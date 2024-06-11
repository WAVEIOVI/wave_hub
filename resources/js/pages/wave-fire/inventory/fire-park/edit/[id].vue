<script setup>
import BasicParkInformation from '@/views/wave-fire/inventory/fire-park/edit/BasicParkInformation.vue'
import EquipmentDetails from '@/views/wave-fire/inventory/fire-park/edit/EquipmentDetails.vue'
import StatisticsDetails from '@/views/wave-fire/inventory/fire-park/edit/StatisticsDetails.vue'
import { useParkListStore } from '@/views/wave-fire/inventory/fire-park/useParkListStore'

const checkoutSteps = [
  {
    title: 'Basic Information',
    icon: 'tabler-360-view',
  },
  {
    title: 'Equipment ',
    icon: 'tabler-tool',
  },
  {
    title: 'Statistics',
    icon: 'tabler-chart-pie-filled',
  },
]

const triggerRefetchCharts = ref(false)

const refetchCharts = () => {
  console.log('Function called from parent')
  triggerRefetchCharts.value = !triggerRefetchCharts.value // Toggle the value
}

const route = useRoute()
const parkData = ref()
const parkListStore = useParkListStore()
const isSnackbarVisible = ref(false)
const currentStep = ref(0)

//SECTION Functions
// 👉 Fetch Park
onMounted(() => {
  parkListStore.fetchPark(Number(route.params.id)).then(response => {
    parkData.value = response.data.data
  })
})

// 👉 Update Park
const updatePark = async  updatedParkData => {
  try {
    const response = await parkListStore.updatePark(Number(route.params.id), updatedParkData)
    if (response.status === 200) {
      isSnackbarVisible.value = true
    } else {
      throw new Error(`Failed to update park: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}
</script>

<template>
  <div>
    <!-- 👉 SnackBar Notification -->
    <VSnackbar 
      v-model="isSnackbarVisible"
      transition="scroll-y-reverse-transition"
    >
      Park Data Updated Successfully
    </VSnackbar>
    <VCard v-if="parkData">
      <VCardText>
        <!-- 👉 Stepper -->
        <AppStepper
          v-model:current-step="currentStep"
          class="checkout-stepper"
          :items="checkoutSteps"
        />
      </VCardText>

      <VDivider />

      <VCardText>
        <!-- 👉 stepper content -->
        <VWindow
          v-model="currentStep"
          :touch="false"
        >
          <VWindowItem>
            <BasicParkInformation
              v-model:current-step="currentStep"
              :park-data="parkData"
              @submit="updatePark"
            />
          </VWindowItem>
          <VWindowItem>
            <EquipmentDetails
              v-model:current-step="currentStep"
              @refetch-charts="refetchCharts"
            />
          </VWindowItem>
          <VWindowItem>
            <StatisticsDetails
              v-model:current-step="currentStep"
              :park-data="parkData"
              :refetch-charts="refetchCharts"
              :trigger-refetch-charts="triggerRefetchCharts"
              @update:trigger-refetch-charts="triggerRefetchCharts = false"
            />
          </VWindowItem>
        </VWindow>
      </VCardText>
    </VCard>
  </div>
</template>

<style lang="scss">
.checkout-stepper {
  .stepper-icon-step {
    .step-wrapper + svg {
      margin-inline: 3.5rem !important;
    }
  }
}
</style>
