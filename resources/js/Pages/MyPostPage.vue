<script setup>
import AuthNav from "../Components/AuthNav.vue"
import { Link, usePage } from "@inertiajs/vue3"
import {createToaster} from "@meforma/vue-toaster"
const page = usePage()
const toaster = createToaster()

const flash = page.props.flash

if (flash?.status === true) {
  toaster.success(flash.message)
} else if (flash?.status === false) {
  toaster.success(flash.message) // change this to .error for false case
}

defineProps({
  posts: Array
})
</script>

<template>
  <AuthNav>
    <div class="container py-5">
    <h1 class="text-center mb-5">📰 My Blog Posts</h1>

    <div v-if="posts.length === 0" class="text-center text-muted mb-4">
      No blog posts available.
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-2">
      <div v-for="post in posts" :key="post.id" class="col">
        <div class="card h-100">
          <!-- Fixed height image -->
          <div style="height: 200px; overflow: hidden;">
            <img v-if="post.image" :src="'/' + post.image" class="card-img-top h-100 w-100 object-fit-cover" alt="Blog Image">
          </div>
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ post.title }}</h5>
            <p class="card-text text-truncate">{{ post.content }}</p>
            <div class="d-flex flex-wrap gap-2">
              tags:
              <span v-for="(tag, index) in post.tags" :key="tag.id" class="d-inline">
                .{{ tag.name }}
              </span>
            </div>
            <div class="mt-2">
              <Link :href="`/view-post/${post.id}`" class="me-2"><button class="btn btn-primary">Read More</button></Link>
              <Link :href="`/post/${post.id}/${post.users_who_liked_the_post_mod.length>0 ? 'unlike' : 'like'}`" class="me-2"><button class="btn btn-info">{{ post.users_who_liked_the_post_mod.length>0 ? '👎': '👍' }}</button></Link>               
              <Link :href="`/edit-post-page/${post.id}`" class="me-2">
                <button class="btn btn-success">📝</button>
              </Link> 
              <Link :href="`/post-delete/${post.id}`" class="me-2">
                <button class="btn btn-warning">❌</button>
              </Link>               
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </AuthNav>

</template>
