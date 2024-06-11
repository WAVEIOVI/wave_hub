<script setup>
const props = defineProps({
  clientData: {
    type: Object,
    required: true,
  },
  parks: {
    type: Object,
    required: true,
  },
  equipments: {
    type: Object,
    required: true,
  },
})
</script>

<template>
  <VCard class="mb-4">
    <VCardText>
      <p class="text-xs">
        BASIC INFORMATION
      </p>

      <VList class="card-list text-medium-emphasis">
        <VListItem>
          <template #prepend>
            <VIcon
              size="20"
              class="me-2"
            />
          </template>
          <VListItem>
            <span class="text-capitalize font-weight-medium me-1">Client ID:</span>
            <span class="text-capitalize font-weight-medium me-1"> {{ clientData.client_id }}</span>
          </VListItem>
          <VListItem>
            <span class="text-capitalize font-weight-medium me-1">Name:</span>
            <span class="text-capitalize font-weight-medium me-1"> {{ clientData.client_name }}</span>
          </VListItem>
          <VListItem>
            <span class="text-capitalize font-weight-medium me-1">Type:</span>
            <span class="text-capitalize font-weight-medium me-1"> {{ clientData.client_type }}</span>
          </VListItem>
          <VListItem>
            <span class="text-capitalize font-weight-medium me-1">Activity:</span>
            <span class="text-capitalize font-weight-medium me-1"> {{ clientData.client_activity }}</span>
          </VListItem>
          <VListItem>
            <span class="text-capitalize font-weight-medium me-1">Status:</span>
            <span class="text-capitalize font-weight-medium me-1"> {{ clientData.client_status }}</span>
          </VListItem>
        </VListItem>
      </VList>

      <p class="text-xs mt-5">
        CONTACTS
      </p>

      <VList class="card-list text-medium-emphasis">
        <VListItem>
          <template #prepend>
            <VIcon
              size="20"
              class="me-2"
            />
          </template>
          <VListItem>
            <span class="text-capitalize font-weight-medium me-1">address :</span>
            <span class="text-capitalize font-weight-medium me-1">{{ clientData.address }} {{ clientData.postcode }} {{ clientData.city }} {{ clientData.country }}</span>
          </VListItem>
          <VListItem>
            <span class="text-capitalize font-weight-medium me-1">Phone Number :</span>
            <span class="text-capitalize font-weight-medium me-1">{{ clientData.main_phone_number }}</span>
          </VListItem>
          <VListItem>
            <span class="text-capitalize font-weight-medium me-1">Email :</span>
            <span class="font-weight-medium me-1">{{ clientData.client_email }}</span>
          </VListItem>
          <VListItem>
            <span class="text-capitalize font-weight-medium me-1">Web Site :</span>
            <span class="font-weight-medium me-1">{{ clientData.client_website }}</span>
          </VListItem>
        </VListItem>
      </VList>
    </VCardText>
  </VCard>

  <VCard>
    <VCardText>
      <p class="text-xs">
        OVERVIEW
      </p>

      <VList class="card-list text-medium-emphasis">
        <VListItem>
          <template #prepend>
            <VIcon
              size="20"
              class="me-2"
            />
          </template>
          <VListItem>
            <span class="font-weight-medium me-1">Parks Total:</span>
            <span>{{ parks }}</span>
          </VListItem>
          <VListItem>
            <span class="font-weight-medium me-1">Equipment Total:</span>
            <span>{{ equipments }}</span>
          </VListItem>
        </VListItem>
      </VList>
    </VCardText>
  </VCard>
</template>

<style lang="scss" scoped>
.card-list {
  --v-card-list-gap: 16px;
}
</style>
