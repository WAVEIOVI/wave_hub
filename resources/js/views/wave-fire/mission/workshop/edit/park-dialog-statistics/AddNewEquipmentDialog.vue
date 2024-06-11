<script setup>
import { useWorkshopListStore } from '../../useWorkshopListStore'
import { StreamBarcodeReader } from "vue-barcode-reader"
import FireExtinguisherPowder from '@images/equipment/FireExtinguisherPowder.png'
import FireExtinguisherCo2 from '@images/equipment/FireExtinguisherCo2.png'
import FireExtinguisherFoam from '@images/equipment/FireExtinguisherFoam.png'
import FireExtinguisherPowder50 from '@images/equipment/FireExtinguisherPowder50.png'
import FireHose from '@images/equipment/FireHose.png'


const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  workshopData: {
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
    icon: 'tabler-search',
    title: 'Search Mode',
  },
  {
    icon: 'tabler-fire-extinguisher',
    title: 'Equipment',
  },
  {
    icon: 'tabler-adjustments-check',
    title: 'Inspection',
  },
  {
    icon: 'tabler-tool',
    title: 'Maintenance',
  },
  {
    icon: 'tabler-shopping-cart-check',
    title: 'Supply',
  },
  
  {
    icon: 'tabler-shopping-cart-plus',
    title: 'Accessories',
  },
  {
    icon: 'tabler-check',
    title: 'Status',
  },
]

const searchMethods = [
  {
    title: 'QR Code Search',
    value: 'qr_code_search',
    icon: {
      icon: 'tabler-scan',
      size: '28',
    },
  },
  {
    title: 'Simple Search',
    value: 'simple_search',
    icon: {
      icon: 'tabler-eye-search',
      size: '28',
    },
  },
]

const inspection = ref([])
const rawRecharge = ref([])
const nitrogenRecharge = ref([])
const maintenance = ref([])
const additionalMaintenance = ref([])
const supply = ref([])
const standardSign = ref([])
const numbering = ref([])
const pictogram = ref([])
const equipmentFixation = ref([])
const accessories = ref([])
const equipmentStatus = ref([])
const workshopListStore = useWorkshopListStore()
const localWorkshopData = ref((props.workshopData))
const clientId = localWorkshopData.value.mission_client_id

const searchQuery = ref('')
const equipments = ref([])
const searchMode = ref('')
const equipmentFetched = ref('')

const equipmentData = ref({
  resources: {}, // Modify the structure to match Laravel Orion's conventions
})

const resetForm = () => {
  emit('update:isDialogVisible', false)
  searchQuery.value = null
  equipmentFetched.value = {
    area_id: '',
    equipment_category: '',
    equipment_model: '',
    equipment_weight: '',
    equipment_pressure: '',
    internal_id: '',
    serial_number: '',
    equipment_status: '',
  }
  standardSign.value = []
  pictogram.value = []
  numbering.value = []
  equipmentFixation.value = []

  // Reset the form fields used in onFormSubmit
  inspection.value = []
  rawRecharge.value = []
  nitrogenRecharge.value = []
  maintenance.value = null
  additionalMaintenance.value = null
  supply.value = null
  accessories.value = null
  equipmentStatus.value = null
}

const dialogVisibleUpdate = val => {
  emit('update:isDialogVisible', val)
  currentStep.value = 0
}

watch(props, () => {
  if (!props.isDialogVisible)
    currentStep.value = 0
})

const onFormSubmit = () => {
  const formattedData = {
    resources: {
      [searchQuery.value]: {
        inspection: inspection.value.length > 0 ? inspection.value[0] : null,
        raw_recharge: rawRecharge.value.length > 0 ? rawRecharge.value[0] : null,
        nitrogen_recharge: nitrogenRecharge.value.length > 0 ? nitrogenRecharge.value[0] : null,
        maintenance: maintenance.value,
        additional_maintenance: additionalMaintenance.value,
        supply: supply.value,
        standard_sign: standardSign.value.length > 0 ? standardSign.value[0] : null,
        numbering: numbering.value.length > 0 ? numbering.value[0] : null,
        pictogram: pictogram.value.length > 0 ? pictogram.value[0] : null,
        equipment_fixation: equipmentFixation.value.length > 0 ? equipmentFixation.value[0] : null,
        accessories: accessories.value,
        equipment_status: equipmentStatus.value,
      },
    },
  }

  emit('submit', formattedData)
  resetForm()
}

const inspectionOptions = [
  {
    title: 'Inspection',
    value: 'inspected',
    icon: {
      icon: 'tabler-zoom-check',
      size: '28',
    },
  },
]

const rawRechargeOptions = [
  {
    title: 'Raw Refill',
    value: 'raw charged',
    icon: {
      icon: 'tabler-battery-3',
      size: '28',
    },
  },
]

const nitrogenRechargeOptions = [
  {
    title: 'Nitrogen Refill',
    value: 'nitrogen charged',
    icon: {
      icon: 'tabler-filter-down',
      size: '28',
    },
  },
]

const maintenanceOptions = [
  {
    title: 'Head Maintenance',
    value: 'head maintenance',
    icon: {
      icon: 'tabler-hexagon-1-filled',
      size: '28',
    },
  },
  {
    title: 'Corps Maintenance',
    value: 'corps maintenance',
    icon: {
      icon: 'tabler-hexagon-2-filled',
      size: '28',
    },
  },
  {
    title: 'Hose Maintenance',
    value: 'hose maintenance',
    icon: {
      icon: 'tabler-hexagon-3-filled',
      size: '28',
    },
  },
]

const additionalMaintenanceOptions = [
  {
    title: 'Sandblasting',
    value: 'sandblasting',
    icon: {
      icon: 'tabler-hexagon-4-filled',
      size: '28',
    },
  },
  {
    title: 'Paint',
    value: 'paint',
    icon: {
      icon: 'tabler-hexagon-5-filled',
      size: '28',
    },
  },
  {
    title: 'Hydro Test',
    value: 'hydro test',
    icon: {
      icon: 'tabler-hexagon-6-filled',
      size: '28',
    },
  },
]

const supplyOptions = [
  {
    title: 'Pressure Gauge',
    value: 'pressure gauge',
    icon: {
      icon: 'tabler-brand-days-counter',
      size: '28',
    },
  },
  {
    title: 'Valve Assembly',
    value: 'valve assembly',
    icon: {
      icon: 'tabler-air-balloon',
      size: '28',
    },
  },
  {
    title: 'Hose Assembly',
    value: 'hose assembly',
    icon: {
      icon: 'tabler-chisel',
      size: '28',
    },
  },
  {
    title: 'Discharge Nozzle',
    value: 'discharge nozzle',
    icon: {
      icon: 'tabler-charging-pile',
      size: '28',
    },
  },
  {
    title: 'Safety Pin',
    value: 'safety pin',
    icon: {
      icon: 'tabler-shield-lock',
      size: '28',
    },
  },
  {
    title: 'O-ring',
    value: 'o ring',
    icon: {
      icon: 'tabler-transition-right',
      size: '28',
    },
  },
  {
    title: 'Handle and Lever',
    value: 'handle and lever',
    icon: {
      icon: 'tabler-brand-deliveroo',
      size: '28',
    },
  },
]

const standardSignOptions = [
  {
    title: 'Sign',
    value: 'available',
    icon: {
      icon: 'tabler-id-badge',
      size: '28',
    },
  },
]

const numberingOptions = [
  {
    title: 'Numbering',
    value: 'available',
    icon: {
      icon: 'tabler-numbers',
      size: '28',
    },
  },
]

const pictogramOptions = [
  {
    title: 'Pictogram',
    value: 'available',
    icon: {
      icon: 'tabler-id-badge',
      size: '28',
    },
  },
]

const equipmentFixationOptions = [
  {
    title: 'Fixation',
    value: 'available',
    icon: {
      icon: 'tabler-tool',
      size: '28',
    },
  },
]

const accessoriesOptions = [
  {
    title: 'Cover',
    value: 'cover',
    icon: {
      icon: 'tabler-cone-2',
      size: '28',
    },
  },
  {
    title: 'Box',
    value: 'box',
    icon: {
      icon: 'tabler-box',
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

onMounted(() => {
  //  Fetching equipments
  workshopListStore.fetchEquipments({
    client: clientId,
    search: searchQuery.value,
  }).then(response => {
    equipments.value = response.data.data.map(equipment => ({ ...equipment }))
    console.log(equipments.value)
  }).catch(error => {
    console.error(error)
  })
})

const fetchEquipment = () => {
  if (!searchQuery.value) return
  workshopListStore.fetchEquipment(searchQuery.value)
    .then(response => {
      equipmentFetched.value = response.data.data
      console.log(equipmentFetched.value)
    }).catch(error => {
      console.error(error)
    })
}

watch(
  () => searchQuery.value,
  fetchEquipment,
)

const onDecode = text => {
  console.log(`Decoded text from QR code: ${text}`)
  searchQuery.value = text // Set the decoded text to the variable
}

const onLoaded = () => {
  console.log("Ready to start scanning barcodes")

  // Perform any initialization tasks
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
          Attach A Equipment
        </h5>
        <p class="text-sm text-center mb-8">
          Provide data with this form to attach a equipment.
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
                <!-- 👉 Search Mode -->
                <VWindowItem>
                  <h6 class="text-h6 my-4">
                    Select Search Mode
                  </h6>
                  <VCol cols="12">
                    <CustomRadiosWithIcon
                      v-model:selected-radio="searchMode"
                      :radio-content="searchMethods"
                      :grid-column="{ sm: '6', cols: '12' }"
                    />
                  </VCol>
                  <VCol
                    v-if="searchMode === 'qr_code_search'"
                    cols="12"
                  >
                    <StreamBarcodeReader
                      @decode="onDecode"
                      @loaded="onLoaded"
                    />
                    <div v-if="searchQuery">
                      <AppAutocomplete
                        v-model="searchQuery"
                        :items="equipments"
                        clearable
                        :item-title="item => item.qrc_id"
                        item-value="id"
                        clear-icon="tabler-x"
                        @input="fetchEquipment"
                      >
                        <template #item="{ props: itemProps, item }">  
                          <VListItem
                            v-bind="itemProps"
                            :subtitle="item.raw.equipment_category + ' - ' + item.raw.equipment_model + ' - ' + item.raw.equipment_weight"
                          />
                        </template>
                      </AppAutocomplete>
                    </div>
                  </VCol>
                  <VCol
                    v-if="searchMode === 'simple_search'"
                    cols="12"
                  >
                    <h6 class="text-h6 my-4">
                      Select Equipment
                    </h6>
                    <AppAutocomplete
                      v-model="searchQuery"
                      :items="equipments"
                      clearable
                      :item-title="item => item.qrc_id"
                      item-value="id"
                      clear-icon="tabler-x"
                      @input="fetchEquipment"
                    >
                      <template #item="{ props: itemProps, item }">  
                        <VListItem
                          v-bind="itemProps"
                          :subtitle="item.raw.equipment_category + ' - ' + item.raw.equipment_model + ' - ' + item.raw.equipment_weight"
                        />
                      </template>
                    </AppAutocomplete>
                  </VCol>
                </VWindowItem>
                <!-- 👉 Equipment -->
                <VWindowItem>
                  <h6 class="text-h6 my-4">
                    Equipment's Details
                  </h6>
                  <VRow>
                    <VCol cols="12">
                      <VCard>
                        <VCardItem>
                          <VCardTitle class="d-flex flex-column align-center justify-center">
                            <VAvatar
                              v-if="equipmentFetched.equipment_model === 'powder abc'"
                              size="200"
                              :image="FireExtinguisherPowder"
                            />
                            <VAvatar
                              v-if="equipmentFetched.equipment_model === 'co2'"
                              size="200"
                              :image="FireExtinguisherCo2"
                            />
                            <VAvatar
                              v-if="equipmentFetched.equipment_model === 'water-based' || equipmentFetched.equipment_model === 'foam'"
                              size="200"
                              :image="FireExtinguisherFoam"
                            />
                            <VAvatar
                              v-if="equipmentFetched.equipment_category === 'fire hose'"
                              size="200"
                              :image="FireHose"
                            />
                            <VAvatar
                              v-if="equipmentFetched.equipment_weight === '50kg'"
                              size="200"
                              :image="FireExtinguisherPowder50"
                            />
                            
                            <p class="mt-4 mb-0">
                              {{ equipmentFetched.equipment_category }} {{ equipmentFetched.equipment_model }} {{ equipmentFetched.equipment_weight }} {{ equipmentFetched.equipment_pressure }}
                            </p>
                            <span class="text-body-1">{{ equipmentFetched.equipment_status }}</span>

                            <div class="d-flex align-center flex-wrap gap-2 mt-2">
                              <VChip
                                label
                                size="small"
                              >
                                {{ equipmentFetched.qrc_id }}
                              </VChip>
                              <VChip
                                label
                                size="small"
                              >
                                {{ equipmentFetched.internal_id }}
                              </VChip>
                              <VChip
                                label
                                size="small"
                              >
                                {{ equipmentFetched.serial_number }}
                              </VChip>
                            </div>
                          </VCardTitle>
                        </VCardItem>
                      </VCard>
                    </VCol>
                  </VRow>
                </VWindowItem>

                <!-- 👉 Inspection & Recharge -->
                <VWindowItem>
                  <VRow>
                    <VCol cols="12">
                      <h6 class="text-h6 mb-4">
                        Inspection & Recharge
                      </h6>
                    </VCol>
                    <VCol
                      md="4"
                      cols="12"
                    >
                      <CustomCheckboxesWithIcon
                        v-model:selected-checkbox="inspection"
                        :checkbox-content="inspectionOptions"
                      />
                    </VCol>
                    <VCol
                      v-if="equipmentFetched.equipment_category === 'fire extinguisher'"
                      md="4"
                      cols="12"
                    >
                      <CustomCheckboxesWithIcon
                        v-model:selected-checkbox="rawRecharge"
                        :checkbox-content="rawRechargeOptions"
                      />
                    </VCol>
                    <VCol
                      v-if="equipmentFetched.equipment_category === 'fire extinguisher' && equipmentFetched.equipment_model !== 'co2'"
                      md="4"
                      cols="12"
                    >
                      <CustomCheckboxesWithIcon
                        v-model:selected-checkbox="nitrogenRecharge"
                        :checkbox-content="nitrogenRechargeOptions"
                      />
                    </VCol>
                  </VRow>
                </VWindowItem>

                <!-- 👉 Maintenance -->
                <VWindowItem>
                  <VRow>
                    <VCol cols="12">
                      <h6 class="text-h6 mb-4">
                        Maintenance
                      </h6>
                    </VCol>
                    <VCol cols="12">
                      <CustomCheckboxesWithIcon
                        v-model:selected-checkbox="maintenance"
                        :checkbox-content="maintenanceOptions"
                      />
                    </VCol>
                    <VCol cols="12">
                      <h6 class="text-h6 mb-4">
                        Additional Maintenance
                      </h6>
                    </VCol>
                    <VCol cols="12">
                      <CustomCheckboxesWithIcon
                        v-model:selected-checkbox="additionalMaintenance"
                        :checkbox-content="additionalMaintenanceOptions"
                      />
                    </VCol>
                  </VRow>
                </VWindowItem>
                <!-- 👉 Supply  -->
                <VWindowItem>
                  <VRow>
                    <VCol cols="12">
                      <h6 class="text-h6 mb-4">
                        Select Supply
                      </h6>
                    </VCol>
                    <VCol cols="12">
                      <CustomCheckboxesWithIcon
                        v-model:selected-checkbox="supply"
                        :checkbox-content="supplyOptions"
                        :grid-column="{ sm: '4', cols: '12' }"
                      />
                    </VCol>
                  </VRow>
                </VWindowItem>
                <VWindowItem>
                  <VRow>
                    <VCol cols="12">
                      <h6 class="text-h6 mb-4">
                        Select Accessories 
                      </h6>
                    </VCol>
                    <VCol 
                      sm="3"
                      cols="6"
                    >
                      <CustomCheckboxesWithIcon
                        v-model:selected-checkbox="standardSign"
                        :checkbox-content="standardSignOptions"
                        :grid-column="{ sm: '12', cols: '12' }"
                      />
                    </VCol>
                    <VCol 
                      sm="3"
                      cols="6"
                    >
                      <CustomCheckboxesWithIcon
                        v-model:selected-checkbox="numbering"
                        :checkbox-content="numberingOptions"
                        :grid-column="{ sm: '12', cols: '12' }"
                      />
                    </VCol>
                    <VCol 
                      sm="3"
                      cols="6"
                    >
                      <CustomCheckboxesWithIcon
                        v-model:selected-checkbox="pictogram"
                        :checkbox-content="pictogramOptions"
                        :grid-column="{ sm: '12', cols: '12' }"
                      />
                    </VCol>
                    <VCol 
                      sm="3"
                      cols="6"
                    >
                      <CustomCheckboxesWithIcon
                        v-model:selected-checkbox="equipmentFixation"
                        :checkbox-content="equipmentFixationOptions"
                        :grid-column="{ sm: '12', cols: '12' }"
                      />
                    </VCol>
                    <VCol cols="12">
                      <h6 class="text-h6 mb-4">
                        Select Protection
                      </h6>
                    </VCol>
                    <VCol cols="12">
                      <CustomRadiosWithIcon
                        v-model:selected-radio="accessories"
                        :radio-content="accessoriesOptions"
                        :grid-column="{ sm: '6', cols: '12' }"
                      />
                    </VCol>
                  </VRow>
                </VWindowItem>
                <VWindowItem>
                  <h6 class="text-h6 mb-4">
                    Select Equipment's Status
                  </h6>
                  <CustomRadiosWithIcon
                    v-model:selected-radio="equipmentStatus"
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
