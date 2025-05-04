<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Components/Welcome.vue";
import { SidebarProvider, SidebarTrigger } from "@/Components/ui/sidebar";
// import { SidebarProvider } from "@/Components/ui/sidebar";
import AppSidebar from "@/Components/AppSidebar.vue";
</script>

<template>
  <div class="flex">
    <SidebarProvider>
      <AppSidebar />

      <AppLayout title="Dashboard">
        <!-- trigger/toggler for the sidebar -->
        <main class="py-1">
          <SidebarTrigger />
        </main>

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
