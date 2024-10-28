<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PaginationLinks from '@/Components/PaginationLinks.vue';
import SearchFilter from '@/Components/SearchFilter.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputText from 'primevue/inputtext';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import { ref } from 'vue';
import { useToast } from 'primevue/usetoast';
import Toast from 'primevue/toast';

const props = defineProps({
	categories: Object,
	searchTerm: String,
})

const search = ref(props.searchTerm)

const form = useForm({
	category: '',
})

const values = ref({
	id: '',
	category: ''
})

const toast = useToast()
const showFormModal = ref(false)
const showDeleteModal = ref(false)

const title = ref('')
const description = ref('')
const operation = ref(1)

const openFormModal = (option, category) => {
	showFormModal.value = true

	operation.value = option

	if (option === 1) {
		title.value = 'Create Category'
		description.value = 'Add category information.'
		form.reset()

	} else {
		title.value = 'Update Category'
		description.value = 'Update category information.'
		form.category = category.category
		values.value.id = category.id
		values.value.category = category.category
	}
}

const closeFormModal = () => {
	showFormModal.value = false
	form.reset()
	form.clearErrors()
}


const openDeleteModal = (category) => {
	showDeleteModal.value = true
	values.value.id = category.id
	values.value.category = category.category
}

const closeDeleteModal = () => {
	showDeleteModal.value = false
}

const save = () => {
	if (operation.value === 1) {
		form.post(route('categories.store'), {
			onSuccess: () => {
				toast.add({
					severity: 'success',
					summary: 'Category Added',
					detail: `Category ${form.category} added successfully`,
					life: 3000
				})
				closeFormModal()
			}
		})

	} else {
		form.put(route('categories.update', values.value.id), {
			onSuccess: () => {
				toast.add({
					severity: 'success',
					summary: 'Category Updated',
					detail: `Category ${values.value.category} updated to ${form.category}`,
					life: 3000
				})
				search.value = 'asd'
				closeFormModal()
			}
		})
	}
}

const deleteCategory = () => {
	form.delete(route('categories.destroy', values.value.id), {
		onSuccess: () => {
			toast.add({
				severity: 'info',
				summary: 'Category Deleted',
				detail: `Category ${values.value.category} deleted`,
				life: 3000
			})
			closeDeleteModal()
		}
	})
}

</script>
<template>
	<Head title="Categories" />
	<AuthenticatedLayout>
		<Toast />
		<template #header>
			Available Categories
		</template>

		<div class="p-4 bg-white rounded-lg shadow-xs">
			<!-- search -->
			<div class="flex justify-between pb-2">
				<SearchFilter routeName="categories.index" :searchTerm="search" />
				<Button v-model:visible="showFormModal" @click="openFormModal(1)">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
						stroke="currentColor" class="size-6">
						<path stroke-linecap="round" stroke-linejoin="round"
							d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
					</svg>
					<p>New</p>
				</Button>
			</div>
			<!-- table -->
			<div class="relative overflow-hidden shadow-md rounded-lg">
				<table class="table-fixed w-full text-left">
					<thead class="uppercase bg-[#6b7280] text-[#e5e7eb]" style="background-color: #6b7280; color: #e5e7eb;">
						<tr>
							<!--[-->
							<th class="py-1  text-center  p-4">Category</th>
							<th class="py-1  text-center  p-4">Actions</th>
							<!--]-->
						</tr>
					</thead>
					<tbody class="bg-white text-gray-500 " style="background-color: #FFFFFF; color: #6b7280;">
						<!--[-->
						<tr v-if="categories.total === 0">
							<td class=" py-3  text-center  p-4">No Category Found</td>
						</tr>

						<tr class=" py-3" v-for="category in categories.data" :key="category.id">
							<!--[-->
							<td class=" py-3  text-center  p-4">{{ category.category }}</td>
							<td class=" py-3  text-center  p-4">
								<Button @click="openFormModal(2, category)" type="button" severity="warn">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
										stroke="currentColor" class="size-6">
										<path stroke-linecap="round" stroke-linejoin="round"
											d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
									</svg>
								</Button>
								<Button @click="openDeleteModal(category)" type="button" severity="danger">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
										stroke="currentColor" class="size-6">
										<path stroke-linecap="round" stroke-linejoin="round"
											d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
									</svg>
								</Button>
							</td>
							<!--]-->
						</tr>
						<!--]-->
					</tbody>
				</table>
				<!-- Pagination Links -->
				<div
					class="px-4 py-2 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
					<PaginationLinks :links="categories.links" :paginator="categories" />
				</div>
			</div>
		</div>
		<!-- Form -->
		<Dialog v-model:visible="showFormModal" modal :header="title">
			<form @submit.prevent="save">
				<span class="text-surface-500 dark:text-surface-400 block mb-8">{{ description }}</span>
				<div class="flex items-center gap-4 mb-4">
					<label for="category" class="font-semibold w-24">Category</label>
					<InputText id="category" class="flex-auto" v-model="form.category" :invalid="form.errors.category" autofocus />
				</div>
				<InputError :message="form.errors.category" />
				<div class="flex justify-end gap-2">
					<Button type="button" label="Cancel" severity="secondary" @click="closeFormModal" />
					<Button type="submit" label="Save" :disabled="form.processing" />
				</div>
			</form>
		</Dialog>
		<!-- Delete -->
		<Dialog v-model:visible="showDeleteModal" modal header="Delete Category">
			<span class="text-surface-500 dark:text-surface-400 block mb-8">
				Are you sure you want to delete this category?
			</span>
			<div class="flex justify-end gap-2">
				<Button type="button" label="Cancel" severity="secondary" @click="closeDeleteModal" />
				<Button type="button" label="Delete" @click="deleteCategory" />
			</div>
		</Dialog>

	</AuthenticatedLayout>
</template>