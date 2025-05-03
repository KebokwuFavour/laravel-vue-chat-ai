<script setup>
import { Head, Link } from "@inertiajs/vue3";

defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
});

const currentYear = new Date().getFullYear(); // Get the current year
</script>

<template>
  <Head title="Welcome Page" />
  <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
    <!-- Header Section -->
    <header class="flex items-center justify-between px-6 py-4 bg-white shadow-md">
      <h1 class="text-2xl font-bold text-indigo-600">ChatAI</h1>
      <div v-if="canLogin" class="space-x-4">
        <Link
          v-if="$page.props.auth.user"
          :href="route('dashboard')"
          class="px-4 py-2 text-indigo-600 border border-indigo-600 rounded hover:bg-indigo-600 hover:text-white transition"
        >
          Dashboard
        </Link>

        <template v-else>
          <Link
            :href="route('login')"
            class="px-4 py-2 text-indigo-600 border border-indigo-600 rounded hover:bg-indigo-600 hover:text-white transition"
          >
            Login
          </Link>
          <Link
            v-if="canRegister"
            :href="route('register')"
            class="px-4 py-2 text-white bg-indigo-600 rounded hover:bg-indigo-700 transition"
          >
            Sign Up
          </Link>
        </template>
      </div>
    </header>

    <!-- Hero Section -->
    <section class="text-center py-20 px-4 bg-gradient-to-b from-indigo-50 to-white">
      <div class="max-w-3xl mx-auto">
        <h2 class="text-4xl sm:text-5xl font-extrabold text-gray-900 mb-6">
          Converse Smarter, Instantly.
        </h2>
        <p class="text-lg sm:text-xl text-gray-600 mb-8">
          ChatAI is your intelligent assistant that helps you write, plan, learn, and
          explore ideas like never before.
        </p>
        <Link
          :href="route('register')"
          class="inline-block px-8 py-3 text-white text-lg bg-indigo-600 rounded-lg hover:bg-indigo-700 transition"
        >
          Get Started Free
        </Link>
      </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
      <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-3 gap-10 text-center">
        <div class="bg-gray-100 p-6 rounded-lg shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold mb-2 text-indigo-600">
            Natural Conversations
          </h3>
          <p class="text-gray-600">
            ChatAI understands context and provides intelligent, human-like responses in
            real time.
          </p>
        </div>
        <div class="bg-gray-100 p-6 rounded-lg shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold mb-2 text-indigo-600">Multilingual Support</h3>
          <p class="text-gray-600">
            Talk in your language—ChatAI supports multiple languages out of the box.
          </p>
        </div>
        <div class="bg-gray-100 p-6 rounded-lg shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold mb-2 text-indigo-600">Secure & Private</h3>
          <p class="text-gray-600">
            Your conversations are safe with us. We value your privacy and security.
          </p>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-6 text-sm text-gray-500 bg-gray-50">
      &copy; {{ currentYear }} ChatAI. All rights reserved.
    </footer>
  </div>
</template>
