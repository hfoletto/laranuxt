<template>
  <main
    id="wrapper"
    class="flex md:m-12 flex-col md:flex-row"
  >
    <LoadingSpinner v-if="loading" class="my-8" />
    <template v-else>
      <ProfileSidebar :profile="profile" />
      <ProfileContent :profile="profile" />
    </template>
  </main>
</template>

<script lang="ts">
import Vue from 'vue'
import { Profile } from '@/types/api'
export default Vue.extend({
  data () {
    const profile: Profile | null = null
    const loading: boolean = true
    return {
      loading,
      profile,
    }
  },
  mounted () {
    this.fetchInfo()
      .finally(() => {
        this.loading = false
      })
  },
  methods: {
    async fetchInfo (): Promise<void> {
      this.profile = (await this.$axios.get('profiles')).data
    },
  },
})
</script>

<style scoped>

</style>
