<template>
    <div :style="{ marginLeft: `${depth * 20}px` }" class="mb-3 border-bottom pb-2">
      <strong>{{ comment.user_info_that_commented.username }}</strong>
      <p class="mb-1">{{ comment.content }}</p>
      <button class="btn btn-sm btn-link p-0" @click="$emit('set-reply', comment.id)">Reply</button>
  
      <!-- Reply input field -->
      <div v-if="replyingTo === comment.id" class="mt-2">
        <textarea
          v-model="replyContent"
          class="form-control mb-2"
          rows="2"
          placeholder="Write your reply..."
        ></textarea>
        <button class="btn btn-primary btn-sm" @click="submitReply">Send Reply</button>
      </div>
  
      <!-- Nested replies -->
      <CommentItem
        v-for="child in groupedComments[comment.id] || []"
        :key="child.id"
        :comment="child"
        :grouped-comments="groupedComments"
        :depth="depth + 1"
        :replying-to="replyingTo"
        @set-reply="$emit('set-reply', $event)"
      />
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  
  defineProps({
    comment: Object,
    groupedComments: Object,
    depth: Number,
    replyingTo: Number
  })
  
  const replyContent = ref('')
  
  function submitReply() {
    // Replace with form submission later
    alert("Reply submitted: " + replyContent.value)
    replyContent.value = ''
  }
  </script>  