<script setup lang="ts">
import axios from 'axios'
import type { AxiosError } from 'axios'
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'

import RoundedButton from '@/components/buttons/RoundedButton.vue'
import Sidebar from '@/components/Sidebar.vue'
import { useAlertStore } from '@/stores/alert'
import type { Ticket } from '@/types/Ticket'

const isLoading = ref(true)

const message = ref('')
const alert = useAlertStore()
const isModalOpen = ref(false)
const route = useRoute()

const ticket = ref<Ticket[]>([])

async function fetchTicket() {
  const ticketId = route.params.id

  isLoading.value = true
  try {
    const response = await axios.get(`/api/tickets/${ticketId}`)
    ticket.value = response.data
  } catch (error) {
    const err = error as AxiosError<{ message?: string; errors?: Record<string, string[]> }>

    if (err.response) {
      if (err.response.status === 422) {
        message.value = err.response.data.message || 'Erro de validação.'
      } else {
        message.value = err.response.data.message || 'Ocorreu um erro no servidor.'
      }
    } else {
      message.value = 'Erro de conexão. Verifique sua internet e tente novamente.'
    }
    alert.show(message.value, 'error')
  } finally {
    isLoading.value = false
  }
}

onMounted(() => {
  fetchTicket()
})
</script>

<template>
  <Sidebar></Sidebar>
  <div class="p-4 sm:ml-64">
    <div class="flex items-center place-content-between">
      <h1 class="text-xl font-semibold">Detalhes do Ticket: {{ ticket.title }}</h1>
      <RoundedButton class="flex items-center text-white" @click="isModalOpen = true">
        <Plus class="mr-2"></Plus>
        Criar Ticket
      </RoundedButton>
    </div>

    <div v-if="isLoading" class="mt-4 text-center">Carregando...</div>

    <router-view />
  </div>
</template>
