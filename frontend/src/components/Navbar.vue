<template>
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" v-if="token === '' || token === null">
                    <li class="nav-item">
                        <router-link to="/login" class="nav-link" active-class="active">Login</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/register" class="nav-link" active-class="active">Register</router-link>
                    </li>
                </ul>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" v-else>
                    <li class="nav-item">
                        <router-link to="/dashboard" class="nav-link" active-class="active" exact>Dashboard</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/add/inventory" class="nav-link" active-class="active">Add New Inventory</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/user/generated-jobs" class="nav-link" active-class="active">My Generated
                            Jobs</router-link>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" @click="logout">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">{{ user.name }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <router-view></router-view>
</template>

<script setup>
import router from '../router';
import { AuthService } from '../services';
const token = localStorage.getItem('token');
const user = JSON.parse(localStorage.getItem('user'));

function logout() {
    AuthService.logout().then(() => {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        router.push('/login').then(() => {
          window.location.reload();
        });
    });
}
</script>

