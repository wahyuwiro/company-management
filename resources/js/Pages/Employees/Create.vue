<script setup>
import { useForm } from '@inertiajs/vue3';
import { message, Select, Input, Button } from 'ant-design-vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({ companies: Array });

const form = useForm({
    first_name: '',
    last_name: '',
    company_id: '',
    email: '',
    phone: ''
});

const submit = () => {
    form.post('/employees', {
        onSuccess: () => message.success('Employee added successfully')
    });
};
</script>

<template>
    <Head title="Add New Employee" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add New Employee</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">First Name</label>
                            <Input v-model:value="form.first_name" placeholder="First Name" required />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Last Name</label>
                            <Input v-model:value="form.last_name" placeholder="Last Name" required />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Company</label>
                            <Select v-model:value="form.company_id" placeholder="Select Company" class="w-full">
                                <Select.Option v-for="company in companies" :key="company.id" :value="company.id">
                                    {{ company.name }}
                                </Select.Option>
                            </Select>
                            <span v-if="form.errors.company_id" class="text-red-500">{{ form.errors.company_id }}</span>
                        </div>


                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <Input v-model:value="form.email" placeholder="Email" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone</label>
                            <Input v-model:value="form.phone" placeholder="Phone" />
                        </div>

                        <Button type="primary" html-type="submit" :loading="form.processing">Save</Button>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
