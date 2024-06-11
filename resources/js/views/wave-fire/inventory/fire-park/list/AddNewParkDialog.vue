<script setup>
import { useParkListStore } from '../useParkListStore'

const props = defineProps({
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  types: {
    type: Array,
    required: true,
  },
  clients: {
    type: Array,
    required: true,
  },
})

const emit = defineEmits([
  'update:isDialogVisible',
  'submit',
])

const parkData = ref({
  client_id: '',
  park_type: '',
  park_title: '',
})

const resetForm = () => {
  emit('update:isDialogVisible', false)
  parkData.value = {
    client_id: '',
    park_type: '',
    park_title: '',
  }
}

const parkListStore = useParkListStore()
const addresses = ref([])

const fetchClientAddresses = () => {
  if (!parkData.value.client_id) return
  parkListStore.fetchClientAddresses(parkData.value.client_id)
    .then(response => {
      addresses.value = response.data.data.map(address => ({ ...address }))
      console.log(addresses.value)
    }).catch(error => {
      console.error(error)
    })
}

watch(
  () => parkData.value.client_id,
  fetchClientAddresses,
)

const onFormSubmit = () => {
  emit('update:isDialogVisible', false)
  emit('submit', parkData.value)
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
    <VCard title="Add New Park">
      <!-- 👉 Form -->
      <VForm
        class="mt-4"
        @submit.prevent="onFormSubmit"
      >
        <VCardText>
          <VRow>
            <VCol cols="12">
              <!-- 👉 Client -->
              <AppSelect
                v-model="parkData.client_id"
                label="Select Client"
                item-title="client_name"
                item-value="id"
                :items="props.clients"
                clearable
                clear-icon="tabler-x"
                @input="fetchClientAddresses"
              >
                <template #item="{ props: itemProps, item }">  
                  <VListItem
                    v-bind="itemProps"
                    :subtitle="item.raw.client_id"
                  />
                </template>
              </AppSelect>
            </VCol>
            <VCol cols="12">
              <AppAutocomplete
                v-model="parkData.park_type"
                label="Type"
                density="compact"
                :items="props.types"
              />
            </VCol>
            <!-- 👉 title -->
            <VCol cols="12">
              <AppSelect
                v-model="parkData.park_title"
                label="Select Address"
                item-title="cl_address_title"
                :items="addresses"
                item-value="id"
                clearable
                clear-icon="tabler-x"
              >
                <template #item="{ props: itemProps, item }">  
                  <VListItem
                    v-bind="itemProps"
                    :subtitle="item.raw.cl_address_description"
                  />
                </template>
              </AppSelect>
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
