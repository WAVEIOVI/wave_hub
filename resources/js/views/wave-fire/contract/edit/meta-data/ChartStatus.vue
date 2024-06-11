<script setup>
import VueApexCharts from 'vue3-apexcharts'
import { useTheme } from 'vuetify'
import { hexToRgb } from '@layouts/utils'

const props = defineProps({
  statusLabels: {
    type: Object,
    required: true,
  },
  statusSeries: {
    type: Object,
    required: true,
  },
})

// 👉 Colors variables
const colorVariables = themeColors => {
  const themeSecondaryTextColor = `rgba(${hexToRgb(themeColors.colors['on-surface'])},${themeColors.variables['medium-emphasis-opacity']})`
  const themeDisabledTextColor = `rgba(${hexToRgb(themeColors.colors['on-surface'])},${themeColors.variables['disabled-opacity']})`
  const themeBorderColor = `rgba(${hexToRgb(String(themeColors.variables['border-color']))},${themeColors.variables['border-opacity']})`
  const themePrimaryTextColor = `rgba(${hexToRgb(themeColors.colors['on-surface'])},${themeColors.variables['high-emphasis-opacity']})`
  
  return { themeSecondaryTextColor, themeDisabledTextColor, themeBorderColor, themePrimaryTextColor }
}

const getStatusChartConfig = themeColors => {
  const donutColors = {
    series1: '#fdd835',
    series2: '#00d4bd',
    series3: '#826bf8',
    series4: '#32baff',
    series5: '#ffa1a1',
  }

  const { themeSecondaryTextColor, themePrimaryTextColor } = colorVariables(themeColors)
  
  return {
    stroke: { width: 0 },
    labels: props.statusLabels,
    colors: [donutColors.series1, donutColors.series5, donutColors.series3, donutColors.series2],
    dataLabels: {
      enabled: true,
      formatter: val => `${parseInt(val, 10)}%`,
    },
    legend: {
      position: 'bottom',
      markers: { offsetX: -3 },
      fontSize: '13px',
      labels: { colors: themeSecondaryTextColor },
      itemMargin: {
        vertical: 3,
        horizontal: 10,
      },
    },
    plotOptions: {
      pie: {
        donut: {
          labels: {
            show: true,
            name: {
              fontSize: '1.125rem',
            },
            value: {
              fontSize: '1.125rem',
              color: themeSecondaryTextColor,
              formatter: val => `${parseInt(val, 10)}`,
            },
            total: {
              show: true,
              fontSize: '1.125rem',
              label: 'Total',
              color: themePrimaryTextColor,
            },
          },
        },
      },
    },
    responsive: [
      {
        breakpoint: 992,
        options: {
          chart: {
            height: 380,
          },
          legend: {
            position: 'bottom',
          },
        },
      },
      {
        breakpoint: 576,
        options: {
          chart: {
            height: 320,
          },
          plotOptions: {
            pie: {
              donut: {
                labels: {
                  show: true,
                  name: {
                    fontSize: '0.9375rem',
                  },
                  value: {
                    fontSize: '0.9375rem',
                  },
                  total: {
                    fontSize: '0.9375rem',
                  },
                },
              },
            },
          },
        },
      },
    ],
  }
}

const vuetifyTheme = useTheme()
const statusChartConfig = computed(() => getStatusChartConfig(vuetifyTheme.current.value))

const series = ref(props.statusSeries)

const localStatusSeries = ref((props.statusSeries))
const localStatusLabels = ref((props.statusLabels))

watchEffect(() => {
  localStatusSeries.value = props.statusSeries
  localStatusLabels.value = props.statusLabels
})
</script>

<template>
  <div>
    <VueApexCharts
      type="donut"
      height="400"
      :options="statusChartConfig"
      :series="series"
    />
  </div>
</template>
