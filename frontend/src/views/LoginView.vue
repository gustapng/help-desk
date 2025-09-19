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
  <header class="py-5">
    <RouterLink
      to="/"
      class="rounded-full bg-primaryColor hover:bg-black p-3 text-black hover:text-white border border-black"
    >
      Voltar
    </RouterLink>
  </header>

  <div>
    <form @submit.prevent="handleSubmit">
      <div class="mb-6">
        <InputBase
          id="email"
          label="E-mail"
          type="email"
          placeholder="Digite seu e-mail"
          v-model="email"
        />
      </div>
      <div class="mb-6">
        <InputPassword
          id="password"
          label="Senha"
          type="password"
          placeholder="Digite sua senha"
          v-model="password"
        />
      </div>
      <div class="flex justify-between">
        <RoundedButton type="submit" :disabled="loading">
          {{ loading ? 'Logando...' : 'Fazer Login' }}
        </RoundedButton>
        <RouterLink
          to="/forgot-password"
          class="text-sm text-black mb-6 hover:underline hover:underline-offset-8"
        >
          Esqueceu sua senha?
        </RouterLink>
      </div>
    </form>
  </div>
</template>
