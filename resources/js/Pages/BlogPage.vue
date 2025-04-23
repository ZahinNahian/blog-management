<script setup>
import { ref, watch } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import AuthNav from "../Components/AuthNav.vue"
import GuestNav from "../Components/GuestNav.vue";

const search = ref('')

// Watch the search input and trigger Inertia visit (debounced)
watch(search, (value) => {
  router.get('/feed-page', { search: value }, { preserveState: true, replace: true })
})

defineProps({
  posts: Array,
  authUser: Boolean
})
</script>

<template>
  <AuthNav v-if="authUser" />
  <GuestNav v-else />
    <div class="container py-5">
    <h1 class="text-center mb-5">📰 Latest Blog Posts</h1>
    <input
      v-model="search"
      type="text"
      class="form-control mb-3"
      placeholder="Search posts..."
    />

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
            <small class="text-muted mt-auto">Visibility: {{ post.visibility }}</small>
            <div class="d-flex flex-wrap gap-2">
              tags:
              <span v-for="(tag, index) in post.tags" :key="tag.id" class="d-inline">
                .{{ tag.name }}
              </span>
            </div>
            <div class="mt-2">
              <Link :href="`${authUser ? '/view-post/'+post.id : '/'}`" class="me-2"><button>Read More</button></Link>
              <Link v-if="authUser" :href="`/post/${post.id}/${post.users_who_liked_the_post_mod.length>0 ? 'unlike' : 'like'}`" class="me-2"><button>{{ post.users_who_liked_the_post_mod.length>0 ? 'Unlike': 'Like' }}</button></Link>               
              <Link v-if="authUser" :href="`/post/${post.id}/${post.users_that_bookmarked_the_post_mod.length>0 ? 'unbookmark':'bookmark'}`" class="me-2"><button>{{ post.users_that_bookmarked_the_post_mod.length>0 ? "UnBookmark":"Bookmark" }}</button></Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- </GuestNav> -->
  <!-- </AuthNav> -->

</template>
