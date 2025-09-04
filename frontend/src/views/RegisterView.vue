<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import { useAlertStore } from '@/stores/alert'
import InputBase from '@/components/inputs/InputBase.vue'
import InputPassword from '@/components/inputs/InputPassword.vue'
import RoundedButton from '@/components/buttons/RoundedButton.vue'

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
  message.value = '';
  if (!validateForm()) return

  try {
    loading.value = true

    const response = await axios.post('/api/register', {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value,
    })

    message.value = response.data.message;
    alert.show(message.value, 'success')
    router.push('/')
  } catch (error: any) {
    if (error.response) {
      if (error.response.status === 422) {
        message.value = error.response.data.message || 'Erro de validação.'
      } 
      else {
        message.value = error.response.data.message || 'Ocorreu um erro no servidor.'
      }
    } else {
      message.value = 'Erro de conexão. Verifique sua internet e tente novamente.'
    }
    alert.show(message.value, 'error');
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="register">
    <header class="py-5">
      <RouterLink to="/"
        class="rounded-full bg-primaryColor hover:bg-black p-3 text-black hover:text-white border border-black">
        Voltar
      </RouterLink>
    </header>

    <div>
      <form @submit.prevent="handleSubmit">
        <div class="grid gap-6 mb-6 md:grid-cols-2">
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
        <div class="mb-6">
          <InputPassword
            id="password_confirmation"
            label="Confirmar Senha"
            type="password"
            placeholder="Confirme sua senha"
            v-model="password_confirmation"
          />
        </div>

        <RoundedButton type="submit" :disabled="loading">
          {{ loading ? 'Cadastrando...' : 'Cadastrar' }}
        </RoundedButton>
      </form>
    </div>
  </div>
</template>