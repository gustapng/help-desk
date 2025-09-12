<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAlertStore } from '@/stores/alert'
import axios from 'axios'
import InputBase from '@/components/inputs/InputBase.vue'
import RoundedButton from '@/components/buttons/RoundedButton.vue'

const email = ref('')

const message = ref('') 
const loading = ref(false)
const alert = useAlertStore()
const route = useRoute()
const router = useRouter()

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

    message.value = response.data.message;
    alert.show(message.value, 'success')
    email.value = ''
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
  <header class="py-5">
    <RouterLink to="/login"
      class="rounded-full bg-primaryColor hover:bg-black p-3 text-black hover:text-white border border-black">
      Voltar
    </RouterLink>
  </header>

  <div>
    <div class="text-center">
      <h1>Esqueceu sua senha?</h1>
      <h2>Digite seu endereço de e-mail e enviaremos instruções para redefinir sua senha.</h2>
    </div>
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

      <RoundedButton type="submit" :disabled="loading">
        {{ loading ? 'Enviando email de recuperação...' : 'Recuperar senha' }}
      </RoundedButton>
    </form>
  </div>
</template>