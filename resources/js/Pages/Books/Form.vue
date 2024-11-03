<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';
import MultiSelect from 'primevue/multiselect';
import NavLink from '@/Components/NavLink.vue';
import FileUpload from 'primevue/fileupload';
import { useToast } from 'primevue/usetoast';
import DatePicker from 'primevue/datepicker';
import InputText from 'primevue/inputtext';
import IftaLabel from 'primevue/iftalabel';
import Button from 'primevue/button';
import Toast from 'primevue/toast';
import Card from 'primevue/card';
import { ref } from 'vue';

const props = defineProps({
  book: Object,
  authors: Object,
  categories: Object,
  authorsOfBook: Object,
  categoriesOfBook: Object

})

const form = useForm({
  id: '',
  isbn: '',
  title: '',
  description: '',
  publisher: '',
  release_date: '',
  pages: '',
  image: '',
  authors: [],
  categories: [],
})

const authorOptions = ref([])
const categoryOptions = ref([])

props.categories.map((row) => {
  categoryOptions.value.push({
    id: row.id,
    category: `${row.category}`
  })
})

props.authors.map((row) => {
  authorOptions.value.push({
    id: row.id,
    author: `${row.name}`
  })
})

// load if edit
if (props.book != null) {
  form.id = props.book.id
  form.isbn = props.book.isbn
  form.title = props.book.title
  form.description = props.book.description
  form.publisher = props.book.publisher
  form.release_date = props.book.release_date
  form.pages = props.book.pages
  props.authorsOfBook.forEach(author => form.authors.push(author.id))
  props.categoriesOfBook.forEach(category => form.categories.push(category.id))
}

const toast = useToast()
const previousImage = ref(props.book == null ? null : props.book.image)
const titleForm = ref(props.book == null ? 'Create Book' : 'Edit Book')

const src = ref(null);

function onFileSelect(event) {
  const file = event.files[0];
  const reader = new FileReader();

  reader.onload = async (e) => {
    src.value = e.target.result;
    form.image = file;
  };

  reader.readAsDataURL(file);
}

const save = () => {
  if (props.book == null) {
    form.post(route('books.store'), {
      onSuccess: () => {
        toast.add({
          severity: 'success',
          summary: 'Book Created',
          detail: `Book ${form.title} created`,
          life: 3000
        })
        form.reset()
        src.value = null
      }
    })
  } else {
    form.post(route('books.update', form.id), {
      onSuccess: () => {
        toast.add({
          severity: 'success',
          summary: 'Book Updated',
          detail: `Book ${form.title} updated`,
          life: 3000
        })
        src.value = null
        previousImage.value = props.book.image
        
      }
    })
  }
}

</script>
<template>

  <Head :title="titleForm" />
  <AuthenticatedLayout>
    <Toast />
    <template #header>
      <!-- Form -->
      <Card>
        <template #title>
          <div class="flex justify-between">
            {{ titleForm }}
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
          <form @submit.prevent="save">
            <div
              class="grid grid-cols-2 gap-4 max-md:grid-cols-1 max-lg:grid-cols-1 max-xl:grid-cols-2 max-2xl:grid-cols-2">
              <IftaLabel>
                <InputText id="isbn" type="text" v-model="form.isbn" class="w-80 max-md:w-full max-lg:w-full"
                  :invalid="form.errors.isbn" />
                <label for="isbn">Isbn</label>
                <InputError :message="form.errors.isbn" />
              </IftaLabel>
              <IftaLabel>
                <InputText id="title" type="text" v-model="form.title" class="w-80 max-md:w-full max-lg:w-full"
                  :invalid="form.errors.title" />
                <label for="title">Title</label>
                <InputError :message="form.errors.title" />
              </IftaLabel>
              <IftaLabel>
                <InputText id="description" type="text" v-model="form.description"
                  class="w-80 max-md:w-full max-lg:w-full" :invalid="form.errors.description" />
                <label for="description">description</label>
                <InputError :message="form.errors.description" />
              </IftaLabel>
              <IftaLabel>
                <DatePicker v-model="form.release_date" dateFormat="yy-mm-dd" inputId="release_date"
                  class="w-80 max-md:w-full max-lg:w-full" :invalid="form.errors.release_date" />
                <label for="release_date">release_date</label>
                <InputError :message="form.errors.release_date" />
              </IftaLabel>
              <IftaLabel>
                <InputText id="pages" type="text" v-model="form.pages" class="w-80 max-md:w-full max-lg:w-full"
                  :invalid="form.errors.pages" />
                <label for="pages">Pages</label>
                <InputError :message="form.errors.pages" />
              </IftaLabel>
              <IftaLabel>
                <InputText id="publisher" type="text" v-model="form.publisher" class="w-80 max-md:w-full max-lg:w-full"
                  :invalid="form.errors.publisher" />
                <label for="publisher">Publisher</label>
                <InputError :message="form.errors.publisher" />
              </IftaLabel>
              <IftaLabel>
                <MultiSelect v-model="form.categories" :options="categoryOptions" option-value="id"
                  option-label="category" id="id" placeholder="Select Category" :maxSelectedLabels="3" filter
                  class="w-80 max-md:w-full max-lg:w-full text-lg" />
                <label for="categories">Categories</label>
              </IftaLabel>
              <IftaLabel>
                <MultiSelect v-model="form.authors" :options="authorOptions" option-value="id" option-label="author"
                  id="id" placeholder="Select Authors" :maxSelectedLabels="3" filter
                  class="w-80 max-md:w-full max-lg:w-full text-lg" />
                <label for="authors">Authors</label>
              </IftaLabel>
              <IftaLabel class="border border-gray-300 rounded">
                <label for="cover">Book Cover</label>
                <div
                  class="grid grid-cols-2 gap-4 max-md:grid-cols-1 max-lg:grid-cols-1 max-xl:grid-cols-2 max-2xl:grid-cols-2  mt-6 mb-6 ">
                  <div v-if="previousImage" class="flex flex-col items-center">
                    <p class="font-bold text-lg text-gray-500">Actual Cover</p>
                    <img :src="`../../storage/${previousImage}`" class="shadow-md rounded-xl h-48 w-auto ml-3"
                      alt="Actual Book Cover" style="filter: grayscale(100%)">
                  </div>
                  <div v-if="src" class="flex flex-col items-center">
                    <p class="font-bold text-lg text-gray-500">New Cover</p>
                    <img v-if="src" :src="src" alt="New Book Cover" class="shadow-md rounded-xl h-48 w-auto mr-3" />
                  </div>
                </div>
                <FileUpload mode="basic" @select="onFileSelect" customUpload auto severity="secondary"
                  class="p-button-outlined mb-3" />
                <InputError>{{ form.errors.image }}</InputError>
              </IftaLabel>
            </div>
            <div class="flex justify-end">
              <Button label="Save" type="submit" severity="success"
                class="w-56 max-md:w-full max-sm:w-full max-lg:w-full max-xl:w-full mt-5" />
            </div>
          </form>
        </template>
      </Card>
    </template>
    {{ form }}
  </AuthenticatedLayout>
</template>