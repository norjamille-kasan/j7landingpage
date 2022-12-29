<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButtonLink from '@/Components/SecondaryButtonLink.vue';
import TextInput from '@/Components/TextInput.vue';
import Textarea from '@/Components/Textarea.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import { useForm , Head} from '@inertiajs/inertia-vue3';

const form = useForm({
  name: '',
  description: '',
  image: null,
});

const submit = () => {
  form.post(route('projects.store'));
};

</script>


<template>
  <AdminLayout title="Create Project">
    <Head title="Create Project" />
    <div class="grid gap-5">
      <form @submit.prevent="submit" class="grid gap-4">
        <div class="grid gap-1">
          <InputLabel for="name">Name</InputLabel>
          <TextInput v-model="form.name" id="name" type="text" placeholder="Name" />
          <InputError class="mt-2" :message="form.errors.name" />
        </div>
        <div class="grid gap-1">
          <InputLabel for="description">Description</InputLabel>
          <Textarea v-model="form.description" rows="10" id="description" type="text" placeholder="Service description" />
          <InputError class="mt-2" :message="form.errors.description" />
        </div>
        <div class="grid gap-1">
          <InputLabel for="file">Image</InputLabel>
          <input type="file" id="file" @input="form.image = $event.target.files[0]"
            class="block w-full p-2 mt-2 bg-white border border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <InputError class="mt-2" :message="form.errors.image" />
          
        </div>
        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
          {{ form.progress.percentage }}%
        </progress>
        <div class="flex space-x-3">
          <PrimaryButton type="submit">Save</PrimaryButton>
          <SecondaryButtonLink href="/services">Cancel</SecondaryButtonLink>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>



