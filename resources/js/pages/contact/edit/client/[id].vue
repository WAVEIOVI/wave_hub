<script setup>
import AdditionalDetails from '@/views/contact/client/edit/AdditionalDetails.vue'
import BasicClientInformation from '@/views/contact/client/edit/BasicClientInformation.vue'
import ClientAddressAndContacts from '@/views/contact/client/edit/ClientAddressAndContacts.vue'
import { useClientListStore } from '@/views/contact/client/useClientListStore'

const checkoutSteps = [
  {
    title: 'Basic Information',
    icon: 'tabler-360-view',
  },
  {
    title: 'Additional Details ',
    icon: 'custom-payment',
  },
  {
    title: 'Address & Contacts',
    icon: 'custom-address',
  },
]

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

const route = useRoute()
const clientData = ref()
const clientListStore = useClientListStore()
const isSnackbarVisible = ref(false)
const currentStep = ref(0)

//SECTION Functions
// 👉 Fetch Client
onMounted(() => {
  clientListStore.fetchClient(Number(route.params.id)).then(response => {
    clientData.value = response.data.data
  })
})

// 👉 Update Client
const updateClient = async  updatedClientData => {
  try {
    const response = await clientListStore.updateClient(Number(route.params.id), updatedClientData)
    if (response.status === 200) {
      isSnackbarVisible.value = true
    } else {
      throw new Error(`Failed to update client: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}
</script>

<template>
  <div>
    <!-- 👉 SnackBar Notification -->
    <VSnackbar 
      v-model="isSnackbarVisible"
      transition="scroll-y-reverse-transition"
    >
      Client Data Updated Successfully
    </VSnackbar>
    <VCard v-if="clientData">
      <VCardText>
        <!-- 👉 Stepper -->
        <AppStepper
          v-model:current-step="currentStep"
          class="checkout-stepper"
          :items="checkoutSteps"
        />
      </VCardText>

      <VDivider />

      <VCardText>
        <!-- 👉 stepper content -->
        <VWindow
          v-model="currentStep"
          class="disable-tab-transition"
        >
          <VWindowItem>
            <BasicClientInformation
              v-model:current-step="currentStep"
              :countries="countries"
              :client-data="clientData"
              @submit="updateClient"
            />
          </VWindowItem>
          <VWindowItem>
            <AdditionalDetails
              v-model:current-step="currentStep"
              :client-data="clientData"
              @submit="updateClient"
            />
          </VWindowItem>
          <VWindowItem>
            <ClientAddressAndContacts
              v-model:current-step="currentStep"
              :client-data="clientData"
            />
          </VWindowItem>
        </VWindow>
      </VCardText>
    </VCard>
  </div>
</template>

<style lang="scss">
.checkout-stepper {
  .stepper-icon-step {
    .step-wrapper + svg {
      margin-inline: 3.5rem !important;
    }
  }
}
</style>
