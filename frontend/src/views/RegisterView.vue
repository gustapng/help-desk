<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import InputBase from '@/components/inputs/InputBase.vue'
import InputPassword from '@/components/inputs/InputPassword.vue'
import RoundedButton from '@/components/buttons/RoundedButton.vue'

const name = ref('')
const secondaryName = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')

const message = ref('') 
const errors = ref<Record<string, string[]>>({});

const router = useRouter()

function validateForm() {
  errors.value = {};

  if (!name.value) {
    errors.value.name = ['O nome é obrigatório.']
  }

  if (!email.value) {
    errors.value.email = ['O e-mail é obrigatório.']
  }

  if (!password.value) {
    errors.value.password = ['A senha é obrigatória.']
  }

  if (!password_confirmation.value) {
    errors.value.password_confirmation = ['A confirmação de senha é obrigatória.']
  }

  const hasPasswordError = !!errors.value.password
  const hasPasswordConfirmationError = !!errors.value.password_confirmation

  if (!hasPasswordError && !hasPasswordConfirmationError && password.value !== password_confirmation.value) {
    errors.value.password_confirmation = ['As senhas não coincidem.']
  }

  return Object.keys(errors.value).length === 0
}

async function handleSubmit() {
  if (!validateForm()) return

  try {
    await axios.post('/register', {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value,
    })

    message.value = 'Cadastro realizado com sucesso!'
    router.push('/')
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
          <InputBase id="name" label="Nome" type="text" placeholder="Digite seu nome" v-model="name" :required=true />
          <InputBase id="secondaryName" label="Sobrenome" type="text" placeholder="Digite seu sobrenome" v-model="secondaryName" :required=true />
        </div>
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
        <div class="mb-6">
          <InputPassword
            id="password_confirmation"
            label="Confirmar Senha"
            type="password"
            placeholder="Confirme sua senha"
            v-model="password_confirmation"
            :required="true"
            :error-message="errors.password_confirmation ? errors.password_confirmation[0] : ''"
          />
        </div>

        <p v-if="message" :class="{'text-green-600': !errors || Object.keys(errors).length === 0, 'text-red-600': errors && Object.keys(errors).length > 0}" class="mb-4 text-center">
          {{ message }}
        </p>

        <RoundedButton type="submit">Cadastrar</RoundedButton>
      </form>
    </div>
  </div>
</template>