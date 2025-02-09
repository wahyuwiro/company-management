<script setup>
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import { message } from 'ant-design-vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';


const form = useForm({
    name: '',
    email: '',
    logo: null,
    website: ''
});

const submit = () => {
    form.post('/companies', {
        onSuccess: () => {
            message.success('Company added successfully');
            router.visit('/companies'); // Redirect to the list
        }
    });
};

const handleFileChange = (event) => {
    form.logo = event.target.files[0];
};
</script>

<template>
    <Head title="Add New Company" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add New Company</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Company Name</label>
                            <a-input v-model:value="form.name" placeholder="Company Name" required />
                            <span v-if="form.errors.namel" class="text-red-500">{{ form.errors.namel }}</span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <a-input v-model:value="form.email" placeholder="Company Email" type="email" />
                            <span v-if="form.errors.email" class="text-red-500">{{ form.errors.email }}</span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Logo</label>
                            <input type="file" @change="handleFileChange" accept="image/*" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Company Website</label>
                            <a-input v-model:value="form.website" placeholder="Company Website" />
                            <span v-if="form.errors.website" class="text-red-500">{{ form.errors.website }}</span>
                            <br v-if="form.errors.website">
                        </div>

                        <a-button type="primary" html-type="submit" :loading="form.processing">Submit</a-button>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
