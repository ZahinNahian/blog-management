<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary px-4">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex flex-row gap-3">
        <li class="nav-item">
          <Link class="nav-link text-white" href="/feed-page">Home</Link>
        </li>        
        <li class="nav-item">
          <Link class="nav-link text-white" href="/create-post-page">Add Post</Link>
        </li>
        <li class="nav-item">
          <Link class="nav-link text-white" href="/my-posts-page">My Posts</Link>
        </li>
        <li class="nav-item">
          <Link class="nav-link text-white" href="/bookmarks-page">Bookmarks</Link>
        </li>
        <li class="nav-item">
          <Link class="nav-link text-white" href="/logout" method="post" as="button">Logout</Link>
        </li>
        
      </ul>
    </nav>
    <slot />
  </template>
  
  <script setup>
  import { Link } from '@inertiajs/vue3'
  import { createToaster } from '@meforma/vue-toaster';

  const toaster=createToaster();
  
  </script>
  