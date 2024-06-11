<script setup>
import { avatarText } from '@core/utils/formatters'
import { useMetaStore } from '@/stores/useMetaStore'

const metaStore = useMetaStore()

const totalContracts = ref()
const pendingContracts = ref()
const inProgressContracts = ref()
const completedContracts = ref()

// 👉 Fetch Contracts
// onMounted(() => {
//   metaStore.fetchContracts()
//     .then(response => {
//       totalContracts.value = response.data.data.total_contracts
//       totalEquipment.value = response.data.data.active_contracts
//       totalFireExtinguisher.value = response.data.data.inactive_contracts
//       activeEquipment.value = response.data.data.pending_contracts
//     }).catch(error => {
//       console.error(error)
//     })
// })

// 👉 Fetch Equipment
onMounted(() => {
  // 👉 Fetch Contracts
  metaStore.fetchContracts()
    .then(response => {
      totalContracts.value = response.data.data.total_contracts
      pendingContracts.value = response.data.data.total_pending_contracts
      inProgressContracts.value = response.data.data.total_inProgress_contracts
      completedContracts.value = response.data.data.total_completed_contracts
    }).catch(error => {
      console.error(error)
    })
})


// 👉 Contract List Meta
const contractListMeta = [
  {
    icon: 'tabler-progress-alert',
    color: 'info',
    title: 'Total Contracts',
    count: totalContracts,
  },
  {
    icon: 'tabler-progress-help',
    color: 'warning',
    title: 'Pending Contracts',
    count: pendingContracts,
  },
  {
    icon: 'tabler-progress',
    color: 'success',
    title: 'In Progress',
    count: inProgressContracts,
  },
  {
    icon: 'tabler-progress-check',
    color: 'error',
    title: 'Completed',
    count: completedContracts,
  },
]
</script>

<template>
  <section>
    <VRow>
      <VCol
        v-for="meta in contractListMeta"
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
