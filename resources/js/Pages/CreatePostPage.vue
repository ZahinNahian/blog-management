<template>
  <AuthNav>
    <div class="container mt-4">
      <h2>Create New Post</h2>
  
      <form @submit.prevent="submitPost" enctype="multipart/form-data">
        <!-- Title -->
        <div class="mb-3">
          <label class="form-label">Title</label>
          <input v-model="form.title" type="text" class="form-control" />
        </div>
  
        <!-- Content -->
        <div class="mb-3">
          <label class="form-label">Content</label>
          <textarea v-model="form.content" class="form-control" rows="5"></textarea>
        </div>
  
        <!-- Visibility -->
        <div class="mb-3">
          <label class="form-label">Visibility</label>
          <select v-model="form.visibility" class="form-select">
            <option value="">-- Select --</option>
            <option value="public">Public</option>
            <option value="private">Private</option>
          </select>
        </div>
  
        <!-- Tags -->
        <div class="mb-3">
          <label class="form-label">Tags (comma separated)</label>
          <input v-model="form.tags" type="text" class="form-control" />
        </div>
  
        <!-- Image -->
        <div class="mb-3">
          <label class="form-label">Image (optional)</label>
          <input @change="handleImage" type="file" accept="image/*" class="form-control" />
        </div>
  
        <!-- Submit -->
        <button type="submit" class="btn btn-primary">Create Post</button>
      </form>
    </div>
  </AuthNav>
  </template>
  
  <script setup>
  import { useForm, usePage } from '@inertiajs/vue3'
  import { createToaster } from '@meforma/vue-toaster'
  import AuthNav from '../Components/AuthNav.vue'
  
  const form = useForm({
    title: '',
    content: '',
    visibility: '',
    tags: '',
    image: null,
  })

  const toaster=createToaster() // {position: top-right}
  const page=usePage()
  
  const handleImage = (e) => {
    form.image = e.target.files[0]
  }
  
  function submitPost() {
    if (form.title.length===0) {
        toaster.success("Title Required")
    } else if (form.content.length===0) {
        toaster.success("Content Required")
    } else if (form.visibility.length===0) {
        toaster.success("Visibility Required")
    } else if (form.tags.length===0) {
        toaster.success("Tags Required")
    } else {
        form.post('/create-post', {
            onSuccess: () => {
                if (page.props.flash.status===true) {
                    toaster.success(page.props.flash.message)
                } else if (page.props.flash.status===false) {
                    toaster.warning(page.props.flash.message)
                }
            }
        })
    }
}
  </script>
  
  