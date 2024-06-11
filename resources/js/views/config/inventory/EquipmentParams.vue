<script setup>
import girlUsingMobile from '@images/pages/girl-using-mobile.png'
import AddAccessoryDialog from './AddAccessoryDialog.vue'
import AddCategoryDialog from './AddCategoryDialog.vue'
import AddNewAdditionalMaintenanceDialog from './AddNewAdditionalMaintenanceDialog.vue'
import AddNewMaintenanceDialog from './AddNewMaintenanceDialog.vue'
import AddNewSupplyDialog from './AddNewSupplyDialog.vue'
import AddPressureDialog from './AddPressureDialog.vue'
import AddProtectionDialog from './AddProtectionDialog.vue'
import AddWeightDialog from './AddWeightDialog.vue'


const emit = defineEmits([
  'update:accessories',
  'update:pressures',
  'update:protections',
  'update:weights',
  'update:categories',
  'update:maintenances',
  'update:additionalMaintenances',
  'update:supplies',
])

const isAddCategoryDialogVisible = ref(false)
const isAddWeightDialogVisible = ref(false)
const isAddAccessoryDialogVisible = ref(false)
const isAddPressureDialogVisible = ref(false)
const isAddProtectionDialogVisible = ref(false)
const isAddNewMaintenanceDialogVisible = ref(false)
const isAddNewAdditionalMaintenanceDialogVisible = ref(false)
const isAddNewSupplyDialogVisible = ref(false)

// 👉 Headers
const headers = [
  {
    title: 'category id',
    key: 'category_id',
  },
  {
    title: 'name',
    key: 'name',
  },
  {
    title: 'description',
    key: 'description',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

const weightHeaders = [
  {
    title: 'weight id',
    key: 'weight_id',
  },
  {
    title: 'value',
    key: 'value',
  },
  {
    title: 'unit',
    key: 'unit',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

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
    title: 'description',
    key: 'description',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

const pressureHeaders = [
  {
    title: 'pressure id',
    key: 'pressure_id',
  },
  {
    title: 'name',
    key: 'name',
  },
  {
    title: 'description',
    key: 'description',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

const protectionHeaders = [
  {
    title: 'protection id',
    key: 'protection_id',
  },
  {
    title: 'name',
    key: 'name',
  },
  {
    title: 'description',
    key: 'description',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

const maintenanceHeaders = [
  {
    title: 'maintenance id',
    key: 'maintenance_id',
  },
  {
    title: 'name',
    key: 'name',
  },
  {
    title: 'description',
    key: 'description',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

const additionalMaintenanceHeaders = [
  {
    title: 'additional maintenance id',
    key: 'additional_maintenance_id',
  },
  {
    title: 'name',
    key: 'name',
  },
  {
    title: 'description',
    key: 'description',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

const supplyHeaders = [
  {
    title: 'supply id',
    key: 'supply_id',
  },
  {
    title: 'name',
    key: 'name',
  },
  {
    title: 'description',
    key: 'description',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]
</script>

<template>
  <AddCategoryDialog
    v-model:isDialogVisible="isAddCategoryDialogVisible"
    :headers="headers"
    @update:categories="emit('update:categories', $event)"
  />
  <AddWeightDialog
    v-model:isDialogVisible="isAddWeightDialogVisible"
    :weight-headers="weightHeaders"
    @update:weights="emit('update:weights', $event)"
  />
  <AddAccessoryDialog
    v-model:isDialogVisible="isAddAccessoryDialogVisible"
    :accessory-headers="accessoryHeaders"
    @update:accessories="emit('update:accessories', $event)"
  />
  <AddPressureDialog
    v-model:isDialogVisible="isAddPressureDialogVisible"
    :pressure-headers="pressureHeaders"
    @update:pressures="emit('update:pressures', $event)"
  />
  <AddProtectionDialog
    v-model:isDialogVisible="isAddProtectionDialogVisible"
    :protection-headers="protectionHeaders"
    @update:protections="emit('update:protections', $event)"
  />
  <AddNewMaintenanceDialog
    v-model:isDialogVisible="isAddNewMaintenanceDialogVisible"
    :maintenance-headers="maintenanceHeaders"
    @update:maintenances="emit('update:maintenances', $event)"
  />
  <AddNewAdditionalMaintenanceDialog
    v-model:isDialogVisible="isAddNewAdditionalMaintenanceDialogVisible"
    :additional-maintenance-headers="additionalMaintenanceHeaders"
    @update:additional-maintenances="emit('update:additionalMaintenances', $event)"
  />
  <AddNewSupplyDialog
    v-model:isDialogVisible="isAddNewSupplyDialogVisible"
    :supply-headers="supplyHeaders"
    @update:supplies="emit('update:supplies', $event)"
  />
  <VRow class="match-height">
    <!-- 👉 Add New Category -->
    <VCol
      cols="12"
      sm="6"
      lg="4"
    >
      <VCard
        class="h-100"
        :ripple="false"
        @click="isAddCategoryDialogVisible = !isAddCategoryDialogVisible"
      >
        <VRow
          no-gutters
          class="h-100"
        >
          <VCol
            cols="5"
            class="d-flex flex-column justify-end align-center mt-5"
          >
            <img
              width="85"
              :src="girlUsingMobile"
            >
          </VCol>

          <VCol cols="7">
            <VCardText
              class="d-flex flex-column align-end justify-end gap-2 h-100"
              style="text-align: end;"
            >
              <VBtn>Add New Category</VBtn>
              <span>Add category, if it doesn't exist.</span>
            </VCardText>
          </VCol>
        </VRow>
      </VCard>
    </VCol>
    <!-- 👉 Add New Accessory -->
    <VCol
      cols="12"
      sm="6"
      lg="4"
    >
      <VCard>
        <VCardText class="d-flex flex-column gap-2">
          <VBtn
            variant="outlined"
            @click="isAddAccessoryDialogVisible = !isAddAccessoryDialogVisible"
          >
            <VIcon
              start
              icon="tabler-tie"
            />Add New Accessory
          </VBtn>
        </VCardText>
        <VCardText class="d-flex flex-column gap-2">
          <VBtn
            variant="outlined"
            @click="isAddProtectionDialogVisible = !isAddProtectionDialogVisible"
          >
            <VIcon
              start
              icon="tabler-shield"
            />Add New Protection
          </VBtn>
        </VCardText>
      </VCard>
    </VCol>
    <VCol
      cols="12"
      sm="6"
      lg="4"
    >
      <VCard>
        <VCardText class="d-flex flex-column gap-2">
          <VBtn
            variant="outlined"
            @click="isAddWeightDialogVisible = !isAddWeightDialogVisible"
          >
            <VIcon
              start
              icon="tabler-weight"
            />
            Add New Weight
          </VBtn>
        </VCardText>
        <VCardText class="d-flex flex-column gap-2">
          <VBtn
            variant="outlined"
            @click="isAddPressureDialogVisible = !isAddPressureDialogVisible"
          >
            <VIcon
              start
              icon="tabler-air-balloon"
            />
            Add New Pressure
          </VBtn>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
  <VRow class="match-height">
    <!-- 👉 Add New Maintenance -->
    <VCol
      cols="12"
      sm="6"
      lg="4"
    >
      <VCard>
        <VCardText class="d-flex flex-column gap-2">
          <VBtn
            variant="outlined"
            @click="isAddNewMaintenanceDialogVisible = !isAddNewMaintenanceDialogVisible"
          >
            <VIcon
              start
              icon="tabler-tool"
            />
            Add New Maintenance
          </VBtn>
        </VCardText>
      </VCard>
    </VCol>
    <VCol
      cols="12"
      sm="6"
      lg="4"
    >
      <VCard>
        <VCardText class="d-flex flex-column gap-2">
          <VBtn
            variant="outlined"
            @click="isAddNewAdditionalMaintenanceDialogVisible = !isAddNewAdditionalMaintenanceDialogVisible"
          >
            <VIcon
              start
              icon="tabler-tool"
            />
            Add New Add. Maintenance
          </VBtn>
        </VCardText>
      </VCard>
    </VCol>
    <VCol
      cols="12"
      sm="6"
      lg="4"
    >
      <VCard>
        <VCardText class="d-flex flex-column gap-2">
          <VBtn
            variant="outlined"
            @click="isAddNewSupplyDialogVisible = !isAddNewSupplyDialogVisible"
          >
            <VIcon
              start
              icon="tabler-checkup-list"
            />
            Add New Supply
          </VBtn>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>
