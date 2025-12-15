<script setup>
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    customers: Array
});

// 初始化表单
const form = useForm({
    customer_id: '',
    invoice_date: new Date().toISOString().substr(0, 10),
    items: [
        { product_name: '', quantity: 1, price: 0 } // 默认一行
    ]
});

// 添加新行
const addItem = () => {
    form.items.push({ product_name: '', quantity: 1, price: 0 });
};

// 删除行
const removeItem = (index) => {
    form.items.splice(index, 1);
};

// 计算总价 (Computed)
const grandTotal = computed(() => {
    return form.items.reduce((acc, item) => {
        return acc + (item.quantity * item.price);
    }, 0);
});

const submit = () => {
    form.post(route('invoices.store'));
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg mt-10">
            <h1 class="text-2xl font-bold mb-6">Create New Invoice</h1>

            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label class="block font-bold">Customer</label>
                    <select v-model="form.customer_id" class="w-full border p-2 rounded">
                        <option value="" disabled>Select a customer</option>
                        <option v-for="c in customers" :key="c.id" :value="c.id">
                            {{ c.name }}
                        </option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-bold">Date</label>
                    <input type="date" v-model="form.invoice_date" class="w-full border p-2 rounded">
                </div>

                <h3 class="text-xl font-bold mt-6 mb-2">Invoice Items</h3>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2">Product</th>
                            <th class="p-2">Qty</th>
                            <th class="p-2">Price</th>
                            <th class="p-2">Subtotal</th>
                            <th class="p-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in form.items" :key="index" class="border-b">
                            <td class="p-2">
                                <input v-model="item.product_name" type="text" class="border p-1 w-full" placeholder="Item name">
                            </td>
                            <td class="p-2 w-24">
                                <input v-model="item.quantity" type="number" min="1" class="border p-1 w-full">
                            </td>
                            <td class="p-2 w-32">
                                <input v-model="item.price" type="number" min="0" step="0.01" class="border p-1 w-full">
                            </td>
                            <td class="p-2 font-bold">
                                {{ (item.quantity * item.price).toFixed(2) }}
                            </td>
                            <td class="p-2">
                                <button type="button" @click="removeItem(index)" class="text-red-500 hover:text-red-700" v-if="form.items.length > 1">
                                    Remove
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <button type="button" @click="addItem" class="mt-2 text-blue-500 hover:underline">+ Add Item</button>

                <div class="flex justify-end items-center mt-6 border-t pt-4">
                    <!-- change to Ringgit -->
                    <div class="text-2xl font-bold mr-6">Total: RM {{ grandTotal.toFixed(2) }}</div>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Save Invoice
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>