<script setup>
import { useContractListStore } from '../useContractListStore'
import { avatarText } from '@core/utils/formatters'

const props = defineProps({
  contractData: {
    type: Array,
    required: true,
  },
})

const localContractData = ref((props.contractData))

//SECTION Declaration

const panel = ref(0)

const route = useRoute()
const contractListStore = useContractListStore()
const interventionId = ref('')
const interventionData = ref({})
const totalEquipment = ref()
const totalFireExtinguisher = ref()
const totalFireHose = ref()
const othersEquipment = ref()
const categoryChart = ref({})
const categoriesLabels = ref({})
const categoriesSeries = ref({})
const fireExtinguisherModelChart = ref({})
const fireExtinguisherModelLabels = ref({})
const fireExtinguisherModelSeries = ref({})
const statusChart = ref({})
const statusLabels = ref({})
const statusSeries = ref({})
const totalInspectedEquipment = ref()
const totalInspectedFireExtinguisher = ref()
const totalInspectedFireHose = ref()
const totalInspectedOthersEquipment = ref()
const nitrogenRecharge = ref()
const rechargedSparklet = ref()
const rechargeRaw = ref()
const rechargeRawModelWeight = ref({})
const rechargeRawModelWeightLabels = ref({})
const rechargeRawModelWeightSeries = ref({})
const inspectedFireExtinguisherModelWeight = ref({})
const inspectedFireExtinguisherModelWeightLabels = ref({})
const inspectedFireExtinguisherModelWeightSeries = ref({})
const standardSignEquipment = ref()
const numberedEquipment = ref()
const pictogramEquipment = ref()
const fixedEquipment = ref()
const boxEquipment = ref()
const coverEquipment = ref()
const supply = ref({})
const supplyLabels = ref({})
const supplySeries = ref({})
const maintenance = ref({})
const maintenanceLabels = ref({})
const maintenanceSeries = ref({})
const additionalMaintenance = ref({})
const additionalMaintenanceLabels = ref({})
const additionalMaintenanceSeries = ref({})
const standardSignExtinguisherModelWeight = ref({})
const standardSignExtinguisherModelWeightLabels = ref({})
const standardSignExtinguisherModelWeightSeries = ref({})
const pictogramExtinguisherModelWeight = ref({})
const pictogramExtinguisherModelWeightLabels = ref({})
const pictogramExtinguisherModelWeightSeries = ref({})
const fixedExtinguisherModelWeight = ref({})
const fixedExtinguisherModelWeightLabels = ref({})
const fixedExtinguisherModelWeightSeries = ref({})

const coverExtinguisherModelWeight = ref({})
const coverExtinguisherModelWeightLabels = ref({})
const coverExtinguisherModelWeightSeries = ref({})

const coverFireHose = ref({})
const coverFireHoseLabels = ref({})
const coverFireHoseSeries = ref({})

const boxExtinguisherModelWeight = ref({})
const boxExtinguisherModelWeightLabels = ref({})
const boxExtinguisherModelWeightSeries = ref({})

const boxFireHose = ref({})
const boxFireHoseLabels = ref({})
const boxFireHoseSeries = ref({})

const maintenanceExtinguisherModelWeight = ref({})
const maintenanceExtinguisherModelWeightLabels = ref({})
const maintenanceExtinguisherModelWeightSeries = ref({})

const additionalMaintenanceFireExtinguisherWeight = ref({})
const additionalMaintenanceFireExtinguisherWeightLabels = ref({})
const additionalMaintenanceFireExtinguisherWeightSeries = ref({})

const supplyFireExtinguisherWeight = ref({})
const supplyFireExtinguisherWeightLabels = ref({})
const supplyFireExtinguisherWeightSeries = ref({})

const totalRawMaterialForFireExtinguishers = ref({})
const totalRawMaterialForFireExtinguishersLabels = ref({})
const totalRawMaterialForFireExtinguishersSeries = ref({})

const inspectedFireHoseModelWeight = ref({})
const inspectedFireHoseModelWeightLabels = ref({})
const inspectedFireHoseModelWeightSeries = ref({})

const maintenanceFireHose = ref({})
const maintenanceFireHoseLabels = ref({})
const maintenanceFireHoseSeries = ref({})

const additionalMaintenanceFireHose = ref({})
const additionalMaintenanceFireHoseLabels = ref({})
const additionalMaintenanceFireHoseSeries = ref({})

const supplyFireHoseCounts = ref({})
const supplyFireHoseCountsLabels = ref({})
const supplyFireHoseCountsSeries = ref({})
const standardSignFireHose = ref()
const pictogramFireHose = ref()
const fixedFireHose = ref()

const inspectedOthersEquipment = ref({})
const inspectedOthersEquipmentLabels = ref({})
const inspectedOthersEquipmentSeries = ref({})

const maintenanceOthersEquipment = ref({})
const maintenanceOthersEquipmentLabels = ref({})
const maintenanceOthersEquipmentSeries = ref({})

const additionalMaintenanceOthersEquipment = ref({})
const additionalMaintenanceOthersEquipmentLabels = ref({})
const additionalMaintenanceOthersEquipmentSeries = ref({})

const supplyOthersEquipmentCounts = ref({})
const supplyOthersEquipmentCountsLabels = ref({})
const supplyOthersEquipmentCountsSeries = ref({})

onMounted(() => {
  fetchIntervention()
})

const fetchIntervention = async () => {
  try {
    const response=await contractListStore
      .fetchIntervention(Number(route.params.id))

    interventionData.value=response.data.data
    interventionId.value=interventionData.value.id
    fetchInspectedEquipments()
  } catch(error) {
    console.error(error)
  }
}

// 👉 Fetching equipments
const fetchInspectedEquipments = () => {
  contractListStore.fetchMetaInspectedEquipments({
    id: interventionId.value,
  }).then(response => {
    totalEquipment.value = response.data.meta.total_equipment
    totalFireExtinguisher.value = response.data.meta.total_fire_extinguishers
    totalFireHose.value = response.data.meta.total_fire_hoses
    othersEquipment.value = response.data.meta.total_others_equipment
    categoryChart.value = response.data.meta.total_equipment_by_category
    categoriesLabels.value = Object.keys(categoryChart.value)
    categoriesSeries.value = Object.values(categoryChart.value)
    fireExtinguisherModelChart.value = response.data.meta.total_fire_extinguishers_by_model
    fireExtinguisherModelLabels.value = Object.keys(fireExtinguisherModelChart.value)
    fireExtinguisherModelSeries.value = Object.values(fireExtinguisherModelChart.value)
    statusChart.value = response.data.meta.equipment_by_status
    statusLabels.value = Object.keys(statusChart.value)
    statusSeries.value = Object.values(statusChart.value)
    totalInspectedEquipment.value = response.data.meta.inspected_equipment
    totalInspectedFireExtinguisher.value = response.data.meta.inspected_fire_extinguisher
    totalInspectedFireHose.value = response.data.meta.inspected_fire_hose
    totalInspectedOthersEquipment.value = response.data.meta.inspected_others_equipment
    nitrogenRecharge.value = response.data.meta.nitrogen_recharged_fire_extinguisher_count
    rechargedSparklet.value = response.data.meta.recharged_sparklet_count
    rechargeRaw.value = response.data.meta.raw_recharged_fire_extinguisher_count
    rechargeRawModelWeight.value = response.data.meta.raw_recharged_fire_extinguisher_by_model_weight
    rechargeRawModelWeightLabels.value = Object.keys(rechargeRawModelWeight.value)
    rechargeRawModelWeightSeries.value = Object.values(rechargeRawModelWeight.value)
    inspectedFireExtinguisherModelWeight.value = response.data.meta.inspected_fire_extinguisher_by_model_weight
    inspectedFireExtinguisherModelWeightLabels.value = Object.keys(inspectedFireExtinguisherModelWeight.value)
    inspectedFireExtinguisherModelWeightSeries.value = Object.values(inspectedFireExtinguisherModelWeight.value)
    standardSignEquipment.value = response.data.meta.standard_sign_equipment
    numberedEquipment.value = response.data.meta.numbered_equipment
    pictogramEquipment.value = response.data.meta.pictogram_equipment
    fixedEquipment.value = response.data.meta.fixed_equipment
    boxEquipment.value = response.data.meta.box_equipment
    coverEquipment.value = response.data.meta.cover_equipment
    supply.value = response.data.meta.supply_counts
    supplyLabels.value = Object.keys(supply.value)
    supplySeries.value = Object.values(supply.value)
    maintenance.value = response.data.meta.maintenance_counts
    maintenanceLabels.value = Object.keys(maintenance.value)
    maintenanceSeries.value = Object.values(maintenance.value)
    additionalMaintenance.value = response.data.meta.additional_maintenance_counts
    additionalMaintenanceLabels.value = Object.keys(additionalMaintenance.value)
    additionalMaintenanceSeries.value = Object.values(additionalMaintenance.value)
    standardSignExtinguisherModelWeight.value = response.data.meta.standard_sign_fire_extinguisher_by_model_weight
    standardSignExtinguisherModelWeightLabels.value = Object.keys(standardSignExtinguisherModelWeight.value)
    standardSignExtinguisherModelWeightSeries.value = Object.values(standardSignExtinguisherModelWeight.value)
    pictogramExtinguisherModelWeight.value = response.data.meta.pictogram_fire_extinguisher_by_model_weight
    pictogramExtinguisherModelWeightLabels.value = Object.keys(pictogramExtinguisherModelWeight.value)
    pictogramExtinguisherModelWeightSeries.value = Object.values(pictogramExtinguisherModelWeight.value)
    fixedExtinguisherModelWeight.value = response.data.meta.fixed_fire_extinguisher_by_model_weight
    fixedExtinguisherModelWeightLabels.value = Object.keys(fixedExtinguisherModelWeight.value)
    fixedExtinguisherModelWeightSeries.value = Object.values(fixedExtinguisherModelWeight.value)
    coverExtinguisherModelWeight.value = response.data.meta.cover_fire_extinguisher_by_model_weight
    coverExtinguisherModelWeightLabels.value = Object.keys(coverExtinguisherModelWeight.value)
    coverExtinguisherModelWeightSeries.value = Object.values(coverExtinguisherModelWeight.value)
    boxExtinguisherModelWeight.value = response.data.meta.box_fire_extinguisher_by_model_weight
    boxExtinguisherModelWeightLabels.value = Object.keys(boxExtinguisherModelWeight.value)
    boxExtinguisherModelWeightSeries.value = Object.values(boxExtinguisherModelWeight.value)
    maintenanceExtinguisherModelWeight.value = response.data.meta.maintenance_fire_extinguisher_counts
    maintenanceExtinguisherModelWeightLabels.value = Object.keys(maintenanceExtinguisherModelWeight.value)
    maintenanceExtinguisherModelWeightSeries.value = Object.values(maintenanceExtinguisherModelWeight.value)
    additionalMaintenanceFireExtinguisherWeight.value = response.data.meta.additional_maintenance_fire_extinguisher_counts
    additionalMaintenanceFireExtinguisherWeightLabels.value = Object.keys(additionalMaintenanceFireExtinguisherWeight.value)
    additionalMaintenanceFireExtinguisherWeightSeries.value = Object.values(additionalMaintenanceFireExtinguisherWeight.value)
    supplyFireExtinguisherWeight.value = response.data.meta.supply_fire_extinguisher_counts
    supplyFireExtinguisherWeightLabels.value = Object.keys(supplyFireExtinguisherWeight.value)
    supplyFireExtinguisherWeightSeries.value = Object.values(supplyFireExtinguisherWeight.value)
    totalRawMaterialForFireExtinguishers.value = response.data.meta.total_raw_material_for_fire_extinguishers
    totalRawMaterialForFireExtinguishersLabels.value = Object.keys(totalRawMaterialForFireExtinguishers.value)
    totalRawMaterialForFireExtinguishersSeries.value = Object.values(totalRawMaterialForFireExtinguishers.value)
    inspectedFireHoseModelWeight.value = response.data.meta.inspected_fire_hose_by_model_weight
    inspectedFireHoseModelWeightLabels.value = Object.keys(inspectedFireHoseModelWeight.value)
    inspectedFireHoseModelWeightSeries.value = Object.values(inspectedFireHoseModelWeight.value)
    maintenanceFireHose.value = response.data.meta.maintenance_fire_hose_counts
    maintenanceFireHoseLabels.value = Object.keys(maintenanceFireHose.value)
    maintenanceFireHoseSeries.value = Object.values(maintenanceFireHose.value)
    additionalMaintenanceFireHose.value = response.data.meta.additional_maintenance_fire_hose_counts
    additionalMaintenanceFireHoseLabels.value = Object.keys(additionalMaintenanceFireHose.value)
    additionalMaintenanceFireHoseSeries.value = Object.values(additionalMaintenanceFireHose.value)
    supplyFireHoseCounts.value = response.data.meta.supply_fire_hose_counts
    supplyFireHoseCountsLabels.value = Object.keys(supplyFireHoseCounts.value)
    supplyFireHoseCountsSeries.value = Object.values(supplyFireHoseCounts.value)
    standardSignFireHose.value = response.data.meta.standard_sign_fire_hose
    pictogramFireHose.value = response.data.meta.pictogram_fire_hose
    fixedFireHose.value = response.data.meta.fixed_fire_hose

    coverFireHose.value = response.data.meta.cover_fire_hose
    coverFireHoseLabels.value = Object.keys(coverFireHose.value)
    coverFireHoseSeries.value = Object.values(coverFireHose.value)

    boxFireHose.value = response.data.meta.box_fire_hose
    boxFireHoseLabels.value = Object.keys(boxFireHose.value)
    boxFireHoseSeries.value = Object.values(boxFireHose.value)

    inspectedOthersEquipment.value = response.data.meta.inspected_others_equipment
    inspectedOthersEquipmentLabels.value = Object.keys(inspectedOthersEquipment.value)
    inspectedOthersEquipmentSeries.value = Object.values(inspectedOthersEquipment.value)
    
    maintenanceOthersEquipment.value = response.data.meta.maintenance_others_equipment_counts
    maintenanceOthersEquipmentLabels.value = Object.keys(maintenanceOthersEquipment.value)
    maintenanceOthersEquipmentSeries.value = Object.values(maintenanceOthersEquipment.value)
    
    additionalMaintenanceOthersEquipment.value = response.data.meta.additional_maintenance_others_equipment_counts
    additionalMaintenanceOthersEquipmentLabels.value = Object.keys(additionalMaintenanceOthersEquipment.value)
    additionalMaintenanceOthersEquipmentSeries.value = Object.values(additionalMaintenanceOthersEquipment.value)
    
    supplyOthersEquipmentCounts.value = response.data.meta.supply_others_equipment_counts
    supplyOthersEquipmentCountsLabels.value = Object.keys(supplyOthersEquipmentCounts.value)
    supplyOthersEquipmentCountsSeries.value = Object.values(supplyOthersEquipmentCounts.value)
    
  }).catch(error => {
    console.error(error)
  })
}

const equipmentCount = computed(() => {
  if (totalEquipment.value === null || totalEquipment.value === undefined) {
    return null
  }

  // No need for type check since we know it's a number
  return totalEquipment.value
})

const fireExtinguisherCount = computed(() => {
  if (totalFireExtinguisher.value === null || totalFireExtinguisher.value === undefined) {
    return null
  }

  // No need for type check since we know it's a number
  return totalFireExtinguisher.value
})

const fireHoseCount = computed(() => {
  if (totalFireHose.value === null || totalFireHose.value === undefined) {
    return null
  }

  // No need for type check since we know it's a number
  return totalFireHose.value
})

const othersEquipmentCount = computed(() => {
  if (othersEquipment.value === null || othersEquipment.value === undefined) {
    return null
  }

  // No need for type check since we know it's a number
  return othersEquipment.value
})


const statisticsVerticalSimple = [
  {
    title: 'Equipment',
    color: 'primary',
    stats: equipmentCount,
    icon: 'tabler-tool',
  },
  {
    title: 'Fire Extinguisher',
    color: 'primary',
    stats: fireExtinguisherCount,
    icon: 'tabler-fire-extinguisher',
  },
  {
    title: 'Fire Hose',
    color: 'primary',
    stats: fireHoseCount,
    icon: 'tabler-firetruck',
  },
  {
    title: 'Others Equipment',
    color: 'primary',
    stats: othersEquipmentCount,
    icon: 'tabler-tools',
  },
]

const equipmentTables = [
  {
    description: 'Fire Extinguisher',
    quantity: fireExtinguisherCount,
  },
  {
    description: 'Fire Hose',
    quantity: fireHoseCount,
  },
  {
    description: 'Others Equipment',
    quantity: othersEquipmentCount,
  },
  {
    description: 'Total',
    quantity: equipmentCount,
  },
]

//!SECTION Declaration
</script>

<template>
  <section>
    <VExpansionPanels
      v-model="panel"
      multiple
      class="no-icon-rotate"
    >
      <VExpansionPanel>
        <VExpansionPanelTitle
          class="text-uppercase"
          disable-icon-rotate
        >
          Inventory (Recap)
          <template #actions>
            <VIcon
              size="35"
              icon="tabler-building-warehouse"
              color="primary"
            />
          </template>
        </VExpansionPanelTitle>
        <VExpansionPanelText>
          <VRow class="match-height">
            <VCol
              cols="12"
              md="4"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Category
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in categoriesLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        {{ label }}
                      </td>
                      <td class="text-center">
                        {{ categoriesSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="4"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Fire Extinguisher
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in fireExtinguisherModelLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        {{ label }}
                      </td>
                      <td class="text-center">
                        {{ fireExtinguisherModelSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="4"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Equipment per Status
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in statusLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        {{ label }}
                      </td>
                      <td class="text-center ">
                        {{ statusSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
          </VRow>
        </VExpansionPanelText>
      </VExpansionPanel>
      <VExpansionPanel>
        <VExpansionPanelTitle
          class="text-uppercase"
          disable-icon-rotate
        >
          Performed Tasks (Recap)
          <template #actions>
            <VIcon
              size="35"
              icon="tabler-tool"
              color="primary"
            />
          </template>
        </VExpansionPanelTitle>
        <VExpansionPanelText>
          <VRow class="match-height">
            <VCol
              cols="12"
              lg="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Inspection
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr>
                      <td class="text-uppercase">
                        Total Inspected Equipment
                      </td>
                      <td class="text-center">
                        {{ totalInspectedEquipment }}
                      </td>
                    </tr>
                    <tr>
                      <td class="text-uppercase">
                        Total Inspected Fire Extinguishers
                      </td>
                      <td class="text-center">
                        {{ totalInspectedFireExtinguisher }}
                      </td>
                    </tr>
                    <tr>
                      <td class="text-uppercase">
                        Total Inspected Fire Hoses
                      </td>
                      <td class="text-center">
                        {{ totalInspectedFireHose }}
                      </td>
                    </tr>
                    <tr>
                      <td class="text-uppercase">
                        Total Inspected Others Equipment
                      </td>
                      <td class="text-center">
                        {{ totalInspectedOthersEquipment }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              lg="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Recharged Fire Extinguisher 
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr>
                      <td class="text-uppercase">
                        Recharge Raw
                      </td>
                      <td class="text-center">
                        {{ rechargeRaw }}
                      </td>
                    </tr>
                    <tr>
                      <td class="text-uppercase">
                        Recharge Nitrogen
                      </td>
                      <td class="text-center">
                        {{ nitrogenRecharge }}
                      </td>
                    </tr>
                    <tr>
                      <td class="text-uppercase">
                        recharged Sparklet
                      </td>
                      <td class="text-center">
                        {{ rechargedSparklet }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              lg="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Accessories & Protection
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr>
                      <td class="text-uppercase">
                        Standard Sign
                      </td>
                      <td class="text-center">
                        {{ standardSignEquipment }}
                      </td>
                    </tr>
                    <tr>
                      <td class="text-uppercase">
                        Number
                      </td>
                      <td class="text-center">
                        {{ numberedEquipment }}
                      </td>
                    </tr>
                    <tr>
                      <td class="text-uppercase">
                        pictogram
                      </td>
                      <td class="text-center">
                        {{ pictogramEquipment }}
                      </td>
                    </tr>
                    <tr>
                      <td class="text-uppercase">
                        fixation
                      </td>
                      <td class="text-center">
                        {{ fixedEquipment }}
                      </td>
                    </tr>
                    <tr>
                      <td class="text-uppercase">
                        box
                      </td>
                      <td class="text-center">
                        {{ boxEquipment }}
                      </td>
                    </tr>
                    <tr>
                      <td class="text-uppercase">
                        cover
                      </td>
                      <td class="text-center">
                        {{ coverEquipment }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Supplies
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in supplyLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        {{ label }}
                      </td>
                      <td class="text-center">
                        {{ supplySeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Maintenance Services
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in maintenanceLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        {{ label }}
                      </td>
                      <td class="text-center">
                        {{ maintenanceSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Additional Maintenance Services
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in additionalMaintenanceLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        {{ label }}
                      </td>
                      <td class="text-center">
                        {{ additionalMaintenanceSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Total Raw Material
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in totalRawMaterialForFireExtinguishersLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        {{ label }} 
                      </td>
                      <td class="text-center">
                        {{ totalRawMaterialForFireExtinguishersSeries[index] }} kg
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
          </VRow> 
        </VExpansionPanelText>
      </VExpansionPanel>
      <VExpansionPanel>
        <VExpansionPanelTitle
          class="text-uppercase"
          disable-icon-rotate
        >
          Performed Tasks (Fire Extinguisher)
          <template #actions>
            <VIcon
              size="35"
              icon="tabler-fire-extinguisher"
              color="primary"
            />
          </template>
        </VExpansionPanelTitle>
        <VExpansionPanelText>
          <VRow class="match-height">
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Inspection per Fire Extinguisher
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in inspectedFireExtinguisherModelWeightLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        Fire Extinguisher {{ label }} Kg
                      </td>
                      <td class="text-center ">
                        {{ inspectedFireExtinguisherModelWeightSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Raw Recharged per Fire Extinguisher
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in rechargeRawModelWeightLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        Fire Extinguisher {{ label }} Kg
                      </td>
                      <td class="text-center ">
                        {{ rechargeRawModelWeightSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Maintenance Services per Fire Extinguisher
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in maintenanceExtinguisherModelWeightLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        Fire Extinguisher{{ label }}
                      </td>
                      <td class="text-center ">
                        {{ maintenanceExtinguisherModelWeightSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Additional Maintenance Services per Fire Extinguisher
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in additionalMaintenanceFireExtinguisherWeightLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        Fire Extinguisher{{ label }}
                      </td>
                      <td class="text-center ">
                        {{ additionalMaintenanceFireExtinguisherWeightSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          supplies per Fire Extinguisher
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in supplyFireExtinguisherWeightLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        Fire Extinguisher{{ label }}
                      </td>
                      <td class="text-center ">
                        {{ supplyFireExtinguisherWeightSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Fire Extinguisher Identification Sign
                        </VChip>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(label, index) in standardSignExtinguisherModelWeightLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        Identification Sign Fire Extinguisher {{ label }}
                      </td>
                      <td class="text-center ">
                        {{ standardSignExtinguisherModelWeightSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Fire Extinguisher pictogram
                        </VChip>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(label, index) in pictogramExtinguisherModelWeightLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        pictogram Fire Extinguisher {{ label }} kg
                      </td>
                      <td class="text-center ">
                        {{ pictogramExtinguisherModelWeightSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Fire Extinguisher Fixation
                        </VChip>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(label, index) in fixedExtinguisherModelWeightLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        Fire Extinguisher {{ label }} Bracket
                      </td>
                      <td class="text-center ">
                        {{ fixedExtinguisherModelWeightSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Cover per Fire Extinguisher
                        </VChip>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(label, index) in coverExtinguisherModelWeightLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        Fire Extinguisher {{ label }} Kg Cover
                      </td>
                      <td class="text-center ">
                        {{ coverExtinguisherModelWeightSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Box per Fire Extinguisher
                        </VChip>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(label, index) in boxExtinguisherModelWeightLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        Fire Extinguisher {{ label }} Kg Box
                      </td>
                      <td class="text-center ">
                        {{ boxExtinguisherModelWeightSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
          </VRow> 
        </VExpansionPanelText>
      </VExpansionPanel>
      <VExpansionPanel>
        <VExpansionPanelTitle
          class="text-uppercase"
          disable-icon-rotate
        >
          Performed Tasks (Fire Hose)
          <template #actions>
            <VIcon
              size="35"
              icon="tabler-firetruck"
              color="primary"
            />
          </template>
        </VExpansionPanelTitle>
        <VExpansionPanelText>
          <VRow class="match-height">
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Inspection per Fire Hose
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in inspectedFireHoseModelWeightLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        Fire Hose {{ label }}
                      </td>
                      <td class="text-center ">
                        {{ inspectedFireHoseModelWeightSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Maintenance Services per Fire Hose
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in maintenanceFireHoseLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        Fire Hose {{ label }}
                      </td>
                      <td class="text-center ">
                        {{ maintenanceFireHoseSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Additional Maintenance Services per Fire Hose
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in additionalMaintenanceFireHoseLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        Fire Hose {{ label }}
                      </td>
                      <td class="text-center ">
                        {{ additionalMaintenanceFireHoseSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          supplies per Fire Hose
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in supplyFireHoseCountsLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        Fire Hose{{ label }}
                      </td>
                      <td class="text-center ">
                        {{ supplyFireHoseCountsSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Accessories
                        </VChip>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-uppercase">
                        Fire Hose Identification Sign
                      </td>
                      <td class="text-center ">
                        {{ standardSignFireHose }}
                      </td>
                    </tr>
                    <tr>
                      <td class="text-uppercase">
                        Fire Hose Pictogram
                      </td>
                      <td class="text-center ">
                        {{ pictogramFireHose }}
                      </td>
                    </tr>
                    <tr>
                      <td class="text-uppercase">
                        Fire Hose Fixation
                      </td>
                      <td class="text-center ">
                        {{ fixedFireHose }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Fire Hose Protection
                        </VChip>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th class="text-uppercase">
                        Cover Per Fire Hose
                      </th>
                    </tr>
                    <tr
                      v-for="(label, index) in coverFireHoseLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        Fire Hose  {{ label }}
                      </td>
                      <td class="text-center ">
                        {{ coverFireHoseSeries[index] }}
                      </td>
                    </tr>
                    <tr>
                      <th class="text-uppercase">
                        Box Per Fire Hose
                      </th>
                    </tr>
                    <tr
                      v-for="(label, index) in boxFireHoseLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        Fire Hose  {{ label }}
                      </td>
                      <td class="text-center ">
                        {{ boxFireHoseSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
          </VRow>   
        </VExpansionPanelText>
      </VExpansionPanel>
      <VExpansionPanel>
        <VExpansionPanelTitle
          class="text-uppercase"
          disable-icon-rotate
        >
          Performed Tasks (Others Equipment)
          <template #actions>
            <VIcon
              size="35"
              icon="tabler-tools"
              color="primary"
            />
          </template>
        </VExpansionPanelTitle>
        <VExpansionPanelText>
          <VRow class="match-height">
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Inspection Others Equipment
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in inspectedOthersEquipmentLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        {{ label }}
                      </td>
                      <td class="text-center ">
                        {{ inspectedOthersEquipmentSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Maintenance Services per Others Equipment
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in maintenanceOthersEquipmentLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        {{ label }}
                      </td>
                      <td class="text-center ">
                        {{ maintenanceOthersEquipmentSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Additional Maintenance Services per Others Equipment
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in additionalMaintenanceOthersEquipmentLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        {{ label }}
                      </td>
                      <td class="text-center ">
                        {{ additionalMaintenanceOthersEquipmentSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VCard>
                <VTable class="text-no-wrap">
                  <thead>
                    <tr>
                      <th class="text-uppercase">
                        <VChip
                          label
                          x-small
                          color="primary"
                          class="mb-0 text-uppercase"
                        >
                          Supplies per Others Equipment
                        </VChip>
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr
                      v-for="(label, index) in supplyOthersEquipmentCountsLabels"
                      :key="index"
                    >
                      <td class="text-uppercase">
                        {{ label }}
                      </td>
                      <td class="text-center ">
                        {{ supplyOthersEquipmentCountsSeries[index] }}
                      </td>
                    </tr>
                  </tbody>
                </VTable>
              </VCard>
            </VCol>
          </VRow>   
        </VExpansionPanelText>
      </VExpansionPanel>
    </VExpansionPanels>
  </section>
</template>
../useContractListStore
