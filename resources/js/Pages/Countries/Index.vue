<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PaginationLinks from '@/Components/PaginationLinks.vue';
import SearchFilter from '@/Components/SearchFilter.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import InputText from 'primevue/inputtext';
import DataTable from 'primevue/datatable';
import Dialog from 'primevue/dialog';
import Column from 'primevue/column';
import Button from 'primevue/button';
import Toast from 'primevue/toast';
import { ref } from 'vue';

const props = defineProps({
	countries: Object,
	searchTerm: String,
})
const form = useForm({
	country: '',
	search: ''
})

const values = ref({
	id: '',
	country: ''
})

const toast = useToast()
const showFormModal = ref(false)
const showDeleteModal = ref(false)

const title = ref('')
const operation = ref(1)

const openFormModal = (option, country) => {
	showFormModal.value = true
	operation.value = option
	if (option === 1) {
		title.value = 'Add Country'
		form.reset()
	} else {
		title.value = 'Update Country'
		form.country = country.country
		values.value.id = country.id
		values.value.country = country.country
	}
}

const closeFormModal = () => {
	showFormModal.value = false
	form.reset()
	form.clearErrors()
}


const openDeleteModal = (country) => {
	showDeleteModal.value = true
	values.value.id = country.id
	values.value.country = country.country
}

const closeDeleteModal = () => {
	showDeleteModal.value = false
}

const save = () => {
	if (operation.value === 1) {
		form.post(route('countries.store'), {
			onSuccess: () => {
				toast.add({
					severity: 'success',
					summary: 'Country Added',
					detail: `Country ${form.country} added`,
					life: 3000
				})
				closeFormModal()
			}
		})
	} else {
		form.put(route('countries.update', values.value.id), {
			onSuccess: () => {
				toast.add({
					severity: 'success',
					summary: 'Country Updated',
					detail: `Country ${values.value.country} updated to ${form.country}`,
					life: 3000
				})
				closeFormModal()
			}
		})
	}
}

const deleteCountry = () => {
	form.delete(route('countries.destroy', values.value.id), {
		onSuccess: () => {
			toast.add({
				severity: 'info',
				summary: 'Country Deleted',
				detail: `Country ${values.value.country} deleted`,
				life: 3000
			})
			closeDeleteModal()
		}
	})
}



</script>
<template>

	<Head title="Countries" />
	<AuthenticatedLayout>
		<Toast />
		<template #header>
			Available Countries
		</template>

		<div class="p-4 bg-white rounded-lg shadow-xs">

			<!-- table -->
			<div class="relative overflow-hidden shadow-md rounded-lg">
				<DataTable :value="countries.data" >
					<template #header>
						<!-- search -->
						<div class="flex justify-between pb-2">
							<SearchFilter routeName="countries.index" :searchTerm="searchTerm" />
							<Button v-model:visible="showFormModal" @click="openFormModal(1)">
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
							No countries found
						</p>
					</template>

					<Column field="country" header="Country" />
					<Column header="Actions">
						<template #body="{ data }">
							<div class="flex gap-2">
								<Button @click="openFormModal(2, data)" type="button" severity="warn">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
										stroke="currentColor" class="size-6">
										<path stroke-linecap="round" stroke-linejoin="round"
											d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
									</svg>
								</Button>
								<Button @click="openDeleteModal(country)" type="button" severity="danger">
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
						<PaginationLinks :links="countries.links" :paginator="countries" />
					</template>
				</DataTable>
			</div>
		</div>
		<!-- Form -->
		<Dialog v-model:visible="showFormModal" modal :header="title">
			<form @submit.prevent="save">
				<div class="flex items-center gap-4 mb-4">
					<label for="country" class="font-semibold w-24">Country</label>
					<InputText id="country" class="flex-auto" v-model="form.country" :invalid="form.errors.country" autofocus />
				</div>
				<InputError :message="form.errors.country" />
				<div class="flex justify-end gap-2">
					<Button type="button" label="Cancel" severity="secondary" @click="closeFormModal" />
					<Button type="submit" label="Save" :disabled="form.processing" />
				</div>
			</form>
		</Dialog>
		<!-- Delete -->
		<Dialog v-model:visible="showDeleteModal" modal header="Delete Country">
			<span class="text-surface-500 dark:text-surface-400 block mb-8">
				Are you sure you want to delete this country?
			</span>
			<div class="flex justify-end gap-2">
				<Button type="button" label="Cancel" severity="secondary" @click="closeDeleteModal" />
				<Button type="button" label="Delete" @click="deleteCountry" />
			</div>
		</Dialog>
	</AuthenticatedLayout>
</template>