<script setup>
import {
  decimalValidator,
  requiredValidator,
} from '@validators'
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import { useEquipmentParamsStore } from './useEquipmentParamsStore'

const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  weightHeaders: {
    type: Array,
    required: true,
  },
})

const emit = defineEmits([
  'update:isDialogVisible',
  'update:weights',
])

const emitWeights = () => {
  emit('update:weights', weights.value)
}

const items = [
  'kg',
  'L',
  'g',
  'lb',
  'oz',
  'mL',
  'gal',
]


//!SECTION UI
//SECTION Declaration
const equipmentParamsStore = useEquipmentParamsStore()
const searchQuery = ref('')
const totalPage = ref(1)
const totalWeights = ref(0)
const weights = ref([])

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

const weightData = ref({
  weight_id: '',
  value: '',
  unit: '',
})

const resetForm = () => {
  weightData.value ={
    weight_id: '',
    value: '',
    unit: '',
  }
}

// 👉 Fetching weights
const fetchWeights = () => {
  equipmentParamsStore.fetchWeights({
    search: searchQuery.value,
    options: options.value,
  }).then(response => {
    weights.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalWeights.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
    emitWeights()
  }).catch(error => {
    console.error(error)
  })
}

// 👉 Add Weight
const addWeight = async weightData => {
  try {
    const response = await equipmentParamsStore.addWeight(weightData)

    if (response.status === 201) {
      fetchWeights()
    } else {
      throw new Error(`Failed to create weight: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Delete Weight
const deleteWeight = id => {
  equipmentParamsStore.deleteWeight(id)
    .then(response => {
      console.log(response.data)
      fetchWeights()
    })
    .catch(error => {
      console.error('Error deleting weight:', error)
    })
}

const onFormSubmit = () => {
  console.log('weightData:', weightData.value)
  addWeight(weightData.value)
  resetForm()
}

watchEffect(fetchWeights)
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
          Weights
        </VCardTitle>
      </VCardItem>
      <VCardText class="mt-6">
        <VRow>
          <VCol cols="12">
            <VCard title="Add New Weight">
              <VCardText class="mt-6">
                <VForm
                  class="mt-4"
                  @submit.prevent="onFormSubmit"
                >
                  <VRow>
                    <VCol cols="3">
                      <VTextField 
                        v-model="weightData.weight_id"
                        label="Weight ID"
                      />
                    </VCol>
                    <VCol cols="3">
                      <VTextField 
                        v-model="weightData.value"
                        :rules="[requiredValidator, decimalValidator]"
                        label="Weight Value"
                      />
                    </VCol>
                    <VCol cols="3">
                      <VAutocomplete
                        v-model="weightData.unit"
                        variant="outlined"
                        :items="items"
                        label="Unit"
                      />
                    </VCol>
                    <VCol cols="3">
                      <VBtn type="submit">
                        Add New Weight
                      </VBtn>
                    </VCol>
                  </VRow>
                </VForm>
              </VCardText>
            </VCard>
          </VCol>
        </VRow>
        <VRow>
          <VCol cols="12">
            <VCard title="Weights List">
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
                :items="weights"
                :items-length="totalWeights"
                :headers="weightHeaders"
                class="text-no-wrap"
                @update:options="options = $event"
              >
                <!-- 👉 Actions -->
                <template #[`item.actions`]="{ item }">
                  <IconBtn @click="deleteWeight(item.raw.id)">
                    <VIcon icon="tabler-trash" />
                  </IconBtn>
                </template>

                <!-- 👉 pagination -->
                <template #bottom>
                  <VDivider />
                  <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                    <p class="text-sm text-disabled mb-0">
                      {{ paginationMeta(options, totalWeights) }}
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
