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
  interventionData: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits([
  'update:currentStep',
  'submit',
])

const localInterventionData = ref((props.interventionData))

const isReadOnly = computed(() => {
  return localInterventionData.value.intervention_status === 'completed'
})

const updateInterventionData = async () => {
  emit('submit', localInterventionData.value)
  console.log('Function called step B')
}

const onSubmit = () => {
  updateInterventionData()
  console.log('Function called step A')
}

const next = () => {
  emit('update:currentStep', props.currentStep ? props.currentStep + 1 : 1)
}

watch(() => props.currentStep)

// Getter function for formattedTeamMembers
const formattedTeamMembers = computed({
  get() {
    try {
      return JSON.parse(localInterventionData.value.team_members)
    } catch (error) {
      return []
    }
  },

  // Setter function for formattedTeamMembers
  set(value) {
    // Convert the array back to a JSON string and update the original data
    localInterventionData.value.team_members = JSON.stringify(value)
  },
})

const interventionStatus = [
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
]
</script>

<template>
  <VRow>
    <VCol cols="12">
      <!-- 👉 Mission Information -->
      <VCard title="Mission Information">
        <VCardText class="pt-2">
          <VRow>
            <!-- 👉 intervention_id -->
            <VCol
              md="4"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.intervention_id"
                label="Intervention Id"
                prepend-inner-icon="tabler-scan"
                persistent-placeholder
                readonly
              />
            </VCol>
            <!-- 👉 intervention_status -->
            <VCol
              md="4"
              cols="12"
            >
              <AppSelect
                v-model="localInterventionData.intervention_status"
                label="Intervention Status"
                :items="interventionStatus"
                prepend-inner-icon="tabler-check"
                clearable
                clear-icon="tabler-x"
                :disabled="isReadOnly"
                @update:model-value="onSubmit"
              />
            </VCol>
          </VRow>
          <VRow>
            <!-- 👉 intervention_frequency -->
            <VCol
              md="4"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.mission_frequency"
                label="Intervention Frequency"
                prepend-inner-icon="tabler-hourglass-empty"
                persistent-placeholder
                readonly
              />
            </VCol>
            <!-- 👉 Intervention Date -->
            <VCol
              md="4"
              cols="12"
            >
              <AppDateTimePicker
                v-model="localInterventionData.intervention_date"
                label="Intervention Date"
                prepend-inner-icon="tabler-calendar-check"
                persistent-placeholder
                readonly
              />
            </VCol>
            <!-- 👉 Intervention Duration -->
            <VCol
              md="4"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.intervention_duration"
                prepend-inner-icon="tabler-clock-pin"
                label="Intervention Duration"
                suffix="Days"
                type="number"
                readonly
              />
            </VCol>
          </VRow>
        </VCardText>
      </VCard>
    </VCol>
    <VCol cols="12">
      <!-- 👉 Intervention Basic Information -->
      <VCard title="Client Information">
        <VCardText class="pt-2">
          <VRow>
            <!-- 👉 Intervention Id -->
            <VCol
              md="4"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.mission_client_id"
                label="Client Id"
                readonly
                prepend-inner-icon="tabler-scan"
                persistent-placeholder
              />
            </VCol>

            <!-- 👉 Client Name -->
            <VCol
              md="4"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.client_name"
                label="Client Name"
                prepend-inner-icon="tabler-user"
                placeholder="Client Name"
                persistent-placeholder
                readonly
              />
            </VCol>
            <!-- 👉 Merge -->
            <VCol
              md="4"
              cols="12"
            />
              
            <!-- 👉 Address -->
            <VCol
              md="6"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.address"
                label="Address"
                prepend-inner-icon="tabler-map-pin"
                placeholder="Address "
                persistent-placeholder
                readonly
              />
            </VCol>

            <!-- 👉 postcode -->
            <VCol
              md="2"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.postcode"
                readonly
                label="Postcode"
              />
            </VCol>

            <!-- 👉 city -->
            <VCol
              md="2"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.city"
                label="City"
                readonly
              />
            </VCol>

            <!-- 👉 Country -->
            <VCol
              md="2"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.country"
                label="Country"
                readonly
              />
            </VCol>
            <!-- 👉 Main Phone Number -->
            <VCol
              md="4"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.main_phone_number"
                label="Phone Number"
                prepend-inner-icon="tabler-phone"
                placeholder="Phone number "
                persistent-placeholder
                readonly
              />
            </VCol>
              
            <!-- 👉 Client Email -->
            <VCol
              md="4"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.client_email"
                label="Email"
                prepend-inner-icon="tabler-mail"
                placeholder="Email "
                persistent-placeholder
                readonly
              />
            </VCol>
              
            <!-- 👉 Client Website -->
            <VCol
              md="4"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.client_website"
                label="Web-Site"
                prepend-inner-icon="tabler-world-www"
                placeholder="Web-Site "
                persistent-placeholder
                readonly
              />
            </VCol>
          </VRow>
        </VCardText>
      </VCard>
    </VCol>
    <VCol cols="12">
      <!-- 👉 Park Information -->
      <VCard
        v-if="localInterventionData.park_id"
        title="Park Information"
      >
        <VCardText class="pt-2">
          <VRow>
            <!-- 👉 Park Id -->
            <VCol
              md="4"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.park_id"
                label="Park Id"
                readonly
                prepend-inner-icon="tabler-scan"
                persistent-placeholder
              />
            </VCol>
            <!-- 👉 Park Title -->
            <VCol
              md="4"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.park_title"
                label="Park Title"
                prepend-inner-icon="tabler-flame"
                placeholder="Park Title"
                persistent-placeholder
                readonly
              />
            </VCol>
            <!-- 👉 park type -->
            <VCol
              md="4"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.park_type"
                label="Type"
                density="compact"
                readonly
              />
            </VCol>
            <!-- 👉 Address -->
            <VCol
              md="6"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.park_address"
                label="Address"
                prepend-inner-icon="tabler-map-pin"
                placeholder="Address "
                persistent-placeholder
                readonly
              />
            </VCol>

            <!-- 👉 postcode -->
            <VCol
              md="2"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.park_postcode"
                label="Postcode"
                placeholder="3000"
                persistent-placeholder
                readonly
              />
            </VCol>

            <!-- 👉 city -->
            <VCol
              md="2"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.park_city"
                label="City"
                placeholder="Sfax"
                persistent-placeholder
                readonly
              />
            </VCol>

            <!-- 👉 Country -->
            <VCol
              md="2"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.park_country"
                label="Country"
                placeholder="Tunisia"
                persistent-placeholder
                readonly
              />
            </VCol>
          </VRow>
        </VCardText>
      </VCard>
    </VCol>
    <VCol cols="12">
      <VCard title="Resources">
        <VCardText class="pt-2">
          <VRow>
            <!-- 👉 team_leader -->
            <VCol
              md="4"
              cols="12"
            >
              <AppSelect
                v-model="localInterventionData.team_leader"
                item-title="technician_name"
                item-value="technician_name"
                label="Team Leader"
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

            <!-- 👉 Team Driver -->
            <VCol
              md="4"
              cols="12"
            >
              <AppSelect
                v-model="localInterventionData.team_driver"
                :items="props.technicians"
                item-title="technician_name"
                item-value="technician_name"
                label="Team Driver"
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
                label="Team Members"
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
          </VRow>
          <VRow>
            <!-- 👉 vehicle_model -->
            <VCol
              md="3"
              cols="12"
            >
              <h6 class="text-h6 my-4">
                Vehicle
              </h6>
            </VCol>
            <VCol
              md="3"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.vehicle_model"
                label="Vehicle Model"
                readonly
              />
            </VCol>
          </VRow>
          <VRow>
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
                v-model="localInterventionData.fuel_price_100km"
                label="Fuel Price /100Km"
                suffix="TND"
                type="number"
                readonly
              />
            </VCol>
            <VCol
              md="3"
              cols="6"
            >
              <AppTextField
                v-model="localInterventionData.target_in_km"
                label="Target in Km"
                suffix="Km"
                type="number"
                readonly
              />
            </VCol>
            <VCol
              md="3"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.fuel_transportation"
                label="Fuel Transportation Cost"
                suffix="TND"
                type="number"
                readonly
              />
            </VCol>
          </VRow>
          <VRow>
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
                v-model="localInterventionData.accommodation_night"
                label="Accommodation/night"
                suffix="TND"
                type="number"
                readonly
              />
            </VCol>
            <VCol
              md="6"
              cols="6"
            >
              <AppTextField
                v-model="localInterventionData.accommodation"
                label="Accommodation"
                suffix="TND"
                type="number"
                readonly
              />
            </VCol>
          </VRow>
          <VRow>
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
                v-model="localInterventionData.meals_cost_member_day"
                label="Meals Cost/Member/Day"
                suffix="TND"
                type="number"
                readonly
              />
            </VCol>
            <VCol
              md="3"
              cols="6"
            >
              <AppTextField
                v-model="localInterventionData.team_total" 
                label="Team Members Number"
                type="number"
                readonly
              />
            </VCol>
            <VCol
              md="3"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.meals_food"
                label="Meals/Food"
                suffix="TND"
                type="number"
                readonly
              />
            </VCol>
          </VRow>
          <VRow>
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
                v-model="localInterventionData.miscellaneous_expenses"
                label="Miscellaneous Expenses"
                suffix="TND"
                type="number"
                readonly
              />
            </VCol>
            <VCol
              md="6"
              cols="12"
            >
              <AppTextField
                v-model="localInterventionData.intervention_finance_total"
                label="Total Expenses"
                suffix="TND"
                type="number"
                readonly
              />
            </VCol>
          </VRow>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
  <VCol cols="12">
    <div class="d-flex flex-wrap gap-4 justify-sm-space-between justify-center mt-8">
      <VBtn
        color="secondary"
        variant="tonal"
        disabled
      >
        <VIcon
          icon="tabler-arrow-left"
          start
          class="flip-in-rtl"
        />
        Previous
      </VBtn>

      <VBtn @click="next">
        Next
        <VIcon
          icon="tabler-arrow-right"
          end
          class="flip-in-rtl"
        />
      </VBtn>
    </div>
  </VCol>
</template>
