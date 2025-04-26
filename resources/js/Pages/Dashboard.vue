<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Components/Welcome.vue";
import Welcome2 from "@/Components/Welcome2.vue";
import { SidebarProvider, SidebarTrigger } from "@/Components/ui/sidebar";
import AppSidebar from "@/Components/AppSidebar.vue";
</script>

<template>
  <div class="flex">
    <SidebarProvider>
      <AppSidebar />
      <!-- <main>
        <SidebarTrigger /> -->
      <!-- <slot /> -->
      <!-- </main> -->
      <AppLayout title="Dashboard">
        <!-- <template #header>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Welcome to ChatAI
          </h2>
        </template> -->

        <div class="py-6">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <Welcome />
            </div>
          </div>
        </div>
      </AppLayout>
    </SidebarProvider>
  </div>
</template>
