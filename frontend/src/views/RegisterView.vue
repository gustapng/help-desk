<script setup lang="ts">
import { ref } from 'vue'
// import { useRouter } from 'vue-router'
import axios from 'axios'
import InputBase from '@/components/inputs/InputBase.vue'
import InputPassword from '@/components/inputs/InputPassword.vue'
import RoundedButton from '@/components/buttons/RoundedButton.vue'

const name = ref('')
const secondaryName = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')

const message = ref('') // Mensagens de sucesso ou erro geral
const errors = ref(null) // Erros de validação retornados pelo Laravel

// const router = useRouter() // Instância do router para navegação

// --- Função de Envio do Formulário ---
async function handleSubmit() {
  message.value = '' // Limpa mensagens anteriores
  errors.value = null // Limpa erros anteriores

  // --- Validação Frontend Simples (Opcional) ---
  if (password.value !== password_confirmation.value) {
    errors.value = { password_confirmation: ['As senhas não coincidem.'] }
    return // Interrompe o envio se as senhas não baterem
  }

  try {
    await axios.get('/sanctum/csrf-cookie')
  } catch {
    console.log("error")
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
          <InputBase id="secodaryName" label="Sobrenome" type="text" placeholder="Digite seu sobrenome"
            v-model="secondaryName" />
        </div>
        <div class="mb-6">
          <InputBase id="email" label="E-mail" type="email" placeholder="Digite seu e-mail" v-model="email"
            :required=true />
        </div>
        <div class="mb-6">
          <InputPassword id="senha" label="Senha" type="password" placeholder="Digite sua senha" v-model="password"
            :required=true />
        </div>
        <div class="mb-6">
          <InputPassword id="password_confirmation" label="Confirmar senha" type="password"
            placeholder="Confirme sua senha" v-model="password_confirmation" :required=true />
        </div>
        <RoundedButton type="submit">Cadastrar</RoundedButton>
      </form>
    </div>
  </div>
</template>