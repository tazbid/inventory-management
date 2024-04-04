<template>
    <div>
        <h1>All Inventories</h1>
        <ul>
        <li v-for="inventory in inventory" :key="inventory.id" @click="viewInventoryDetails(inventory.id)">
            <h3>Name: {{ inventory.name }}</h3>
            <p>Description: {{ inventory.description }}</p>
        </li>
        </ul>
    </div>
</template>
  
<script setup>
import { ref, onMounted } from 'vue';
import { JobService, InventoryService } from '../services';
import router from '../router';

const inventory = ref([]);

onMounted(() => {
    InventoryService.getAllInventoryForUser()
    .then(response => {
        inventory.value = response.data.data.data;
    })
    .catch(error => {
        console.log(error);
    });
});

const viewInventoryDetails = (id) => {
    router.push(`/inventory/${id}`);
}

</script>

<style scoped>
h1 {
    color: #3eaf7c;
}

ul {
    list-style-type: none;
    padding: 0;
}

li {
    margin: 10px 0;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #ffffff;
    color: #3eaf7c;
}
</style>