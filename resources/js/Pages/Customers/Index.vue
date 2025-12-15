<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, router } from '@inertiajs/vue3';
defineProps({ customers: Object });

// soft delete customer
const deleteCustomer = (id) => {
    if (confirm('Are you sure you want to delete this customer?')) {
        router.delete(route('customers.destroy', id), {
            preserveScroll: true,
        });
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-6xl mx-auto p-6">
            <div class="flex justify-between mb-4">
                <h1 class="text-2xl font-bold">Customers List</h1>
                <Link :href="route('customers.create')" class="bg-green-500 text-white px-4 py-2 rounded">
                    Create New
                </Link>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-6 text-left">ID</th>
                            <th class="py-3 px-6 text-left">Name</th>
                            <th class="py-3 px-6 text-left">Email</th>
                            <th class="py-3 px-6 text-left">Phone</th>
                            <th class="py-3 px-6 text-left">Address</th>
                            <th class="py-3 px-6 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="customer in customers.data" :key="customer.id" class="border-b">
                            <td class="py-3 px-6">#{{ customer.id }}</td>
                            <td class="py-3 px-6">{{ customer.name }}</td>
                            <td class="py-3 px-6">{{ customer.email }}</td>
                            <td class="py-3 px-6">{{ customer.phone }}</td>
                            <td class="py-3 px-6 font-bold">{{ customer.address }}</td>
                            <td class="py-3 px-6 flex gap-2">
                                <Link :href="route('customers.edit', customer.id)" class="bg-blue-500 text-white px-4 py-2 rounded">
                                    Edit
                                </Link>
                                <button class="bg-red-500 text-white px-4 py-2 rounded" @click="deleteCustomer(customer.id)">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <Link 
                    v-for="link in customers.links" 
                    :key="link.label"
                    :href="link.url ?? '#'"
                    v-html="link.label"
                    class="px-3 py-1 border mx-1 rounded"
                    :class="{ 'bg-blue-500 text-white': link.active, 'text-gray-500': !link.url }"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>