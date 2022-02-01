<template>
  <div>
    <label v-if="label" class="text-gray-500">
      {{ label }}
      {{ required ? '*' : '' }}
    </label>
    <div class="form-input p-0" :class="{ error: errors.length }">
      <input
        ref="file"
        type="file"
        accept="image/*"
        class="hidden"
        :required="required"
        @change="change"
      >
      <img
        v-if="url"
        :src="url"
        alt="Profile Picture"
        class="w-full mx-auto px-3 mt-2 cursor-pointer"
        @click="browse"
      >
      <div
        v-else
        class="w-full mx-auto px-3 mt-2 bg-gray-200 rounded flex flex-col items-center justify-center cursor-pointer"
        style="aspect-ratio: 1 / 1"
        @click="browse"
      >
        <span class="text-gray-500 text-4xl">No profile image</span>
        <span class="text-gray-600 text-sm mt-2">Use the button below to browse for an image</span>
      </div>
      <div class="flex items-center justify-between mt-1 w-full px-3 py-2">
        <button v-if="!value" type="button" class="px-4 py-1 text-white text-xs font-medium bg-gray-500 hover:bg-gray-700 rounded" @click="browse">Browse</button>
        <template v-else>
          <div class="flex-1 pr-1">{{ value.name }}</div>
          <button type="button" class="px-4 py-1 text-white text-xs font-medium bg-gray-500 hover:bg-gray-700 rounded" @click="remove">Remove</button>
        </template>
      </div>
    </div>
    <div v-if="errors.length" class="px-2 pt-1 text-small text-red-600 font-semibold">{{ errors.join() }}</div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
  props: {
    value: File,
    label: String,
    currentImage: String,
    errors: {
      type: Array,
      default: () => [],
    },
    required: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    url (): string | null {
      if (this.value instanceof File)
        return URL.createObjectURL(this.value)
      if (this.currentImage)
        return this.currentImage
      return null
    },
  },
  watch: {
    value (value) {
      if (!value)
        (this.$refs.file as HTMLInputElement).value = ''
    },
  },
  methods: {
    browse () {
      (this.$refs.file as HTMLInputElement).click()
    },
    change (e: { target: { files: any[] } }) {
      this.$emit('input', e.target.files[0])
    },
    remove () {
      this.$emit('input', null)
    },
  },
})
</script>
