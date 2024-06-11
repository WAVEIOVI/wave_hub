import axios from '@axios'
import { defineStore } from 'pinia'

export const useMetaStore = defineStore('MetaStore', {
  actions: {
    // 👉 Fetch clients data
    fetchClients()  {      
      return new Promise((resolve, reject) => {
        axios
          .get('/api/meta-clients')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Suppliers data
    fetchSuppliers()  {      
      return new Promise((resolve, reject) => {
        axios
          .get('/api/meta-suppliers')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Parks data
    fetchParks()  {      
      return new Promise((resolve, reject) => {
        axios
          .get('/api/parks')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Equipment data
    fetchEquipment()  {      
      return new Promise((resolve, reject) => {
        axios
          .get('/api/meta-equipment')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Park Equipment data
    fetchParkEquipment(id)  {      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/park/${id}/meta-equipment/search?limit=10000`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Mission Meta
    fetchMissions()  {      
      return new Promise((resolve, reject) => {
        axios
          .get('/api/meta-missions')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    // 👉 Fetch Interventions Meta
    fetchInterventions()  {      
      return new Promise((resolve, reject) => {
        axios
          .get('/api/meta-interventions')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Workshops Meta
    fetchWorkshops()  {      
      return new Promise((resolve, reject) => {
        axios
          .get('/api/meta-workshops')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
  },
})
