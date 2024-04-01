<template>
    <div>
        <h1>All Generated Jobs</h1>
        <ul>
        <li v-for="job in jobs" :key="job.id">
            {{ serial++ }}. {{ job.job_title }}
            <button @click="viewJobDetails(job.id)">View Details</button>
        </li>
        </ul>
    </div>
</template>
  
<script setup>
import { ref, onMounted } from 'vue';
import { JobService } from '../services';
import router from '../router';

const jobs = ref([]);
let serial = 1;

onMounted(() => {
    JobService.getAllJobs()
    .then(response => {
        jobs.value = response.data;
    })
    .catch(error => {
        console.log(error);
    });
});

const viewJobDetails = (id) => {
    router.push('/job/' + id);
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