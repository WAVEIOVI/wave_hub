<script setup>
import AddNewClientDialog from '@/views/contact/client/list/AddNewClientDialog.vue'
import { useClientListStore } from '@/views/contact/client/useClientListStore'
import { avatarText } from '@core/utils/formatters'
import { VDataTableServer } from 'vuetify/labs/VDataTable'


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
const resolveClientTypeVariant = type => {
  const typeLowerCase = type.toLowerCase()
  if (typeLowerCase === 'individual client')
    return {
      color: 'warning',
      icon: 'tabler-user-question',
    }
  if (typeLowerCase === 'small business client')
    return {
      color: 'success',
      icon: 'tabler-users-group',
    }
  if (typeLowerCase === 'enterprise client')
    return {
      color: 'primary',
      icon: 'tabler-building-community',
    }
  if (typeLowerCase === 'government client')
    return {
      color: 'info',
      icon: 'tabler-briefcase',
    }
  if (typeLowerCase === 'non-profit client')
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

const resolveClientStatusVariant = stat => {
  const statLowerCase = stat.toLowerCase()
  if (statLowerCase === 'pending')
    return 'warning'
  if (statLowerCase === 'active')
    return 'success'
  if (statLowerCase === 'inactive')
    return 'error'
  
  return 'secondary'
}

//!SECTION UI
//SECTION Declaration
const clientId = ref()
const router = useRouter()
const clientListStore = useClientListStore()
const searchQuery = ref('')
const selectedType = ref()
const selectedActivity = ref()
const selectedStatus = ref()
const totalPage = ref(1)
const totalClients = ref(0)
const clients = ref([])

const options = ref({
  page: 1,
  itemsPerPage: 10,
  sortBy: [],
  groupBy: [],
  search: undefined,
})

// 👉 Add New Client Dialog
const isAddNewClientDialogVisible = ref(false)

//!SECTION Declaration

//SECTION Functions
const paginationMeta = computed(() => {
  return (options, total) => {
    const start = (options.page - 1) * options.itemsPerPage + 1
    const end = Math.min(options.page * options.itemsPerPage, total)
    
    return `Showing ${start} to ${end} of ${total} entries`
  }
})

// 👉 Fetching clients
const fetchClients = () => {
  clientListStore.fetchClients({
    search: searchQuery.value,
    status: selectedStatus.value,
    activity: selectedActivity.value,
    type: selectedType.value,
    options: options.value,
  }).then(response => {
    clients.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalClients.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
  }).catch(error => {
    console.error(error)
  })
}

// 👉 Add Client
const addClient = async clientData => {
  try {
    const response = await clientListStore.addClient(clientData)

    if (response.status === 201) {
      clientId.value = response.data.data.id
      router.push({ name: 'contact-edit-client-id', params: { id: clientId.value } })
    } else {
      throw new Error(`Failed to create client: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Delete Client
const deleteClient = id => {
  clientListStore.deleteClient(id)
    .then(response => {
      console.log(response.data)
      fetchClients()
    })
    .catch(error => {
      console.error('Error deleting client:', error)
    })
}

watchEffect(fetchClients)

//!SECTION Functions
</script>

<template>
  <section>
    <AddNewClientDialog
      v-model:isDialogVisible="isAddNewClientDialogVisible"
      :types="types"
      :activities="activities" 
      :status="status" 
      @submit="addClient"
    />
    <VRow>
      <VCol cols="12">
        <VCard title="Clients">
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
                @click="isAddNewClientDialogVisible = !isAddNewClientDialogVisible"
              >
                Add New Client
              </VBtn>
            </div>
          </VCardText>
          <!-- !SECTION - Table Tools -->

          <VDivider />
          <!-- SECTION dataTable -->
          <VDataTableServer
            v-model:items-per-page="options.itemsPerPage"
            v-model:page="options.page"
            :items="clients"
            :items-length="totalClients"
            :headers="headers"
            class="text-no-wrap"
            @update:options="options = $event"
          >
            <!-- 👉 Client Name -->
            <template #[`item.client_name`]="{ item }">
              <div class="d-flex align-center">
                <VAvatar
                  size="34"
                  :variant="!item.raw.avatar ? 'tonal' : undefined"
                  :color="!item.raw.avatar ? resolveClientTypeVariant(item.raw.client_type).color : undefined"
                  class="me-3"
                >
                  <span>{{ avatarText(item.raw.client_name) }}</span>
                </VAvatar>

                <div class="d-flex flex-column">
                  <h6 class="text-base">
                    <RouterLink
                      :to="{ name: 'contact-edit-client-id', params: { id: item.raw.id } }"
                      class="font-weight-medium user-list-name"
                    >
                      {{ item.raw.client_name }}
                    </RouterLink>
                  </h6>

                  <span class="text-sm text-medium-emphasis">#{{ item.raw.client_id }}</span>
                </div>
              </div>
            </template>

            <!-- 👉 Type -->
            <template #[`item.client_type`]="{ item }">
              <div class="d-flex align-center gap-4">
                <VAvatar
                  :size="30"
                  :color="resolveClientTypeVariant(item.raw.client_type).color"
                  variant="tonal"
                >
                  <VIcon
                    :size="20"
                    :icon="resolveClientTypeVariant(item.raw.client_type).icon"
                  />
                </VAvatar>
                <span class="text-capitalize">{{ item.raw.client_type }}</span>
              </div>
            </template>

            <!-- 👉 Client Activity -->
            <template #[`item.client_activity`]="{ item }">
              <span class="text-capitalize font-weight-medium">{{ item.raw.client_activity }}</span>
            </template>

            <!-- 👉 Status -->
            <template #[`item.client_status`]="{ item }">
              <VChip
                :color="resolveClientStatusVariant(item.raw.client_status)"
                size="small"
                label
                class="text-capitalize"
              >
                {{ item.raw.client_status }}
              </VChip>
            </template>
            <!-- 👉 Actions -->
            <template #[`item.actions`]="{ item }">
              <IconBtn :to="{ name: 'contact-edit-client-id', params: { id: item.raw.id } }">
                <VIcon icon="tabler-edit" />
              </IconBtn>

              <IconBtn @click="deleteClient(item.raw.id)">
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
                    <VListItem :to="{ name: 'contact-edit-client-id', params: { id: item.raw.id } }">
                      <template #prepend>
                        <VIcon icon="tabler-eye" />
                      </template>

                      <VListItemTitle>View</VListItemTitle>
                    </VListItem>

                    <VListItem link>
                      <template #prepend>
                        <VIcon
                          to="{ name: 'contact-edit-client-id', params: { id: item.raw.id } }"
                          icon="tabler-pencil"
                        />
                      </template>
                      <VListItemTitle>Edit</VListItemTitle>
                    </VListItem>

                    <VListItem @click="deleteClient(item.raw.id)">
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
                  {{ paginationMeta(options, totalClients) }}
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
