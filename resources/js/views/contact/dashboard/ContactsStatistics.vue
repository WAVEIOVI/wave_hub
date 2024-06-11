<script setup>
const statistics = [
  {
    title: 'Contacts',
    stats: '230k',
    icon: 'tabler-users',
    color: 'primary',
  },
  {
    title: 'Clients',
    stats: '8.549k',
    icon: 'tabler-user-dollar',
    color: 'primary',
  },
  {
    title: 'Suppliers',
    stats: '1.423k',
    icon: 'tabler-shopping-cart',
    color: 'primary',
  },
  {
    title: 'Organizations',
    stats: '$9745',
    icon: 'tabler-users-group',
    color: 'primary',
  },
]
</script>

<template>
  <VCard title="Statistics">
    <VCardText class="pt-0">
      <VRow>
        <VCol
          v-for="item in statistics"
          :key="item.title"
          cols="6"
          md="3"
        >
          <div class="d-flex align-center gap-4">
            <VAvatar
              :color="item.color"
              variant="tonal"
              size="42"
            >
              <VIcon :icon="item.icon" />
            </VAvatar>

            <div class="d-flex flex-column">
              <span class="text-h5 font-weight-medium">{{ item.stats }}</span>
              <span class="text-sm">
                {{ item.title }}
              </span>
            </div>
          </div>
        </VCol>
      </VRow>
    </VCardText>
  </VCard>
</template>
