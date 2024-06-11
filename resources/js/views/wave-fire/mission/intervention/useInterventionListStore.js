import axios from '@axios'
import { defineStore } from 'pinia'

export const useInterventionListStore = defineStore('InterventionListStore', {
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

    // 👉 Fetch interventions data
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

    //SECTION Intervention API CALL
    
    // 👉 Fetch Inspected Equipments data
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
          .post(`/api/interventions/${params.id}/equipment/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
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
          .post(`/api/interventions/${params.id}/equipment/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
            filters,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION


    //SECTION Intervention API CALL
    // 👉 Fetch interventions data
    fetchInterventions(params)  {
      const filters = []
      if (params.technician) {
        filters.push({ field: 'team_leader', operator: '=', value: params.technician })
      }
      if (params.client) {
        filters.push({ field: 'client_name', operator: '=', value: params.client })
      }
      if (params.status) {
        filters.push({ field: 'intervention_status', operator: '=', value: params.status })
      }
      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/interventions/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
            filters,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single intervention
    fetchIntervention(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/interventions/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Intervention
    addIntervention(interventionData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/interventions', interventionData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update intervention
    updateIntervention(id, interventionData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/interventions/${id}`, interventionData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Intervention
    deleteIntervention(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/interventions/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },   

    //!SECTION Intervention API CALL

    //SECTION Intervention Equipment  API CALL
    // 👉 Attach  Equipment with Intervention
    attachInterventionEquipment(id, equipmentData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/interventions/${id}/equipment/attach`, equipmentData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Detach  Equipment with Intervention
    detachInterventionEquipment(id, equipmentId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/interventions/${id}/equipment/detach`, {
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
          .get(`/api/interventions/${id}/equipment/${equipmentId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update intervention
    updateInspectedEquipment(id, equipmentId, equipmentData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/interventions/${id}/equipment/${equipmentId}/pivot`, equipmentData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Intervention Equipment  API CALL
        
    //SECTION CheckList API CALL

    // 👉 Fetch CheckList
    fetchCheckList(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/intervention/${id}/check-list`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },


    // 👉 update CheckList
    updateCheckList(id, checkListData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/intervention/${id}/check-list`, checkListData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION  CheckList API CALL
    // 👉 Add Intervention Area
    addInterventionArea(id, areaData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/intervention/${id}/areas`, areaData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },  
    
    // 👉 Update Intervention Area
    updateInterventionArea(id, areaId, areaData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/intervention/${id}/areas/${areaId}`, areaData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Intervention Area
    deleteInterventionArea(id, areaId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/intervention/${id}/areas/${areaId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Intervention Area API CALL 
    
    //SECTION Intervention Equipment API CALL
    // 👉 Fetch Intervention Equipments
    fetchInterventionEquipments(params) {
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
          .post(`/api/intervention/${params.id}/equipment/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
            filters,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Intervention Equipment
    fetchInterventionEquipment(id, equipmentId) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/intervention/${id}/equipment/${equipmentId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Intervention Equipment
    addInterventionEquipment(id, equipmentData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/intervention/${id}/equipment`, equipmentData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },  
    
    // 👉 Update Intervention Equipment
    updateInterventionEquipment(id, equipmentId, equipmentData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/intervention/${id}/equipment/${equipmentId}`, equipmentData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Intervention Equipment
    deleteInterventionEquipment(id, equipmentId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/intervention/${id}/equipment/${equipmentId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Intervention Equipment API CALL 
  },
})
