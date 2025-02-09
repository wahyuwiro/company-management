<script setup>
import { useForm } from '@inertiajs/vue3';
import { message } from 'ant-design-vue';
import { defineProps } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({ company: Object });

// Ensure the prop exists before using it
if (!props.company) {
    throw new Error("Company prop is missing!");
}

const form = useForm({
    name: props.company.name,
    email: props.company.email,
    logo: null, // Handle new logo upload
    website: props.company.website
});


const submit = () => {
    form.transform((data) => {
        return {
            ...data,
            _method: 'PATCH', // Laravel needs this for updates
        };
    }).post(`/companies/${props.company.id}`, {
        onSuccess: () => {
            message.success('Company updated successfully');
        }
    });
};

const handleFileChange = (event) => {
    form.logo = event.target.files[0];
};
</script>

<template>
    <Head title="Edit Company" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Company</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                    <form @submit.prevent="submit" class="space-y-4">
                        <a-input v-model:value="form.name" placeholder="Company Name" required />
                        <a-input v-model:value="form.email" placeholder="Company Email" type="email" />

                        <div>
                            <p>Current Logo:</p>
                            <img v-if="props.company.logo" :src="`/storage/${props.company.logo}`" alt="Company Logo" class="h-20 w-20 mb-2"/>
                            <input type="file" @change="handleFileChange" accept="image/*" />
                        </div>

                        <a-input v-model:value="form.website" placeholder="Company Website" />
                        <a-button type="primary" html-type="submit" :loading="form.processing">Update</a-button>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
