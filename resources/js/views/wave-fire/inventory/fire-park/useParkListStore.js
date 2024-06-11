import axios from '@axios'
import { defineStore } from 'pinia'

export const useParkListStore = defineStore('ParkListStore', {
  actions: {
    //SECTION Options 
    // 👉 Fetch clients data
    fetchClients()  {      
      return new Promise((resolve, reject) => {
        axios
          .get('/api/clients')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    // 👉 Fetch Client Addresses
    fetchClientAddresses(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/client/${id}/addresses`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION

    //SECTION Park API CALL
    // 👉 Fetch parks data
    fetchParks(params)  {
      const filters = []
      if (params.type) {
        filters.push({ field: 'park_type', operator: '=', value: params.type })
      }
      if (params.client) {
        filters.push({ field: 'client_name', operator: '=', value: params.client })
      }
      if (params.city) {
        filters.push({ field: 'park_city', operator: '=', value: params.city })
      }
      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/parks/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
            filters,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single park
    fetchPark(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/parks/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Park
    addPark(parkData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/parks', parkData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update park
    updatePark(id, parkData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/parks/${id}`, parkData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Park
    deletePark(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/parks/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },   

    //!SECTION Park API CALL
    
    //SECTION Park Area API CALL
    // 👉 Fetch Park Areas
    fetchParkAreas(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/park/${id}/areas`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Park Area
    fetchParkArea(id, areaId) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/park/${id}/areas/${areaId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Park Area
    addParkArea(id, areaData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/park/${id}/areas`, areaData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },  
    
    // 👉 Update Park Area
    updateParkArea(id, areaId, areaData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/park/${id}/areas/${areaId}`, areaData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Park Area
    deleteParkArea(id, areaId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/park/${id}/areas/${areaId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Park Area API CALL 
    
    //SECTION Park Equipment API CALL
    // 👉 Fetch Park Equipments
    fetchParkEquipments(params) {
      const filters = []
      if (params.category) {
        filters.push({ field: 'equipment_category', operator: '=', value: params.category })
      }
      if (params.model) {
        filters.push({ field: 'equipment_model', operator: '=', value: params.model })
      }
      if (params.status) {
        filters.push({ field: 'equipment_status', operator: '=', value: params.status })
      }
      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/park/${params.id}/equipment/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
            filters,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Park Equipment
    fetchParkEquipment(id, equipmentId) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/park/${id}/equipment/${equipmentId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Park Equipment
    addParkEquipment(id, equipmentData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/park/${id}/equipment`, equipmentData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },  
    
    // 👉 Update Park Equipment
    updateParkEquipment(id, equipmentId, equipmentData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/park/${id}/equipment/${equipmentId}`, equipmentData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Park Equipment
    deleteParkEquipment(id, equipmentId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/park/${id}/equipment/${equipmentId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Park Equipment API CALL 
    // 👉 Add New Accessories
    addNewAccessories(id, accessories) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/equipment/${id}/accessories/batch`, {
            resources: accessories,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // fetchEquipmentAccessories(id) {
    //   return new Promise((resolve, reject) => {
    //     axios
    //       .get(`/api/equipment/${id}/accessories`)
    //       .then(response => resolve(response))
    //       .catch(error => reject(error))
    //   })
    // },

    // 👉 Fetch Accessories data
    fetchEquipmentAccessories(params)  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/equipment/${params.id}/accessories/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Accessory
    deleteAccessory(equipmentId, accessoryId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/equipment/${equipmentId}/accessories/${accessoryId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
  },
})
