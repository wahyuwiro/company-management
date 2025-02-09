<script setup>
import { ref, computed } from 'vue';
import { useForm, router, Head } from '@inertiajs/vue3';
import { Modal, Input, Button, message } from 'ant-design-vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

// Props received from Laravel Controller
const props = defineProps({ employees: Object, companies: Array });

// Modal state
const isModalVisible = ref(false);
const isModalDelete = ref(false);
let form = null; // Declare form variable

// Open modal and initialize form
const openEditModal = (employee) => {
    isModalVisible.value = true;
    currentCompany = computed(() => {
        return props.companies.find(company => company.id === employee.company_id) || {};
    });

    console.log('Selected Company:', currentCompany.value);

    // Create a fresh useForm() instance every time
    form = useForm({
        id: employee.id,
        first_name: employee.first_name,
        last_name: employee.last_name,
        email: employee.email,
        phone: employee.phone,
        company_id: employee.company_id
    });
};

const openDeleteModal = (company) => {
    isModalDelete.value = true;
    form = useForm({
        id: company.id,
    });
};

// Submit updated data
const updateEmployee = () => {
    if (!form) return; // Ensure form is initialized
    form.put(`/employees/${form.id}`, {
        onSuccess: () => {
            message.success('Employee updated successfully');
            isModalVisible.value = false;
        }
    });
};

// Delete employee
const deleteEmployee = () => {
    router.delete(`/employees/${form.id}`, {
        onSuccess: () => {
            message.success('Employee deleted successfully');
            isModalDelete.value = false;
        }
    });
};

// Table columns
const columns = [
    { title: '#', key: 'index', dataIndex: 'id', customRender: ({ index }) => index + 1 },
    { title: 'Full Name', key: 'full_name', customRender: ({ record }) => `${record.first_name} ${record.last_name}` },
    { title: 'Email', dataIndex: 'email', key: 'email' },
    { title: 'Company', key: 'company', customRender: ({ record }) => record.company?.name ?? '-' },
    { title: 'Action', key: 'action' }
];

const companyList = computed(() => props.companies || []);
let currentCompany = computed(() => {
    return props.companies.find(company => company.id === form?.company_id) || {};
});


</script>

<template>
    <Head title="Employees" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Employees</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <a-button type="primary" @click="router.visit('/employees/create')">Add New Employees</a-button>
                    <a-table :dataSource="employees.data" :columns="columns" rowKey="id" bordered>
                        <template #bodyCell="{ column, record }">
                            <!-- Custom rendering for Action buttons -->
                            <template v-if="column.key === 'action'">
                                <div class="flex space-x-2">
                                    <a-button type="primary" @click="openEditModal(record)">Edit</a-button>
                                    <a-button type="primary" danger @click="openDeleteModal(record)">Delete</a-button>
                                </div>
                            </template>
                        </template>
                    </a-table>

                    <!-- Delete Company Modal -->
                    <a-modal v-model:visible="isModalDelete" title="Are you sure ?" @ok="deleteEmployee()" >
                        <section>
                            <header>
                                <p class="mt-1 text-sm text-gray-600">
                                    Once deleted, this cannot be recovered. Do you want to continue ?
                                </p>
                            </header>
                        </section>
                    </a-modal>

                    <!-- Edit Employee Modal -->
                    <a-modal v-model:visible="isModalVisible" title="Edit Employee" @ok="updateEmployee">
                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">First Name</label>
                                    <Input v-model:value="form.first_name" placeholder="First Name" />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Last Name</label>
                                    <Input v-model:value="form.last_name" placeholder="Last Name" />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Company</label>
                                    <a-select
                                        v-model:value="form.company_id"
                                        placeholder="Select Company"
                                        :getPopupContainer="trigger => trigger.parentNode"
                                        class="w-full"
                                    >
                                        <a-select-option v-for="company in companies" :key="company.id" :value="company.id">
                                            {{ company.name }}
                                        </a-select-option>
                                    </a-select>

                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <Input v-model:value="form.email" placeholder="Email" />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                                    <Input v-model:value="form.phone" placeholder="Phone" />
                                </div>

                            </div>
                        </div>

                        <div class="p-4 sm:p-8 mt-4 bg-white shadow sm:rounded-lg">
                            <div class="space-y-4">
                                <div v-if="currentCompany.id">
                                    <label class="block text-sm font-medium text-gray-700">Company Name</label>
                                    <Input :value="currentCompany.name" disabled />
                                </div>

                                <div v-if="currentCompany.website">
                                    <label class="block text-sm font-medium text-gray-700">Website</label>
                                    <Input :value="currentCompany.website" disabled />
                                </div>

                                <div v-if="currentCompany.email">
                                    <label class="block text-sm font-medium text-gray-700">Company Email</label>
                                    <Input :value="currentCompany.email" disabled />
                                </div>
                            </div>
                        </div>

                    </a-modal>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
