<script setup>
import InterventionListMeta  from '@/views/wave-fire/mission/intervention/list/InterventionListMeta.vue'
import InterventionListTable  from '@/views/wave-fire/mission/intervention/list/InterventionListTable.vue'
import { useInterventionListStore } from '@/views/wave-fire/mission/intervention/useInterventionListStore'

//SECTION Items

// 👉 Headers
const headers = [
  {
    title: 'Intervention ID',
    key: 'intervention_id',
  },
  {
    title: 'Client',
    key: 'client',
  },
  {
    title: 'Park',
    key: 'intervention_park',
  },
  {
    title: 'Team Leader',
    key: 'intervention_team_leader',
  },
  {
    title: 'Status',
    key: 'intervention_status',
  },
  {
    title: 'Intervention Date',
    key: 'intervention_date',
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

const interventionListStore = useInterventionListStore()
const clients = ref([])

// 👉 Fetch Clients
onMounted(() => {
  interventionListStore.fetchClients()
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
  interventionListStore.fetchTechnicians()
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
    <InterventionListMeta />
    <VRow>
      <VCol cols="12">
        <InterventionListTable
          :headers="headers" 
          :status="status"
          :technicians="technicians" 
          :clients="clients"
        />
      </VCol>
    </VRow>
  </section>
</template>
