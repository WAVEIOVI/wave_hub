<script setup>
import ClientReportTasksCard from './ClientReportTasksCard.vue'


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

const localWorkshopData = ref((props.workshopData))
const refVForm = ref()

const Previous = () => {
  emit('update:currentStep', props.currentStep ? props.currentStep - 1 : 1)
}

const updateWorkshopData = async () => {
  emit('submit', localWorkshopData.value)
}

const onSubmit = () => {
  updateWorkshopData() // Emit the updated data
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
                        <span>{{ localWorkshopData.workshop_id }}</span>
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
                        <span>{{ localWorkshopData.workshop_date }}</span>
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
                        <span class="font-weight-medium me-1">Workshop Leader:</span>
                        <span>{{ localWorkshopData.team_leader }}</span>
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
                          v-for="teamMembers in parsedTeamMembers(localWorkshopData.team_members)"
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
                        <span>{{ localWorkshopData.mission_client_id }}</span>
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
                        <span>{{ localWorkshopData.client_name }}</span>
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
                        <span>{{ localWorkshopData.address }} - {{ localWorkshopData.postcode }}</span>
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
                        <span>{{ localWorkshopData.city }} - {{ localWorkshopData.country }}</span>
                      </VListItemTitle>
                    </VListItem>
                  </VList>

                  <p class="text-xs mt-5">
                    CONTACTS
                  </p>

                  <VList class="card-list text-medium-emphasis">
                    <VListItem v-if="localWorkshopData.main_phone_number">
                      <template #prepend>
                        <VIcon
                          icon="tabler-phone"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span class="font-weight-medium me-1">Phone:</span>
                        <span>{{ localWorkshopData.main_phone_number }}</span>
                      </VListItemTitle>
                    </VListItem>
                    <VListItem v-if="localWorkshopData.email">
                      <template #prepend>
                        <VIcon
                          icon="tabler-mail"
                          size="20"
                          class="me-2"
                        />
                      </template>
                      <VListItemTitle>
                        <span class="font-weight-medium me-1">Email:</span>
                        <span>{{ localWorkshopData.email }}</span>
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
                              v-model="localWorkshopData.feedback"
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
