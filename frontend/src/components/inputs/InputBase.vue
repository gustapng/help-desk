<template>
  <div>
    <label :for="id" class="block mb-2 text-sm font-medium">
      {{ label }}
    </label>
    <input
      :id="id"
      :type="type"
      :class="[
        'border border-black text-sm rounded-lg focus:ring-emerald-400 focus:border-emerald-400 block w-full p-2.5',
        inputClass,
      ]"
      :placeholder="placeholder"
      :value="modelValue"
      :required="required"
      @input="onInput"
    />
    <p v-if="errorMessage" class="mt-1 text-sm text-red-600">{{ errorMessage }}</p>
  </div>
</template>

<script setup lang="ts">
import { defineProps, defineEmits, withDefaults } from 'vue'

interface Props {
  id: string
  label: string
  type?: string
  placeholder?: string
  modelValue?: string
  required?: boolean
  errorMessage?: string
  inputClass?: string;
}

const { id, label, type, inputClass, placeholder, modelValue, required, errorMessage } = withDefaults(
  defineProps<Props>(),
  {
    type: 'text',
    inputClass: '', // <-- Defina um valor padrão
    placeholder: '',
    modelValue: '',
    required: false,
    errorMessage: '',
  }
)

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void
}>()

function onInput(event: Event) {
  const target = event.target as HTMLInputElement
  emit('update:modelValue', target.value)
}
</script>
