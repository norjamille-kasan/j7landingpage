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
import { Link , Head} from '@inertiajs/inertia-vue3';
import {  ref, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import debounce from 'lodash/debounce';


let deleteModal = ref(false)
let deleteId = ref(null)

const deleteProject = (id) => {
   deleteId.value = id
   deleteModal.value = true
}

const confirmDelete = () => {
   Inertia.delete(route('projects.destroy', { id: deleteId.value }), {
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

let search = ref(props.filters.search)

 let props = defineProps({
      projects: Object,
      filters: Object,
 })

watch(search, debounce((value) => {
   Inertia.get(route('projects.index'), { search: value }, {
      preserveState: true,
      preserveScroll: true,
   })
}, 1000))
</script>


<template>
   <AdminLayout title="Projects">
       <Head title="Projects" />
    <div class="grid gap-5">
        <div class="flex justify-between">
           <div>
              <TextInput v-model="search" type="search" placeholder="Search" />
           </div>
           <div>
              <PrimaryButtonLink :href="route('projects.create')">Create</PrimaryButtonLink>
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
                  <Row v-for="project in projects.data" :key="project.id">
                     <Cell>{{ project.name }}</Cell>
                     <Cell>
                        <a :href="'storage/' + project.image_path" target="_blank" class="text-blue-600 hover:underline">
                           View Image
                        </a>
                     </Cell>
                     <Cell>
                        <p>
                           {{ project.description }}
                        </p>
                     </Cell>
                     <Cell>
                        <div class="flex space-x-2">
                           <Link :href="route('projects.edit', { id : project.id })" class="font-semibold text-yellow-600 uppercase hover:underline">Edit</Link>
                        <button @click="deleteProject(project.id)" type="button"
                           class="font-semibold text-red-600 uppercase hover:underline">Delete</button>
                        </div>
                     </Cell>
                  </Row>
                  <Row v-if="projects.data.length === 0">
                     <Cell colspan="4" class="text-center">No projects found.</Cell>
                  </Row>
            </template>
            <template #pagination>
               <Pagination 
               class="mt-4" 
               :firstUrl="projects.first_page_url" 
               :prevUrl="projects.prev_page_url" 
               :nextUrl="projects.next_page_url" 
               :from="projects.from"
               :to="projects.to"
               :total="projects.total"
               />
            </template>
        </Table>
    </div>
    <Confirm :show="deleteModal" @confirm="confirmDelete" @cancel="cancelDelete" title="Delete Project" message="Are you sure you want to delete this project?" />
   </AdminLayout>
</template>



