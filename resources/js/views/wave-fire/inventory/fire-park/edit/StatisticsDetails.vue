<script setup>
import { useMetaStore } from '@/stores/useMetaStore'
import ChartCategories from './park-charts/ChartCategories.vue'
import ChartFireExtinguisherModel from './park-charts/ChartFireExtinguisherModel.vue'
import ChartStatus from './park-charts/ChartStatus.vue'

const props = defineProps({
  currentStep: {
    type: Number,
    required: false,
  },
  refetchCharts: {
    type: Function,
    required: true,
  },
  triggerRefetchCharts: {
    type: Boolean,
    required: true,
  },
})

const emit = defineEmits([
  'update:currentStep',
  'update:triggerRefetchCharts',
])

const route = useRoute()
const metaStore = useMetaStore()

const Previous = () => {
  emit('update:currentStep', props.currentStep ? props.currentStep - 1 : 1)
}

watch(() => props.currentStep)

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

const fetchParkEquipment = () => {
  metaStore.fetchParkEquipment(Number(route.params.id))
    .then(response => {
      totalEquipment.value = response.data.data.count.equipment_per_park
      totalFireExtinguisher.value = response.data.data.count.fire_extinguisher_per_park
      totalFireHose.value = response.data.data.count.fire_hose_per_park
      othersEquipment.value = response.data.data.count.others_equipment_per_park
      categoryChart.value = response.data.data.count.equipment_category_count
      categoriesLabels.value = Object.keys(categoryChart.value)
      categoriesSeries.value = Object.values(categoryChart.value)
      fireExtinguisherModelChart.value = response.data.data.count.fire_extinguisher_model_count
      fireExtinguisherModelLabels.value = Object.keys(fireExtinguisherModelChart.value)
      fireExtinguisherModelSeries.value = Object.values(fireExtinguisherModelChart.value)
      statusChart.value = response.data.data.count.equipment_status_count
      statusLabels.value = Object.keys(statusChart.value)
      statusSeries.value = Object.values(statusChart.value)
    }).catch(error => {
      console.error(error)
    })
    
  emit('update:triggerRefetchCharts', false)
}

onMounted(() => {
  fetchParkEquipment()
})

watch(() => props.triggerRefetchCharts, newValue => {
  if (newValue) {
    fetchParkEquipment()
  }
})

const equipmentCount = computed(() => {
  if (!totalEquipment.value || typeof totalEquipment.value !== 'object') {
    return null
  }

  return Object.values(totalEquipment.value)[0]
})

const fireExtinguisherCount = computed(() => {
  if (!totalFireExtinguisher.value || typeof totalFireExtinguisher.value !== 'object') {
    return null
  }

  return Object.values(totalFireExtinguisher.value)[0]
})

const fireHoseCount = computed(() => {
  if (!totalFireHose.value || typeof totalFireHose.value !== 'object') {
    return null
  }

  return Object.values(totalFireHose.value)[0]
})

const othersEquipmentCount = computed(() => {
  if (!othersEquipment.value || typeof othersEquipment.value !== 'object') {
    return null
  }

  return Object.values(othersEquipment.value)[0]
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
</script>

<template>
  <VRow />
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
      cols="12"
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
      cols="12"
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
      cols="12"
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
  <VRow>
    <VCol cols="12" />
    <VCol cols="12">
      <div class="d-flex flex-wrap gap-4 justify-sm-space-between justify-center mt-8">
        <VBtn
          color="secondary"
          variant="tonal"
          @click="Previous"
        >
          <VIcon
            icon="tabler-arrow-left"
            start
            class="flip-in-rtl"
          />
          Previous
        </VBtn>

        <VBtn color="success">
          Submit
          <VIcon
            icon="tabler-check"
            end
            class="flip-in-rtl"
          />
        </VBtn>
      </div>
    </VCol>
  </VRow>
</template>

<style lang="scss">
@use "@core-scss/template/libs/apex-chart.scss";

#apex-chart-wrapper {
  .v-card-item__append {
    padding-inline-start: 0;
  }
}
</style>
