<script setup>
const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  types: {
    type: Array,
    required: true,
  },
  activities: {
    type: Array,
    required: true,
  },
  status: {
    type: Array,
    required: true,
  },
})

const emit = defineEmits([
  'update:isDialogVisible',
  'submit',
])

const supplierData = ref({
  supplier_name: '',
  supplier_type: '',
  supplier_activity: '',
  supplier_status: '',
})

const resetForm = () => {
  emit('update:isDialogVisible', false)
  supplierData.value ={
    supplier_name: '',
    supplier_type: '',
    supplier_activity: '',
    supplier_status: '',
  }
}

const onFormSubmit = () => {
  emit('update:isDialogVisible', false)
  emit('submit', supplierData.value)
}
</script>

<template>
  <VDialog
    :width="$vuetify.display.smAndDown ? 'auto' : 610 "
    :model-value="props.isDialogVisible"
    @update:model-value="val => $emit('update:isDialogVisible', val)"
  >
    <!-- 👉 Dialog close btn -->
    <DialogCloseBtn @click="$emit('update:isDialogVisible', false)" />

    <!-- Dialog Content -->
    <VCard title="Add New Supplier">
      <!-- 👉 Form -->
      <VForm
        class="mt-4"
        @submit.prevent="onFormSubmit"
      >
        <VCardText>
          <VRow>
            <VCol cols="12">
              <AppTextField
                v-model="supplierData.supplier_name"
                label="Supplier Name"
              />
            </VCol>
            <VCol cols="12">
              <AppAutocomplete
                v-model="supplierData.supplier_type"
                label="Type"
                density="compact"
                :items="types"
              />
            </VCol>
            <VCol cols="12">
              <AppAutocomplete
                v-model="supplierData.supplier_activity"
                label="Activity"
                density="compact"
                :items="activities"
              />
            </VCol>
            <VCol cols="12">
              <AppAutocomplete
                v-model="supplierData.supplier_status"
                label="Status"
                density="compact"
                :items="status"
              />
            </VCol>
          </VRow>
        </VCardText>

        <VCardText class="d-flex justify-end flex-wrap gap-3">
          <VBtn
            variant="tonal"
            color="secondary"
            @click="resetForm"
          >
            Close
          </VBtn>
          <VBtn type="submit">
            Add
          </VBtn>
        </VCardText>
      </VForm>
    </VCard>
  </VDialog>
</template>
