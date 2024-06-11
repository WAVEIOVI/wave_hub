<script setup>
import BasicMissionInformation from '@/views/wave-fire/mission/mission-folder/edit/BasicMissionInformation.vue'
import MissionMonitoring from '@/views/wave-fire/mission/mission-folder/edit/MissionMonitoring.vue'
import MissionParams from '@/views/wave-fire/mission/mission-folder/edit/MissionParams.vue'
import ServiceDeliveryNote from '@/views/wave-fire/mission/mission-folder/edit/ServiceDeliveryNote.vue'
import { useMissionListStore } from '@/views/wave-fire/mission/mission-folder/useMissionListStore'

const checkoutSteps = [
  {
    title: 'Basic Information',
    icon: 'tabler-360-view',
  },
  {
    title: 'Mission Params',
    icon: 'tabler-adjustments',
  },
  {
    title: 'Mission Monitoring',
    icon: 'tabler-heart-rate-monitor',
  },
  {
    title: 'Service Delivery Note',
    icon: 'tabler-truck-delivery',
  },
]

const route = useRoute()
const missionData = ref()
const technicians = ref([])
const missionListStore = useMissionListStore()
const isSnackbarVisible = ref(false)
const currentStep = ref(0)

//SECTION Functions
// 👉 Fetch Mission
onMounted(() => {
  missionListStore.fetchMission(Number(route.params.id)).then(response => {
    missionData.value = response.data.data
  })
})

// 👉 Fetch Technicians
onMounted(() => {
  missionListStore.fetchTechnicians()
    .then(response => {
      technicians.value = response.data.data.map(technician => ({ ...technician }))
      console.log(technicians.value)
    }).catch(error => {
      console.error(error)
    })
})
 

// 👉 Update Mission
const updateMission = async  updatedMissionData => {
  try {
    const response = await missionListStore.updateMission(Number(route.params.id), updatedMissionData)
    if (response.status === 200) {
      isSnackbarVisible.value = true
    } else {
      throw new Error(`Failed to update mission: ${response.statusText}`)
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
      Mission Data Updated Successfully
    </VSnackbar>
    <VCard v-if="missionData">
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
          class="disable-tab-transition"
        >
          <VWindowItem>
            <BasicMissionInformation
              v-model:current-step="currentStep"
              :mission-data="missionData"
              @submit="updateMission"
            />
          </VWindowItem>
          <VWindowItem>
            <MissionParams
              v-model:current-step="currentStep"
              :mission-data="missionData"
              :technicians="technicians"
              @submit="updateMission"
            />
          </VWindowItem>
          <VWindowItem>
            <MissionMonitoring
              v-model:current-step="currentStep"
              :mission-data="missionData"
              :technicians="technicians"
              @submit="updateMission"
            />
          </VWindowItem>
          <VWindowItem>
            <ServiceDeliveryNote
              v-model:current-step="currentStep"
              :mission-data="missionData"
              @submit="updateMission"
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
