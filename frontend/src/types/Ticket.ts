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

export interface PaginationLink {
  url: string | null
  label: string
  active: boolean
}

export interface Pagination<T> {
  current_page: number
  data: T[]
  first_page_url: string
  from: number
  last_page: number
  last_page_url: string
  links: PaginationLink[]
  next_page_url: string | null
  path: string
  per_page: number
  prev_page_url: string | null
  to: number
  total: number
}
