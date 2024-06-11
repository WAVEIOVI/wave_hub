<script setup>
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import { avatarText } from '@core/utils/formatters'
import { useContractListStore } from '../useContractListStore'
import AddNewContractDialog from './AddNewContractDialog.vue'


const props = defineProps({
  headers: {
    type: Array,
    required: true,
  },
  types: {
    type: Array,
    required: true,
  },
  clients: {
    type: Array,
    required: true,
  },
  status: {
    type: Array,
    required: true,
  },
})

//SECTION UI
const resolveContractTypeVariant = type => {
  const typeLowerCase = type.toLowerCase()
  if (typeLowerCase === 'intervention')
    return {
      color: 'primary',
      icon: 'tabler-progress-check',
    }
  if (typeLowerCase === 'workshop')
    return {
      color: 'success',
      icon: 'tabler-building-warehouse',
    }
  
  return {
    color: 'secondary',
    icon: 'tabler-home-question',
  }
}


const resolveContractStatusVariant = stat => {
  if (stat === 'pending')
    return 'warning'
  if (stat === 'in progress')
    return 'success'
  if (stat === 'completed')
    return 'info'
  if (stat === 'closure')
    return 'error'
  
  return 'primary'
}

//!SECTION UI
//SECTION Declaration
const contractId = ref()
const router = useRouter()
const contractListStore = useContractListStore()
const searchQuery = ref('')
const selectedType = ref()
const selectedClient = ref()
const selectedStatus = ref()
const totalPage = ref(1)
const totalContracts = ref(0)
const contracts = ref([])

const options = ref({
  page: 1,
  itemsPerPage: 10,
  sortBy: [],
  groupBy: [],
  search: undefined,
})

// 👉 Add New Contract Dialog
const isAddNewContractDialogVisible = ref(false)

//!SECTION Declaration

//SECTION Functions
const paginationMeta = computed(() => {
  return (options, total) => {
    const start = (options.page - 1) * options.itemsPerPage + 1
    const end = Math.min(options.page * options.itemsPerPage, total)
    
    return `Showing ${start} to ${end} of ${total} entries`
  }
})

// 👉 Fetching contracts
const fetchContracts = () => {
  contractListStore.fetchContracts({
    search: searchQuery.value,
    status: selectedStatus.value,
    client: selectedClient.value,
    type: selectedType.value,
    options: options.value,
  }).then(response => {
    contracts.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalContracts.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
    console.log(contracts.value)
  }).catch(error => {
    console.error(error)
  })
}

// 👉 Add Contract
const addContract = async contractData => {
  try {
    const response = await contractListStore.addContract(contractData)
    if (response.status === 201) {
      contractId.value = response.data.data.id
      router.push({ name: 'wave-fire-contract-contract-folder-edit-id', params: { id: contractId.value } })

    } else {
      throw new Error(`Failed to create contract: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Delete Contract
const deleteContract = id => {
  contractListStore.deleteContract(id)
    .then(response => {
      console.log(response.data)
      fetchContracts()
    })
    .catch(error => {
      console.error('Error deleting contract:', error)
    })
}

watchEffect(fetchContracts)

//!SECTION Functions
</script>

<template>
  <section>
    <AddNewContractDialog
      v-model:isDialogVisible="isAddNewContractDialogVisible"
      :types="types"
      :clients="clients"
      @submit="addContract"
    />
    <VRow>
      <VCol cols="12">
        <VCard title="Contracts">
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
              <!-- 👉 Select Client -->
              <VCol
                cols="12"
                sm="4"
              >
                <AppSelect
                  v-model="selectedClient"
                  label="Select Client"
                  item-title="client_name"
                  :items="clients"
                  clearable
                  clear-icon="tabler-x"
                >
                  <template #item="{ props: itemProps, item }">  
                    <VListItem
                      v-bind="itemProps"
                      :subtitle="item.raw.client_id"
                    />
                  </template>
                </AppSelect>
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
                @click="isAddNewContractDialogVisible = !isAddNewContractDialogVisible"
              >
                Add New Contract
              </VBtn>
            </div>
          </VCardText>
          <!-- !SECTION - Table Tools -->

          <VDivider />
          <!-- SECTION dataTable -->
          <VDataTableServer
            v-model:items-per-page="options.itemsPerPage"
            v-model:page="options.page"
            :items="contracts"
            :items-length="totalContracts"
            :headers="headers"
            class="text-no-wrap"
            @update:options="options = $event"
          >
            <!-- 👉 Contract ID -->
            <template #[`item.contract_id`]="{ item }">
              <div class="d-flex align-center">
                <VAvatar
                  size="34"
                  :variant="!item.raw.avatar ? 'tonal' : undefined"
                  :color="!item.raw.avatar ? resolveContractTypeVariant(item.raw.contract_type).color : undefined"
                  class="me-3"
                >
                  <span>{{ avatarText(item.raw.client_name) }}</span>
                </VAvatar>

                <div class="d-flex flex-column">
                  <h6 class="text-base">
                    <RouterLink
                      :to="{ name: 'wave-fire-contract-contract-folder-edit-id', params: { id: item.raw.id } }"
                      class="font-weight-medium user-list-name"
                    >
                      #{{ item.raw.contract_id }}
                    </RouterLink>
                  </h6>
                </div>
              </div>
            </template>
            <!-- 👉 Type -->
            <template #[`item.contract_type`]="{ item }">
              <div class="d-flex align-center gap-4">
                <VAvatar
                  :size="30"
                  :color="resolveContractTypeVariant(item.raw.contract_type).color"
                  variant="tonal"
                >
                  <VIcon
                    :size="20"
                    :icon="resolveContractTypeVariant(item.raw.contract_type).icon"
                  />
                </VAvatar>
                <span class="text-capitalize">{{ item.raw.contract_type }}</span>
              </div>
            </template>
            <!-- 👉 Client Name -->
            <template #[`item.contract_client`]="{ item }">
              <div class="d-flex align-center">
                <VAvatar
                  size="34"
                  :variant="!item.raw.avatar ? 'tonal' : undefined"
                  :color="!item.raw.avatar ? resolveContractTypeVariant(item.raw.contract_type).color : undefined"
                  class="me-3"
                >
                  <span>{{ avatarText(item.raw.client_name) }}</span>
                </VAvatar>

                <div class="d-flex flex-column">
                  <h6 class="text-base">
                    <RouterLink
                      :to="{ name: 'wave-fire-contract-contract-folder-edit-id', params: { id: item.raw.id } }"
                      class="font-weight-medium user-list-name"
                    >
                      {{ item.raw.client_name }}
                    </RouterLink>
                  </h6>

                  <span class="text-sm text-medium-emphasis">#{{ item.raw.contract_client_id }}</span>
                </div>
              </div>
            </template>
            <!-- 👉 Status -->
            <template #[`item.contract_status`]="{ item }">
              <VChip
                :color="resolveContractStatusVariant(item.raw.contract_status)"
                size="small"
                label
                class="text-capitalize"
              >
                {{ item.raw.contract_status }}
              </VChip>
            </template>
            <!-- 👉 Actions -->
            <template #[`item.actions`]="{ item }">
              <IconBtn :to="{ name: 'wave-fire-contract-contract-folder-edit-id', params: { id: item.raw.id } }">
                <VIcon icon="tabler-edit" />
              </IconBtn>

              <IconBtn @click="deleteContract(item.raw.id)">
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
                    <VListItem :to="{ name: 'wave-fire-contract-contract-folder-edit-id', params: { id: item.raw.id } }">
                      <template #prepend>
                        <VIcon icon="tabler-eye" />
                      </template>

                      <VListItemTitle>View</VListItemTitle>
                    </VListItem>

                    <VListItem link>
                      <template #prepend>
                        <VIcon
                          to="{ name: 'wave-fire-contract-contract-folder-edit-id', params: { id: item.raw.id } }"
                          icon="tabler-pencil"
                        />
                      </template>
                      <VListItemTitle>Edit</VListItemTitle>
                    </VListItem>

                    <VListItem @click="deleteContract(item.raw.id)">
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
                  {{ paginationMeta(options, totalContracts) }}
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
../useContractListStore
