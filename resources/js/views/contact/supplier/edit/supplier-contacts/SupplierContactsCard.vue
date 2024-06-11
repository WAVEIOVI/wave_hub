<script setup>
import { useSupplierListStore } from '@/views/contact/supplier/useSupplierListStore'
import AddNewContactDialog from './AddNewContactDialog.vue'
import EditContactDialog from './EditContactDialog.vue'
import ViewContactDialog from './ViewContactDialog.vue'
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import { avatarText } from '@core/utils/formatters'

const props = defineProps({
  contactsHeaders: {
    type: Array,
    required: true,
  },
})


//SECTION Declaration
const route = useRoute()
const router = useRouter()
const supplierListStore = useSupplierListStore()
const searchQuery = ref('')
const totalPage = ref(1)
const totalContacts = ref(0)
const contacts = ref([])
const contactData = ref([])

const options = ref({
  page: 1,
  itemsPerPage: 10,
  sortBy: [],
  groupBy: [],
  search: undefined,
})

// 👉 Contact Dialog
const isAddNewContactDialogVisible = ref(false)
const isEditContactDialogVisible = ref(false)
const isViewContactDialogVisible = ref(false)

//!SECTION Declaration
const paginationMeta = computed(() => {
  return (options, total) => {
    const start = (options.page - 1) * options.itemsPerPage + 1
    const end = Math.min(options.page * options.itemsPerPage, total)
    
    return `Showing ${start} to ${end} of ${total} entries`
  }
})

// 👉 Fetching contacts
const fetchSupplierContacts = () => {
  supplierListStore.fetchSupplierContacts({
    id: Number(route.params.id),
    search: searchQuery.value,
    options: options.value,
  }).then(response => {
    contacts.value = response.data.data
    totalPage.value = response.data.meta.last_page
    totalContacts.value = response.data.meta.total
    options.value.page = response.data.meta.current_page
  }).catch(error => {
    console.error(error)
  })
}

// 👉 Fetch Supplier Contact
const fetchSupplierContact = contactId => {
  supplierListStore.fetchSupplierContact(Number(route.params.id), contactId)
    .then(response => {
      contactData.value = response.data.data
    }).catch(error => {
      console.error(error)
    })
}

// 👉 Add Contact
const addContact = async contactData => {
  try {
    const response = await supplierListStore.addSupplierContact(Number(route.params.id), contactData)
    if (response.status === 201) {
      fetchSupplierContacts()
    } else {
      throw new Error(`Failed to create supplier: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

const updateContact = async contactData => {
  const contactId = contactData.id
  try {
    console.log("Contact ID:", contactData.id)
    console.log("Contact Data:", contactData)
    console.log("Route Params ID:", Number(route.params.id))

    const response = await supplierListStore.updateSupplierContact(Number(route.params.id), contactId, contactData)
    if (response.status === 200) {
      fetchSupplierContacts()
    } else {
      throw new Error(`Failed to update supplier: ${response.statusText}`)
    }
  } catch (error) {
    console.log(error.message)
  }
}

// 👉 Delete Contact
const deleteContact = contactId => {
  supplierListStore.deleteSupplierContact(Number(route.params.id), contactId)
    .then(response => {
      console.log(response.data)
      fetchSupplierContacts()
    })
    .catch(error => {
      console.error('Error deleting supplier:', error)
    })
}

watchEffect(fetchSupplierContacts)
</script>

<template>
  <AddNewContactDialog
    v-model:isDialogVisible="isAddNewContactDialogVisible"
    @submit="addContact"
  />
  <EditContactDialog
    v-model:isDialogVisible="isEditContactDialogVisible"
    :contact-data="contactData"
    @submit="updateContact"
  />
  <ViewContactDialog
    v-model:isDialogVisible="isViewContactDialogVisible"
    :contact-data="contactData"
  />
  <section>
    <VRow>
      <VCol cols="12">
        <VCard title="Supplier Contacts">
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
                @click="isAddNewContactDialogVisible = !isAddNewContactDialogVisible"
              >
                Add New Contact
              </VBtn>
            </div>
          </VCardText>
          <!-- !SECTION - Table Tools -->

          <VDivider />
          <!-- SECTION dataTable -->
          <VDataTableServer
            v-model:items-per-page="options.itemsPerPage"
            v-model:page="options.page"
            :items="contacts"
            :items-length="totalContacts"
            :headers="contactsHeaders"
            class="text-no-wrap"
            @update:options="options = $event"
          >
            <!-- 👉 Contact Title -->
            <template #[`item.name`]="{ item }">
              <div class="d-flex align-center">
                <VAvatar
                  size="34"
                  variant="primary"
                  color="warning"
                  class="me-3"
                >
                  <span>{{ avatarText(item.raw.su_contact_full_name) }}</span>
                </VAvatar>

                <div class="d-flex flex-column">
                  <h6 class="text-base">
                    <RouterLink
                      :to="{ name: 'contact-edit-supplier-id', params: { id: item.raw.id } }"
                      class="font-weight-medium user-list-name"
                    >
                      {{ item.raw.su_contact_full_name }}
                    </RouterLink>
                  </h6>

                  <span class="text-sm text-medium-emphasis">#{{ item.raw.su_contact_post }}</span>
                </div>
              </div>
            </template>
            <!-- 👉 Contact info -->
            <template #[`item.phone`]="{ item }">
              <div class="d-flex flex-column">
                <h6 class="text-base">
                  {{ item.raw.su_contact_phone }}
                </h6>

                <span class="text-sm text-medium-emphasis">{{ item.raw.su_contact_email }}</span>
              </div>
            </template>
            <!-- 👉 Actions -->
            <template #[`item.actions`]="{ item }">
              <IconBtn 
                @click=" fetchSupplierContact(item.raw.id),
                         isViewContactDialogVisible = !isViewContactDialogVisible"
              >
                <VIcon icon="tabler-eye" />
              </IconBtn>

              <IconBtn 
                @click=" fetchSupplierContact(item.raw.id),
                         isEditContactDialogVisible = !isEditContactDialogVisible"
              >
                <VIcon icon="tabler-edit" />
              </IconBtn>

              <IconBtn @click="deleteContact(item.raw.id)">
                <VIcon icon="tabler-trash" />
              </IconBtn>
            </template>

            <!-- 👉 pagination -->
            <template #bottom>
              <VDivider />
              <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                <p class="text-sm text-disabled mb-0">
                  {{ paginationMeta(options, totalContacts) }}
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
