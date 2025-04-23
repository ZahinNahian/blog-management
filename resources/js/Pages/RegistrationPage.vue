<template>
    <div class="container mt-5">
      <h2 class="mb-4">Register</h2>
      <form @submit.prevent="submit">
        <div class="mb-3">
          <label>Username</label>
          <input v-model="form.username" type="text" class="form-control" />
        </div>
        <div class="mb-3">
          <label>Email</label>
          <input v-model="form.email" type="email" class="form-control" />
        </div>
        <div class="mb-3">
          <label>Password</label>
          <input v-model="form.password" type="password" class="form-control" />
        </div>
        <div class="mb-3">
          <label>Profile Picture</label>
          <input @change="e=> form.profile_pic=e.target.files[0]" type="file" class="form-control"/>
        </div>
        <button class="btn btn-success">Register</button>
        <p class="mt-3">
          Already have an account?
          <Link href="/">Login</Link>
        </p>
      </form>
    </div>
  </template>
  
  <script setup>
  import { useForm, router, Link, usePage } from '@inertiajs/vue3'
  import { createToaster } from '@meforma/vue-toaster'
  import AuthNav from "../Components/AuthNav.vue"
  import GuestNav from "../Components/GuestNav.vue";  
  
  const form = useForm({
    username: '',
    email: '',
    password: '',
    profile_pic: null,
  })
  
  const toaster=createToaster({position: 'top-right'});
  const page=usePage();

  function submit() {
    if (form.username.length===0) {
        toaster.success("Username required");
    } else if (form.email.length===0) {
        toaster.success("Email required");
    } else if (form.password.length===0) {
        toaster.warning("password required");
    } else {
        form.post("/user-registration", {
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
  