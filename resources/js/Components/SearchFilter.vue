<template>
  <div class="flex justify-start mb-4 rounded-lg">
    <div class="inline-block relative">
      <input v-model="search"
        class="px-9 py-2.5 text-sm  rounded-lg  focus:outline focus:outline-2 focus:outline-offset-2 bg-[#ffffff] text-[#444444] focus:outline-[#aaaaaa] border-[#cccccc]"
        placeholder="Search...">
      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
          <path fill-rule="evenodd"
            d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
            clip-rule="evenodd" />
        </svg>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { debounce } from 'lodash';
import { router } from '@inertiajs/vue3';

const props = defineProps({
	searchTerm: String,
  routeName: String
})


const search = ref(props.searchTerm);

watch(
	search,
	debounce((q) => router.get(route(props.routeName), { search: q }, { preserveState: true, preserveScroll: true }), 500)
)


</script>