import type { FunctionalComponent } from 'vue'

export interface TicketTypeOption {
  id: number
  title: string
  icon: FunctionalComponent
}

export interface TicketPriorityOption {
  id: number
  label: string
  classes: string
  dotClass: string
}

export interface TicketCreatePayload {
  title: string
  description: string
  type_id: number
  priority_id: number
}

export interface Ticket {
  id: number
  title: string
  description: string
  status: 'open' | 'in_progress' | 'close'
  created_at: string
  type_id: number
  priority_id: number
}
