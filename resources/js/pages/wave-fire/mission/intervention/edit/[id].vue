<script setup>
import AdditionalTasks from '@/views/wave-fire/mission/intervention/edit/AdditionalTasks.vue'
import BasicInterventionInformation from '@/views/wave-fire/mission/intervention/edit/BasicInterventionInformation.vue'
import ClientReport from '@/views/wave-fire/mission/intervention/edit/ClientReport.vue'
import EquipmentDetails from '@/views/wave-fire/mission/intervention/edit/EquipmentDetails.vue'
import InterventionCheckList from '@/views/wave-fire/mission/intervention/edit/InterventionCheckList.vue'
 
import { useInterventionListStore } from '@/views/wave-fire/mission/intervention/useInterventionListStore'

const checkoutSteps = [
  {
    title: 'Basic Information',
    icon: 'tabler-360-view',
  },
  {
    title: 'Intervention CheckList',
    icon: 'tabler-checklist',
  },
  {
    title: 'Intervention Tasks',
    icon: 'tabler-list-details',
  },
  {
    title: 'Additional Tasks',
    icon: 'tabler-home-plus',
  },
  {
    title: 'Client Report',
    icon: 'tabler-report',
  },
]

const route = useRoute()
const interventionData = ref()
const checkListData = ref()
const technicians = ref([])
const interventionListStore = useInterventionListStore()
const isSnackbarVisible = ref(false)
const currentStep = ref(0)

//SECTION Functions
// 👉 Fetch Intervention
onMounted(() => {
  interventionListStore.fetchIntervention(Number(route.params.id)).then(response => {
    interventionData.value = response.data.data
  })
  interventionListStore.fetchCheckList(Number(route.params.id)).then(response => {
    checkListData.value = response.data.data
  })
})
 
// 👉 Update Intervention
const updateIntervention = async  updatedInterventionData => {
  try {
    const response = await interventionListStore.updateIntervention(Number(route.params.id), updatedInterventionData)
    if (response.status === 200) {
      isSnackbarVisible.value = true
    } else {
      throw new Error(`Failed to update intervention: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Update CheckList
const updateCheckList = async  updateCheckListData => {
  try {
    const response = await interventionListStore.updateCheckList(Number(route.params.id), updateCheckListData)
    if (response.status === 200) {
      isSnackbarVisible.value = true
    } else {
      throw new Error(`Failed to update intervention: ${response.statusText}`)
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
      Intervention Data Updated Successfully
    </VSnackbar>
    <VCard v-if="interventionData">
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
            <BasicInterventionInformation
              v-model:current-step="currentStep"
              :intervention-data="interventionData"
              @submit="updateIntervention"
            />
          </VWindowItem>
          <VWindowItem>
            <InterventionCheckList
              v-model:current-step="currentStep" 
              :check-list-data="checkListData"
              @submit="updateCheckList"
            />
          </VWindowItem>
          <VWindowItem>
            <EquipmentDetails 
              v-model:current-step="currentStep"
              :intervention-data="interventionData"
            />
          </VWindowItem>
          <VWindowItem>
            <AdditionalTasks 
              v-model:current-step="currentStep"
              :intervention-data="interventionData"
            />
          </VWindowItem>
          <VWindowItem>
            <ClientReport 
              v-model:current-step="currentStep"
              :intervention-data="interventionData"
              @submit="updateIntervention"
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
