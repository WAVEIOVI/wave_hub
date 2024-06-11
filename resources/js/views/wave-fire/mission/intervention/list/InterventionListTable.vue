<script setup>
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import { avatarText } from '@core/utils/formatters'
import { useInterventionListStore } from '../useInterventionListStore'


const props = defineProps({
  headers: {
    type: Array,
    required: true,
  },
  technicians: {
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

const resolveInterventionStatusVariant = stat => {
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
const interventionId = ref()
const router = useRouter()
const interventionListStore = useInterventionListStore()
const searchQuery = ref('')
const selectedTechnician = ref()
const selectedClient = ref()
const selectedStatus = ref()
const totalPage = ref(1)
const totalInterventions = ref(0)
const interventions = ref([])

const options = ref({
  page: 1,
  itemsPerPage: 10,
  sortBy: [],
  groupBy: [],
  search: undefined,
})

//!SECTION Declaration

//SECTION Functions
const paginationMeta = computed(() => {
  return (options, total) => {
    const start = (options.page - 1) * options.itemsPerPage + 1
    const end = Math.min(options.page * options.itemsPerPage, total)
    
    return `Showing ${start} to ${end} of ${total} entries`
  }
})

// 👉 Fetching interventions
const fetchInterventions = () => {
  interventionListStore.fetchInterventions({
    search: searchQuery.value,
    status: selectedStatus.value,
    client: selectedClient.value,
    technician: selectedTechnician.value,
    options: options.value,
  }).then(response => {
    interventions.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalInterventions.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
    console.log(interventions.value)
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchInterventions)

//!SECTION Functions
</script>

<template>
  <section>
    <VRow>
      <VCol cols="12">
        <VCard title="Interventions">
          <!-- SECTION - Filters -->
          <VCardText>
            <VRow>
              <!-- 👉 Select Technician -->
              <VCol
                cols="12"
                sm="4"
              >
                <AppSelect
                  v-model="selectedTechnician"
                  label="Select Team Leader"
                  :items="technicians"
                  item-title="technician_name"
                  clearable
                  clear-icon="tabler-x"
                >
                  <template #item="{ props: itemProps, item }">  
                    <VListItem
                      v-bind="itemProps"
                      :subtitle="item.raw.technician_id"
                    />
                  </template>
                </AppSelect>
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
            </div>
          </VCardText>
          <!-- !SECTION - Table Tools -->

          <VDivider />
          <!-- SECTION dataTable -->
          <VDataTableServer
            v-model:items-per-page="options.itemsPerPage"
            v-model:page="options.page"
            :items="interventions"
            :items-length="totalInterventions"
            :headers="headers"
            class="text-no-wrap"
            @update:options="options = $event"
          >
            <!-- 👉 Intervention ID -->
            <template #[`item.intervention_id`]="{ item }">
              <div class="d-flex align-center">
                <VAvatar
                  size="34"
                  :variant="!item.raw.avatar ? 'tonal' : undefined"
                  class="me-3"
                >
                  <span>{{ avatarText(item.raw.client_name) }}</span>
                </VAvatar>

                <div class="d-flex flex-column">
                  <h6 class="text-base">
                    <RouterLink
                      :to="{ name: 'wave-fire-mission-intervention-edit-id', params: { id: item.raw.id } }"
                      class="font-weight-medium user-list-name"
                    >
                      #{{ item.raw.intervention_id }}
                    </RouterLink>
                  </h6>
                </div>
              </div>
            </template>
            <!-- 👉 Client Name -->
            <template #[`item.client`]="{ item }">
              <div class="d-flex align-center">
                <VAvatar
                  size="34"
                  :variant="!item.raw.avatar ? 'tonal' : undefined"
                  class="me-3"
                >
                  <span>{{ avatarText(item.raw.client_name) }}</span>
                </VAvatar>

                <div class="d-flex flex-column">
                  <h6 class="text-base">
                    {{ item.raw.client_name }}
                  </h6>

                  <span class="text-sm text-medium-emphasis">#{{ item.raw.mission_client_id }}</span>
                </div>
              </div>
            </template>
            <!-- 👉 Park Address -->
            <template #[`item.intervention_park`]="{ item }">
              <div class="d-flex flex-column">
                <h6 class="text-base">
                  {{ item.raw.park_id }} {{ item.raw.park_title }}
                </h6>

                <span class="text-sm text-medium-emphasis">{{ item.raw.park_address }} {{ item.raw.park_postcode }} {{ item.raw.park_city }} {{ item.raw.park_country }}</span>
              </div>
            </template>
            <!-- 👉 Park Address -->
            <template #[`item.intervention_team_leader`]="{ item }">
              <div class="d-flex flex-column">
                <h6 class="text-base">
                  {{ item.raw.team_leader }} 
                </h6>
              </div>
            </template>
            <!-- 👉 Status -->
            <template #[`item.intervention_status`]="{ item }">
              <VChip
                :color="resolveInterventionStatusVariant(item.raw.intervention_status)"
                size="small"
                label
                class="text-capitalize"
              >
                {{ item.raw.intervention_status }}
              </VChip>
            </template>
            <!-- 👉 Actions -->
            <template #[`item.actions`]="{ item }">
              <IconBtn :to="{ name: 'wave-fire-mission-intervention-edit-id', params: { id: item.raw.id } }">
                <VIcon icon="tabler-edit" />
              </IconBtn>

              <IconBtn>
                <VIcon icon="tabler-eye" />
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
                    <VListItem :to="{ name: 'wave-fire-mission-intervention-edit-id', params: { id: item.raw.id } }">
                      <template #prepend>
                        <VIcon icon="tabler-eye" />
                      </template>

                      <VListItemTitle>View</VListItemTitle>
                    </VListItem>

                    <VListItem link>
                      <template #prepend>
                        <VIcon
                          to="{ name: 'wave-fire-mission-intervention-edit-id', params: { id: item.raw.id } }"
                          icon="tabler-pencil"
                        />
                      </template>
                      <VListItemTitle>Edit</VListItemTitle>
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
                  {{ paginationMeta(options, totalInterventions) }}
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
