<script setup>
import About from './About.vue'
import ParkListMeta from './ParkListMeta.vue'

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
    <VCol
      md="4"
      cols="12"
    >
      <About
        :client-data="clientData"
        :parks="parks"
        :equipments="equipments"
      />
    </VCol>

    <VCol
      cols="12"
      md="8"
    >
      <VRow>
        <VCol cols="12">
          <ParkListMeta
            :client-data="clientData"
            :parks="parks"
            :equipments="equipments"
          />
        </VCol>
      </VRow>
    </VCol>
  </VRow>
</template>
