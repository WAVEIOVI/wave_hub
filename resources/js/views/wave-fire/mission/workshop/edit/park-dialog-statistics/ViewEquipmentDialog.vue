<script setup>
import { useWorkshopListStore } from '../../useWorkshopListStore'
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
  equipmentData: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits([
  'update:isDialogVisible',
])

const currentStep = ref(0)

const createApp = [
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
    title: 'Tasks',
  },
  {
    icon: 'tabler-check',
    title: 'Status',
  },
]

const workshopListStore = useWorkshopListStore()
const localWorkshopData = ref((props.workshopData))

const dialogVisibleUpdate = val => {
  emit('update:isDialogVisible', val)
  currentStep.value = 0
}

watch(props, () => {
  if (!props.isDialogVisible)
    currentStep.value = 0
})

watch(() => props.equipmentData, newValue => {
  localEquipmentData.value = { ...newValue }
})

const onFormSubmit = () => {
  emit('update:isDialogVisible', false)
}

const localEquipmentData = ref((props.equipmentData))

const inspectionOptions = [
  { title: 'Inspected', value: 'inspected' },
  { title: 'Not Inspected', value: null },
]

const rawRechargeOptions = [
  { title: 'Raw Refill', value: 'raw charged' },
  { title: 'Not Charged', value: null },
]

const nitrogenRechargeOptions = [
  { title: 'Nitrogen Refill', value: 'nitrogen charged' },
  { title: 'Not Charged', value: null },
]

const maintenanceOptions = [
  { title: 'Head Maintenance', value: 'head maintenance' },
  { title: 'Corps Maintenance', value: 'corps maintenance' },
  { title: 'Hose Maintenance', value: 'hose maintenance' },
]

const additionalMaintenanceOptions = [
  { title: 'Sandblasting', value: 'sandblasting' },
  { title: 'Paint', value: 'paint' },
  { title: 'Hydro Test', value: 'hydro test' },
]

const supplyOptions = [
  { title: 'Pressure Gauge', value: 'pressure gauge' },
  { title: 'Valve Assembly', value: 'valve assembly' },
  { title: 'Discharge Nozzle', value: 'discharge nozzle' },
  { title: 'Safety Pin', value: 'safety pin' },
  { title: 'O-ring', value: 'o ring' },
  { title: 'Handle and Lever', value: 'handle and lever' },
]

const standardSignOptions = [
  { title: 'Sign', value: 'available' },
  { title: 'Not Available', value: null },
]

const numberingOptions = [
  { title: 'Numbering', value: 'available' },
  { title: 'Not Available', value: null },
]

const pictogramOptions = [
  { title: 'Pictogram', value: 'available' },
  { title: 'Not Available', value: null },
]

const equipmentFixationOptions = [
  { title: 'Fixation', value: 'available' },
  { title: 'Not Available', value: null },
]

const accessoriesOptions = [
  { title: 'Cover', value: 'cover' },
  { title: 'Box', value: 'box' },
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


// Getter function for formattedMaintenance
const formattedMaintenance = computed({
  get() {
    try {
      return JSON.parse(localEquipmentData.value.pivot.maintenance)
    } catch (error) {
      return []
    }
  },

  // Setter function for formattedMaintenance
  set(value) {
    // Convert the array back to a JSON string and update the original data
    localEquipmentData.value.pivot.maintenance = JSON.stringify(value)
  },
})

// Getter function for formattedAdditionalMaintenance
const formattedAdditionalMaintenance = computed({
  get() {
    try {
      return JSON.parse(localEquipmentData.value.pivot.additional_maintenance)
    } catch (error) {
      return []
    }
  },

  // Setter function for formattedAdditionalMaintenance
  set(value) {
    // Convert the array back to a JSON string and update the original data
    localEquipmentData.value.pivot.additional_maintenance = JSON.stringify(value)
  },
})

// Getter function for formattedSupply
const formattedSupply = computed({
  get() {
    try {
      return JSON.parse(localEquipmentData.value.pivot.supply)
    } catch (error) {
      return []
    }
  },

  // Setter function for formattedSupply
  set(value) {
    // Convert the array back to a JSON string and update the original data
    localEquipmentData.value.pivot.supply = JSON.stringify(value)
  },
})
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
          View A Equipment
        </h5>
        <p class="text-sm text-center mb-8">
          View tasks data with this equipment.
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
              <!-- 👉 Equipment -->
              <VWindowItem>
                <VCard>
                  <div class="d-flex justify-space-between flex-wrap flex-md-nowrap flex-column flex-md-row">
                    <div class="ma-auto pa-5">
                      <VImg
                        v-if="localEquipmentData.equipment_model === 'powder abc'"
                        width="250"
                        height="300"
                        :src="FireExtinguisherPowder"
                      />
                      <VImg
                        v-if="localEquipmentData.equipment_model === 'co2'"
                        width="250"
                        height="300"
                        :image="FireExtinguisherCo2"
                      />
                      <VImg
                        v-if="localEquipmentData.equipment_model === 'water-based' || localEquipmentData.equipment_model === 'foam'"
                        width="137"
                        height="176"
                        :image="FireExtinguisherFoam"
                      />
                      <VImg
                        v-if="localEquipmentData.equipment_category === 'fire hose'"
                        width="137"
                        height="176"
                        :image="FireHose"
                      />
                      <VImg
                        v-if="localEquipmentData.equipment_weight === '50kg'"
                        width="137"
                        height="176"
                        :image="FireExtinguisherPowder50"
                      />
                    </div>

                    <VDivider :vertical="$vuetify.display.mdAndUp" />

                    <div>
                      <VCardItem>
                        <VCardTitle>{{ localEquipmentData.qrc_id }} | {{ localEquipmentData.internal_id }} | {{ localEquipmentData.serial_number }}</VCardTitle>
                        <VCardTitle>{{ localEquipmentData.equipment_category }} {{ localEquipmentData.equipment_model }}</VCardTitle>
                        <VCardTitle>{{ localEquipmentData.equipment_weight }} {{ localEquipmentData.equipment_pressure }}</VCardTitle>
                      </VCardItem>

                      <VCardText class="text-subtitle-1">
                        <span>Status :</span> <span class="font-weight-medium">{{ localEquipmentData.equipment_status }}</span>
                      </VCardText>
                    </div>
                  </div>
                </VCard>
              </VWindowItem>
              <VWindowItem>
                <VRow>
                  <VCol cols="12">
                    <h6 class="text-h6 mb-4">
                      Inspection & Recharge
                    </h6>
                  </VCol>
                  <VCol cols="12">
                    <AppSelect
                      v-model="localEquipmentData.pivot.inspection"
                      :items="inspectionOptions"
                      item-title="title"
                      item-value="value"
                      label="Inspection"
                      clearable
                      clear-icon="tabler-x"
                      readonly
                    >
                      <template #selection="{ item }">
                        <VChip>
                          <span>{{ item.title }}</span>
                        </VChip>
                      </template>
                    </AppSelect>
                  </VCol>
                  <VCol
                    v-if="localEquipmentData.equipment_category === 'fire extinguisher'"
                    cols="12"
                  >
                    <AppSelect
                      v-model="localEquipmentData.pivot.raw_recharge"
                      :items="rawRechargeOptions"
                      item-title="title"
                      item-value="value"
                      label="Raw Recharge"
                      clearable
                      clear-icon="tabler-x"
                      readonly
                    >
                      <template #selection="{ item }">
                        <VChip>
                          <span>{{ item.title }}</span>
                        </VChip>
                      </template>
                    </AppSelect>
                  </VCol>
                  <VCol
                    v-if="localEquipmentData.equipment_category === 'fire extinguisher' && localEquipmentData.equipment_model !== 'co2'"
                    cols="12"
                  >
                    <AppSelect
                      v-model="localEquipmentData.pivot.nitrogen_recharge"
                      :items="nitrogenRechargeOptions"
                      item-title="title"
                      item-value="value"
                      label="Nitrogen Recharge"
                      clearable
                      clear-icon="tabler-x"
                      readonly
                    >
                      <template #selection="{ item }">
                        <VChip>
                          <span>{{ item.title }}</span>
                        </VChip>
                      </template>
                    </AppSelect>
                  </VCol>
                </VRow>
              </VWindowItem>

              <!-- 👉 Tasks -->
              <VWindowItem>
                <VRow>
                  <VCol cols="12">
                    <h6 class="text-h6 mb-4">
                      Tasks
                    </h6>
                  </VCol>
                  <VCol cols="12">
                    <AppSelect
                      v-model="formattedMaintenance"
                      :items="maintenanceOptions"
                      item-title="title"
                      item-value="value"
                      label="Maintenance"
                      multiple
                      clearable
                      clear-icon="tabler-x"
                      readonly
                    >
                      <template #selection="{ item }">
                        <VChip>
                          <span>{{ item.title }}</span>
                        </VChip>
                      </template>
                    </AppSelect>
                  </VCol>
                  <VCol cols="12">
                    <AppSelect
                      v-model="formattedAdditionalMaintenance"
                      :items="additionalMaintenanceOptions"
                      item-title="title"
                      item-value="value"
                      label="Additional Maintenance"
                      multiple
                      clearable
                      clear-icon="tabler-x"
                      readonly
                    >
                      <template #selection="{ item }">
                        <VChip>
                          <span>{{ item.title }}</span>
                        </VChip>
                      </template>
                    </AppSelect>
                  </VCol>
                  <VCol cols="12">
                    <AppSelect
                      v-model="formattedSupply"
                      :items="supplyOptions"
                      item-title="title"
                      item-value="value"
                      label="Supply"
                      multiple
                      clearable
                      clear-icon="tabler-x"
                      readonly
                    >
                      <template #selection="{ item }">
                        <VChip>
                          <span>{{ item.title }}</span>
                        </VChip>
                      </template>
                    </AppSelect>
                  </VCol>
                  <VCol cols="6">
                    <AppSelect
                      v-model="localEquipmentData.pivot.standard_sign"
                      :items="standardSignOptions"
                      item-title="title"
                      item-value="value"
                      label="Standard Sign"
                      clearable
                      clear-icon="tabler-x"
                      readonly
                    >
                      <template #selection="{ item }">
                        <VChip>
                          <span>{{ item.title }}</span>
                        </VChip>
                      </template>
                    </AppSelect>
                  </VCol>
                  <VCol cols="6">
                    <AppSelect
                      v-model="localEquipmentData.pivot.numbering"
                      :items="numberingOptions"
                      item-title="title"
                      item-value="value"
                      label="Numbering"
                      clearable
                      clear-icon="tabler-x"
                      readonly
                    >
                      <template #selection="{ item }">
                        <VChip>
                          <span>{{ item.title }}</span>
                        </VChip>
                      </template>
                    </AppSelect>
                  </VCol>
                  <VCol cols="6">
                    <AppSelect
                      v-model="localEquipmentData.pivot.pictogram"
                      :items="pictogramOptions"
                      item-title="title"
                      item-value="value"
                      label="Pictogram"
                      clearable
                      clear-icon="tabler-x"
                      readonly
                    >
                      <template #selection="{ item }">
                        <VChip>
                          <span>{{ item.title }}</span>
                        </VChip>
                      </template>
                    </AppSelect>
                  </VCol>
                  <VCol cols="6">
                    <AppSelect
                      v-model="localEquipmentData.pivot.equipment_fixation"
                      :items="equipmentFixationOptions"
                      item-title="title"
                      item-value="value"
                      label="Fixation"
                      clearable
                      clear-icon="tabler-x"
                      readonly
                    >
                      <template #selection="{ item }">
                        <VChip>
                          <span>{{ item.title }}</span>
                        </VChip>
                      </template>
                    </AppSelect>
                  </VCol>
                  <VCol cols="12">
                    <AppSelect
                      v-model="localEquipmentData.pivot.accessories"
                      :items="accessoriesOptions"
                      item-title="title"
                      item-value="value"
                      label="Protection"
                      clearable
                      clear-icon="tabler-x"
                      readonly
                    >
                      <template #selection="{ item }">
                        <VChip>
                          <span>{{ item.title }}</span>
                        </VChip>
                      </template>
                    </AppSelect>
                  </VCol>
                </VRow>
              </VWindowItem>  
              <VWindowItem>
                <h6 class="text-h6 mb-4">
                  Equipment's Status
                </h6>
                <CustomRadiosWithIcon
                  v-model:selected-radio="localEquipmentData.pivot.equipment_status"
                  :radio-content="status"
                  :grid-column="{ sm: '4', cols: '12' }"
                  readonly
                />
              </VWindowItem>
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
