<script setup>
import Cell from '@/Components/Cell.vue';
import Thead from '@/Components/Head.vue';
import PrimaryButtonLink from '@/Components/PrimaryButtonLink.vue';
import Row from '@/Components/Row.vue';
import Table from '@/Components/Table.vue';
import TextInput from '@/Components/TextInput.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import Confirm from '@/Components/Confirm.vue';
import { Link, Head } from '@inertiajs/inertia-vue3';
import { ref, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import debounce from 'lodash/debounce';


let search = ref(props.filters.search)

let deleteModal = ref(false)
let deleteId = ref(null)

const deleteService = (id) => {
   deleteId.value = id
   deleteModal.value = true
}

const confirmDelete = () => {
   Inertia.delete(route('services.destroy', { id: deleteId.value }), {
      preserveState: true,
      preserveScroll: true,
      onSuccess: () => {
         deleteModal.value = false
      },
   })
}

const cancelDelete = () => {
   deleteModal.value = false
}

let props = defineProps({
   services: Object,
   filters: Object,
})

watch(search, debounce((value) => {
   Inertia.get(route('services.index'), { search: value }, {
      preserveState: true,
      preserveScroll: true,
   })
}, 1000))
</script>


<template>
   <AdminLayout title="Services">

      <Head title="Services" />
      <div class="grid gap-5">
         <div class="flex justify-between">
            <div>
               <TextInput v-model="search" type="search" placeholder="Search" />
            </div>
            <div>
               <PrimaryButtonLink :href="route('services.create')">Create</PrimaryButtonLink>
            </div>
         </div>
         <Table>
            <template #head>
               <Thead>Name</Thead>
               <Thead>Image</Thead>
               <Thead>Descriptions</Thead>
               <Thead>Action</Thead>
            </template>
            <template #body>
               <Row v-for="service in services.data" :key="service.id">
                  <Cell>{{ service.name }}</Cell>
                  <Cell>
                     <a :href="'storage/' + service.image_path" target="_blank" class="text-blue-600 hover:underline">
                        View Image
                     </a>
                  </Cell>
                  <Cell>
                     <p>
                        {{ service.description }}
                     </p>
                  </Cell>
                  <Cell>
                     <div class="flex space-x-2">
                        <Link :href="route('services.edit', { id: service.id })"
                           class="font-semibold text-yellow-600 uppercase hover:underline">Edit</Link>
                        <button @click="deleteService(service.id)" type="button"
                           class="font-semibold text-red-600 uppercase hover:underline">Delete</button>
                     </div>
                  </Cell>
               </Row>
               <Row v-if="services.data.length === 0">
                  <Cell colspan="4" class="text-center">No services found.</Cell>
               </Row>
            </template>
            <template #pagination>
               <Pagination class="mt-4" :firstUrl="services.first_page_url" :prevUrl="services.prev_page_url"
                  :nextUrl="services.next_page_url" :from="services.from" :to="services.to" :total="services.total" />
            </template>
         </Table>
      </div>
      <Confirm :show="deleteModal" @confirm="confirmDelete" @cancel="cancelDelete" title="Delete Service" message="Are you sure you want to delete this service?" />
   </AdminLayout>
</template>



