<script setup>
import {
  emailValidator,
  urlValidator,
  integerValidator,
  requiredValidator,
} from '@validators'

const props = defineProps({
  currentStep: {
    type: Number,
    required: false,
  },
  missionData: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits([
  'update:currentStep',
])

const localMissionData = ref((props.missionData))


const next = () => {
  emit('update:currentStep', props.currentStep ? props.currentStep + 1 : 1)
}

watch(() => props.currentStep)

//SECTION Items

// 👉 search filters

//!SECTION Items
</script>

<template>
  <VRow>
    <VCol cols="12">
      <!-- 👉 Mission Basic Information -->
      <VCard title="Client Information">
        <VCardText class="pt-2">
          <VRow>
            <!-- 👉 Mission Id -->
            <VCol
              md="4"
              cols="12"
            >
              <AppTextField
                v-model="localMissionData.mission_client_id"
                label="Client Id"
                readonly
                prepend-inner-icon="tabler-scan"
                persistent-placeholder
              />
            </VCol>

            <!-- 👉 Client Name -->
            <VCol
              md="4"
              cols="12"
            >
              <AppTextField
                v-model="localMissionData.client_name"
                label="Client Name"
                prepend-inner-icon="tabler-user"
                placeholder="Client Name"
                persistent-placeholder
                readonly
              />
            </VCol>
            <!-- 👉 Merge -->
            <VCol
              md="4"
              cols="12"
            />
              
            <!-- 👉 Address -->
            <VCol
              md="6"
              cols="12"
            >
              <AppTextField
                v-model="localMissionData.address"
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
                v-model="localMissionData.postcode"
                readonly
                label="Postcode"
                :rules="[integerValidator]"
              />
            </VCol>

            <!-- 👉 city -->
            <VCol
              md="2"
              cols="12"
            >
              <AppTextField
                v-model="localMissionData.city"
                label="City"
                readonly
              />
            </VCol>

            <!-- 👉 Country -->
            <VCol
              md="2"
              cols="12"
            >
              <AppTextField
                v-model="localMissionData.country"
                label="Country"
                readonly
              />
            </VCol>
            <!-- 👉 Main Phone Number -->
            <VCol
              md="4"
              cols="12"
            >
              <AppTextField
                v-model="localMissionData.main_phone_number"
                label="Phone Number"
                prepend-inner-icon="tabler-phone"
                placeholder="Phone number "
                persistent-placeholder
                readonly
                :rules="[integerValidator]"
              />
            </VCol>
              
            <!-- 👉 Client Email -->
            <VCol
              md="4"
              cols="12"
            >
              <AppTextField
                v-model="localMissionData.client_email"
                label="Email"
                prepend-inner-icon="tabler-mail"
                placeholder="Email "
                persistent-placeholder
                readonly
                :rules="[emailValidator]"
              />
            </VCol>
              
            <!-- 👉 Client Website -->
            <VCol
              md="4"
              cols="12"
            >
              <AppTextField
                v-model="localMissionData.client_website"
                label="Web-Site"
                prepend-inner-icon="tabler-world-www"
                placeholder="Web-Site "
                persistent-placeholder
                readonly
                :rules="[urlValidator]"
              />
            </VCol>
          </VRow>
        </VCardText>
      </VCard>
    </VCol>
    <VCol cols="12">
      <!-- 👉 Park Information -->
      <VCard
        v-if="localMissionData.park_id"
        title="Park Information"
      >
        <VCardText class="pt-2">
          <VRow>
            <!-- 👉 Park Id -->
            <VCol
              md="4"
              cols="12"
            >
              <AppTextField
                v-model="localMissionData.park_id"
                label="Park Id"
                readonly
                prepend-inner-icon="tabler-scan"
                persistent-placeholder
              />
            </VCol>
            <!-- 👉 Park Title -->
            <VCol
              md="4"
              cols="12"
            >
              <AppTextField
                v-model="localMissionData.park_title"
                label="Park Title"
                prepend-inner-icon="tabler-flame"
                placeholder="Park Title"
                persistent-placeholder
                readonly
              />
            </VCol>
            <!-- 👉 park type -->
            <VCol
              md="4"
              cols="12"
            >
              <AppTextField
                v-model="localMissionData.park_type"
                label="Type"
                density="compact"
                readonly
              />
            </VCol>
            <!-- 👉 Address -->
            <VCol
              md="6"
              cols="12"
            >
              <AppTextField
                v-model="localMissionData.park_address"
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
                v-model="localMissionData.park_postcode"
                label="Postcode"
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
                v-model="localMissionData.park_city"
                label="City"
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
                v-model="localMissionData.park_country"
                label="Country"
                placeholder="Tunisia"
                persistent-placeholder
                readonly
              />
            </VCol>
          </VRow>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
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

      <VBtn @click="next">
        Next
        <VIcon
          icon="tabler-arrow-right"
          end
          class="flip-in-rtl"
        />
      </VBtn>
    </div>
  </VCol>
</template>
