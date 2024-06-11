<script setup>
import * as htmlToImage from 'html-to-image'
import QRCode from 'qrcode'

const mode = ref('single')
const inputValue = ref('')
const prefix = ref('')
const numberOfQRCodes = ref(1)
const digits = ref(6)
const qrCodes = ref([])
const qrCodeRefs = ref([])
const format = ref('png') // Add a ref for QR code format

const generateQRCode = async () => {
  qrCodes.value = []
  if (mode.value === 'single') {
    await generateSingleQRCode()
  } else {
    await generateMultipleQRCodes()
  }
}

const generateSingleQRCode = async () => {
  if (inputValue.value) {
    try {
      const qrCodeData = await QRCode.toDataURL(inputValue.value)

      qrCodes.value.push({ value: inputValue.value, data: qrCodeData })
      inputValue.value = '' // Clear the input after generating the QR code
    } catch (error) {
      console.error('Error generating QR code:', error)
    }
  }
}

const generateMultipleQRCodes = async () => {
  if (prefix.value && numberOfQRCodes.value > 0 && digits.value > 0) {
    for (let i = 1; i <= numberOfQRCodes.value; i++) {
      await generateQRCodeWithPrefix(i)
    }
    resetMultipleQRCodeInputs()
  }
}

const generateQRCodeWithPrefix = async index => {
  const number = String(index).padStart(digits.value, '0')
  const qrValue = `${prefix.value}${number}`
  try {
    const qrCodeData = await QRCode.toDataURL(qrValue)

    qrCodes.value.push({ value: qrValue, data: qrCodeData })
  } catch (error) {
    console.error('Error generating QR code:', error)
  }
}

const resetMultipleQRCodeInputs = () => {
  prefix.value = '' // Clear the prefix after generating QR codes
  numberOfQRCodes.value = 1 // Reset the number of QR codes
  digits.value = 6 // Reset the digits to default value
}

const downloadQRCode = async index => {
  try {
    const node = qrCodeRefs.value[index]
    if (node) {
      let dataUrl
      if (format.value === 'png') {
        dataUrl = await htmlToImage.toPng(node, { cacheBust: true, skipFonts: true })
      } else if (format.value === 'svg') {
        dataUrl = await htmlToImage.toSvg(node, { cacheBust: true, skipFonts: true })
      }
      const link = document.createElement('a')

      link.href = dataUrl
      link.download = `qr-code-${qrCodes.value[index].value}.${format.value}`
      link.click()
    } else {
      console.error('QR code element not found')
    }
  } catch (error) {
    console.error('Error downloading QR Code:', error)
  }
}

const downloadAllQRCodes = async () => {
  for (let i = 0; i < qrCodes.value.length; i++) {
    try {
      const node = qrCodeRefs.value[i]
      if (node) {
        let dataUrl
        if (format.value === 'png') {
          dataUrl = await htmlToImage.toPng(node, { cacheBust: true, skipFonts: true })
        } else if (format.value === 'svg') {
          dataUrl = await htmlToImage.toSvg(node, { cacheBust: true, skipFonts: true })
        }
        const link = document.createElement('a')

        link.href = dataUrl
        link.download = `qr-code-${qrCodes.value[i].value}.${format.value}`
        link.click()
      } else {
        console.error('QR code element not found')
      }
    } catch (error) {
      console.error('Error downloading QR Code:', error)
    }
  }
}

const radioContent = [
  {
    title: 'Single QR CODE',
    desc: 'For Generate Single QR CODE',
    value: 'single',
    icon: {
      icon: 'tabler-qrcode',
      size: '28',
    },
  },
  {
    title: 'Multi QR Code',
    desc: 'For Generate Multi QR CODE',
    value: 'multi',
    icon: {
      icon: 'tabler-qrcode',
      size: '28',
    },
  },
]
</script>

<template>
  <section>
    <VRow justify="center">
      <VCol cols="12">
        <h4 class="text-h4 mb-0">
          QR CODE Generator
        </h4>
      </VCol>
    </VRow>
    <VCard>
      <VCardText>
        <VRow>
          <VCol cols="12">
            <CustomRadiosWithIcon
              v-model:selected-radio="mode"
              :radio-content="radioContent"
              :grid-column="{ sm: '6', cols: '12' }"
            />
          </VCol>
        </VRow>
        <VRow v-if="mode === 'single'">
          <VCol cols="4">
            <VTextField
              v-model="inputValue"
              label="QR Code"
            />
          </VCol>
          <VCol cols="2">
            <VSelect
              v-model="format"
              :items="['png', 'svg']"
              label="Select QR Code Format"
            />
          </VCol>
          <VCol cols="3">
            <VBtn @click="generateQRCode">
              Generate QR Code
              <VIcon
                end
                icon="tabler-checkbox"
              />
            </VBtn>
          </VCol>
        </VRow>
        <VRow v-else>
          <VCol cols="3">
            <VTextField
              v-model="prefix"
              label="Prefix"
            />
          </VCol>
          <VCol cols="2">
            <VTextField
              v-model="numberOfQRCodes"
              label="Number of QR Codes"
              type="number"
            />
          </VCol>
          <VCol cols="2">
            <VTextField
              v-model="digits"
              label="Number of Digits"
              type="number"
            />
          </VCol>
          <VCol cols="2">
            <VSelect
              v-model="format"
              :items="['png', 'svg']"
              label="Select QR Code Format"
            />
          </VCol>
          <VCol cols="3">
            <VBtn @click="generateQRCode">
              Generate QR Code
              <VIcon
                end
                icon="tabler-checkbox"
              />
            </VBtn>
          </VCol>
        </VRow>
      </VCardText>
      <VCardText>
        <VRow
          class="demo-space-x"
          justify="center"
        >
          <VCol
            v-for="(qrCode, index) in qrCodes"
            :key="index"
            cols="2"
            class="qr-code-container"
          >
            <h3>{{ qrCode.value }}</h3>
            <img
              :ref="el => qrCodeRefs[index] = el"
              :src="qrCode.data"
            >
            <VBtn @click="downloadQRCode(index)">
              Download
            </VBtn>
          </VCol>
          <VCol
            cols="12"
            class="text-center"
          >
            <VBtn @click="downloadAllQRCodes">
              Download All QR Codes
            </VBtn>
          </VCol>
        </VRow>
      </VCardText>
    </VCard>
  </section>
</template>

<style scoped>
.qr-code-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-block-start: 5px;
  text-align: center; /* Center text */
}

img {
  margin-block-end: 5px;
  margin-block-start: 5px;
}
</style>
