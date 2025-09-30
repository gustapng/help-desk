<script setup lang="ts">
import { defineProps, defineEmits } from 'vue'

const props = defineProps<{
  show: boolean
  title?: string
  size?: 'sm' | 'md' | 'lg' | 'xl' 
}>()

const emit = defineEmits(['close'])
</script>

<template>
  <transition name="fade">
    <div v-if="props.show" class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
      <div
        class="bg-white rounded-xl shadow-lg p-6"
        :class="{
          'max-w-sm w-full': props.size === 'sm',
          'max-w-md w-full': props.size === 'md' || !props.size,
          'max-w-lg w-full': props.size === 'lg',
          'max-w-xl w-full': props.size === 'xl',
        }"
      >
        <!-- Cabeçalho -->
        <div class="flex items-center justify-between mb-4">
          <div class="flex items-center">
            <slot name="icon"></slot>
            <h2 class="text-xl font-semibold" v-if="props.title">{{ props.title }}</h2>
          </div>
        </div>

        <hr class="mb-2 text-black"/>
        <!-- Conteúdo do modal -->
        <slot></slot>
      </div>
    </div>
  </transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
