<script setup>
import { useEquipmentParamsStore } from '@/views/config/inventory/useEquipmentParamsStore'
import {
  customRequiredValidator,
} from '@validators'
import { StreamBarcodeReader } from "vue-barcode-reader"
import { VForm } from 'vuetify/components/VForm'

const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  areas: {
    type: Array,
    required: true,
  },
})

const emit = defineEmits([
  'update:isDialogVisible',
  'submit',
])

const currentStep = ref(0)

const errors = ref({
  qrc: '',
  category: '',
  model: '',
  area: '',
  status: '',
  weight: '',
  pressure: '',
})

const refVForm = ref()

const createApp = [
  {
    icon: 'tabler-scan',
    title: 'QRC Scanner',
  },
  {
    icon: 'tabler-category',
    title: 'Category',
  },
  {
    icon: 'tabler-adjustments-code',
    title: 'Model',
  },
  {
    icon: 'tabler-direction-sign-filled',
    title: 'Area',
  },
  {
    icon: 'tabler-id',
    title: 'Identification',
  },
  {
    icon: 'tabler-brand-appgallery',
    title: 'Accessories',
  },
  {
    icon: 'tabler-check',
    title: 'Status',
  },
]

const searchMethods = [
  {
    title: 'Creation By QR Code ',
    value: 'qr_code_search',
    icon: {
      icon: 'tabler-scan',
      size: '28',
    },
  },
  {
    title: 'Simple Creation',
    value: 'simple_search',
    icon: {
      icon: 'tabler-eye-search',
      size: '28',
    },
  },
]

const status = [
  {
    title: 'In Service',
    value: 'in service',
    icon: {
      icon: 'tabler-check',
      size: '28',
    },
  },
  {
    title: 'Limited Use',
    value: 'limited use',
    icon: {
      icon: 'tabler-eye-check',
      size: '28',
    },
  },
  {
    title: 'Out Of Order',
    value: 'out of order',
    icon: {
      icon: 'tabler-hotel-service',
      size: '28',
    },
  },
]

const equipmentParamsStore = useEquipmentParamsStore()
const categories = ref([])
const modelOptions = ref([])
const weightOptions = ref([])
const pressureOptions = ref([])
const protectionOptions = ref([])
const accessoryOptions = ref([])
const selectedAccessories = ref([])
const searchMode = ref('')

const selectedCategory = ref('')
const selectedModel = ref('')
const selectedWeight = ref('')
const selectedPressure = ref('')
const selectedProtection = ref('')

const equipmentData = ref({
  qrc_id: '',
  area_id: '',
  equipment_category_id: '',
  equipment_category: '',
  model_id: '',
  equipment_model_id: '',
  equipment_model: '',
  equipment_weight_unit: '',
  equipment_weight_value: '',
  equipment_pressure_id: '',
  equipment_pressure: '',
  equipment_protection_id: '',
  equipment_protection: '',
  internal_id: '',
  serial_number: '',
  equipment_brand: '',
  made_in: '',
  ce_marking: '',
  mfg_date: '',
  installation_date: '',
  equipment_status: '',
})

const resetForm = () => {
  emit('update:isDialogVisible', false)
  selectedAccessories.value = []
  searchMode.value = ''
  selectedCategory.value = null
  selectedModel.value = ''
  modelOptions.value = [] // Clearing modelOptions
  weightOptions.value = [] // Clearing weightOptions
  pressureOptions.value = [] // Clearing pressureOptions
  accessoryOptions.value = [] // Clearing accessoryOptions
  protectionOptions.value = [] // Clearing protectionOptions
  selectedWeight.value = ''
  selectedPressure.value = ''
  selectedProtection.value = ''
  equipmentData.value = {
    qrc_id: '',
    area_id: '',
    equipment_category_id: '',
    equipment_category: '',
    model_id: '',
    equipment_model_id: '',
    equipment_model: '',
    equipment_weight_unit: '',
    equipment_weight_value: '',
    equipment_pressure_id: '',
    equipment_pressure: '',
    equipment_protection_id: '',
    equipment_protection: '',
    internal_id: '',
    serial_number: '',
    equipment_brand: '',
    made_in: '',
    ce_marking: '',
    mfg_date: '',
    installation_date: '',
    equipment_status: '',
  }
}

const areaOptions = computed(() =>
  props.areas.map(area => ({
    title: area.area_description,
    value: area.id,
    subtitle: area.area_id, // Adjust if needed
    icon: { icon: 'tabler-map-pin', size: '28' },
  })),
)

const fetchCategoriesOptions = () => {
  equipmentParamsStore.fetchCategoriesOptions()
    .then(response => {
      categories.value = response.data.data.map(category => {
        let icon = { icon: 'tabler-box', size: '28' } // Default icon

        // Check if the category name matches specific categories
        if (category.name === 'fire extinguisher' || category.name === 'mobile fire extinguisher') {
          icon = { icon: 'tabler-fire-extinguisher', size: '28' }
        } else if (category.name === 'fire hose') {
          icon = { icon: 'tabler-firetruck', size: '28' }
        } else if (category.name === 'fire hydrant') {
          icon = { icon: 'tabler-fire-hydrant', size: '28' }
        } else if (category.name === 'fire sprinkler') {
          icon = { icon: 'tabler-fountain', size: '28' }
        } else if (category.name === 'smoke detector') {
          icon = { icon: 'tabler-smoking-no', size: '28' }
        }

        return {
          title: category.name, // Set the title property with category name
          description: category.description || '', // Set the description property with category description or an empty string if null
          value: category.id, // Set the value property with category name
          icon, // Include the icon object
        }
      })

      console.log(categories.value)
    })
    .catch(error => {
      console.error(error)
    })
}

const fetchModelsOptions = () => {
  if (!selectedCategory.value) return
  equipmentParamsStore
    .fetchCategoryModelsOptions(selectedCategory.value)
    .then(response => {
      modelOptions.value = response.data.data.map(model => ({
        title: model.name,
        value: model.id,
        subtitle: model.model_id,
        desc: model.category_name,
      }))
    })
    .catch(error => {
      console.error(error)
    })
}

const fetchModelOptionsData = async () => {
  if (!selectedModel.value) return

  try {
    const [weights, pressures, accessories, protections] = await Promise.all([
      equipmentParamsStore.fetchModelWeights(selectedModel.value),
      equipmentParamsStore.fetchModelPressures(selectedModel.value),
      equipmentParamsStore.fetchModelAccessories(selectedModel.value),
      equipmentParamsStore.fetchModelProtections(selectedModel.value),
    ])

    weightOptions.value = weights.data.data.map(weight => ({
      subtitle: weight.unit,
      value: weight.id,
      title: weight.value,
    }))

    pressureOptions.value = pressures.data.data.map(pressure => ({
      value: pressure.id,
      title: pressure.name,
    }))

    accessoryOptions.value = accessories.data.data.map(accessory => ({
      value: accessory.id,
      title: accessory.name,
      icon: { icon: 'tabler-box', size: '28' },
      desc: accessory.description || '',
    }))

    protectionOptions.value = protections.data.data.map(protection => ({
      value: protection.id,
      title: protection.name,
      icon: { icon: 'tabler-box', size: '28' },
    }))
  } catch (error) {
    console.error(error)
  }
}

const modelData = ref({
  model_category_id: '',
  category_name: '',
  name: '',
  model_id: '',
  id: '',
})

// 👉 Fetch Model
const fetchModel = () => {
  if (!selectedModel.value) return
  equipmentParamsStore.fetchModel(selectedModel.value)
    .then(response => {
      modelData.value = response.data.data
      equipmentData.value.equipment_category_id = modelData.value.model_category_id
      equipmentData.value.equipment_category = modelData.value.category_name
      equipmentData.value.equipment_model = modelData.value.name
      equipmentData.value.equipment_model_id = modelData.value.model_id
      equipmentData.value.model_id = modelData.value.id
    }).catch(error => {
      console.error(error)
    })
}

const weightData = ref({
  value: '',
  unit: '',
})

// 👉 fetch Weight
const fetchWeightData = () => {
  if (!selectedWeight.value) return
  equipmentParamsStore.fetchWeight(selectedWeight.value)
    .then(response => {
      weightData.value = response.data.data
      equipmentData.value.equipment_weight_unit = weightData.value.unit
      equipmentData.value.equipment_weight_value = weightData.value.value
    }).catch(error => {
      console.error(error)
    })
}

const pressureData = ref({
  pressure_id: '',
  name: '',
})

// 👉 fetch Pressure
const fetchPressureData = () => {
  if (!selectedPressure.value) return
  equipmentParamsStore.fetchPressure(selectedPressure.value)
    .then(response => {
      pressureData.value = response.data.data
      equipmentData.value.equipment_pressure_id = pressureData.value.pressure_id
      equipmentData.value.equipment_pressure = pressureData.value.name
      console.log(equipmentData.value)
    }).catch(error => {
      console.error(error)
    })
}

const protectionData = ref({
  protection_id: '',
  name: '',
})

// 👉 fetch Protection
const fetchProtectionData = () => {
  if (!selectedProtection.value) return
  equipmentParamsStore.fetchProtection(selectedProtection.value)
    .then(response => {
      protectionData.value = response.data.data
      equipmentData.value.equipment_protection_id = protectionData.value.protection_id
      equipmentData.value.equipment_protection = protectionData.value.name
      console.log(equipmentData.value)
    }).catch(error => {
      console.error(error)
    })
}

const handleInput = () => {
  fetchModelOptionsData()
  fetchModel()
}


const onDecode = text => {
  console.log(`Decoded text from QR code: ${text}`)
  equipmentData.value.qrc_id = text // Set the decoded text to the variable
}

const onLoaded = () => {
  console.log("Ready to start scanning barcodes")

  // Perform any initialization tasks
}

const dialogVisibleUpdate = val => {
  emit('update:isDialogVisible', val)
  currentStep.value = 0
}

watch(props, () => {
  if (!props.isDialogVisible)
    currentStep.value = 0
})

onMounted(() => {
  fetchCategoriesOptions()
})

// const onFormSubmit = () => {
//   refVForm.value?.validate().then(({ valid: isValid }) => {
//     if (isValid) {
//       emit('submit', { equipmentData: equipmentData.value, accessories: selectedAccessories.value })
//       resetForm()
//     } else {
//       errors.value.category = 'Please select a category' // Set error message if form is invalid
//       errors.value.model = 'Please select a model' // Set error message if form is invalid
//       errors.value.area = 'Please select a area' // Set error message if form is invalid
//       errors.value.status = 'Please select a status' // Set error message if form is invalid

//     }
//   })
// }
const onFormSubmit = () => {
  // Clear previous errors
  errors.value.qrc = ''
  errors.value.category = ''
  errors.value.model = ''
  errors.value.weight = ''
  errors.value.pressure = ''
  errors.value.area = ''
  errors.value.status = ''

  // Check individual field errors manually
  let isValid = true

  if (!equipmentData.value.qrc_id) {
    errors.value.qrc = 'Please select a QR Code'
    isValid = false
  }
  if (!selectedCategory.value) {
    errors.value.category = 'Please select a category'
    isValid = false
  }
  if (!selectedModel.value) {
    errors.value.model = 'Please select a model'
    isValid = false
  }
  if (!equipmentData.value.area_id) {
    errors.value.area = 'Please select an area'
    isValid = false
  }
  if (!equipmentData.value.equipment_status) {
    errors.value.status = 'Please select a status'
    isValid = false
  }

  if (isValid) {
    emit('submit', { equipmentData: equipmentData.value, accessories: selectedAccessories.value })
    emit('update:isDialogVisible', false)
    resetForm()
  }
}
</script>

<template>
  <VDialog
    :model-value="props.isDialogVisible"
    max-width="900"
    @update:model-value="dialogVisibleUpdate"
  >
    <!-- 👉 dialog close btn -->
    <DialogCloseBtn
      size="small"
      @click="emit('update:isDialogVisible', false)"
    />
    <VCard class="create-app-dialog">
      <VCardText class="pa-5 pa-sm-10">
        <h5 class="text-h5 text-center mb-2">
          Add New Equipment
        </h5>
        <p class="text-sm text-center mb-8">
          Provide data with this form to add new equipment.
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
            <VForm
              ref="refVForm"
              class="mt-4"
              @submit.prevent="onFormSubmit"
            >
              <VWindow
                v-model="currentStep"
                class="disable-tab-transition stepper-content"
              >
                <!-- 👉 QRC  -->
                <VWindowItem>
                  <h6 class="text-h6 my-4">
                    Select Creation Mode
                  </h6>
                  <VCol cols="12">
                    <CustomRadiosWithIcon
                      v-model:selected-radio="searchMode"
                      :radio-content="searchMethods"
                      :grid-column="{ sm: '6', cols: '12' }"
                    />
                  </VCol>

                  <VCol cols="12">
                    <div v-if="searchMode === 'qr_code_search'">
                      <StreamBarcodeReader
                        @decode="onDecode"
                        @loaded="onLoaded"
                      />
                    </div>
                    <h6
                      v-else-if="searchMode === 'simple_search'"
                      class="text-h6 my-4"
                    >
                      Select Equipment
                    </h6>
                    <VTextField
                      v-model="equipmentData.qrc_id"
                      :rules="[customRequiredValidator]"
                      :error-messages="[errors.qrc]"
                    />
                  </VCol>
                </VWindowItem>
                <!-- 👉 category -->
                <VWindowItem>
                  <h6 class="text-h6 my-4">
                    Equipment's Category
                  </h6>
                  <CustomRadiosWithIcon
                    v-model:selected-radio="selectedCategory"
                    :radio-content="categories"
                    :grid-column="{ sm: '6', cols: '12' }"
                    :rules="[customRequiredValidator]"
                    :error-messages="[errors.category]"
                    @input="fetchModelsOptions"
                  />
                </VWindowItem>

                <!-- 👉 Model -->
                <VWindowItem>
                  <VRow>
                    <VCol cols="12">
                      <h6 class="text-h6 mb-4">
                        Equipment's Model
                      </h6>
                      <CustomRadios
                        v-model:selected-radio="selectedModel"
                        :radio-content="modelOptions"
                        :grid-column="{ cols: '6' }"                   
                        :rules="[customRequiredValidator]"
                        :error-messages="[errors.model]"
                        @input="handleInput"
                      />
                    </VCol>
                    <VCol
                      v-if="weightOptions.length > 0"
                      cols="12"
                    >
                      <h6 class="text-h6 my-4">
                        Equipment Weight
                      </h6>
                      <CustomRadios
                        v-model:selected-radio="selectedWeight"
                        :radio-content="weightOptions"
                        :grid-column="{ sm: '3', cols: '4' }"
                        @input="fetchWeightData"
                      />
                    </VCol>
                    <VCol 
                      v-if="pressureOptions.length > 0"
                      cols="12"
                    >
                      <h6 class="text-h6 my-4">
                        Equipment Pressure
                      </h6>
                      <CustomRadios
                        v-model:selected-radio="selectedPressure"
                        :radio-content="pressureOptions"
                        :grid-column="{ cols: '6' }"
                        @input="fetchPressureData"
                      />
                    </VCol>
                  </VRow>
                </VWindowItem>

                <!-- 👉 Area -->
                <VWindowItem>
                  <VRow>
                    <VCol cols="12">
                      <h6 class="text-h6 my-4">
                        Insert Equipment's Area Details
                      </h6>
                      <CustomRadiosWithIcon
                        v-model:selected-radio="equipmentData.area_id"
                        :radio-content="areaOptions"
                        :grid-column="{ sm: '3', cols: '4' }"
                        :rules="[customRequiredValidator]"
                        :error-messages="[errors.area]"
                      />
                    </VCol>
                  </VRow>
                </VWindowItem>
                <!-- 👉 Identification Equipment  -->
                <VWindowItem>
                  <VRow>
                    <VCol cols="12">
                      <h6 class="text-h6 my-4">
                        Insert Equipment's Identification Details
                      </h6>
                    </VCol>
                    <VCol cols="6">
                      <AppTextField
                        v-model="equipmentData.internal_id"
                        label="Internal Id"
                        prepend-inner-icon="tabler-scan"
                        persistent-placeholder
                      />
                    </VCol>
                    <VCol cols="6">
                      <AppTextField
                        v-model="equipmentData.serial_number"
                        label="Serial Number"
                        prepend-inner-icon="tabler-scan"
                        persistent-placeholder
                      />
                    </VCol>
                    
                    <VCol cols="12">
                      <h6 class="text-h6 mb-4">
                        Insert manufacturer's Details
                      </h6>
                    </VCol>
                    <VCol cols="4">
                      <AppTextField
                        v-model="equipmentData.equipment_brand"
                        label="Brand"
                        prepend-inner-icon="tabler-building-factory-2"
                        persistent-placeholder
                      />
                    </VCol>
                    <VCol cols="4">
                      <AppTextField
                        v-model="equipmentData.made_in"
                        label="Made In"
                        prepend-inner-icon="tabler-flag"
                        persistent-placeholder
                      />
                    </VCol>
                    <VCol cols="4">
                      <AppTextField
                        v-model="equipmentData.ce_marking"
                        label="Ce Marking"
                        prepend-inner-icon="tabler-ce"
                        persistent-placeholder
                      />
                    </VCol>
                    <VCol cols="12">
                      <h6 class="text-h6 mb-4">
                        Insert Equipment's Dates
                      </h6>
                    </VCol>
                    <VCol cols="6">
                      <AppDateTimePicker
                        v-model="equipmentData.mfg_date"
                        prepend-inner-icon="tabler-calendar-check"
                        :config="{ inline: true }"
                        label="MFG Date"
                      />
                    </VCol>
                    <VCol cols="6">
                      <AppDateTimePicker
                        v-model="equipmentData.installation_date"
                        prepend-inner-icon="tabler-calendar-check"
                        :config="{ inline: true }"
                        label="Installation Date"
                      />
                    </VCol>
                  </VRow>
                </VWindowItem>
                <!-- 👉 Accessories & Protection -->
                <VWindowItem>
                  <VRow>
                    <VCol
                      v-if="accessoryOptions.length > 0"
                      cols="12"
                    >
                      <h6 class="text-h6 mb-4">
                        Select Equipment's Accessories
                      </h6>
                    </VCol>
                    <VCol
                      v-if="accessoryOptions.length > 0"
                      cols="12"
                    >
                      <CustomCheckboxesWithIcon
                        v-model:selected-checkbox="selectedAccessories"
                        :checkbox-content="accessoryOptions"
                        :grid-column="{ sm: '3', cols: '6' }"
                      />
                    </VCol>
                    <VCol
                      v-if="protectionOptions.length > 0"
                      cols="12"
                    >
                      <h6 class="text-h6 mb-4">
                        Select Equipment's Protection
                      </h6>
                    </VCol>
                    <VCol
                      v-if="protectionOptions.length > 0"
                      cols="12"
                    >
                      <CustomRadiosWithIcon
                        v-model:selected-radio="selectedProtection"
                        :radio-content="protectionOptions"
                        :grid-column="{ sm: '6', cols: '6' }"
                        @input="fetchProtectionData"
                      />
                    </VCol>
                  </VRow>
                </VWindowItem>
                <VWindowItem class="text-center">
                  <h6 class="text-h6 my-4">
                    Select Equipment's Status
                  </h6>
                  <CustomRadiosWithIcon
                    v-model:selected-radio="equipmentData.equipment_status"
                    :radio-content="status"
                    :grid-column="{ sm: '4', cols: '12' }"
                    :rules="[customRequiredValidator]"
                    :error-messages="[errors.status]"
                  />
                </VWindowItem>
              </VWindow>
            </VForm>

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
                type="submit"
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
