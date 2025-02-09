<script setup>
import { useForm } from '@inertiajs/vue3';
import { message, Select, Input, Button } from 'ant-design-vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({ employee: Object, companies: Array });

const form = useForm({
    first_name: props.employee.first_name,
    last_name: props.employee.last_name,
    company_id: props.employee.company_id,
    email: props.employee.email,
    phone: props.employee.phone
});

const submit = () => {
    form.put(`/employees/${props.employee.id}`, {
        onSuccess: () => message.success('Employee updated successfully')
    });
};
</script>

<template>
    <Head title="Edit Employee" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Employee</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <Input v-model:value="form.email" placeholder="Email" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone</label>
                            <Input v-model:value="form.phone" placeholder="Phone" />
                        </div>

                        <Button type="primary" html-type="submit" :loading="form.processing">Update</Button>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
