import axios from '@axios'
import { defineStore } from 'pinia'

export const useClientListStore = defineStore('ClientListStore', {
  actions: {
    //SECTION Client API CALL
    // 👉 Fetch clients data
    fetchClients(params)  {
      const filters = []
      if (params.type) {
        filters.push({ field: 'client_type', operator: '=', value: params.type })
      }
      if (params.activity) {
        filters.push({ field: 'client_activity', operator: '=', value: params.activity })
      }
      if (params.status) {
        filters.push({ field: 'client_status', operator: '=', value: params.status })
      }
      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/clients/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
            filters,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single client
    fetchClient(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/clients/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Client
    addClient(clientData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/clients', clientData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update client
    updateClient(id, clientData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/clients/${id}`, clientData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Client
    deleteClient(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/clients/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },   

    //!SECTION Client API CALL
    
    //SECTION Client Address API CALL
    // 👉 Fetch Client Addresses
    fetchClientAddresses(params) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/client/${params.id}/addresses/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Client Address
    fetchClientAddress(id, addressId) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/client/${id}/addresses/${addressId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Client Address
    addClientAddress(id, addressData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/client/${id}/addresses`, addressData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },  
    
    // 👉 Update Client Address
    updateClientAddress(id, addressId, addressData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/client/${id}/addresses/${addressId}`, addressData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Client Address
    deleteClientAddress(id, addressId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/client/${id}/addresses/${addressId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Client Address API CALL 
    
    //SECTION Client Contact API CALL
    // 👉 Fetch Client Contacts
    fetchClientContacts(params) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/client/${params.id}/contacts/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Client Contact
    fetchClientContact(id, contactId) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/client/${id}/contacts/${contactId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Client Contact
    addClientContact(id, contactData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/client/${id}/contacts`, contactData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },  
    
    // 👉 Update Client Contact
    updateClientContact(id, contactId, contactData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/client/${id}/contacts/${contactId}`, contactData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Client Contact
    deleteClientContact(id, contactId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/client/${id}/contacts/${contactId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Client Contact API CALL 
  },
})
