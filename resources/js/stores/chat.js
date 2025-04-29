import axios from 'axios';
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useChatStore = defineStore(
  'chat', () => {
    // Define a reactive variable to hold the chats
    const messages = ref([{ from: "AI", text: "Hello! Ask me anything." }]);
    const newMessage = ref("");
    const loading = ref(false);
    const chatBox = ref(null);
   
    // track conversations (we can call it tittles)
    const conversation_id = ref("");


    // Define a function to fetch conversations from the API
    // This function will be called when the store is initialized
    async function getConversationChats() {
      try {

        // save the current assigned conversation in a variable
        const cId = conversation_id.value;

        const response = await axios.get("/api/chat/messages", {
          params: { conversation_id: cId },
        });

        // clear the messages array and set the conversation_id to an empty string
       messages.value = [];
       conversation_id.value = "";
       newMessage.value = "";
       loading.value = false;

        // Show initial message
       messages.value.push({ from: "AI", text: "Hello! Ask me anything." });

        // loop through the messages and push them to the messages array
        response.data.messages.forEach((message) => {
          conversation_id.value = message.conversation_id;
          messages.value.push({
            from: "User",
            text: message.user_prompt,
          });
          messages.value.push({
            from: "AI",
            text: message.ai_reply,
          });
        });

      } catch (error) {
        console.error("Error fetching user chat history :", error);
      }
    }

    return {
      messages,
      newMessage,
      loading,
      chatBox,
      conversation_id,
      getConversationChats,
    }
  
  },
  {
    persist: true,
  }
);

 