<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
	<Head title="Authors" />
	
	<AuthenticatedLayout>
		<template #header>
			Authors List
		</template>
		
		<div class="p-4 bg-white rounded-lg shadow-xs">
			You're logged in!
		</div>
	</AuthenticatedLayout>
</template>