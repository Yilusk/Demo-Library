<script setup>
import Header from './Layout/Header.vue';
import SearchBar from './Components/SearchBar.vue';
import PaginationLinks from '@/Components/PaginationLinks.vue';
import { Head, Link } from '@inertiajs/vue3';
import Card from 'primevue/card';
import Image from 'primevue/image';

const props = defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  searchTerm: String,
  routeName: String,
  books: Object
})

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-EN', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });
}


</script>

<template>
  <Head title="Searching" />
  <Header :canLogin="canLogin" :canRegister="canRegister"/>
  <SearchBar :routeName="route('home.search')" :searchTerm="searchTerm"/>
  <div class="container py-4 mx-auto grid grid-cols-1 gap-4">
    <Card v-if="books.data.length === 0">
      <template #content>
        <p class="text-xl font-serif text-gray-700">No books found.</p>
      </template>
    </Card>
  <Card v-for="book in books.data" :key="book.id">
    <template #content>
      <div class="flex gap-4 p-4">
        <div class="flex items-center">
          <Image 
            :src="`../../storage/${ book.image }`" 
            alt="Book Cover" 
            width="100" 
            height="150" 
            object-fit="cover" 
            v-if="book.image"
          />
          <Image 
            :src="`../../storage/images/default_book_cover.jpg`" 
            alt="Default Image" 
            width="100" 
            height="150" 
            object-fit="cover" 
            v-if="!book.image"
          />
        </div>
        <div class="flex-1">
          <p class="text-xl font-serif text-gray-700 truncate w-52 md:w-96 sm:w-80 lg:w-96 xl:w-full">
            {{ book.title }}
          </p>
          <p class="text-gray-500 pb-3">
            {{ book.publisher }}
          </p>
          <div class="flex gap-2 italic text-blue-400 pb-10">
            <p v-for="author,index in book.authors" :key="author.id">
               {{ author.name }}
              <b v-if=" index < book.authors.length - 1">
                ,
              </b>
            </p>
            <p v-if="book.authors.length == 0">
              No Author
            </p>
          </div>
          <div class="text-gray-600 flex justify-end gap-2">
            <p>
              From: <span class="text-gray-800">{{ formatDate(book.release_date) }}</span>
            </p>
            <p>
              Language: <span class="text-gray-800">{{ book.language ?? 'N/A' }}</span>
            </p>
            <p>
              Volumen: <span class="text-gray-800">{{ book.volumen ?? 'N/A' }}</span>
            </p>
          </div>
        </div>
      </div>
    </template>
    <template #footer>
      
      <div class="flex justify-end">
          <Link :href="route('home.show', book.id)">See More &rArr;</Link>
        </div>
      </template>
  </Card>
</div>
  <div class="flex justify-center pb-8 pt-5">
    <PaginationLinks :links="books.links" :paginator="books" :moreText="false"/>
  </div>



</template>