<script setup>
import axios from "axios";
import { ref, nextTick, onMounted } from "vue";
import { useChatStore } from "@/stores/chat";
import { useConversationStore } from "@/stores/conversation";

// initializing the chat store
const chatStore = useChatStore();

// initializing the conversation store
const conversationStore = useConversationStore();

// const messages = ref([{ from: "AI", text: "Hello! Ask me anything." }]);
// const newMessage = ref("");
// const loading = ref(false);
const chatBox = ref(null);

// // track conversations (we can call it tittles)
// const conversation = ref("");

// function to scroll to the bottom of the chat box
const scrollToBottom = () => {
  nextTick(() => {
    chatBox.value.scrollTop = chatBox.value.scrollHeight;
  });
};

// Function to format messages
const formatMessage = (text) => {
  if (!text) return "";

  // Replace formatting syntax
  let formatted = text
    .replace(/\n/g, "<br>") // Convert newlines to <br> for HTML display
    .replace(/\*\*(.*?)\*\*/g, "<b>$1</b>") // Bold
    .replace(/\*(?!\*)(.*?)\*/g, "<i>$1</i>") // Italic (avoid conflict with bold)
    .replace(/`(.*?)`/g, "<code>$1</code>"); // Inline code

  // Convert bullet lists (- item)
  if (formatted.match(/(^|\n)- /)) {
    formatted = formatted.replace(/(?:^|\n)- (.*?)(?=\n|$)/g, "<li>$1</li>");
    formatted = "<ul>" + formatted + "</ul>";
  }

  // Convert numbered lists (1. item)
  if (formatted.match(/(^|\n)\d+\. /)) {
    formatted = formatted.replace(/(?:^|\n)(\d+)\. (.*?)(?=\n|$)/g, "<li>$1. $2</li>");
    formatted = "<ol>" + formatted + "</ol>";
  }

  return formatted;
};

// Function to send the user prompt or message
const sendMessage = async () => {
  if (!chatStore.newMessage.trim()) return;

  const conversationId = chatStore.conversation_id;

  const userText = chatStore.newMessage;
  chatStore.messages.push({ from: "User", text: userText });
  chatStore.newMessage = "";
  chatStore.loading = true;

  // Show "Thinking..." immediately
  chatStore.messages.push({ from: "AI", text: "Thinking..." });

  // Scroll to bottom
  scrollToBottom();

  try {
    // Send the message to api/chat endpoint and get the AI response
    const response = await axios.post("/api/chat", {
      message: userText,
      conversation_id: conversationId,
    });

    // Replace "Thinking..." with actual AI response
    chatStore.messages[chatStore.messages.length - 1].text = response.data.reply;
    chatStore.conversation_id = response.data.conversation_id;

    // get conversations again
    conversationStore.getConversations();

    // Scroll to bottom
    scrollToBottom();
  } catch (error) {
    // messages.value.push({ from: "AI", text: "Something went wrong." });

    // Replace "Thinking..." with error message
    chatStore.messages[chatStore.messages.length - 1].text = "Something went wrong.";
  } finally {
    chatStore.loading = false;
  }
};

// Function to start a new chat
const newChat = () => {
  chatStore.messages = [];
  chatStore.conversation_id = "";
  chatStore.newMessage = "";
  chatStore.loading = false;

  // Show initial message
  chatStore.messages.push({ from: "AI", text: "Hello! Ask me anything." });

  // Scroll to bottom
  scrollToBottom();
};

// // when the component is mounted (browser has fininsh loading), fetch the chat history
// onMounted(async () => {
//   try {
//     const conversationId = conversation.value;

//     const response = await axios.get("/api/chat/messages", {
//       conversation_id: conversationId,
//     });

//     // // log the response to see the structure
//     // console.log(response.data);
//     // console.log(response.data.messages);

//     // loop through the messages and push them to the messages array
//     response.data.messages.forEach((message) => {
//       conversation.value = message.conversation_id;
//       messages.value.push({
//         from: "User",
//         text: message.user_prompt,
//       });
//       messages.value.push({
//         from: "AI",
//         text: message.ai_reply,
//       });
//     });

//     // Scroll to bottom after DOM updates
//     scrollToBottom();
//   } catch (error) {
//     console.error("Error fetching user chat history :", error);
//   }
// });
</script>

<template>
  <div class="p-6 bg-white rounded shadow">
    <div class="flex mb-3 w-100 justify-between items-center">
      <h1 class="text-xl font-bold mb-4 pe-3">AI Chat</h1>
      <button
        @click="newChat"
        type="button"
        class="bg-green-500 text-white px-3 py-2 rounded"
      >
        New Chat
      </button>
    </div>

    <div class="h-80 overflow-y-auto border p-4 mb-4 bg-gray-100 rounded" ref="chatBox">
      <div
        v-for="(msg, index) in chatStore.messages"
        :key="index"
        class="mb-2"
        :class="
          msg.from === 'User'
            ? 'text-end bg-blue-100 text-blue-900'
            : 'text-start bg-gray-200 text-gray-900'
        "
        :style="{
          padding: '10px',
          borderRadius: '8px',
          width: 'fit-content',
          maxWidth: '70%',
          marginLeft: msg.from === 'User' ? 'auto' : '0',
        }"
      >
        <!-- <strong>{{ msg.from }}:</strong> -->
        <span v-html="formatMessage(msg.text)"></span>
      </div>
    </div>

    <form @submit.prevent="sendMessage">
      <textarea
        v-model="chatStore.newMessage"
        type="text"
        class="w-full border p-2 rounded mb-2"
        placeholder="Type your message..."
      ></textarea>
      <!-- <input
        type="hidden"
        v-model="chatStore.conversation_id"
        :value="chatStore.conversation_id"
      /> -->
      <button
        class="bg-blue-600 text-white px-4 py-2 rounded"
        :disabled="chatStore.loading"
      >
        {{ chatStore.loading ? "Sending..." : "Send" }}
      </button>
    </form>
  </div>
</template>

<style scoped>
textarea {
  resize: none;
  height: 100px;
}
</style>
