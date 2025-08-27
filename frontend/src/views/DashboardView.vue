<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import RoundedButton from '@/components/buttons/RoundedButton.vue'

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

<template>
  <p>dashboard logado</p>
  <div>
    <form @submit.prevent="handleSubmit">
      <p v-if="message" :class="{'text-green-600': !errors || Object.keys(errors).length === 0, 'text-red-600': errors && Object.keys(errors).length > 0}" class="mb-4 text-center">
          {{ message }}
        </p>

        <RoundedButton type="submit">Sair</RoundedButton>
    </form>
  </div>
</template>
