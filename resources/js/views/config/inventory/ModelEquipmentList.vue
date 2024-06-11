<script setup>
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import AddNewModelDialog from './AddNewModelDialog.vue'
import EditModelDialog from './EditModelDialog.vue'
import { useEquipmentParamsStore } from './useEquipmentParamsStore'

const props = defineProps({
  accessories: {
    type: Array,
    required: true,
  },
  pressures: {
    type: Array,
    required: true,
  },
  protections: {
    type: Array,
    required: true,
  },
  weights: {
    type: Array,
    required: true,
  },
  categories: {
    type: Array,
    required: true,
  },
  maintenances: {
    type: Array,
    required: true,
  },
  additionalMaintenances: {
    type: Array,
    required: true,
  },
  supplies: {
    type: Array,
    required: true,
  },
})

const accessories = ref((props.accessories))
const pressures = ref((props.pressures))
const protections = ref((props.protections))
const weights = ref((props.weights))
const categories = ref((props.categories))
const supplies = ref((props.supplies))
const maintenances = ref((props.maintenances))
const additionalMaintenances = ref((props.additionalMaintenances))

const headers = [
  {
    title: 'Category ID',
    key: 'model_category_id',
  },
  {
    title: 'Category Name',
    key: 'category_name',
  },
  {
    title: 'Model Id',
    key: 'model_id',
  },
  {
    title: 'Model Name',
    key: 'name',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

//SECTION Declaration
const route = useRoute()
const equipmentParamsStore = useEquipmentParamsStore()
const searchQuery = ref('')
const totalPage = ref(1)
const totalModels = ref(0)
const models = ref([])
const fetchedModelData = ref([])
const modelId = ref()


const options = ref({
  page: 1,
  itemsPerPage: 10,
  sortBy: [],
  groupBy: [],
  search: undefined,
})

// 👉 Model Dialog
const isAddNewModelDialogVisible = ref(false)
const isEditModelDialogVisible = ref(false)

//!SECTION Declaration
const paginationMeta = computed(() => {
  return (options, total) => {
    const start = (options.page - 1) * options.itemsPerPage + 1
    const end = Math.min(options.page * options.itemsPerPage, total)
    
    return `Showing ${start} to ${end} of ${total} entries`
  }
})

// 👉 Fetching models
const fetchModels = () => {
  equipmentParamsStore.fetchModels({
    search: searchQuery.value,
    options: options.value,
  }).then(response => {
    models.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalModels.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
  }).catch(error => {
    console.error(error)
  })
}

// 👉 Add Model
const addModel = async modelData => {
  try {
    const response = await equipmentParamsStore.addModel(modelData)
    if (response.status === 201) {
      modelId.value = response.data.data.id
      fetchModel(modelId.value) // Call fetchModel with the new modelId
      fetchModels()
    } else {
      throw new Error(`Failed to create client: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}


// 👉 Fetch  Model
const fetchModel = id => {
  equipmentParamsStore.fetchModel(id)
    .then(response => {
      fetchedModelData.value = response.data.data
    }).catch(error => {
      console.error(error)
    })
}

const updateModel = async fetchedModelData => {
  const modelId = fetchedModelData.id
  try {

    const response = await equipmentParamsStore.updateModel( modelId, fetchedModelData)
    if (response.status === 200) {
      fetchModels()
    } else {
      throw new Error(`Failed to update Model: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Delete Model
const deleteModel = id => {
  equipmentParamsStore.deleteModel(id)
    .then(response => {
      console.log(response.data)
      fetchModels()
    })
    .catch(error => {
      console.error('Error deleting client:', error)
    })
}

watchEffect(fetchModels)

watch(
  () => props.accessories,
  newValue => {
    accessories.value = newValue
    console.log('accessories in child:', accessories.value)
  },
  { deep: true },
)
watch(
  () => props.pressures,
  newValue => {
    pressures.value = newValue
    console.log('pressures in child:', pressures.value)
  },
  { deep: true },
)
watch(
  () => props.protections,
  newValue => {
    protections.value = newValue
    console.log('protections in child:', protections.value)
  },
  { deep: true },
)
watch(
  () => props.weights,
  newValue => {
    weights.value = newValue
    console.log('weights in child:', weights.value)
  },
  { deep: true },
)
watch(
  () => props.categories,
  newValue => {
    categories.value = newValue
    console.log('categories in child:', categories.value)
  },
  { deep: true },
)
watch(
  () => props.maintenances,
  newValue => {
    maintenances.value = newValue
    console.log('maintenances in child:', maintenances.value)
  },
  { deep: true },
)
watch(
  () => props.additionalMaintenances,
  newValue => {
    additionalMaintenances.value = newValue
    console.log('additionalMaintenances in child:', additionalMaintenances.value)
  },
  { deep: true },
)
watch(
  () => props.supplies,
  newValue => {
    supplies.value = newValue
    console.log('supplies in child:', supplies.value)
  },
  { deep: true },
)
</script>

<template>
  <AddNewModelDialog
    v-model:isDialogVisible="isAddNewModelDialogVisible"
    :fetched-model-data="fetchedModelData"
    :accessories="accessories"
    :pressures="pressures"
    :protections="protections"
    :weights="weights"
    :categories="categories"
    :maintenances="maintenances"
    :additional-maintenances="additionalMaintenances"
    :supplies="supplies"
    @submit="addModel"
  />
  <EditModelDialog
    v-model:isDialogVisible="isEditModelDialogVisible"
    :fetched-model-data="fetchedModelData"
    :accessories="accessories"
    :pressures="pressures"
    :protections="protections"
    :weights="weights"
    :maintenances="maintenances"
    :additional-maintenances="additionalMaintenances"
    :supplies="supplies"
    @submit="updateModel"
  />
 
  <section>
    <VRow>
      <VCol cols="12">
        <VCard title="Models">
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
                @click="isAddNewModelDialogVisible = !isAddNewModelDialogVisible"
              >
                Add New Model
              </VBtn>
            </div>
          </VCardText>
          <!-- !SECTION - Table Tools -->

          <VDivider />
          <!-- SECTION dataTable -->
          <VDataTableServer
            v-model:items-per-page="options.itemsPerPage"
            v-model:page="options.page"
            :items="models"
            :items-length="totalModels"
            :headers="headers"
            class="text-no-wrap"
            @update:options="options = $event"
          >
            <!-- 👉 Actions -->
            <template #[`item.actions`]="{ item }">
              <IconBtn 
                @click=" fetchModel(item.raw.id),
                         isEditModelDialogVisible = !isEditModelDialogVisible"
              >
                <VIcon icon="tabler-edit" />
              </IconBtn>

              <IconBtn @click="deleteModel(item.raw.id)">
                <VIcon icon="tabler-trash" />
              </IconBtn>
            </template>

            <!-- 👉 pagination -->
            <template #bottom>
              <VDivider />
              <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                <p class="text-sm text-disabled mb-0">
                  {{ paginationMeta(options, totalModels) }}
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

<style lang="scss">
.text-capitalize {
  text-transform: capitalize;
}

.user-list-name:not(:hover) {
  color: rgba(var(--v-theme-on-background), var(--v-medium-emphasis-opacity));
}
</style>
