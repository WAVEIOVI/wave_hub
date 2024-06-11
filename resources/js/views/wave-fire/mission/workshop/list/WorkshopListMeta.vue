<script setup>
import { avatarText } from '@core/utils/formatters'
import { useMetaStore } from '@/stores/useMetaStore'

const metaStore = useMetaStore()

const totalWorkshops = ref()
const pendingWorkshops = ref()
const inProgressWorkshops = ref()
const completedWorkshops = ref()

// 👉 Fetch Workshops
// onMounted(() => {
//   metaStore.fetchWorkshops()
//     .then(response => {
//       totalWorkshops.value = response.data.data.total_workshops
//       totalEquipment.value = response.data.data.active_workshops
//       totalFireExtinguisher.value = response.data.data.inactive_workshops
//       activeEquipment.value = response.data.data.pending_workshops
//     }).catch(error => {
//       console.error(error)
//     })
// })


onMounted(() => {
  // 👉 Fetch Workshops
  metaStore.fetchWorkshops()
    .then(response => {
      totalWorkshops.value = response.data.data.total_workshops
      pendingWorkshops.value = response.data.data.total_pending_workshops
      inProgressWorkshops.value = response.data.data.total_inProgress_workshops
      completedWorkshops.value = response.data.data.total_completed_workshops
    }).catch(error => {
      console.error(error)
    })
})


// 👉 Workshop List Meta
const workshopListMeta = [
  {
    icon: 'tabler-progress-alert',
    color: 'info',
    title: 'Total Workshops',
    count: totalWorkshops,
  },
  {
    icon: 'tabler-progress-help',
    color: 'warning',
    title: 'Pending',
    count: pendingWorkshops,
  },
  {
    icon: 'tabler-progress',
    color: 'success',
    title: 'In Progress',
    count: inProgressWorkshops,
  },
  {
    icon: 'tabler-progress-check',
    color: 'error',
    title: 'Completed',
    count: completedWorkshops,
  },
]
</script>

<template>
  <section>
    <VRow>
      <VCol
        v-for="meta in workshopListMeta"
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
