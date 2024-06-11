<script setup>
import { useClientListStore } from '@/views/contact/client/useClientListStore'
import { avatarText } from '@core/utils/formatters'
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import AddNewAddressDialog from './AddNewAddressDialog.vue'
import EditAddressDialog from './EditAddressDialog.vue'
import ViewAddressDialog from './ViewAddressDialog.vue'

const props = defineProps({
  addressesHeaders: {
    type: Array,
    required: true,
  },
})

const countries = [
  { title: 'Afghanistan', value: 'afghanistan' },
  { title: 'Albania', value: 'albania' },
  { title: 'Algeria', value: 'algeria' },
  { title: 'Andorra', value: 'andorra' },
  { title: 'Angola', value: 'angola' },
  { title: 'Antigua and Barbuda', value: 'antigua_and_barbuda' },
  { title: 'Argentina', value: 'argentina' },
  { title: 'Armenia', value: 'armenia' },
  { title: 'Australia', value: 'australia' },
  { title: 'Austria', value: 'austria' },
  { title: 'Azerbaijan', value: 'azerbaijan' },
  { title: 'Bahamas', value: 'bahamas' },
  { title: 'Bahrain', value: 'bahrain' },
  { title: 'Bangladesh', value: 'bangladesh' },
  { title: 'Barbados', value: 'barbados' },
  { title: 'Belarus', value: 'belarus' },
  { title: 'Belgium', value: 'belgium' },
  { title: 'Belize', value: 'belize' },
  { title: 'Benin', value: 'benin' },
  { title: 'Bhutan', value: 'bhutan' },
  { title: 'Bolivia', value: 'bolivia' },
  { title: 'Bosnia and Herzegovina', value: 'bosnia_and_herzegovina' },
  { title: 'Botswana', value: 'botswana' },
  { title: 'Brazil', value: 'brazil' },
  { title: 'Brunei', value: 'brunei' },
  { title: 'Bulgaria', value: 'bulgaria' },
  { title: 'Burkina Faso', value: 'burkina_faso' },
  { title: 'Burundi', value: 'burundi' },
  { title: "Côte d'Ivoire", value: 'cote_divoire' },
  { title: 'Cabo Verde', value: 'cabo_verde' },
  { title: 'Cambodia', value: 'cambodia' },
  { title: 'Cameroon', value: 'cameroon' },
  { title: 'Canada', value: 'canada' },
  { title: 'Central African Republic', value: 'central_african_republic' },
  { title: 'Chad', value: 'chad' },
  { title: 'Chile', value: 'chile' },
  { title: 'China', value: 'china' },
  { title: 'Colombia', value: 'colombia' },
  { title: 'Comoros', value: 'comoros' },
  { title: 'Congo', value: 'congo' },
  { title: 'Costa Rica', value: 'costa_rica' },
  { title: 'Croatia', value: 'croatia' },
  { title: 'Cuba', value: 'cuba' },
  { title: 'Cyprus', value: 'cyprus' },
  { title: 'Czechia', value: 'czechia' },
  { title: 'Denmark', value: 'denmark' },
  { title: 'Djibouti', value: 'djibouti' },
  { title: 'Dominica', value: 'dominica' },
  { title: 'Dominican Republic', value: 'dominican_republic' },
  { title: 'Ecuador', value: 'ecuador' },
  { title: 'Egypt', value: 'egypt' },
  { title: 'El Salvador', value: 'el_salvador' },
  { title: 'Equatorial Guinea', value: 'equatorial_guinea' },
  { title: 'Eritrea', value: 'eritrea' },
  { title: 'Estonia', value: 'estonia' },
  { title: 'Eswatini', value: 'eswatini' },
  { title: 'Ethiopia', value: 'ethiopia' },
  { title: 'Fiji', value: 'fiji' },
  { title: 'Finland', value: 'finland' },
  { title: 'France', value: 'france' },
  { title: 'Gabon', value: 'gabon' },
  { title: 'Gambia', value: 'gambia' },
  { title: 'Georgia', value: 'georgia' },
  { title: 'Germany', value: 'germany' },
  { title: 'Ghana', value: 'ghana' },
  { title: 'Greece', value: 'greece' },
  { title: 'Grenada', value: 'grenada' },
  { title: 'Guatemala', value: 'guatemala' },
  { title: 'Guinea', value: 'guinea' },
  { title: 'Guinea-Bissau', value: 'guinea_bissau' },
  { title: 'Guyana', value: 'guyana' },
  { title: 'Haiti', value: 'haiti' },
  { title: 'Holy See', value: 'holy_see' },
  { title: 'Honduras', value: 'honduras' },
  { title: 'Hungary', value: 'hungary' },
  { title: 'Iceland', value: 'iceland' },
  { title: 'India', value: 'india' },
  { title: 'Indonesia', value: 'indonesia' },
  { title: 'Iran', value: 'iran' },
  { title: 'Iraq', value: 'iraq' },
  { title: 'Ireland', value: 'ireland' },
  { title: 'Israel', value: 'israel' },
  { title: 'Italy', value: 'italy' },
  { title: 'Jamaica', value: 'jamaica' },
  { title: 'Japan', value: 'japan' },
  { title: 'Jordan', value: 'jordan' },
  { title: 'Kazakhstan', value: 'kazakhstan' },
  { title: 'Kenya', value: 'kenya' },
  { title: 'Kiribati', value: 'kiribati' },
  { title: 'Kuwait', value: 'kuwait' },
  { title: 'Kyrgyzstan', value: 'kyrgyzstan' },
  { title: 'Laos', value: 'laos' },
  { title: 'Latvia', value: 'latvia' },
  { title: 'Lebanon', value: 'lebanon' },
  { title: 'Lesotho', value: 'lesotho' },
  { title: 'Liberia', value: 'liberia' },
  { title: 'Libya', value: 'libya' },
  { title: 'Liechtenstein', value: 'liechtenstein' },
  { title: 'Lithuania', value: 'lithuania' },
  { title: 'Luxembourg', value: 'luxembourg' },
  { title: 'Madagascar', value: 'madagascar' },
  { title: 'Malawi', value: 'malawi' },
  { title: 'Malaysia', value: 'malaysia' },
  { title: 'Maldives', value: 'maldives' },
  { title: 'Mali', value: 'mali' },
  { title: 'Malta', value: 'malta' },
  { title: 'Marshall Islands', value: 'marshall_islands' },
  { title: 'Mauritania', value: 'mauritania' },
  { title: 'Mauritius', value: 'mauritius' },
  { title: 'Mexico', value: 'mexico' },
  { title: 'Micronesia', value: 'micronesia' },
  { title: 'Moldova', value: 'moldova' },
  { title: 'Monaco', value: 'monaco' },
  { title: 'Mongolia', value: 'mongolia' },
  { title: 'Montenegro', value: 'montenegro' },
  { title: 'Morocco', value: 'morocco' },
  { title: 'Mozambique', value: 'mozambique' },
  { title: 'Myanmar', value: 'myanmar' },
  { title: 'Namibia', value: 'namibia' },
  { title: 'Nauru', value: 'nauru' },
  { title: 'Nepal', value: 'nepal' },
  { title: 'Netherlands', value: 'netherlands' },
  { title: 'New Zealand', value: 'new_zealand' },
  { title: 'Nicaragua', value: 'nicaragua' },
  { title: 'Niger', value: 'niger' },
  { title: 'Nigeria', value: 'nigeria' },
  { title: 'North Korea', value: 'north_korea' },
  { title: 'North Macedonia', value: 'north_macedonia' },
  { title: 'Norway', value: 'norway' },
  { title: 'Oman', value: 'oman' },
  { title: 'Pakistan', value: 'pakistan' },
  { title: 'Palau', value: 'palau' },
  { title: 'Palestine State', value: 'palestine_state' },
  { title: 'Panama', value: 'panama' },
  { title: 'Papua New Guinea', value: 'papua_new_guinea' },
  { title: 'Paraguay', value: 'paraguay' },
  { title: 'Peru', value: 'peru' },
  { title: 'Philippines', value: 'philippines' },
  { title: 'Poland', value: 'poland' },
  { title: 'Portugal', value: 'portugal' },
  { title: 'Qatar', value: 'qatar' },
  { title: 'Romania', value: 'romania' },
  { title: 'Russia', value: 'russia' },
  { title: 'Rwanda', value: 'rwanda' },
  { title: 'Saint Kitts and Nevis', value: 'saint_kitts_and_nevis' },
  { title: 'Saint Lucia', value: 'saint_lucia' },
  { title: 'Saint Vincent & the Grenadines', value: 'saint_vincent_and_the_grenadines' },
  { title: 'Samoa', value: 'samoa' },
  { title: 'San Marino', value: 'san_marino' },
  { title: 'Sao Tome and Principe', value: 'sao_tome_and_principe' },
  { title: 'Saudi Arabia', value: 'saudi_arabia' },
  { title: 'Senegal', value: 'senegal' },
  { title: 'Serbia', value: 'serbia' },
  { title: 'Seychelles', value: 'seychelles' },
  { title: 'Sierra Leone', value: 'sierra_leone' },
  { title: 'Singapore', value: 'singapore' },
  { title: 'Slovakia', value: 'slovakia' },
  { title: 'Slovenia', value: 'slovenia' },
  { title: 'Solomon Islands', value: 'solomon_islands' },
  { title: 'Somalia', value: 'somalia' },
  { title: 'South Africa', value: 'south_africa' },
  { title: 'South Korea', value: 'south_korea' },
  { title: 'South Sudan', value: 'south_sudan' },
  { title: 'Spain', value: 'spain' },
  { title: 'Sri Lanka', value: 'sri_lanka' },
  { title: 'Sudan', value: 'sudan' },
  { title: 'Suriname', value: 'suriname' },
  { title: 'Sweden', value: 'sweden' },
  { title: 'Switzerland', value: 'switzerland' },
  { title: 'Syria', value: 'syria' },
  { title: 'Tajikistan', value: 'tajikistan' },
  { title: 'Tanzania', value: 'tanzania' },
  { title: 'Thailand', value: 'thailand' },
  { title: 'Timor-Leste', value: 'timor-leste' },
  { title: 'Togo', value: 'togo' },
  { title: 'Tonga', value: 'tonga' },
  { title: 'Trinidad and Tobago', value: 'trinidad_and_tobago' },
  { title: 'Tunisia', value: 'tunisia' },
  { title: 'Turkey', value: 'turkey' },
  { title: 'Turkmenistan', value: 'turkmenistan' },
  { title: 'Tuvalu', value: 'tuvalu' },
  { title: 'Uganda', value: 'uganda' },
  { title: 'Ukraine', value: 'ukraine' },
  { title: 'United Arab Emirates', value: 'united_arab_emirates' },
  { title: 'United Kingdom', value: 'united_kingdom' },
  { title: 'USA', value: 'usa' },
  { title: 'Uruguay', value: 'uruguay' },
  { title: 'Uzbekistan', value: 'uzbekistan' },
  { title: 'Vanuatu', value: 'vanuatu' },
  { title: 'Venezuela', value: 'venezuela' },
  { title: 'Vietnam', value: 'vietnam' },
  { title: 'Yemen', value: 'yemen' },
  { title: 'Zambia', value: 'zambia' },
  { title: 'Zimbabwe', value: 'zimbabwe' },
]

//SECTION Declaration
const route = useRoute()
const router = useRouter()
const clientListStore = useClientListStore()
const searchQuery = ref('')
const totalPage = ref(1)
const totalAddresses = ref(0)
const addresses = ref([])
const addressData = ref([])

const options = ref({
  page: 1,
  itemsPerPage: 10,
  sortBy: [],
  groupBy: [],
  search: undefined,
})

// 👉 Address Dialog
const isAddNewAddressDialogVisible = ref(false)
const isEditAddressDialogVisible = ref(false)
const isViewAddressDialogVisible = ref(false)

//!SECTION Declaration
const paginationMeta = computed(() => {
  return (options, total) => {
    const start = (options.page - 1) * options.itemsPerPage + 1
    const end = Math.min(options.page * options.itemsPerPage, total)
    
    return `Showing ${start} to ${end} of ${total} entries`
  }
})

// 👉 Fetching addresses
const fetchClientAddresses = () => {
  clientListStore.fetchClientAddresses({
    id: Number(route.params.id),
    search: searchQuery.value,
    options: options.value,
  }).then(response => {
    addresses.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalAddresses.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
  }).catch(error => {
    console.error(error)
  })
}

// 👉 Fetch Client Address
const fetchClientAddress = addressId => {
  clientListStore.fetchClientAddress(Number(route.params.id), addressId)
    .then(response => {
      addressData.value = response.data.data
    }).catch(error => {
      console.error(error)
    })
}

// 👉 Add Address
const addAddress = async addressData => {
  try {
    const response = await clientListStore.addClientAddress(Number(route.params.id), addressData)
    if (response.status === 201) {
      fetchClientAddresses()
    } else {
      throw new Error(`Failed to create client: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

const updateAddress = async addressData => {
  const addressId = addressData.id
  try {
    console.log("Address ID:", addressData.id)
    console.log("Address Data:", addressData)
    console.log("Route Params ID:", Number(route.params.id))

    const response = await clientListStore.updateClientAddress(Number(route.params.id), addressId, addressData)
    if (response.status === 200) {
      fetchClientAddresses()
    } else {
      throw new Error(`Failed to update client: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Delete Address
const deleteAddress = addressId => {
  clientListStore.deleteClientAddress(Number(route.params.id), addressId)
    .then(response => {
      console.log(response.data)
      fetchClientAddresses()
    })
    .catch(error => {
      console.error('Error deleting client:', error)
    })
}

watchEffect(fetchClientAddresses)
</script>

<template>
  <AddNewAddressDialog
    v-model:isDialogVisible="isAddNewAddressDialogVisible"
    :countries="countries"
    @submit="addAddress"
  />
  <EditAddressDialog
    v-model:isDialogVisible="isEditAddressDialogVisible"
    :address-data="addressData"
    :countries="countries"
    @submit="updateAddress"
  />
  <ViewAddressDialog
    v-model:isDialogVisible="isViewAddressDialogVisible"
    :address-data="addressData"
  />
  <section>
    <VRow>
      <VCol cols="12">
        <VCard title="Client Addresses">
          <VDivider />
          <!-- SECTION - Table Tools -->
          <VCardText class="d-flex flex-wrap py-4 gap-4">
            <div class="me-3 d-flex gap-3">
              <AppSelect
                :model-value="options.itemsPerPage"
                :items="[
                  { value: 10, title: '10' },
                  { value: 25, title: '25' },
                  { value: 50, title: '50' },
                  { value: 100, title: '100' },
                ]"
                style="width: 6.25rem;"
                @update:model-value="options.itemsPerPage = parseInt($event, 10)"
              />
            </div>
            <VSpacer />

            <div class="app-user-search-filter d-flex align-center flex-wrap gap-4">
              <!-- 👉 Search  -->
              <div style="inline-size: 10rem;">
                <AppTextField
                  v-model="searchQuery"
                  placeholder="Search"
                  density="compact"
                />
              </div>

              <!-- 👉 Add user button -->
              <VBtn
                prepend-icon="tabler-plus"
                @click="isAddNewAddressDialogVisible = !isAddNewAddressDialogVisible"
              >
                Add New Address
              </VBtn>
            </div>
          </VCardText>
          <!-- !SECTION - Table Tools -->

          <VDivider />
          <!-- SECTION dataTable -->
          <VDataTableServer
            v-model:items-per-page="options.itemsPerPage"
            v-model:page="options.page"
            :items="addresses"
            :items-length="totalAddresses"
            :headers="addressesHeaders"
            class="text-no-wrap"
            @update:options="options = $event"
          >
            <!-- 👉 Address Title -->
            <template #[`item.cl_address_title`]="{ item }">
              <div class="d-flex align-center">
                <VAvatar
                  size="34"
                  variant="primary"
                  color="warning"
                  class="me-3"
                >
                  <span>{{ avatarText(item.raw.cl_address_title) }}</span>
                </VAvatar>

                <div class="d-flex flex-column">
                  <h6 class="text-base">
                    <RouterLink
                      :to="{ name: 'contact-edit-client-id', params: { id: item.raw.id } }"
                      class="font-weight-medium user-list-name"
                    >
                      {{ item.raw.cl_address_title }}
                    </RouterLink>
                  </h6>

                  <span class="text-sm text-medium-emphasis">#{{ item.raw.cl_address_id }}</span>
                </div>
              </div>
            </template>

            <!-- 👉 Address Description -->
            <template #[`item.description`]="{ item }">
              <div class="d-flex flex-column">
                <h6 class="text-base">
                  {{ item.raw.cl_address_description }}
                </h6>

                <span class="text-sm text-medium-emphasis">{{ item.raw.cl_address_postcode }} {{ item.raw.cl_address_city }} {{ item.raw.cl_address_country }}</span>
              </div>
            </template>
            <!-- 👉 Actions -->
            <template #[`item.actions`]="{ item }">
              <IconBtn 
                @click=" fetchClientAddress(item.raw.id),
                         isViewAddressDialogVisible = !isViewAddressDialogVisible"
              >
                <VIcon icon="tabler-eye" />
              </IconBtn>

              <IconBtn 
                @click=" fetchClientAddress(item.raw.id),
                         isEditAddressDialogVisible = !isEditAddressDialogVisible"
              >
                <VIcon icon="tabler-edit" />
              </IconBtn>

              <IconBtn @click="deleteAddress(item.raw.id)">
                <VIcon icon="tabler-trash" />
              </IconBtn>
            </template>

            <!-- 👉 pagination -->
            <template #bottom>
              <VDivider />
              <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                <p class="text-sm text-disabled mb-0">
                  {{ paginationMeta(options, totalAddresses) }}
                </p>

                <VPagination
                  v-model="options.page"
                  :length="totalPage"
                  :total-visible="$vuetify.display.xs ? 1 : totalPage"
                >
                  <template #prev="slotProps">
                    <VBtn
                      variant="tonal"
                      color="default"
                      v-bind="slotProps"
                      :icon="false"
                    >
                      Previous
                    </VBtn>
                  </template>

                  <template #next="slotProps">
                    <VBtn
                      variant="tonal"
                      color="default"
                      v-bind="slotProps"
                      :icon="false"
                    >
                      Next
                    </VBtn>
                  </template>
                </VPagination>
              </div>
            </template>
          </VDataTableServer>
          <!-- !SECTION dataTable -->
        </VCard>
      </VCol>
    </VRow>
  </section>
</template>
