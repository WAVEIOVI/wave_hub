import axios from '@axios'
import { defineStore } from 'pinia'

export const useUserListStore = defineStore('UserListStore', {
  actions: {
    //SECTION User API CALL
    // 👉 Fetch Roles data
    fetchRoles()  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/roles/search`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchClients()  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/clients/search`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Client Contact API CALL 
  },
})
