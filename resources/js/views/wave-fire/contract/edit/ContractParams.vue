<script setup>
import {
  emailValidator,
  urlValidator,
  integerValidator,
  requiredValidator,
} from '@validators'

const props = defineProps({
  currentStep: {
    type: Number,
    required: false,
  },
  contractData: {
    type: Object,
    required: true,
  },
  technicians: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits([
  'update:currentStep',
  'submit',
])

const localContractData = ref((props.contractData))
const refVForm = ref()

const Previous = () => {
  emit('update:currentStep', props.currentStep ? props.currentStep - 1 : 1)
}

const updateContractData = async () => {
  emit('submit', localContractData.value)
}

const onSubmit = () => {
  refVForm.value?.validate().then(({ valid: isValid }) => {
    if (isValid) {
      updateContractData() // Emit the updated data
      emit('update:currentStep', props.currentStep ? props.currentStep + 1 : 1)
    }
  })
}

watch(() => props.currentStep, updateContractData)

const vehiclesModels = [
  {
    title: 'BoxerPeugeot Boxer',
    desc: '1584TU195', 
    value: 'Peugeot Boxer 1584TU195',
    icon: {
      icon: 'tabler-truck',
      size: '28',
    },
  },
  {
    title: 'Peugeot Jumpy ',
    desc: '1334TU202', 
    value: 'peugeot jumpy 1334TU202',
    icon: {
      icon: 'tabler-truck',
      size: '28',
    },
  },
  {
    title: 'Peugeot Expert',
    desc: '9984TU226', 
    value: 'peugeot expert 9984TU226',
    icon: {
      icon: 'tabler-truck',
      size: '28',
    },
  },
]

const contractStatus = [
  {
    title: 'Pending',
    value: 'pending',
  },
  {
    title: 'Work In Progress',
    value: 'in_progress',
  },
  {
    title: 'Intervention Completed',
    value: 'completed',
  },
  {
    title: 'Contract Closured',
    value: 'closure',
  },
]

const calculatedFuelCost = computed(() => {
  return (localContractData.value.fuel_price_100km / 100) * localContractData.value.target_in_km
})

watch(calculatedFuelCost, newValue => {
  localContractData.value.fuel_transportation = newValue
})

const calculatedAccommodationCost = computed(() => {
  return localContractData.value.accommodation_night * localContractData.value.contract_duration
})

watch(calculatedAccommodationCost, newValue => {
  localContractData.value.accommodation = newValue
})

const calculatedMealsCost = computed(() => {
  return (localContractData.value.meals_cost_member_day * localContractData.value.contract_duration) * localContractData.value.team_total
})

watch(calculatedMealsCost, newValue => {
  localContractData.value.meals_food = newValue
})

const calculatedTotalCost = computed(() => {
  // Parse all values as floats before adding them
  const fuelTransportationCost = parseFloat(localContractData.value.fuel_transportation)
  const accommodationCost = parseFloat(localContractData.value.accommodation)
  const mealsFoodCost = parseFloat(localContractData.value.meals_food)
  const miscellaneousExpenses = parseFloat(localContractData.value.miscellaneous_expenses)

  // Calculate the total cost
  return fuelTransportationCost + accommodationCost + mealsFoodCost + miscellaneousExpenses
})


watch(calculatedTotalCost, newValue => {
  localContractData.value.contract_finance_total = newValue
})

// Getter function for formattedTeamMembers
const formattedTeamMembers = computed({
  get() {
    try {
      return JSON.parse(localContractData.value.team_members)
    } catch (error) {
      return []
    }
  },

  // Setter function for formattedTeamMembers
  set(value) {
    // Convert the array back to a JSON string and update the original data
    localContractData.value.team_members = JSON.stringify(value)
  },
})
</script>

<template>
  <VRow>
    <VCol cols="12">
      <!-- 👉 Form -->
      <VForm
        ref="refVForm"
        lazy-validation
        class="mt-1"
        @submit.prevent="onSubmit"
      >
        <!-- 👉 Basic Params Contract -->
        <VCard title="Basic Params Contract">
          <VCardText class="pt-2">
            <VRow>
              <!-- 👉 contract_id -->
              <VCol
                md="4"
                cols="12"
              >
                <AppTextField
                  v-model="localContractData.contract_id"
                  label="Contract Id"
                  prepend-inner-icon="tabler-scan"
                  persistent-placeholder
                  readonly
                />
              </VCol>
              <!-- 👉 contract_type -->
              <VCol
                md="4"
                cols="12"
              >
                <AppTextField
                  v-model="localContractData.contract_type"
                  label="Contract Type"
                  prepend-inner-icon="tabler-category-2"
                  persistent-placeholder
                  readonly
                />
              </VCol>
              <!-- 👉 contract_status -->
              <VCol
                md="4"
                cols="12"
              >
                <AppSelect
                  v-model="localContractData.contract_status"
                  label="Contract Status"
                  :items="contractStatus"
                  prepend-inner-icon="tabler-check"
                  clearable
                  clear-icon="tabler-x"
                />
              </VCol>
              <!-- 👉 contract_frequency -->
              <VCol
                md="4"
                cols="12"
              >
                <AppTextField
                  v-model="localContractData.contract_frequency"
                  label="Contract Frequency"
                  prepend-inner-icon="tabler-hourglass-empty"
                  persistent-placeholder
                  readonly
                />
              </VCol>
              <!-- 👉 Contract Date -->
              <VCol
                md="4"
                cols="12"
              >
                <AppDateTimePicker
                  v-model="localContractData.contract_date"
                  label="Contract Date"
                  prepend-inner-icon="tabler-calendar-check"
                  persistent-placeholder
                />
              </VCol>
              <!-- 👉 Contract Duration -->
              <VCol
                md="4"
                cols="12"
              >
                <AppTextField
                  v-model="localContractData.contract_duration"
                  prepend-inner-icon="tabler-clock-pin"
                  label="Contract Duration"
                  suffix="Days"
                  type="number"
                />
              </VCol>
            </VRow>
          </VCardText>
        </VCard>
        <VDivider />
        <!-- 👉 Resources -->
        <VCard title="Resources">
          <VCardText class="pt-2">
            <VRow v-if="contractData.contract_type === 'workshop'">
              <!-- 👉 workshop_leader -->
              <VCol
                md="4"
                cols="12"
              >
                <AppSelect
                  v-model="localContractData.team_leader"
                  :items="props.technicians"
                  item-title="technician_name"
                  item-value="technician_name"
                  label="Select Workshop Leader"
                  clearable
                  clear-icon="tabler-x"
                >
                  <template #selection="{ item }">
                    <VChip>
                      <span>{{ item.title }}</span>
                    </VChip>
                  </template>
                </AppSelect>
              </VCol>
              <!-- 👉 Team Members -->
              <VCol
                md="4"
                cols="12"
              >
                <AppSelect
                  v-model="formattedTeamMembers"
                  :items="props.technicians"
                  item-title="technician_name"
                  item-value="technician_name"
                  label="Select Team Members"
                  multiple
                  clearable
                  clear-icon="tabler-x"
                >
                  <template #selection="{ item }">
                    <VChip>
                      <span>{{ item.title }}</span>
                    </VChip>
                  </template>
                </AppSelect>
              </VCol>
            </VRow>
            <VRow>
              <!-- 👉 team_leader -->
              <VCol
                v-if="contractData.contract_type === 'intervention'"
                md="4"
                cols="12"
              >
                <AppSelect
                  v-model="localContractData.team_leader"
                  :items="props.technicians"
                  item-title="technician_name"
                  item-value="technician_name"
                  label="Select Team Leader"
                  clearable
                  clear-icon="tabler-x"
                >
                  <template #selection="{ item }">
                    <VChip>
                      <span>{{ item.title }}</span>
                    </VChip>
                  </template>
                </AppSelect>
              </VCol>

              <!-- 👉 Team Driver -->
              <VCol
                v-if="contractData.contract_type === 'intervention'"
                md="4"
                cols="12"
              >
                <AppSelect
                  v-model="localContractData.team_driver"
                  :items="props.technicians"
                  item-title="technician_name"
                  item-value="technician_name"
                  label="Select Team Driver"
                  clearable
                  clear-icon="tabler-x"
                >
                  <template #selection="{ item }">
                    <VChip>
                      <span>{{ item.title }}</span>
                    </VChip>
                  </template>
                </AppSelect>
              </VCol>
              <!-- 👉 Team Members -->
              <VCol
                v-if="contractData.contract_type === 'intervention'"
                md="4"
                cols="12"
              >
                <AppSelect
                  v-model="formattedTeamMembers"
                  :items="props.technicians"
                  item-title="technician_name"
                  item-value="technician_name"
                  label="Select Team Members"
                  multiple
                  clearable
                  clear-icon="tabler-x"
                >
                  <template #selection="{ item }">
                    <VChip>
                      <span>{{ item.title }}</span>
                    </VChip>
                  </template>
                </AppSelect>
              </VCol>
            </VRow>
            <VRow v-if="contractData.contract_type === 'intervention'">
              <!-- 👉 vehicle_model -->
              <VCol cols="12">
                <h6 class="text-h6 my-4">
                  Select Vehicle Model
                </h6>
                <CustomRadiosWithIcon
                  v-model:selected-radio="localContractData.vehicle_model"
                  :radio-content="vehiclesModels"
                  :grid-column="{ sm: '4', cols: '12' }"
                />
              </VCol>
            </VRow>
            <VRow v-if="contractData.contract_type === 'intervention'">
              <!-- 👉 fuel_transportation -->
              <VCol
                md="3"
                cols="12"
              >
                <h6 class="text-h6 my-4">
                  Fuel Transportation
                </h6>
              </VCol>
              <VCol
                md="3"
                cols="6"
              >
                <AppTextField
                  v-model="localContractData.fuel_price_100km"
                  label="Fuel Price /100Km"
                  suffix="TND"
                  type="number"
                />
              </VCol>
              <VCol
                md="3"
                cols="6"
              >
                <AppTextField
                  v-model="localContractData.target_in_km"
                  label="Target in Km"
                  suffix="Km"
                  type="number"
                />
              </VCol>
              <VCol
                md="3"
                cols="12"
              >
                <AppTextField
                  v-model="localContractData.fuel_transportation"
                  label="Fuel Transportation Cost"
                  suffix="TND"
                  type="number"
                />
              </VCol>
            </VRow>
            <VRow v-if="contractData.contract_type === 'intervention'">
              <!-- 👉 Accommodation -->
              <VCol
                md="3"
                cols="12"
              >
                <h6 class="text-h6 my-4">
                  Accommodation
                </h6>
              </VCol>
              <VCol
                md="3"
                cols="6"
              >
                <AppTextField
                  v-model="localContractData.accommodation_night"
                  label="Accommodation/night"
                  suffix="TND"
                  type="number"
                />
              </VCol>
              <VCol
                md="6"
                cols="6"
              >
                <AppTextField
                  v-model="localContractData.accommodation"
                  label="Accommodation"
                  suffix="TND"
                  type="number"
                />
              </VCol>
            </VRow>
            <VRow v-if="contractData.contract_type === 'intervention'">
              <!-- 👉 Meals/Food -->
              <VCol
                md="3"
                cols="12"
              >
                <h6 class="text-h6 my-4">
                  Meals/Food
                </h6>
              </VCol>
              <VCol
                md="3"
                cols="6"
              >
                <AppTextField
                  v-model="localContractData.meals_cost_member_day"
                  label="Meals Cost/Member/Day"
                  suffix="TND"
                  type="number"
                />
              </VCol>
              <VCol
                md="3"
                cols="6"
              >
                <AppTextField
                  v-model="localContractData.team_total" 
                  label="Team Members Number"
                  type="number"
                />
              </VCol>
              <VCol
                md="3"
                cols="12"
              >
                <AppTextField
                  v-model="localContractData.meals_food"
                  label="Meals/Food"
                  suffix="TND"
                  type="number"
                />
              </VCol>
            </VRow>
            <VRow v-if="contractData.contract_type === 'intervention'">
              <!-- 👉 total_expenses -->
              <VCol
                md="3"
                cols="12"
              >
                <h6 class="text-h6 my-4">
                  Total Expenses
                </h6>
              </VCol>
              <VCol
                md="3"
                cols="6"
              >
                <AppTextField
                  v-model="localContractData.miscellaneous_expenses"
                  label="Miscellaneous Expenses"
                  suffix="TND"
                  type="number"
                />
              </VCol>
              <VCol
                md="6"
                cols="12"
              >
                <AppTextField
                  v-model="localContractData.contract_finance_total"
                  label="Total Expenses"
                  suffix="TND"
                  type="number"
                />
              </VCol>
            </VRow>
            <VRow>
              <!-- 👉 Contract Note -->
              <VCol cols="12">
                <AppTextarea 
                  v-model="localContractData.contract_note"
                  label="Contract Note"
                  prepend-inner-icon="tabler-note"
                  persistent-placeholder
                />
              </VCol>
            </VRow>
          </VCardText>
        </VCard>
        <VCol cols="12">
          <div class="d-flex flex-wrap gap-4 justify-sm-space-between justify-center mt-8">
            <VBtn
              color="secondary"
              variant="tonal"
              @click="Previous"
            >
              <VIcon
                icon="tabler-arrow-left"
                start
                class="flip-in-rtl"
              />
              Previous
            </VBtn>

            <VBtn
              type="submit"
              @click="refVForm?.validate()"
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
      </VForm>
    </VCol>
  </VRow>
</template>
