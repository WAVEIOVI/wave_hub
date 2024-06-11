<script setup>
import { useContractListStore } from '../useContractListStore'
import { VDataTableServer } from 'vuetify/labs/VDataTable'

// import ViewEquipmentDialog from './ViewEquipmentDialog.vue'
import { avatarText } from '@core/utils/formatters'

const props = defineProps({
  equipmentHeaders: {
    type: Array,
    required: true,
  },
  contractData: {
    type: Array,
    required: true,
  },
})

//!SECTION UI
const resolveEquipmentStatusVariant = stat => {
  if (stat === 'in service')
    return 'success'
  if (stat === 'limited use')
    return 'warning'
  if (stat === 'out of order')
    return 'error'
  if (stat === 'workshop')
    return 'warning'
  
  return 'primary'
}

const localContractData = ref((props.contractData))

//SECTION Declaration
const route = useRoute()
const contractListStore = useContractListStore()
const searchQuery = ref('')
const totalPage = ref(1)
const totalEquipments = ref(0)
const equipments = ref([])
const equipmentData = ref([])
const workshopId = ref('')
const workshopData = ref({})



const options = ref({
  page: 1,
  itemsPerPage: 10,
  sortBy: [],
  groupBy: [],
  search: undefined,
})

const isViewEquipmentDialogVisible = ref(false)

//!SECTION Declaration
const paginationMeta = computed(() => {
  return (options, total) => {
    const start = (options.page - 1) * options.itemsPerPage + 1
    const end = Math.min(options.page * options.itemsPerPage, total)
    
    return `Showing ${start} to ${end} of ${total} entries`
  }
})

onMounted(() => {
  fetchWorkshop()
})

const fetchWorkshop = () => {
  return contractListStore
    .fetchWorkshop(Number(route.params.id))
    .then(response => {
      workshopData.value = response.data.data
      workshopId.value = workshopData.value.id
      fetchInspectedEquipments()
    })
    .catch(error => {
      console.error(error)
    })
}

// 👉 Fetching equipments
const fetchInspectedEquipments = () => {
  contractListStore.fetchInspectedWorkshopEquipments({
    id: workshopId.value,
    search: searchQuery.value,
    options: options.value,
  }).then(response => {
    console.log('Function called')
    equipments.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalEquipments.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
  }).catch(error => {
    console.error(error)
  })
}

// Function to parse maintenance data
const parsedMaintenance = maintenance => {
  try {
    return JSON.parse(maintenance)
  } catch (error) {
    return []
  }
}

// Function to parse additional maintenance data
const parsedAdditionalMaintenance = additionalMaintenance => {
  try {
    return JSON.parse(additionalMaintenance)
  } catch (error) {
    return []
  }
}

// Function to parse supply data
const parsedSupply = supply => {
  try {
    return JSON.parse(supply)
  } catch (error) {
    return []
  }
}
</script>

<template>
  <section>
    <VRow>
      <VCol cols="12">
        <VCard title="Performed Tasks">
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
            </div>
          </VCardText>
          <!-- !SECTION - Table Tools -->

          <!-- SECTION dataTable -->
          <VDataTableServer
            v-model:items-per-page="options.itemsPerPage"
            v-model:page="options.page"
            :items="equipments"
            :items-length="totalEquipments"
            :headers="equipmentHeaders"
            class="text-no-wrap"
            @update:options="options = $event"
          >
            <!-- 👉 Equipment Title -->
            <template #[`item.equipment`]="{ item }">
              <div class="d-flex align-center">
                <div class="d-flex flex-column">
                  <h6 class="text-base text-uppercase">
                    {{ item.raw.qrc_id }} | {{ item.raw.internal_id }} <span class="text-sm text-medium-emphasis">{{ item.raw.equipment_category }} {{ item.raw.equipment_model }} {{ item.raw.equipment_weight }} {{ item.raw.equipment_pressure }}</span>
                  </h6>
                </div>
              </div>
              <div class="ga-0">
                <div class="d-flex align-center mb-0">
                  <span class="text-sm text-medium-emphasis font-weight-medium me-1 text-uppercase">Inspection:</span>
                  <VIcon
                    v-if="item.raw.pivot.inspection === 'inspected'"
                    class="me-2"
                    size="16"
                    color="success"
                    icon="tabler-square-check-filled"
                  />
                  <VIcon
                    v-else
                    class="me-2"
                    size="16"
                    color="error"
                    icon="tabler-square-x-filled"
                  />
                  <span class="text-sm text-medium-emphasis font-weight-medium me-1 text-uppercase">Raw Material Charged:</span>
                  <VIcon
                    v-if="item.raw.pivot.raw_recharge === 'raw charged'"
                    class="me-2"
                    size="16"
                    color="success"
                    icon="tabler-square-check-filled"
                  />
                  <VIcon
                    v-else
                    class="me-2"
                    size="16"
                    color="error"
                    icon="tabler-square-x-filled"
                  />
                  <span class="text-sm text-medium-emphasis font-weight-medium me-1 text-uppercase">Nitrogen Charged:</span>
                  <VIcon
                    v-if="item.raw.pivot.nitrogen_recharge === 'nitrogen charged'"
                    class="me-2"
                    size="16"
                    color="success"
                    icon="tabler-square-check-filled"
                  />
                  <VIcon
                    v-else
                    class="me-2"
                    size="16"
                    color="error"
                    icon="tabler-square-x-filled"
                  />
                </div>
                <div class="d-flex align-center mb-0">
                  <span
                    v-if="item.raw.pivot.standard_sign === 'available'"
                    class="text-sm text-medium-emphasis font-weight-medium me-0 text-uppercase"
                  >Sign:</span>
                  <VIcon
                    v-if="item.raw.pivot.standard_sign === 'available'"
                    class="me-2"
                    size="16"
                    color="success"
                    icon="tabler-square-check-filled"
                  />
                  <span
                    v-if="item.raw.pivot.pictogram === 'available'"
                    class="text-sm text-medium-emphasis font-weight-medium me-0 text-uppercase"
                  >Pictogram:</span>
                  <VIcon
                    v-if="item.raw.pivot.pictogram === 'available'"
                    class="me-2"
                    size="16"
                    color="success"
                    icon="tabler-square-check-filled"
                  />
                  <span
                    v-if="item.raw.pivot.numbering === 'available'"
                    class="text-sm text-medium-emphasis font-weight-medium me-0 text-uppercase"
                  >Numbering:</span>
                  <VIcon
                    v-if="item.raw.pivot.numbering === 'available'"
                    class="me-2"
                    size="16"
                    color="success"
                    icon="tabler-square-check-filled"
                  />
                  <span
                    v-if="item.raw.pivot.equipment_fixation === 'available'"
                    class="text-sm text-medium-emphasis font-weight-medium me-1"
                  >Fixation:</span>
                  <VIcon
                    v-if="item.raw.pivot.equipment_fixation === 'available'"
                    class="me-2"
                    size="16"
                    color="success"
                    icon="tabler-square-check-filled"
                  />
                  <span
                    v-if="item.raw.pivot.accessories === 'cover'"
                    class="text-sm text-medium-emphasis font-weight-medium me-1"
                  >Cover:</span>
                  <VIcon
                    v-if="item.raw.pivot.accessories === 'cover'"
                    class="me-2"
                    size="16"
                    color="success"
                    icon="tabler-square-check-filled"
                  />
                  <span
                    v-if="item.raw.pivot.accessories === 'box'"
                    class="text-sm text-medium-emphasis font-weight-medium me-1"
                  >Cover:</span>
                  <VIcon
                    v-if="item.raw.pivot.accessories === 'box'"
                    class="me-2"
                    size="16"
                    color="success"
                    icon="tabler-square-check-filled"
                  />
                </div>
                <div
                  v-if="(item.raw.pivot.maintenance && item.raw.pivot.maintenance.length > 0 && item.raw.pivot.maintenance !== '[]') || 
                    (item.raw.pivot.additional_maintenance && item.raw.pivot.additional_maintenance.length > 0 && item.raw.pivot.additional_maintenance !== '[]')"
                  class="d-flex align-center mb-0  overflow-x-auto" 
                >
                  <span class="text-sm text-medium-emphasis   font-weight-medium me-1 text-uppercase d-inline-flex align-center">Tasks:</span>
                  <VChipGroup class="d-inline-flex align-center">
                    <VChip
                      v-for="maintenance in parsedMaintenance(item.raw.pivot.maintenance)"
                      :key="maintenance"
                      label
                      x-small
                      class="text-sm text-medium-emphasis mb-0 me-1 text-uppercase"
                    >
                      {{ maintenance }}
                    </VChip>
                    <VChip
                      v-for="additionalMaintenance in parsedAdditionalMaintenance(item.raw.pivot.additional_maintenance)"
                      :key="additionalMaintenance"
                      label
                      x-small
                      class="text-sm text-medium-emphasis mb-0 me-1 text-uppercase"
                    >
                      {{ additionalMaintenance }}
                    </VChip>
                  </VChipGroup>
                </div>  
                <div
                  v-if="item.raw.pivot.supply && item.raw.pivot.supply.length > 0 && item.raw.pivot.supply !== '[]'"
                  class="d-flex align-center mb-0 overflow-x-auto"
                >
                  <span class="text-sm text-medium-emphasis font-weight-medium me-1 text-uppercase d-inline-flex align-center">Supply:</span>
                  <VChipGroup class="d-inline-flex align-center">
                    <VChip
                      v-for="supply in parsedSupply(item.raw.pivot.supply)"
                      :key="supply"
                      label
                      x-small
                      class="text-sm text-medium-emphasis mb-0 me-1 text-uppercase"
                    >
                      {{ supply }}
                    </VChip>
                  </VChipGroup>
                </div>
              </div>
            </template>
            <!-- 👉 Status -->
            <template #[`item.equipment_status`]="{ item }">
              <VChip
                :color="resolveEquipmentStatusVariant(item.raw.pivot.equipment_status)"
                size="small"
                label
                class="text-capitalize"
              >
                {{ item.raw.pivot.equipment_status }}
              </VChip>
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
  </section>
</template>
../useContractListStore
