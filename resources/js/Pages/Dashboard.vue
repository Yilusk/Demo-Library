<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Card from 'primevue/card';
import Chart from 'primevue/chart';
import Divider from 'primevue/divider';
import { ref } from 'vue';

const props = defineProps({
	// count
	books: Number,
	authors: Number,
	categories: Number,
	author_books_count: Object
})

const chartOptions = ref([])
const charData = ref([])
const authorName = ref([])
const booksCount = ref([])
const colors = ref([])

const random = () => {
	return Math.round(Math.random() * 255)
}

props.author_books_count.map(row => {
	authorName.value.push(row.name)
	booksCount.value.push(row.books_count)
	colors.value.push('rgb(' + random() + ',' + random() + ',' + random() + ')')
})


chartOptions.value = { responsive: true }

charData.value = {
	labels: authorName.value,
	datasets: [{
		label: 'Number of books',
		backgroundColor: colors.value,
		data: booksCount.value
	}]
}

</script>

<template>

	<Head title="Dashboard" />

	<AuthenticatedLayout>
		<template #header>
			Dashboard
		</template>
		<!-- possible chart for auhtor with more books -->
		<div class="p-4 bg-white rounded-lg shadow-xs">
			<div class="grid gap-6  md:grid-cols-2 xl:grid-cols-3">
				<Card class="w-full text-center" style="background-color: palegoldenrod">
					<template #title>
						<p class="text-3xl font-serif text-gray-700">
							Total Books
						</p>
					</template>
					<template #content>
						<div class="grid grid-cols-3 text-gray-500 hover:text-gray-700 transition duration-300">
							<div>
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
									stroke="currentColor" class="size-14">
									<path stroke-linecap="round" stroke-linejoin="round"
										d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
								</svg>
							</div>
							<div>
								<p class="text-5xl">{{ books }}</p>
							</div>
						</div>
					</template>
				</Card>
				<Card class="w-full text-center" style="background-color: paleturquoise">
					<template #title>
						<p class="text-3xl font-serif text-gray-700">
							Total Authors
						</p>
					</template>
					<template #content>
						<div class="grid grid-cols-3 text-gray-500 hover:text-gray-700 transition duration-300">
							<div>
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
									stroke="currentColor" class="size-14">
									<path stroke-linecap="round" stroke-linejoin="round"
										d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
								</svg>
							</div>
							<div>
								<p class="text-5xl">{{ authors }}</p>
							</div>
						</div>
					</template>
				</Card>
				<Card class="w-full text-center" style="background-color: orange">
					<template #title>
						<p class="text-3xl font-serif text-gray-700">
							Total Categories
						</p>
					</template>
					<template #content>
						<div class="grid grid-cols-3 text-gray-500 hover:text-gray-700 transition duration-300">
							<div>
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
									stroke="currentColor" class="size-14">
									<path stroke-linecap="round" stroke-linejoin="round"
										d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
								</svg>
							</div>
							<p class="text-5xl">{{ categories }}</p>
						</div>
					</template>
				</Card>
			</div>

			<Divider type="solid" />
			<div>
				<p class="text-3xl font-serif text-gray-700">
					Author with more books
				</p>
			</div>
			<Chart type="bar" :data="charData" :options="chartOptions" class="bg-white rounded-lg shadow-xs"
				style="position: absolute; height:40vh; width:80vw" />
		</div>
	</AuthenticatedLayout>
</template>
