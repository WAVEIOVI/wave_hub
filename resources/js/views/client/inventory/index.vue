<script setup>
import ParksInventory from './ParksInventory.vue'

const props = defineProps({
  clientData: {
    type: Object,
    required: true,
  },
  parksData: {
    type: Array,
    required: true,
  },
  equipments: {
    type: Object,
    required: true,
  },
})

// 👉 Equipment Headers
const equipmentHeaders = [
  {
    title: 'EQUIPMENT ID',
    key: 'equipment_id',
  },
  {
    title: 'AREA',
    key: 'area',
  },
  {
    title: 'Category',
    key: 'category',
  },
  {
    title: 'Equipment',
    key: 'equipment',
  },
  {
    title: 'STATUS',
    key: 'equipment_status',
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

const clientData = ref((props.clientData))

watch(
  () => props.clientData,
  newValue => {
    clientData.value = newValue
    console.log('clientData in child:', clientData.value)
  },
  { deep: true },
)
</script>

<template>
  <VRow>
    <VCol cols="12">
      <h2>Parks List</h2>
      <ParksInventory
        :parks-data="parksData"
        :equipment-headers="equipmentHeaders"
      />
    </VCol>
  </VRow>
</template>
