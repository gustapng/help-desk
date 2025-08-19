<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import axios from 'axios'
import InputBase from '@/components/inputs/InputBase.vue'
import InputPassword from '@/components/inputs/InputPassword.vue'
import RoundedButton from '@/components/buttons/RoundedButton.vue'

const email = ref('')
const password = ref('')

const message = ref('') 
const errors = ref<Record<string, string[]>>({});

const router = useRouter()
const route = useRoute()

onMounted(() => {
  // Parâmetros de query sempre vêm como string, por isso a verificação === 'true'
  if (route.query.verified === 'true') {
    message.value = 'Seu e-mail foi verificado com sucesso! Por favor, faça o login.'
  }
})

function validateForm() {
  errors.value = {};

  if (!email.value) {
    errors.value.email = ['O e-mail é obrigatório.']
  }

  if (!password.value) {
    errors.value.password = ['A senha é obrigatória.']
  }

  return Object.keys(errors.value).length === 0
}

async function handleSubmit() {
  if (!validateForm()) return

  try {
    await axios.get('/sanctum/csrf-cookie')

    await axios.post('/login', {
      email: email.value,
      password: password.value,
    })

    router.push('/dashboard')
  } catch (error: any) {
    if (error.response) {
      if (error.response.status === 422) {
        errors.value = error.response.data.errors || {}
        message.value = error.response.data.message || 'Erro de validação.'
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

<template>
  <header class="py-5">
    <RouterLink to="/"
      class="rounded-full bg-primaryColor hover:bg-black p-3 text-black hover:text-white border border-black">
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
          :required="true"
          :error-message="errors.email ? errors.email[0] : ''"
        />
      </div>
      <div class="mb-6">
        <InputPassword
          id="password"
          label="Senha"
          type="password"
          placeholder="Digite sua senha"
          v-model="password"
          :required="true"
          :error-message="errors.password ? errors.password[0] : ''"
        />
      </div>
      <RoundedButton type="submit">Fazer Login</RoundedButton>
      <p v-if="message" :class="{'text-green-600': !errors || Object.keys(errors).length === 0, 'text-red-600': errors && Object.keys(errors).length > 0}" class="mb-4 text-center">
        {{ message }}
      </p>
    </form>
  </div>
</template>
