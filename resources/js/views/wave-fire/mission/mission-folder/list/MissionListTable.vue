<script setup>
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import { avatarText } from '@core/utils/formatters'
import { useMissionListStore } from '../useMissionListStore'
import AddNewMissionDialog from './AddNewMissionDialog.vue'


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
const resolveMissionTypeVariant = type => {
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


const resolveMissionStatusVariant = stat => {
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
const missionId = ref()
const router = useRouter()
const missionListStore = useMissionListStore()
const searchQuery = ref('')
const selectedType = ref()
const selectedClient = ref()
const selectedStatus = ref()
const totalPage = ref(1)
const totalMissions = ref(0)
const missions = ref([])

const options = ref({
  page: 1,
  itemsPerPage: 10,
  sortBy: [],
  groupBy: [],
  search: undefined,
})

// 👉 Add New Mission Dialog
const isAddNewMissionDialogVisible = ref(false)

//!SECTION Declaration

//SECTION Functions
const paginationMeta = computed(() => {
  return (options, total) => {
    const start = (options.page - 1) * options.itemsPerPage + 1
    const end = Math.min(options.page * options.itemsPerPage, total)
    
    return `Showing ${start} to ${end} of ${total} entries`
  }
})

// 👉 Fetching missions
const fetchMissions = () => {
  missionListStore.fetchMissions({
    search: searchQuery.value,
    status: selectedStatus.value,
    client: selectedClient.value,
    type: selectedType.value,
    options: options.value,
  }).then(response => {
    missions.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalMissions.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
    console.log(missions.value)
  }).catch(error => {
    console.error(error)
  })
}

// 👉 Add Mission
const addMission = async missionData => {
  try {
    const response = await missionListStore.addMission(missionData)
    if (response.status === 201) {
      missionId.value = response.data.data.id
      router.push({ name: 'wave-fire-mission-mission-folder-edit-id', params: { id: missionId.value } })

    } else {
      throw new Error(`Failed to create mission: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Delete Mission
const deleteMission = id => {
  missionListStore.deleteMission(id)
    .then(response => {
      console.log(response.data)
      fetchMissions()
    })
    .catch(error => {
      console.error('Error deleting mission:', error)
    })
}

watchEffect(fetchMissions)

//!SECTION Functions
</script>

<template>
  <section>
    <AddNewMissionDialog
      v-model:isDialogVisible="isAddNewMissionDialogVisible"
      :types="types"
      :clients="clients"
      @submit="addMission"
    />
    <VRow>
      <VCol cols="12">
        <VCard title="Missions">
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
                @click="isAddNewMissionDialogVisible = !isAddNewMissionDialogVisible"
              >
                Add New Mission
              </VBtn>
            </div>
          </VCardText>
          <!-- !SECTION - Table Tools -->

          <VDivider />
          <!-- SECTION dataTable -->
          <VDataTableServer
            v-model:items-per-page="options.itemsPerPage"
            v-model:page="options.page"
            :items="missions"
            :items-length="totalMissions"
            :headers="headers"
            class="text-no-wrap"
            @update:options="options = $event"
          >
            <!-- 👉 Mission ID -->
            <template #[`item.mission_id`]="{ item }">
              <div class="d-flex align-center">
                <VAvatar
                  size="34"
                  :variant="!item.raw.avatar ? 'tonal' : undefined"
                  :color="!item.raw.avatar ? resolveMissionTypeVariant(item.raw.mission_type).color : undefined"
                  class="me-3"
                >
                  <span>{{ avatarText(item.raw.client_name) }}</span>
                </VAvatar>

                <div class="d-flex flex-column">
                  <h6 class="text-base">
                    <RouterLink
                      :to="{ name: 'wave-fire-mission-mission-folder-edit-id', params: { id: item.raw.id } }"
                      class="font-weight-medium user-list-name"
                    >
                      #{{ item.raw.mission_id }}
                    </RouterLink>
                  </h6>
                </div>
              </div>
            </template>
            <!-- 👉 Type -->
            <template #[`item.mission_type`]="{ item }">
              <div class="d-flex align-center gap-4">
                <VAvatar
                  :size="30"
                  :color="resolveMissionTypeVariant(item.raw.mission_type).color"
                  variant="tonal"
                >
                  <VIcon
                    :size="20"
                    :icon="resolveMissionTypeVariant(item.raw.mission_type).icon"
                  />
                </VAvatar>
                <span class="text-capitalize">{{ item.raw.mission_type }}</span>
              </div>
            </template>
            <!-- 👉 Client Name -->
            <template #[`item.mission_client`]="{ item }">
              <div class="d-flex align-center">
                <VAvatar
                  size="34"
                  :variant="!item.raw.avatar ? 'tonal' : undefined"
                  :color="!item.raw.avatar ? resolveMissionTypeVariant(item.raw.mission_type).color : undefined"
                  class="me-3"
                >
                  <span>{{ avatarText(item.raw.client_name) }}</span>
                </VAvatar>

                <div class="d-flex flex-column">
                  <h6 class="text-base">
                    <RouterLink
                      :to="{ name: 'wave-fire-mission-mission-folder-edit-id', params: { id: item.raw.id } }"
                      class="font-weight-medium user-list-name"
                    >
                      {{ item.raw.client_name }}
                    </RouterLink>
                  </h6>

                  <span class="text-sm text-medium-emphasis">#{{ item.raw.mission_client_id }}</span>
                </div>
              </div>
            </template>
            <!-- 👉 Status -->
            <template #[`item.mission_status`]="{ item }">
              <VChip
                :color="resolveMissionStatusVariant(item.raw.mission_status)"
                size="small"
                label
                class="text-capitalize"
              >
                {{ item.raw.mission_status }}
              </VChip>
            </template>
            <!-- 👉 Actions -->
            <template #[`item.actions`]="{ item }">
              <IconBtn :to="{ name: 'wave-fire-mission-mission-folder-edit-id', params: { id: item.raw.id } }">
                <VIcon icon="tabler-edit" />
              </IconBtn>

              <IconBtn @click="deleteMission(item.raw.id)">
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
                    <VListItem :to="{ name: 'wave-fire-mission-mission-folder-edit-id', params: { id: item.raw.id } }">
                      <template #prepend>
                        <VIcon icon="tabler-eye" />
                      </template>

                      <VListItemTitle>View</VListItemTitle>
                    </VListItem>

                    <VListItem link>
                      <template #prepend>
                        <VIcon
                          to="{ name: 'wave-fire-mission-mission-folder-edit-id', params: { id: item.raw.id } }"
                          icon="tabler-pencil"
                        />
                      </template>
                      <VListItemTitle>Edit</VListItemTitle>
                    </VListItem>

                    <VListItem @click="deleteMission(item.raw.id)">
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
                  {{ paginationMeta(options, totalMissions) }}
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
