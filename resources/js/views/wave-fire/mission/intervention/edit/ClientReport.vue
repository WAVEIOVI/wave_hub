<script setup>
import ClientReportTasksCard from './ClientReportTasksCard.vue'
import ExitSlipCard from './ExitSlipCard.vue'


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

// 👉 Equipment Headers
const equipmentHeaders = [
  {
    title: 'EQUIPMENT',
    key: 'equipment',
  },
  {
    title: 'STATUS',
    key: 'equipment_status',
  },
]

const localInterventionData = ref((props.interventionData))
const refVForm = ref()

const Previous = () => {
  emit('update:currentStep', props.currentStep ? props.currentStep - 1 : 1)
}

const updateInterventionData = async () => {
  emit('submit', localInterventionData.value)
}

const onSubmit = () => {
  updateInterventionData() // Emit the updated data
}

watch(() => props.currentStep)

// Function to parse additional maintenance data
const parsedTeamMembers = teamMembers => {
  try {
    return JSON.parse(teamMembers)
  } catch (error) {
    return []
  }
}
</script>

<template>
  <VRow>
    <VCol cols="12">
      <!-- 👉 Client Information -->
      <VCard title="Client Report">
        <VCardText>
          <VRow>
            <VCol
              md="4"
              cols="12"
            >
              <VCard class="mb-4">
                <VCardText>
                  <p class="text-xs">
                    Service Provider
                  </p>

                  <VList class="card-list text-medium-emphasis">
                    <VListItem>
                      <template #prepend>
                        <VIcon
                          icon="tabler-user"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span class="font-weight-medium me-1">Company Profile:</span>
                        <span>SS PLUS</span>
                      </VListItemTitle>
                    </VListItem>
                    <VListItem>
                      <template #prepend>
                        <VIcon
                          icon="tabler-map-pin"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span class="font-weight-medium me-1">Address:</span>
                        <span>Gabes Road Km 3.5 Sfax</span>
                      </VListItemTitle>
                    </VListItem>
                  </VList>

                  <p class="text-xs mt-5">
                    CONTACTS
                  </p>

                  <VList class="card-list text-medium-emphasis">
                    <VListItem>
                      <template #prepend>
                        <VIcon
                          icon="tabler-phone"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span class="font-weight-medium me-1">Phone:</span>
                        <span>+216 74 453 027</span>
                      </VListItemTitle>
                    </VListItem>
                    <VListItem>
                      <template #prepend>
                        <VIcon
                          icon="tabler-mail"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span class="font-weight-medium me-1">Email:</span>
                        <span>contact@ssplus.tn</span>
                      </VListItemTitle>
                    </VListItem>
                  </VList>

                  <p class="text-xs mt-5">
                    Mission
                  </p>

                  <VList class="card-list text-medium-emphasis">
                    <VListItem>
                      <template #prepend>
                        <VIcon
                          icon="tabler-scan"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span class="font-weight-medium me-1">Mission ID:</span>
                        <span>{{ localInterventionData.intervention_id }}</span>
                      </VListItemTitle>
                    </VListItem>
                    <VListItem>
                      <template #prepend>
                        <VIcon
                          icon="tabler-calendar-check"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span class="font-weight-medium me-1">Mission Date:</span>
                        <span>{{ localInterventionData.intervention_date }}</span>
                      </VListItemTitle>
                    </VListItem>
                    <VListItem>
                      <template #prepend>
                        <VIcon
                          icon="tabler-hourglass-empty"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span class="font-weight-medium me-1">Mission Frequency:</span>
                        <span>{{ localInterventionData.mission_frequency }}</span>
                      </VListItemTitle>
                    </VListItem>
                  </VList>

                  <p class="text-xs mt-5">
                    TEAMS
                  </p>

                  <VList class="card-list text-medium-emphasis">
                    <VListItem>
                      <template #prepend>
                        <VIcon
                          icon="tabler-user-check"
                          size="20"
                          color="success"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span class="font-weight-medium me-1">Team Leader:</span>
                        <span>{{ localInterventionData.team_leader }}</span>
                      </VListItemTitle>
                    </VListItem>
                    <VListItem>
                      <VListItemTitle>
                        <VIcon
                          icon="tabler-users"
                          size="20"
                          color="success"
                          class="me-2"
                        />
                        <span class="font-weight-medium me-1">Team Members:</span>
                      </VListItemTitle>
                      <VChipGroup>
                        <VChip
                          v-for="teamMembers in parsedTeamMembers(localInterventionData.team_members)"
                          :key="teamMembers"
                          variant="text"
                          label
                          x-small
                          class="mb-0 text-uppercase"
                        >
                          {{ teamMembers }}
                        </VChip>
                      </VChipGroup>
                    </VListItem>
                  </VList>
                </VCardText>
              </VCard>
              <VCard class="mb-4">
                <VCardText>
                  <p class="text-xs">
                    Client Details
                  </p>

                  <VList class="card-list text-medium-emphasis">
                    <VListItem>
                      <template #prepend>
                        <VIcon
                          icon="tabler-scan"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span class="font-weight-medium me-1" />
                        <span>{{ localInterventionData.mission_client_id }}</span>
                      </VListItemTitle>
                    </VListItem>
                    <VListItem>
                      <template #prepend>
                        <VIcon
                          icon="tabler-user"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span class="font-weight-medium me-1" />
                        <span>{{ localInterventionData.client_name }}</span>
                      </VListItemTitle>
                    </VListItem>
                    <VListItem>
                      <template #prepend>
                        <VIcon
                          icon="tabler-map-pin"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span class="font-weight-medium me-1" />
                        <span>{{ localInterventionData.address }} - {{ localInterventionData.postcode }}</span>
                      </VListItemTitle>
                    </VListItem>
                    <VListItem>
                      <template #prepend>
                        <VIcon
                          icon="tabler-flag"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span class="font-weight-medium me-1" />
                        <span>{{ localInterventionData.city }} - {{ localInterventionData.country }}</span>
                      </VListItemTitle>
                    </VListItem>
                  </VList>

                  <p class="text-xs mt-5">
                    CONTACTS
                  </p>

                  <VList class="card-list text-medium-emphasis">
                    <VListItem v-if="localInterventionData.main_phone_number">
                      <template #prepend>
                        <VIcon
                          icon="tabler-phone"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span class="font-weight-medium me-1">Phone:</span>
                        <span>{{ localInterventionData.main_phone_number }}</span>
                      </VListItemTitle>
                    </VListItem>
                    <VListItem v-if="localInterventionData.email">
                      <template #prepend>
                        <VIcon
                          icon="tabler-mail"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span class="font-weight-medium me-1">Email:</span>
                        <span>{{ localInterventionData.email }}</span>
                      </VListItemTitle>
                    </VListItem>
                  </VList>

                  <p class="text-xs mt-5">
                    Park Details
                  </p>

                  <VList class="card-list text-medium-emphasis">
                    <VListItem>
                      <template #prepend>
                        <VIcon
                          icon="tabler-scan"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span class="font-weight-medium me-1" />
                        <span>{{ localInterventionData.park_id }}</span>
                      </VListItemTitle>
                    </VListItem>
                    <VListItem>
                      <template #prepend>
                        <VIcon
                          icon="tabler-flame"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span class="font-weight-medium me-1" />
                        <span>{{ localInterventionData.park_title }}</span>
                      </VListItemTitle>
                    </VListItem>
                    <VListItem>
                      <template #prepend>
                        <VIcon
                          icon="tabler-map-pin"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span class="font-weight-medium me-1" />
                        <span>{{ localInterventionData.park_address }} - {{ localInterventionData.park_postcode }}</span>
                      </VListItemTitle>
                    </VListItem>
                    <VListItem>
                      <template #prepend>
                        <VIcon
                          icon="tabler-flag"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span class="font-weight-medium me-1" />
                        <span> {{ localInterventionData.park_city }} - {{ localInterventionData.park_country }}</span>
                      </VListItemTitle>
                    </VListItem>
                  </VList>
                </VCardText>
              </VCard>
            </VCol>

            <VCol
              cols="12"
              md="8"
            >
              <VRow>
                <VCol cols="12">
                  <ClientReportTasksCard :equipment-headers="equipmentHeaders" />
                </VCol>

                <VCol cols="12">
                  <ExitSlipCard :equipment-headers="equipmentHeaders" />
                </VCol>
                
                <VCol cols="12">
                  <VCard title="Remarks & Feedback">
                    <VCardText>
                      <VForm
                        ref="refVForm"
                        lazy-validation
                        class="mt-1"
                        @submit.prevent="onSubmit"
                      >
                        <VRow>
                          <VCol
                            md="10"
                            cols="9"
                          >
                            <VTextarea
                              v-model="localInterventionData.feedback"
                              label="Feedback"
                              rows="3"
                              variant="outlined"
                            />
                          </VCol>
                          <VCol
                            md="2"
                            cols="3"
                          >
                            <VBtn type="submit">
                              Accept
                              <VIcon
                                end
                                icon="tabler-checkbox"
                              />
                            </VBtn>
                          </VCol>
                        </VRow>
                      </VForm>
                    </VCardText>
                  </VCard>
                </VCol>
              </VRow> 
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
        @click="Previous"
      >
        <VIcon
          icon="tabler-arrow-left"
          start
          class="flip-in-rtl"
        />
        Previous
      </VBtn>

      <VBtn disabled>
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
