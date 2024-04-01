<template>
  <div class="login-container">
    <h2 class="login-heading">Register</h2>
    <form @submit.prevent="Register()" class="login-form">
      <div class="form-group">
        <label for="name" class="label">Name:</label>
        <input type="text" id="name" v-model="RegistrationInput.name" required class="form-control">
      </div>
      <div class="form-group">
        <label for="email" class="label">Email:</label>
        <input type="text" id="email" v-model="RegistrationInput.email" required class="form-control">
      </div>
      <div class="form-group">
        <label for="password" class="label">Password:</label>
        <input type="password" id="password" v-model="RegistrationInput.password" required class="form-control">
      </div>
      <div class="form-group">
        <label for="password" class="label">Confirm Password:</label>
        <input type="password" id="confirm_password" v-model="RegistrationInput.confirmPassword" required
          class="form-control">
      </div>
      <!-- <button type="submit" class="btn btn-primary mb-4">Login</button> -->
      <button type="submit"
        class="mt-4 w-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-indigo-100 py-2 rounded-md text-lg tracking-wide">Register</button>
    </form>
    <router-link to="/login" class="btn btn-primary">Already have an account? Login</router-link>
    <div v-if="errorMessage" class="error-message">{{ errorMessage }}</div>
  </div>
</template>

<script setup>
import { AuthService } from '../services';
import {reactive,ref} from 'vue';
import router from '../router';

const RegistrationInput = reactive({
  name: '',
  email: '',
  password: '',
  confirmPassword: '',
});

const errorMessage = ref("");

function Register() {
  AuthService.register({
    name: RegistrationInput.name,
    email: RegistrationInput.email,
    password: RegistrationInput.password,
    confirmPassword: RegistrationInput.confirmPassword
  })
  .then(response => {
    localStorage.setItem('token', response.data.token);
    localStorage.setItem('user', JSON.stringify(response.data.user));
    router.push('/dashboard');
    //reload the page
    location.reload();
  })
  .catch(error => {
    this.errorMessage = error.response.data.message;
  });
}
</script>

<style>
.login-container {
  max-width: 400px;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #f9f9f9;
  margin-top: 40px !important;
}

.login-heading {
  text-align: center;
  margin-bottom: 20px;
  color: black;
}

.login-form {
  background-color: #fff;
  padding: 20px;
  border-radius: 5px;
}

.form-group {
  margin-bottom: 20px;
}

.label {
  font-weight: bold;
  color: black;
  /* Set label color to black */
}

.form-control {
  width: 100%;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 5px;
  color: rgb(0, 0, 0);
  background-color: #f9f9f9;
}

.btn-primary {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  width: 100%;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.error-message {
  color: red;
  margin-top: 10px;
  text-align: center;
}
</style>
