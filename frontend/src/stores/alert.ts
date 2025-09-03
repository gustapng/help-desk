import { defineStore } from 'pinia'

export type AlertType = 'success' | 'error' | 'warning' | 'info'

export const useAlertStore = defineStore('alert', {
  state: () => ({
    message: '' as string,
    type: 'success' as AlertType,
    visible: false,
  }),
  actions: {
    show(msg: string, type: AlertType = 'success') {
      this.message = msg
      this.type = type
      this.visible = true

      setTimeout(() => this.hide(), 5000)
    },
    hide() {
      this.visible = false
      this.message = ''
    },
  },
})