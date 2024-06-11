import axios from '@axios'
import { defineStore } from 'pinia'

export const useUserStore = defineStore('user', {
  state: () => ({
    id: null,
    name: '',
    email: '',
    client_id: '',
    client_name: '',
    roles: [],
    permissions: [],
    isAuthenticated: false,
  }),
  actions: {
    async fetchUserData() {
      try {
        const response = await axios.get('/api/user')
        const userData = response.data

        // Update state with user data
        this.id = userData.id
        this.name = userData.name
        this.email = userData.email
        this.client_id = userData.client_id
        this.client_name = userData.client_name
        this.roles = userData.roles
        this.permissions = userData.permissions
        this.isAuthenticated = true // Mark user as authenticated
      } catch (error) {
        console.error('Error fetching user data:', error)
        this.isAuthenticated = false
      }
    },
  },
})
