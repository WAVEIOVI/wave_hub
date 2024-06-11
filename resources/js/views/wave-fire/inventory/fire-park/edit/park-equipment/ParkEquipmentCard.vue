<script setup>
import { useEquipmentParamsStore } from '@/views/config/inventory/useEquipmentParamsStore'
import { useParkListStore } from '@/views/wave-fire/inventory/fire-park/useParkListStore'
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import AddNewEquipmentDialog from './AddNewEquipmentDialog.vue'
import EditEquipmentDialog from './EditEquipmentDialog.vue'
import ViewEquipmentDialog from './ViewEquipmentDialog.vue'

const props = defineProps({
  equipmentHeaders: {
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
})

const emit = defineEmits([
  'refetchCharts',
])

const accessoryHeaders = [
  {
    title: 'accessory id',
    key: 'accessory_id',
  },
  {
    title: 'name',
    key: 'name',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

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

//!SECTION UI

//SECTION Declaration
const route = useRoute()
const router = useRouter()
const parkListStore = useParkListStore()
const equipmentParamsStore = useEquipmentParamsStore()
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

// 👉 Equipment Dialog
const isAddNewEquipmentDialogVisible = ref(false)
const isEditEquipmentDialogVisible = ref(false)
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
const fetchParkEquipments = () => {
  parkListStore.fetchParkEquipments({
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
}

// 👉 Fetch Park Equipment
const fetchParkEquipment = equipmentId => {
  parkListStore.fetchParkEquipment(Number(route.params.id), equipmentId)
    .then(response => {
      equipmentData.value = response.data.data
    }).catch(error => {
      console.error(error)
    })
}

const accessories = ref([])

const addEquipment = async ({ equipmentData, accessories }) => {
  try {
    const response = await parkListStore.addParkEquipment(Number(route.params.id), equipmentData)
    if (response.status === 201) {
      const newEquipmentId = response.data.data.id // Ensure this ID is correctly retrieved

      await addNewAccessories(newEquipmentId, accessories)
      fetchParkEquipments()
      emit('refetchCharts')
    } else {
      throw new Error(`Failed to create equipment: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

const addNewAccessories = async (equipmentId, accessories) => {
  try {
    const formattedAccessories = accessories.map(id => ({ equipment_accessory_id: id })) // Format correctly
    const response = await parkListStore.addNewAccessories(equipmentId, formattedAccessories)
    if (response.status === 200) {
      console.log('Accessories Created')
    } else {
      throw new Error(`Failed to create accessories: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

const updateEquipment = async({ equipmentData, accessories }) => {
  const equipmentId = equipmentData.id
  try {
    const response = await parkListStore.updateParkEquipment(Number(route.params.id), equipmentId, equipmentData)
    if (response.status === 200) {
      fetchParkEquipments()
      emit('refetchCharts')
      await addNewAccessories(equipmentId, accessories)
      
    } else {
      throw new Error(`Failed to update park: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Delete Equipment
const deleteEquipment = equipmentId => {
  parkListStore.deleteParkEquipment(Number(route.params.id), equipmentId)
    .then(response => {
      console.log(response.data)
      fetchParkEquipments()
      emit('refetchCharts')
    })
    .catch(error => {
      console.error('Error deleting park:', error)
    })
}


const categoryOptions = ref([])

const fetchCategoriesOptions = () => {
  equipmentParamsStore
    .fetchCategoriesOptions()
    .then(response => {
      categoryOptions.value = response.data.data.map(category => ({
        title: category.name,
        value: category.category_id,
        id: category.id,
      }))
    })
    .catch(error => {
      console.error(error)
    })
}

const modelOptions = ref([])

const fetchModelsOptions = () => {
  equipmentParamsStore
    .fetchModelOptions()
    .then(response => {
      modelOptions.value = response.data.data.map(model => ({
        title: model.name,
        value: model.model_id,
      }))
    })
    .catch(error => {
      console.error(error)
    })
}

onMounted(() => {
  fetchCategoriesOptions()
  fetchModelsOptions()
}) 
watchEffect(fetchParkEquipments)
</script>

<template>
  <AddNewEquipmentDialog
    v-model:is-dialog-visible="isAddNewEquipmentDialogVisible"
    :areas="areas"
    @submit="addEquipment"
  />
  <EditEquipmentDialog
    v-model:isDialogVisible="isEditEquipmentDialogVisible"
    :equipment-data="equipmentData"
    :accessory-headers="accessoryHeaders"
    :areas="areas"
    @submit="updateEquipment"
  />
  <ViewEquipmentDialog
    v-model:isDialogVisible="isViewEquipmentDialogVisible"
    :areas="areas"
    :accessory-view-headers="accessoryViewHeaders"
    :equipment-data="equipmentData"
  />
  <section>
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
                :items="categoryOptions"
                item-title="title"
                item-value="title"
                clearable
                clear-icon="tabler-x"
              >
                <template #selection="{ item }">
                  <VChip>
                    <span>{{ item.title }}</span>
                  </VChip>
                </template>
              </AppSelect>
            </VCol>
            <!-- 👉 Select Model -->
            <VCol
              cols="12"
              sm="4"
            >
              <AppSelect
                v-model="selectedModel"
                label="Select Model"
                :items="modelOptions"
                item-title="title"
                item-value="title"
                clearable
                clear-icon="tabler-x"
              >
                <template #selection="{ item }">
                  <VChip>
                    <span>{{ item.title }}</span>
                  </VChip>
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

            <div class="app-user-search-filter d-flex align-center flex-wrap gap-4">
              <!-- 👉 Search  -->
              <div style="inline-size: 10rem;">
                <AppTextField
                  v-model="searchQuery"
                  placeholder="Search"
                  density="compact"
                />
              </div>

              <!-- 👉 Add user button -->
              <VBtn
                prepend-icon="tabler-plus"
                @click="isAddNewEquipmentDialogVisible = !isAddNewEquipmentDialogVisible"
              >
                Add New Equipment
              </VBtn>
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
                    <RouterLink
                      :to="{ name: 'contact-edit-client-id', params: { id: item.raw.id } }"
                      class="font-weight-medium user-list-name"
                    >
                      {{ item.raw.qrc_id }}
                    </RouterLink>
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
                    <RouterLink
                      :to="{ name: 'contact-edit-client-id', params: { id: item.raw.id } }"
                      class="font-weight-medium user-list-name text-uppercase"
                    >
                      {{ item.raw.equipment_area }}
                    </RouterLink>
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
                @click=" fetchParkEquipment(item.raw.id),
                         isViewEquipmentDialogVisible = !isViewEquipmentDialogVisible"
              >
                <VIcon icon="tabler-eye" />
              </IconBtn>

              <IconBtn 
                @click=" fetchParkEquipment(item.raw.id),
                         isEditEquipmentDialogVisible = !isEditEquipmentDialogVisible"
              >
                <VIcon icon="tabler-edit" />
              </IconBtn>

              <IconBtn @click="deleteEquipment(item.raw.id)">
                <VIcon icon="tabler-trash" />
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
  </section>
</template>
