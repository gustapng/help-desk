<template>
  <div>
    <button 
        :type="type"
        @click="$emit('click')"
        class="rounded-full bg-colorGreen hover:bg-black p-3 text-black hover:text-white">{{ text }}</button>
  </div>
</template>

<script setup>
defineProps({
  text: String,
  type: {
    type: String,
    default: ''
  }
})
</script>
