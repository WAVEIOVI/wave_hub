<script setup>
import WorkshopListMeta  from '@/views/wave-fire/mission/workshop/list/WorkshopListMeta.vue'
import WorkshopListTable  from '@/views/wave-fire/mission/workshop/list/WorkshopListTable.vue'
import { useWorkshopListStore } from '@/views/wave-fire/mission/workshop/useWorkshopListStore'

//SECTION Items

// 👉 Headers
const headers = [
  {
    title: 'Workshop ID',
    key: 'workshop_id',
  },
  {
    title: 'Client',
    key: 'client',
  },
  {
    title: 'Workshop Leader',
    key: 'workshop_leader',
  },
  {
    title: 'Status',
    key: 'workshop_status',
  },
  {
    title: 'Workshop Date',
    key: 'workshop_date',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]


const status = [
  {
    title: 'Pending',
    value: 'pending',
  },
  {
    title: 'In Progress',
    value: 'in_progress',
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

const workshopListStore = useWorkshopListStore()
const clients = ref([])

// 👉 Fetch Clients
onMounted(() => {
  workshopListStore.fetchClients()
    .then(response => {
      clients.value = response.data.data.map(client => ({ ...client }))
      console.log(clients.value)
    }).catch(error => {
      console.error(error)
    })
})
 
const technicians = ref([])

// 👉 Fetch Technicians
onMounted(() => {
  workshopListStore.fetchTechnicians()
    .then(response => {
      technicians.value = response.data.data.map(technician => ({ ...technician }))
      console.log(technicians.value)
    }).catch(error => {
      console.error(error)
    })
}) 
</script>

<template>
  <section>
    <WorkshopListMeta />
    <VRow>
      <VCol cols="12">
        <WorkshopListTable
          :headers="headers" 
          :status="status"
          :technicians="technicians" 
          :clients="clients"
        />
      </VCol>
    </VRow>
  </section>
</template>
