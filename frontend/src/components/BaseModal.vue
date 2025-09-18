<script setup lang="ts">
import { defineProps, defineEmits } from 'vue'

const props = defineProps<{
  show: boolean
  title?: string
  size?: 'sm' | 'md' | 'lg' // tamanho opcional
}>()

// const emit = defineEmits(['close'])
</script>

<template>
    <transition name="fade">
        <div
            v-if="show"
            class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        >
            <div
                class="bg-white rounded-xl shadow-lg p-6"
                :class="{
                    'max-w-sm w-full': size === 'sm',
                    'max-w-md w-full': size === 'md' || !size,
                    'max-w-lg w-full': size === 'lg',
                }"
            >
                <!-- Cabeçalho -->
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <slot name="icon"></slot>
                        <h2 class="text-xl font-semibold" v-if="title">{{ title }}</h2>
                    </div>
                    <!-- <button
                        class="text-gray-400 hover:text-gray-600"
                        @click="emit('close')"
                    >
                        ✕
                    </button> -->
                </div>

                <hr>
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
