<script setup>
import EquipmentParams from '@/views/config/inventory/EquipmentParams.vue'
import ModelEquipmentList from '@/views/config/inventory/ModelEquipmentList.vue'

const receivedAccessories = ref([])
const receivedPressures = ref([])
const receivedProtections = ref([])
const receivedWeights = ref([])
const receivedCategories = ref([])
const receivedSupplies = ref([])
const receivedMaintenances = ref([])
const receivedAdditionalMaintenances = ref([])
</script>

<template>
  <VRow>
    <VCol cols="12">
      <h4 class="text-h4 mb-0">
        Equipment Params
      </h4>
    </VCol>

    <!-- 👉 EquipmentParams -->
    <VCol cols="12">
      <EquipmentParams
        @update:accessories="receivedAccessories = $event"
        @update:pressures="receivedPressures = $event"
        @update:protections="receivedProtections = $event"
        @update:weights="receivedWeights = $event"
        @update:categories="receivedCategories = $event"
        @update:supplies="receivedSupplies = $event"
        @update:maintenances="receivedMaintenances = $event"
        @update:additional-maintenances="receivedAdditionalMaintenances = $event"
      />
    </VCol>
    <VCol cols="12">
      <ModelEquipmentList
        :accessories="receivedAccessories"
        :pressures="receivedPressures"
        :protections="receivedProtections"
        :weights="receivedWeights"
        :categories="receivedCategories"
        :supplies="receivedSupplies"
        :maintenances="receivedMaintenances"
        :additional-maintenances="receivedAdditionalMaintenances"
      />
    </VCol>
  </VRow>
</template>
