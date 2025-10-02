import {
  CircleEllipsis,
  CircleAlert,
  Wrench,
  CircleQuestionMark,
  Lightbulb,
  ShieldAlert,
  Folder,
} from 'lucide-vue-next'

import type { TicketTypeOption, TicketPriorityOption } from '@/types/Ticket'

export const ticketTypes: TicketTypeOption[] = [
  { id: 0, title: 'Selecione', icon: CircleEllipsis },
  { id: 1, title: 'Problema Técnico', icon: CircleAlert },
  { id: 2, title: 'Solicitação de Serviço', icon: Wrench },
  { id: 3, title: 'Dúvida / Suporte', icon: CircleQuestionMark },
  { id: 4, title: 'Melhoria / Sugestão', icon: Lightbulb },
  { id: 5, title: 'Incidente de Segurança', icon: ShieldAlert },
  { id: 6, title: 'Outro', icon: Folder },
]

export const ticketPriorities: TicketPriorityOption[] = [
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
