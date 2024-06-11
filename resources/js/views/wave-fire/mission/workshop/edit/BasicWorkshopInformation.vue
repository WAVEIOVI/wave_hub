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
  workshopData: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits([
  'update:currentStep',
  'submit',
])

const localWorkshopData = ref((props.workshopData))

const isReadOnly = computed(() => {
  return localWorkshopData.value.workshop_status === 'completed'
})

const updateWorkshopData = async () => {
  emit('submit', localWorkshopData.value)
  console.log('Function called step B')
}

const onSubmit = () => {
  updateWorkshopData()
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
      return JSON.parse(localWorkshopData.value.team_members)
    } catch (error) {
      return []
    }
  },

  // Setter function for formattedTeamMembers
  set(value) {
    // Convert the array back to a JSON string and update the original data
    localWorkshopData.value.team_members = JSON.stringify(value)
  },
})

const workshopStatus = [
  {
    title: 'Pending',
    value: 'pending',
  },
  {
    title: 'Work In Progress',
    value: 'in_progress',
  },
  {
    title: 'Workshop Completed',
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
            <!-- 👉 workshop_id -->
            <VCol
              md="4"
              cols="12"
            >
              <AppTextField
                v-model="localWorkshopData.workshop_id"
                label="Workshop Id"
                prepend-inner-icon="tabler-scan"
                persistent-placeholder
                readonly
              />
            </VCol>
            <!-- 👉 workshop status -->
            <VCol
              md="4"
              cols="12"
            >
              <AppSelect
                v-model="localWorkshopData.workshop_status"
                label="Mission Status"
                :items="workshopStatus"
                prepend-inner-icon="tabler-check"
                clearable
                clear-icon="tabler-x"
                :disabled="isReadOnly"
                @update:model-value="onSubmit"
              />
            </VCol>
          </VRow>
          <VRow>
            <!-- 👉 mission_frequency -->
            <VCol
              md="4"
              cols="12"
            >
              <AppTextField
                v-model="localWorkshopData.mission_frequency"
                label="Mission Frequency"
                prepend-inner-icon="tabler-hourglass-empty"
                persistent-placeholder
                readonly
              />
            </VCol>
            <!-- 👉 workshop Date -->
            <VCol
              md="4"
              cols="12"
            >
              <AppDateTimePicker
                v-model="localWorkshopData.workshop_date"
                label="Mission Date"
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
                v-model="localWorkshopData.workshop_duration"
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
      <!-- 👉 Workshop Basic Information -->
      <VCard title="Client Information">
        <VCardText class="pt-2">
          <VRow>
            <!-- 👉 Workshop Id -->
            <VCol
              md="4"
              cols="12"
            >
              <AppTextField
                v-model="localWorkshopData.mission_client_id"
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
                v-model="localWorkshopData.client_name"
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
                v-model="localWorkshopData.address"
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
                v-model="localWorkshopData.postcode"
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
                v-model="localWorkshopData.city"
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
                v-model="localWorkshopData.country"
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
                v-model="localWorkshopData.main_phone_number"
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
                v-model="localWorkshopData.client_email"
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
                v-model="localWorkshopData.client_website"
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
      <VCard title="Resources">
        <VCardText class="pt-2">
          <VRow>
            <!-- 👉 workshop_leader -->
            <VCol
              md="4"
              cols="12"
            >
              <AppSelect
                v-model="localWorkshopData.workshop_leader"
                item-title="technician_name"
                item-value="technician_name"
                label="Workshop Leader"
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
