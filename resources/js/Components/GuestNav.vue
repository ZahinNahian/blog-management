<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex flex-row gap-3">
        <li class="nav-item">
          <Link class="nav-link" href="/post">Post</Link>
        </li>
        <li class="nav-item">
          <Link class="nav-link" href="/">Login</Link>
        </li>
        <li class="nav-item">
          <Link class="nav-link" href="/registration-page">Register</Link>
        </li>
        
      </ul>
    </nav>
    <slot />
  </template>
  
  <script setup>
  import { Link } from '@inertiajs/vue3'
  </script>
  