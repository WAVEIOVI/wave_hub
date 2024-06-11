<script setup>
import { useMetaStore } from '@/stores/useMetaStore'
import { useUserClientDashboardStore } from '@/stores/useUserClientDashboardStore'
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import ChartCategories from './park-charts/ChartCategories.vue'
import ChartFireExtinguisherModel from './park-charts/ChartFireExtinguisherModel.vue'
import ChartStatus from './park-charts/ChartStatus.vue'
import ViewEquipmentDialog from './ViewEquipmentDialog.vue'

const props = defineProps({
  parksData: {
    type: Array,
    required: true,
  },
  equipmentHeaders: {
    type: Array,
    required: true,
  },
})

const route = useRoute()
const router = useRouter()
const metaStore = useMetaStore()
const clientDashboardStore = useUserClientDashboardStore()
const panel = ref(0)

const parksEquipment = ref({})
const totalPage = ref(1)
const totalEquipments = ref(0)
const equipments = ref({})
const equipmentData = ref([])
const equipmentSingleData = ref([])
const isViewEquipmentDialogVisible = ref(false)

const options = ref({
  page: 1,
  itemsPerPage: 10,
  sortBy: [],
  groupBy: [],
})

const paginationMeta = computed(() => {
  return (options, total) => {
    const start = (options.page - 1) * options.itemsPerPage + 1
    const end = Math.min(options.page * options.itemsPerPage, total)
    
    return `Showing ${start} to ${end} of ${total} entries`
  }
})

// 👉 Fetch Park Equipment data
const fetchParkEquipmentData = id => {
  clientDashboardStore.fetchParkEquipmentData(id)
    .then(response => {
      equipmentSingleData.value = response.data.data
    }).catch(error => {
      console.error(error)
    })
}

const fetchParkEquipment = parkId => {
  return metaStore.fetchParkEquipment(parkId)
    .then(response => {
      console.log('Park Meta Equipment Response:', response.data)
      
      return {
        totalEquipment: response.data.data.count.equipment_per_park,
        totalFireExtinguisher: response.data.data.count.fire_extinguisher_per_park,
        totalFireHose: response.data.data.count.fire_hose_per_park,
        othersEquipment: response.data.data.count.others_equipment_per_park,
        categoryChart: response.data.data.count.equipment_category_count,
        fireExtinguisherModelChart: response.data.data.count.fire_extinguisher_model_count,
        statusChart: response.data.data.count.equipment_status_count,
      }
    }).catch(error => {
      console.error('Error fetching park equipment:', error)
      
      return null
    })
}

const fetchParkEquipments = parkId => {
  return clientDashboardStore.fetchParkEquipments({
    id: parkId,
    options: options.value,
  })
    .then(response => {
      console.log('Park Equipments Response:', response.data)
      equipments.value[parkId] = response.data.data
      totalPage.value = response.data.meta.last_page
      totalEquipments.value = response.data.meta.total
      options.value.page = response.data.meta.current_page
    })
    .catch(error => {
      console.error('Error fetching park equipments:', error)
    })
}

const fetchAllParksEquipment = () => {
  props.parksData.forEach(park => {
    fetchParkEquipment(park.id).then(data => {
      if (data) {
        parksEquipment.value[park.id] = data
      }
    })
    fetchParkEquipments(park.id)
  })
}

onMounted(() => {
  fetchAllParksEquipment()
})

// Helper function to extract the count value
const extractCount = countObject => {
  if (!countObject || typeof countObject !== 'object') {
    return null
  }
  
  return Object.values(countObject)[0]
}

const createStatisticsVerticalSimple = parkId => {
  const equipmentData = parksEquipment.value[parkId]

  if (!equipmentData) return []

  return [
    {
      title: 'Equipment',
      color: 'primary',
      stats: extractCount(equipmentData.totalEquipment),
      icon: 'tabler-tool',
    },
    {
      title: 'Fire Extinguisher',
      color: 'primary',
      stats: extractCount(equipmentData.totalFireExtinguisher),
      icon: 'tabler-fire-extinguisher',
    },
    {
      title: 'Fire Hose',
      color: 'primary',
      stats: extractCount(equipmentData.totalFireHose),
      icon: 'tabler-firetruck',
    },
    {
      title: 'Others Equipment',
      color: 'primary',
      stats: extractCount(equipmentData.othersEquipment),
      icon: 'tabler-tools',
    },
  ]
}

//SECTION UI
const resolveEquipmentCategoryVariant = category => {
  if (category === 'fire extinguisher')
    return {
      color: 'warning',
      icon: 'tabler-fire-extinguisher',
    }
  if (category === 'fire hose')
    return {
      color: 'warning',
      icon: 'tabler-firetruck',
    }
  if (category === 'fire hydrant')
    return {
      color: 'warning',
      icon: 'tabler-fire-hydrant',
    }  
  
  return {
    color: 'secondary',
    icon: 'tabler-box',
  }
}

const resolveEquipmentStatusVariant = stat => {
  if (stat === 'in service')
    return 'success'
  if (stat === 'limited use')
    return 'warning'
  if (stat === 'out of order')
    return 'error'
  
  return 'primary'
}

const accessoryViewHeaders = [
  {
    title: 'accessory id',
    key: 'accessory_id',
  },
  {
    title: 'name',
    key: 'name',
  },
]


//!SECTION UI
watch(
  () => options.value.page,
  newPage => {
    props.parksData.forEach(park => {
      fetchParkEquipments(park.id)
    })
  },
)
watch(
  () => options.value.page,
  newPage => {
    props.parksData.forEach(park => {
      fetchParkEquipments(park.id)
    })
  },
)
</script>

<template>
  <div>
    <ViewEquipmentDialog
      v-model:isDialogVisible="isViewEquipmentDialogVisible"
      :accessory-view-headers="accessoryViewHeaders"
      :equipment-single-data="equipmentSingleData"
    />
    <VExpansionPanels
      v-model="panel"
      multiple
      class="no-icon-rotate"
    >
      <VExpansionPanel
        v-for="(park, index) in props.parksData"
        :key="index"
      >
        <VExpansionPanelTitle
          class="text-uppercase"
          disable-icon-rotate
        >
          Park ID: {{ park.park_id }} 
          <template #actions>
            <VIcon
              size="35"
              icon="tabler-building-warehouse"
              color="primary"
            />
          </template>
        </VExpansionPanelTitle>
        <VExpansionPanelText>
          <VRow class="match-height">
            <VCol cols="12">
              <VCard>
                <VCardText>
                  <VList class="card-list text-medium-emphasis">
                    <VListItem>
                      <VListItemTitle>
                        <span class="text-capitalize font-weight-medium me-1">Title:</span>
                        <span class="text-capitalize font-weight-medium me-1"> {{ park.park_title }}</span>
                      </VListItemTitle>
                      <VListItemTitle>
                        <span class="text-capitalize font-weight-medium me-1">Type:</span>
                        <span class="text-capitalize font-weight-medium me-1"> {{ park.park_type }}</span>
                      </VListItemTitle>
                      <VListItemTitle>
                        {{ park.park_address }} {{ park.park_postcode }} {{ park.park_city }} {{ park.park_country }} 
                      </VListItemTitle>
                    </VListItem>
                  </VList>
                </VCardText>
              </VCard>
            </VCol>
          </VRow>
          <VRow class="match-height"> 
            <VCol
              v-for="statistics in createStatisticsVerticalSimple(park.id)"
              :key="statistics.title"
              md="3"
              cols="6"
            >
              <CardStatisticsVerticalSimple v-bind="statistics" />
            </VCol>
            <VCol
              md="4"
              cols="12"
            >
              <VCard>
                <VCardTitle>Categories</VCardTitle>
                <ChartCategories
                  v-if="parksEquipment[park.id]?.categoryChart"
                  :categories-labels="Object.keys(parksEquipment[park.id].categoryChart)"
                  :categories-series="Object.values(parksEquipment[park.id].categoryChart)"
                />
              </VCard>
            </VCol>
            <VCol
              md="4"
              cols="12"
            >
              <VCard>
                <VCardTitle>Fire Extinguisher</VCardTitle>
                <ChartFireExtinguisherModel
                  v-if="parksEquipment[park.id]?.fireExtinguisherModelChart"
                  :fire-extinguisher-model-labels="Object.keys(parksEquipment[park.id].fireExtinguisherModelChart)"
                  :fire-extinguisher-model-series="Object.values(parksEquipment[park.id].fireExtinguisherModelChart)"
                />
              </VCard>
            </VCol>
            <VCol
              md="4"
              cols="12"
            >
              <VCard>
                <VCardTitle>Status</VCardTitle>
                <ChartStatus
                  v-if="parksEquipment[park.id]?.statusChart"
                  :status-labels="Object.keys(parksEquipment[park.id].statusChart)"
                  :status-series="Object.values(parksEquipment[park.id].statusChart)"
                />
              </VCard>
            </VCol>
            <VCol cols="12">
              <VCard title="Park Equipments">
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
                </VCardText>
                <!-- !SECTION - Table Tools -->

                <VDivider />
                <!-- SECTION dataTable -->
                <VDataTableServer
                  v-model:items-per-page="options.itemsPerPage"
                  v-model:page="options.page"
                  :items="equipments[park.id]"
                  :items-length="totalEquipments"
                  :headers="equipmentHeaders"
                  class="text-no-wrap"
                  @update:options="options = $event"
                >
                  <!-- 👉 Equipment Title -->
                  <template #[`item.equipment_id`]="{ item }">
                    <div class="d-flex align-center">
                      <div class="d-flex flex-column">
                        <h6 class="text-base">
                          {{ item.raw.qrc_id }}
                        </h6>

                        <span class="text-sm text-medium-emphasis">{{ item.raw.internal_id }}</span>
                      </div>
                    </div>
                  </template>
                  <!-- 👉 Equipment Area -->
                  <template #[`item.area`]="{ item }">
                    <div class="d-flex align-center">
                      <div class="d-flex flex-column">
                        <h6 class="text-base">
                          {{ item.raw.equipment_area }}
                        </h6>

                        <span class="text-sm text-medium-emphasis text-uppercase">{{ item.raw.equipment_area_description }} </span>
                      </div>
                    </div>
                  </template>
                  <!-- 👉 Category -->
                  <template #[`item.category`]="{ item }">
                    <div class="d-flex align-center gap-4">
                      <VAvatar
                        :size="30"
                        :color="resolveEquipmentCategoryVariant(item.raw.equipment_category).color"
                        variant="tonal"
                      >
                        <VIcon
                          :size="20"
                          :icon="resolveEquipmentCategoryVariant(item.raw.equipment_category).icon"
                        />
                      </VAvatar>
                      <span class="text-capitalize">{{ item.raw.equipment_category }}</span>
                    </div>
                  </template>
                  <!-- 👉 Equipment Description -->
                  <template #[`item.equipment`]="{ item }">
                    <div class="d-flex flex-column">
                      <h6 class="text-base text-capitalize">
                        {{ item.raw.equipment_model }}
                      </h6>
                      <span 
                        v-if="item.raw.equipment_category === 'fire extinguisher'"
                        class="text-sm text-medium-emphasis text-capitalize"
                      >{{ item.raw.equipment_weight_value }} {{ item.raw.equipment_weight_unit }} {{ item.raw.equipment_pressure }}</span>
                    </div>
                  </template>
                  <!-- 👉 Status -->
                  <template #[`item.equipment_status`]="{ item }">
                    <VChip
                      :color="resolveEquipmentStatusVariant(item.raw.equipment_status)"
                      size="small"
                      label
                      class="text-capitalize"
                    >
                      {{ item.raw.equipment_status }}
                    </VChip>
                  </template>
                  <!-- 👉 Actions -->
                  <template #[`item.actions`]="{ item }">
                    <IconBtn 
                      @click=" fetchParkEquipmentData(item.raw.id),
                               isViewEquipmentDialogVisible = !isViewEquipmentDialogVisible"
                    >
                      <VIcon icon="tabler-eye" />
                    </IconBtn>
                  </template>

                  <!-- 👉 pagination -->
                  <template #bottom>
                    <VDivider />
                    <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                      <p class="text-sm text-disabled mb-0">
                        {{ paginationMeta(options, totalEquipments) }}
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
        </VExpansionPanelText>
      </VExpansionPanel>
    </VExpansionPanels>
  </div>
</template>
