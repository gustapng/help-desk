import axios from 'axios'
import { defineStore } from 'pinia'

interface User {
  id: number
  name: string
  email: string
}

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null as User | null,
  }),

  getters: {
    isAuthenticated: (state) => !!state.user,
  },

  actions: {
    async checkAuth() {
      if (this.user) return

      try {
        const response = await axios.get('/user')
        this.user = response.data
      } catch {
        this.user = null
      }
    },
  },
})
