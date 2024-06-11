<script setup>
import { useParkListStore } from '@/views/wave-fire/inventory/fire-park/useParkListStore'
import AddNewAreaDialog from './AddNewAreaDialog.vue'
import EditAreaDialog from './EditAreaDialog.vue'
import { avatarText } from '@core/utils/formatters'

const emit = defineEmits([
  'refetchAreas',
])

// SECTION Options
const areaAccessibilityOptions = [
  'Open Access Area',
  'Easy Access',
  'Limited Access',
  'Difficult Access',
  'Restricted Access Area',
  'Inaccessible',
]

const areaClassificationOptions = [
  'High Risk',
  'Medium Risk',
  'Low Risk',
  'Controlled Risk',
  'No Risk',
  'Special Risk',
  'Safe Area',
]

const resolveAccessibilityColor = {
  'Open Access Area': 'success',
  'Easy Access': 'info',
  'Limited Access': 'secondary',
  'Difficult Access': 'warning',
  'Restricted Access Area': 'error',
  'Inaccessible': 'error',
}

const resolveClassificationColor = {
  'Safe Area': 'success',
  'No Risk': 'info', 
  'Controlled Risk': 'secondary',
  'Low Risk': 'warning',
  'Medium Risk': 'error',
  'High Risk': 'error',
}


// !SECTION Options
//SECTION Declaration
const route = useRoute()
const parkListStore = useParkListStore()
const areas = ref([])
const areaData = ref([])

// 👉 Area Dialog
const isAddNewAreaDialogVisible = ref(false)
const isEditAreaDialogVisible = ref(false)

// 👉 Fetching areas
const fetchParkAreas = () => {
  parkListStore.fetchParkAreas(Number(route.params.id))
    .then(response => {
      areas.value = response.data.data
      console.log(areas)
    }).catch(error => {
      console.error(error)
    })
}

// 👉 Fetch Park Area
const fetchParkArea = areaId => {
  parkListStore.fetchParkArea(Number(route.params.id), areaId)
    .then(response => {
      areaData.value = response.data.data
    }).catch(error => {
      console.error(error)
    })
}

// 👉 Add Area
const addArea = async areaData => {
  try {
    const response = await parkListStore.addParkArea(Number(route.params.id), areaData)
    if (response.status === 201) {
      fetchParkAreas()
      emit('refetchAreas')
    } else {
      throw new Error(`Failed to create park: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

const updateArea = async areaData => {
  const areaId = areaData.id
  try {
    const response = await parkListStore.updateParkArea(Number(route.params.id), areaId, areaData)
    if (response.status === 200) {
      fetchParkAreas()
      emit('refetchAreas')
    } else {
      throw new Error(`Failed to update park: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Delete Area
const deleteArea = areaId => {
  parkListStore.deleteParkArea(Number(route.params.id), areaId)
    .then(response => {
      console.log(response.data)
      fetchParkAreas()
      emit('refetchAreas')
    })
    .catch(error => {
      console.error('Error deleting park:', error)
    })
}

onMounted(() => {
  fetchParkAreas()
})
</script>

<template>
  <AddNewAreaDialog
    v-model:isDialogVisible="isAddNewAreaDialogVisible"    
    :area-classification-options="areaClassificationOptions"
    :area-accessibility-options="areaAccessibilityOptions"
    @submit="addArea"
  />
  <EditAreaDialog
    v-model:isDialogVisible="isEditAreaDialogVisible"
    :area-classification-options="areaClassificationOptions"
    :area-accessibility-options="areaAccessibilityOptions"
    :area-data="areaData"
    @submit="updateArea"
  />
  <section>
    <VRow>
      <VCol cols="12">
        <AppCardActions
          title="Park Areas"
          action-collapsed
        >
          <template #before-actions>
            <VChip
              class="me-3"
              color="primary"
              size="small"
              @click="isAddNewAreaDialogVisible = !isAddNewAreaDialogVisible"
            >
              New Area 
            </VChip>
          </template>
          <VList
            lines="two"
            border
            density="compact"
          >
            <template
              v-for="(area, index) in areas"
              :key="area.id"
            >
              <VListItem>
                <template #prepend>
                  <VIcon 
                    icon="tabler-direction-sign-filled" 
                    variant="tonal"
                    :color="resolveClassificationColor[area.area_classification]"
                  />
                </template>
                <VListItemTitle>
                  {{ area.area_id }} {{ area.area_description }}
                </VListItemTitle>
                <VListItemSubtitle class="mt-1">
                  <VBadge
                    dot
                    location="start center"
                    offset-x="2"
                    :color="resolveClassificationColor[area.area_classification]"
                    class="me-3"
                  >
                    <span class="ms-4">{{ area.area_classification }}</span>
                  </VBadge>
                  <VBadge
                    dot
                    location="start center"
                    offset-x="2"
                    :color="resolveAccessibilityColor[area.area_classification]"
                    class="me-3"
                  >
                    <span class="ms-4">{{ area.area_accessibility }}</span>
                  </VBadge>
                </VListItemSubtitle>

                <template #append>
                  <IconBtn
                    @click=" fetchParkArea(area.id),
                             isEditAreaDialogVisible = !isEditAreaDialogVisible"
                  >
                    <VIcon icon="tabler-pencil" />
                  </IconBtn>
                  <IconBtn @click=" deleteArea(area.id)">
                    <VIcon icon="tabler-trash" />
                  </IconBtn>
                </template>
              </VListItem>
              <VDivider v-if="index !== areas.length - 1" />
            </template>
          </VList>
        </AppCardActions>
      </VCol>
    </VRow>
  </section>
</template>
