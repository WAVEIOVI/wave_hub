<script setup>
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import { useEquipmentParamsStore } from './useEquipmentParamsStore'

const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  pressureHeaders: {
    type: Array,
    required: true,
  },
})

const emit = defineEmits([
  'update:isDialogVisible',
  'update:pressures',
])


const emitPressures = () => {
  emit('update:pressures', pressures.value)
}


//!SECTION UI
//SECTION Declaration
const equipmentParamsStore = useEquipmentParamsStore()
const searchQuery = ref('')
const totalPage = ref(1)
const totalPressures = ref(0)
const pressures = ref([])

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

const pressureData = ref({
  pressure_id: '',
  name: '',
  description: '',
})

const resetForm = () => {
  pressureData.value ={
    pressure_id: '',
    name: '',
    description: '',
  }
}

// 👉 Fetching pressures
const fetchPressures = () => {
  equipmentParamsStore.fetchPressures({
    search: searchQuery.value,
    options: options.value,
  }).then(response => {
    pressures.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalPressures.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
    emitPressures() 
  }).catch(error => {
    console.error(error)
  })
}

// 👉 Add Pressure
const addPressure = async pressureData => {
  try {
    const response = await equipmentParamsStore.addPressure(pressureData)

    if (response.status === 201) {
      fetchPressures()
    } else {
      throw new Error(`Failed to create pressure: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Delete Pressure
const deletePressure = id => {
  equipmentParamsStore.deletePressure(id)
    .then(response => {
      console.log(response.data)
      fetchPressures()
    })
    .catch(error => {
      console.error('Error deleting pressure:', error)
    })
}

const onFormSubmit = () => {
  console.log('pressureData:', pressureData.value)
  addPressure(pressureData.value)
  resetForm()
}

watchEffect(fetchPressures)
</script>

<template>
  <VDialog
    :width="$vuetify.display.smAndDown ? 'auto' : 900"
    :model-value="props.isDialogVisible"
    @update:model-value="val => $emit('update:isDialogVisible', val)"
  >
    <!-- 👉 Dialog close btn -->
    <DialogCloseBtn @click="$emit('update:isDialogVisible', false)" />

    <VCard class="pa-sm-8 pa-5">
      <!-- 👉 Title -->
      <VCardItem class="text-center">
        <VCardTitle class="text-h3 mb-3">
          Pressures
        </VCardTitle>
      </VCardItem>
      <VCardText class="mt-6">
        <VRow>
          <VCol cols="12">
            <VCard title="Add New Pressure">
              <VCardText class="mt-6">
                <VForm
                  class="mt-4"
                  @submit.prevent="onFormSubmit"
                >
                  <VRow>
                    <VCol cols="3">
                      <VTextField 
                        v-model="pressureData.pressure_id"
                        label="Pressure ID"
                      />
                    </VCol>
                    <VCol cols="5">
                      <VTextField 
                        v-model="pressureData.name"
                        label="Pressure Name"
                      />
                    </VCol>
                    <VCol cols="4">
                      <VBtn type="submit">
                        Add New Pressure
                      </VBtn>
                    </VCol>
                    <VCol cols="12">
                      <VTextarea
                        v-model="pressureData.description"
                        rows="1"
                        variant="outlined"
                        label="Description"
                      />
                    </VCol>
                  </VRow>
                </VForm>
              </VCardText>
            </VCard>
          </VCol>
        </VRow>
        <VRow>
          <VCol cols="12">
            <VCard title="Pressures List">
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
                :items="pressures"
                :items-length="totalPressures"
                :headers="pressureHeaders"
                class="text-no-wrap"
                @update:options="options = $event"
              >
                <!-- 👉 Actions -->
                <template #[`item.actions`]="{ item }">
                  <IconBtn @click="deletePressure(item.raw.id)">
                    <VIcon icon="tabler-trash" />
                  </IconBtn>
                </template>

                <!-- 👉 pagination -->
                <template #bottom>
                  <VDivider />
                  <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                    <p class="text-sm text-disabled mb-0">
                      {{ paginationMeta(options, totalPressures) }}
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
      </VCardText>
    </VCard>
  </VDialog>
</template>
