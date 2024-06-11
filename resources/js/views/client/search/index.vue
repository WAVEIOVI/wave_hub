<script setup>
import About from './About.vue'

const props = defineProps({
  clientData: {
    type: Object,
    required: true,
  },
  parks: {
    type: Object,
    required: true,
  },
  equipments: {
    type: Object,
    required: true,
  },
})

const clientData = ref((props.clientData))

watch(
  () => props.clientData,
  newValue => {
    clientData.value = newValue
    console.log('clientData in child:', clientData.value)
  },
  { deep: true },
)
</script>

<template>
  <VRow>
    <VCol cols="12">
      <About :client-data="clientData" />
    </VCol>
  </VRow>
</template>
