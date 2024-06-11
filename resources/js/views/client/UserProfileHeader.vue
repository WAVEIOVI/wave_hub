<script setup>
import fireExtinguisherCo2 from '@images/pages/1.png'

const props = defineProps({
  clientData: {
    type: Object,
    required: true,
  },
})

const clientData = ref((props.clientData))

watch(
  () => props.clientData,
  newValue => {
    clientData.value = newValue
    console.log('clientData in child:', clientData.value)
  },
  { deep: true },
)
</script>

<template>
  <VCard>
    <VImg
      :src="fireExtinguisherCo2"
      min-height="125"
      max-height="250"
      cover
    />

    <VCardText class="d-flex align-bottom flex-sm-row flex-column justify-center gap-x-5">
      <div class="d-flex h-0">
        <VAvatar
          rounded
          size="120"
          class="user-profile-avatar mx-auto"
        >
          <VIcon
            size="80"
            icon="tabler-user"
            class="me-1"
          />
        </VAvatar>
      </div>

      <div class="user-profile-info w-100 mt-16 pt-6 pt-sm-0 mt-sm-0">
        <h6 class="text-h6 text-center text-sm-start font-weight-medium mb-3">
          {{ clientData.client_name }}
        </h6>

        <div class="d-flex align-center justify-center justify-sm-space-between flex-wrap gap-4">
          <div class="d-flex flex-wrap justify-center justify-sm-start flex-grow-1 gap-2">
            <span class="d-flex align-center">
              <VIcon
                size="20"
                icon="tabler-map-pin"
                class="me-1"
              />
              <span class="text-body-1">
                {{ clientData.address }} {{ clientData.postcode }} {{ clientData.city }} {{ clientData.country }}
              </span>
            </span>
          </div>

          <VBtn prepend-icon="tabler-check">
            Connected
          </VBtn>
        </div>
      </div>
    </VCardText>
  </VCard>
</template>

<style lang="scss">
.user-profile-avatar {
  border: 5px solid rgb(var(--v-theme-surface));
  background-color: rgb(var(--v-theme-surface)) !important;
  inset-block-start: -3rem;

  .v-img__img {
    border-radius: 0.125rem;
  }
}
</style>
