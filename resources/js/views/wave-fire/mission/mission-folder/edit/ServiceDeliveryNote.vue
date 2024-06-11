<script setup>
const props = defineProps({
  currentStep: {
    type: Number,
    required: false,
  },
  missionData: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits([
  'update:currentStep',
  'submit',
])

const localMissionData = ref((props.missionData))
const refVForm = ref()

const Previous = () => {
  emit('update:currentStep', props.currentStep ? props.currentStep - 1 : 1)
}

const updateMissionData = async () => {
  emit('submit', localMissionData.value)
}

const onSubmit = () => {
  refVForm.value?.validate().then(({ valid: isValid }) => {
    if (isValid) {
      updateMissionData() // Emit the updated data
      emit('update:currentStep', props.currentStep ? props.currentStep + 1 : 1)
    }
  })
}

watch(() => props.currentStep, updateMissionData)

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

const missionStatus = [
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
    title: 'Mission Closured',
    value: 'closure',
  },
]

const calculatedFuelCost = computed(() => {
  return (localMissionData.value.fuel_price_100km / 100) * localMissionData.value.target_in_km
})

watch(calculatedFuelCost, newValue => {
  localMissionData.value.fuel_transportation = newValue
})

const calculatedAccommodationCost = computed(() => {
  return localMissionData.value.accommodation_night * localMissionData.value.mission_duration
})

watch(calculatedAccommodationCost, newValue => {
  localMissionData.value.accommodation = newValue
})

const calculatedMealsCost = computed(() => {
  return (localMissionData.value.meals_cost_member_day * localMissionData.value.mission_duration) * localMissionData.value.team_total
})

watch(calculatedMealsCost, newValue => {
  localMissionData.value.meals_food = newValue
})

const calculatedTotalCost = computed(() => {
  // Parse all values as floats before adding them
  const fuelTransportationCost = parseFloat(localMissionData.value.fuel_transportation)
  const accommodationCost = parseFloat(localMissionData.value.accommodation)
  const mealsFoodCost = parseFloat(localMissionData.value.meals_food)
  const miscellaneousExpenses = parseFloat(localMissionData.value.miscellaneous_expenses)

  // Calculate the total cost
  return fuelTransportationCost + accommodationCost + mealsFoodCost + miscellaneousExpenses
})


watch(calculatedTotalCost, newValue => {
  localMissionData.value.mission_finance_total = newValue
})

// Getter function for formattedTeamMembers
const formattedTeamMembers = computed({
  get() {
    try {
      return JSON.parse(localMissionData.value.team_members)
    } catch (error) {
      return []
    }
  },

  // Setter function for formattedTeamMembers
  set(value) {
    // Convert the array back to a JSON string and update the original data
    localMissionData.value.team_members = JSON.stringify(value)
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
        <!-- 👉 Basic Params Mission -->
        <VCard title="Basic Params Mission">
          <VCardText class="pt-2">
            <VRow>
              <!-- 👉 mission_id -->
              <VCol
                md="4"
                cols="12"
              >
                <AppTextField
                  v-model="localMissionData.mission_id"
                  label="Mission Id"
                  prepend-inner-icon="tabler-scan"
                  persistent-placeholder
                  readonly
                />
              </VCol>
              <!-- 👉 mission_type -->
              <VCol
                md="4"
                cols="12"
              >
                <AppTextField
                  v-model="localMissionData.mission_type"
                  label="Mission Type"
                  prepend-inner-icon="tabler-category-2"
                  persistent-placeholder
                  readonly
                />
              </VCol>
              <!-- 👉 mission_status -->
              <VCol
                md="4"
                cols="12"
              >
                <AppSelect
                  v-model="localMissionData.mission_status"
                  label="Mission Status"
                  :items="missionStatus"
                  prepend-inner-icon="tabler-check"
                  clearable
                  clear-icon="tabler-x"
                />
              </VCol>
              <!-- 👉 mission_frequency -->
              <VCol
                md="4"
                cols="12"
              >
                <AppTextField
                  v-model="localMissionData.mission_frequency"
                  label="Mission Frequency"
                  prepend-inner-icon="tabler-hourglass-empty"
                  persistent-placeholder
                  readonly
                />
              </VCol>
              <!-- 👉 Mission Date -->
              <VCol
                md="4"
                cols="12"
              >
                <AppDateTimePicker
                  v-model="localMissionData.mission_date"
                  label="Mission Date"
                  prepend-inner-icon="tabler-calendar-check"
                  persistent-placeholder
                />
              </VCol>
              <!-- 👉 Mission Duration -->
              <VCol
                md="4"
                cols="12"
              >
                <AppTextField
                  v-model="localMissionData.mission_duration"
                  prepend-inner-icon="tabler-clock-pin"
                  label="Mission Duration"
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
            <VRow v-if="missionData.mission_type === 'workshop'">
              <!-- 👉 workshop_leader -->
              <VCol
                md="4"
                cols="12"
              >
                <AppSelect
                  v-model="localMissionData.team_leader"
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
                v-if="missionData.mission_type === 'intervention'"
                md="4"
                cols="12"
              >
                <AppSelect
                  v-model="localMissionData.team_leader"
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
                v-if="missionData.mission_type === 'intervention'"
                md="4"
                cols="12"
              >
                <AppSelect
                  v-model="localMissionData.team_driver"
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
                v-if="missionData.mission_type === 'intervention'"
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
            <VRow v-if="missionData.mission_type === 'intervention'">
              <!-- 👉 vehicle_model -->
              <VCol cols="12">
                <h6 class="text-h6 my-4">
                  Select Vehicle Model
                </h6>
                <CustomRadiosWithIcon
                  v-model:selected-radio="localMissionData.vehicle_model"
                  :radio-content="vehiclesModels"
                  :grid-column="{ sm: '4', cols: '12' }"
                />
              </VCol>
            </VRow>
            <VRow v-if="missionData.mission_type === 'intervention'">
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
                  v-model="localMissionData.fuel_price_100km"
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
                  v-model="localMissionData.target_in_km"
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
                  v-model="localMissionData.fuel_transportation"
                  label="Fuel Transportation Cost"
                  suffix="TND"
                  type="number"
                />
              </VCol>
            </VRow>
            <VRow v-if="missionData.mission_type === 'intervention'">
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
                  v-model="localMissionData.accommodation_night"
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
                  v-model="localMissionData.accommodation"
                  label="Accommodation"
                  suffix="TND"
                  type="number"
                />
              </VCol>
            </VRow>
            <VRow v-if="missionData.mission_type === 'intervention'">
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
                  v-model="localMissionData.meals_cost_member_day"
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
                  v-model="localMissionData.team_total" 
                  label="Team Members Number"
                  type="number"
                />
              </VCol>
              <VCol
                md="3"
                cols="12"
              >
                <AppTextField
                  v-model="localMissionData.meals_food"
                  label="Meals/Food"
                  suffix="TND"
                  type="number"
                />
              </VCol>
            </VRow>
            <VRow v-if="missionData.mission_type === 'intervention'">
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
                  v-model="localMissionData.miscellaneous_expenses"
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
                  v-model="localMissionData.mission_finance_total"
                  label="Total Expenses"
                  suffix="TND"
                  type="number"
                />
              </VCol>
            </VRow>
            <VRow>
              <!-- 👉 Mission Note -->
              <VCol cols="12">
                <AppTextarea 
                  v-model="localMissionData.mission_note"
                  label="Mission Note"
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
