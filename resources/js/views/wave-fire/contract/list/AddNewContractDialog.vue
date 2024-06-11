<script setup>
import { useContractListStore } from '../useContractListStore'

const props = defineProps({
  isDialogVisible: {
    type: Boolean,
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

const contractTypes = [
  {
    title: 'Intervention',
    value: 'intervention',
    icon: {
      icon: 'tabler-progress-check',
      size: '28',
    },
  },
  {
    title: 'WorkShop',
    value: 'workshop',
    icon: {
      icon: 'tabler-building-warehouse',
      size: '28',
    },
  },
]

const contractFrequency = [
  {
    title: 'None',
    value: 'none',
    icon: {
      icon: 'tabler-alarm-off',
      size: '28',
    },
  },
  {
    title: 'Half-Yearly',
    value: 'half-yearly',
    icon: {
      icon: 'tabler-clock-hour-6',
      size: '28',
    },
  },
  {
    title: 'Yearly',
    value: 'yearly',
    icon: {
      icon: 'tabler-clock-hour-12',
      size: '28',
    },
  },
]

const contractData = ref({
  client_id: '',
  contract_client_id: '',
  client_name: '',
  client_website: '',
  main_phone_number: '',
  client_email: '',
  address: '',
  postcode: '',
  city: '',
  country: '',
  contract_type: '',
  contract_frequency: '',
  park_id: '',
})

const resetForm = () => {
  emit('update:isDialogVisible', false)
  contractData.value = {
    client_id: '',
    contract_client_id: '',
    client_name: '',
    client_website: '',
    main_phone_number: '',
    client_email: '',
    address: '',
    postcode: '',
    city: '',
    country: '',
    contract_type: '',
    contract_frequency: '',
    park_id: '',
  }
}

const currentStep = ref(0)

const createApp = [
  {
    icon: 'tabler-user-dollar',
    title: 'Client',
  },
  {
    icon: 'tabler-adjustments-code',
    title: 'Type',
  },
  {
    icon: 'tabler-map-pin',
    title: 'Park',
  },
  {
    icon: 'tabler-hourglass-empty',
    title: 'Frequency',
  },
]

const contractListStore = useContractListStore()
const parks = ref([])

const clientData = ref({
  client_id: '',
  client_name: '',
  client_website: '',
  main_phone_number: '',
  client_email: '',
  address: '',
  postcode: '',
  city: '',
  country: '',
})

const parkData = ref({
  park_id: '',
  park_type: '',
  park_title: '',
  park_address: '',
  park_postcode: '',
  park_city: '',
  park_country: '',
})

// 👉 Fetch Client
const fetchClient = () => {
  if (!contractData.value.client_id) return
  contractListStore.fetchClient(contractData.value.client_id)
    .then(response => {
      clientData.value = response.data.data
      contractData.value.contract_client_id = clientData.value.client_id
      contractData.value.client_name = clientData.value.client_name
      contractData.value.client_website = clientData.value.client_website
      contractData.value.main_phone_number = clientData.value.main_phone_number
      contractData.value.client_email = clientData.value.client_email
      contractData.value.address = clientData.value.address
      contractData.value.postcode = clientData.value.postcode
      contractData.value.city = clientData.value.city
      contractData.value.country = clientData.value.country
      console.log(clientData.value)
    }).catch(error => {
      console.error(error)
    })
}

const fetchClientParks = () => {
  if (!contractData.value.client_id) return
  contractListStore.fetchClientParks(contractData.value.client_id)
    .then(response => {
      parks.value = response.data.data.map(park => ({ ...park }))
      console.log(parks.value)
    }).catch(error => {
      console.error(error)
    })
}


// 👉 Fetch Park
const fetchPark = () => {
  if (!contractData.value.park) return
  contractListStore.fetchPark(contractData.value.park)
    .then(response => {
      parkData.value = response.data.data
      contractData.value.park = parkData.value.id
      contractData.value.park_id = parkData.value.park_id
      contractData.value.park_type = parkData.value.park_type
      contractData.value.park_title = parkData.value.park_title
      contractData.value.park_address = parkData.value.park_address
      contractData.value.park_postcode = parkData.value.park_postcode
      contractData.value.park_city = parkData.value.park_city
      contractData.value.park_country = parkData.value.park_country
      console.log(parkData.value)
    }).catch(error => {
      console.error(error)
    })
}

watch(
  () => contractData.value.client_id,
  (newValue, oldValue) => {
    fetchClientParks()
    fetchClient()
  },
)

watch(
  () => contractData.value.park,
  (newValue, oldValue) => {
    fetchPark()
  },
)


const onFormSubmit = () => {
  emit('update:isDialogVisible', false)
  emit('submit', contractData.value)
}
</script>

<template>
  <VDialog
    :model-value="props.isDialogVisible"
    max-width="900"
    @update:model-value="val => $emit('update:isDialogVisible', val)"
  >
    <!-- 👉 Dialog close btn -->
    <DialogCloseBtn @click="$emit('update:isDialogVisible', false)" />
    <!-- Dialog Content -->
    <VCard class="create-app-dialog">
      <VCardText class="pa-5 pa-sm-10">
        <h5 class="text-h5 text-center mb-2">
          Add New Contract
        </h5>
        <p class="text-sm text-center mb-8">
          Provide data with this form to add new contract.
        </p>
        <VRow>
          <VCol
            cols="12"
            sm="5"
            md="4"
            lg="3"
          >
            <AppStepper
              v-model:current-step="currentStep"
              direction="vertical"
              :items="createApp"
              icon-size="24"
              class="stepper-icon-step-bg"
            />
          </VCol>

          <VCol
            cols="12"
            sm="7"
            md="8"
            lg="9"
          >
            <VForm
              class="mt-4"
              @submit.prevent="onFormSubmit"
            >
              <VWindow
                v-model="currentStep"
                class="disable-tab-transition stepper-content"
              >
                <!-- 👉 Client -->
                <VWindowItem>
                  <h6 class="text-h6 my-4">
                    Client Details
                  </h6>
                  <VRow>
                    <VCol cols="12">
                      <!-- 👉 Client -->
                      <AppSelect
                        v-model="contractData.client_id"
                        label="Select Client"
                        item-title="client_name"
                        item-value="id"
                        :items="props.clients"
                        clearable
                        clear-icon="tabler-x"
                        @input="fetchClientParks; fetchClient"
                      >
                        <template #item="{ props: itemProps, item }">  
                          <VListItem
                            v-bind="itemProps"
                            :subtitle="item.raw.client_id"
                          />
                        </template>
                      </AppSelect>
                    </VCol>
                  </VRow>
                  <VRow v-if="contractData.client_id">
                    <!-- 👉 Client Id -->
                    <VCol
                      v-show="false"
                      cols="12"
                    >
                      <AppTextField
                        v-model="contractData.contract_client_id"
                        label="Client Id"
                        readonly
                        prepend-inner-icon="tabler-scan"
                        persistent-placeholder
                      />
                    </VCol>

                    <!-- 👉 Client Name -->
                    <VCol
                      v-show="false"
                      cols="12"
                    >
                      <AppTextField
                        v-model="contractData.client_name"
                        label="Client Name"
                        prepend-inner-icon="tabler-user"
                        placeholder="Client Name"
                        persistent-placeholder
                        readonly
                      />
                    </VCol>
              
                    <!-- 👉 Address -->
                    <VCol
                      md="6"
                      cols="12"
                    >
                      <AppTextField
                        v-model="contractData.address"
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
                        v-model="contractData.postcode"
                        label="postcode"
                      />
                    </VCol>

                    <!-- 👉 city -->
                    <VCol
                      md="2"
                      cols="12"
                    >
                      <AppTextField
                        v-model="contractData.city"
                        label="city"
                      />
                    </VCol>

                    <!-- 👉 Country -->
                    <VCol
                      md="2"
                      cols="12"
                    >
                      <AppTextField
                        v-model="contractData.country"
                        label="Country"
                      />
                    </VCol>
                    <!-- 👉 Main Phone Number -->
                    <VCol
                      md="4"
                      cols="12"
                    >
                      <AppTextField
                        v-model="contractData.main_phone_number"
                        label="Phone Number"
                        prepend-inner-icon="tabler-phone"
                        placeholder="Phone number "
                        persistent-placeholder
                      />
                    </VCol>
              
                    <!-- 👉 Client Email -->
                    <VCol
                      md="4"
                      cols="12"
                    >
                      <AppTextField
                        v-model="contractData.client_email"
                        label="Email"
                        prepend-inner-icon="tabler-mail"
                        placeholder="Email "
                        persistent-placeholder
                      />
                    </VCol>
              
                    <!-- 👉 Client Website -->
                    <VCol
                      md="4"
                      cols="12"
                    >
                      <AppTextField
                        v-model="contractData.client_website"
                        label="Web-Site"
                        prepend-inner-icon="tabler-world-www"
                        placeholder="Web-Site "
                        persistent-placeholder
                      />
                    </VCol>
                  </VRow>
                </VWindowItem>
                <VWindowItem>
                  <!-- 👉 Type -->
                  <VCol cols="12">
                    <h6 class="text-h6 my-4">
                      Contract's Type
                    </h6>
                    <CustomRadiosWithIcon
                      v-model:selected-radio="contractData.contract_type"
                      :radio-content="contractTypes"
                      :grid-column="{ sm: '6', cols: '12' }"
                    />
                  </VCol>  
                </VWindowItem>
                <VWindowItem>
                  <VRow v-if="contractData.contract_type === 'intervention'">
                    <VCol cols="12">
                      <AppSelect
                        v-model="contractData.park"
                        label="Select Park"
                        item-title="park_id"
                        :items="parks"
                        item-value="id"
                        clearable
                        clear-icon="tabler-x"
                        @input="fetchPark"
                      >
                        <template #item="{ props: itemProps, item }">  
                          <VListItem
                            v-bind="itemProps"
                            :subtitle="item.raw.park_address"
                          />
                        </template>
                      </AppSelect>
                    </VCol>
                    <VRow v-if="contractData.park">
                      <!-- 👉 Park Id -->
                      <VCol
                        v-show="false"
                        md="4"
                        cols="12"
                      >
                        <AppTextField
                          v-model="contractData.park_id"
                          label="Client Id"
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
                          v-model="contractData.park_title"
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
                          v-model="contractData.park_type"
                          label="Type"
                          density="compact"
                        />
                      </VCol>
                      <!-- 👉 Address -->
                      <VCol
                        md="6"
                        cols="12"
                      >
                        <AppTextField
                          v-model="contractData.park_address"
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
                          v-model="contractData.park_postcode"
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
                          v-model="contractData.park_city"
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
                          v-model="contractData.park_country"
                          label="Country"
                          placeholder="Tunisia"
                          persistent-placeholder
                          readonly
                        />
                      </VCol>
                    </VRow>                  
                  </VRow>
                  <VRow v-if="contractData.contract_type === 'workshop'">
                    <VCol cols="12">
                      <h3>No park selection needed for workshop contracts!</h3>
                    </VCol>
                  </VRow>
                </VWindowItem>
                <VWindowItem>
                  <VCol cols="12">
                    <h6 class="text-h6 my-4">
                      Contract's Type
                    </h6>
                    <CustomRadiosWithIcon
                      v-model:selected-radio="contractData.contract_frequency"
                      :radio-content="contractFrequency"
                      :grid-column="{ sm: '4', cols: '6' }"
                    />
                  </VCol>
                </VWindowItem>
              </VWindow>
            </VForm>

            <div class="d-flex justify-space-between mt-8">
              <VBtn
                variant="tonal"
                color="secondary"
                :disabled="currentStep === 0"
                @click="currentStep--"
              >
                <VIcon
                  icon="tabler-arrow-left"
                  start
                  class="flip-in-rtl"
                />
                Previous
              </VBtn>

              <VBtn
                v-if="createApp.length - 1 === currentStep"
                color="success"
                type="submit"
                @click="onFormSubmit"
              >
                submit
                <VIcon
                  icon="tabler-check"
                  end
                  class="flip-in-rtl"
                />
              </VBtn>

              <VBtn
                v-else
                @click="currentStep++"
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
      </VCardText>
    </VCard>
  </VDialog>
</template>

<style lang="scss">
.stepper-content .card-list {
  --v-card-list-gap: 24px;
}
</style>
../useContractListStore
