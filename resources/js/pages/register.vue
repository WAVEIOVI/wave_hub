<script setup>
import { useUserListStore } from '@/stores/useUserListStore'
import AuthProvider from '@/views/pages/authentication/AuthProvider.vue'
import axios from '@axios'
import { useGenerateImageVariant } from '@core/composable/useGenerateImageVariant'
import authV2RegisterIllustrationBorderedDark from '@images/pages/auth-v2-register-illustration-bordered-dark.png'
import authV2RegisterIllustrationBorderedLight from '@images/pages/auth-v2-register-illustration-bordered-light.png'
import authV2RegisterIllustrationDark from '@images/pages/auth-v2-register-illustration-dark.png'
import authV2RegisterIllustrationLight from '@images/pages/auth-v2-register-illustration-light.png'
import authV2MaskDark from '@images/pages/misc-mask-dark.png'
import authV2MaskLight from '@images/pages/misc-mask-light.png'
import { VNodeRenderer } from '@layouts/components/VNodeRenderer'
import { themeConfig } from '@themeConfig'
import {
  alphaDashValidator,
  emailValidator,
  requiredValidator,
} from '@validators'
import { VForm } from 'vuetify/components/VForm'

const refVForm = ref()
const username = ref('johnDoe')
const email = ref('test@test.com')
const password = ref('123456789')
const password_confirmation = ref('123456789')
const role_id = ref('')
const client_id = ref('')
const client_name = ref('')

// const privacyPolicies = ref(true)

// Router
const route = useRoute()
const router = useRouter()

// Form Errors
const errors = ref({
  email: undefined,
  password: undefined,
})


const userListStore = useUserListStore()
const roles = ref([])
const clients = ref([])

// 👉 Fetching roles
const fetchRoles = () => {
  userListStore.fetchRoles()
    .then(response => {
      roles.value = response.data.data
    }).catch(error => {
      console.error(error)
    })
}

// 👉 Fetching clients
const fetchClients = () => {
  userListStore.fetchClients()
    .then(response => {
      clients.value = response.data.data
    }).catch(error => {
      console.error(error)
    })
}

const updateClientName = newValue => {
  const selectedClient = clients.value.find(client => client.id === newValue)
  if (selectedClient) {
    client_name.value = selectedClient.client_name
  } else {
    client_name.value = ''
  }
}

async function register() {
  try {
    const response = await axios.post('/api/register-user', {
      name: username.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value,
      role_id: role_id.value,
      client_id: client_id.value,
      client_name: client_name.value,
    })

    router.replace(route.query.to ? String(route.query.to) : '/')
  } catch (error) {
    if (error.response && error.response.data) {
      const { errors: formErrors } = error.response.data

      errors.value = formErrors
    } else {
      console.error('Network error:', error)
    }
  }
}

const imageVariant = useGenerateImageVariant(authV2RegisterIllustrationLight, authV2RegisterIllustrationDark, authV2RegisterIllustrationBorderedLight, authV2RegisterIllustrationBorderedDark, true)
const authThemeMask = useGenerateImageVariant(authV2MaskLight, authV2MaskDark)
const isPasswordVisible = ref(false)

const onSubmit = () => {
  refVForm.value?.validate().then(({ valid: isValid }) => {
    if (isValid)
      register()
  })
}

onMounted(() => {
  fetchRoles()
  fetchClients()
})
</script>

<template>
  <VRow
    no-gutters
    class="auth-wrapper bg-surface"
  >
    <VCol
      lg="8"
      class="d-none d-lg-flex"
    >
      <div class="position-relative bg-background rounded-lg w-100 ma-8 me-0">
        <div class="d-flex align-center justify-center w-100 h-100">
          <VImg
            max-width="441"
            :src="imageVariant"
            class="auth-illustration mt-16 mb-2"
          />
        </div>

        <VImg
          class="auth-footer-mask"
          :src="authThemeMask"
        />
      </div>
    </VCol>

    <VCol
      cols="12"
      lg="4"
      class="d-flex align-center justify-center"
    >
      <VCard
        flat
        :max-width="500"
        class="mt-12 mt-sm-0 pa-4"
      >
        <VCardText>
          <VNodeRenderer
            :nodes="themeConfig.app.logo"
            class="mb-6"
          />
          <h5 class="text-h5 mb-1">
            Adventure starts here 🚀
          </h5>
          <p class="mb-0">
            Make your app management easy and fun!
          </p>
        </VCardText>

        <VCardText>
          <VForm
            ref="refVForm"
            @submit.prevent="onSubmit"
          >
            <VRow>
              <!-- Username -->
              <VCol cols="12">
                <AppTextField
                  v-model="username"
                  autofocus
                  :rules="[requiredValidator, alphaDashValidator]"
                  label="Username"
                />
              </VCol>

              <!-- email -->
              <VCol cols="12">
                <AppTextField
                  v-model="email"
                  :rules="[requiredValidator, emailValidator]"
                  label="Email"
                  type="email"
                />
              </VCol>
              <VCol cols="12">
                <AppSelect
                  v-model="role_id"
                  label="Select Role"
                  item-title="name"
                  :items="roles"
                  item-value="id"
                  clearable
                  clear-icon="tabler-x"
                >
                  <template #item="{ props: itemProps, item }">  
                    <VListItem
                      v-bind="itemProps"
                      :subtitle="item.raw.name"
                    />
                  </template>
                </AppSelect>
              </VCol>
              <VCol
                v-if="role_id === 3"
                cols="12"
              >
                <AppSelect
                  v-model="client_id"
                  label="Select Client"
                  item-title="client_name"
                  :items="clients"
                  item-value="id"
                  clearable
                  clear-icon="tabler-x"
                  @update:model-value="updateClientName"
                >
                  <template #item="{ props: itemProps, item }">
                    <VListItem
                      v-bind="itemProps"
                      :subtitle="item.raw.client_id"
                    />
                  </template>
                </AppSelect>
              </VCol>

              <!-- password -->
              <VCol cols="12">
                <AppTextField
                  v-model="password"
                  :rules="[requiredValidator]"
                  label="Password"
                  :type="isPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isPasswordVisible ? 'tabler-eye-off' : 'tabler-eye'"
                  @click:append-inner="isPasswordVisible = !isPasswordVisible"
                />
              </VCol>
              <!-- password_confirmation -->
              <VCol cols="12">
                <AppTextField
                  v-model="password_confirmation"
                  :rules="[requiredValidator]"
                  label="Password Confirmation"
                  :type="isPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isPasswordVisible ? 'tabler-eye-off' : 'tabler-eye'"
                  @click:append-inner="isPasswordVisible = !isPasswordVisible"
                />
                <!--
                  <div class="d-flex align-center mt-2 mb-4">
                  <VCheckbox
                  id="privacy-policy"
                  v-model="privacyPolicies"
                  :rules="[requiredValidator]"
                  inline
                  >
                  <template #label>
                  <span class="me-1">
                  I agree to
                  <a
                  href="javascript:void(0)"
                  class="text-primary"
                  >privacy policy & terms</a>
                  </span>
                  </template>
                  </VCheckbox>
                  </div> 
                -->
              </VCol>
              <VCol>
                <VBtn
                  block
                  type="submit"
                >
                  Sign up
                </VBtn>
              </VCol>

              <!-- create account -->
              <VCol
                cols="12"
                class="text-center text-base"
              >
                <span>Already have an account?</span>
                <RouterLink
                  class="text-primary ms-2"
                  :to="{ name: 'login' }"
                >
                  Sign in instead
                </RouterLink>
              </VCol>

              <VCol
                cols="12"
                class="d-flex align-center"
              >
                <VDivider />
                <span class="mx-4">or</span>
                <VDivider />
              </VCol>

              <!-- auth providers -->
              <VCol
                cols="12"
                class="text-center"
              >
                <AuthProvider />
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>

<style lang="scss">
@use "@core-scss/template/pages/page-auth.scss";
</style>

<route lang="yaml">
meta:
  layout: blank
  action: read
  subject: Auth
  redirectIfLoggedIn: true
</route>
