<script setup>
import MissionListMeta  from '@/views/wave-fire/mission/mission-folder/list/MissionListMeta.vue'
import MissionListTable  from '@/views/wave-fire/mission/mission-folder/list/MissionListTable.vue'
import { useMissionListStore } from '@/views/wave-fire/mission/mission-folder/useMissionListStore'

//SECTION Items

// 👉 Headers
const headers = [
  {
    title: 'Mission ID',
    key: 'mission_id',
  },
  {
    title: 'Client',
    key: 'mission_client',
  },
  {
    title: 'Type',
    key: 'mission_type',
  },
  {
    title: 'Status',
    key: 'mission_status',
  },
  {
    title: 'Mission Date',
    key: 'mission_date',
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

const missionListStore = useMissionListStore()
const clients = ref([])

// 👉 Fetch Clients
onMounted(() => {
  missionListStore.fetchClients()
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
    <MissionListMeta />
    <VRow>
      <VCol cols="12">
        <MissionListTable
          :headers="headers" 
          :status="status"
          :types="types" 
          :clients="clients"
        />
      </VCol>
    </VRow>
  </section>
</template>
