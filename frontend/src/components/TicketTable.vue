<script setup lang="ts">
import type { Ticket, TicketTypeOption, TicketPriorityOption } from '@/types/Ticket'

const props = defineProps<{
  tickets: Ticket[]
  ticketTypes: TicketTypeOption[]
  ticketPriorities: TicketPriorityOption[]
}>()

function getPriorityInfo(priorityId: number): TicketPriorityOption | undefined {
  return props.ticketPriorities.find((p) => p.id === priorityId)
}

function getTypeInfo(typeId: number): TicketTypeOption | undefined {
  return props.ticketTypes.find((t) => t.id === typeId)
}
</script>

<template>
  <div class="relative overflow-x-auto rounded-lg mt-2 text-gray-800 border border-gray-200">
    <table class="w-full text-sm text-left">
      <thead class="text-xs uppercase">
        <tr>
          <th scope="col" class="px-6 py-3 w-[40px]">
            <input class="accent-sky-400" type="checkbox" />
          </th>
          <th scope="col" class="px-6 py-3 border-x border-gray-200 w-[40px]">Ticket ID</th>
          <th scope="col" class="px-6 py-3 border-x border-gray-200">Título</th>
          <th scope="col" class="px-6 py-3 border-x border-gray-200 w-[40px]">Prioridade</th>
          <th scope="col" class="px-6 py-3 border-x border-gray-200">Tipo</th>
          <th scope="col" class="px-6 py-3 w-[40px]">Ação</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="ticket in tickets"
          :key="ticket.id"
          class="bg-white border-b border-gray-200 hover:bg-gray-100"
        >
          <td class="px-6 py-3 border-t border-gray-200">
            <input class="accent-sky-400" type="checkbox" />
          </td>
          <td class="px-6 py-3 border border-gray-200">#TKT-{{ ticket.id }}</td>
          <td class="px-6 py-3 border border-gray-200">
            {{ ticket.title }}
          </td>
          <td class="px-6 py-3 border border-gray-200">
            <button
              v-if="getPriorityInfo(ticket.priority_id)"
              type="button"
              class="inline-flex items-center gap-x-2 rounded-lg px-3 py-2 text-xs font-medium border"
              :class="getPriorityInfo(ticket.priority_id)?.classes"
            >
              <span
                class="w-2 h-2 rounded-full"
                :class="getPriorityInfo(ticket.priority_id)?.dotClass"
              ></span>
              {{ getPriorityInfo(ticket.priority_id)?.label }}
            </button>
          </td>
          <td class="px-6 py-3 border border-gray-200">
            <div v-if="getTypeInfo(ticket.type_id)" class="flex items-center">
              <component
                :is="getTypeInfo(ticket.type_id)!.icon"
                class="size-5 shrink-0 text-gray-800"
              />
              <span class="font-normal ml-2 block truncate text-gray-800">{{
                getTypeInfo(ticket.type_id)!.title
              }}</span>
            </div>
          </td>
          <td class="px-6 py-3 border-t border-gray-200">
            <a href="#" class="font-medium text-sky-400 hover:underline">Editar</a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
