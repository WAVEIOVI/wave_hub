<script setup>
const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  countries: {
    type: Array,
    required: true,
  },
})

const emit = defineEmits([
  'update:isDialogVisible',
  'submit',
])

const addressData = ref({
  su_address_title: '',
  su_address_description: '',
  su_address_postcode: '',
  su_address_city: '',
  su_address_country: '',
})

const resetForm = () => {
  emit('update:isDialogVisible', false)
  addressData.value ={
    su_address_title: '',
    su_address_description: '',
    su_address_postcode: '',
    su_address_city: '',
    su_address_country: '',
  }
}

const onFormSubmit = () => {
  emit('update:isDialogVisible', false)
  emit('submit', addressData.value)
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
    <VCard title="Add New Address">
      <!-- 👉 Form -->
      <VForm
        class="mt-4"
        @submit.prevent="onFormSubmit"
      >
        <VCardText>
          <VRow>
            <VCol cols="4">
              <AppTextField
                v-model="addressData.su_address_title"
                label="Address Title"
              />
            </VCol>
            <!-- 👉 postcode -->
            <VCol
              md="2"
              cols="12"
            >
              <AppTextField
                v-model="addressData.su_address_postcode"
                label="postcode"
                :rules="[integerValidator]"
              />
            </VCol>

            <!-- 👉 city -->
            <VCol
              md="3"
              cols="12"
            >
              <AppTextField
                v-model="addressData.su_address_city"
                label="city"
              />
            </VCol>

            <!-- 👉 Country -->
            <VCol
              md="3"
              cols="12"
            >
              <AppSelect
                v-model="addressData.su_address_country"
                label="Country"
                :items="countries"
              />
            </VCol>
            <!-- 👉 Address -->
            <VCol cols="12">
              <AppTextField
                v-model="addressData.su_address_description"
                label="Address"
                prepend-inner-icon="tabler-map-pin"
                placeholder="Address "
                persistent-placeholder
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
