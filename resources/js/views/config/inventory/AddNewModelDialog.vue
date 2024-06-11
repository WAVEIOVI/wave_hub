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
  categories: {
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

const accessories = ref((props.accessories))
const pressures = ref((props.pressures))
const weights = ref((props.weights))
const protections = ref((props.protections))
const fetchedModelData = ref((props.fetchedModelData))
const equipmentParamsStore = useEquipmentParamsStore()
const categories = ref((props.categories))
const supplies = ref((props.supplies))
const maintenances = ref((props.maintenances))
const additionalMaintenances = ref((props.additionalMaintenances))

const categoryData = ref({
  category_id: '',
  name: '',
})

const modelData = ref({
  equipment_category_id: '',
  model_category_id: '',
  category_name: '',
  model_id: '',
  name: '',
  description: '',
  inspection: '',
  raw_recharge: '',
  nitrogen_recharge: '',
})

const resetForm = () => {
  emit('update:isDialogVisible', false)
  selectedAccessories.value = []
  selectedPressures.value = []
  selectedProtections.value = []
  selectedWeights.value = []
  selectedSupplies.value = []
  selectedMaintenances.value = []
  selectedAdditionalMaintenances.value = []

  modelData.value = {
    equipment_category_id: '',
    model_category_id: '',
    category_name: '',
    model_id: '',
    name: '',
    description: '',
    inspection: '',
    raw_recharge: '',
    nitrogen_recharge: '',
  }
  currentStep.value = 0 // Reset to the first step
}

// 👉 Fetch category
const fetchCategory = () => {
  if (!modelData.value.equipment_category_id) return
  equipmentParamsStore.fetchCategory(modelData.value.equipment_category_id)
    .then(response => {
      categoryData.value = response.data.data
      modelData.value.equipment_category_id = categoryData.value.id
      modelData.value.model_category_id = categoryData.value.category_id
      modelData.value.category_name = categoryData.value.name
    }).catch(error => {
      console.error(error)
    })
}

const selectedAccessories = ref([])
const selectedPressures = ref([])
const selectedProtections = ref([])
const selectedWeights = ref([])
const selectedSupplies = ref([])
const selectedMaintenances = ref([])
const selectedAdditionalMaintenances = ref([])

// 👉 Attach Accessory
const attachAccessory = async () => {
  try {
    const response = await equipmentParamsStore.attachAccessory(
      fetchedModelData.value.id,
      selectedAccessories.value,
    )

    if (response.status === 200) {
      console.log('Accessory Attached')
    } else {
      throw new Error(`Failed to attach accessory: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Attach Pressure
const attachPressure = async () => {
  try {
    const response = await equipmentParamsStore.attachPressure(
      fetchedModelData.value.id,
      selectedPressures.value,
    )

    if (response.status === 200) {
      console.log('Pressure Attached')
    } else {
      throw new Error(`Failed to attach Pressure: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Attach Protection
const attachProtection = async () => {
  try {
    const response = await equipmentParamsStore.attachProtection(
      fetchedModelData.value.id,
      selectedProtections.value,
    )

    if (response.status === 200) {
      console.log('Protection Attached')
    } else {
      throw new Error(`Failed to attach Protection: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Attach Weight
const attachWeight = async () => {
  try {
    const response = await equipmentParamsStore.attachWeight(
      fetchedModelData.value.id,
      selectedWeights.value,
    )

    if (response.status === 200) {
      console.log('Weight Attached')
    } else {
      throw new Error(`Failed to attach Weight: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Attach Maintenance
const attachMaintenance = async () => {
  try {
    const response = await equipmentParamsStore.attachMaintenance(
      fetchedModelData.value.id,
      selectedMaintenances.value,
    )

    if (response.status === 200) {
      console.log('Maintenance Attached')
    } else {
      throw new Error(`Failed to attach Maintenance: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Attach Additional Maintenance
const attachAdditionalMaintenance = async () => {
  try {
    const response = await equipmentParamsStore.attachAdditionalMaintenance(
      fetchedModelData.value.id,
      selectedAdditionalMaintenances.value,
    )

    if (response.status === 200) {
      console.log('Additional Maintenance Attached')
    } else {
      throw new Error(`Failed to attach Additional Maintenance: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Attach Supply
const attachSupply = async () => {
  try {
    const response = await equipmentParamsStore.attachSupply(
      fetchedModelData.value.id,
      selectedSupplies.value,
    )

    if (response.status === 200) {
      console.log('Supply Attached')
    } else {
      throw new Error(`Failed to attach Supply: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

const onFormSubmit = () => {
  attachAccessory()
  attachPressure()
  attachWeight()
  attachProtection()
  attachMaintenance()
  attachAdditionalMaintenance()
  attachSupply()
  resetForm()
}

watch(
  () => modelData.value.equipment_category_id,
  (newValue, oldValue) => {
    fetchCategory()
  },
)

watch(
  () => props.fetchedModelData,
  newValue => {
    fetchedModelData.value = newValue
    console.log('fetchedModelData in child:', fetchedModelData.value)
  },
  { deep: true },
)

watch(
  () => props.categories,
  newValue => {
    categories.value = newValue
    console.log('categories in child:', categories.value)
  },
  { deep: true },
)

watch(
  () => props.accessories,
  newValue => {
    accessories.value = newValue
    console.log('accessories in child:', accessories.value)
  },
  { deep: true },
)

watch(
  () => props.pressures,
  newValue => {
    pressures.value = newValue
    console.log('pressures in child:', pressures.value)
  },
  { deep: true },
)

watch(
  () => props.protections,
  newValue => {
    protections.value = newValue
    console.log('protections in child:', protections.value)
  },
  { deep: true },
)

watch(
  () => props.weights,
  newValue => {
    weights.value = newValue
    console.log('weights in child:', weights.value)
  },
  { deep: true },
)

watch(
  () => props.maintenances,
  newValue => {
    maintenances.value = newValue
    console.log('maintenances in child:', maintenances.value)
  },
  { deep: true },
)

watch(
  () => props.additionalMaintenances,
  newValue => {
    additionalMaintenances.value = newValue
    console.log('additionalMaintenances in child:', additionalMaintenances.value)
  },
  { deep: true },
)

watch(
  () => props.supplies,
  newValue => {
    supplies.value = newValue
    console.log('supplies in child:', supplies.value)
  },
  { deep: true },
)

const addModelOnFormSubmit = () => {
  emit('submit', modelData.value)
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
          Add New Model
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
                @submit.prevent="addModelOnFormSubmit"
              >
                <!-- 👉 Category -->
                <VWindowItem>
                  <h6 class="text-h6 my-0">
                    Category
                  </h6>
                  <VRow>
                    <VCol cols="6">
                      <!-- 👉 Category -->
                      <AppSelect
                        v-model="modelData.equipment_category_id"
                        label="Select category"
                        item-title="name"
                        item-value="id"
                        :items="categories"
                        clearable
                        clear-icon="tabler-x"
                        @input="fetchCategory"
                      >
                        <template #item="{ props: itemProps, item }">  
                          <VListItem
                            v-bind="itemProps"
                            :subtitle="item.raw.category_id"
                          />
                        </template>
                      </AppSelect>
                    </VCol>
                  </VRow>
                  <VRow v-if="modelData.equipment_category_id">
                    <!-- 👉 Category Id -->
                    <VCol cols="4">
                      <VTextField 
                        v-model="modelData.model_category_id"
                        label="Category Id"
                        readonly
                      />
                    </VCol>

                    <!-- 👉 Category Name -->
                    <VCol cols="8">
                      <VTextField 
                        v-model="modelData.category_name"
                        label="Category Name"
                        readonly
                      />
                    </VCol>
                    <VCol cols="12">
                      <h6 class="text-h6 my-0">
                        Insert Model
                      </h6>
                    </VCol>
                    <!-- 👉 Model Name -->
                    <VCol cols="4">
                      <VTextField 
                        v-model="modelData.model_id"
                        label="Model ID"
                      />
                    </VCol>
                    <VCol cols="8">
                      <VTextField 
                        v-model="modelData.name"
                        label="Model Name"
                      />
                    </VCol>
                    <VCol cols="12">
                      <VTextarea
                        v-model="modelData.description"
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
                        v-model="modelData.inspection"
                        label="Inspection"
                      />
                    </VCol>
                    <VCol cols="4">
                      <VCheckbox
                        v-model="modelData.raw_recharge"
                        label="Raw Recharge"
                      />
                    </VCol>
                    <VCol cols="4">
                      <VCheckbox
                        v-model="modelData.nitrogen_recharge"
                        label="Nitrogen Recharge"
                      />
                    </VCol>
                    <VCol cols="12">
                      <VBtn
                        type="submit"
                        variant="outlined"
                        block
                        @click="currentStep++"
                      >
                        Add New Model
                      </VBtn>
                    </VCol>
                  </VRow>
                </VWindowItem>
                <VWindowItem>
                  <VRow>
                    <VCol cols="12">
                      <h4>Select Weight</h4>
                    </VCol>
                    <VCol cols="12">
                      <div class="demo-space-x">
                        <VCheckbox
                          v-for="item in weights"
                          :key="item.id"
                          v-model="selectedWeights"
                          :label="item.value + ' ' + item.unit"
                          :value="item.id"
                          multiple
                        />
                      </div>
                    </VCol>
                  </VRow>
                  <VRow>
                    <VCol cols="12">
                      <h4>Select Accessory</h4>
                    </VCol>
                    <VCol cols="12">
                      <div class="demo-space-x">
                        <VCheckbox
                          v-for="item in accessories"
                          :key="item.id"
                          v-model="selectedAccessories"
                          :label="item.name"
                          :value="item.id"
                          multiple
                        />
                      </div>
                    </VCol>
                  </VRow>
                  <VRow>
                    <VCol cols="12">
                      <h4>Select Pressure</h4>
                    </VCol>
                    <VCol cols="12">
                      <div class="demo-space-x">
                        <VCheckbox
                          v-for="item in pressures"
                          :key="item.id"
                          v-model="selectedPressures"
                          :label="item.name"
                          :value="item.id"
                          multiple
                        />
                      </div>
                    </VCol>
                  </VRow>
                  <VRow>
                    <VCol cols="12">
                      <h4>Select Protection</h4>
                    </VCol>
                    <VCol cols="12">
                      <div class="demo-space-x">
                        <VCheckbox
                          v-for="item in protections"
                          :key="item.id"
                          v-model="selectedProtections"
                          :label="item.name"
                          :value="item.id"
                          multiple
                        />
                      </div>
                    </VCol>
                  </VRow>
                </VWindowItem>
                <VWindowItem>
                  <VRow>
                    <VCol cols="12">
                      <h4>Select Maintenance</h4>
                    </VCol>
                    <VCol cols="12">
                      <div>
                        <VCheckbox
                          v-for="item in maintenances"
                          :key="item.id"
                          v-model="selectedMaintenances"
                          :label="item.name"
                          :value="item.id"
                          multiple
                        />
                      </div>
                    </VCol>
                  </VRow>
                  <VRow>
                    <VCol cols="12">
                      <h4>Select Additional Maintenance</h4>
                    </VCol>
                    <VCol cols="12">
                      <div>
                        <VCheckbox
                          v-for="item in additionalMaintenances"
                          :key="item.id"
                          v-model="selectedAdditionalMaintenances"
                          :label="item.name"
                          :value="item.id"
                          multiple
                        />
                      </div>
                    </VCol>
                  </VRow>
                  <VRow>
                    <VCol cols="12">
                      <h4>Select Supply</h4>
                    </VCol>
                    <VCol cols="12">
                      <div>
                        <VCheckbox
                          v-for="item in supplies"
                          :key="item.id"
                          v-model="selectedSupplies"
                          :label="item.name"
                          :value="item.id"
                          multiple
                        />
                      </div>
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
                @click="onFormSubmit"
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
