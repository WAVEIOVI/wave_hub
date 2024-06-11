<script setup>
import congoImg from '@images/illustrations/laptop-girl.png'
import AddNewEquipmentDialog from './AddNewEquipmentDialog.vue'
import { useWorkshopListStore } from '../../useWorkshopListStore'

const props = defineProps({
  workshopData: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits([
  'update:isDialogVisible',
  'submit',
])

const route = useRoute()
const workshopListStore = useWorkshopListStore()

const localWorkshopData = ref((props.workshopData))

const isReadOnly = computed(() => {
  return localWorkshopData.value.workshop_status === 'completed'
})

// 👉 Add Equipment
const addEquipment = async equipmentData => {
  try {
    const response = await workshopListStore.attachWorkshopEquipment(Number(route.params.id), equipmentData)
    if (response.status === 200) {
      emit('submit')
    } else {
      throw new Error(`Failed to create park: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

const isAddNewEquipmentDialogVisible = ref(false)
</script>

<template>
  <AddNewEquipmentDialog
    v-model:is-dialog-visible="isAddNewEquipmentDialogVisible"
    :workshop-data="workshopData"
    @submit="addEquipment"
  />
  <VCard>
    <VRow no-gutters>
      <VCol cols="8">
        <VCardText>
          <h6 class="text-lg text-no-wrap font-weight-medium">
            Search for equipment! 🎉
          </h6>
          <p class="mb-2">
            by entering keywords or scan a QR code.
          </p>
          <VBtn
            :disabled="isReadOnly"
            @click="isAddNewEquipmentDialogVisible = !isAddNewEquipmentDialogVisible"
          >
            Attach Equipment 
          </VBtn>
        </VCardText>
      </VCol>

      <VCol cols="4">
        <VCardText class="pb-0 px-0 position-relative h-100">
          <VImg
            :src="congoImg"
            height="150"
            class="congo-john-img w-100"
          />
        </VCardText>
      </VCol>
    </VRow>
  </VCard>
</template>

<style lang="scss" scoped>
.congo-john-img {
  position: absolute;
  inset-block-end: 0;
  inset-inline-end: 1.25rem;
}
</style>
