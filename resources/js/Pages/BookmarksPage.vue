<script setup>
import { router, Link } from '@inertiajs/vue3'
import AuthNav from '../Components/AuthNav.vue'
defineProps({ posts: Array })

// const toggleBookmark = (postId) => {
//   router.post('/toggle-bookmark', { post_id: postId }, {
//     preserveScroll: true,
//     onFinish: () => router.reload({ only: ['posts'] })
//   })
// }
</script>

<template>
<AuthNav>
  <div class="container py-5">
    <h1 class="text-center mb-5 fw-bold display-6">🌟 Bookmarked Posts</h1>

    <div v-if="posts.length" class="row row-cols-1 g-4">
      <div v-for="post in posts" :key="post.id" class="col">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <Link :href="`/view-post/${post.id}`">
                    <h5 class="card-title fw-bold">{{ post.title }}</h5>
                </Link>
                <p class="card-text text-muted">{{ post.content.slice(0, 120) }}...</p>
              </div>
              <Link :href="`/post/${post.id}/unbookmark`" class="btn btn-outline-danger h-50 align-self-start">
                💔 Unbookmark
              </Link>
            </div>

            <div v-if="post.tags?.length" class="mt-3">
              <span
                v-for="tag in post.tags"
                :key="tag.id"
                class="badge bg-primary me-2"
              >
                #{{ tag.name }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-else class="text-center text-muted mt-5">
      <p class="fs-5">You haven’t bookmarked any posts yet. 📭</p>
    </div>
  </div>
</AuthNav>  
</template>
