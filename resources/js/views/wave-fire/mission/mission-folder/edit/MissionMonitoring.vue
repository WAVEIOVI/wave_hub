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
  missionData: {
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

const localMissionData = ref((props.missionData))

const Previous = () => {
  emit('update:currentStep', props.currentStep ? props.currentStep - 1 : 1)
}

const updateMissionData = async () => {
  emit('submit', localMissionData.value)
}

// Function to parse additional maintenance data
const parsedTeamMembers = teamMembers => {
  try {
    return JSON.parse(teamMembers)
  } catch (error) {
    return []
  }
}

watch(() => props.currentStep, updateMissionData)
</script>

<template>
  <VCard v-if="localMissionData.mission_status === 'pending'">
    <VRow>
      <VCol cols="12">
        <div class="text-center mb-12">
          <!-- 👉 Title and subtitle -->
          <h4 class="text-h4 font-weight-medium mb-3">
            The Mission Is Pending! 🚧
          </h4>
          <p>This Mission Is Waiting To Be Worked On By Technicians.</p>
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
      v-if="localMissionData.mission_status !== 'pending'"
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
                          <span>{{ localMissionData.mission_id }}</span>
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
                          <span>{{ localMissionData.mission_date }}</span>
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
                          <span class="text-uppercase">{{ localMissionData.mission_frequency }}</span>
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
                        <VListItemTitle v-if="localMissionData.mission_status === 'in_progress'">
                          <span class="font-weight-medium me-1">Mission Status:</span>
                          <VProgressLinear
                            indeterminate
                            color="warning"
                          />
                        </VListItemTitle>
                        <VListItemTitle v-if="localMissionData.mission_status === 'completed'">
                          <span class="font-weight-medium me-1">Mission Completed</span>
                        </VListItemTitle>
                        <VListItemTitle v-if="localMissionData.mission_status === 'closure'">
                          <span class="font-weight-medium me-1">Mission Closured</span>
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
                            {{ localMissionData.team_leader }}
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
                            v-for="teamMembers in parsedTeamMembers(localMissionData.team_members)"
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
                    v-if="localMissionData.mission_type === 'intervention'"
                    cols="12"
                  >
                    <InterventionTableTasksCard :mission-data="missionData" />
                  </VCol>
                  <VCol
                    v-if="localMissionData.mission_type === 'workshop'"
                    cols="12"
                  >
                    <WorkshopTableTasksCard :mission-data="missionData" />
                  </VCol>
                </VRow>
              </VCol>
            </VRow> 
          </VCol>
          <VCol
            v-if="localMissionData.mission_type === 'intervention'"
            cols="12"
          >
            <InterventionMetaTasksCard :mission-data="missionData" />
          </VCol>
          <VCol
            v-if="localMissionData.mission_type === 'workshop'"
            cols="12"
          >
            <WorkshopMetaTasksCard :mission-data="missionData" />
          </VCol>
          <VCol
            v-if="localMissionData.mission_type === 'intervention'"
            cols="12"
          >
            <InterventionReportTasksCard
              :mission-data="missionData"
              :equipment-headers="equipmentHeaders"
            />
          </VCol>
          <VCol
            v-if="localMissionData.mission_type === 'workshop'"
            cols="12"
          >
            <WorkshopReportTasksCard
              :mission-data="missionData"
              :equipment-headers="equipmentHeaders"
            />
          </VCol>
        </VRow>
        <VRow>                              
          <VCol cols="12">
            <VTextarea
              v-model="localMissionData.feedback"
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
