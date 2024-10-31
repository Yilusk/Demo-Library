<script setup>
import Form from './Form.vue';

const props = defineProps({
	authors: Object,
	categories: Object
})

</script>

<template>
	<Form :authors="authors"
				:categories="categories"/>
</template>