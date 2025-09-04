<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useAlertStore } from '@/stores/alert'
import axios from 'axios';
import InputPassword from '@/components/inputs/InputPassword.vue'
import RoundedButton from '@/components/buttons/RoundedButton.vue'

const route = useRoute();
const router = useRouter();

const token = ref('');
const email = ref('');
const password = ref('');
const password_confirmation = ref('');
const loading = ref(false)
const alert = useAlertStore()
const message = ref('');

// Pega o token e o email da URL quando o componente é montado
onMounted(() => {
  token.value = route.query.token as string;
  email.value = route.query.email as string;
});

function validateForm() {
  if (!password.value) {
    alert.show('O campo de senha é obrigatório.', 'error')
    return false
  }

  if (!password_confirmation.value) {
    alert.show('O campo de confirmação de senha é obrigatório.', 'error')
    return false
  }

  if (password.value !== password_confirmation.value) {
    alert.show('Os campo de senhas não coincidem.', 'error')
    return false
  }

  return true
}

async function handleResetPassword() {
  message.value = '';
  if (!validateForm()) return

  try {
    loading.value = true

    const response = await axios.post('/api/reset-password', {
      token: token.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value,
    });

    message.value = response.data.message;
    alert.show(message.value, 'success')
    router.push('/login');
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
    <RouterLink to="/"
      class="rounded-full bg-primaryColor hover:bg-black p-3 text-black hover:text-white border border-black">
      Voltar
    </RouterLink>
  </header>

  <div>
    <h2>Redefina sua Senha</h2>
    <form @submit.prevent="handleResetPassword">
      <input type="hidden" v-model="email" />
      
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
        {{ loading ? 'Redefinindo senha...' : 'Redefinir senha' }}
      </RoundedButton>
    </form>
  </div>
</template>