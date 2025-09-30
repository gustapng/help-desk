import type { FunctionalComponent } from 'vue';

// Interface para as OPÇÕES de tipo de ticket (usado no Listbox)
export interface TicketTypeOption {
  id: number;
  name: string;
  icon: FunctionalComponent; // Tipo mais específico para componentes de ícone
}

// Interface para as OPÇÕES de prioridade (usado no RadioGroup)
export interface TicketPriorityOption {
  id: number;
  label: string;
  classes: string;
  dotClass: string;
}

export interface TicketCreatePayload {
  name: string;
  description: string;
  type_id: number;
  priority_id: number;
}

// Interface para o TICKET que RECEBEMOS da API
export interface Ticket {
  id: number;
  ticket_name: string;
  ticket_description: string;
  status: 'aberto' | 'em_andamento' | 'fechado';
  created_at: string;
  // A API nos devolverá os IDs
  type_id: number;
  priority_id: number;
}