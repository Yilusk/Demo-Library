<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NavLink from '@/Components/NavLink.vue';
import Button from 'primevue/button';
import Image from 'primevue/image';
import Card from 'primevue/card';
import Tag from 'primevue/tag';

const props = defineProps({
  book: Object,
  authors: Object,
  categories: Object

})
</script>

<template>
  <Head title="Show Book" />
  <AuthenticatedLayout>
    <Card>
      <template #title>
        <div class="flex justify-between">
          Showing
          <!-- back Button -->
          <NavLink :href="route('books.index')">
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
                <Image :src="`../../storage/${book.image}`" width="300" preview v-if="book.image" />
                <Image src="../../storage/images/default_book_cover.jpg" width="300" v-else />

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
                    {{ book.release_date }}
                  </p>
                  <p>
                    <strong>Pages: </strong>
                    {{ book.pages }}
                  </p>
                  <p>
                    <strong>Categories: </strong>
                    <span v-for="(category, index) in book.categories" :key="category.id">
                      <Tag severity="primary" rounded>
                        {{ category.category }}
                      </Tag>
                      <b v-if="index < book.categories.length - 1">
                        &nbsp;
                      </b>
                    </span>
                    <Tag v-if="book.categories.length === 0" severity="info" rounded>
                      No Category
                    </Tag>
                  </p>
                  <p>
                    <strong>Authors: </strong>
                    <span v-for="(author, index) in book.authors" :key="author.id">
                      <Tag severity="primary" rounded>
                        {{ author.name }}
                      </Tag>
                      <b v-if="index < book.authors.length - 1">
                        &nbsp;
                      </b>
                    </span>
                    <Tag v-if="book.authors.length === 0" severity="info" rounded>
                      No Author
                    </Tag>
                  </p>
                </div>
              </template>
            </Card>
          </div>
        </div>
      </template>
    </Card>
  </AuthenticatedLayout>
</template>
