import axios from '@axios'
import { defineStore } from 'pinia'

export const useEquipmentParamsStore = defineStore('EquipmentParamsStore', {
  actions: {
    //SECTION Category API CALL
    // 👉 Fetch Categories data
    fetchCategories(params)  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/categories/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single Category
    fetchCategory(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/categories/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Category
    addCategory(categoryData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/categories', categoryData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update Category
    updateCategory(id, categoryData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/categories/${id}`, categoryData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Category
    deleteCategory(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/categories/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Category API CALL

    //SECTION Weight API CALL
    // 👉 Fetch Categories data
    fetchWeights(params)  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/weights/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single Weight
    fetchWeight(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/weights/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Weight
    addWeight(weightData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/weights', weightData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update Weight
    updateWeight(id, weightData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/weights/${id}`, weightData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Weight
    deleteWeight(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/weights/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Weight API CALL

    //SECTION Protections API CALL
    // 👉 Fetch Protections data
    fetchProtections(params)  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/protections/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single protection
    fetchProtection(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/protections/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add protection
    addProtection(protectionData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/protections', protectionData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update protection
    updateProtection(id, protectionData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/protections/${id}`, protectionData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Weight
    deleteProtection(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/protections/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Protection API CALL

    //SECTION Pressures API CALL
    // 👉 Fetch Pressures data
    fetchPressures(params)  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/pressures/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single pressure
    fetchPressure(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/pressures/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add pressure
    addPressure(pressureData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/pressures', pressureData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update pressure
    updatePressure(id, pressureData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/pressures/${id}`, pressureData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Pressure
    deletePressure(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/pressures/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Pressure API CALL

    //SECTION Accessories API CALL
    // 👉 Fetch Accessories data
    fetchAccessories(params)  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/accessories/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single Accessory
    fetchAccessory(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/accessories/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Accessory
    addAccessory(accessoryData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/accessories', accessoryData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update Accessory
    updateAccessory(id, accessoryData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/accessories/${id}`, accessoryData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Accessory
    deleteAccessory(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/accessories/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Accessory API CALL
    //SECTION Maintenances API CALL
    // 👉 Fetch Maintenances data
    fetchMaintenances(params)  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/maintenances/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single Maintenance
    fetchMaintenance(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/maintenances/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Maintenance
    addMaintenance(maintenanceData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/maintenances', maintenanceData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update Maintenances
    updateMaintenance(id, maintenanceData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/maintenances/${id}`, maintenanceData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Maintenance
    deleteMaintenance(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/maintenances/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Maintenances API CALL
    
    //SECTION Additional Maintenances API CALL
    // 👉 Fetch Additional Maintenances data
    fetchAdditionalMaintenances(params)  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/additional-maintenances/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single Additional Maintenance
    fetchAdditionalMaintenance(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/additional-maintenances/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Additional Maintenance
    addAdditionalMaintenance(additionalMaintenanceData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/additional-maintenances', additionalMaintenanceData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update Additional Maintenances
    updateAdditionalMaintenance(id, additionalMaintenanceData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/additional-maintenances/${id}`, additionalMaintenanceData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Additional Maintenance
    deleteAdditionalMaintenance(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/additional-maintenances/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Additional Maintenance API CALL

    //SECTION Supplies API CALL
    // 👉 Fetch supplies 
    fetchSupplies(params)  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/supplies/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single Supply
    fetchSupply(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/supplies/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Supply
    addSupply(supplyData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/supplies', supplyData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update Supply
    updateSupply(id, supplyData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/supplies/${id}`, supplyData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Supply
    deleteSupply(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/supplies/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Supplies API CALL
    
    //SECTION Models API CALL
    // 👉 Fetch Models data
    fetchModels(params)  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/models/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Models data
    fetchModelOptions()  {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/models/search`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Models 
    fetchCategoryModelsOptions(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/category/${id}/models`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch Model 
    fetchModel(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/models/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Model
    addModel(modelData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/models', modelData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update Model
    updateModel(id, fetchedModelData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/models/${id}`, fetchedModelData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Model
    deleteModel(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/models/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Models API CALL
    
    // 👉 Fetch Categories
    fetchCategoriesOptions()  {
      return new Promise((resolve, reject) => {
        axios
          .get('/api/categories')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    //SECTION Attaching API CALL
    // 👉 Attach Accessory
    attachAccessory(id, selectedAccessories) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/models/${id}/accessories/attach`, {
            resources: selectedAccessories,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Attach New Accessory 
    attachNewAccessory(modelId, accessoryId) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/models/${modelId}/accessories/attach`,
            { resources: [accessoryId] },
          )
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    // 👉 detach Accessory 
    detachAccessory(modelId, accessoryId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/models/${modelId}/accessories/detach`, {
            data: { resources: [accessoryId] },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Attach Protection
    attachProtection(id, selectedProtections) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/models/${id}/protections/attach`, {
            resources: selectedProtections,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Attach New Protection 
    attachNewProtection(modelId, protectionId) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/models/${modelId}/protections/attach`,
            { resources: [protectionId] },
          )
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    // 👉 detach Protection 
    detachProtection(modelId, protectionId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/models/${modelId}/protections/detach`, {
            data: { resources: [protectionId] },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Attach Pressure
    attachPressure(id, selectedPressures) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/models/${id}/pressures/attach`, {
            resources: selectedPressures,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Attach New Pressure 
    attachNewPressure(modelId, pressureId) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/models/${modelId}/pressures/attach`,
            { resources: [pressureId] },
          )
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    // 👉 detach Pressure 
    detachPressure(modelId, pressureId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/models/${modelId}/pressures/detach`, {
            data: { resources: [pressureId] },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Attach Weight
    attachWeight(id, selectedWeights) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/models/${id}/weights/attach`, {
            resources: selectedWeights,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Attach New Weight 
    attachNewWeight(modelId, weightId) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/models/${modelId}/weights/attach`,
            { resources: [weightId] },
          )
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    // 👉 detach Weight 
    detachWeight(modelId, weightId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/models/${modelId}/weights/detach`, {
            data: { resources: [weightId] },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Attach Maintenance
    attachMaintenance(id, selectedMaintenances) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/models/${id}/maintenances/attach`, {
            resources: selectedMaintenances,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Attach New Maintenance 
    attachNewMaintenance(modelId, maintenanceId) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/models/${modelId}/maintenances/attach`,
            { resources: [maintenanceId] },
          )
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    // 👉 detach Maintenance 
    detachMaintenance(modelId, maintenanceId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/models/${modelId}/maintenances/detach`, {
            data: { resources: [maintenanceId] },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Attach Additional Maintenance
    attachAdditionalMaintenance(id, selectedAdditionalMaintenances) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/models/${id}/additional-maintenances/attach`, {
            resources: selectedAdditionalMaintenances,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Attach New additional Maintenance 
    attachNewAdditionalMaintenance(modelId, additionalMaintenanceId) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/models/${modelId}/additional-maintenances/attach`,
            { resources: [additionalMaintenanceId] },
          )
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    // 👉 detach additional Maintenance 
    detachAdditionalMaintenance(modelId, additionalMaintenanceId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/models/${modelId}/additional-maintenances/detach`, {
            data: { resources: [additionalMaintenanceId] },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    // 👉 Attach Supply
    attachSupply(id, selectedSupplies) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/models/${id}/supplies/attach`, {
            resources: selectedSupplies,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Attach New Supply 
    attachNewSupply(modelId, supplyId) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/models/${modelId}/supplies/attach`,
            { resources: [supplyId] },
          )
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    // 👉 detach Supply 
    detachSupply(modelId, supplyId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/models/${modelId}/supplies/detach`, {
            data: { resources: [supplyId] },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch Model Accessories
    fetchModelAccessories(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/models/${id}/accessories`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    // 👉 fetch Model Protections
    fetchModelProtections(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/models/${id}/protections`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    
    // 👉 fetch Model Weights
    fetchModelWeights(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/models/${id}/weights`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch Model Pressures
    fetchModelPressures(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/models/${id}/pressures`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch Model Maintenances
    fetchModelMaintenances(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/models/${id}/Maintenances`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    
    // 👉 fetch Model Maintenances
    fetchModelMaintenances(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/models/${id}/maintenances`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch Model Additional Maintenances
    fetchModelAdditionalMaintenances(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/models/${id}/additional-maintenances`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch Model Supplies
    fetchModelSupplies(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/models/${id}/supplies`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Attaching API CALL 
  },
})
