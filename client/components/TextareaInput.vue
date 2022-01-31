<template>
  <div :class="$attrs.class">
    <label v-if="label" class="block" :for="id">
      <span class="text-gray-500">{{ label }}</span>
      <textarea
        :id="id"
        ref="input"
        rows="4"
        v-bind="{ ...$attrs, class: null }"
        class="block mt-1 w-full rounded-md border-gray-300 border outline-none shadow-sm px-3 py-2
               focus:ring focus:ring-gray-300 focus:ring-opacity-50"
        :class="{ error: error }"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
      ></textarea>
    </label>
    <div v-if="error" class="text-small text-red-600">{{ error }}</div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
  inheritAttrs: false,
  props: {
    id: {
      required: true,
      type: String,
    },
    error: String,
    label: String,
    modelValue: String,
  },
})
</script>
