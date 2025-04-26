<?php

use App\Models\ChatMessage;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use OpenAI\Laravel\Facades\OpenAI;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route to get the chat conversations for the authenticated user
Route::get('/chat/conversations', function (Request $request) {

    // get the authenticated user id
    $userId = Auth::id();

    // get the chat conversations for the authenticated user
    $conversations = Conversation::where('user_id', $userId)->get();

    // return the chat conversations to the frontend in json format
    return response()->json([
        'conversations' => $conversations,
    ]);

})->middleware('auth:sanctum');


// Route to chat with AI
Route::post('/chat', function (Request $request) {

    // Get the latest prompt of the user from the request
    $userInput = $request->input('message');

    // get the chat messages for the user making this request
    $chatMessages = ChatMessage::where('user_id', $request->user()->id)->take(10)->get();

    // Format the chat messages for the current conversation for the OpenAI-compatible API
    $conversation = [];

    // loop through the chat messages and add them to the conversation
    foreach ($chatMessages as $chat) {
        $conversation[] = ['role' => 'user', 'content' => $chat->user_prompt];
        $conversation[] = ['role' => 'assistant', 'content' => $chat->ai_reply];
    }

    // Add the latest user message to the conversation
    $conversation[] = ['role' => 'user', 'content' => $userInput];


    // // Connect to your AI API here (like OpenAI, or a free alternative)
    // $response = OpenAI::chat()->create([
    //     // 'model' => 'gpt-4o-mini',
    //     'messages' => $conversation,
    // ]);


    // the alternative I am using for now is DeepInfra
    // make a request to the AI API with the current conversation for context understanding
    $response = Http::withToken(env('DEEPINFRA_API_KEY'))->post('https://api.deepinfra.com/v1/openai/chat/completions', [
        'model' => 'meta-llama/Meta-Llama-3-8B-Instruct',
        'messages' => $conversation,
    ]);

    // store the response from the AI in a variable
    $aiReply = $response['choices'][0]['message']['content'];

    // get the user id from the request
    $userId = $request->user()->id;

    // check if the user has a conversation id in the request
    // if the user has a conversation id, we will use it to save the chat message
    // if the user does not have a conversation id, we will create a new conversation
    // if ($request->missing('conversation_id')) {
    if ($request->input('conversation_id') == "") {
        // 3. Ask AI to generate a title
        $titleResponse = Http::withToken(env('DEEPINFRA_API_KEY'))->post('https://api.deepinfra.com/v1/openai/chat/completions', [
            'model' => 'meta-llama/Meta-Llama-3-8B-Instruct',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a title generator: provide a concise headline, not more than 30 characters, for the conversation.'],
                ['role' => 'user', 'content' => $userInput],
                // ['role' => 'assistant', 'content' => $aiReply],
            ],
        ]);

        if ($titleResponse->ok()) {
            // $generatedTitle = json_decode($titleResponse->body(), true)['choices'][0]['message']['content'];

            // $generatedTitle = trim(
            //     $titleResponse->json()['choices'][0]['message']['content']
            // );

            $generatedTitle = trim($titleResponse['choices'][0]['message']['content']);

        } else {

            // Handle error
            dump($titleResponse->body());

        }

        // 3. Create the Conversation record
        $conversationModel = Conversation::create([
            'user_id' => $userId,
            'title' => Str::limit($generatedTitle, 100),
        ]);

        $conversationId = $conversationModel->id;
    } else {
        $conversationId = $request->input('conversation_id');
    }


    // Save the new message and reply to DB with the user id
    ChatMessage::create([
        'user_id' => $userId,
        'conversation_id' => $conversationId,
        'user_prompt' => $userInput,
        'ai_reply' => $aiReply,
    ]);

    // return the response from the AI API to the frontend in json format
    return response()->json([
        'reply' => $aiReply,
        'conversation_id' => $conversationId,
    ]);

})->middleware('auth:sanctum');


// Route to get the chat messages for the authenticated user
Route::get('/chat/messages', function (Request $request) {

    // get the authenticated user id
    $userId = Auth::id();

    // get the user id from the request
    $conversationId = $request->input('conversation_id');


    // get the chat messages for the authenticated user
    $chatMessages = ChatMessage::where('user_id', $userId)->where('conversation_id', $conversationId)->get();

    // return the chat messages to the frontend in json format
    return response()->json([
        'messages' => $chatMessages,
    ]);

})->middleware('auth:sanctum');