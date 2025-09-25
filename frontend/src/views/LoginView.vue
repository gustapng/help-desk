<script setup lang="ts">
import axios from 'axios'
import type { AxiosError } from 'axios'
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'

import RoundedButton from '@/components/buttons/RoundedButton.vue'
import InputBase from '@/components/inputs/InputBase.vue'
import InputPassword from '@/components/inputs/InputPassword.vue'
import { useAlertStore } from '@/stores/alert'
import { useAuthStore } from '@/stores/auth'

const email = ref('')
const password = ref('')
const message = ref('')
const loading = ref(false)
const alert = useAlertStore()
const route = useRoute()
const router = useRouter()

onMounted(() => {
  const verified = route.query.verified

  if (verified === 'true') {
    alert.show('Seu e-mail foi verificado com sucesso! Por favor, faça o login.', 'success')
  } else if (verified === 'not_found') {
    alert.show('Seu usuário não foi encontrado.', 'error')
  } else if (verified === 'invalid') {
    alert.show('Seu link de verificação é inválido.', 'error')
  }

  if (verified) {
    router.replace({ query: { ...route.query, verified: undefined } })
  }
})

function validateForm() {
  if (!email.value) {
    alert.show('O campo de e-mail é obrigatório.', 'error')
    return false
  }

  if (!password.value) {
    alert.show('O campo de senha é obrigatório.', 'error')
    return false
  }

  return true
}

async function handleSubmit() {
  if (!validateForm()) return

  try {
    loading.value = true

    await axios.post('/login', {
      email: email.value,
      password: password.value,
    })

    const authStore = useAuthStore()
    await authStore.checkAuth()

    router.push('/dashboard')
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
            class="rounded-full bg-primaryColor hover:bg-black px-4 py-3 text-black hover:text-white border border-black"
          >
            Voltar
          </RouterLink>
        </nav>
      </div>
    </header>

    <main class="flex-grow flex justify-center items-center px-6">
      <div class="w-full sm:max-w-sm">
        <h2 class="text-center text-2xl font-bold mb-10">Entre na sua conta</h2>
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
          <div>
            <InputPassword
              id="password"
              label="Senha"
              type="password"
              placeholder="Digite sua senha"
              v-model="password"
            />
          </div>
          <div class="flex justify-end">
            <RouterLink
              to="/forgot-password"
              class="text-sm font-semibold text-emerald-400 mb-6 hover:underline hover:underline-offset-8"
            >
              Esqueceu sua senha?
            </RouterLink>
          </div>
          <RoundedButton class="w-full justify-center" type="submit" :disabled="loading">
            {{ loading ? 'Logando...' : 'Fazer Login' }}
          </RoundedButton>
          <p class="mt-10 text-center text-sm">
            Não é membro?
            <a href="/register" class="font-semibold text-emerald-400 hover:text-emerald-300 hover:underline hover:underline-offset-8">
              Registre-se agora
            </a>
          </p>
        </form>
      </div>
    </main>
  </div>
</template>