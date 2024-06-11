import axios from '@axios'
import { defineStore } from 'pinia'

export const useContractListStore = defineStore('ContractListStore', {
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
    fetchTechnicians(id) {
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

    //!SECTION

    //SECTION Contract API CALL
    // 👉 Fetch contracts data
    fetchContracts(params)  {
      const filters = []
      if (params.type) {
        filters.push({ field: 'contract_type', operator: '=', value: params.type })
      }
      if (params.client) {
        filters.push({ field: 'client_name', operator: '=', value: params.client })
      }
      if (params.status) {
        filters.push({ field: 'contract_status', operator: '=', value: params.status })
      }
      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/contracts/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
            filters,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single contract
    fetchContract(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/contracts/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Contract
    addContract(contractData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/contracts', contractData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update contract
    updateContract(id, contractData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/contracts/${id}`, contractData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Contract
    deleteContract(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/contracts/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },   

    //!SECTION Contract API CALL
    
    //SECTION Contract Area API CALL
    // 👉 Fetch Contract Areas
    fetchContractAreas(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/contract/${id}/areas`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Contract Area
    fetchContractArea(id, areaId) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/contract/${id}/areas/${areaId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Contract Area
    addContractArea(id, areaData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/contract/${id}/areas`, areaData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },  
    
    // 👉 Update Contract Area
    updateContractArea(id, areaId, areaData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/contract/${id}/areas/${areaId}`, areaData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Contract Area
    deleteContractArea(id, areaId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/contract/${id}/areas/${areaId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Contract Area API CALL 
    
    //SECTION Contract Equipment API CALL
    // 👉 Fetch Contract Equipments
    fetchContractEquipments(params) {
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
          .post(`/api/contract/${params.id}/equipment/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
            filters,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Contract Equipment
    fetchContractEquipment(id, equipmentId) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/contract/${id}/equipment/${equipmentId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Contract Equipment
    addContractEquipment(id, equipmentData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/contract/${id}/equipment`, equipmentData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },  
    
    // 👉 Update Contract Equipment
    updateContractEquipment(id, equipmentId, equipmentData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/contract/${id}/equipment/${equipmentId}`, equipmentData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Contract Equipment
    deleteContractEquipment(id, equipmentId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/contract/${id}/equipment/${equipmentId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Inspected Intervention Equipments data
    fetchMetaInspectedEquipments(params) {      
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/interventions/${params.id}/meta-equipment`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Inspected Intervention Equipments data
    fetchMetaWorkshopInspectedEquipments(params) {      
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/workshops/${params.id}/meta-equipment`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    // 👉 Fetch Inspected Intervention Equipments data
    fetchInspectedEquipments(params) {      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/interventions/${params.id}/equipment/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Inspected Workshop Equipments data
    fetchInspectedWorkshopEquipments(params) {      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/workshops/${params.id}/equipment/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Intervention
    fetchIntervention(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/contract/${id}/intervention`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Workshop
    fetchWorkshop(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/contract/${id}/workshop`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Contract Equipment API CALL 
  },
})
