<script setup>
import { ref } from "vue";

const newMessage = ref("");
const sidebarOpen = ref(false);

function handleSend() {
  if (!newMessage.value.trim()) return;
  // Handle message send logic here
  console.log("Sent:", newMessage.value);
  newMessage.value = "";
}
</script>

<template>
  <div class="flex h-screen overflow-hidden bg-[#343541] text-white">
    <!-- Sidebar Toggle Button for Mobile -->
    <button
      @click="sidebarOpen = !sidebarOpen"
      class="md:hidden p-4 text-black absolute top-0 left-0 z-50"
    >
      ☰
    </button>

    <!-- Sidebar -->
    <transition name="fade">
      <aside
        :class="[
          'bg-[#202123] p-4 flex flex-col space-y-4 z-40',
          sidebarOpen
            ? 'fixed inset-0 md:relative md:inset-auto md:flex md:w-64'
            : 'hidden md:flex md:relative md:w-64',
        ]"
      >
        <div class="text-white text-xl font-semibold mb-4">ChatGPT</div>
        <nav class="flex-1 space-y-2 overflow-auto text-sm">
          <a href="#" class="block py-2 px-3 rounded hover:bg-gray-700">New Chat</a>
          <a href="#" class="block py-2 px-3 rounded hover:bg-gray-700"
            >OpenAI Laravel Integration</a
          >
          <a href="#" class="block py-2 px-3 rounded hover:bg-gray-700"
            >Crowdsourced Disaster Report</a
          >
        </nav>
        <div class="text-xs text-gray-400 mt-auto">Upgrade plan</div>
        <button
          class="md:hidden mt-4 p-2 bg-gray-700 rounded"
          @click="sidebarOpen = false"
        >
          Close
        </button>
      </aside>
    </transition>
    <!-- <Sidebar>
      <div class="text-white text-xl font-semibold mb-4">ChatGPT</div>
      <nav class="flex-1 space-y-2 overflow-auto text-sm">
        <a href="#" class="block py-2 px-3 rounded hover:bg-gray-700">New Chat</a>
        <a href="#" class="block py-2 px-3 rounded hover:bg-gray-700"
          >OpenAI Laravel Integration</a
        >
        <a href="#" class="block py-2 px-3 rounded hover:bg-gray-700"
          >Crowdsourced Disaster Report</a
        >
      </nav>
      <div class="text-xs text-gray-400 mt-auto">Upgrade plan</div>
      <button class="md:hidden mt-4 p-2 bg-gray-700 rounded" @click="sidebarOpen = false">
        Close
      </button>
    </Sidebar> -->

    <!-- Main Chat Area -->
    <main class="flex flex-col flex-1 overflow-hidden">
      <!-- Chat Messages Area -->
      <div class="flex-1 overflow-y-auto p-6 space-y-6 bg-[#343541]">
        <!-- Example System Message -->
        <div class="flex items-start space-x-3">
          <div
            class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center text-white"
          >
            A
          </div>
          <div class="bg-[#444654] p-4 rounded-md text-sm max-w-2xl">
            Awesome — let’s set up conversation threads or titles in your Laravel + Vue.js
            AI chat app.
          </div>
        </div>

        <!-- Example User Message -->
        <div class="flex items-start space-x-3 justify-end">
          <div class="bg-[#10a37f] p-4 rounded-md text-sm max-w-2xl text-white">
            Let us start with the number one.
          </div>
          <div
            class="w-10 h-10 rounded-full bg-white text-black flex items-center justify-center"
          >
            U
          </div>
        </div>
      </div>

      <!-- Chat Input -->
      <div class="bg-[#40414f] p-4 border-t border-gray-700">
        <form
          @submit.prevent="handleSend"
          class="flex items-center gap-3 max-w-4xl mx-auto"
        >
          <input
            v-model="newMessage"
            type="text"
            placeholder="Send a message..."
            class="flex-1 px-4 py-2 bg-[#343541] text-white rounded-md border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500"
          />
          <button
            type="submit"
            class="p-2 rounded-md bg-green-500 hover:bg-green-600 text-white"
          >
            Send
          </button>
        </form>
      </div>
    </main>
  </div>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

body {
  margin: 0;
  font-family: "Inter", sans-serif;
}
</style>
