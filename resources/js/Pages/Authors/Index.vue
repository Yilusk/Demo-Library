<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PaginationLinks from '@/Components/PaginationLinks.vue';
import SearchFilter from '@/Components/SearchFilter.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import InputText from 'primevue/inputtext';
import IftaLabel from 'primevue/iftalabel';
import DataTable from 'primevue/datatable';
import Fieldset from 'primevue/fieldset';
import Dialog from 'primevue/dialog';
import Select from 'primevue/select';
import Button from 'primevue/button';
import Column from 'primevue/column';
import Toast from 'primevue/toast';
import { ref } from 'vue';

const props = defineProps({
	authors: Object,
	searchTerm: String,
	countries: Object
})

const form = useForm({
	name: '',
	last_name: '',
	country_id: ''
})

const search = ref(props.searchTerm)

const toast = useToast()

const showDataModal = ref(false)
const showFormModal = ref(false)
const showDeleteModal = ref(false)

const title = ref('')
const operation = ref(1)

const values = ref({
	id: '',
	name: '',
	last_name: '',
	country_id: '',
	books: []
})


const openFormModal = (option, author) => {
	showFormModal.value = true
	operation.value = option
	if (option === 1) {
		title.value = 'Create Author'
		form.reset()
		form.clearErrors()
	} else {
		title.value = 'Update Author'
		form.name = author.name
		form.last_name = author.last_name
		form.country_id = author.country.id
		values.value.id = author.id
		form.clearErrors()
	}
}

const closeFormModal = () => {
	showFormModal.value = false
	form.reset()
	form.clearErrors()
}

const openDataModal = (data) => {
	showDataModal.value = true
	values.value.id = data.id
	values.value.name = data.name
	values.value.last_name = data.last_name
	values.value.country = data.country
	values.value.books = data.books

}
const closeDataModal = () => {
	showDataModal.value = false
}

const openDeleteModal = (author) => {
	showDeleteModal.value = true
	values.value.id = author.id
	values.value.name = author.name
}

const closeDeleteModal = () => {
	showDeleteModal.value = false
}

const save = () => {
	if (operation.value === 1) {
		form.post(route('authors.store'), {
			onSuccess: () => {
				toast.add({
					severity: 'success',
					summary: 'Author Created',
					detail: `Author ${form.name} ${form.last_name} created`,
					life: 3000
				})
				closeFormModal()
			}
		})
	} else {
		form.put(route('authors.update', values.value.id), {
			onSuccess: () => {
				toast.add({
					severity: 'success',
					summary: 'Author Updated',
					detail: `Author ${form.name} ${form.last_name} updated`,
					life: 3000
				})
				closeFormModal()
			}
		})
	}
}


const deleteAuthor = () => {
	form.delete(route('authors.destroy', values.value.id), {
		onSuccess: () => {
			toast.add({
				severity: 'info',
				summary: 'Author Deleted',
				detail: `Author ${values.value.name} ${values.value.last_name} deleted`,
				life: 3000
			})
			closeDeleteModal()
		}
	})
}
</script>
<template>

	<Head title="Authors" />
	<AuthenticatedLayout>
		<Toast />
		<template #header>
			Authors List
		</template>
		<div class="p-4 bg-white rounded-lg shadow-xs">
			<!-- table -->
			<div class="relative overflow-hidden shadow-md rounded-lg">
				<DataTable :value="authors.data">
					<template #header>
						<div class="flex justify-between pb-2">
							<!-- search -->
							<SearchFilter routeName="authors.index" :searchTerm="search" />
							<Button @click="openFormModal(1)" size="">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
									stroke="currentColor" class="size-6">
									<path stroke-linecap="round" stroke-linejoin="round"
										d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
								</svg>
								<p>New</p>
							</Button>
						</div>
					</template>
					<template #empty>
						<p>
							No authors found
						</p>
					</template>


					<Column field="name" header="Name" />
					<Column field="last_name" header="Last Name" />
					<Column field="country.country" header="Country" />
					<Column header="Actions">
						<template #body="{ data }">
							<div class="flex gap-2">
								<Button @click="openDataModal(data)" type="button" severity="secondary">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
										stroke="currentColor" class="size-6">
										<path stroke-linecap="round" stroke-linejoin="round"
											d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
										<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
									</svg>
								</Button>
								<Button @click="openFormModal(2, data)" type="button" severity="warn">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
										stroke="currentColor" class="size-6">
										<path stroke-linecap="round" stroke-linejoin="round"
											d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
									</svg>
								</Button>
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
					<template #footer>
						<PaginationLinks :links="authors.links" :paginator="authors" />
					</template>
				</DataTable>
			</div>
		</div>

		<!-- Show Data Modal -->
		<Dialog v-model:visible="showDataModal" modal header="Author Information">
			<div class="flex items-center gap-4 mb-4">
				<div>
					<p>
						<span class="font-bold">Name: </span>
						{{ values.last_name }} {{ values.name }}
					</p>
					<p>
						<span class="font-bold">Country: </span>
						{{ values.country.country }}
					</p>
					<p>
						<span class="font-bold">Author Description:</span>
						This author has {{ values.books.length }} books
					</p>
					<Fieldset legend="Books Writted">
						<div v-if="values.books.length == 0">
							<p>
								<span>No Books Written By This Author</span>
							</p>
						</div>
						<div v-for="book in values.books" :key="book.id">
							<Fieldset :legend="book.title" :toggleable="true" :collapsed="true">
								<p>
									<span class="font-bold">Release Date: </span>
									{{ book.release_date }}
								</p>
								<p>
									<span class="font-bold">Publisher: </span>
									{{ book.publisher }}
								</p>
								<p>
									<span class="font-bold">Pages: </span>
									{{ book.pages }}
								</p>
								<p>
									<span class="font-bold">Description: </span>
									{{ book.description }}
								</p>
							</Fieldset>
						</div>
					</Fieldset>
				</div>

			</div>
			<div class="flex justify-end gap-2">
				<Button type="button" label="Close" severity="secondary" @click="closeDataModal" />
			</div>
		</Dialog>

		<!-- Show Form Modal -->
		<Dialog v-model:visible="showFormModal" modal :header="title">
			<form @submit.prevent="save">
				<!-- first name -->
				<div class="flex items-center gap-4 mb-4">
					<IftaLabel>
						<InputText id="name" class="flex-auto w-full md:w-56" v-model="form.name" :invalid="form.errors.name"
							autofocus />
						<label for="name" class="font-semibold w-24">First Name</label>
						<InputError :message="form.errors.name" />
					</IftaLabel>
				</div>
				<!-- last name -->
				<div class="flex items-center gap-4 mb-4">
					<IftaLabel>
						<InputText id="last_name" class="flex-auto w-full md:w-56" v-model="form.last_name"
							:invalid="form.errors.last_name" autofocus />
						<label for="last_name" class="font-semibold w-24">Last name</label>
						<InputError :message="form.errors.last_name" />
					</IftaLabel>
				</div>
				<!-- country -->
				<div class="flex items-center gap-4 mb-4">
					<IftaLabel>
						<Select v-model="form.country_id" :options="countries" filter option-value="id" option-label="country"
							placeholder="Select a Country" class="w-full md:w-56" :invalid="form.errors.country_id" />
						<label for="country" class="font-semibold w-24">Country</label>
						<InputError :message="form.errors.country_id" />
					</IftaLabel>
				</div>
				<!-- buttons -->
				<div class="flex justify-end gap-2">
					<Button type="button" label="Cancel" severity="secondary" @click="closeFormModal" />
					<Button type="submit" label="Save" :disabled="form.processing" />
				</div>
			</form>
		</Dialog>


		<!-- show Delete Modal -->
		<Dialog v-model:visible="showDeleteModal" modal header="Delete Auhtor">
			<span class="text-surface-500 dark:text-surface-400 block mb-8">
				Are you sure you want to delete this author?
			</span>
			<div class="flex justify-end gap-2">
				<Button type="button" label="Cancel" severity="secondary" @click="closeDeleteModal" />
				<Button type="button" label="Delete" @click="deleteAuthor" />
			</div>
		</Dialog>
	</AuthenticatedLayout>
</template>