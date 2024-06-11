<script setup>
import ParkListMeta  from '@/views/wave-fire/inventory/fire-park/list/ParkListMeta.vue'
import ParkListTable  from '@/views/wave-fire/inventory/fire-park/list/ParkListTable.vue'
import { useParkListStore } from '@/views/wave-fire/inventory/fire-park/useParkListStore'

//SECTION Items

// 👉 Headers
const headers = [
  {
    title: 'Park',
    key: 'park',
  },
  {
    title: 'Type',
    key: 'park_type',
  },
  {
    title: 'Client',
    key: 'park_client',
  },
  {
    title: 'Address',
    key: 'park_address',
  },
  {
    title: 'CREATED DATE',
    key: 'created_at',
  },
  {
    title: 'LAST UPDATED',
    key: 'updated_at',
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
    title: 'Primary Fire Park',
    value: 'primary fire park',
  },
  {
    title: 'Secondary Fire Park',
    value: 'secondary fire park',
  },
  {
    title: 'Reserve Fire Park',
    value: 'reserve fire park',
  },
]

const cities = [
  {
    title: 'Ariana',
    value: 'ariana',
  },
  {
    title: 'Beja',
    value: 'beja',
  },
  {
    title: 'Ben Arous',
    value: 'ben arous',
  },
  {
    title: 'Bizerte',
    value: 'bizerte',
  },
  {
    title: 'Gabès',
    value: 'gabes',
  },
  {
    title: 'Gafsa',
    value: 'gafsa',
  },
  {
    title: 'Jendouba',
    value: 'jendouba',
  },
  {
    title: 'Kairouan',
    value: 'kairouan',
  },
  {
    title: 'Kasserine',
    value: 'kasserine',
  },
  {
    title: 'Kébili',
    value: 'kebili',
  },
  {
    title: 'Kef',
    value: 'kef',
  },
  {
    title: 'Mahdia',
    value: 'mahdia',
  },
  {
    title: 'Manouba',
    value: 'manouba',
  },
  {
    title: 'Médenine',
    value: 'medenine',
  },
  {
    title: 'Monastir',
    value: 'monastir',
  },
  {
    title: 'Nabeul',
    value: 'nabeul',
  },
  {
    title: 'Sfax',
    value: 'sfax',
  },
  {
    title: 'Sidi Bouzid',
    value: 'sidi bouzid',
  },
  {
    title: 'Siliana',
    value: 'siliana',
  },
  {
    title: 'Sousse',
    value: 'sousse',
  },
  {
    title: 'Tataouine',
    value: 'tataouine',
  },
  {
    title: 'Tozeur',
    value: 'tozeur',
  },
  {
    title: 'Tunis',
    value: 'tunis',
  },
  {
    title: 'Zaghouan',
    value: 'zaghouan',
  },
]

const status = [
  {
    title: 'Pending',
    value: 'pending',
  },
  {
    title: 'Active',
    value: 'active',
  },
  {
    title: 'Inactive',
    value: 'inactive',
  },
]

//!SECTION Items

const parkListStore = useParkListStore()
const clients = ref([])

// 👉 Fetch Clients
onMounted(() => {
  parkListStore.fetchClients()
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
    <ParkListMeta />
    <VRow>
      <VCol cols="12">
        <ParkListTable
          :headers="headers" 
          :types="types" 
          :clients="clients"
          :cities="cities"
        />
      </VCol>
    </VRow>
  </section>
</template>

