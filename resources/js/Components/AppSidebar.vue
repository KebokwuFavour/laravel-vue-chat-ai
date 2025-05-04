<script setup lang="ts">
import {
  Sidebar,
  SidebarContent,
  SidebarGroup,
  SidebarGroupContent,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from "@/Components/ui/sidebar";
import NavLink from "@/Components/NavLink.vue";
import { computed, onMounted } from "vue";
import { useChatStore } from "@/stores/chat";
import { useConversationStore } from "@/stores/conversation";

// initializing the conversation store
const conversationStore = useConversationStore();

// initializing the chat store
const chatStore = useChatStore();

// Menu items.
// Items are generated dynamically from the conversation store.
// It is computed to reactively update when the conversations change.
const items = computed(() =>
  conversationStore.conversations.map((conversation) => ({
    title: conversation.title,
    url: "/chat/" + conversation.id,
    id: conversation.id,
  }))
);

// Function to set the active conversation
const activeConversation = (convId) => {
  // set the conversation id to the chat store
  chatStore.conversation_id = convId;

  // Fetch the current conversation chats
  chatStore.getConversationChats();
};

const handleRightClick = (e) => {
  alert("Custom context menu action triggered!");
};

let holdTimer = null;

const startHold = () => {
  holdTimer = setTimeout(() => {
    // Do something on hold (after 800ms)
    console.log("Held for long enough!");
    alert("Held for long enough!");
  }, 800); // hold duration in ms
};

const cancelHold = () => {
  clearTimeout(holdTimer);
};

// when the component is mounted (browser has fininsh loading), get available conversation
onMounted(() => {
  // emppty conversations array in the conversation store
  conversationStore.conversations = [];

  // Fetch the conversations when the component is mounted
  conversationStore.getConversations();
});
</script>

<template>
  <Sidebar>
    <SidebarContent>
      <SidebarGroup>
        <!-- <SidebarGroupLabel class="fs-1">Application</SidebarGroupLabel> -->
        <h1 class="py-4 px-0 text-center text-xl" style="font-weight: bolder">
          Conversations
        </h1>
        <SidebarGroupContent>
          <SidebarMenu class="px-2">
            <SidebarMenuItem v-for="(item, index) in items" :key="index">
              <SidebarMenuButton asChild>
                <NavLink
                  href="#"
                  :class="
                    chatStore.conversation_id == item.id
                      ? 'text-gray-950 bg-gray-300 fw-bolder'
                      : ''
                  "
                  @click.prevent="activeConversation(item.id)"
                  @contextmenu.prevent="handleRightClick"
                  @mousedown.prevent="startHold"
                  @mouseup.prevent="cancelHold"
                  @mouseleave="cancelHold"
                  @touchstart="startHold"
                  @touchend="cancelHold"
                >
                  <!-- <component :is="item.icon" /> -->
                  <span>{{ item.title }}</span>
                </NavLink>
              </SidebarMenuButton>
            </SidebarMenuItem>
          </SidebarMenu>
        </SidebarGroupContent>
      </SidebarGroup>
    </SidebarContent>
  </Sidebar>
</template>
