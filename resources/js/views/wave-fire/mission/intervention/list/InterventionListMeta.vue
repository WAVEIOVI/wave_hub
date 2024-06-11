<script setup>
import { avatarText } from '@core/utils/formatters'
import { useMetaStore } from '@/stores/useMetaStore'

const metaStore = useMetaStore()

const totalInterventions = ref()
const pendingInterventions = ref()
const inProgressInterventions = ref()
const completedInterventions = ref()

// 👉 Fetch Interventions
// onMounted(() => {
//   metaStore.fetchInterventions()
//     .then(response => {
//       totalInterventions.value = response.data.data.total_interventions
//       totalEquipment.value = response.data.data.active_interventions
//       totalFireExtinguisher.value = response.data.data.inactive_interventions
//       activeEquipment.value = response.data.data.pending_interventions
//     }).catch(error => {
//       console.error(error)
//     })
// })


onMounted(() => {
  // 👉 Fetch Interventions
  metaStore.fetchInterventions()
    .then(response => {
      totalInterventions.value = response.data.data.total_interventions
      pendingInterventions.value = response.data.data.total_pending_interventions
      inProgressInterventions.value = response.data.data.total_inProgress_interventions
      completedInterventions.value = response.data.data.total_completed_interventions
    }).catch(error => {
      console.error(error)
    })
})


// 👉 Intervention List Meta
const interventionListMeta = [
  {
    icon: 'tabler-progress-alert',
    color: 'info',
    title: 'Total Interventions',
    count: totalInterventions,
  },
  {
    icon: 'tabler-progress-help',
    color: 'warning',
    title: 'Pending',
    count: pendingInterventions,
  },
  {
    icon: 'tabler-progress',
    color: 'success',
    title: 'In Progress',
    count: inProgressInterventions,
  },
  {
    icon: 'tabler-progress-check',
    color: 'error',
    title: 'Completed',
    count: completedInterventions,
  },
]
</script>

<template>
  <section>
    <VRow>
      <VCol
        v-for="meta in interventionListMeta"
        :key="meta.title"
        cols="12"
        sm="6"
        lg="3"
      >
        <VCard>
          <VCardText class="d-flex justify-space-between">
            <div>
              <h5 class="text-h4">
                {{ meta.count }}
              </h5>

              <div class="d-flex align-center gap-2 my-1">
                <h5 class="text-h4">
                  {{ meta.title }}
                </h5>
              </div>
            </div>

            <VAvatar
              rounded
              variant="tonal"
              :color="meta.color"
              :icon="meta.icon"
            />
          </VCardText>
        </VCard>
      </VCol>
    </VRow>
  </section>
</template>
