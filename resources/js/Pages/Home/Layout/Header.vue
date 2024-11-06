<script setup>
import { Link } from '@inertiajs/vue3';
import Button from 'primevue/button';

defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },

});
</script>

<template>
    <header class="text-gray-600 body-font">
    <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
      <Link :href="route('home')" class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round"
          stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full"
          viewBox="0 0 24 24">
          <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
        </svg>
        <span class="ml-3 text-xl">Demo Library</span>
      </Link>
      <nav v-if="canLogin" class="md:ml-auto flex flex-wrap items-center text-base justify-center">
        <Link v-if="$page.props.auth.user" :href="route('dashboard')"
          class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] ">
        Dashboard
        </Link>

        <template v-else>
          <Link :href="route('login')"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] ">
          Log in
          </Link>

          <Button class="rounded-full" variant="link">
            <Link v-if="canRegister" :href="route('register')"
              class="">
            Register
            </Link>

          </Button>

        </template>
      </nav>
    </div>
  </header>
</template>
