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
  clientData: {
    type: Object,
    required: true,
  },
  countries: {
    type: Array,
    required: true,
  },
})

const emit = defineEmits([
  'update:currentStep',
  'submit',
])

const localClientData = ref((props.clientData))
const refVForm = ref()

const updateClientData = async () => {
  emit('submit', localClientData.value)
}

const onSubmit = () => {
  refVForm.value?.validate().then(({ valid: isValid }) => {
    if (isValid) {
      updateClientData() // Emit the updated data
      emit('update:currentStep', props.currentStep ? props.currentStep + 1 : 1)
    }
  })
}

watch(() => props.currentStep, updateClientData)

//SECTION Items

// 👉 search filters
const types = [
  {
    title: 'Individual Client',
    value: 'individual client',
  },
  {
    title: 'Small Business Client ',
    value: 'small business client ',
  },
  {
    title: 'Enterprise Client',
    value: 'enterprise client',
  },
  {
    title: 'Government Client',
    value: 'government client',
  },
  {
    title: 'Non-Profit Client',
    value: 'non-profit client',
  },
  {
    title: 'Key Account',
    value: 'key account',
  },
]

const activities = [
  {
    title: 'Agriculture',
    value: 'agriculture',
  },
  {
    title: 'Automotive',
    value: 'automotive',
  },
  {
    title: 'Banking and Finance',
    value: 'banking and finance',
  },
  {
    title: 'Construction',
    value: 'construction',
  },
  {
    title: 'Education',
    value: 'education',
  },
  {
    title: 'Energy',
    value: 'energy',
  },
  {
    title: 'Healthcare',
    value: 'healthcare',
  },
  {
    title: 'Hospitality and Tourism',
    value: 'hospitality and tourism',
  },
  {
    title: 'Information Technology (IT)',
    value: 'information technology',
  },
  {
    title: 'Manufacturing',
    value: 'manufacturing',
  },
  {
    title: 'Real Estate',
    value: 'real estate',
  },
  {
    title: 'Retail',
    value: 'retail',
  },
  {
    title: 'Telecommunications',
    value: 'telecommunications',
  },
  {
    title: 'Transportation and Logistics',
    value: 'transportation and logistics',
  },
  {
    title: 'Utilities',
    value: 'utilities',
  },
  {
    title: 'Wholesale/Retail Trade',
    value: 'wholesale retail trade',
  },
  {
    title: 'Media and Entertainment',
    value: 'media and entertainment',
  },
  {
    title: 'Legal and Professional Services',
    value: 'legal and professional services',
  },
]

const status = [
  {
    title: 'Pending',
    value: 'pending',
  },
  {
    title: 'Active',
    value: 'active',
  },
  {
    title: 'Inactive',
    value: 'inactive',
  },
]

//!SECTION Items
</script>

<template>
  <VRow>
    <VCol cols="12">
      <!-- 👉 Client Basic Information -->
      <VCard title="Insert Client Basic Information">
        <VCardText class="pt-2">
          <!-- 👉 Form -->
          <VForm
            ref="refVForm"
            lazy-validation
            class="mt-1"
            @submit.prevent="onSubmit"
          >
            <VRow>
              <!-- 👉 Client Id -->
              <VCol
                md="4"
                cols="12"
              >
                <AppTextField
                  v-model="localClientData.client_id"
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
                  v-model="localClientData.client_name"
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
                  v-model="localClientData.address"
                  label="Address"
                  prepend-inner-icon="tabler-map-pin"
                  placeholder="Address "
                  persistent-placeholder
                />
              </VCol>

              <!-- 👉 postcode -->
              <VCol
                md="2"
                cols="12"
              >
                <AppTextField
                  v-model="localClientData.postcode"
                  label="postcode"
                  :rules="[integerValidator]"
                />
              </VCol>

              <!-- 👉 city -->
              <VCol
                md="2"
                cols="12"
              >
                <AppTextField
                  v-model="localClientData.city"
                  label="city"
                />
              </VCol>

              <!-- 👉 Country -->
              <VCol
                md="2"
                cols="12"
              >
                <AppSelect
                  v-model="localClientData.country"
                  label="Country"
                  :items="countries"
                />
              </VCol>
              <!-- 👉 Main Phone Number -->
              <VCol
                md="4"
                cols="12"
              >
                <AppTextField
                  v-model="localClientData.main_phone_number"
                  label="Phone Number"
                  prepend-inner-icon="tabler-phone"
                  placeholder="Phone number "
                  persistent-placeholder
                  :rules="[integerValidator]"
                />
              </VCol>
              
              <!-- 👉 Client Email -->
              <VCol
                md="4"
                cols="12"
              >
                <AppTextField
                  v-model="localClientData.client_email"
                  label="Email"
                  prepend-inner-icon="tabler-mail"
                  placeholder="Email "
                  persistent-placeholder
                  :rules="[emailValidator]"
                />
              </VCol>
              
              <!-- 👉 Client Website -->
              <VCol
                md="4"
                cols="12"
              >
                <AppTextField
                  v-model="localClientData.client_website"
                  label="Web-Site"
                  prepend-inner-icon="tabler-world-www"
                  placeholder="Web-Site "
                  persistent-placeholder
                  :rules="[urlValidator]"
                />
              </VCol>

              <!-- 👉 client type -->
              <VCol
                md="4"
                cols="12"
              >
                <AppAutocomplete
                  v-model="localClientData.client_type"
                  label="Type"
                  density="compact"
                  :items="types"
                />
              </VCol>

              <!-- 👉 Client Activity -->
              <VCol
                md="4"
                cols="12"
              >
                <AppAutocomplete
                  v-model="localClientData.client_activity"
                  label="Activity"
                  density="compact"
                  :items="activities"
                />
              </VCol>
              
              <!-- 👉 Client Status -->
              <VCol
                md="4"
                cols="12"
              >
                <AppAutocomplete
                  v-model="localClientData.client_status"
                  label="Status"
                  density="compact"
                  :items="status"
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

                  <VBtn
                    type="submit"
                    @click="refVForm?.validate()"
                  >
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
