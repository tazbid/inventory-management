<template>
    <div>
        <h1>Add New Inventory</h1>
        <form @submit.prevent="createInventory">
            <div class="form-group">
                <label for="job_title">Inventory Name</label>
                <input type="text" class="form-control" id="job_title" v-model="name" required>
            </div>
            <div class="form-group">
                <label for="job_description">Description</label>
                <textarea class="form-control" id="job_description" v-model="description" required></textarea>
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

const createInventory = () => {
    InventoryService.createInventory({
        name: name.value,
        description: description.value
    })
    .then(response => {
        router.push('/dashboard');
    })
    .catch(error => {
        console.log(error);
    });
}
</script>

