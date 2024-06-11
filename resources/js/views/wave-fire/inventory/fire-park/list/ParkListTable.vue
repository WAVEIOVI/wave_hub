<script setup>
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import { avatarText } from '@core/utils/formatters'
import { useParkListStore } from '../useParkListStore'
import AddNewParkDialog from './AddNewParkDialog.vue'


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
  cities: {
    type: Array,
    required: true,
  },
})

//SECTION UI
const resolveParkTypeVariant = type => {
  const typeLowerCase = type.toLowerCase()
  if (typeLowerCase === 'primary fire park')
    return {
      color: 'primary',
      icon: 'tabler-badges-filled',
    }
  if (typeLowerCase === 'secondary fire park')
    return {
      color: 'success',
      icon: 'tabler-arrow-badge-down-filled',
    }
  if (typeLowerCase === 'reserve fire park')
    return {
      color: 'info',
      icon: 'tabler-briefcase',
    }  
  
  return {
    color: 'secondary',
    icon: 'tabler-home-question',
  }
}


//!SECTION UI
//SECTION Declaration
const parkId = ref()
const router = useRouter()
const parkListStore = useParkListStore()
const searchQuery = ref('')
const selectedType = ref()
const selectedClient = ref()
const selectedCity = ref()
const totalPage = ref(1)
const totalParks = ref(0)
const parks = ref([])

const options = ref({
  page: 1,
  itemsPerPage: 10,
  sortBy: [],
  groupBy: [],
  search: undefined,
})

// 👉 Add New Park Dialog
const isAddNewParkDialogVisible = ref(false)

//!SECTION Declaration

//SECTION Functions
const paginationMeta = computed(() => {
  return (options, total) => {
    const start = (options.page - 1) * options.itemsPerPage + 1
    const end = Math.min(options.page * options.itemsPerPage, total)
    
    return `Showing ${start} to ${end} of ${total} entries`
  }
})

// 👉 Fetching parks
const fetchParks = () => {
  parkListStore.fetchParks({
    search: searchQuery.value,
    city: selectedCity.value,
    client: selectedClient.value,
    type: selectedType.value,
    options: options.value,
  }).then(response => {
    parks.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalParks.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
    console.log(parks.value)
  }).catch(error => {
    console.error(error)
  })
}

// 👉 Add Park
const addPark = async parkData => {
  try {
    const response = await parkListStore.addPark(parkData)
    if (response.status === 201) {
      parkId.value = response.data.data.id
      router.push({ name: 'wave-fire-inventory-fire-park-edit-id', params: { id: parkId.value } })
    } else {
      throw new Error(`Failed to create park: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Delete Park
const deletePark = id => {
  parkListStore.deletePark(id)
    .then(response => {
      console.log(response.data)
      fetchParks()
    })
    .catch(error => {
      console.error('Error deleting park:', error)
    })
}

watchEffect(fetchParks)

//!SECTION Functions
</script>

<template>
  <section>
    <AddNewParkDialog
      v-model:isDialogVisible="isAddNewParkDialogVisible"
      :types="types"
      :clients="clients"
      @submit="addPark"
    />
    <VRow>
      <VCol cols="12">
        <VCard title="Parks">
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
              <!-- 👉 Select City -->
              <VCol
                cols="12"
                sm="4"
              >
                <AppSelect
                  v-model="selectedCity"
                  label="Select City"
                  :items="cities"
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
                @click="isAddNewParkDialogVisible = !isAddNewParkDialogVisible"
              >
                Add New Park
              </VBtn>
            </div>
          </VCardText>
          <!-- !SECTION - Table Tools -->

          <VDivider />
          <!-- SECTION dataTable -->
          <VDataTableServer
            v-model:items-per-page="options.itemsPerPage"
            v-model:page="options.page"
            :items="parks"
            :items-length="totalParks"
            :headers="headers"
            class="text-no-wrap"
            @update:options="options = $event"
          >
            <!-- 👉 Park ID -->
            <template #[`item.park`]="{ item }">
              <div class="d-flex align-center">
                <VAvatar
                  size="34"
                  :variant="!item.raw.avatar ? 'tonal' : undefined"
                  :color="!item.raw.avatar ? resolveParkTypeVariant(item.raw.park_type).color : undefined"
                  class="me-3"
                >
                  <span>{{ avatarText(item.raw.park_title) }}</span>
                </VAvatar>

                <div class="d-flex flex-column">
                  <h6 class="text-base">
                    <RouterLink
                      :to="{ name: 'wave-fire-inventory-fire-park-edit-id', params: { id: item.raw.id } }"
                      class="font-weight-medium user-list-name"
                    >
                      {{ item.raw.park_title }}
                    </RouterLink>
                  </h6>

                  <span class="text-sm text-medium-emphasis">#{{ item.raw.park_id }}</span>
                </div>
              </div>
            </template>
            <!-- 👉 Type -->
            <template #[`item.park_type`]="{ item }">
              <div class="d-flex align-center gap-4">
                <VAvatar
                  :size="30"
                  :color="resolveParkTypeVariant(item.raw.park_type).color"
                  variant="tonal"
                >
                  <VIcon
                    :size="20"
                    :icon="resolveParkTypeVariant(item.raw.park_type).icon"
                  />
                </VAvatar>
                <span class="text-capitalize">{{ item.raw.park_type }}</span>
              </div>
            </template>
            <!-- 👉 Client Name -->
            <template #[`item.park_client`]="{ item }">
              <div class="d-flex align-center">
                <VAvatar
                  size="34"
                  :variant="!item.raw.avatar ? 'tonal' : undefined"
                  :color="!item.raw.avatar ? resolveParkTypeVariant(item.raw.park_type).color : undefined"
                  class="me-3"
                >
                  <span>{{ avatarText(item.raw.client_name) }}</span>
                </VAvatar>

                <div class="d-flex flex-column">
                  <h6 class="text-base">
                    <RouterLink
                      :to="{ name: 'wave-fire-inventory-fire-park-edit-id', params: { id: item.raw.id } }"
                      class="font-weight-medium user-list-name"
                    >
                      {{ item.raw.client_name }}
                    </RouterLink>
                  </h6>

                  <span class="text-sm text-medium-emphasis">#{{ item.raw.park_client_id }}</span>
                </div>
              </div>
            </template>

            <!-- 👉 Park Address -->
            <template #[`item.park_address`]="{ item }">
              <div class="d-flex flex-column">
                <h6 class="text-base">
                  {{ item.raw.park_address }}
                </h6>

                <span class="text-sm text-medium-emphasis">{{ item.raw.park_postcode }} {{ item.raw.park_city }} {{ item.raw.park_country }}</span>
              </div>
            </template>

            <!-- 👉 Actions -->
            <template #[`item.actions`]="{ item }">
              <IconBtn :to="{ name: 'wave-fire-inventory-fire-park-edit-id', params: { id: item.raw.id } }">
                <VIcon icon="tabler-edit" />
              </IconBtn>

              <IconBtn @click="deletePark(item.raw.id)">
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
                          to="{ name: ''wave-fire-inventory-fire-park-edit-id',', params: { id: item.raw.id } }"
                          icon="tabler-pencil"
                        />
                      </template>
                      <VListItemTitle>Edit</VListItemTitle>
                    </VListItem>

                    <VListItem @click="deletePark(item.raw.id)">
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
                  {{ paginationMeta(options, totalParks) }}
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
