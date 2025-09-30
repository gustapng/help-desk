<script setup lang="ts">
import axios from 'axios'
import type { AxiosError } from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

import RoundedButton from '@/components/buttons/RoundedButton.vue'
import InputBase from '@/components/inputs/InputBase.vue'
import InputPassword from '@/components/inputs/InputPassword.vue'
import { useAlertStore } from '@/stores/alert'

const name = ref('')
const secondaryName = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')
const message = ref('')
const loading = ref(false)
const alert = useAlertStore()
const router = useRouter()

function validateForm() {
  if (!name.value) {
    alert.show('O campo de nome é obrigatório.', 'error')
    return false
  }

  if (!password.value) {
    alert.show('O campo de senha é obrigatório.', 'error')
    return false
  }

  if (!password_confirmation.value) {
    alert.show('O campo de confirmação de senha é obrigatório.', 'error')
    return false
  }

  if (!email.value) {
    alert.show('O campo de e-mail é obrigatório.', 'error')
    return false
  }

  if (password.value !== password_confirmation.value) {
    alert.show('Os campo de senhas não coincidem.', 'error')
    return false
  }

  return true
}

async function handleSubmit() {
  message.value = ''
  if (!validateForm()) return

  try {
    loading.value = true

    const response = await axios.post('/api/register', {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value,
    })

    message.value = response.data.message
    alert.show(message.value, 'success')
    router.push('/login')
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
        <h2 class="text-center text-2xl font-bold mb-10">Registre-se agora</h2>
        <form class="space-y-6" @submit.prevent="handleSubmit">
          <div class="grid gap-6 md:grid-cols-2">
            <InputBase
              id="name"
              label="Nome"
              type="text"
              placeholder="Digite seu nome"
              v-model="name"
            />
            <InputBase
              id="secondaryName"
              label="Sobrenome"
              type="text"
              placeholder="Digite seu sobrenome"
              v-model="secondaryName"
            />
          </div>
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
          <div>
            <InputPassword
              id="password_confirmation"
              label="Confirmar Senha"
              type="password"
              placeholder="Confirme sua senha"
              v-model="password_confirmation"
            />
          </div>

          <RoundedButton class="w-full justify-center" type="submit" :disabled="loading">
            {{ loading ? 'Cadastrando...' : 'Cadastrar' }}
          </RoundedButton>
          <p class="mt-10 text-center text-sm">
            Já é membro?
            <a href="/login" class="font-semibold text-emerald-400 hover:text-emerald-300 hover:underline hover:underline-offset-8">
              Faça login agora
            </a>
          </p>
        </form>
      </div>
    </main>
  </div>
</template>
