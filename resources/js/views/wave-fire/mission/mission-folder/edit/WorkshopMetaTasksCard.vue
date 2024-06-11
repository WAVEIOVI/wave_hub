<script setup>
import ChartCategories from './meta-data/ChartCategories.vue'
import ChartFireExtinguisherModel from './meta-data/ChartFireExtinguisherModel.vue'
import ChartStatus from './meta-data/ChartStatus.vue'
import { useMissionListStore } from '../useMissionListStore'
import { VDataTable, VDataTableServer } from 'vuetify/labs/VDataTable'
import { avatarText } from '@core/utils/formatters'

const props = defineProps({
  equipmentHeaders: {
    type: Array,
    required: true,
  },
  missionData: {
    type: Array,
    required: true,
  },
})

//!SECTION UI
const resolveEquipmentStatusVariant = stat => {
  if (stat === 'in service')
    return 'success'
  if (stat === 'limited use')
    return 'warning'
  if (stat === 'out of order')
    return 'error'
  if (stat === 'workshop')
    return 'warning'
  
  return 'primary'
}

const localMissionData = ref((props.missionData))

//SECTION Declaration
const route = useRoute()
const missionListStore = useMissionListStore()
const workshopId = ref('')
const workshopData = ref({})
const equipments = ref([])
const totalEquipment = ref()
const totalFireExtinguisher = ref()
const totalFireHose = ref()
const othersEquipment = ref()
const categoryChart = ref({})
const categoriesLabels = ref({})
const categoriesSeries = ref({})
const fireExtinguisherModelChart = ref({})
const fireExtinguisherModelLabels = ref({})
const fireExtinguisherModelSeries = ref({})
const statusChart = ref({})
const statusLabels = ref({})
const statusSeries = ref({})

onMounted(() => {
  fetchWorkshop()
})

const fetchWorkshop = async () => {
  try {
    const response=await missionListStore
      .fetchWorkshop(Number(route.params.id))

    workshopData.value=response.data.data
    workshopId.value=workshopData.value.id
    fetchInspectedEquipments()
  } catch(error) {
    console.error(error)
  }
}

// 👉 Fetching equipments
const fetchInspectedEquipments = () => {
  missionListStore.fetchMetaWorkshopInspectedEquipments({
    id: workshopId.value,
  }).then(response => {
    console.log('Function called')
    equipments.value = response.data.meta
    totalEquipment.value = response.data.meta.total_equipment
    totalFireExtinguisher.value = response.data.meta.total_fire_extinguishers
    totalFireHose.value = response.data.meta.total_fire_hoses
    othersEquipment.value = response.data.meta.total_others_equipment
    console.log("Equipment Count:", equipmentCount.value)
    console.log("Fire Extinguisher Count:", fireExtinguisherCount.value)
    console.log("Fire Hose Count:", fireHoseCount.value)
    console.log("Others Equipment Count:", othersEquipmentCount.value)
    categoryChart.value = response.data.meta.total_equipment_by_category
    categoriesLabels.value = Object.keys(categoryChart.value)
    categoriesSeries.value = Object.values(categoryChart.value)
    fireExtinguisherModelChart.value = response.data.meta.total_fire_extinguishers_by_model
    fireExtinguisherModelLabels.value = Object.keys(fireExtinguisherModelChart.value)
    fireExtinguisherModelSeries.value = Object.values(fireExtinguisherModelChart.value)
    statusChart.value = response.data.meta.equipment_by_status
    statusLabels.value = Object.keys(statusChart.value)
    statusSeries.value = Object.values(statusChart.value)
  }).catch(error => {
    console.error(error)
  })
}

const equipmentCount = computed(() => {
  if (totalEquipment.value === null || totalEquipment.value === undefined) {
    return null
  }

  // No need for type check since we know it's a number
  return totalEquipment.value
})

const fireExtinguisherCount = computed(() => {
  if (totalFireExtinguisher.value === null || totalFireExtinguisher.value === undefined) {
    return null
  }

  // No need for type check since we know it's a number
  return totalFireExtinguisher.value
})

const fireHoseCount = computed(() => {
  if (totalFireHose.value === null || totalFireHose.value === undefined) {
    return null
  }

  // No need for type check since we know it's a number
  return totalFireHose.value
})

const othersEquipmentCount = computed(() => {
  if (othersEquipment.value === null || othersEquipment.value === undefined) {
    return null
  }

  // No need for type check since we know it's a number
  return othersEquipment.value
})


const statisticsVerticalSimple = [
  {
    title: 'Equipment',
    color: 'primary',
    stats: equipmentCount,
    icon: 'tabler-tool',
  },
  {
    title: 'Fire Extinguisher',
    color: 'primary',
    stats: fireExtinguisherCount,
    icon: 'tabler-fire-extinguisher',
  },
  {
    title: 'Fire Hose',
    color: 'primary',
    stats: fireHoseCount,
    icon: 'tabler-firetruck',
  },
  {
    title: 'Others Equipment',
    color: 'primary',
    stats: othersEquipmentCount,
    icon: 'tabler-tools',
  },
]

const equipmentTables = [
  {
    description: 'Equipment',
    quantity: equipmentCount,
  },
  {
    description: 'Fire Extinguisher',
    quantity: fireExtinguisherCount,
  },
  {
    description: 'Fire Hose',
    quantity: fireHoseCount,
  },
  {
    description: 'Others Equipment',
    quantity: othersEquipmentCount,
  },
]
</script>

<template>
  <section>
    <VRow class="match-height"> 
      <VCol
        v-for="statistics in statisticsVerticalSimple"
        :key="statistics.title"
        md="3"
        cols="6"
      >
        <CardStatisticsVerticalSimple v-bind="statistics" />
      </VCol>
    </VRow>
    <VRow class="match-height">
      <VCol
        md="4"
        cols="6"
      >
        <VCard>
          <VCardTitle>Categories</VCardTitle>
          <ChartCategories
            v-if="categoriesLabels.length && categoriesSeries.length"
            :categories-labels="categoriesLabels"
            :categories-series="categoriesSeries"
          />
        </VCard>
      </VCol>
      <VCol
        md="4"
        cols="6"
      >
        <VCard>
          <VCardTitle>Fire Extinguisher</VCardTitle>
          <ChartFireExtinguisherModel
            v-if="fireExtinguisherModelLabels.length && fireExtinguisherModelSeries.length"
            :fire-extinguisher-model-labels="fireExtinguisherModelLabels"
            :fire-extinguisher-model-series="fireExtinguisherModelSeries"
          />
        </VCard>
      </VCol>
      <VCol
        md="4"
        cols="6"
      >
        <VCard>
          <VCardTitle>Status</VCardTitle>
          <ChartStatus
            v-if="statusLabels.length && statusSeries.length"
            :status-labels="statusLabels"
            :status-series="statusSeries"
          />
        </VCard>
      </VCol>
    </VRow> 
  </section>
</template>
