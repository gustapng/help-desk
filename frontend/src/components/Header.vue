<script setup lang="ts">
import { Menu, X } from 'lucide-vue-next'
import { ref, onMounted, onBeforeUnmount } from 'vue'

const isOpen = ref(false)

const toggleMenu = () => {
  isOpen.value = !isOpen.value
}

const handleResize = () => {
  if (window.innerWidth >= 768) {
    isOpen.value = false
  }
}

onMounted(() => {
  window.addEventListener('resize', handleResize)
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', handleResize)
})
</script>

<template>
  <header class="shadow-sm px-4 sm:px-6 lg:px-8 bg-white relative z-50">
    <div class="max-w-7xl mx-auto flex justify-between items-center py-4">
      <h1 class="text-2xl font-bold">Help Desk</h1>
      <nav class="hidden md:flex space-x-4">
        <RouterLink
          to="/register"
          class="rounded-full hover:bg-black px-4 py-2 text-black hover:text-white border border-black transition-all"
        >
          Registre-se
        </RouterLink>
        <RouterLink
          to="/login"
          class="rounded-full bg-colorGreen hover:bg-black px-4 py-2 text-black hover:text-white border border-colorGreen hover:border-black transition-all"
        >
          Login
        </RouterLink>
      </nav>

      <!-- Mobile -->
      <button
        class="md:hidden p-2 rounded-md border border-gray-200 text-black hover:bg-black hover:text-white transition"
        @click="toggleMenu"
      >
        <component :is="isOpen ? X : Menu" class="w-6 h-6" />
      </button>
    </div>

    <!-- Mobile Dropdown -->
    <transition name="slide-down">
      <div
        v-if="isOpen"
        class="absolute right-4 mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-lg z-40"
      >
        <nav class="flex flex-col p-4 space-y-2">
          <RouterLink
            to="/register"
            class="rounded-lg bg-primaryColor px-4 py-2 text-center text-black hover:bg-black hover:text-white border border-black transition-all"
            @click="isOpen = false"
          >
            Registre-se
          </RouterLink>
          <RouterLink
            to="/login"
            class="rounded-lg bg-colorGreen px-4 py-2 text-center text-black hover:bg-black hover:text-white border border-colorGreen hover:border-black transition-all"
            @click="isOpen = false"
          >
            Login
          </RouterLink>
        </nav>
      </div>
    </transition>
  </header>
</template>

<style scoped>
.slide-down-enter-active,
.slide-down-leave-active {
  transition: all 0.2s ease;
}
.slide-down-enter-from {
  opacity: 0;
  transform: translateY(-10px);
}
.slide-down-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>
