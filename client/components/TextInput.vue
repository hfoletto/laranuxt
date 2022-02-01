<template>
  <div :class="$attrs.class">
    <label v-if="label" class="block" :for="id">
      <span class="text-gray-500">
        {{ label }}
        {{ required ? '*' : '' }}
      </span>
      <input
        :id="id"
        ref="input"
        :required="required"
        :type="type"
        :value="modelValue"
        class="block mt-1 w-full rounded-md border-gray-300 border outline-none shadow-sm px-3 py-2
               focus:ring focus:ring-gray-300 focus:ring-opacity-50"
        v-bind="{ ...$attrs, class: null }"
        @input="$emit('update:modelValue', $event.target.value)"
      >
    </label>
    <div v-if="errors.length" class="px-2 pt-1 text-small text-red-600 font-semibold">{{ errors.join() }}</div>
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
    type: {
      default: 'text',
      type: String,
    },
    required: {
      default: false,
      type: Boolean,
    },
    errors: {
      type: Array,
      default: () => [],
    },
    label: String,
    modelValue: String,
  },
})
</script>
