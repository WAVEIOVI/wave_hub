<script setup>
import { avatarText } from '@core/utils/formatters'
import { useMetaStore } from '@/stores/useMetaStore'

const metaStore = useMetaStore()

const totalParks = ref()
const totalEquipment = ref()
const totalFireExtinguisher = ref()
const activeEquipment = ref()

// 👉 Fetch Parks
// onMounted(() => {
//   metaStore.fetchParks()
//     .then(response => {
//       totalParks.value = response.data.data.total_parks
//       totalEquipment.value = response.data.data.active_parks
//       totalFireExtinguisher.value = response.data.data.inactive_parks
//       activeEquipment.value = response.data.data.pending_parks
//     }).catch(error => {
//       console.error(error)
//     })
// })

// 👉 Fetch Equipment
onMounted(() => {
  metaStore.fetchEquipment()
    .then(response => {
      totalEquipment.value = response.data.data.total.total_equipment
      totalFireExtinguisher.value = response.data.data.total.total_fire_extinguisher
      activeEquipment.value = response.data.data.total.total_active_extinguisher
    }).catch(error => {
      console.error(error)
    })

  // 👉 Fetch Parks
  metaStore.fetchParks()
    .then(response => {
      totalParks.value = response.data.meta.total
    }).catch(error => {
      console.error(error)
    })
})


// 👉 Park List Meta
const parkListMeta = [
  {
    icon: 'tabler-map-pin',
    color: 'primary',
    title: 'Total Parks',
    count: totalParks,
  },
  {
    icon: 'tabler-tool',
    color: 'error',
    title: 'Total Equipment',
    count: totalEquipment,
  },
  {
    icon: 'tabler-fire-extinguisher',
    color: 'error',
    title: 'Fire Extinguisher',
    count: totalFireExtinguisher,
  },
  {
    icon: 'tabler-checkbox',
    color: 'success',
    title: 'In Service',
    count: activeEquipment,
  },
]
</script>

<template>
  <section>
    <VRow>
      <VCol
        v-for="meta in parkListMeta"
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
