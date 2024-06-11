<script setup>
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import { avatarText } from '@core/utils/formatters'
import { useSupplierListStore } from '@/views/contact/supplier/useSupplierListStore'
import AddNewSupplierDialog from '@/views/contact/supplier/list/AddNewSupplierDialog.vue'


const props = defineProps({
  headers: {
    type: Array,
    required: true,
  },
  types: {
    type: Array,
    required: true,
  },
  activities: {
    type: Array,
    required: true,
  },
  status: {
    type: Array,
    required: true,
  },
})

//SECTION UI
const resolveSupplierTypeVariant = type => {
  const typeLowerCase = type.toLowerCase()
  if (typeLowerCase === 'individual supplier')
    return {
      color: 'warning',
      icon: 'tabler-user-question',
    }
  if (typeLowerCase === 'small business supplier')
    return {
      color: 'success',
      icon: 'tabler-users-group',
    }
  if (typeLowerCase === 'enterprise supplier')
    return {
      color: 'primary',
      icon: 'tabler-building-community',
    }
  if (typeLowerCase === 'government supplier')
    return {
      color: 'info',
      icon: 'tabler-briefcase',
    }
  if (typeLowerCase === 'non-profit supplier')
    return {
      color: 'secondary',
      icon: 'tabler-user-heart',
    }
    
  if (typeLowerCase === 'key account')
    return {
      color: 'primary',
      icon: 'tabler-user-star',
    }
  
  return {
    color: 'secondary',
    icon: 'tabler-user',
  }
}

const resolveSupplierStatusVariant = stat => {
  const statLowerCase = stat.toLowerCase()
  if (statLowerCase === 'pending')
    return 'warning'
  if (statLowerCase === 'active')
    return 'success'
  if (statLowerCase === 'inactive')
    return 'secondary'
  
  return 'primary'
}

//!SECTION UI
//SECTION Declaration
const supplierId = ref()
const router = useRouter()
const supplierListStore = useSupplierListStore()
const searchQuery = ref('')
const selectedType = ref()
const selectedActivity = ref()
const selectedStatus = ref()
const totalPage = ref(1)
const totalSuppliers = ref(0)
const suppliers = ref([])

const options = ref({
  page: 1,
  itemsPerPage: 10,
  sortBy: [],
  groupBy: [],
  search: undefined,
})

// 👉 Add New Supplier Dialog
const isAddNewSupplierDialogVisible = ref(false)

//!SECTION Declaration

//SECTION Functions
const paginationMeta = computed(() => {
  return (options, total) => {
    const start = (options.page - 1) * options.itemsPerPage + 1
    const end = Math.min(options.page * options.itemsPerPage, total)
    
    return `Showing ${start} to ${end} of ${total} entries`
  }
})

// 👉 Fetching suppliers
const fetchSuppliers = () => {
  supplierListStore.fetchSuppliers({
    search: searchQuery.value,
    status: selectedStatus.value,
    activity: selectedActivity.value,
    type: selectedType.value,
    options: options.value,
  }).then(response => {
    suppliers.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalSuppliers.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
  }).catch(error => {
    console.error(error)
  })
}

// 👉 Add Supplier
const addSupplier = async supplierData => {
  try {
    const response = await supplierListStore.addSupplier(supplierData)

    if (response.status === 201) {
      supplierId.value = response.data.data.id
      router.push({ name: 'contact-edit-supplier-id', params: { id: supplierId.value } })
    } else {
      throw new Error(`Failed to create supplier: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Delete Supplier
const deleteSupplier = id => {
  supplierListStore.deleteSupplier(id)
    .then(response => {
      console.log(response.data)
      fetchSuppliers()
    })
    .catch(error => {
      console.error('Error deleting supplier:', error)
    })
}

watchEffect(fetchSuppliers)

//!SECTION Functions
</script>

<template>
  <section>
    <AddNewSupplierDialog
      v-model:isDialogVisible="isAddNewSupplierDialogVisible"
      :types="types"
      :activities="activities" 
      :status="status" 
      @submit="addSupplier"
    />
    <VRow>
      <VCol cols="12">
        <VCard title="Suppliers">
          <!-- SECTION - Filters -->
          <VCardText>
            <VRow>
              <!-- 👉 Select Type -->
              <VCol
                cols="12"
                sm="4"
              >
                <AppSelect
                  v-model="selectedType"
                  label="Select Type"
                  :items="types"
                  clearable
                  clear-icon="tabler-x"
                />
              </VCol>
              <!-- 👉 Select Activity -->
              <VCol
                cols="12"
                sm="4"
              >
                <AppSelect
                  v-model="selectedActivity"
                  label="Select Activity"
                  :items="activities"
                  clearable
                  clear-icon="tabler-x"
                />
              </VCol>
              <!-- 👉 Select Status -->
              <VCol
                cols="12"
                sm="4"
              >
                <AppSelect
                  v-model="selectedStatus"
                  label="Select Status"
                  :items="status"
                  clearable
                  clear-icon="tabler-x"
                />
              </VCol>
            </VRow>
            
          <!-- !SECTION - Filters -->
          </VCardText>

          <VDivider />
          <!-- SECTION - Table Tools -->
          <VCardText class="d-flex flex-wrap py-4 gap-4">
            <div class="me-3 d-flex gap-3">
              <AppSelect
                :model-value="options.itemsPerPage"
                :items="[
                  { value: 10, title: '10' },
                  { value: 25, title: '25' },
                  { value: 50, title: '50' },
                  { value: 100, title: '100' },
                ]"
                style="width: 6.25rem;"
                @update:model-value="options.itemsPerPage = parseInt($event, 10)"
              />
            </div>
            <VSpacer />

            <div class="app-user-search-filter d-flex align-center flex-wrap gap-4">
              <!-- 👉 Search  -->
              <div style="inline-size: 10rem;">
                <AppTextField
                  v-model="searchQuery"
                  placeholder="Search"
                  density="compact"
                />
              </div>

              <!-- 👉 Export button -->
              <VBtn
                variant="tonal"
                color="secondary"
                prepend-icon="tabler-screen-share"
              >
                Export
              </VBtn>

              <!-- 👉 Add user button -->
              <VBtn
                prepend-icon="tabler-plus"
                @click="isAddNewSupplierDialogVisible = !isAddNewSupplierDialogVisible"
              >
                Add New Supplier
              </VBtn>
            </div>
          </VCardText>
          <!-- !SECTION - Table Tools -->

          <VDivider />
          <!-- SECTION dataTable -->
          <VDataTableServer
            v-model:items-per-page="options.itemsPerPage"
            v-model:page="options.page"
            :items="suppliers"
            :items-length="totalSuppliers"
            :headers="headers"
            class="text-no-wrap"
            @update:options="options = $event"
          >
            <!-- 👉 Supplier Name -->
            <template #[`item.supplier_name`]="{ item }">
              <div class="d-flex align-center">
                <VAvatar
                  size="34"
                  :variant="!item.raw.avatar ? 'tonal' : undefined"
                  :color="!item.raw.avatar ? resolveSupplierTypeVariant(item.raw.supplier_type).color : undefined"
                  class="me-3"
                >
                  <span>{{ avatarText(item.raw.supplier_name) }}</span>
                </VAvatar>

                <div class="d-flex flex-column">
                  <h6 class="text-base">
                    <RouterLink
                      :to="{ name: 'contact-edit-supplier-id', params: { id: item.raw.id } }"
                      class="font-weight-medium user-list-name"
                    >
                      {{ item.raw.supplier_name }}
                    </RouterLink>
                  </h6>

                  <span class="text-sm text-medium-emphasis">#{{ item.raw.supplier_id }}</span>
                </div>
              </div>
            </template>

            <!-- 👉 Type -->
            <template #[`item.supplier_type`]="{ item }">
              <div class="d-flex align-center gap-4">
                <VAvatar
                  :size="30"
                  :color="resolveSupplierTypeVariant(item.raw.supplier_type).color"
                  variant="tonal"
                >
                  <VIcon
                    :size="20"
                    :icon="resolveSupplierTypeVariant(item.raw.supplier_type).icon"
                  />
                </VAvatar>
                <span class="text-capitalize">{{ item.raw.supplier_type }}</span>
              </div>
            </template>

            <!-- 👉 Supplier Activity -->
            <template #[`item.supplier_activity`]="{ item }">
              <span class="text-capitalize font-weight-medium">{{ item.raw.supplier_activity }}</span>
            </template>

            <!-- 👉 Status -->
            <template #[`item.supplier_status`]="{ item }">
              <VChip
                :color="resolveSupplierStatusVariant(item.raw.supplier_status)"
                size="small"
                label
                class="text-capitalize"
              >
                {{ item.raw.supplier_status }}
              </VChip>
            </template>
            <!-- 👉 Actions -->
            <template #[`item.actions`]="{ item }">
              <IconBtn :to="{ name: 'contact-edit-supplier-id', params: { id: item.raw.id } }">
                <VIcon icon="tabler-edit" />
              </IconBtn>

              <IconBtn @click="deleteSupplier(item.raw.id)">
                <VIcon icon="tabler-trash" />
              </IconBtn>

              <VBtn
                icon
                variant="text"
                size="small"
                color="medium-emphasis"
              >
                <VIcon
                  size="24"
                  icon="tabler-dots-vertical"
                />

                <VMenu activator="parent">
                  <VList>
                    <VListItem :to="{ name: 'contact-edit-supplier-id', params: { id: item.raw.id } }">
                      <template #prepend>
                        <VIcon icon="tabler-eye" />
                      </template>

                      <VListItemTitle>View</VListItemTitle>
                    </VListItem>

                    <VListItem link>
                      <template #prepend>
                        <VIcon
                          to="{ name: 'contact-edit-supplier-id', params: { id: item.raw.id } }"
                          icon="tabler-pencil"
                        />
                      </template>
                      <VListItemTitle>Edit</VListItemTitle>
                    </VListItem>

                    <VListItem @click="deleteSupplier(item.raw.id)">
                      <template #prepend>
                        <VIcon icon="tabler-trash" />
                      </template>
                      <VListItemTitle>Delete</VListItemTitle>
                    </VListItem>
                  </VList>
                </VMenu>
              </VBtn>
            </template>

            <!-- 👉 pagination -->
            <template #bottom>
              <VDivider />
              <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                <p class="text-sm text-disabled mb-0">
                  {{ paginationMeta(options, totalSuppliers) }}
                </p>

                <VPagination
                  v-model="options.page"
                  :length="totalPage"
                  :total-visible="$vuetify.display.xs ? 1 : totalPage"
                >
                  <template #prev="slotProps">
                    <VBtn
                      variant="tonal"
                      color="default"
                      v-bind="slotProps"
                      :icon="false"
                    >
                      Previous
                    </VBtn>
                  </template>

                  <template #next="slotProps">
                    <VBtn
                      variant="tonal"
                      color="default"
                      v-bind="slotProps"
                      :icon="false"
                    >
                      Next
                    </VBtn>
                  </template>
                </VPagination>
              </div>
            </template>
          </VDataTableServer>
          <!-- !SECTION dataTable -->
        </VCard>
      </VCol>
    </VRow>
  </section>
</template>
