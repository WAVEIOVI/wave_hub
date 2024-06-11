<script setup>
import { useInterventionListStore } from '../useInterventionListStore'
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import EditEquipmentDialog from './park-dialog-statistics/EditEquipmentDialog.vue'
import ViewEquipmentDialog from './park-dialog-statistics/ViewEquipmentDialog.vue'
import { avatarText } from '@core/utils/formatters'

const props = defineProps({
  equipmentHeaders: {
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

//SECTION Declaration
const route = useRoute()
const interventionListStore = useInterventionListStore()
const searchQuery = ref('')
const totalPage = ref(1)
const totalEquipments = ref(0)
const equipments = ref([])
const equipmentData = ref([])

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

// 👉 Fetching equipments
const fetchInspectedEquipments = () => {
  interventionListStore.fetchInspectedEquipments({
    id: Number(route.params.id),
    search: searchQuery.value,
    status: 'workshop',
    options: options.value,
  }).then(response => {
    equipments.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalEquipments.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
  }).catch(error => {
    console.error(error)
  })
}

// 👉 Fetch Inspected Equipment
const fetchInspectedEquipment = equipmentId => {
  interventionListStore.fetchInspectedEquipment(Number(route.params.id), equipmentId)
    .then(response => {
      equipmentData.value = response.data.data
    }).catch(error => {
      console.error(error)
    })
}

watchEffect(fetchInspectedEquipments)


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
    <ViewEquipmentDialog
      v-model:isDialogVisible="isViewEquipmentDialogVisible"
      :equipment-data="equipmentData"
    />
    <VRow>
      <VCol cols="12">
        <VCard title="Exit  Slip">
          <!-- SECTION - Table Tools -->
          <VCardText class="d-flex flex-wrap py-0 gap-0">
            <div class="app-user-search-filter d-flex align-center flex-wrap gap-0">
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
            </template>
            <!-- 👉 Status -->
            <template #[`item.equipment_status`]="{ item }">
              <VChip
                :color="resolveEquipmentStatusVariant(item.raw.pivot.equipment_status)"
                size="small"
                label
                class="text-capitalize"
                @click=" fetchInspectedEquipment(item.raw.id),
                         isViewEquipmentDialogVisible = !isViewEquipmentDialogVisible"
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
