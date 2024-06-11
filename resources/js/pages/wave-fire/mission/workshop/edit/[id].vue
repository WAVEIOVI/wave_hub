<script setup>
import BasicWorkshopInformation from '@/views/wave-fire/mission/workshop/edit/BasicWorkshopInformation.vue'
import ClientReport from '@/views/wave-fire/mission/workshop/edit/ClientReport.vue'
import EquipmentDetails from '@/views/wave-fire/mission/workshop/edit/EquipmentDetails.vue'
 
import { useWorkshopListStore } from '@/views/wave-fire/mission/workshop/useWorkshopListStore'

const checkoutSteps = [
  {
    title: 'Basic Information',
    icon: 'tabler-360-view',
  },
  {
    title: 'Workshop Tasks',
    icon: 'tabler-list-details',
  },
  {
    title: 'Client Report',
    icon: 'tabler-report',
  },
]

const route = useRoute()
const workshopData = ref()
const checkListData = ref()
const technicians = ref([])
const workshopListStore = useWorkshopListStore()
const isSnackbarVisible = ref(false)
const currentStep = ref(0)

//SECTION Functions
// 👉 Fetch Workshop
onMounted(() => {
  workshopListStore.fetchWorkshop(Number(route.params.id)).then(response => {
    workshopData.value = response.data.data
  })
  workshopListStore.fetchCheckList(Number(route.params.id)).then(response => {
    checkListData.value = response.data.data
  })
})
 
// 👉 Update Workshop
const updateWorkshop = async  updatedWorkshopData => {
  try {
    const response = await workshopListStore.updateWorkshop(Number(route.params.id), updatedWorkshopData)
    if (response.status === 200) {
      isSnackbarVisible.value = true
    } else {
      throw new Error(`Failed to update workshop: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Update CheckList
const updateCheckList = async  updateCheckListData => {
  try {
    const response = await workshopListStore.updateCheckList(Number(route.params.id), updateCheckListData)
    if (response.status === 200) {
      isSnackbarVisible.value = true
    } else {
      throw new Error(`Failed to update workshop: ${response.statusText}`)
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
      Workshop Data Updated Successfully
    </VSnackbar>
    <VCard v-if="workshopData">
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
            <BasicWorkshopInformation
              v-model:current-step="currentStep"
              :workshop-data="workshopData"
              @submit="updateWorkshop"
            />
          </VWindowItem>
          <VWindowItem>
            <EquipmentDetails 
              v-model:current-step="currentStep"
              :workshop-data="workshopData"
            />
          </VWindowItem>
          <VWindowItem>
            <ClientReport 
              v-model:current-step="currentStep"
              :workshop-data="workshopData"
              @submit="updateWorkshop"
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
