<script setup>
import ClientAddressesCard from './client-addresses/ClientAddressesCard.vue'
import ClientContactsCard from './client-contacts/ClientContactsCard.vue'

const props = defineProps({
  currentStep: {
    type: Number,
    required: false,
  },
})

const emit = defineEmits([
  'update:currentStep',
])

const refVForm = ref()

const Previous = () => {
  emit('update:currentStep', props.currentStep ? props.currentStep - 1 : 1)
}

watch(() => props.currentStep)

//SECTION Items

// 👉 Addresses Headers
const addressesHeaders = [
  {
    title: 'Address',
    key: 'cl_address_title',
  },
  {
    title: 'Description',
    key: 'description',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

// 👉 Contacts Headers
const contactsHeaders = [
  {
    title: 'Contact Name',
    key: 'name',
  },
  {
    title: 'Phone | Email',
    key: 'phone',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

//!SECTION Items
</script>

<template>
  <VRow class="match-height">
    <VCol
      md="6"
      cols="12"
    >
      <!-- 👉 Addresses -->
      <ClientAddressesCard :addresses-headers="addressesHeaders" />
    </VCol>
    
    <VCol
      md="6"
      cols="12"
    >
      <!-- 👉 Contacts -->
      <ClientContactsCard :contacts-headers="contactsHeaders" />
    </VCol>
    <VCol cols="12">
      <div class="d-flex flex-wrap gap-4 justify-sm-space-between justify-center mt-8">
        <VBtn
          color="secondary"
          variant="tonal"
          @click="Previous"
        >
          <VIcon
            icon="tabler-arrow-left"
            start
            class="flip-in-rtl"
          />
          Previous
        </VBtn>

        <VBtn disabled>
          Next
          <VIcon
            icon="tabler-arrow-right"
            end
            class="flip-in-rtl"
          />
        </VBtn>
      </div>
    </VCol>
  </VRow>
</template>
