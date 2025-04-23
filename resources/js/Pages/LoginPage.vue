<template>
  <AuthNav v-if="authUser" />
  <GuestNav v-else />
    <div class="container mt-5">
      <h2 class="mb-4">Login</h2>
      <form @submit.prevent="submit">
        <div class="mb-3">
          <label>Email</label>
          <input v-model="form.email" type="email" class="form-control" required />
        </div>
        <div class="mb-3">
          <label>Password</label>
          <input v-model="form.password" type="password" class="form-control" required />
        </div>
        <button class="btn btn-primary">Login</button>
        <p class="mt-3">
          Don’t have an account?
          <Link href="/registration-page">Sign up</Link>
        </p>
      </form>
    </div>
  </template>
  
  <script setup>
  import { useForm, usePage } from '@inertiajs/vue3'
  import { Link } from '@inertiajs/vue3'
  import { createToaster } from '@meforma/vue-toaster';
  import AuthNav from "../Components/AuthNav.vue"
  import GuestNav from "../Components/GuestNav.vue";

  const toaster=createToaster();
  const page=usePage();
  
  const form = useForm({
    email: '',
    password: '',
  })
  
  function submit() {
    if (form.email.length===0) {
      toaster.success("Email required")
    } else if (form.password.length===0) {
      toaster.success("Password required")
    }
    else {
      form.post('/user-login', {
        onSuccess: () => {
          if (page.props.flash.status===true) {
            toaster.success(page.props.flash.message)
          } else if (page.props.flash.status===false) {
            toaster.success(page.props.flash.message)
          }
        }
      })

    }
  }
  </script>
  