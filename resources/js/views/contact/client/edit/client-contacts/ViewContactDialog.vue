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
])
</script>

<template>
  <VDialog
    :width="$vuetify.display.smAndDown ? 'auto' : 400 "
    :model-value="props.isDialogVisible"
    @update:model-value="val => $emit('update:isDialogVisible', val)"
  >
    <!-- 👉 Dialog close btn -->
    <DialogCloseBtn @click="$emit('update:isDialogVisible', false)" />
    <!-- Dialog Content -->
    <VCard class="refer-and-earn-dialog">
      <VCardText>
        <h5 class="text-h5 text-center">
          Client's Contact View
        </h5>
        <VRow class="text-center mt-3">
          <VCol cols="12">
            <VAvatar
              variant="tonal"
              size="72"
              color="primary"
              rounded
            >
              <VIcon
                size="50"
                icon="tabler-user"
              />
            </VAvatar>
            <h6 class="text-lg mt-4 mb-2">
              {{ contactData.cl_contact_full_name }}
            </h6>
            <span class="text-base">{{ contactData.cl_contact_id }}</span>
            <VDivider />
            <span class="text-base">{{ contactData.cl_contact_post }}</span>
            <p class="mb-1 text-sm">
              {{ contactData.cl_contact_phone }}
            </p>
            <p class="mb-1 text-sm">
              {{ contactData.cl_contact_email }}
            </p>
          </VCol>
        </VRow>
      </VCardText>
    </VCard>
  </VDialog>
</template>

<style lang="scss">
.refer-link-input {
  .v-field--appended {
    padding-inline-end: 0;
  }

  .v-field__append-inner {
    padding-block-start: 0.125rem;
  }
}
</style>
