<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
	<Head title="Books" />
	
	<AuthenticatedLayout>
		<template #header>
			Books List
		</template>
		
		<div class="p-4 bg-white rounded-lg shadow-xs">
			You're logged in!
		</div>
	</AuthenticatedLayout>
</template>