<script setup>
const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  areaClassificationOptions: {
    type: Array,
    required: true,
  },
  areaAccessibilityOptions: {
    type: Array,
    required: true,
  },
})

const emit = defineEmits([
  'update:isDialogVisible',
  'submit',
])

const areaData = ref({
  area_description: '',
  area_accessibility: '',
  area_classification: '',
})

const resetForm = () => {
  emit('update:isDialogVisible', false)
  areaData.value ={
    area_description: '',
    area_accessibility: '',
    area_classification: '',
  }
}

const onFormSubmit = () => {
  emit('update:isDialogVisible', false)
  emit('submit', areaData.value)
  resetForm()
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
    <VCard title="Add New Area">
      <!-- 👉 Form -->
      <VForm
        class="mt-4"
        @submit.prevent="onFormSubmit"
      >
        <VCardText>
          <VRow>
            <!-- 👉 Area Description -->
            <VCol cols="12">
              <VRow no-gutters>
                <VCol
                  cols="12"
                  md="3"
                  class="d-flex align-items-center"
                >
                  <label
                    class="v-label text-body-2 text-high-emphasis"
                    for="areaDescription"
                  >Description</label>
                </VCol>

                <VCol
                  cols="12"
                  md="9"
                >
                  <AppTextField
                    id="areaDescription"
                    v-model="areaData.area_description"
                    prepend-inner-icon="tabler-zoom-in-area"
                    placeholder="Area Description"
                    persistent-placeholder
                  />
                </VCol>
              </VRow>
            </VCol>

            <!-- 👉 First Name -->
            <VCol cols="12">
              <VRow no-gutters>
                <VCol
                  cols="12"
                  md="3"
                  class="d-flex align-items-center"
                >
                  <label
                    class="v-label text-body-2 text-high-emphasis"
                    for="areaAccessibility"
                  >Accessibility</label>
                </VCol>

                <VCol
                  cols="12"
                  md="9"
                >
                  <AppSelect
                    id="areaAccessibility"
                    v-model="areaData.area_accessibility"
                    prepend-inner-icon="tabler-accessible"
                    :items="areaAccessibilityOptions"
                  />
                </VCol>
              </VRow>
            </VCol>

            <!-- 👉 area_classification -->
            <VCol cols="12">
              <VRow no-gutters>
                <VCol
                  cols="12"
                  md="3"
                  class="d-flex align-items-center"
                >
                  <label
                    class="v-label text-body-2 text-high-emphasis"
                    for="areaClassification"
                  >Area Classification</label>
                </VCol>

                <VCol
                  cols="12"
                  md="9"
                >
                  <AppSelect
                    id="areaClassification"
                    v-model="areaData.area_classification"
                    prepend-inner-icon="tabler-alert-triangle"
                    :items="areaClassificationOptions"
                  />
                </VCol>
              </VRow>
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
