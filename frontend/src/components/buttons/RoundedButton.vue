<template>
  <button
    :type="buttonType"
    @click="emitClick"
    class="rounded-full bg-colorGreen hover:bg-black text-black hover:text-white p-3 transition-colors duration-200"
  >
    <slot />
  </button>
</template>

<script setup lang="ts">
import { defineProps, defineEmits, withDefaults } from 'vue'

interface Props {
  buttonType?: 'button' | 'submit' | 'reset'
}

const { buttonType } = withDefaults(defineProps<Props>(), {
  buttonType: 'button',
})

const emit = defineEmits<{
  (e: 'click'): void
}>()

const emitClick = () => {
  emit('click')
}
</script>
