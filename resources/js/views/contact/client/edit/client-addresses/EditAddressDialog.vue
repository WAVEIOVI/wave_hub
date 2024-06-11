<script setup>
const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  addressData: {
    type: Object,
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

const localAddressData = ref((props.addressData))

const onFormSubmit = () => {
  emit('submit', localAddressData.value)
  emit('update:isDialogVisible', false)
}

watch(() => props.addressData, newValue => {
  localAddressData.value = { ...newValue }
})
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
    <VCard title="Edit Address">
      <!-- 👉 Form -->
      <VForm
        class="mt-4"
        @submit.prevent="onFormSubmit"
      >
        <VCardText>
          <VRow>
            <VCol cols="4">
              <AppTextField
                v-model="localAddressData.cl_address_title"
                label="Address Title"
              />
            </VCol>
            <!-- 👉 postcode -->
            <VCol
              md="2"
              cols="12"
            >
              <AppTextField
                v-model="localAddressData.cl_address_postcode"
                label="postcode"
              />
            </VCol>

            <!-- 👉 city -->
            <VCol
              md="3"
              cols="12"
            >
              <AppTextField
                v-model="localAddressData.cl_address_city"
                label="city"
              />
            </VCol>

            <!-- 👉 Country -->
            <VCol
              md="3"
              cols="12"
            >
              <AppSelect
                v-model="localAddressData.cl_address_country"
                label="Country"
                :items="countries"
              />
            </VCol>
            <!-- 👉 Address -->
            <VCol cols="12">
              <AppTextField
                v-model="localAddressData.cl_address_description"
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
            @click="$emit('update:isDialogVisible', false)"
          >
            Close
          </VBtn>
          <VBtn type="submit">
            Edit
          </VBtn>
        </VCardText>
      </VForm>
    </VCard>
  </VDialog>
</template>
