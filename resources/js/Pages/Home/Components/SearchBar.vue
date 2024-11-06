<template>
  <div class="container px-5 py-2 mx-auto">
    <div class="flex lg:w-2/3 w-full sm:flex-row  mx-auto px-8 sm:space-x-4 sm:space-y-3 space-y-4 sm:px-0 items-end ">
      <div class="relative flex-grow w-full ">
        <input v-model="search" @keydown="handleKeyDown"
        class="w-full text-sm rounded-lg focus:outline focus:outline-2 focus:outline-offset-2 pl-10
         bg-[#ffffff] text-[#444444]  border-[#cccccc]" 
        placeholder="Search by Title, Author, Isbn, Year..." />
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
          <path fill-rule="evenodd"
            d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
            clip-rule="evenodd" />
        </svg>
        </div>
      </div>
      <Button @click="makeSearch()" type="button" severity="secondary" label="Search" />
    </div>
  </div>
</template>
<script setup>
import Button from 'primevue/button';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  searchTerm: String,
  routeName: String
})

const search = ref(props.searchTerm);

const handleKeyDown = (event) => {
  if (event.key === 'Enter') {
    makeSearch()
  }
}

const makeSearch = () => {
  router.get(props.routeName, { search: search.value }, {
    replace: true,
    preserveState: true
  })
}


</script>