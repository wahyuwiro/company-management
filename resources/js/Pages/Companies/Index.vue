<script setup>
import { ref, computed } from 'vue';
import { useForm, router, Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Modal, Input, Button, message } from 'ant-design-vue';

defineProps({ companies: Object });

// Modal state
const isModalVisible = ref(false);
const isModalDelete = ref(false);
const logoUrl = ref(null);

// Initialize form once
let form = null; // Declare form variable

// Open modal & reset form data
const openEditModal = (company) => {
    isModalVisible.value = true;

    form = useForm({
        id: company.id,
        name: company.name,
        email: company.email,
        logo: null,
        website: company.website
    });
    logoUrl.value = company.logo ? `/storage/${company.logo}` : null;

};

const openDeleteModal = (company) => {
    isModalDelete.value = true;
    form = useForm({
        id: company.id,
    });
};

// Update company
const updateCompany = () => {

    form.transform((data) => {
        return {
            ...data,
            _method: 'PATCH', // Laravel needs this for updates
        };
    }).post(`/companies/${form.id}`, {
        onSuccess: () => {
            message.success('Company updated successfully');
            isModalVisible.value = false;
        }
    });
};

const handleFileChange = (event) => {
    form.logo = event.target.files[0];

    // Show preview for new image
    logoUrl.value = URL.createObjectURL(form.logo);
};

const deleteCompany = () => {
    router.delete(`/companies/${form.id}`, {
        onSuccess: () => {
            message.success('Company deleted.')
            isModalDelete.value = false;
        }
    });
};

const columns = [
    { title: '#', key: 'index', },
    { title: 'Name', dataIndex: 'name', key: 'name', },
    { title: 'Email', dataIndex: 'email', key: 'email', },
    { title: 'Logo', dataIndex: 'logo', key: 'logo', },
    { title: 'Website', dataIndex: 'website', key: 'website', },
    { title: 'Action', key: 'action', },
];

</script>

<template>
    <Head title="Companies" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Companies</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <a-button type="primary" @click="router.visit('/companies/create')">Add New Company</a-button>
                    <a-table :dataSource="companies.data" :columns="columns" rowKey="id" bordered>
                        <template #bodyCell="{ column, record, index }">
                            <template v-if="column.key === 'index'">
                                {{ index + 1 }}
                            </template>
                            <template v-if="column.key === 'logo'">
                                <img v-if="record.logo" :src="`/storage/${record.logo}`" alt="Company Logo" class="h-12 w-12 object-contain" />
                                <span v-else>No Logo</span>
                            </template>

                            <template v-if="column.key === 'action'">
                                <div class="flex space-x-2">
                                    <a-button type="primary" @click="openEditModal(record)">Edit</a-button>
                                    <a-button type="primary" danger @click="openDeleteModal(record)">Delete</a-button>
                                </div>
                            </template>

                        </template>
                    </a-table>

                    <!-- Delete Company Modal -->
                    <a-modal v-model:visible="isModalDelete" title="Are you sure ?" @ok="deleteCompany()" >
                        <section>
                            <header>
                                <p class="mt-1 text-sm text-gray-600">
                                    Once deleted, this cannot be recovered. Do you want to continue ?
                                </p>
                            </header>
                        </section>
                    </a-modal>

                    <!-- Edit Company Modal -->
                    <a-modal v-model:visible="isModalVisible" title="Edit Company" @ok="updateCompany" >
                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <Input v-model:value="form.name" placeholder="Name" />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <Input v-model:value="form.email" placeholder="Email" />
                                </div>

                                <div>
                                    <p>Current Logo:</p>
                                    <img v-if="logoUrl" :src="logoUrl" alt="Company Logo" class="h-20 w-20 mb-2"/>
                                    <input type="file" @change="handleFileChange" accept="image/*" />
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Website</label>
                                    <Input v-model:value="form.website" placeholder="Website" />
                                </div>

                            </div>
                        </div>
                    </a-modal>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


<script>
export default {
    data() {
        return {
            columns: [
                { title: 'Name', dataIndex: 'name', key: 'name' },
                { title: 'Email', dataIndex: 'email', key: 'email' },
                { title: 'Website', dataIndex: 'website', key: 'website' },
                { title: 'Action', key: 'action' }
            ]
        };
    }
};
</script>
