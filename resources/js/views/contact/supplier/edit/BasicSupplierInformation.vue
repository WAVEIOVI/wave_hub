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
  supplierData: {
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

const localSupplierData = ref((props.supplierData))
const refVForm = ref()

const updateSupplierData = async () => {
  emit('submit', localSupplierData.value)
}

const onSubmit = () => {
  refVForm.value?.validate().then(({ valid: isValid }) => {
    if (isValid) {
      updateSupplierData() // Emit the updated data
      emit('update:currentStep', props.currentStep ? props.currentStep + 1 : 1)
    }
  })
}

watch(() => props.currentStep, updateSupplierData)

//SECTION Items

// 👉 search filters
const types = [
  {
    title: 'Individual Supplier',
    value: 'individual supplier',
  },
  {
    title: 'Small Business Supplier ',
    value: 'small business supplier ',
  },
  {
    title: 'Enterprise Supplier',
    value: 'enterprise supplier',
  },
  {
    title: 'Government Supplier',
    value: 'government supplier',
  },
  {
    title: 'Non-Profit Supplier',
    value: 'non-profit supplier',
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
      <!-- 👉 Supplier Additional Details -->
      <VCard title="Insert Supplier Additional Details">
        <VCardText class="pt-2">
          <!-- 👉 Form -->
          <VForm
            ref="refVForm"
            lazy-validation
            class="mt-1"
            @submit.prevent="onSubmit"
          >
            <VRow>
              <!-- 👉 Supplier Id -->
              <VCol
                md="4"
                cols="12"
              >
                <AppTextField
                  v-model="localSupplierData.supplier_id"
                  label="Supplier Id"
                  readonly
                  prepend-inner-icon="tabler-scan"
                  persistent-placeholder
                />
              </VCol>

              <!-- 👉 Supplier Name -->
              <VCol
                md="4"
                cols="12"
              >
                <AppTextField
                  v-model="localSupplierData.supplier_name"
                  label="Supplier Name"
                  prepend-inner-icon="tabler-user"
                  placeholder="Supplier Name"
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
                  v-model="localSupplierData.address"
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
                  v-model="localSupplierData.postcode"
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
                  v-model="localSupplierData.city"
                  label="city"
                />
              </VCol>

              <!-- 👉 Country -->
              <VCol
                md="2"
                cols="12"
              >
                <AppSelect
                  v-model="localSupplierData.Country"
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
                  v-model="localSupplierData.main_phone_number"
                  label="Phone Number"
                  prepend-inner-icon="tabler-phone"
                  placeholder="Phone number "
                  persistent-placeholder
                  :rules="[integerValidator]"
                />
              </VCol>
              
              <!-- 👉 Supplier Email -->
              <VCol
                md="4"
                cols="12"
              >
                <AppTextField
                  v-model="localSupplierData.supplier_email"
                  label="Email"
                  prepend-inner-icon="tabler-mail"
                  placeholder="Email "
                  persistent-placeholder
                  :rules="[emailValidator]"
                />
              </VCol>
              
              <!-- 👉 Supplier Website -->
              <VCol
                md="4"
                cols="12"
              >
                <AppTextField
                  v-model="localSupplierData.supplier_website"
                  label="Web-Site"
                  prepend-inner-icon="tabler-world-www"
                  placeholder="Web-Site "
                  persistent-placeholder
                  :rules="[urlValidator]"
                />
              </VCol>

              <!-- 👉 supplier type -->
              <VCol
                md="4"
                cols="12"
              >
                <AppAutocomplete
                  v-model="localSupplierData.supplier_type"
                  label="Type"
                  density="compact"
                  :items="types"
                />
              </VCol>

              <!-- 👉 Supplier Activity -->
              <VCol
                md="4"
                cols="12"
              >
                <AppAutocomplete
                  v-model="localSupplierData.supplier_activity"
                  label="Activity"
                  density="compact"
                  :items="activities"
                />
              </VCol>
              
              <!-- 👉 Supplier Status -->
              <VCol
                md="4"
                cols="12"
              >
                <AppAutocomplete
                  v-model="localSupplierData.supplier_status"
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
