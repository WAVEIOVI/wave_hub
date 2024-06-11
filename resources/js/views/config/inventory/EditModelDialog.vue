<script setup>
import { useEquipmentParamsStore } from './useEquipmentParamsStore'

const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  fetchedModelData: {
    type: Object,
    required: true,
  },
  accessories: {
    type: Array,
    required: true,
  },
  pressures: {
    type: Array,
    required: true,
  },
  protections: {
    type: Array,
    required: true,
  },
  weights: {
    type: Array,
    required: true,
  },
  maintenances: {
    type: Array,
    required: true,
  },
  additionalMaintenances: {
    type: Array,
    required: true,
  },
  supplies: {
    type: Array,
    required: true,
  },
})

const emit = defineEmits([
  'update:isDialogVisible',
  'submit',
])

const currentStep = ref(0)

const createApp = [
  {
    icon: 'tabler-category',
    title: 'Category',
  },
  {
    icon: 'tabler-category-plus',
    title: 'Features',
  },
  {
    icon: 'tabler-tool',
    title: 'Services',
  },
]

const equipmentParamsStore = useEquipmentParamsStore()
const fetchedModelData = ref((props.fetchedModelData))
const fetchedAccessories = ref([])
const selectedAccessories = ref([])
const fetchedPressures = ref([])
const selectedPressures = ref([])
const fetchedProtections = ref([])
const selectedProtections = ref([])
const fetchedWeights = ref([])
const selectedWeights = ref([])
const fetchedMaintenances = ref([])
const selectedMaintenances = ref([])
const fetchedAdditionalMaintenances = ref([])
const selectedAdditionalMaintenances = ref([])
const fetchedSupplies = ref([])
const selectedSupplies = ref([])

// 👉 Fetch  Model Accessories
const fetchModelAccessories = () => {
  if (!fetchedModelData.value.id) return
  equipmentParamsStore.fetchModelAccessories(fetchedModelData.value.id)
    .then(response => {
      fetchedAccessories.value = response.data.data
      console.log(fetchedAccessories.value)
    }).catch(error => {
      console.error(error)
    })
}

// 👉 Fetch  Model Pressures
const fetchModelPressures = () => {
  if (!fetchedModelData.value.id) return
  equipmentParamsStore.fetchModelPressures(fetchedModelData.value.id)
    .then(response => {
      fetchedPressures.value = response.data.data
      console.log(fetchedPressures.value)
    }).catch(error => {
      console.error(error)
    })
}

const fetchModelWeights = () => {
  if (!fetchedModelData.value.id) return
  equipmentParamsStore.fetchModelWeights(fetchedModelData.value.id)
    .then(response => {
      fetchedWeights.value = response.data.data
      console.log(fetchedWeights.value)
    }).catch(error => {
      console.error(error)
    })
}

const fetchModelProtections = () => {
  if (!fetchedModelData.value.id) return
  equipmentParamsStore.fetchModelProtections(fetchedModelData.value.id)
    .then(response => {
      fetchedProtections.value = response.data.data
      console.log(fetchedProtections.value)
    }).catch(error => {
      console.error(error)
    })
}

const fetchModelMaintenances = () => {
  if (!fetchedModelData.value.id) return
  equipmentParamsStore.fetchModelMaintenances(fetchedModelData.value.id)
    .then(response => {
      fetchedMaintenances.value = response.data.data
      console.log(fetchedMaintenances.value)
    }).catch(error => {
      console.error(error)
    })
}

const fetchModelAdditionalMaintenances = () => {
  if (!fetchedModelData.value.id) return
  equipmentParamsStore.fetchModelAdditionalMaintenances(fetchedModelData.value.id)
    .then(response => {
      fetchedAdditionalMaintenances.value = response.data.data
      console.log(fetchedAdditionalMaintenances.value)
    }).catch(error => {
      console.error(error)
    })
}

const fetchModelSupplies = () => {
  if (!fetchedModelData.value.id) return
  equipmentParamsStore.fetchModelSupplies(fetchedModelData.value.id)
    .then(response => {
      fetchedSupplies.value = response.data.data
      console.log(fetchedSupplies.value)
    }).catch(error => {
      console.error(error)
    })
}


const fetchedAccessoriesIds = computed(() => {
  return fetchedAccessories.value.map(accessory => accessory.id)
})

const fetchedPressuresIds = computed(() => {
  return fetchedPressures.value.map(pressure => pressure.id)
})

const fetchedProtectionsIds = computed(() => {
  return fetchedProtections.value.map(protection => protection.id)
})

const fetchedWeightsIds = computed(() => {
  return fetchedWeights.value.map(weight => weight.id)
})

const fetchedMaintenancesIds = computed(() => {
  return fetchedMaintenances.value.map(maintenance => maintenance.id)
})

const fetchedAdditionalMaintenancesIds = computed(() => {
  return fetchedAdditionalMaintenances.value.map(additionalMaintenance => additionalMaintenance.id)
})

const fetchedSuppliesIds = computed(() => {
  return fetchedSupplies.value.map(supply => supply.id)
})

watch(
  () => props.fetchedModelData,
  newValue => {
    fetchedModelData.value = newValue
    console.log('fetchedModelData in child:', fetchedModelData.value)
  },
  { deep: true },
)

watch(
  () => fetchedModelData.value.id,
  (newValue, oldValue) => {
    if (newValue) {
      fetchModelAccessories()
      fetchModelProtections()
      fetchModelPressures()
      fetchModelWeights()
      fetchModelMaintenances()
      fetchModelAdditionalMaintenances()
      fetchModelSupplies()
    }
  },
)

watch(
  () => fetchedAccessories.value,
  newValue => {
    selectedAccessories.value = fetchedAccessoriesIds.value
  },
  { immediate: true },
)
watch(
  () => fetchedProtections.value,
  newValue => {
    selectedProtections.value = fetchedProtectionsIds.value
  },
  { immediate: true },
)
watch(
  () => fetchedPressures.value,
  newValue => {
    selectedPressures.value = fetchedPressuresIds.value
  },
  { immediate: true },
)
watch(
  () => fetchedWeights.value,
  newValue => {
    selectedWeights.value = fetchedWeightsIds.value
  },
  { immediate: true },
)
watch(
  () => fetchedMaintenances.value,
  newValue => {
    selectedMaintenances.value = fetchedMaintenancesIds.value
  },
  { immediate: true },
)
watch(
  () => fetchedAdditionalMaintenances.value,
  newValue => {
    selectedAdditionalMaintenances.value = fetchedAdditionalMaintenancesIds.value
  },
  { immediate: true },
)
watch(
  () => fetchedSupplies.value,
  newValue => {
    selectedSupplies.value = fetchedSuppliesIds.value
  },
  { immediate: true },
)

const handleAccessoryAttachment = async () => {
  try {
    // Get the current model ID
    const modelId = fetchedModelData.value.id

    // Get the list of currently attached accessory IDs
    const currentAccessoryIds = fetchedAccessoriesIds.value

    // Get the list of newly selected accessory IDs
    const newlySelectedAccessoryIds = selectedAccessories.value

    // Find the IDs of accessories that need to be attached
    const accessoriesToAttach = newlySelectedAccessoryIds.filter(id => !currentAccessoryIds.includes(id))

    // Find the IDs of accessories that need to be detached
    const accessoriesToDetach = currentAccessoryIds.filter(id => !newlySelectedAccessoryIds.includes(id))

    // Attach new accessories
    for (const accessoryId of accessoriesToAttach) {
      await equipmentParamsStore.attachNewAccessory(modelId, accessoryId)
    }

    // Detach removed accessories
    for (const accessoryId of accessoriesToDetach) {
      await equipmentParamsStore.detachAccessory(modelId, accessoryId)
    }

    // Refresh the list of fetched accessories
    fetchModelAccessories()
  } catch (error) {
    console.error(error)
  }
}

const handleProtectionAttachment = async () => {
  try {
    // Get the current model ID
    const modelId = fetchedModelData.value.id

    // Get the list of currently attached protection IDs
    const currentProtectionIds = fetchedProtectionsIds.value

    // Get the list of newly selected protection IDs
    const newlySelectedProtectionIds = selectedProtections.value

    // Find the IDs of protections that need to be attached
    const protectionsToAttach = newlySelectedProtectionIds.filter(id => !currentProtectionIds.includes(id))

    // Find the IDs of protections that need to be detached
    const protectionsToDetach = currentProtectionIds.filter(id => !newlySelectedProtectionIds.includes(id))

    // Attach new protections
    for (const protectionId of protectionsToAttach) {
      await equipmentParamsStore.attachNewProtection(modelId, protectionId)
    }

    // Detach removed protections
    for (const protectionId of protectionsToDetach) {
      await equipmentParamsStore.detachProtection(modelId, protectionId)
    }

    // Refresh the list of fetched protections
    fetchModelProtections()
  } catch (error) {
    console.error(error)
  }
}

const handlePressureAttachment = async () => {
  try {
    // Get the current model ID
    const modelId = fetchedModelData.value.id

    // Get the list of currently attached pressure IDs
    const currentPressureIds = fetchedPressuresIds.value

    // Get the list of newly selected pressure IDs
    const newlySelectedPressureIds = selectedPressures.value

    // Find the IDs of pressures that need to be attached
    const pressuresToAttach = newlySelectedPressureIds.filter(id => !currentPressureIds.includes(id))

    // Find the IDs of pressures that need to be detached
    const pressuresToDetach = currentPressureIds.filter(id => !newlySelectedPressureIds.includes(id))

    // Attach new pressures
    for (const pressureId of pressuresToAttach) {
      await equipmentParamsStore.attachNewPressure(modelId, pressureId)
    }

    // Detach removed pressures
    for (const pressureId of pressuresToDetach) {
      await equipmentParamsStore.detachPressure(modelId, pressureId)
    }

    // Refresh the list of fetched pressures
    fetchModelPressures()
  } catch (error) {
    console.error(error)
  }
}

const handleWeightAttachment = async () => {
  try {
    // Get the current model ID
    const modelId = fetchedModelData.value.id

    // Get the list of currently attached Weight IDs
    const currentWeightIds = fetchedWeightsIds.value

    // Get the list of newly selected Weight IDs
    const newlySelectedWeightIds = selectedWeights.value

    // Find the IDs of Weights that need to be attached
    const weightsToAttach = newlySelectedWeightIds.filter(id => !currentWeightIds.includes(id))

    // Find the IDs of weights that need to be detached
    const weightsToDetach = currentWeightIds.filter(id => !newlySelectedWeightIds.includes(id))

    // Attach new weights
    for (const weightId of weightsToAttach) {
      await equipmentParamsStore.attachNewWeight(modelId, weightId)
    }

    // Detach removed weights
    for (const weightId of weightsToDetach) {
      await equipmentParamsStore.detachWeight(modelId, weightId)
    }

    // Refresh the list of fetched Weights
    fetchModelWeights()
  } catch (error) {
    console.error(error)
  }
}

const handleMaintenanceAttachment = async () => {
  try {
    // Get the current model ID
    const modelId = fetchedModelData.value.id

    // Get the list of currently attached maintenance IDs
    const currentMaintenanceIds = fetchedMaintenancesIds.value

    // Get the list of newly selected maintenance IDs
    const newlySelectedMaintenanceIds = selectedMaintenances.value

    // Find the IDs of maintenances that need to be attached
    const maintenancesToAttach = newlySelectedMaintenanceIds.filter(id => !currentMaintenanceIds.includes(id))

    // Find the IDs of maintenances that need to be detached
    const maintenancesToDetach = currentMaintenanceIds.filter(id => !newlySelectedMaintenanceIds.includes(id))

    // Attach new maintenances
    for (const maintenanceId of maintenancesToAttach) {
      await equipmentParamsStore.attachNewMaintenance(modelId, maintenanceId)
    }

    // Detach removed maintenances
    for (const maintenanceId of maintenancesToDetach) {
      await equipmentParamsStore.detachMaintenance(modelId, maintenanceId)
    }

    // Refresh the list of fetched maintenances
    fetchModelMaintenances()
  } catch (error) {
    console.error(error)
  }
}

const handleAdditionalMaintenanceAttachment = async () => {
  try {
    // Get the current model ID
    const modelId = fetchedModelData.value.id

    // Get the list of currently attached additionalAdditionalMaintenance IDs
    const currentAdditionalMaintenanceIds = fetchedAdditionalMaintenancesIds.value

    // Get the list of newly selected additionalMaintenance IDs
    const newlySelectedAdditionalMaintenanceIds = selectedAdditionalMaintenances.value

    // Find the IDs of additionalMaintenances that need to be attached
    const additionalMaintenancesToAttach = newlySelectedAdditionalMaintenanceIds.filter(id => !currentAdditionalMaintenanceIds.includes(id))

    // Find the IDs of additionalMaintenances that need to be detached
    const additionalMaintenancesToDetach = currentAdditionalMaintenanceIds.filter(id => !newlySelectedAdditionalMaintenanceIds.includes(id))

    // Attach new additionalMaintenances
    for (const additionalMaintenanceId of additionalMaintenancesToAttach) {
      await equipmentParamsStore.attachNewAdditionalMaintenance(modelId, additionalMaintenanceId)
    }

    // Detach removed additionalMaintenances
    for (const additionalMaintenanceId of additionalMaintenancesToDetach) {
      await equipmentParamsStore.detachAdditionalMaintenance(modelId, additionalMaintenanceId)
    }

    // Refresh the list of fetched additionalMaintenances
    fetchModelAdditionalMaintenances()
  } catch (error) {
    console.error(error)
  }
}

const handleSupplyAttachment = async () => {
  try {
    // Get the current model ID
    const modelId = fetchedModelData.value.id

    // Get the list of currently attached supply IDs
    const currentSupplyIds = fetchedSuppliesIds.value

    // Get the list of newly selected supply IDs
    const newlySelectedSupplyIds = selectedSupplies.value

    // Find the IDs of supplies that need to be attached
    const suppliesToAttach = newlySelectedSupplyIds.filter(id => !currentSupplyIds.includes(id))

    // Find the IDs of supplies that need to be detached
    const suppliesToDetach = currentSupplyIds.filter(id => !newlySelectedSupplyIds.includes(id))

    // Attach new supplies
    for (const supplyId of suppliesToAttach) {
      await equipmentParamsStore.attachNewSupply(modelId, supplyId)
    }

    // Detach removed supplies
    for (const supplyId of suppliesToDetach) {
      await equipmentParamsStore.detachSupply(modelId, supplyId)
    }

    // Refresh the list of fetched supplies
    fetchModelSupplies()
  } catch (error) {
    console.error(error)
  }
}

const inspection = computed({
  get() {
    return !!fetchedModelData.value.inspection
  },
  set(value) {
    fetchedModelData.value.inspection = value ? 1 : 0
  },
})

const rawRecharge = computed({
  get() {
    return !!fetchedModelData.value.raw_recharge
  },
  set(value) {
    fetchedModelData.value.raw_recharge = value ? 1 : 0
  },
})

const nitrogenRecharge = computed({
  get() {
    return !!fetchedModelData.value.nitrogen_recharge
  },
  set(value) {
    fetchedModelData.value.nitrogen_recharge = value ? 1 : 0
  },
})

const resetForm = () => {
  emit('update:isDialogVisible', false)
  currentStep.value = 0 // Reset to the first step
}

const updateModelOnFormSubmit = () => {
  emit('submit', fetchedModelData.value)
  handleAccessoryAttachment()
  handleProtectionAttachment()
  handlePressureAttachment()
  handleWeightAttachment()
  handleMaintenanceAttachment()
  handleAdditionalMaintenanceAttachment()
  handleSupplyAttachment()
  resetForm()
}
</script>

<template>
  <VDialog
    :model-value="props.isDialogVisible"
    max-width="900"
    @update:model-value="val => $emit('update:isDialogVisible', val)"
  >
    <!-- 👉 Dialog close btn -->
    <DialogCloseBtn @click="resetForm" />
    <!-- Dialog Content -->
    <VCard class="create-app-dialog">
      <VCardText class="pa-5 pa-sm-10">
        <h5 class="text-h5 text-center mb-2">
          Edit Model
        </h5>
        <p class="text-sm text-center mb-8">
          Provide data with this form to add new Equipment Model.
        </p>
        <VRow>
          <VCol
            cols="12"
            sm="5"
            md="4"
            lg="3"
          >
            <AppStepper
              v-model:current-step="currentStep"
              direction="vertical"
              :items="createApp"
              icon-size="24"
              class="stepper-icon-step-bg"
            />
          </VCol>

          <VCol
            cols="12"
            sm="7"
            md="8"
            lg="9"
          >
            <VWindow
              v-model="currentStep"
              class="disable-tab-transition stepper-content"
            >
              <VForm
                class="mt-4"
                @submit.prevent="updateModelOnFormSubmit"
              >
                <!-- 👉 Category -->
                <VWindowItem>
                  <h6 class="text-h6 my-4">
                    Model Details
                  </h6>
                  <VRow>
                    <!-- 👉 Category Id -->
                    <VCol cols="4">
                      <VTextField 
                        v-model="fetchedModelData.model_category_id"
                        label="Category Id"
                        readonly
                      />
                    </VCol>
                    <!-- 👉 Category Name -->
                    <VCol cols="8">
                      <VTextField 
                        v-model="fetchedModelData.category_name"
                        label="Category Name"
                        readonly
                      />
                    </VCol>
                    <VCol cols="12">
                      <h6 class="text-h6">
                        Insert Model
                      </h6>
                    </VCol>
                    <!-- 👉 Model Name -->
                    <VCol cols="4">
                      <VTextField 
                        v-model="fetchedModelData.model_id"
                        label="Model ID"
                      />
                    </VCol>
                    <VCol cols="8">
                      <VTextField 
                        v-model="fetchedModelData.name"
                        label="Model Name"
                      />
                    </VCol>
                    <VCol cols="12">
                      <VTextarea
                        v-model="fetchedModelData.description"
                        rows="2"
                        variant="outlined"
                        label="Description"
                      />
                    </VCol>
                    <VCol cols="12">
                      <h6 class="text-h6 my-0">
                        Basic Inspection
                      </h6>
                    </VCol>
                    <VCol cols="4">
                      <VCheckbox
                        v-model="inspection"
                        label="Inspection"
                      />
                    </VCol>
                    <VCol cols="4">
                      <VCheckbox
                        v-model="rawRecharge"
                        label="Raw Recharge"
                      />
                    </VCol>
                    <VCol cols="4">
                      <VCheckbox
                        v-model="nitrogenRecharge"
                        label="Nitrogen Recharge"
                      />
                    </VCol>
                  </VRow>
                </VWindowItem>
                <VWindowItem>
                  <VRow>
                    <VCol cols="12">
                      <VRow>
                        <VCol cols="12">
                          <h4>Select weight</h4>
                        </VCol>
                        <VCol
                          class="demo-space-x d-flex flex-wrap gap-0"
                          cols="12"
                        >
                          <VCheckbox
                            v-for="weight in props.weights"
                            :key="weight.id"
                            v-model="selectedWeights"
                            :label="weight.value + ' ' + weight.unit"
                            :value="weight.id"
                            multiple
                            :checked="fetchedWeightsIds.includes(weight.id)"
                          />
                        </VCol>
                      </VRow>
                      <VRow>
                        <VCol cols="12">
                          <h4>Select accessory</h4>
                        </VCol>
                        <VCol
                          class="demo-space-x d-flex flex-wrap gap-0"
                          cols="12"
                        >
                          <VCheckbox
                            v-for="accessory in props.accessories"
                            :key="accessory.id"
                            v-model="selectedAccessories"
                            :label="accessory.name"
                            :value="accessory.id"
                            multiple
                            :checked="fetchedAccessoriesIds.includes(accessory.id)"
                          />
                        </VCol>
                      </VRow>
                      <VRow class="d-flex flex-wrap gap-0 pa-0 pt-0">
                        <VCol cols="12">
                          <h4>Select Protection</h4>
                        </VCol>
                        <VCol
                          class="demo-space-x demo-space-x d-flex flex-wrap gap-0"
                          cols="12"
                        >
                          <VCheckbox
                            v-for="protection in props.protections"
                            :key="protection.id"
                            v-model="selectedProtections"
                            :label="protection.name"
                            :value="protection.id"
                            multiple
                            :checked="fetchedProtectionsIds.includes(protection.id)"
                          />
                        </VCol>
                      </VRow>
                      <VRow class="d-flex flex-wrap gap-0 pa-0 pt-0">
                        <VCol cols="12">
                          <h4>Select Pressure</h4>
                        </VCol>
                        <VCol
                          class="demo-space-x demo-space-x d-flex flex-wrap gap-0"
                          cols="12"
                        >
                          <VCheckbox
                            v-for="pressure in props.pressures"
                            :key="pressure.id"
                            v-model="selectedPressures"
                            :label="pressure.name"
                            :value="pressure.id"
                            multiple
                            :checked="fetchedPressuresIds.includes(pressure.id)"
                          />
                        </VCol>
                      </VRow>
                    </VCol>
                  </VRow>
                </VWindowItem>
                <VWindowItem>
                  <VRow>
                    <VCol cols="12">
                      <VRow>
                        <VCol cols="12">
                          <h4>Select Maintenance</h4>
                        </VCol>
                        <VCol
                          class="demo-space-x d-flex flex-wrap gap-0"
                          cols="12"
                        >
                          <VCheckbox
                            v-for="maintenance in props.maintenances"
                            :key="maintenance.id"
                            v-model="selectedMaintenances"
                            :label="maintenance.name"
                            :value="maintenance.id"
                            multiple
                            :checked="fetchedMaintenancesIds.includes(maintenance.id)"
                          />
                        </VCol>
                      </VRow>
                      <VRow>
                        <VCol cols="12">
                          <h4>Select Additional Maintenance</h4>
                        </VCol>
                        <VCol
                          class="demo-space-x d-flex flex-wrap gap-0"
                          cols="12"
                        >
                          <VCheckbox
                            v-for="additionalMaintenance in props.additionalMaintenances"
                            :key="additionalMaintenance.id"
                            v-model="selectedAdditionalMaintenances"
                            :label="additionalMaintenance.name"
                            :value="additionalMaintenance.id"
                            multiple
                            :checked="fetchedAdditionalMaintenancesIds.includes(additionalMaintenance.id)"
                          />
                        </VCol>
                      </VRow>
                      <VRow class="d-flex flex-wrap gap-0 pa-0 pt-0">
                        <VCol cols="12">
                          <h4>Select Supply</h4>
                        </VCol>
                        <VCol
                          class="demo-space-x demo-space-x d-flex flex-wrap gap-0"
                          cols="12"
                        >
                          <VCheckbox
                            v-for="supply in props.supplies"
                            :key="supply.id"
                            v-model="selectedSupplies"
                            :label="supply.name"
                            :value="supply.id"
                            multiple
                            :checked="fetchedSuppliesIds.includes(supply.id)"
                          />
                        </VCol>
                      </VRow>
                    </VCol>
                  </VRow>
                </VWindowItem>
              </VForm>
            </VWindow>

            <div class="d-flex justify-space-between mt-8">
              <VBtn
                variant="tonal"
                color="secondary"
                :disabled="currentStep === 0"
                @click="currentStep--"
              >
                <VIcon
                  icon="tabler-arrow-left"
                  start
                  class="flip-in-rtl"
                />
                Previous
              </VBtn>

              <VBtn
                v-if="createApp.length - 1 === currentStep"
                color="success"
                @click="updateModelOnFormSubmit"
              >
                submit
                <VIcon
                  icon="tabler-check"
                  end
                  class="flip-in-rtl"
                />
              </VBtn>

              <VBtn
                v-else
                @click="currentStep++"
              >
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
      </VCardText>
    </VCard>
  </VDialog>
</template>


<style lang="scss">
.stepper-content .card-list {
  --v-card-list-gap: 24px;
}
</style>
