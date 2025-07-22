<template>
  <div>
    <label
      :for="id"
      class="block mb-2 text-sm font-medium text-black"
    >
      {{ label }}
    </label>
    <input
      :id="id"
      :type="type"
      class="bg-primaryColor border border-black text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
      :placeholder="placeholder"
      :value="modelValue"
      :required="required"
      @input="onInput"
    />
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
}

const {
  id,
  label,
  type,
  placeholder,
  modelValue,
  required
} = withDefaults(defineProps<Props>(), {
  type: 'text',
  placeholder: '',
  modelValue: '',
  required: false,
})

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void
}>()

function onInput(event: Event) {
  const target = event.target as HTMLInputElement
  emit('update:modelValue', target.value)
}
</script>
