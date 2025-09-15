<template>
  <transition name="fade">
    <div
      v-if="alert.visible"
      class="fixed bottom-4 right-4 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow-lg dark:text-gray-400 dark:bg-gray-800"
      role="alert"
    >
        <div
            :class="[
                'inline-flex items-center justify-center shrink-0 w-8 h-8 rounded-lg',
                colorClasses.bg,
                colorClasses.text
            ]"
        >
            <component :is="icon" class="w-5 h-5" />
        </div>
        <div class="ms-3 text-sm font-medium">
            {{ alert.message }}
        </div>
        <button
            type="button"
            class="ms-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
            @click="alert.hide"
        >
            <span class="sr-only">Close</span>
            ✕
        </button>
    </div>
  </transition>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useAlertStore } from '@/stores/alert'
import { CheckIcon, XCircle, AlertTriangle, Info } from 'lucide-vue-next'

const alert = useAlertStore()

const icons = {
  success: CheckIcon,
  error: XCircle,
  warning: AlertTriangle,
  info: Info,
}

const icon = computed(() => icons[alert.type])

const colors = {
  success: { bg: 'bg-green-100 dark:bg-green-800', text: 'text-green-500 dark:text-green-200' },
  error: { bg: 'bg-red-100 dark:bg-red-800', text: 'text-red-500 dark:text-red-200' },
  warning: { bg: 'bg-orange-100 dark:bg-orange-700', text: 'text-orange-500 dark:text-orange-200' },
  info: { bg: 'bg-blue-100 dark:bg-blue-700', text: 'text-blue-500 dark:text-blue-200' },
}

const colorClasses = computed(() => colors[alert.type])
</script>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s, transform 0.3s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
  transform: translateY(10px);
}
</style>