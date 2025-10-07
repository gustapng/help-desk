<script setup lang="ts">
import type { Pagination, PaginationLink } from '@/types/Ticket'

defineProps<{ paginationInfo: Pagination<unknown> | null }>()
const emit = defineEmits<{ (e: 'change-page', url: string): void }>()

function onPageChange(link: PaginationLink) {
  if (link.url) {
    emit('change-page', link.url)
  }
}
</script>

<template>
  <div
    v-if="paginationInfo && paginationInfo.total > 0"
    class="flex items-center justify-between border-t border-white/10 py-3"
  >
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-400">
          Mostrando
          <span class="font-medium">1</span>
          a
          <span class="font-medium">{{ paginationInfo.per_page }}</span>
          de
          <span class="font-medium">{{ paginationInfo.total }}</span>
          resultados
        </p>
      </div>
      <div>
        <nav aria-label="Pagination" class="isolate inline-flex -space-x-px rounded-md">
          <button
            v-for="link in paginationInfo.links"
            :key="link.label"
            @click="onPageChange(link)"
            :disabled="!link.url || link.active"
            :class="[
              'relative inline-flex items-center px-4 py-2 text-sm font-semibold focus:z-20 focus:outline-offset-0',
              link.active
                ? 'text-white bg-sky-400 hover:bg-sky-500'
                : 'text-gray-400 hover:bg-gray-200',
            ]"
          >
            <span v-html="link.label"></span>
          </button>
        </nav>
      </div>
    </div>
  </div>
</template>
