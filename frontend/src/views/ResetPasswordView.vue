<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import InputBase from '@/components/inputs/InputBase.vue'
import RoundedButton from '@/components/buttons/RoundedButton.vue'

const route = useRoute();
const router = useRouter();

const token = ref('');
const email = ref('');
const password = ref('');
const password_confirmation = ref('');

const message = ref('');
const errors = ref<Record<string, string[]>>({});

// Pega o token e o email da URL quando o componente é montado
onMounted(() => {
  token.value = route.query.token as string;
  email.value = route.query.email as string;
});

function validateForm() {
  errors.value = {};

  if (!password.value) {
    errors.value.password = ['A senha é obrigatória.']
  }

  if (!password_confirmation.value) {
    errors.value.password_confirmation = ['A confirmação de senha é obrigatória.']
  }

  return Object.keys(errors.value).length === 0
}


async function handleResetPassword() {
  message.value = '';

  if (!validateForm()) return

  try {
    const response = await axios.post('/api/reset-password', {
      token: token.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value,
    });
    message.value = response.data.message;
    // Redireciona para o login após sucesso
    setTimeout(() => {
      router.push('/login');
    }, 2000);
  } catch (err: any) {
    errors.value = err.response?.data?.message || 'Ocorreu um erro.';
  }
}
</script>

<template>
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

      <RoundedButton type="submit">Redefinir senha</RoundedButton>
    </form>
  </div>
</template>