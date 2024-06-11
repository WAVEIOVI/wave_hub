<script setup>
import ContractListMeta  from '@/views/wave-fire/contract/list/ContractListMeta.vue'
import ContractListTable  from '@/views/wave-fire/contract/list/ContractListTable.vue'
import { useContractListStore } from '@/views/wave-fire/contract/useContractListStore'

//SECTION Items

// 👉 Headers
const headers = [
  {
    title: 'Contract ID',
    key: 'contract_id',
  },
  {
    title: 'Client',
    key: 'contract_client',
  },
  {
    title: 'Type',
    key: 'contract_type',
  },
  {
    title: 'Status',
    key: 'contract_status',
  },
  {
    title: 'Contract Date',
    key: 'contract_date',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

// 👉 search filters
const types = [
  {
    title: 'Intervention',
    value: 'intervention',
  },
  {
    title: 'WorkShop',
    value: 'workshop',
  },
]

const status = [
  {
    title: 'Pending',
    value: 'pending',
  },
  {
    title: 'In Progress',
    value: 'in progress',
  },
  {
    title: 'Completed',
    value: 'completed',
  },
  {
    title: 'Closure',
    value: 'closure',
  },
]

//!SECTION Items

const contractListStore = useContractListStore()
const clients = ref([])

// 👉 Fetch Clients
onMounted(() => {
  contractListStore.fetchClients()
    .then(response => {
      clients.value = response.data.data.map(client => ({ ...client }))
      console.log(clients.value)
    }).catch(error => {
      console.error(error)
    })
}) 
</script>

<template>
  <section>
    <ContractListMeta />
    <VRow>
      <VCol cols="12">
        <ContractListTable
          :headers="headers" 
          :status="status"
          :types="types" 
          :clients="clients"
        />
      </VCol>
    </VRow>
  </section>
</template>
@/views/wave-fire/contract/useContractListStore
