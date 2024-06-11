<script setup>
import { useWorkshopListStore } from '../useWorkshopListStore'
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import EditEquipmentDialog from './park-dialog-statistics/EditEquipmentDialog.vue'
import ViewEquipmentDialog from './park-dialog-statistics/ViewEquipmentDialog.vue'
import { avatarText } from '@core/utils/formatters'

const props = defineProps({
  equipmentHeaders: {
    type: Array,
    required: true,
  },
  categories: {
    type: Array,
    required: true,
  },
  status: {
    type: Array,
    required: true,
  },
  areas: {
    type: Array,
    required: true,
  },
  models: {
    type: Array,
    required: true,
  },
  runFunction: {
    type: Function,
    required: true,
  },
  triggerChildFunction: {
    type: Boolean,
    required: true,
  },
  workshopData: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits([
  'update:triggerChildFunction',
])

const localWorkshopData = ref((props.workshopData))

const isReadOnly = computed(() => {
  return localWorkshopData.value.workshop_status === 'completed'
})

//SECTION UI
const resolveEquipmentCategoryVariant = type => {
  const typeLowerCase = type.toLowerCase()
  if (typeLowerCase === 'fire extinguisher')
    return {
      color: 'warning',
      icon: 'tabler-fire-extinguisher',
    }
  if (typeLowerCase === 'fire hose')
    return {
      color: 'warning',
      icon: 'tabler-firetruck',
    }
  if (typeLowerCase === 'fire hydrant')
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
  if (stat === 'workshop')
    return 'warning'
  
  return 'primary'
}

//!SECTION UI

//SECTION Declaration
const route = useRoute()
const router = useRouter()
const workshopListStore = useWorkshopListStore()
const searchQuery = ref('')
const selectedCategory = ref()
const selectedModel = ref()
const selectedStatus = ref()
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

const isEditEquipmentDialogVisible = ref(false)
const isViewEquipmentDialogVisible = ref(false)

// const isViewEquipmentDialogVisible = ref(false)

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
  workshopListStore.fetchInspectedEquipments({
    id: Number(route.params.id),
    search: searchQuery.value,
    options: options.value,
    status: selectedStatus.value,
    model: selectedModel.value,
    category: selectedCategory.value,
  }).then(response => {
    equipments.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalEquipments.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
  }).catch(error => {
    console.error(error)
  })
  
  emit('update:triggerChildFunction', false)
}

const runFunction = () => {
  if (props.runFunction) {
    fetchInspectedEquipments()
  } else {
    throw new Error(`Failed to fetch equipments`)
  }
}

// 👉 Fetch Inspected Equipment
const fetchInspectedEquipment = equipmentId => {
  workshopListStore.fetchInspectedEquipment(Number(route.params.id), equipmentId)
    .then(response => {
      equipmentData.value = response.data.data
    }).catch(error => {
      console.error(error)
    })
}

const updateInspectedEquipment = async equipmentData => {
  const equipmentId = equipmentData.id
  try {
    const response = await workshopListStore.updateInspectedEquipment(Number(route.params.id), equipmentId, equipmentData)
    if (response.status === 200) {
      fetchInspectedEquipments()
    } else {
      throw new Error(`Failed to update park: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Delete Equipment
const deleteEquipment = equipmentId => {
  workshopListStore.detachWorkshopEquipment(Number(route.params.id), equipmentId)
    .then(response => {
      console.log(response.data)
      fetchInspectedEquipments()
    })
    .catch(error => {
      console.error('Error deleting park:', error)
    })
}

watchEffect(fetchInspectedEquipments)
watch(() => props.triggerChildFunction, newValue => {
  if (newValue) {
    fetchInspectedEquipments()
  }
})

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

const shouldDisplayIconBtn = item => {
  const {
    maintenance,
    additional_maintenance,
    supply,
    standard_sign,
    numbering,
    Pictogram,
    equipment_fixation,
    accessories,
  } = item.raw.pivot

  const hasData = value => {
    if (typeof value === 'string') {
      return value !== '' && value !== '[]'
    } else if (Array.isArray(value)) {
      return value.length > 0
    }
    
    return false
  }

  return (
    hasData(maintenance) ||
    hasData(additional_maintenance) ||
    hasData(supply) ||
    hasData(standard_sign) ||
    hasData(numbering) ||
    hasData(Pictogram) ||
    hasData(equipment_fixation) ||
    hasData(accessories)
  )
}
</script>

<template>
  <section>
    <ViewEquipmentDialog
      v-model:isDialogVisible="isViewEquipmentDialogVisible"
      :equipment-data="equipmentData"
    />
    <EditEquipmentDialog
      v-model:isDialogVisible="isEditEquipmentDialogVisible"
      :equipment-data="equipmentData"
      @submit="updateInspectedEquipment"
    />
    <VRow>
      <VCol cols="12">
        <!-- SECTION - Filters -->
        <VCardText>
          <VRow>
            <!-- 👉 Select Category -->
            <VCol
              cols="12"
              sm="4"
            >
              <AppSelect
                v-model="selectedCategory"
                label="Select Category"
                :items="categories"
                clearable
                clear-icon="tabler-x"
              />
            </VCol>
            <!-- 👉 Select Model -->
            <VCol
              cols="12"
              sm="4"
            >
              <AppSelect
                v-model="selectedModel"
                label="Select Model"
                :items="models"
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
        <VCard title="Tasks">
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
            </div>
          </VCardText>
          <!-- !SECTION - Table Tools -->

          <VDivider />
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
            <template #[`item.equipment_id`]="{ item }">
              <div class="d-flex align-center">
                <div class="d-flex flex-column">
                  <h6 class="text-base">
                    {{ item.raw.qrc_id }} | {{ item.raw.internal_id }}
                  </h6>

                  <span class="text-sm text-medium-emphasis">{{ item.raw.equipment_category }} {{ item.raw.equipment_model }} {{ item.raw.equipment_weight }} {{ item.raw.equipment_pressure }}</span>
                </div>
              </div>
            </template>
            <!-- 👉 Inspection -->
            <template #[`item.inspection`]="{ item }">
              <div v-if="item.raw.pivot.inspection === 'inspected'">
                <VChip color="success">
                  <VIcon
                    size="16"
                    icon="tabler-square-check-filled"
                  />
                </VChip>
              </div>
            </template>
            <!-- 👉 raw_recharge -->
            <template #[`item.raw_recharge`]="{ item }">
              <div v-if="item.raw.pivot.raw_recharge === 'raw charged'">
                <VChip color="success">
                  <VIcon
                    size="16"
                    icon="tabler-square-check-filled"
                  />
                </VChip>
              </div>
            </template>
            <!-- 👉 nitrogen_recharge -->
            <template #[`item.nitrogen_recharge`]="{ item }">
              <div v-if="item.raw.pivot.nitrogen_recharge === 'nitrogen charged'">
                <VChip color="success">
                  <VIcon
                    size="16"
                    icon="tabler-square-check-filled"
                  />
                </VChip>
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
            <!-- 👉 Actions -->
            <template #[`item.actions`]="{ item }">
              <IconBtn v-if="shouldDisplayIconBtn(item)">
                <VIcon icon="tabler-info-circle" />
                <VTooltip
                  location="start"
                  activator="parent"
                  max-width="600"
                  max-height="400"
                >
                  <VCardText>
                    <VRow>
                      <VCol 
                        class="mt-0 pt-0"
                        cols="12"
                      >
                        <h4>
                          Tasks
                        </h4>
                      </VCol>
                      <VCol 
                        v-if="item.raw.pivot.maintenance && item.raw.pivot.maintenance.length > 0 && item.raw.pivot.maintenance !== '[]'"
                        class="mb-0 pb-0"
                        cols="12"
                      >
                        <h4>Maintenance</h4>
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
                        </VChipGroup>
                      </VCol>
                      <VCol
                        v-if="item.raw.pivot.additional_maintenance && item.raw.pivot.additional_maintenance.length > 0 && item.raw.pivot.additional_maintenance !== '[]'"
                        cols="12"
                        class="mb-0 pb-0"
                      >
                        <h4>Additional Maintenance</h4>
                        <VChipGroup class="d-inline-flex align-center">                        
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
                      </VCol>
                      <VCol
                        v-if="item.raw.pivot.supply && item.raw.pivot.supply.length > 0 && item.raw.pivot.supply !== '[]'"
                        cols="12"
                        class="mb-0 pb-0"
                      >
                        <h4>Supply</h4>
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
                      </VCol>
                      <VCol
                        v-if="item.raw.pivot.standard_sign && item.raw.pivot.standard_sign.length > 0"
                        class="mb-0 pb-0"
                        cols="6"
                      >
                        <h4>Standard Sign</h4>
                        <VChip
                          label
                          x-small
                          class="text-sm text-medium-emphasis mb-0 me-1 text-uppercase"
                        >
                          {{ item.raw.pivot.standard_sign }}
                        </VChip>
                      </VCol>
                      <VCol 
                        v-if="item.raw.pivot.numbering && item.raw.pivot.numbering.length > 0"
                        class="mb-0 pb-0"
                        cols="6"
                      >
                        <h4>Numbering</h4>
                        <VChip
                          label
                          x-small
                          class="text-sm text-medium-emphasis mb-0 me-1 text-uppercase"
                        >
                          {{ item.raw.pivot.numbering }}
                        </VChip>
                      </VCol>
                      <VCol 
                        v-if="item.raw.pivot.Pictogram && item.raw.pivot.Pictogram.length > 0"
                        class="mb-0 pb-0"
                        cols="6"
                      >
                        <h4>Pictogram</h4>
                        <VChip
                          label
                          x-small
                          class="text-sm text-medium-emphasis mb-0 me-1 text-uppercase"
                        >
                          {{ item.raw.pivot.Pictogram }}
                        </VChip>
                      </VCol>
                      <VCol
                        v-if="item.raw.pivot.equipment_fixation && item.raw.pivot.equipment_fixation.length > 0"
                        class="mb-0 pb-0"
                        cols="6"
                      >
                        <h4>Fixation</h4>
                        <VChip
                          label
                          x-small
                          class="text-sm text-medium-emphasis mb-0 me-1 text-uppercase"
                        >
                          {{ item.raw.pivot.equipment_fixation }}
                        </VChip>
                      </VCol>
                      <VCol
                        v-if="item.raw.pivot.accessories && item.raw.pivot.accessories.length > 0 && item.raw.pivot.accessories !== '[]'"
                        class="mb-0 pb-0"
                        cols="6"
                      >
                        <h4>Protection</h4>
                        <VChip
                          label
                          x-small
                          class="text-sm text-medium-emphasis mb-0 me-1 text-uppercase"
                        >
                          {{ item.raw.pivot.accessories }}
                        </VChip>
                      </VCol>
                    </VRow>
                  </VCardText>
                </VTooltip>
              </IconBtn>
              <IconBtn v-else />
              <IconBtn 
                @click=" fetchInspectedEquipment(item.raw.id),
                         isViewEquipmentDialogVisible = !isViewEquipmentDialogVisible"
              >
                <VIcon icon="tabler-eye" />
              </IconBtn>
              <VBtn
                :disabled="isReadOnly"
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
                    <VListItem 
                      link
                      @click=" fetchInspectedEquipment(item.raw.id),
                               isEditEquipmentDialogVisible = !isEditEquipmentDialogVisible"
                    >
                      <template #prepend>
                        <VIcon icon="tabler-pencil" />
                      </template>
                      <VListItemTitle>Edit</VListItemTitle>
                    </VListItem>

                    <VListItem @click="deleteEquipment(item.raw.id)">
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
