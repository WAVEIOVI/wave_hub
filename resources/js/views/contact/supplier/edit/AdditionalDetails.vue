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
})

const emit = defineEmits([
  'update:currentStep',
  'submit',
])

const localSupplierData = ref((props.supplierData))
const refVForm = ref()

const Previous = () => {
  emit('update:currentStep', props.currentStep ? props.currentStep - 1 : 1)
}

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
              <!-- 👉 Tax ID -->
              <VCol
                md="4"
                cols="12"
              >
                <AppTextField
                  v-model="localSupplierData.tax_id"
                  label="Tax Id"
                  prepend-inner-icon="tabler-scan"
                  placeholder="TAX ID"
                  persistent-placeholder
                />
              </VCol>

              <!-- 👉 Rne id -->
              <VCol
                md="4"
                cols="12"
              >
                <AppTextField
                  v-model="localSupplierData.rne_id"
                  label="RNE ID"
                  prepend-inner-icon="tabler-scan"
                  placeholder="RNE ID"
                  persistent-placeholder
                />
              </VCol>
              <!-- 👉 RNE Verification -->
              <VCol
                md="4"
                cols="12"
              />
              <!-- 👉 Company Form Legal -->
              <VCol
                md="4"
                cols="12"
              >
                <AppTextField
                  v-model="localSupplierData.company_form_legal"
                  label="Company Form Legal"
                  prepend-inner-icon="tabler-certificate"
                  placeholder="Company Form Legal"
                  persistent-placeholder
                />
              </VCol>

              <!-- 👉 Company Capital -->
              <VCol
                md="4"
                cols="12"
              >
                <AppTextField
                  v-model="localSupplierData.company_capital"
                  label="Company Capital"
                  prepend-inner-icon="tabler-file-dollar"
                  placeholder="Company Capital"
                  persistent-placeholder
                  :rules="[integerValidator]"
                />
              </VCol>
              <!-- 👉 Created Date -->
              <VCol
                md="4"
                cols="12"
              >
                <AppDateTimePicker
                  v-model="localSupplierData.created_date"
                  prepend-inner-icon="tabler-calendar-check"
                  label="Created Date"
                />
              </VCol>
              <!-- 👉 VAT Exemption Certificate -->
              <VCol cols="12">
                <VRow>
                  <VCol cols="12">
                    <VCheckbox
                      v-model="localSupplierData.has_vat_exemption_cert"
                      label="VAT Exemption Certificate"
                    />
                  </VCol>
                  <VCol cols="12">
                    <VRow v-show="localSupplierData.has_vat_exemption_cert === true">
                      <!-- 👉 VAT Exemption Certificate ID -->
                      <VCol 
                        cols="12"
                        md="4"
                      >
                        <AppTextField
                          v-model="localSupplierData.vat_exemption_cert_id"
                          label="VAT Exemption Certificate ID"
                          prepend-inner-icon="tabler-scan"
                          placeholder="VAT Exemption Certificate ID"
                          persistent-placeholder
                        />
                      </VCol>

                      <!-- 👉 Date of issue VAT Exemption Certificate -->
                      <VCol
                        cols="6"
                        md="4"
                      >
                        <AppDateTimePicker
                          v-model="localSupplierData.vat_exemption_start"
                          prepend-inner-icon="tabler-calendar-check"
                          label="Issue date"
                        />
                      </VCol>
                      <!-- 👉 VAT Exemption Certificate Expiry date --> 
                      <VCol
                        cols="6"
                        md="4"
                      >
                        <AppDateTimePicker
                          v-model="localSupplierData.vat_exemption_end"
                          prepend-inner-icon="tabler-calendar-x"
                          label="Expiration Date"
                        />
                      </VCol>
                    </VRow>
                  </VCol>
                </VRow>
              </VCol>
              <!-- 👉 Bank Name -->
              <VCol
                md="3"
                cols="12"
              >
                <AppTextField
                  v-model="localSupplierData.bank_name"
                  label="Bank Name"
                  prepend-inner-icon="tabler-building-bank"
                  placeholder="Bank Name"
                  persistent-placeholder
                />
              </VCol>

              <!-- 👉 Bank Agency -->
              <VCol
                md="3"
                cols="12"
              >
                <AppTextField
                  v-model="localSupplierData.bank_agency"
                  label="Bank Agency"
                  prepend-inner-icon="tabler-building-bank"
                  placeholder="Bank Agency"
                  persistent-placeholder
                  :rules="[integerValidator]"
                />
              </VCol>
              <!-- 👉 Bank RIB -->
              <VCol
                md="3"
                cols="12"
              >
                <AppTextField
                  v-model="localSupplierData.bank_rib"
                  label="Bank RIB"
                  prepend-inner-icon="tabler-building-bank"
                  placeholder="Bank RIB"
                  persistent-placeholder
                />
              </VCol>
              <!-- 👉 payment_terms -->
              <VCol
                md="3"
                cols="12"
              >
                <AppTextField
                  v-model="localSupplierData.payment_terms"
                  label="Payment Terms"
                  prepend-inner-icon="tabler-building-bank"
                  placeholder="Payment Terms"
                  persistent-placeholder
                />
              </VCol>
              <!-- 👉 Supplier Note -->
              <VCol cols="12">
                <AppTextarea 
                  v-model="localSupplierData.supplier_note"
                  label="Supplier Note"
                  prepend-inner-icon="tabler-note"
                  placeholder="Supplier Note"
                  persistent-placeholder
                />
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
