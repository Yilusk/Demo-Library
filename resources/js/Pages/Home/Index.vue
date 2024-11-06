<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Header from './Layout/Header.vue';
import PaginationLinks from '@/Components/PaginationLinks.vue';
import SearchBar from './Components/SearchBar.vue';
import Footer from './Layout/Footer.vue';
import Card from 'primevue/card';
import Image from 'primevue/image';


defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  searchTerm: String,
  routeName: String,
  books: Object

});
</script>
<template>
  <Head title="Home" />
  <Header :canLogin="canLogin" :canRegister="canRegister" />
  <section class="text-gray-600 body-font ">
    <div class="container mx-auto flex px-5 items-center justify-center flex-col">
      <img class="lg:w-2/6 md:w-3/6 w-5/6 mb-10 object-cover object-center rounded" alt="Mary Potter from Unsplash"
        src="../../../../public/images/book-search.jpg">
      <div class="text-center lg:w-2/3 w-full">
        <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">Demo Library</h1>
        <p class="leading-relaxed">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
          magna aliqua.
        </p>
      </div>
    </div>
  </section>
  <div class="pb-9">
    <SearchBar :routeName="route('home.search')" />
  </div>

  <div class="flex flex-wrap justify-center gap-5" >
    <div v-if="books.data.length == 0">
      <Card>
        <template #content>
          <p class="text-xl font-serif text-gray-700">No books found.</p>
        </template>
      </Card>
    </div>

    <Card style="width: 15rem; " v-for="book in books.data" :key="book.id">
      <template #header>
        <div class="h-96 overflow-hidden">
          <Image :src="`../../storage/${ book.image }`" width="700" preview  v-if="book.image"/>
          <Image :src="`../../storage/images/default_book_cover.jpg`" v-if="!book.image"/>
        </div>
      </template>
      <template #title>
        <p class="text-xl font-serif text-gray-700 h-8 truncate">
          {{ book.title }}
        </p>
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


<Footer/>
</template>