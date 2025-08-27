<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'
import InputBase from '@/components/inputs/InputBase.vue'
import RoundedButton from '@/components/buttons/RoundedButton.vue'

const email = ref('')

const message = ref('') 
const errors = ref<Record<string, string[]>>({});

const route = useRoute()

onMounted(() => {
  if (route.query.verified === 'true') {
    message.value = 'Seu e-mail foi verificado com sucesso! Por favor, faça o login.'
  }
})

function validateForm() {
  errors.value = {};

  if (!email.value) {
    errors.value.email = ['O e-mail é obrigatório.']
  }

  return Object.keys(errors.value).length === 0
}

async function handleSubmit() {
  if (!validateForm()) return

  try {
    await axios.post('/forgot-password', {
      email: email.value,
    })
  }  catch (err: any) {
    errors.value = err.response?.data?.message || 'Ocorreu um erro.';
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
          :required="true"
          :error-message="errors.email ? errors.email[0] : ''"
        />
      </div>
      <RoundedButton type="submit">Recuperar Senha</RoundedButton>
      <p v-if="message" :class="{'text-green-600': !errors || Object.keys(errors).length === 0, 'text-red-600': errors && Object.keys(errors).length > 0}" class="mb-4 text-center">
        {{ message }}
      </p>
    </form>
  </div>
</template>