<script setup lang="ts">
import { ref } from 'vue'
import InputBase from '@/components/inputs/InputBase.vue'
import InputPassword from '@/components/inputs/InputPassword.vue'
import RoundedButton from './buttons/RoundedButton.vue'

const email = ref('')
const password = ref('')

const errors = ref<Record<string, string[]>>({});
</script>

<template>
    <div class="header">
        <header class="py-5 flex justify-between items-center">
            <nav>
                <RouterLink 
                    to="/register" 
                    class="rounded-full bg-primaryColor hover:bg-black p-3 text-black hover:text-white border border-black inline-block">
                    Demonstração
                </RouterLink>
            </nav>
            <div class="flex items-center space-x-4">
                <InputBase
                    id="email"
                    label="E-mail"
                    type="email"
                    placeholder="Digite seu e-mail"
                    v-model="email"
                    :required="true"
                    :error-message="errors.email ? errors.email[0] : ''"
                    class="w-full"
                />
                <InputPassword
                    id="password"
                    label="Senha"
                    type="password"
                    placeholder="Digite sua senha"
                    v-model="password"
                    :required="true"
                    :error-message="errors.password ? errors.password[0] : ''"
                    class="w-full"
                />
                <RoundedButton type="submit">Login</RoundedButton>
            </div>
        </header>
    </div>
</template>