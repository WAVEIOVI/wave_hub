<script setup>
import ParkEquipmentCard from './EquipmentWorkshopCard.vue'

const props = defineProps({
  currentStep: {
    type: Number,
    required: false,
  },
  interventionData: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits([
  'update:currentStep',
])

// 👉 search filters
const categories = [
  {
    title: 'Fire Extinguisher',
    value: 'fire extinguisher',
  },
  {
    title: 'Fire Hose',
    value: 'fire hose',
  },
  {
    title: 'Fire Hydrant',
    value: 'fire hydrant',
  },
  {
    title: 'Fire Sprinkler',
    value: 'fire sprinkler',
  },
  {
    title: 'Smoke Detector',
    value: 'smoke detector',
  },
]

const models = [
  {
    title: 'Water-Based',
    value: 'water-based',
  },
  {
    title: 'Powder ABC',
    value: 'powder abc',
  },
  {
    title: 'CO2',
    value: 'co2',
  },
  {
    title: 'Foam',
    value: 'foam',
  },
  {
    title: 'Wet Chemical (Kitchen-Specific)',
    value: 'wet chemical (kitchen-specific)',
  },
  {
    title: 'Dry Powder (Class D)',
    value: 'dry powder (class d)',
  },
]

const Previous = () => {
  emit('update:currentStep', props.currentStep ? props.currentStep - 1 : 1)
}

const Next = () => {
  emit('update:currentStep', props.currentStep ? props.currentStep + 1 : 1)
}

watch(() => props.currentStep)

//SECTION Items

// 👉 Equipment Headers
const equipmentHeaders = [
  {
    title: 'EQUIPMENT ID',
    key: 'equipment_id',
  },
  {
    title: 'Inspection',
    key: 'inspection',
  },
  {
    title: 'Raw',
    key: 'raw_recharge',
  },  
  {
    title: 'Nitrogen',
    key: 'nitrogen_recharge',
  },
  {
    title: 'STATUS',
    key: 'equipment_status',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

//!SECTION Items
</script>

<template>
  <VRow class="match-height">
    <VCol cols="12">
      <ParkEquipmentCard
        :intervention-data="interventionData" 
        :equipment-headers="equipmentHeaders"
        :categories="categories"
        :models="models"
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
