<script setup>
import Form from './Form.vue';

const props = defineProps({
  book: Object,
	authors: Object,
  authorsOfBook: Object,
  categories: Object,
  categoriesOfBook: Object
})

</script>

<template>
	<Form :book="book"
        :authors="authors"
        :authorsOfBook="authorsOfBook"
        :categories="categories"
        :categoriesOfBook="categoriesOfBook"/>
</template>