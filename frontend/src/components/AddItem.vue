<template>
    <div>
        <h1>Add New Item to Inventory</h1>
        <form @submit.prevent="addItemToInventory">
            <div class="form-group">
                <label for="job_title">Item Name</label>
                <input type="text" class="form-control" id="job_title" v-model="name" required>
            </div>
            <div class="form-group">
                <label for="job_description">Description</label>
                <textarea class="form-control" id="job_description" v-model="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="job_title">Quantity</label>
                <input type="text" class="form-control" id="job_title" v-model="quantity" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Inventory</button>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { InventoryService } from '../services';
import router from '../router';

const name = ref('');
const description = ref('');
const quantity = ref('');

const addItemToInventory = () => {
    InventoryService.addItemToInventory(
        router.currentRoute.value.params.id,{
        name: name.value,
        description: description.value,
        quantity: quantity.value
    })
    .then(response => {
        router.push('/dashboard');
    })
    .catch(error => {
        console.log(error);
    });
}
</script>

