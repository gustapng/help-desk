<template>
  <div>
    <label :for="id" class="block mb-2 text-sm font-medium text-black">
      {{ label }}
    </label>
    <div class="relative">
      <input
        :id="id"
        :type="isVisible ? 'text' : 'password'"
        class="bg-primaryColor border border-black text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
        :placeholder="placeholder"
        :value="modelValue"
        :required="required"
        @input="onInput"
      />
      <button
        type="button"
        @click="toggleVisibility"
        class="absolute right-3 top-1/2 -translate-y-1/2"
        :aria-label="isVisible ? 'Esconder senha' : 'Mostrar senha'"
      >
        <component :is="isVisible ? EyeOff : Eye" class="w-5 h-5" />
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Eye, EyeOff } from 'lucide-vue-next'
import { defineProps, defineEmits, withDefaults } from 'vue'

interface Props {
  id: string
  label: string
  placeholder?: string
  modelValue?: string
  required?: boolean
}

const {
  id,
  label,
  placeholder,
  modelValue,
  required
} = withDefaults(defineProps<Props>(), {
  placeholder: '',
  modelValue: '',
  required: false,
})

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void
}>()

const isVisible = ref(false)

function toggleVisibility() {
  isVisible.value = !isVisible.value
}

function onInput(event: Event) {
  const target = event.target as HTMLInputElement
  emit('update:modelValue', target.value)
}
</script>
