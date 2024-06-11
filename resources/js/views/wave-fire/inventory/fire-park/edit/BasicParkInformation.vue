<script setup>
const props = defineProps({
  currentStep: {
    type: Number,
    required: false,
  },
  parkData: {
    type: Object, 
    required: true,
  },
})

const emit = defineEmits([
  'update:currentStep',
  'submit',
])

const localParkData = ref((props.parkData))

const updateParkData = async () => {
  emit('submit', localParkData.value)
}

const onSubmit = () => {
  updateParkData() // Emit the updated data
  emit('update:currentStep', props.currentStep ? props.currentStep + 1 : 1)
}

watch(() => props.currentStep, updateParkData)

//SECTION Items

// 👉 search filters
const types = [
  {
    title: 'Primary Fire Park',
    value: 'primary fire park',
  },
  {
    title: 'Secondary Fire Park',
    value: 'secondary fire park',
  },
  {
    title: 'Reserve Fire Park',
    value: 'reserve fire park',
  },
]

//!SECTION Items
</script>

<template>
  <VRow>
    <VCol cols="12">
      <!-- 👉 Park's Basic Information -->
      <VCard title="Park's Basic Information">
        <VCardText class="pt-2">
          <!-- 👉 Form -->
          <VForm
            lazy-validation
            class="mt-1"
            @submit.prevent="onSubmit"
          >
            <VRow>
              <!-- 👉 Park Id -->
              <VCol
                md="3"
                cols="6"
              >
                <AppTextField
                  v-model="localParkData.park_client_id"
                  label="Client Id"
                  readonly
                  prepend-inner-icon="tabler-scan"
                  persistent-placeholder
                />
              </VCol>

              <!-- 👉 Park Name -->
              <VCol
                md="4"
                cols="6"
              >
                <AppTextField
                  v-model="localParkData.client_name"
                  label="Client Name"
                  prepend-inner-icon="tabler-user"
                  placeholder="Client Name"
                  persistent-placeholder
                  readonly
                />
              </VCol>
            </VRow>
            <VRow>
              <!-- 👉 Park ID -->
              <VCol
                md="3"
                cols="12"
              >
                <AppTextField
                  v-model="localParkData.park_id"
                  label="Park ID"
                  prepend-inner-icon="tabler-scan"
                  placeholder="Park ID"
                  persistent-placeholder
                  readonly
                />
              </VCol>
              <!-- 👉 Park Title -->
              <VCol
                md="4"
                cols="12"
              >
                <AppTextField
                  v-model="localParkData.park_title"
                  label="Park Title"
                  prepend-inner-icon="tabler-flame"
                  placeholder="Park Title"
                  persistent-placeholder
                  readonly
                />
              </VCol>
              <!-- 👉 park type -->
              <VCol
                md="3"
                cols="12"
              >
                <AppSelect
                  v-model="localParkData.park_type"
                  label="Type"
                  density="compact"
                  :items="types"
                />
              </VCol>
              <!-- 👉 Address -->
              <VCol
                md="6"
                cols="12"
              >
                <AppTextField
                  v-model="localParkData.park_address"
                  label="Address"
                  prepend-inner-icon="tabler-map-pin"
                  placeholder="Address "
                  persistent-placeholder
                  readonly
                />
              </VCol>

              <!-- 👉 postcode -->
              <VCol
                md="2"
                cols="12"
              >
                <AppTextField
                  v-model="localParkData.park_postcode"
                  label="postcode"
                  placeholder="3000"
                  persistent-placeholder
                  readonly
                />
              </VCol>

              <!-- 👉 city -->
              <VCol
                md="2"
                cols="12"
              >
                <AppTextField
                  v-model="localParkData.park_city"
                  label="city"
                  placeholder="Sfax"
                  persistent-placeholder
                  readonly
                />
              </VCol>

              <!-- 👉 Country -->
              <VCol
                md="2"
                cols="12"
              >
                <AppTextField
                  v-model="localParkData.park_country"
                  label="Country"
                  placeholder="Tunisia"
                  persistent-placeholder
                  readonly
                />
              </VCol>
              <VCol cols="12">
                <div class="d-flex flex-wrap gap-4 justify-sm-space-between justify-center mt-8">
                  <VBtn
                    color="secondary"
                    variant="tonal"
                    disabled
                  >
                    <VIcon
                      icon="tabler-arrow-left"
                      start
                      class="flip-in-rtl"
                    />
                    Previous
                  </VBtn>

                  <VBtn type="submit">
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
          </VForm>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>
