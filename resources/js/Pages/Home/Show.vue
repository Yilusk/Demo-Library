<script setup>
import Header from './Layout/Header.vue';
import { Head } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import Button from 'primevue/button';
import Image from 'primevue/image';
import Card from 'primevue/card';
import Tag from 'primevue/tag';

const props = defineProps({
  book: Object,
  canLogin: Boolean,
  canRegister: Boolean,
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

  <Head title="Showing Book" />
  <Header :canLogin="canLogin" :canRegister="canRegister" />
  <Card>
    <template #title>
      <div class="flex justify-between">
        Showing: {{ book.title }}
        <!-- back Button -->
        <NavLink :href="route('home')">
          <Button type="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
            </svg>
            Back
          </Button>
        </NavLink>
      </div>
    </template>
    <template #content>
      <div class="grid grid-cols-[25%,75%] max-sm:grid-cols-1 max-md:grid-cols-1 gap-4">
        <div>
          <!-- set book image -->
          <Card class="items-center">
            <template #content>
              <div class="flex items-center">
                <Image :src="`../../storage/${book.image}`" alt="Book Cover" width="250" height="150" object-fit="cover"
                  v-if="book.image" />
                <Image :src="`../../storage/images/default_book_cover.jpg`" alt="Default Image" width="200" height="150"
                  object-fit="cover" v-if="!book.image" />
              </div>

            </template>
          </Card>
        </div>
        <div>
          <!-- set book content -->
          <Card>
            <template #title>
              <strong>
                {{ book.title }}
              </strong>
            </template>
            <template #content>
              <div class="space-y-2">
                <p>
                  <strong>ISBN: </strong>
                  {{ book.isbn }}
                </p>
                <p>
                  <strong>Publisher: </strong>
                  {{ book.publisher }}
                </p>
                <p>
                  <strong>Description: </strong>
                  {{ book.description }}
                </p>
                <p>
                  <strong>Release Date: </strong>
                  {{ formatDate(book.release_date) }}
                </p>
                <p>
                  <strong>Volumen: </strong>
                  {{ book.volumen ?? '01' }}
                </p>
                <p>
                  <strong>Pages: </strong>
                  {{ book.pages }}
                </p>
                <p>
                  <strong>Language: </strong>
                  {{ book.language ?? 'N/A' }}
                </p>
                <div class="">
                  <strong>Categories: </strong>
                  <span v-for="(category) in book.categories" :key="category.id" class="mr-1">
                    <Tag severity="primary" rounded>
                      {{ category.category }}
                    </Tag>
                  </span>
                  <Tag v-if="book.categories.length === 0" severity="info" rounded>
                    No Category
                  </Tag>
                </div>

                <div class="flex gap-1">
                  <strong>Authors: </strong>
                  <p v-for="author, index in book.authors" :key="author.id">
                    {{ author.name }}
                    <b v-if="index < book.authors.length - 1">
                      ,
                    </b>
                  </p>
                  <p v-if="book.authors.length == 0">
                    No Author
                  </p>
                </div>
              </div>
            </template>
          </Card>
        </div>
      </div>
    </template>
  </Card>
</template>