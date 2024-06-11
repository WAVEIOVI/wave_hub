<script setup>
import { useMetaStore } from '@/stores/useMetaStore'

const props = defineProps({
  interventionData: {
    type: Object,
    required: true,
  },
})

const localInterventionData = ref((props.interventionData))

const totalEquipment = ref()
const totalFireExtinguisher = ref()
const totalFireHose = ref()
const othersEquipment = ref()

const route = useRoute()
const metaStore = useMetaStore()
const parkId = localInterventionData.value.park

// 👉 Fetch Equipment
onMounted(() => {
  metaStore.fetchParkEquipment(parkId)
    .then(response => {
      totalEquipment.value = response.data.data.count.equipment_per_park
      totalFireExtinguisher.value = response.data.data.count.fire_extinguisher_per_park
      totalFireHose.value = response.data.data.count.fire_hose_per_park
      othersEquipment.value = response.data.data.count.others_equipment_per_park
    }).catch(error => {
      console.error(error)
    })
})

const equipmentCount = computed(() => {
  if (!totalEquipment.value || typeof totalEquipment.value !== 'object') {
    return null
  }

  return Object.values(totalEquipment.value)[0]
})

const fireExtinguisherCount = computed(() => {
  if (!totalFireExtinguisher.value || typeof totalFireExtinguisher.value !== 'object') {
    return null
  }

  return Object.values(totalFireExtinguisher.value)[0]
})

const fireHoseCount = computed(() => {
  if (!totalFireHose.value || typeof totalFireHose.value !== 'object') {
    return null
  }

  return Object.values(totalFireHose.value)[0]
})

const othersEquipmentCount = computed(() => {
  if (!othersEquipment.value || typeof othersEquipment.value !== 'object') {
    return null
  }

  return Object.values(othersEquipment.value)[0]
})

const statistics = [
  {
    title: 'Equipment',
    stats: equipmentCount,
    icon: 'tabler-tool',
    color: 'primary',
  },
  {
    title: 'Fire Extinguisher',
    stats: fireExtinguisherCount,
    icon: 'tabler-fire-extinguisher',
    color: 'primary',
  },
  {
    title: 'Fire Hose',
    stats: fireHoseCount,
    icon: 'tabler-firetruck',
    color: 'primary',
  },
  {
    title: 'Others Equipment',
    stats: othersEquipmentCount,
    icon: 'tabler-tools',
    color: 'primary',
  },
]
</script>

<template>
  <VCard title="Statistics">
    <VCardText class="pt-0">
      <VRow>
        <VCol
          v-for="item in statistics"
          :key="item.title"
          cols="6"
          md="3"
        >
          <div class="d-flex align-center gap-4">
            <VAvatar
              :color="item.color"
              variant="tonal"
              size="42"
            >
              <VIcon :icon="item.icon" />
            </VAvatar>

            <div class="d-flex flex-column">
              <span class="text-h5 font-weight-medium">{{ item.stats }}</span>
              <span class="text-sm">
                {{ item.title }}
              </span>
            </div>
          </div>
        </VCol>
      </VRow>
    </VCardText>
  </VCard>
</template>
