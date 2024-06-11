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

const clientData = ref({
  client_name: '',
  client_type: '',
  client_activity: '',
  client_status: '',
})

const resetForm = () => {
  emit('update:isDialogVisible', false)
  clientData.value ={
    client_name: '',
    client_type: '',
    client_activity: '',
    client_status: '',
  }
}

const onFormSubmit = () => {
  emit('update:isDialogVisible', false)
  emit('submit', clientData.value)
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
    <VCard title="Add New Client">
      <!-- 👉 Form -->
      <VForm
        class="mt-4"
        @submit.prevent="onFormSubmit"
      >
        <VCardText>
          <VRow>
            <VCol cols="12">
              <AppTextField
                v-model="clientData.client_name"
                label="Client Name"
              />
            </VCol>
            <VCol cols="12">
              <AppAutocomplete
                v-model="clientData.client_type"
                label="Type"
                density="compact"
                :items="types"
              />
            </VCol>
            <VCol cols="12">
              <AppAutocomplete
                v-model="clientData.client_activity"
                label="Activity"
                density="compact"
                :items="activities"
              />
            </VCol>
            <VCol cols="12">
              <AppAutocomplete
                v-model="clientData.client_status"
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
