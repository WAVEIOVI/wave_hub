import axios from '@axios'
import { defineStore } from 'pinia'

export const useWorkshopListStore = defineStore('WorkshopListStore', {
  actions: {
    //SECTION Options 
    // 👉 Fetch clients
    fetchClients()  {      
      return new Promise((resolve, reject) => {
        axios
          .get('/api/clients')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    // 👉 Fetch Client Parks
    fetchClientParks(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/client/${id}/parks`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Technicians
    fetchTechnicians() {
      return new Promise((resolve, reject) => {
        axios
          .get('/api/technicians')
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

    // 👉 fetch single Park
    fetchPark(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/parks/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch workshops data
    fetchParkEquipments(params)  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/park/${params.id}/equipment/search`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Equipments data
    fetchEquipments(params)  {
      const filters = []

      filters.push({ field: 'client_id', operator: '=', value: params.client })
      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/equipment/search`, {
            search: { value: params.search },
            filters,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single park
    fetchEquipment(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/equipment/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION

    //SECTION Workshop API CALL
    
    // 👉 FetchInspected Equipments data
    fetchInspectedEquipments(params) {
      const filters = []
      if (params.category) {
        filters.push({ field: 'equipment_category', operator: '=', value: params.category })
      }
      if (params.model) {
        filters.push({ field: 'equipment_model', operator: '=', value: params.model })
      }
      if (params.status) {
        filters.push({ field: 'pivot.equipment_status', operator: '=', value: params.status })
      }
      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/workshops/${params.id}/equipment/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
            filters,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Workshop Equipments data
    fetchInspectedWorkshopEquipments(params) {
      const filters = []
      if (params.category) {
        filters.push({ field: 'equipment_category', operator: '=', value: params.category })
      }
      if (params.model) {
        filters.push({ field: 'equipment_model', operator: '=', value: params.model })
      }
      filters.push({ field: 'equipment_status', operator: '=', value: workshop })
      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/workshops/${params.id}/equipment/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
            filters,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION


    //SECTION Workshop API CALL
    // 👉 Fetch workshops data
    fetchWorkshops(params)  {
      const filters = []
      if (params.technician) {
        filters.push({ field: 'team_leader', operator: '=', value: params.technician })
      }
      if (params.client) {
        filters.push({ field: 'client_name', operator: '=', value: params.client })
      }
      if (params.status) {
        filters.push({ field: 'workshop_status', operator: '=', value: params.status })
      }
      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/workshops/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
            filters,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single workshop
    fetchWorkshop(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/workshops/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Workshop
    addWorkshop(workshopData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/workshops', workshopData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update workshop
    updateWorkshop(id, workshopData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/workshops/${id}`, workshopData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Workshop
    deleteWorkshop(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/workshops/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },   

    //!SECTION Workshop API CALL

    //SECTION Workshop Equipment  API CALL
    // 👉 Attach  Equipment with Workshop
    attachWorkshopEquipment(id, equipmentData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/workshops/${id}/equipment/attach`, equipmentData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Detach  Equipment with Workshop
    detachWorkshopEquipment(id, equipmentId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/workshops/${id}/equipment/detach`, {
            data: {
              resources: [equipmentId],
            },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch Inspected Equipment
    fetchInspectedEquipment(id, equipmentId) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/workshops/${id}/equipment/${equipmentId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update workshop
    updateInspectedEquipment(id, equipmentId, equipmentData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/workshops/${id}/equipment/${equipmentId}/pivot`, equipmentData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Workshop Equipment  API CALL
        
    //SECTION CheckList API CALL

    // 👉 Fetch CheckList
    fetchCheckList(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/workshop/${id}/check-list`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },


    // 👉 update CheckList
    updateCheckList(id, checkListData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/workshop/${id}/check-list`, checkListData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION  CheckList API CALL
    // 👉 Add Workshop Area
    addWorkshopArea(id, areaData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/workshop/${id}/areas`, areaData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },  
    
    // 👉 Update Workshop Area
    updateWorkshopArea(id, areaId, areaData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/workshop/${id}/areas/${areaId}`, areaData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Workshop Area
    deleteWorkshopArea(id, areaId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/workshop/${id}/areas/${areaId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Workshop Area API CALL 
    
    //SECTION Workshop Equipment API CALL
    // 👉 Fetch Workshop Equipments
    fetchWorkshopEquipments(params) {
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
          .post(`/api/workshop/${params.id}/equipment/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
            filters,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Workshop Equipment
    fetchWorkshopEquipment(id, equipmentId) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/workshop/${id}/equipment/${equipmentId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Workshop Equipment
    addWorkshopEquipment(id, equipmentData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/workshop/${id}/equipment`, equipmentData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },  
    
    // 👉 Update Workshop Equipment
    updateWorkshopEquipment(id, equipmentId, equipmentData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/workshop/${id}/equipment/${equipmentId}`, equipmentData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Workshop Equipment
    deleteWorkshopEquipment(id, equipmentId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/workshop/${id}/equipment/${equipmentId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Workshop Equipment API CALL 
  },
})
