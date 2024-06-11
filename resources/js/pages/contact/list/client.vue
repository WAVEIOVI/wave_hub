<script setup>
import ClientListMeta  from '@/views/contact/client/list/ClientListMeta.vue'
import ClientListTable  from '@/views/contact/client/list/ClientListTable.vue'

import { avatarText } from '@core/utils/formatters'
import { VForm } from 'vuetify/components/VForm'

//SECTION Items

// 👉 Headers
const headers = [
  {
    title: 'Client',
    key: 'client_name',
  },
  {
    title: 'Type',
    key: 'client_type',
  },
  {
    title: 'Activity',
    key: 'client_activity',
  },
  {
    title: 'Status',
    key: 'client_status',
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
  },
]

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
  <section>
    <ClientListMeta />
    <VRow>
      <VCol cols="12">
        <ClientListTable
          :headers="headers" 
          :types="types" 
          :activities="activities" 
          :status="status"
        />
      </VCol>
    </VRow>
  </section>
</template>

