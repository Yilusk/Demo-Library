<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PaginationLinks from '@/Components/PaginationLinks.vue';
import SearchFilter from '@/Components/SearchFilter.vue';
import { Head, useForm } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import ScrollPanel from 'primevue/scrollpanel';
import { useToast } from 'primevue/usetoast';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import Toast from 'primevue/toast';
import { ref } from 'vue';

const props = defineProps({
	books: Object,
	searchTerm: String
})

const form = useForm({
	id: ''
})

const values = ref({
	id: '',
	isbn: '',
	title: '',
	description: ''
})

const toast = useToast()
const search = ref(props.searchTerm)

const showDeleteModal = ref(false)

const openDeleteModal = (book) => {
	showDeleteModal.value = true
	form.id = book.id
	values.value.title = book.title
}

const closeDeleteModal = () => {
	showDeleteModal.value = false
}

const deleteBook = () => {
	form.delete(route('books.destroy', form.id), {
		onSuccess: () => {
			toast.add({
				severity: 'info',
				summary: 'Book Deleted',
				detail: `Book ${values.value.title} deleted`,
				life: 3000
			})
			closeDeleteModal()
		}
	})
}
</script>
<template>
	<Head title="Books" />
	<AuthenticatedLayout>
		<Toast />
		<template #header>
			Books List
		</template>
		<div class="p-4 bg-white rounded-lg shadow-xs">
			<!-- table -->
			<div class="relative overflow-hidden shadow-md rounded-lg">
				<DataTable :value="books.data">
					<template #header>
						<!-- search  -->
						<SearchFilter routeName="books.index" :searchTerm="search" />
					</template>
					<template #empty>
						<p>
							No books found
						</p>
					</template>
					<Column field="title" header="Title" />
					<Column field="publisher" header="Publisher" />
					<Column field="release_date" header="Release Date" />
					<Column field="categories" header="Categories">
						<template #body="{ data }">
							<ScrollPanel style="width: 100%; height: 70px">
								<p v-for="category in data.categories" :key="category.id">
									{{ category.category }}

								</p>
								<p v-if="data.categories.length == 0">
									Uncategorized
								</p>
							</ScrollPanel>
						</template>
					</Column>
					<Column field="authors" header="Authors">
						<template #body="{ data }">
							<ScrollPanel style="width: 100%; height: 70px">
								<p v-for="author in data.authors" :key="author.id">
									{{ author.name }}
								</p>
								<p v-if="data.authors.length == 0">
									Not Found
								</p>
							</ScrollPanel>
						</template>
					</Column>
					<Column header="Actions">
						<template #body="{ data }">
							<div class="flex">
								<!-- show -->
								<NavLink :href="route('books.show', data.id)">
									<Button type="button" severity="secondary">
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
											stroke="currentColor" class="size-6">
											<path stroke-linecap="round" stroke-linejoin="round"
												d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
											<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
										</svg>
									</Button>
								</NavLink>
								<!-- edit -->
								<NavLink :href="route('books.edit', data.id)">
									<Button type="button" severity="warn" class="mr-3">
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
											stroke="currentColor" class="size-6">
											<path stroke-linecap="round" stroke-linejoin="round"
												d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
										</svg>
									</Button>
								</NavLink>
								<!-- delete -->
								<Button @click="openDeleteModal(data)" type="button" severity="danger">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
										stroke="currentColor" class="size-6">
										<path stroke-linecap="round" stroke-linejoin="round"
											d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
									</svg>
								</Button>
							</div>
						</template>
					</Column>
					<!-- Pagination Links -->
					<template #footer>
						<PaginationLinks :links="books.links" :paginator="books" />
					</template>
				</DataTable>
			</div>
		</div>

		<!-- show Delete Modal -->
		<Dialog v-model:visible="showDeleteModal" modal header="Delete Book">
			<span class="text-surface-500 dark:text-surface-400 block mb-8">
				Are you sure you want to delete this Book?
			</span>
			<div class="flex justify-end gap-2">
				<Button type="button" label="Cancel" severity="secondary" @click="closeDeleteModal" />
				<Button type="button" label="Delete" @click="deleteBook" />
			</div>
		</Dialog>

	</AuthenticatedLayout>
</template>