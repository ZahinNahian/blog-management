<template>
    <div class="container py-5">
      <div class="card shadow-lg border-0 rounded-4 px-4 py-5">
  
        <!-- Post Title -->
        <h1 class="display-5 fw-bold mb-4 text-primary">{{ page.props.post.title }}</h1>
  
        <!-- Tags -->
        <div class="mb-4 text-secondary fs-6">
          <span class="me-2 fw-semibold">Tags:</span>
          <span
            v-for="tag in page.props.post.tags"
            :key="tag.id"
            class="me-2 text-dark"
          >
            .{{ tag.name }}
          </span>
        </div>
  
        <!-- Post Image -->
        <div v-if="page.props.post.image" class="text-center mb-4">
          <img
            :src="`/${page.props.post.image}`"
            alt="Post image"
            class="img-fluid rounded-4 shadow-sm"
            style="max-height: 400px; object-fit: cover;"
          />
        </div>
  
        <!-- Post Content -->
        <div class="fs-5 lh-lg text-body mb-5">
          {{ page.props.post.content }}
        </div>
  
        <!-- Back Button -->
        <div class="text-end">
          <Link href="/feed-page" class="btn btn-outline-primary px-4 py-2 rounded-pill">
            ← Back to Feed
          </Link>
        </div>
  
      </div>
      <h5 class="mt-5">Comments</h5>
        <!-- <div v-for="comment in page.props.post.comments_of_the_post" :key="comment.id" class="mb-3 border-bottom pb-2">
          <strong>{{ comment.user_info_that_commented.username }}</strong>
          <p class="mb-1">{{ comment.content }}</p>
          <button @click="form.parent_id = comment.id">Reply</button>
        </div> -->

        <!--Added Later Portion-->
        <!-- <div>
        <CommentItem
          v-for="comment in rootComments"
          :key="comment.id"
          :comment="comment"
          :grouped-comments="groupedComments"
          :depth="0"
          @set-reply="setReply" />
        </div> -->

        <CommentItem
        v-for="comment in rootComments"
        :key="comment.id"
        :comment="comment"
        :grouped-comments="groupedComments"
        :depth="0"
        :replying-to="replyingTo"
        @set-reply="setReply"/>


        <!--Added Later Portion-->

      <h1 class="mt-4">Post Your Comment Here</h1>
      <form @submit.prevent="submitComment">
        <textarea v-model="form.content" class="form-control mb-2" rows="3" placeholder="Write a comment..."></textarea>
      <button class="btn btn-primary btn-sm">Post Comment</button>
      </form>
    </div>
  </template>
  
  <script setup>
  // import { Link, useForm, usePage } from '@inertiajs/vue3'
  // import CommentItem from '../Components/CommentItem.vue'

  // const page=usePage()
  // const groupedComments = page.props.groupedComments
  // const rootComments = groupedComments[""] || groupedComments.null || []
  // const form= useForm({
  //   content:'',
  //   post_id:page.props.post.id,
  //   parent_id: null,
  // })
  

  // function submitComment() {
  //   form.post('/add-comment')
  // }

  // function setReply(id) {
  //   form.parent_id = id
  // }


import { ref } from 'vue'
import { Link, useForm, usePage } from '@inertiajs/vue3'
import CommentItem from '../Components/CommentItem.vue'

const page = usePage()
const groupedComments = page.props.groupedComments
const rootComments = groupedComments.null || []

const replyingTo = ref(null) // Track the comment being replied to

const form = useForm({
  content: '',
  post_id: page.props.post.id,
  parent_id: null
})

function setReply(id) {
  replyingTo.value = id
  form.parent_id = id
}


  console.log('Grouped Comments:', groupedComments)
  console.log('Root Comments:', rootComments)
  </script>