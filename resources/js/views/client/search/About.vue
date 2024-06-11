<script setup>
import { useUserClientDashboardStore } from '@/stores/useUserClientDashboardStore'
import { StreamBarcodeReader } from "vue-barcode-reader"
import ViewEquipmentDialog from '../inventory/ViewEquipmentDialog.vue'

const props = defineProps({
  clientData: {
    type: Object,
    required: true,
  },
})

const clientDashboardStore = useUserClientDashboardStore()

const clientData = ref(props.clientData)
const clientName = computed(() => clientData.value.client_name) // Use client_name instead of id
const equipments = ref([])
const searchQuery = ref('') // Initialize with an empty string
const equipmentSingleData = ref([])
const isViewEquipmentDialogVisible = ref(false)

watch(
  () => props.clientData,
  newValue => {
    clientData.value = newValue
    fetchEquipments()
    console.log('clientData in child:', clientData.value)
  },
  { deep: true },
)

const searchMode = ref('')

const searchMethods = [
  {
    title: 'Search By QR Code ',
    value: 'qr_code_search',
    icon: {
      icon: 'tabler-scan',
      size: '28',
    },
  },
  {
    title: 'Simple Search',
    value: 'simple_search',
    icon: {
      icon: 'tabler-eye-search',
      size: '28',
    },
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


const fetchEquipments = () => {
  clientDashboardStore.fetchEquipmentsById({
    client: clientName.value, // Pass clientName instead of clientId
    search: searchQuery.value,
  })
    .then(response => {
      equipments.value = response.data.data.map(equipment => ({ ...equipment }))
      console.log(equipments.value)
    })
    .catch(error => {
      console.error(error)
    })
}

const fetchEquipment = () => {
  if (!searchQuery.value) return
  clientDashboardStore.fetchEquipment(searchQuery.value)
    .then(response => {
      equipmentSingleData.value = response.data.data
      console.log(equipmentSingleData.value)
    })
    .catch(error => {
      console.error(error)
    })
}

onMounted(fetchEquipments)

watch(
  () => searchQuery.value,
  fetchEquipment,
)

const onDecode = text => {
  console.log(`Decoded text from QR code: ${text}`)
  searchQuery.value = text // Set the decoded text to the variable
}

const onLoaded = () => {
  console.log("Ready to start scanning barcodes")
}
</script>

<template>
  <div>
    <ViewEquipmentDialog
      v-model:isDialogVisible="isViewEquipmentDialogVisible"
      :accessory-view-headers="accessoryViewHeaders"
      :equipment-single-data="equipmentSingleData"
    />
    <VCard class="mb-4">
      <VCardText>
        <h6 class="text-lg text-no-wrap font-weight-medium">
          Search for equipment! 🎉
        </h6>
        <VCol cols="12">
          <CustomRadiosWithIcon
            v-model:selected-radio="searchMode"
            :radio-content="searchMethods"
            :grid-column="{ sm: '6', cols: '12' }"
          />
        </VCol>
        <VCol v-if="searchMode === 'qr_code_search'">
          <VCardText>
            <VCol
              md="6"
              cols="12"
            >
              <StreamBarcodeReader
                @decode="onDecode"
                @loaded="onLoaded"
              />
            </VCol>
            <div v-if="searchQuery">
              <AppAutocomplete
                v-model="searchQuery"
                :items="equipments"
                clearable
                :item-title="item => item.qrc_id"
                item-value="id"
                clear-icon="tabler-x"
              >
                <template #item="{ props: itemProps, item }">  
                  <VListItem
                    v-bind="itemProps"
                    :subtitle="item.raw.equipment_category + ' - ' + item.raw.equipment_model + ' - ' + item.raw.equipment_weight_value + ' - ' + item.raw.equipment_weight_unit + ' - ' + item.raw.equipment_pressure"
                  />
                </template>
              </AppAutocomplete>
            </div>
          </VCardText>
        </VCol>
        <VCol
          v-if="searchMode === 'simple_search'"
          cols="12"
        >
          <h6 class="text-h6 my-4">
            Select Equipment
          </h6>
          <AppAutocomplete
            v-model="searchQuery"
            :items="equipments"
            clearable
            :item-title="item => item.qrc_id"
            item-value="id"
            clear-icon="tabler-x"
          >
            <template #item="{ props: itemProps, item }">  
              <VListItem
                v-bind="itemProps"
                :subtitle="item.raw.equipment_category + ' - ' + item.raw.equipment_model + ' - ' + item.raw.equipment_weight_value + ' - ' + item.raw.equipment_weight_unit + ' - ' + item.raw.equipment_pressure"
              />
            </template>
          </AppAutocomplete>
        </VCol>
        <VCol cols="12">
          <VCardText>
            <VBtn
              block
              @click=" fetchEquipment(searchQuery.value),
                       isViewEquipmentDialogVisible = !isViewEquipmentDialogVisible"
            >
              Search Equipment 
            </VBtn>
          </VCardText>
        </VCol>
      </VCardText>
    </VCard>
  </div>
</template>

<style lang="scss" scoped>
.card-list {
  --v-card-list-gap: 16px;
}
</style>
