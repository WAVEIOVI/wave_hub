<script setup>
import { useEquipmentParamsStore } from '@/views/config/inventory/useEquipmentParamsStore'
import { useParkListStore } from '@/views/wave-fire/inventory/fire-park/useParkListStore'
import fireExtinguisherCo2 from '@images/equipment/FireExtinguisherCo2.png'
import fireExtinguisherFoam from '@images/equipment/FireExtinguisherFoam.png'
import fireExtinguisherPowder from '@images/equipment/FireExtinguisherPowder.png'
import fireExtinguisherPowder50 from '@images/equipment/FireExtinguisherPowder50.png'
import fireHose from '@images/equipment/FireHose.png'
import { VDataTableServer } from 'vuetify/labs/VDataTable'


const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  equipmentData: {
    type: Object,
    required: true,
  },
  accessoryViewHeaders: {
    type: Array,
    required: true,
  },
})

const emit = defineEmits([
  'update:isDialogVisible',
  'submit',
])

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
}

const onFormSubmit = () => {
  emit('update:isDialogVisible', false)
  emit('submit', { equipmentData: localEquipmentData.value, accessories: selectedAccessories.value })
}

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
          View Equipment
        </h5>
        <p class="text-sm text-center mb-8">
          View data with this equipment.
        </p>
        <VRow>
          <VCol
            cols="12"
            md="7"
          >
            <h5 class="text-h5 mb-5">
              Equipment's Details! 🚀
            </h5>

            <table class="text-base">
              <tr>
                <td style="width: 202px;">
                  <p class="font-weight-medium mb-2">
                    QRC ID
                  </p>
                </td>
                <td>
                  <p class="mb-2">
                    {{ localEquipmentData.qrc_id }}
                  </p>
                </td>
              </tr>

              <tr>
                <td>
                  <p class="font-weight-medium mb-2">
                    Equipment Status
                  </p>
                </td>
                <td>
                  <p class="mb-2">
                    <VChip
                      size="small"
                      label
                    >
                      {{ localEquipmentData.equipment_status }}
                    </VChip>
                  </p>
                </td>
              </tr>

              <tr>
                <td>
                  <p class="font-weight-medium mb-2">
                    Category
                  </p>
                </td>
                <td>
                  <p class="mb-2">
                    {{ localEquipmentData.equipment_category_id }} | {{ localEquipmentData.equipment_category }}
                  </p>
                </td>
              </tr>

              <tr>
                <td>
                  <p class="font-weight-medium mb-2">
                    Model
                  </p>
                </td>
                <td>
                  <p class="mb-2">
                    {{ localEquipmentData.equipment_model_id }} | {{ localEquipmentData.equipment_model }}
                  </p>
                </td>
              </tr>

              <tr>
                <td>
                  <p class="font-weight-medium mb-2">
                    Weight
                  </p>
                </td>
                <td>
                  <p class="mb-2">
                    {{ localEquipmentData.equipment_weight_value }} {{ localEquipmentData.equipment_weight_unit }}
                  </p>
                </td>
              </tr>
              <tr>
                <td>
                  <p class="font-weight-medium mb-2">
                    Pressure
                  </p>
                </td>
                <td>
                  <p class="mb-2">
                    {{ localEquipmentData.pressure }}
                  </p>
                </td>
              </tr>
            </table>
          </VCol>

          <VCol
            cols="12"
            md="5"
          >
            <div class="border rounded pa-4 pb-0">
              <VImg
                v-if="localEquipmentData.equipment_model === 'powder abc'"
                :src="fireExtinguisherPowder"
                class="mx-auto"
              />
              <VImg
                v-if="localEquipmentData.equipment_model === 'co2'"
                :src="fireExtinguisherCo2"
                class="mx-auto"
              />
              <VImg
                v-if="localEquipmentData.equipment_model === 'water-based' || localEquipmentData.equipment_model === 'foam'"
                :src="fireExtinguisherFoam"
                class="mx-auto"
              />
              <VImg
                v-if="localEquipmentData.equipment_category === 'fire hose'"
                :src="fireHose"
                class="mx-auto"
              />
              <VImg
                v-if="localEquipmentData.equipment_weight === '50kg'"
                :src="fireExtinguisherPowder50"
                class="mx-auto"
              />
            </div>
          </VCol>
        </VRow>
        <VRow>
          <VCol cols="12">
            <!-- 👉 Area -->
            <VRow>
              <VCol cols="12">
                <h6 class="text-h6 my-4">
                  Equipment's Area Details
                </h6>
              </VCol>
              <VCol cols="4">
                <VTextField 
                  v-model="localEquipmentData.equipment_area"
                  label="Area ID"
                  readonly
                />  
              </VCol> 
              <VCol cols="8">
                <VTextField 
                  v-model="localEquipmentData.equipment_area_description"
                  label="Area Description"
                  readonly
                />
              </VCol> 
              <VCol cols="6">
                <VTextField 
                  v-model="localEquipmentData.equipment_area_accessibility"
                  label="Area Accessibility"
                  readonly
                />  
              </VCol> 
              <VCol cols="6">
                <VTextField 
                  v-model="localEquipmentData.equipment_area_classification"
                  label="Area Classification"
                  readonly
                />  
              </VCol>
            </VRow>
            <!-- 👉 Identification Equipment  -->
            <VRow>
              <VCol cols="12">
                <h6 class="text-h6 my-4">
                  Equipment's Identification Details
                </h6>
              </VCol>
              <VCol cols="6">
                <AppTextField
                  v-model="localEquipmentData.internal_id"
                  label="Internal Id"
                  prepend-inner-icon="tabler-scan"
                  persistent-placeholder
                  readonly
                />
              </VCol>
              <VCol cols="6">
                <AppTextField
                  v-model="localEquipmentData.serial_number"
                  label="Serial Number"
                  prepend-inner-icon="tabler-scan"
                  persistent-placeholder
                  readonly
                />
              </VCol>
                    
              <VCol cols="12">
                <h6 class="text-h6 mb-4">
                  Manufacturer's Details
                </h6>
              </VCol>
              <VCol cols="4">
                <AppTextField
                  v-model="localEquipmentData.equipment_brand"
                  label="Brand"
                  prepend-inner-icon="tabler-building-factory-2"
                  persistent-placeholder
                  readonly
                />
              </VCol>
              <VCol cols="4">
                <AppTextField
                  v-model="localEquipmentData.made_in"
                  label="Made In"
                  prepend-inner-icon="tabler-flag"
                  persistent-placeholder
                  readonly
                />
              </VCol>
              <VCol cols="4">
                <AppTextField
                  v-model="localEquipmentData.ce_marking"
                  label="Ce Marking"
                  prepend-inner-icon="tabler-ce"
                  persistent-placeholder
                  readonly
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
                  label="MFG Date"
                  readonly
                />
              </VCol>
              <VCol cols="6">
                <AppDateTimePicker
                  v-model="localEquipmentData.installation_date"
                  prepend-inner-icon="tabler-calendar-check"
                  label="Installation Date"
                  readonly
                />
              </VCol>
            </VRow>
            
            <!-- 👉 Protection -->
            <VRow>
              <VCol cols="12">
                <h6 class="text-h6 my-4">
                  Equipment's Protection Details
                </h6>
              </VCol>
              <VCol cols="4">
                <VTextField 
                  v-model="localEquipmentData.equipment_protection_id"
                  label="Protection ID"
                  readonly
                />  
              </VCol> 
              <VCol cols="8">
                <VTextField 
                  v-model="localEquipmentData.equipment_protection"
                  label="Equipment Protection"
                  readonly
                />
              </VCol> 
            </VRow>
            <VRow>
              <VCol cols="12">
                <h6 class="text-h6 mb-4">
                  Equipment's Accessories
                </h6>
              </VCol>
              <VCol cols="12">
                <VDivider />
                <!-- SECTION dataTable -->
                <VDataTableServer
                  v-model:items-per-page="options.itemsPerPage"
                  v-model:page="options.page"
                  :items="accessories"
                  :items-length="totalAccessories"
                  :headers="accessoryViewHeaders"
                  class="text-no-wrap"
                  @update:options="options = $event"
                >
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
            <div class="d-flex justify-space-between mt-8">
              <VBtn
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
