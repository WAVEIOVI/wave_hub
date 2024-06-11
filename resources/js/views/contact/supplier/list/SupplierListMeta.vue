<script setup>
import { avatarText } from '@core/utils/formatters'
import { useMetaStore } from '@/stores/useMetaStore'

const metaStore = useMetaStore()

const totalSuppliers = ref()
const activeSuppliers = ref()
const inactiveSuppliers = ref()
const pendingSuppliers = ref()

// 👉 Fetch Suppliers
onMounted(() => {
  metaStore.fetchSuppliers()
    .then(response => {
      totalSuppliers.value = response.data.data.total_suppliers
      activeSuppliers.value = response.data.data.active_suppliers
      inactiveSuppliers.value = response.data.data.inactive_suppliers
      pendingSuppliers.value = response.data.data.pending_suppliers
    }).catch(error => {
      console.error(error)
    })
})

// 👉 Supplier List Meta
const supplierListMeta = [
  {
    icon: 'tabler-user',
    color: 'primary',
    title: 'Total Suppliers',
    count: totalSuppliers,
  },
  {
    icon: 'tabler-user-plus',
    color: 'error',
    title: 'Inactive Suppliers',
    count: inactiveSuppliers,
  },
  {
    icon: 'tabler-user-check',
    color: 'success',
    title: 'Active Suppliers',
    count: activeSuppliers,
  },
  {
    icon: 'tabler-user-exclamation',
    color: 'warning',
    title: 'Pending Suppliers',
    count: pendingSuppliers,
  },
]
</script>

<template>
  <section>
    <VRow>
      <VCol
        v-for="meta in supplierListMeta"
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
