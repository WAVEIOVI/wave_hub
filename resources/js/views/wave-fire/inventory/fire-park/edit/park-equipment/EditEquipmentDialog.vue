<script setup>
import { useEquipmentParamsStore } from '@/views/config/inventory/useEquipmentParamsStore'
import { useParkListStore } from '@/views/wave-fire/inventory/fire-park/useParkListStore'
import { VDataTableServer } from 'vuetify/labs/VDataTable'

const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  areas: {
    type: Array,
    required: true,
  },
  equipmentData: {
    type: Object,
    required: true,
  },
  accessoryHeaders: {
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
    icon: 'tabler-fire-extinguisher',
    title: 'Equipment',
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
    icon: 'tabler-shield',
    title: 'Protections',
  },
  {
    icon: 'tabler-check',
    title: 'Status',
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

const route = useRoute()

const equipmentParamsStore = useEquipmentParamsStore()

const parkListStore = useParkListStore()
const localEquipmentData = ref((props.equipmentData))
const areaData = ref([])
const modalId = ref(localEquipmentData.value.model_id)

const accessoryOptions = ref([])
const selectedAccessories = ref([])

const protectionOptions = ref([])
const selectedProtection = ref('')


const resetForm = () => {
  emit('update:isDialogVisible', false)
}

const areaOptions = computed(() =>
  props.areas.map(area => ({
    title: area.area_description,
    value: area.id,
    subtitle: area.area_id, // Adjust if needed
    icon: { icon: 'tabler-map-pin', size: '28' },
  })),
)

const totalPage = ref(1)
const totalAccessories = ref(0)
const accessories = ref([])

const options = ref({
  page: 1,
  itemsPerPage: 10,
  sortBy: [],
  groupBy: [],
  search: undefined,
})

//!SECTION Declaration

//SECTION Functions
const paginationMeta = computed(() => {
  return (options, total) => {
    const start = (options.page - 1) * options.itemsPerPage + 1
    const end = Math.min(options.page * options.itemsPerPage, total)
    
    return `Showing ${start} to ${end} of ${total} entries`
  }
})

const fetchModelOptionsData = async () => {
  if (!modalId.value) return

  try {
    const accessoriesResponse = await equipmentParamsStore.fetchModelAccessories(modalId.value)

    accessoryOptions.value = accessoriesResponse.data.data.map(accessory => ({
      value: accessory.id,
      title: accessory.name,
      icon: { icon: 'tabler-box', size: '28' },
      desc: accessory.description || '',
    }))
  } catch (error) {
    console.error(error)
  }
}

// 👉 Fetching accessories
const fetchEquipmentAccessories = () => {
  if (!localEquipmentData.value.id) return
  parkListStore.fetchEquipmentAccessories({
    id: localEquipmentData.value.id,
    options: options.value,
  }).then(response => {
    accessories.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalAccessories.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
  }).catch(error => {
    console.error(error)
  })
}

const filteredAccessoryOptions = computed(() => {
  return accessoryOptions.value.filter(option =>
    !accessories.value.some(selected =>
      selected.option_id === option.value, // assuming 'value' holds the ID of the accessory
    ),
  )
})

const fetchProtectionOptionsData = async () => {
  if (!modalId.value) return

  try {
    const protectionsResponse = await equipmentParamsStore.fetchModelProtections(modalId.value)

    protectionOptions.value = protectionsResponse.data.data.map(protection => ({
      value: protection.id,
      title: protection.name,
      icon: { icon: 'tabler-box', size: '28' },
      desc: protection.description || '',
    }))
  } catch (error) {
    console.error(error)
  }
}

// 👉 Fetch Park Area
const fetchParkArea = () => {
  if (!localEquipmentData.value.area_id) return
  parkListStore.fetchParkArea(Number(route.params.id), localEquipmentData.value.area_id)
    .then(response => {
      areaData.value = response.data.data
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

// 👉 Delete Accessory 
const deleteAccessory = accessoryId => {
  parkListStore
    .deleteAccessory(localEquipmentData.value.id, accessoryId)
    .then(response => {
      console.log(response.data)
      fetchEquipmentAccessories()
      fetchModelOptionsData()
    })
    .catch(error => {
      console.error('Error deleting accessory:', error)
    })
}

watch(
  () => localEquipmentData.value.model_id,
  newValue => {
    if (newValue) {
      modalId.value = newValue
      fetchModelOptionsData()
      fetchProtectionOptionsData()
    }
  },
)
watch(
  () => localEquipmentData.value.id,
  newValue => {
    if (newValue) {
      fetchEquipmentAccessories()
    }
  },
)

watch(
  () => selectedProtection.value,
  newValue => {
    if (newValue) {
      fetchProtectionData()
    }
  },
)
watch(
  () => localEquipmentData.value.area_id,
  newValue => {
    if (newValue) {
      fetchParkArea()
    }
  },
)
watch(
  () => localEquipmentData.value.area_id,
  newValue => {
    if (newValue) {
      fetchParkArea()
    }
  },
)

onMounted(() => {
  fetchModelOptionsData()
  fetchProtectionOptionsData()
})

const dialogVisibleUpdate = val => {
  emit('update:isDialogVisible', val)
  currentStep.value = 0
}

const onFormSubmit = () => {
  emit('update:isDialogVisible', false)
  emit('submit', { equipmentData: localEquipmentData.value, accessories: selectedAccessories.value })
}

watch(props, () => {
  if (!props.isDialogVisible)
    currentStep.value = 0
})

watch(() => props.equipmentData, newData => {
  localEquipmentData.value = { ...newData }
}, { immediate: true })

// Watch for changes in props.areas to ensure areaOptions is up-to-date
watch(() => props.areas, () => {
  // This will automatically update areaOptions due to it being a computed property
})  
watchEffect(fetchEquipmentAccessories)
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
          Edit Equipment
        </h5>
        <p class="text-sm text-center mb-8">
          Provide data with this form to edit equipment.
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
              class="mt-4"
              @submit.prevent="onFormSubmit"
            >
              <VWindow
                v-model="currentStep"
                class="disable-tab-transition stepper-content"
              >
                <!-- 👉 category -->
                <VWindowItem>
                  <h6 class="text-h6 my-4">
                    Equipment's Details
                  </h6>
                  <VRow>
                    <!-- 👉 Category Id -->
                    <VCol cols="4">
                      <VTextField 
                        v-model="localEquipmentData.equipment_category_id"
                        label="Category Id"
                        readonly
                      />
                    </VCol>
                    <!-- 👉 Category Name -->
                    <VCol cols="8">
                      <VTextField 
                        v-model="localEquipmentData.equipment_category"
                        label="Category Name"
                        readonly
                      />
                    </VCol>
                    <!-- 👉 Model Name -->
                    <VCol cols="4">
                      <VTextField 
                        v-model="localEquipmentData.equipment_model_id"
                        label="Model ID"
                        readonly
                      />
                    </VCol>
                    <VCol cols="8">
                      <VTextField 
                        v-model="localEquipmentData.equipment_model"
                        label="Equipment Model"
                        readonly
                      />
                    </VCol>
                    <!-- 👉 Model Weight -->
                    <VCol cols="3">
                      <VTextField 
                        v-model="localEquipmentData.equipment_weight_value"
                        label="Weight"
                        readonly
                      />
                    </VCol>
                    <VCol cols="3">
                      <VTextField 
                        v-model="localEquipmentData.equipment_weight_unit"
                        label="Unit"
                        readonly
                      />
                    </VCol>
                    <VCol cols="6">
                      <VTextField 
                        v-model="localEquipmentData.equipment_pressure"
                        label="Equipment Pressure"
                        readonly
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
                    </VCol>
                    <VCol cols="12"> 
                      <CustomRadiosWithIcon
                        v-model:selected-radio="localEquipmentData.area_id"
                        :radio-content="areaOptions"
                        :grid-column="{ sm: '3', cols: '4' }"
                      />
                    </VCol>
                    <VDivider />
                    <VCol cols="4">
                      <VTextField 
                        v-model="areaData.area_id"
                        label="Area ID"
                        readonly
                      />  
                    </VCol> 
                    <VCol cols="8">
                      <VTextField 
                        v-model="areaData.area_description"
                        label="Area Description"
                        readonly
                      />
                    </VCol> 
                    <VCol cols="6">
                      <VTextField 
                        v-model="areaData.area_accessibility"
                        label="Area Accessibility"
                        readonly
                      />  
                    </VCol> 
                    <VCol cols="6">
                      <VTextField 
                        v-model="areaData.area_classification"
                        label="Area Classification"
                        readonly
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
                    <VCol cols="12">
                      <AppTextField
                        v-model="localEquipmentData.qrc_id"
                        label="QRC Id"
                        prepend-inner-icon="tabler-scan"
                        persistent-placeholder
                      />
                    </VCol>
                    <VCol cols="6">
                      <AppTextField
                        v-model="localEquipmentData.internal_id"
                        label="Internal Id"
                        prepend-inner-icon="tabler-scan"
                        persistent-placeholder
                      />
                    </VCol>
                    <VCol cols="6">
                      <AppTextField
                        v-model="localEquipmentData.serial_number"
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
                        v-model="localEquipmentData.equipment_brand"
                        label="Brand"
                        prepend-inner-icon="tabler-building-factory-2"
                        persistent-placeholder
                      />
                    </VCol>
                    <VCol cols="4">
                      <AppTextField
                        v-model="localEquipmentData.made_in"
                        label="Made In"
                        prepend-inner-icon="tabler-flag"
                        persistent-placeholder
                      />
                    </VCol>
                    <VCol cols="4">
                      <AppTextField
                        v-model="localEquipmentData.ce_marking"
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
                        v-model="localEquipmentData.mfg_date"
                        prepend-inner-icon="tabler-calendar-check"
                        :config="{ inline: true }"
                        label="MFG Date"
                      />
                    </VCol>
                    <VCol cols="6">
                      <AppDateTimePicker
                        v-model="localEquipmentData.installation_date"
                        prepend-inner-icon="tabler-calendar-check"
                        :config="{ inline: true }"
                        label="Installation Date"
                      />
                    </VCol>
                  </VRow>
                </VWindowItem>
                <VWindowItem>
                  <VRow>
                    <VCol cols="12">
                      <h6 class="text-h6 mb-4">
                        Select Equipment's Accessories
                      </h6>
                    </VCol>
                    <VCol
                      v-if="filteredAccessoryOptions.length > 0"
                      cols="12"
                    >
                      <CustomCheckboxesWithIcon
                        v-model:selected-checkbox="selectedAccessories"
                        :checkbox-content="filteredAccessoryOptions"
                        :grid-column="{ sm: '3', cols: '6' }"
                      />
                    </VCol>
                    <VCol cols="12">
                      <VDivider />
                      <!-- SECTION dataTable -->
                      <VDataTableServer
                        v-model:items-per-page="options.itemsPerPage"
                        v-model:page="options.page"
                        :items="accessories"
                        :items-length="totalAccessories"
                        :headers="accessoryHeaders"
                        class="text-no-wrap"
                        @update:options="options = $event"
                      >
                        <!-- 👉 Actions -->
                        <template #[`item.actions`]="{ item }">
                          <IconBtn @click="deleteAccessory(item.raw.id)">
                            <VIcon icon="tabler-trash" />
                          </IconBtn>
                        </template>

                        <!-- 👉 pagination -->
                        <template #bottom>
                          <VDivider />
                          <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                            <p class="text-sm text-disabled mb-0">
                              {{ paginationMeta(options, totalAccessories) }}
                            </p>

                            <VPagination
                              v-model="options.page"
                              :length="totalPage"
                              :total-visible="$vuetify.display.xs ? 1 : totalPage"
                            >
                              <template #prev="slotProps">
                                <VBtn
                                  variant="tonal"
                                  color="default"
                                  v-bind="slotProps"
                                  :icon="false"
                                >
                                  Previous
                                </VBtn>
                              </template>

                              <template #next="slotProps">
                                <VBtn
                                  variant="tonal"
                                  color="default"
                                  v-bind="slotProps"
                                  :icon="false"
                                >
                                  Next
                                </VBtn>
                              </template>
                            </VPagination>
                          </div>
                        </template>
                      </VDataTableServer>
                      <!-- !SECTION dataTable -->
                    </VCol>
                  </VRow>
                </VWindowItem>
                <!-- 👉 Protection -->
                <VWindowItem>
                  <VRow>
                    <VCol cols="12">
                      <h6 class="text-h6 my-4">
                        Insert Equipment's Protection Details
                      </h6>
                      <CustomRadiosWithIcon
                        v-model:selected-radio="selectedProtection"
                        :radio-content="protectionOptions"
                        :grid-column="{ sm: '3', cols: '4' }"
                      />
                    </VCol>
                    <VDivider />
                    <VCol cols="4">
                      <VTextField 
                        v-model="protectionData.protection_id"
                        label="Protection ID"
                        readonly
                      />  
                    </VCol> 
                    <VCol cols="8">
                      <VTextField 
                        v-model="protectionData.name"
                        label="Equipment Protection"
                        readonly
                      />
                    </VCol> 
                  </VRow>
                </VWindowItem>
                <VWindowItem class="text-center">
                  <h6 class="text-h6 my-4">
                    Select Equipment's Status
                  </h6>
                  <CustomRadiosWithIcon
                    v-model:selected-radio="localEquipmentData.equipment_status"
                    :radio-content="status"
                    :grid-column="{ sm: '4', cols: '12' }"
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
