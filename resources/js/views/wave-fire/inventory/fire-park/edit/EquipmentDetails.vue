<script setup>
import { useParkListStore } from '@/views/wave-fire/inventory/fire-park/useParkListStore'
import ParkAreasCard from './park-areas/ParkAreasCard.vue'
import ParkEquipmentCard from './park-equipment/ParkEquipmentCard.vue'

const props = defineProps({
  currentStep: {
    type: Number,
    required: false,
  },
})

const emit = defineEmits([
  'update:currentStep',
  'refetchCharts',
])

const route = useRoute()
const parkListStore = useParkListStore()
const areas = ref([])

// 👉 search filters

//SECTION Items

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

//!SECTION Items

const status = [
  {
    title: 'In Service',
    value: 'in service',
  },
  {
    title: 'Limited Use',
    value: 'limited use',
  },
  {
    title: 'Out Of Order',
    value: 'out of order',
  },
]

const Previous = () => {
  emit('update:currentStep', props.currentStep ? props.currentStep - 1 : 1)
}

const Next = () => {
  emit('update:currentStep', props.currentStep ? props.currentStep + 1 : 1)
}

watch(() => props.currentStep)

const fetchAreas = () => {
  parkListStore.fetchParkAreas(Number(route.params.id))
    .then(response => {
      areas.value = response.data.data.map(area => ({ ...area }))
      console.log(areas.value)
    }).catch(error => {
      console.error(error)
    })
}

// 👉 Fetch Areas
onMounted(() => {
  fetchAreas()
}) 

const refetchAreas = () => {
  console.log('refetchAreas Function run')
  fetchAreas()
}

const refetchCharts = () => {
  console.log('refetchCharts Function Called')
  emit('refetchCharts')
}
</script>

<template>
  <VRow class="match-height"> 
    <VCol cols="12">
      <!-- 👉 Areas -->
      <ParkAreasCard @refetch-areas="refetchAreas" />
    </VCol>
    <VCol cols="12">
      <!-- 👉 Equipment -->
      <ParkEquipmentCard 
        :equipment-headers="equipmentHeaders"
        :areas="areas"
        :status="status"
        @refetch-charts="refetchCharts"
      />
    </VCol>
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

        <VBtn @click="Next">
          Next
          <VIcon
            icon="tabler-arrow-right"
            end
            class="flip-in-rtl"
          />
        </VBtn>
      </div>
    </VCol>
  </VRow>
</template>
