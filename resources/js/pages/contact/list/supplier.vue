<script setup>
import SupplierListMeta  from '@/views/contact/supplier/list/SupplierListMeta.vue'
import SupplierListTable  from '@/views/contact/supplier/list/SupplierListTable.vue'

import { avatarText } from '@core/utils/formatters'
import { VForm } from 'vuetify/components/VForm'

//SECTION Items

// 👉 Headers
const headers = [
  {
    title: 'Supplier',
    key: 'supplier_name',
  },
  {
    title: 'Type',
    key: 'supplier_type',
  },
  {
    title: 'Activity',
    key: 'supplier_activity',
  },
  {
    title: 'Status',
    key: 'supplier_status',
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
  <section>
    <SupplierListMeta />
    <VRow>
      <VCol cols="12">
        <SupplierListTable
          :headers="headers" 
          :types="types" 
          :activities="activities" 
          :status="status"
        />
      </VCol>
    </VRow>
  </section>
</template>

