<template>
    <div>
        <button @click="AddItemToInventory">Add Item</button>
        <h1>Inventory Details</h1>
        <h3>Name: {{ inventoryName }}</h3>
        <p>Description: {{ inventoryDescription }}</p>
        <table class="table">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in inventoryDetails" :key="item.id">
                    <td>{{ item.name }}</td>
                    <td>{{ item.description }}</td>
                    <td>{{ item.quantity }}</td>
                    <td>
                        <button class="btn btn-danger">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { InventoryService } from '../services';
import router from '../router';

const inventoryName = ref('');
const inventoryDescription = ref('');
//inventory details
const inventoryDetails = ref([]);
const inventoryId = router.currentRoute.value.params.id;

onMounted(() => {
    InventoryService.getInventoryById(inventoryId)
    .then(response => {
        console.log(response.data.data);
        inventoryName.value = response.data.data.name;
        inventoryDescription.value = response.data.data.description;
        inventoryDetails.value = response.data.data.inventory_details;
;
    })
    .catch(error => {
        console.log(error);
    });
});

const deleteInventory = () => {
    InventoryService.deleteInventory(inventoryId)
    .then(response => {
        console.log(response);
        router.push('/dashboard');
    })
    .catch(error => {
        console.log(error);
    });
}

const AddItemToInventory = () => {
    router.push(`/inventory/${inventoryId}/details`);
}
</script>