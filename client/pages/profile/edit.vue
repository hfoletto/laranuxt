<template>
  <LoadingSpinner v-if="fetching" class="my-8" />
  <div v-else class="bg-white rounded-md shadow overflow-hidden my-8 max-w-4xl w-full">
    <h1 class="p-8 text-3xl font-bold">
      Editing Profile
    </h1>
    <form class="w-full" @submit.prevent="submit">
      <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
        <TextInput
          id="first_name"
          :model-value.sync="profile.first_name"
          :errors="errors.first_name"
          class="pb-8 pr-6 w-full lg:w-1/2"
          label="First name"
          required
        />
        <TextInput
          id="last_name"
          :model-value.sync="profile.last_name"
          :errors="errors.last_name"
          class="pb-8 pr-6 w-full lg:w-1/2"
          label="Last name"
          required
        />
        <TextInput
          id="email"
          :model-value.sync="profile.email"
          :errors="errors.email"
          type="email"
          class="pb-8 pr-6 w-full lg:w-1/2"
          label="Email"
          required
        />
        <TextInput
          id="phone_number"
          :model-value.sync="profile.phone_number"
          :errors="errors.phone_number"
          type="tel"
          class="pb-8 pr-6 w-full lg:w-1/2"
          label="Phone Number"
        />
        <TextInput
          id="job_title"
          :model-value.sync="profile.job_title"
          :errors="errors.job_title"
          class="pb-8 pr-6 w-full lg:w-1/2"
          label="Job Title"
          required
        />
        <TextInput
          id="location"
          :model-value.sync="profile.location"
          :errors="errors.location"
          class="pb-8 pr-6 w-full lg:w-1/2"
          label="Location"
        />
        <TextareaInput
          id="introduction"
          :model-value.sync="profile.introduction"
          :errors="errors.introduction"
          class="pb-8 pr-6 w-full"
          label="Introduction"
        />
        <h2 class="mt-8 mb-4 w-full font-bold text-2xl">On the web</h2>
        <TextInput
          id="github_url"
          :model-value.sync="profile.github_url"
          :errors="errors.github_url"
          type="url"
          class="pb-8 pr-6 w-full lg:w-1/2"
          label="Github URL"
        />
        <TextInput
          id="linkedin_url"
          :model-value.sync="profile.linkedin_url"
          :errors="errors.linkedin_url"
          type="url"
          class="pb-8 pr-6 w-full lg:w-1/2"
          label="LinkedIn URL"
        />
        <TextInput
          id="twitter_url"
          :model-value.sync="profile.twitter_url"
          :errors="errors.twitter_url"
          type="url"
          class="pb-8 pr-6 w-full lg:w-1/2"
          label="Twitter URL"
        />
        <TextInput
          id="website_url"
          :model-value.sync="profile.website_url"
          :errors="errors.website_url"
          type="url"
          class="pb-8 pr-6 w-full lg:w-1/2"
          label="Website URL"
        />
      </div>
      <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center flex-row-reverse">
        <PushButton theme="indigo" type="submit" :disabled="submitting">
          <mdicon v-if="submitting" name="loading" :size="18" class="animate-spin mr-2" />
          {{ submitting ? 'Processing...' : 'Submit changes' }}
        </PushButton>
      </div>
    </form>
  </div>
</template>

<script lang="ts">
import Vue from 'vue'
import { Profile } from '@/types/api'
export default Vue.extend({
  data () {
    const fetching: boolean = true
    const submitting: boolean = false
    const profile: Profile = {} as Profile
    const errors: Object = {}
    return {
      fetching,
      submitting,
      profile,
      errors,
    }
  },
  mounted () {
    this.fetchInfo()
      .finally(() => {
        this.fetching = false
      })
  },
  methods: {
    async fetchInfo (): Promise<void> {
      this.profile = (await this.$axios.get('profiles')).data
    },
    submit (): void {
      this.submitting = true
      this.errors = {}
      this.$axios.put(`profiles/${this.profile.id}`, this.profile)
        .then((data) => {
          console.log(data)
          this.$toast.show({
            type: 'success',
            message: 'Profile updated',
            primary: {
              label: 'View profile',
              action: () => this.$router.push({
                path: '/profile',
              }),
            },
            timeout: 6,
          })
        })
        .catch((err) => {
          if (err.response && err.response.status === 422) {
            this.errors = err.response.data.errors
            this.$toast.show({
              type: 'danger',
              title: 'Error',
              message: err.response.data.message,
              timeout: 6,
            })
          } else
            this.$toast.show({
              type: 'danger',
              title: 'Error',
              message: 'Please try again later',
              timeout: 6,
            })
        })
        .finally(() => {
          this.submitting = false
        })
    },
  },
})
</script>
