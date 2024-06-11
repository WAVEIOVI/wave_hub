<script setup>
import { useGenerateImageVariant } from '@core/composable/useGenerateImageVariant'
import miscMaskDark from '@images/pages/misc-mask-dark.png'
import miscMaskLight from '@images/pages/misc-mask-light.png'
import miscUnderMaintenance from '@images/pages/misc-under-maintenance.png'
import InterventionReportTasksCard from './InterventionReportTasksCard.vue'
import InterventionMetaTasksCard from './InterventionMetaTasksCard.vue'
import InterventionTableTasksCard from './InterventionTableTasksCard.vue' 
import WorkshopReportTasksCard from './WorkshopReportTasksCard.vue'
import WorkshopMetaTasksCard from './WorkshopMetaTasksCard.vue'
import WorkshopTableTasksCard from './WorkshopTableTasksCard.vue'


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


const authThemeMask = useGenerateImageVariant(miscMaskLight, miscMaskDark)

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

const localContractData = ref((props.contractData))

const Previous = () => {
  emit('update:currentStep', props.currentStep ? props.currentStep - 1 : 1)
}

const updateContractData = async () => {
  emit('submit', localContractData.value)
}

// Function to parse additional maintenance data
const parsedTeamMembers = teamMembers => {
  try {
    return JSON.parse(teamMembers)
  } catch (error) {
    return []
  }
}

watch(() => props.currentStep, updateContractData)
</script>

<template>
  <VCard v-if="localContractData.contract_status === 'pending'">
    <VRow>
      <VCol cols="12">
        <div class="text-center mb-12">
          <!-- 👉 Title and subtitle -->
          <h4 class="text-h4 font-weight-medium mb-3">
            The Contract Is Pending! 🚧
          </h4>
          <p>This Contract Is Waiting To Be Worked On By Technicians.</p>
        </div>

        <!-- 👉 Image -->
        <div class="misc-avatar w-100 text-center">
          <VImg
            :src="miscUnderMaintenance"
            class="mx-auto"
            :max-width="450"
          />
        </div>

        <VImg
          :src="authThemeMask"
          class="misc-footer-img d-none d-md-block"
        />
      </VCol>
    </VRow>
  </VCard>
  <VRow>
    <!-- 👉 Monitoring -->
    <VCard 
      v-if="localContractData.contract_status !== 'pending'"
      title="Monitoring"
    >
      <VCardText class="pt-2">
        <VRow>
          <VCol cols="12">
            <VCard class="mb-4">
              <VCardText>
                <VRow>
                  <VCol cols="6">
                    <p class="text-xs mt-5">
                      Contract
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
                          <span>{{ localContractData.contract_id }}</span>
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
                          <span>{{ localContractData.contract_date }}</span>
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
                          <span class="text-uppercase">{{ localContractData.contract_frequency }}</span>
                        </VListItemTitle>
                      </VListItem>
                      <VListItem>
                        <template #prepend>
                          <VIcon
                            icon="tabler-report-analytics"
                            size="20"
                            class="me-2"
                          />
                        </template>
                        <VListItemTitle v-if="localContractData.contract_status === 'in_progress'">
                          <span class="font-weight-medium me-1">Contract Status:</span>
                          <VProgressLinear
                            indeterminate
                            color="warning"
                          />
                        </VListItemTitle>
                        <VListItemTitle v-if="localContractData.contract_status === 'completed'">
                          <span class="font-weight-medium me-1">Contract Completed</span>
                        </VListItemTitle>
                        <VListItemTitle v-if="localContractData.contract_status === 'closure'">
                          <span class="font-weight-medium me-1">Contract Closured</span>
                        </VListItemTitle>
                      </VListItem>
                    </VList>
                  </VCol>
                  <VCol cols="6">
                    <p class="text-xs mt-5">
                      TEAMS
                    </p>
                    <VList class="card-list text-medium-emphasis">
                      <VListItem>
                        <VListItemTitle>
                          <VIcon
                            icon="tabler-user-star"
                            size="20"
                            color="success"
                            class="me-2"
                          />
                          <span class="font-weight-medium me-1">Team Leader:
                          </span>
                        </VListItemTitle>
                        <VChipGroup>
                          <VChip
                            label
                            x-small
                            class="mb-0 text-uppercase"
                          >
                            {{ localContractData.team_leader }}
                          </VChip>
                        </VChipGroup>
                      </VListItem>
                      <VListItem>
                        <VListItemTitle>
                          <VIcon
                            icon="tabler-users"
                            size="20"
                            color="success"
                            class="me-2"
                          />
                          <span class="font-weight-medium me-1">Team Members:
                          </span>
                        </VListItemTitle>
                        <VChipGroup>
                          <VChip
                            v-for="teamMembers in parsedTeamMembers(localContractData.team_members)"
                            :key="teamMembers"
                            label
                            x-small
                            class="mb-0 text-uppercase"
                          >
                            {{ teamMembers }}
                          </VChip>
                        </VChipGroup>
                      </VListItem>
                    </VList>
                  </VCol>
                </VRow>
              </VCardText>
            </VCard>
          </VCol>

          <VCol cols="12">
            <VRow>             
              <VCol cols="12">
                <VRow>
                  <VCol
                    v-if="localContractData.contract_type === 'intervention'"
                    cols="12"
                  >
                    <InterventionTableTasksCard :contract-data="contractData" />
                  </VCol>
                  <VCol
                    v-if="localContractData.contract_type === 'workshop'"
                    cols="12"
                  >
                    <WorkshopTableTasksCard :contract-data="contractData" />
                  </VCol>
                </VRow>
              </VCol>
            </VRow> 
          </VCol>
          <VCol
            v-if="localContractData.contract_type === 'intervention'"
            cols="12"
          >
            <InterventionMetaTasksCard :contract-data="contractData" />
          </VCol>
          <VCol
            v-if="localContractData.contract_type === 'workshop'"
            cols="12"
          >
            <WorkshopMetaTasksCard :contract-data="contractData" />
          </VCol>
          <VCol
            v-if="localContractData.contract_type === 'intervention'"
            cols="12"
          >
            <InterventionReportTasksCard
              :contract-data="contractData"
              :equipment-headers="equipmentHeaders"
            />
          </VCol>
          <VCol
            v-if="localContractData.contract_type === 'workshop'"
            cols="12"
          >
            <WorkshopReportTasksCard
              :contract-data="contractData"
              :equipment-headers="equipmentHeaders"
            />
          </VCol>
        </VRow>
        <VRow>                              
          <VCol cols="12">
            <VTextarea
              v-model="localContractData.feedback"
              label="Feedback"
              rows="3"
              variant="outlined"
              disabled
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
  </VRow>
</template>

<style lang="scss">
@use "@core-scss/template/pages/misc.scss";
</style>
