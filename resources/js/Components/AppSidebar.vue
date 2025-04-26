<script setup lang="ts">
import { Calendar, Home, Inbox, Search, Settings } from "lucide-vue-next";
import {
  Sidebar,
  SidebarContent,
  SidebarGroup,
  SidebarGroupContent,
  SidebarGroupLabel,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from "@/Components/ui/sidebar";
import NavLink from "@/Components/NavLink.vue";
import { onMounted, ref } from "vue";
import { useChatStore } from "@/stores/chat";
import { useConversationStore } from "@/stores/conversation";

// initializing the conversation store
const conversationStore = useConversationStore();

// initializing the chat store
const chatStore = useChatStore();

// Menu items.
const items = ref([]);

// Function to set the active conversation
const activeConversation = (convId) => {
  // set the conversation id to the chat store
  chatStore.conversation_id = convId;

  chatStore.getConversationChats();
};

// when the component is mounted (browser has fininsh loading), get available conversation
onMounted(() => {
  // Fetch the conversations when the component is mounted
  conversationStore.getConversations();

  // loop through the conversations and push them to the items array
  conversationStore.conversations.forEach((conversation) => {
    items.value.push({
      title: conversation.title,
      url: "/chat/" + conversation.id,
      id: conversation.id,
      // icon: Home,
    });
  });
});
</script>

<template>
  <Sidebar>
    <SidebarContent>
      <SidebarGroup class="px-6">
        <!-- <SidebarGroupLabel class="fs-1">Application</SidebarGroupLabel> -->
        <h1 class="mx-auto pt-3 h1" style="font-weight: bolder">Conversations</h1>
        <SidebarGroupContent>
          <SidebarMenu>
            <SidebarMenuItem v-for="(item, index) in items" :key="index">
              <SidebarMenuButton asChild>
                <NavLink href="/dashboard" @click="activeConversation(item.id)">
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
