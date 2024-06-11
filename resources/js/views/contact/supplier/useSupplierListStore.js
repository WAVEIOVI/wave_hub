import axios from '@axios'
import { defineStore } from 'pinia'

export const useSupplierListStore = defineStore('SupplierListStore', {
  actions: {
    //SECTION Supplier API CALL
    // 👉 Fetch suppliers data
    fetchSuppliers(params)  {
      const filters = []
      if (params.type) {
        filters.push({ field: 'supplier_type', operator: '=', value: params.type })
      }
      if (params.activity) {
        filters.push({ field: 'supplier_activity', operator: '=', value: params.activity })
      }
      if (params.status) {
        filters.push({ field: 'supplier_status', operator: '=', value: params.status })
      }
      
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/suppliers/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
            filters,
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 fetch single supplier
    fetchSupplier(id) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/suppliers/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Supplier
    addSupplier(supplierData) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/suppliers', supplierData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 update supplier
    updateSupplier(id, supplierData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/suppliers/${id}`, supplierData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Supplier
    deleteSupplier(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/suppliers/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },   

    //!SECTION Supplier API CALL
    
    //SECTION Supplier Address API CALL
    // 👉 Fetch Supplier Addresses
    fetchSupplierAddresses(params) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/supplier/${params.id}/addresses/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Supplier Address
    fetchSupplierAddress(id, addressId) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/supplier/${id}/addresses/${addressId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Supplier Address
    addSupplierAddress(id, addressData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/supplier/${id}/addresses`, addressData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },  
    
    // 👉 Update Supplier Address
    updateSupplierAddress(id, addressId, addressData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/supplier/${id}/addresses/${addressId}`, addressData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Supplier Address
    deleteSupplierAddress(id, addressId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/supplier/${id}/addresses/${addressId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Supplier Address API CALL 
    
    //SECTION Supplier Contact API CALL
    // 👉 Fetch Supplier Contacts
    fetchSupplierContacts(params) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/supplier/${params.id}/contacts/search?limit=${params.options.itemsPerPage}&page=${params.options.page}`, {
            search: { value: params.search },
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Fetch Supplier Contact
    fetchSupplierContact(id, contactId) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/supplier/${id}/contacts/${contactId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Add Supplier Contact
    addSupplierContact(id, contactData) {
      return new Promise((resolve, reject) => {
        axios
          .post(`/api/supplier/${id}/contacts`, contactData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },  
    
    // 👉 Update Supplier Contact
    updateSupplierContact(id, contactId, contactData) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/supplier/${id}/contacts/${contactId}`, contactData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    // 👉 Delete Supplier Contact
    deleteSupplierContact(id, contactId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/supplier/${id}/contacts/${contactId}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },

    //!SECTION Supplier Contact API CALL 
  },
})
