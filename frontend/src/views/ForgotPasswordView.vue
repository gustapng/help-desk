<script setup lang="ts">
import axios from 'axios'
import type { AxiosError } from 'axios'
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'

import RoundedButton from '@/components/buttons/RoundedButton.vue'
import InputBase from '@/components/inputs/InputBase.vue'
import { useAlertStore } from '@/stores/alert'

const email = ref('')

const message = ref('')
const loading = ref(false)
const alert = useAlertStore()
const route = useRoute()

onMounted(() => {
  if (route.query.verified === 'true') {
    message.value = 'Seu e-mail foi verificado com sucesso!'
  }
})

function validateForm() {
  if (!email.value) {
    alert.show('O campo de email é obrigatório.', 'error')
    return false
  }

  return true
}

async function handleSubmit() {
  if (!validateForm()) return

  try {
    loading.value = true

    const response = await axios.post('/api/forgot-password', {
      email: email.value,
    })

    message.value = response.data.message
    alert.show(message.value, 'success')
    email.value = ''
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
    loading.value = false
  }
}
</script>

<template>
  <div class="flex flex-col min-h-screen">
    <header class="px-6">
      <div class="max-w-7xl mx-auto flex justify-between items-center py-4">
        <h1 class="text-2xl font-bold">Help Desk</h1>
        <nav class="flex">
          <RouterLink
            to="/"
            class="rounded-full hover:bg-black px-4 py-3 text-black hover:text-white border border-black"
          >
            Voltar
          </RouterLink>
        </nav>
      </div>
    </header>

    <main class="flex-grow flex justify-center items-center px-6">
      <div class="w-full sm:max-w-sm">
        <h2 class="text-center text-2xl font-bold mb-2">Esqueceu sua senha?</h2>
        <h3 class="text-center text-sm mb-10">
          Digite seu endereço de e-mail e enviaremos instruções para redefinir sua senha.
        </h3>
        <form class="space-y-6" @submit.prevent="handleSubmit">
          <div>
            <InputBase
              id="email"
              label="E-mail"
              type="email"
              placeholder="Digite seu e-mail"
              v-model="email"
            />
          </div>

          <RoundedButton class="w-full" type="submit" :disabled="loading">
            {{ loading ? 'Enviando email de recuperação...' : 'Recuperar senha' }}
          </RoundedButton>
        </form>
      </div>
    </main>
  </div>
</template>
