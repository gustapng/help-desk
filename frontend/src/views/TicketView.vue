<script setup lang="ts">
import {
  Listbox,
  ListboxButton,
  ListboxLabel,
  ListboxOption,
  ListboxOptions,
} from '@headlessui/vue'
import {
  Plus,
  Ticket,
  ChevronsUpDown,
  Check,
  CircleEllipsis,
  CircleAlert,
  Wrench,
  CircleQuestionMark,
  Lightbulb,
  ShieldAlert,
  Folder,
} from 'lucide-vue-next'
import { ref } from 'vue'

import BaseModal from '@/components/BaseModal.vue'
import RoundedButton from '@/components/buttons/RoundedButton.vue'
import Sidebar from '@/components/Sidebar.vue'

const ticketType = [
  {
    id: 0,
    name: 'Selecione',
    icon: CircleEllipsis,
  },
  {
    id: 1,
    name: 'Problema Técnico',
    icon: CircleAlert,
  },
  {
    id: 2,
    name: 'Solicitação de Serviço',
    icon: Wrench,
  },
  {
    id: 3,
    name: 'Dúvida / Suporte',
    icon: CircleQuestionMark,
  },
  {
    id: 4,
    name: 'Melhoria / Sugestão',
    icon: Lightbulb,
  },
  {
    id: 5,
    name: 'Incidente de Segurança',
    icon: ShieldAlert,
  },
  {
    id: 6,
    name: 'Outro',
    icon: Folder,
  },
]
const selected = ref(ticketType[0])

const priorities = [
  {
    id: 1,
    label: 'Baixa',
    classes: 'bg-green-100 border-green-300 text-green-800',
    dotClass: 'bg-green-400',
  },
  {
    id: 2,
    label: 'Média',
    classes: 'bg-yellow-100 border-yellow-300 text-yellow-800',
    dotClass: 'bg-yellow-400',
  },
  {
    id: 3,
    label: 'Alta',
    classes: 'bg-red-100 border-red-300 text-red-800',
    dotClass: 'bg-red-400',
  },
]
const selectedPriority = ref<number | null>(null)

function selectPriority(id: number) {
  selectedPriority.value = id
}

const isModalOpen = ref(false)

function handleCreateTicket() {
  isModalOpen.value = false
}
</script>

<template>
  <Sidebar></Sidebar>
  <div class="p-4 sm:ml-64">
    <div class="flex items-center place-content-between">
      <h1>Ticket</h1>
      <RoundedButton class="flex items-center" @click="isModalOpen = true">
        <Plus class="mr-2"></Plus>
        Criar Ticket
      </RoundedButton>
    </div>
    <BaseModal :show="isModalOpen" title="Criar Novo Ticket" size="lg" @close="isModalOpen = false">
      <template #icon>
        <div class="rounded-lg p-2 mr-2 bg-gray-100">
          <Ticket class="text-colorBlue"></Ticket>
        </div>
      </template>
      <form @submit.prevent="handleCreateTicket" class="space-y-4">
        <div class="flex">
          <div>
            <div class="col-span-full">
              <label for="about" class="block text-sm/6 font-medium">Descrição</label>
              <div class="mt-1">
                <textarea
                  name="about"
                  id="about"
                  rows="3"
                  class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base border border-gray-200 outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6"
                />
              </div>
            </div>
          </div>
          <div>
            <div>
              <label class="block text-sm/6 font-medium">Nome do Ticket</label>
              <div class="mt-1">
                <input
                  type="text"
                  name="street-address"
                  id="street-address"
                  autocomplete="street-address"
                  class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base border border-gray-200 outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6"
                />
              </div>
            </div>
            <div>
              <h2 class="mb-2 text-sm font-semibold text-gray-700">Prioridade</h2>
              <div class="flex items-center gap-2">
                <button
                  v-for="priority in priorities"
                  :key="priority.id"
                  type="button"
                  @click="selectPriority(priority.id)"
                  class="inline-flex items-center gap-x-2 rounded-md px-3 py-2 text-xs font-medium border transition-colors duration-200"
                  :class="[
                    selectedPriority === priority.id
                      ? priority.classes
                      : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-100 hover:border-gray-300',
                  ]"
                >
                  <span class="w-2 h-2 rounded-full" :class="priority.dotClass"></span>
                  {{ priority.label }}
                </button>
              </div>
            </div>
            <div>
              <Listbox as="div" v-model="selected">
                <ListboxLabel class="block text-sm/6 font-medium">Tipo de Ticket</ListboxLabel>
                <div class="relative mt-1">
                  <ListboxButton
                    class="grid w-full cursor-default grid-cols-1 rounded-md border border-gray-200 py-1.5 pr-2 pl-3 text-left text-white outline-1 -outline-offset-1 outline-white/10 focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-indigo-500 sm:text-sm/6"
                  >
                    <span class="col-start-1 row-start-1 flex items-center gap-3 pr-6">
                      <component :is="selected.icon" class="size-5 shrink-0 text-gray-400" />
                      <span class="block truncate text-black">{{ selected.name }}</span>
                    </span>
                    <ChevronsUpDown
                      class="col-start-1 row-start-1 size-5 self-center justify-self-end text-gray-400 sm:size-4"
                      aria-hidden="true"
                    />
                  </ListboxButton>

                  <transition
                    leave-active-class="transition ease-in duration-100"
                    leave-from-class=""
                    leave-to-class="opacity-0"
                  >
                    <ListboxOptions
                      class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base outline-1 -outline-offset-1 outline-white/10 sm:text-sm"
                    >
                      <ListboxOption
                        as="template"
                        v-for="ticket in ticketType"
                        :key="ticket.id"
                        :value="ticket"
                        v-slot="{ active, selected }"
                      >
                        <li
                          :class="[
                            active ? 'bg-colorBlue text-white outline-hidden' : 'text-white',
                            'relative cursor-default py-2 pr-9 pl-3 select-none',
                          ]"
                        >
                          <div class="flex items-center">
                            <component :is="ticket.icon" class="size-5 shrink-0 text-gray-400" />
                            <span
                              :class="[
                                selected ? 'font-semibold' : 'font-normal',
                                'ml-3 block truncate text-black',
                              ]"
                              >{{ ticket.name }}</span
                            >
                          </div>

                          <span
                            v-if="selected"
                            :class="[
                              active ? 'text-white' : 'text-colorBlue',
                              'absolute inset-y-0 right-0 flex items-center pr-4',
                            ]"
                          >
                            <Check class="size-5" aria-hidden="true" />
                          </span>
                        </li>
                      </ListboxOption>
                    </ListboxOptions>
                  </transition>
                </div>
              </Listbox>
            </div>
            <div class="flex justify-end gap-2">
              <button
                type="button"
                @click="isModalOpen = false"
                class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700"
              >
                Cancelar
              </button>
              <button
                type="submit"
                class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white"
              >
                Criar Ticket
              </button>
            </div>
          </div>
        </div>
      </form>
    </BaseModal>
    <router-view />
  </div>
</template>
