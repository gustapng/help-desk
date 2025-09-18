<template>
  <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
    <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
    </svg>
  </button>

  <aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-100">
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <button class="relative flex max-w-xs items-center rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
            <span class="absolute -inset-1.5"></span>
            <span class="sr-only">Open user menu</span>
            <img 
              src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" 
              alt="" 
              class="size-12 rounded-full outline -outline-offset-1 outline-white/10" 
            />
          </button>
          <div class="ms-3">
            <p class="text-gray-800 font-medium">Gustavo Ferreira</p>
            <p class="text-gray-500 text-sm">Administrador</p>
          </div>
        </div>

        <Menu as="div" class="relative inline-block">
          <MenuButton class="rounded-lg p-1 text-gray-500 hover:text-gray-800 hover:bg-gray-200">
            <EllipsisVertical />
          </MenuButton>

          <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform scale-100" leave-to-class="transform opacity-0 scale-95">
            <MenuItems class="absolute right-0 z-10 mt-3 w-56 rounded-md bg-gray-200">
              <div class="py-1">
                <MenuItem v-slot="{ active }">
                  <a href="#" :class="[active ? 'text-gray-800 bg-gray-300 outline-hidden' : 'text-gray-500', 'flex items-center gap-2 p-2 text-sm']">
                    <Settings></Settings>
                    <span>Configurações</span>
                  </a>
                </MenuItem>
                <form @submit.prevent="handleSubmit">
                  <MenuItem v-slot="{ active }">
                    <button type="submit" :class="[active ? 'text-gray-800 bg-gray-300 outline-hidden' : 'text-gray-500', 'flex items-center gap-2 p-2 text-sm w-full text-left']">
                      <LogOut></LogOut>
                      <span>Sair</span>
                    </button>
                  </MenuItem>
                </form>
              </div>
            </MenuItems>
          </transition>
        </Menu>
      </div>

      <hr class="my-2">

      <ul class="space-y-2">
        <li>
          <RouterLink to="/dashboard" v-slot="{ href, navigate, isActive }">
            <a
              :href="href"
              @click="navigate"
              class="flex p-2 rounded-lg hover:bg-gray-200 hover:text-gray-800"
              :class="isActive ? 'bg-gray-200 text-gray-800 font-semibold' : 'text-gray-500'"
            >
            <LayoutDashboard />
            <span class="ms-2">Dashboard</span>
            </a>
          </RouterLink>
        </li>
        <li>
          <RouterLink to="/ticket" v-slot="{ href, navigate, isActive }">
            <a
              :href="href"
              @click="navigate"
              class="flex p-2 rounded-lg hover:bg-gray-200 hover:text-gray-800"
              :class="isActive ? 'bg-gray-200 text-gray-800 font-semibold' : 'text-gray-500'"
            >
              <Ticket />
              <span class="ms-2">Ticket</span>
            </a>
          </RouterLink>
        </li>
      </ul>
    </div>
  </aside>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { EllipsisVertical, Settings, LogOut, Ticket, LayoutDashboard } from 'lucide-vue-next'

const message = ref('') 
const errors = ref<Record<string, string[]>>({});

const router = useRouter()

async function handleSubmit() {
  try {
    await axios.post('/logout')

    message.value = 'Cadastro realizado com sucesso!'
    router.push('/')
  } catch (error: any) {
    if (error.response) {
      if (error.response.status === 422) {
        errors.value = error.response.data.errors || {}
        message.value = error.response.data.message || 'Erro ao realizar logout.'
      } 
      else {
        message.value = error.response.data.message || 'Ocorreu um erro no servidor.'
      }
    } else {
      message.value = 'Erro de conexão. Verifique sua internet e tente novamente.'
    }
  }
}
</script>