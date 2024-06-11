<script setup>
const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  contactData: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits([
  'update:isDialogVisible',
  'submit',
])

const localContactData = ref((props.contactData))

const onFormSubmit = () => {
  emit('submit', localContactData.value)
  emit('update:isDialogVisible', false)
}

watch(() => props.contactData, newValue => {
  localContactData.value = { ...newValue }
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
    <VCard title="Edit Contact">
      <!-- 👉 Form -->
      <VForm
        class="mt-4"
        @submit.prevent="onFormSubmit"
      >
        <VCardText>
          <VRow>
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
                    for="firstNameHorizontalIcons"
                  >First Name</label>
                </VCol>

                <VCol
                  cols="12"
                  md="9"
                >
                  <AppTextField
                    id="firstNameHorizontalIcons"
                    v-model="localContactData.cl_contact_full_name"
                    prepend-inner-icon="tabler-user"
                    placeholder="First Name"
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
                    for="firstNameHorizontalIcons"
                  >Post</label>
                </VCol>

                <VCol
                  cols="12"
                  md="9"
                >
                  <AppTextField
                    id="firstNameHorizontalIcons"
                    v-model="localContactData.cl_contact_post"
                    prepend-inner-icon="tabler-file-description"
                    placeholder="Post"
                    persistent-placeholder
                  />
                </VCol>
              </VRow>
            </VCol>

            <!-- 👉 Email -->
            <VCol cols="12">
              <VRow no-gutters>
                <VCol
                  cols="12"
                  md="3"
                  class="d-flex align-items-center"
                >
                  <label
                    class="v-label text-body-2 text-high-emphasis"
                    for="emailHorizontalIcons"
                  >Email</label>
                </VCol>

                <VCol
                  cols="12"
                  md="9"
                >
                  <AppTextField
                    id="emailHorizontalIcons"
                    v-model="localContactData.cl_contact_email"
                    prepend-inner-icon="tabler-mail"
                    placeholder="Email"
                    persistent-placeholder
                  />
                </VCol>
              </VRow>
            </VCol>

            <!-- 👉 Mobile -->
            <VCol cols="12">
              <VRow no-gutters>
                <VCol
                  cols="12"
                  md="3"
                  class="d-flex align-items-center"
                >
                  <label
                    class="v-label text-body-2 text-high-emphasis"
                    for="mobileHorizontalIcons"
                  >Mobile</label>
                </VCol>

                <VCol
                  cols="12"
                  md="9"
                >
                  <AppTextField
                    id="mobileHorizontalIcons"
                    v-model="localContactData.cl_contact_phone"
                    prepend-inner-icon="tabler-device-mobile"
                    placeholder="Number"
                    persistent-placeholder
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
