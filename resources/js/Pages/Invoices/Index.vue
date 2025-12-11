<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({ invoices: Object });
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-6xl mx-auto p-6">
            <div class="flex justify-between mb-4">
                <h1 class="text-2xl font-bold">Invoices List</h1>
                <Link :href="route('invoices.create')" class="bg-green-500 text-white px-4 py-2 rounded">
                    Create New
                </Link>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-6 text-left">Invoice ID</th>
                            <th class="py-3 px-6 text-left">Customer</th>
                            <th class="py-3 px-6 text-left">Date</th>
                            <th class="py-3 px-6 text-left">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="inv in invoices.data" :key="inv.id" class="border-b">
                            <td class="py-3 px-6">#{{ inv.id }}</td>
                            <td class="py-3 px-6">{{ inv.customer.name }}</td>
                            <td class="py-3 px-6">{{ inv.invoice_date }}</td>
                            <td class="py-3 px-6 font-bold">${{ inv.total_amount }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <Link 
                    v-for="link in invoices.links" 
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