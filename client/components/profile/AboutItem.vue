<template>
  <div class="flex items-center my-3">
    <mdicon class="inline w-6 mr-2" :name="icon" />
    <a v-if="href" :href="href" :target="target">{{ text }}</a>
    <p v-else>{{ text }}</p>
  </div>
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
  name: 'AboutItem',
  props: {
    icon: {
      required: true,
      type: String,
    },
    text: {
      required: true,
      type: String,
    },
    href: {
      required: false,
      type: String,
    },
  },
  computed: {
    target (): string {
      if (!this.href) return '_self'
      const pattern = /^((http|https):\/\/)/
      return pattern.test(this.href) ? '_blank' : '_self'
    },
  },
})
</script>

<style scoped>

</style>
