<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    address: '',
    is_deleted: '0'
});

const submit = () => {
    form.post(route('customers.store'));
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg mt-10">
            <h1 class="text-2xl font-bold mb-6">Create New Customer</h1>

            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label class="block font-bold">Name</label>
                    <input type="text" v-model="form.name" class="w-full border p-2 rounded">
                </div>

                <div class="mb-4">
                    <label class="block font-bold">Email</label>
                    <input type="email" v-model="form.email" class="w-full border p-2 rounded">
                </div>
                
                <div class="mb-4">
                    <label class="block font-bold">Phone</label>
                    <input type="text" v-model="form.phone" class="w-full border p-2 rounded">
                </div>

                <div class="mb-4">
                    <label class="block font-bold">Address</label>
                    <textarea v-model="form.address" class="w-full border p-2 rounded"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-bold">Status</label>
                    <select v-model="form.status" class="w-full border p-2 rounded">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Save Customer
                </button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>