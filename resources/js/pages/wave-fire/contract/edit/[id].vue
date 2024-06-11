<script setup>
import BasicContractInformation from '@/views/wave-fire/contract/edit/BasicContractInformation.vue'
import ContractParams from '@/views/wave-fire/contract/edit/ContractParams.vue'
import ContractMonitoring from '@/views/wave-fire/contract/edit/ContractMonitoring.vue'
import { useContractListStore } from '@/views/wave-fire/contract/useContractListStore'

const checkoutSteps = [
  {
    title: 'Basic Information',
    icon: 'tabler-360-view',
  },
  {
    title: 'Contract Params',
    icon: 'tabler-adjustments',
  },
  {
    title: 'Contract Monitoring',
    icon: 'tabler-heart-rate-monitor',
  },
]

const route = useRoute()
const contractData = ref()
const technicians = ref([])
const contractListStore = useContractListStore()
const isSnackbarVisible = ref(false)
const currentStep = ref(0)

//SECTION Functions
// 👉 Fetch Contract
onMounted(() => {
  contractListStore.fetchContract(Number(route.params.id)).then(response => {
    contractData.value = response.data.data
  })
})

// 👉 Fetch Technicians
onMounted(() => {
  contractListStore.fetchTechnicians()
    .then(response => {
      technicians.value = response.data.data.map(technician => ({ ...technician }))
      console.log(technicians.value)
    }).catch(error => {
      console.error(error)
    })
})
 

// 👉 Update Contract
const updateContract = async  updatedContractData => {
  try {
    const response = await contractListStore.updateContract(Number(route.params.id), updatedContractData)
    if (response.status === 200) {
      isSnackbarVisible.value = true
    } else {
      throw new Error(`Failed to update contract: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}
</script>

<template>
  <!-- 👉 SnackBar Notification -->
  <VSnackbar 
    v-model="isSnackbarVisible"
    transition="scroll-y-reverse-transition"
  >
    Contract Data Updated Successfully
  </VSnackbar>
  <VCard v-if="contractData">
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
          <BasicContractInformation
            v-model:current-step="currentStep"
            :contract-data="contractData"
            @submit="updateContract"
          />
        </VWindowItem>
        <VWindowItem>
          <ContractParams
            v-model:current-step="currentStep"
            :contract-data="contractData"
            :technicians="technicians"
            @submit="updateContract"
          />
        </VWindowItem>
        <VWindowItem>
          <ContractMonitoring
            v-model:current-step="currentStep"
            :contract-data="contractData"
            :technicians="technicians"
            @submit="updateContract"
          />
        </VWindowItem>
      </VWindow>
    </VCardText>
  </VCard>
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
@/views/wave-fire/contract/useContractListStore
