<script setup>
const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
})

const emit = defineEmits([
  'update:isDialogVisible',
  'submit',
])

const addressData = ref({
  cl_address_id: '',
  cl_address_title: '',
  cl_address_description: '',
  cl_address_postcode: '',
  cl_address_city: '',
  cl_address_country: '',
})

const resetForm = () => {
  emit('update:isDialogVisible', false)
  addressData.value = {
    cl_address_id: '',
    cl_address_title: '',
    cl_address_description: '',
    cl_address_postcode: '',
    cl_address_city: '',
    cl_address_country: '',
  }
}

const onFormSubmit = () => {
  emit('update:isDialogVisible', false)
  emit('submit', addressData.value) // Emit the submit event with addressData as the parameter
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

    <VCard class="pa-sm-8 pa-5">
      <!-- 👉 Title -->
      <VCardItem>
        <VCardTitle class="text-h4 text-center">
          Add New Address
        </VCardTitle>
      </VCardItem>

      <VCardText>
        <!-- 👉 Subtitle -->
        <VCardSubtitle class="text-center mb-6">
          <span class="text-base">

            Add new client address
          </span>
        </VCardSubtitle>

        <!-- 👉 Form -->
        <VForm
          class="mt-4"
          @submit.prevent="onFormSubmit"
        >
          <VRow>
            <!-- 👉 Address Title -->
            <VCol
              cols="12"
              md="6"
            >
              <AppTextField
                v-model="addressData.cl_address_title"
                label="Address Title"
              />
            </VCol>

            

            <!-- 👉 Address Description -->
            <VCol cols="12">
              <AppTextarea
                v-model="addressData.cl_address_description"
                rows="2"
                label="Address Description"
              />
            </VCol>

            <!-- 👉 Post Code -->
            <VCol
              cols="12"
              md="4"
            >
              <AppTextField
                v-model="addressData.cl_address_postcode"
                label="Post Code"
                type="number"
              />
            </VCol>

            <!-- 👉 city -->
            <VCol
              cols="12"
              md="4"
            >
              <AppTextField
                v-model="addressData.cl_address_city"
                label="City"
              />
            </VCol>

            <!-- 👉 Country -->
            <VCol
              cols="12"
              md="4"
            >
              <AppTextField
                v-model="addressData.cl_address_country"
                label="Country"
              />
            </VCol>

            <!-- 👉 Submit and Cancel button -->
            <VCol
              cols="12"
              class="text-center"
            >
              <VBtn
                type="submit"
                class="me-3"
              >
                submit
              </VBtn>

              <VBtn
                variant="tonal"
                color="secondary"
                @click="resetForm"
              >
                Cancel
              </VBtn>
            </VCol>
          </VRow>
        </VForm>
      </VCardText>
    </VCard>
  </VDialog>
</template>
