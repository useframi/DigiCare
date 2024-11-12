<template>
  <div class="form-group">
    <div class="text-center">
      <Dashboard id="drag-drop-area" class="custom-file-upload mb-3" :uppy="uppy" :open="open" />
    </div>
  </div>
</template>

<script setup>
import { ref, defineProps, watch } from 'vue'
import { Dashboard } from '@uppy/vue'
import Uppy from '@uppy/core'
import '@uppy/core/dist/style.css'
import '@uppy/dashboard/dist/style.css'

const props = defineProps({
  ImageViewer: { type: String,  default: ''  },
})

const open = ref(false)
const uppy = new Uppy()


async function createFile(newValue){
  let response = await fetch(newValue);
  let data = await response.blob();
  let metadata = {
    type: 'image/jpeg'
  };
  let file = new File([data], 'Image.jpg', metadata);
  uppy.addFile(file)
}

watch(() => props.ImageViewer, (newValue) => {
  uppy.getFiles().forEach(file => {
    uppy.removeFile(file.id)
  })
  console.log(newValue)
  if(newValue && newValue.length > 0) {
    createFile(newValue)
  }
})

uppy.on('file-added', (file) => {
  const uploadedFile = file
  updateModelValue(uploadedFile.data)
})

uppy.on('file-removed', () => {
  const files = uppy.getFiles();  
  if (files.length > 0) {
    const lastFileData = files[files.length - 1].data;
    updateModelValue(lastFileData);
  } else {
    updateModelValue(null);
  }
});


const emit = defineEmits(['update:modelValue'])

const updateModelValue = (uploadedFile) => {
  emit('update:modelValue', uploadedFile)
}
</script>

<style>
.uppy-Dashboard-progressindicators{
  display: none;
}
</style>
