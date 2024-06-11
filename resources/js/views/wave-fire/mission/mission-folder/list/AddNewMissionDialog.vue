<script setup>
import { useMissionListStore } from '../useMissionListStore'

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

const missionTypes = [
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

const missionFrequency = [
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

const missionData = ref({
  client_id: '',
  mission_client_id: '',
  client_name: '',
  client_website: '',
  main_phone_number: '',
  client_email: '',
  address: '',
  postcode: '',
  city: '',
  country: '',
  mission_type: '',
  mission_frequency: '',
  park_id: '',
})

const resetForm = () => {
  emit('update:isDialogVisible', false)
  missionData.value = {
    client_id: '',
    mission_client_id: '',
    client_name: '',
    client_website: '',
    main_phone_number: '',
    client_email: '',
    address: '',
    postcode: '',
    city: '',
    country: '',
    mission_type: '',
    mission_frequency: '',
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

const missionListStore = useMissionListStore()
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
  if (!missionData.value.client_id) return
  missionListStore.fetchClient(missionData.value.client_id)
    .then(response => {
      clientData.value = response.data.data
      missionData.value.mission_client_id = clientData.value.client_id
      missionData.value.client_name = clientData.value.client_name
      missionData.value.client_website = clientData.value.client_website
      missionData.value.main_phone_number = clientData.value.main_phone_number
      missionData.value.client_email = clientData.value.client_email
      missionData.value.address = clientData.value.address
      missionData.value.postcode = clientData.value.postcode
      missionData.value.city = clientData.value.city
      missionData.value.country = clientData.value.country
      console.log(clientData.value)
    }).catch(error => {
      console.error(error)
    })
}

const fetchClientParks = () => {
  if (!missionData.value.client_id) return
  missionListStore.fetchClientParks(missionData.value.client_id)
    .then(response => {
      parks.value = response.data.data.map(park => ({ ...park }))
      console.log(parks.value)
    }).catch(error => {
      console.error(error)
    })
}


// 👉 Fetch Park
const fetchPark = () => {
  if (!missionData.value.park) return
  missionListStore.fetchPark(missionData.value.park)
    .then(response => {
      parkData.value = response.data.data
      missionData.value.park = parkData.value.id
      missionData.value.park_id = parkData.value.park_id
      missionData.value.park_type = parkData.value.park_type
      missionData.value.park_title = parkData.value.park_title
      missionData.value.park_address = parkData.value.park_address
      missionData.value.park_postcode = parkData.value.park_postcode
      missionData.value.park_city = parkData.value.park_city
      missionData.value.park_country = parkData.value.park_country
      console.log(parkData.value)
    }).catch(error => {
      console.error(error)
    })
}

watch(
  () => missionData.value.client_id,
  (newValue, oldValue) => {
    fetchClientParks()
    fetchClient()
  },
)

watch(
  () => missionData.value.park,
  (newValue, oldValue) => {
    fetchPark()
  },
)


const onFormSubmit = () => {
  emit('update:isDialogVisible', false)
  emit('submit', missionData.value)
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
          Add New Mission
        </h5>
        <p class="text-sm text-center mb-8">
          Provide data with this form to add new mission.
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
                        v-model="missionData.client_id"
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
                  <VRow v-if="missionData.client_id">
                    <!-- 👉 Client Id -->
                    <VCol
                      v-show="false"
                      cols="12"
                    >
                      <AppTextField
                        v-model="missionData.mission_client_id"
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
                        v-model="missionData.client_name"
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
                        v-model="missionData.address"
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
                        v-model="missionData.postcode"
                        label="postcode"
                      />
                    </VCol>

                    <!-- 👉 city -->
                    <VCol
                      md="2"
                      cols="12"
                    >
                      <AppTextField
                        v-model="missionData.city"
                        label="city"
                      />
                    </VCol>

                    <!-- 👉 Country -->
                    <VCol
                      md="2"
                      cols="12"
                    >
                      <AppTextField
                        v-model="missionData.country"
                        label="Country"
                      />
                    </VCol>
                    <!-- 👉 Main Phone Number -->
                    <VCol
                      md="4"
                      cols="12"
                    >
                      <AppTextField
                        v-model="missionData.main_phone_number"
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
                        v-model="missionData.client_email"
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
                        v-model="missionData.client_website"
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
                      Mission's Type
                    </h6>
                    <CustomRadiosWithIcon
                      v-model:selected-radio="missionData.mission_type"
                      :radio-content="missionTypes"
                      :grid-column="{ sm: '6', cols: '12' }"
                    />
                  </VCol>  
                </VWindowItem>
                <VWindowItem>
                  <VRow v-if="missionData.mission_type === 'intervention'">
                    <VCol cols="12">
                      <AppSelect
                        v-model="missionData.park"
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
                    <VRow v-if="missionData.park">
                      <!-- 👉 Park Id -->
                      <VCol
                        v-show="false"
                        md="4"
                        cols="12"
                      >
                        <AppTextField
                          v-model="missionData.park_id"
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
                          v-model="missionData.park_title"
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
                          v-model="missionData.park_type"
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
                          v-model="missionData.park_address"
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
                          v-model="missionData.park_postcode"
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
                          v-model="missionData.park_city"
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
                          v-model="missionData.park_country"
                          label="Country"
                          placeholder="Tunisia"
                          persistent-placeholder
                          readonly
                        />
                      </VCol>
                    </VRow>                  
                  </VRow>
                  <VRow v-if="missionData.mission_type === 'workshop'">
                    <VCol cols="12">
                      <h3>No park selection needed for workshop missions!</h3>
                    </VCol>
                  </VRow>
                </VWindowItem>
                <VWindowItem>
                  <VCol cols="12">
                    <h6 class="text-h6 my-4">
                      Mission's Type
                    </h6>
                    <CustomRadiosWithIcon
                      v-model:selected-radio="missionData.mission_frequency"
                      :radio-content="missionFrequency"
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
