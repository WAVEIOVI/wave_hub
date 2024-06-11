<script setup>
import { avatarText } from '@core/utils/formatters'
import { useMetaStore } from '@/stores/useMetaStore'

const metaStore = useMetaStore()

const totalMissions = ref()
const pendingMissions = ref()
const inProgressMissions = ref()
const completedMissions = ref()

// 👉 Fetch Missions
// onMounted(() => {
//   metaStore.fetchMissions()
//     .then(response => {
//       totalMissions.value = response.data.data.total_missions
//       totalEquipment.value = response.data.data.active_missions
//       totalFireExtinguisher.value = response.data.data.inactive_missions
//       activeEquipment.value = response.data.data.pending_missions
//     }).catch(error => {
//       console.error(error)
//     })
// })

// 👉 Fetch Equipment
onMounted(() => {
  // 👉 Fetch Missions
  metaStore.fetchMissions()
    .then(response => {
      totalMissions.value = response.data.data.total_missions
      pendingMissions.value = response.data.data.total_pending_missions
      inProgressMissions.value = response.data.data.total_inProgress_missions
      completedMissions.value = response.data.data.total_completed_missions
    }).catch(error => {
      console.error(error)
    })
})


// 👉 Mission List Meta
const missionListMeta = [
  {
    icon: 'tabler-progress-alert',
    color: 'info',
    title: 'Total Missions',
    count: totalMissions,
  },
  {
    icon: 'tabler-progress-help',
    color: 'warning',
    title: 'Pending Missions',
    count: pendingMissions,
  },
  {
    icon: 'tabler-progress',
    color: 'success',
    title: 'In Progress',
    count: inProgressMissions,
  },
  {
    icon: 'tabler-progress-check',
    color: 'error',
    title: 'Completed',
    count: completedMissions,
  },
]
</script>

<template>
  <section>
    <VRow>
      <VCol
        v-for="meta in missionListMeta"
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
