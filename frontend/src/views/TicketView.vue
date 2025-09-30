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
} from 'lucide-vue-next'
import { ref } from 'vue'

import type {
  TicketTypeOption,
  TicketPriorityOption,
  TicketCreatePayload,
} from '@/types/Ticket'

// 2. IMPORTE OS DADOS
import { ticketTypes, ticketPriorities } from '@/data/ticket-options'

import InputBase from '@/components/inputs/InputBase.vue'
import BaseModal from '@/components/BaseModal.vue'
import RoundedButton from '@/components/buttons/RoundedButton.vue'
import Sidebar from '@/components/Sidebar.vue'
import { useAlertStore } from '@/stores/alert'

const ticket_name = ref('')
const ticket_description = ref('')
const alert = useAlertStore()

const selectedTicketType = ref<TicketTypeOption>(ticketTypes[0])
const selectedTicketPriority = ref(<number | null>(null))

function selectTicketPriority(id: number) {
  selectedTicketPriority.value = id
}

const isModalOpen = ref(false)

function validateForm() {
  if (!ticket_description.value) {
    alert.show('O campo de descrição é obrigatório.', 'error')
    return false
  }

  if (!ticket_name.value) {
    alert.show('O campo de nome é obrigatório.', 'error')
    return false
  }

  if (!selectedTicketPriority.value) {
    alert.show('É obrigatório selecionar uma prioridade.', 'error')
    return false
  }

    if (selectedTicketType.value.id === 0) {
    alert.show('É obrigatório selecionar o tipo de ticket.', 'error')
    return false
  }

  return true
}

// TODO - confirm if this code snippet is necessary
function resetForm() {
  ticket_name.value = '';
  ticket_description.value = '';
  selectedTicketType.value = ticketTypes[0];
  selectedTicketPriority.value = null;
}

function handleCreateTicket() {
  if (!validateForm()) return

  const ticketPayload: TicketCreatePayload = {
    name: ticket_name.value,
    description: ticket_description.value,
    type_id: selectedTicketType.value.id,
    priority_id: selectedTicketPriority.value!, // O '!' diz ao TS que temos certeza que não é null aqui
  };

  console.log('Objeto que será enviado para a API:', ticketPayload);

  // 2. Chame a API com o payload limpo
  // try {
  //   await axios.post('/api/tickets', ticketPayload);
  //   alert.show('Ticket criado com sucesso!', 'success');
  //   closeModal(); // Fecha e reseta o formulário
  // } catch (error) {
  //   // ... tratamento de erro
  // }

  isModalOpen.value = false

  resetForm();
}
</script>

<template>
  <Sidebar></Sidebar>
  <div class="p-4 sm:ml-64">
    <div class="flex items-center place-content-between">
      <h1>Ticket</h1>
      <RoundedButton class="flex items-center text-white" @click="isModalOpen = true">
        <Plus class="mr-2"></Plus>
        Criar Ticket
      </RoundedButton>
    </div>
    <BaseModal :show="isModalOpen" title="Criar Novo Ticket" size="xl" @close="isModalOpen = false">
      <template #icon>
        <div class="rounded-lg p-2 mr-2 bg-gray-200">
          <Ticket class="text-sky-400"></Ticket>
        </div>
      </template>
      <form @submit.prevent="handleCreateTicket" class="space-y-4">
        <div class="flex space-x-6">
          <div class="flex flex-col w-full"> 
            <div class="col-span-full h-full flex flex-col">
              <label for="ticket_description" class="block mb-2 text-sm font-medium">Descrição</label>
              <div class="flex-grow"> 
                <textarea
                  name="ticket_description"
                  id="ticket_description"
                  v-model="ticket_description"
                  class="block h-full border border-gray-200 text-sm rounded-lg focus:ring-emerald-400 focus:border-emerald-400 w-full p-2.5 "
                />
              </div>
            </div>
          </div>
          <div class="space-y-6">
            <div>
              <InputBase
                id="ticket_name"
                label="Nome do Ticket"
                type="ticket_name"
                v-model="ticket_name"
                inputClass="border-gray-200" 
              />
            </div>
            <div>
              <h2 class="block mb-2 text-sm font-medium">Prioridade</h2>
              <div class="flex items-center gap-2">
                <button
                  v-for="priority in ticketPriorities"
                  :key="priority.id"
                  type="button"
                  name="ticket_priority"
                  id="ticket_priority"
                  @click="selectTicketPriority(priority.id)"
                  class="inline-flex items-center gap-x-2 rounded-lg px-3 py-2 text-xs font-medium border transition-colors duration-200"
                  :class="[
                    selectedTicketPriority === priority.id
                      ? priority.classes
                      : 'bg-white border-gray-200 text-gray-800 hover:bg-gray-100 hover:border-gray-300',
                  ]"
                >
                  <span class="w-2 h-2 rounded-full" :class="priority.dotClass"></span>
                  {{ priority.label }}
                </button>
              </div>
            </div>
            <div>
              <Listbox as="div" v-model="selectedTicketType">
                <ListboxLabel class="block mb-2 text-sm font-medium">Tipo de Ticket</ListboxLabel>
                <div class="relative">
                  <ListboxButton
                    class="grid border border-gray-200 text-sm rounded-lg focus:ring-emerald-400 focus:border-emerald-400 w-full p-2.5"
                  >
                    <span class="col-start-1 row-start-1 flex items-center gap-3 pr-6">
                      <component :is="selectedTicketType.icon" class="size-5 shrink-0 text-gray-800" />
                      <span class="block truncate text-black">{{ selectedTicketType.name }}</span>
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
                            active ? 'text-gray-800 bg-gray-200' : 'text-gray-500',
                            'relative cursor-default py-2 pr-9 pl-3 select-none',
                          ]"
                        >
                          <div class="flex items-center">
                            <component :is="ticket.icon" class="size-5 shrink-0 text-gray-800" />
                            <span
                              :class="[
                                selected ? 'font-semibold' : 'font-normal',
                                'ml-3 block truncate text-gray-800',
                              ]"
                              >{{ ticket.name }}</span
                            >
                          </div>

                          <span
                            v-if="selected"
                            :class="[
                              'absolute inset-y-0 right-0 flex items-center pr-4 text-gray-800',
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
            <div class="flex justify-between">
              <button
                type="button"
                @click="isModalOpen = false"
                class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800"
              >
                Cancelar
              </button>
              <button
                type="submit"
                class="px-4 py-2 rounded-lg bg-sky-400 hover:bg-sky-500 text-white"
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
