<script setup>
import { avatarText } from '@core/utils/formatters'
import { useMetaStore } from '@/stores/useMetaStore'

const metaStore = useMetaStore()

const totalClients = ref()
const activeClients = ref()
const inactiveClients = ref()
const pendingClients = ref()

// 👉 Fetch Clients
onMounted(() => {
  metaStore.fetchClients()
    .then(response => {
      totalClients.value = response.data.data.total_clients
      activeClients.value = response.data.data.active_clients
      inactiveClients.value = response.data.data.inactive_clients
      pendingClients.value = response.data.data.pending_clients
    }).catch(error => {
      console.error(error)
    })
})

// 👉 Client List Meta
const clientListMeta = [
  {
    icon: 'tabler-user',
    color: 'primary',
    title: 'Total Clients',
    count: totalClients,
  },
  {
    icon: 'tabler-user-plus',
    color: 'error',
    title: 'Inactive Clients',
    count: inactiveClients,
  },
  {
    icon: 'tabler-user-check',
    color: 'success',
    title: 'Active Clients',
    count: activeClients,
  },
  {
    icon: 'tabler-user-exclamation',
    color: 'warning',
    title: 'Pending Clients',
    count: pendingClients,
  },
]
</script>

<template>
  <section>
    <VRow>
      <VCol
        v-for="meta in clientListMeta"
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
