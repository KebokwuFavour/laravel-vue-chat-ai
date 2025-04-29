import axios from 'axios';
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useConversationStore = defineStore(
  'conversation', () => {
    // Define a reactive variable to hold the conversations
    const conversations = ref([]);
    
    // Define a function to fetch conversations from the API
    // This function will be called when the store is initialized
    async function getConversations() {
      try {
        const response = await axios.get("/api/chat/conversations");
        
        // set the conversations array to the response data received from the API
        conversations.value = response.data.conversations;

      } catch (error) {
        console.error("Failed to fetch conversations:", error);
      }
    }

    return {
      conversations,
      getConversations,
    }
  
  },
  {
    persist: true,
  }
);

 