<template>
  <div>
    <label :for="id" class="block mb-2 text-sm font-medium text-black">{{ label }}</label>
    <div class="relative">
        <input
            :id="id"
            :type="isVisible ? 'text' : 'password'"
            class="bg-primaryColor border border-black text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
            :placeholder="placeholder"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            :required="required"
        />
        <button type="button" @click="isVisible = !isVisible" class="absolute right-3 top-1/2 -translate-y-1/2">
            <component :is="isVisible ? EyeOff : Eye" class="w-5 h-5" />
        </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Eye, EyeOff } from 'lucide-vue-next'

defineProps({
  id: String,
  label: String,
  placeholder: String,
  modelValue: String,
  required: {
    type: Boolean,
    default: false
  }
})

defineEmits(['update:modelValue'])

const isVisible = ref(false)
</script>
