<script setup>
import { useInterventionListStore } from '@/views/wave-fire/mission/intervention/useInterventionListStore'

const props = defineProps({
  currentStep: {
    type: Number,
    required: false,
  },
  checkListData: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits([
  'update:currentStep',
  'submit',

])

const route = useRoute()
const interventionListStore = useInterventionListStore()

const missionDocuments = [
  {
    title: 'Mission Documents',
    desc: 'Ensure all necessary documents related to the mission or task at hand are present and up-to-date.',
    value: 'checked',
    icon: {
      icon: 'tabler-checklist',
      size: '28',
    },
  },
]

const teamDocuments = [
  {
    title: 'Team Documents',
    desc: 'Check for the availability and completeness of documents related to the team, including personnel records and assignment details.',
    value: 'checked',
    icon: {
      icon: 'tabler-users',
      size: '28',
    },
  },
]

const ppe = [
  {
    title: 'PPE',
    desc: 'Confirm the availability and condition of required protective gear for safety during the intervention.',
    value: 'checked',
    icon: {
      icon: 'tabler-shield-check',
      size: '28',
    },
  },
]

const toolsAndEquipment = [
  {
    title: 'Tools and Equipment',
    desc: 'Ensure all necessary tools and equipment are available, calibrated, and in working order for the intervention.',
    value: 'checked',
    icon: {
      icon: 'tabler-tools',
      size: '28',
    },
  },
]

const emergencyKit = [
  {
    title: 'Emergency Kit',
    desc: 'Verify the accessibility and readiness of emergency supplies and equipment in case of unforeseen circumstances.',
    value: 'checked',
    icon: {
      icon: 'tabler-first-aid-kit',
      size: '28',
    },
  },
]

const vehicleMaintenance = [
  {
    title: 'Vehicle Maintenance',
    desc: 'Assess the condition and maintenance status of any vehicles or transportation equipment needed for the intervention.',
    value: 'checked',
    icon: {
      icon: 'tabler-truck',
      size: '28',
    },
  },
]

const materialsAndParts = [
  {
    title: 'Materials and Parts',
    desc: 'Check the availability and condition of raw materials and spare parts required for the task.',
    value: 'checked',
    icon: {
      icon: 'tabler-checklist',
      size: '28',
    },
  },
]

const refVForm = ref()
const localCheckListData = ref((props.checkListData))

const updateCheckListData = async () => {
  emit('submit', localCheckListData.value)
}

const onSubmit = () => {
  refVForm.value?.validate().then(({ valid: isValid }) => {
    if (isValid) {
      updateCheckListData() // Emit the updated data
      emit('update:currentStep', props.currentStep ? props.currentStep + 1 : 1)
    }
  })
}

const Previous = () => {
  emit('update:currentStep', props.currentStep ? props.currentStep - 1 : 1)
}

watch(() => props.currentStep, updateCheckListData)
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
        <!-- 👉 Intervention CheckList -->
        <VCard title="Intervention CheckList">
          <VCardText>
            <VRow class="match-height">
              <VCol
                md="4"
                cols="12"
              >
                <CustomCheckboxesWithIcon
                  v-model:selected-checkbox="localCheckListData.mission_documents"
                  :checkbox-content="missionDocuments"
                  :readonly="localCheckListData.mission_documents.includes('checked')"
                />
              </VCol>
              <VCol
                md="4"
                cols="12"
              >
                <CustomCheckboxesWithIcon
                  v-model:selected-checkbox="localCheckListData.team_documents"
                  :checkbox-content="teamDocuments"
                  :readonly="localCheckListData.team_documents.includes('checked')"
                />
              </VCol>
              <VCol
                md="4"
                cols="12"
              >
                <CustomCheckboxesWithIcon
                  v-model:selected-checkbox="localCheckListData.ppe"
                  :checkbox-content="ppe"
                  :readonly="localCheckListData.ppe.includes('checked')"
                />
              </VCol>
              <VCol
                md="4"
                cols="12"
              >
                <CustomCheckboxesWithIcon
                  v-model:selected-checkbox="localCheckListData.emergency_kit"
                  :checkbox-content="emergencyKit"
                  
                  :readonly="localCheckListData.emergency_kit.includes('checked')"
                />
              </VCol>
              <VCol
                md="4"
                cols="12"
              >
                <CustomCheckboxesWithIcon
                  v-model:selected-checkbox="localCheckListData.vehicle_maintenance"
                  :checkbox-content="vehicleMaintenance"
                  :readonly="localCheckListData.vehicle_maintenance.includes('checked')"
                />
              </VCol>
              <VCol
                md="4"
                cols="12"
              >
                <CustomCheckboxesWithIcon
                  v-model:selected-checkbox="localCheckListData.materials_and_parts"
                  :checkbox-content="materialsAndParts"
                  :readonly="localCheckListData.materials_and_parts.includes('checked')"
                />
              </VCol>
              <VCol
                md="4"
                cols="12"
              >
                <CustomCheckboxesWithIcon
                  v-model:selected-checkbox="localCheckListData.tools_and_equipment"
                  :checkbox-content="toolsAndEquipment"
                  :readonly="localCheckListData.tools_and_equipment.includes('checked')"
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
