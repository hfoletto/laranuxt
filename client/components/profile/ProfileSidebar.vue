<template>
  <div
    id="sidebar"
    class="w-full md:max-w-sm p-8 bg-gray-700 text-white"
  >
    <div class="px-2 mb-12">
      <img
        v-if="profile.photo"
        :src="profile.photo"
        alt="Profile Picture"
        class="rounded-full w-48 mx-auto mb-2"
      />
      <h1 class="text-center text-3xl font-semibold mb-2">{{ full_name }}</h1>
      <h2 class="text-center text-xl font-light">{{ profile.job_title }}</h2>
    </div>

    <div class="font-light text-lg px-2 mb-12">
      <h2 class="text-xl font-semibold mb-4">Contact</h2>
      <ProfileAboutItem
        :text="profile.email"
        icon="email"
        :href="'mailto:'+profile.email"
      />
      <ProfileAboutItem
        v-if="profile.phone_number"
        :text="profile.phone_number"
        icon="phone"
        :href="'tel:'+profile.phone_number"
      />
      <ProfileAboutItem
        v-if="profile.location"
        :text="profile.location"
        icon="home"
      />
    </div>

    <div class="font-light text-lg px-2 mb-12">
      <h2 class="text-xl font-semibold mb-4">On the Web</h2>
      <ProfileAboutItem
        v-if="profile.github_url"
        text="GitHub"
        icon="github"
        :href="profile.github_url"
      />
      <ProfileAboutItem
        v-if="profile.linkedin_url"
        text="LinkedIn"
        icon="linkedin"
        :href="profile.linkedin_url"
      />
      <ProfileAboutItem
        v-if="profile.twitter_url"
        text="Twitter"
        icon="twitter"
        :href="profile.twitter_url"
      />
      <ProfileAboutItem
        v-if="profile.website_url"
        text="Website"
        icon="web"
        :href="profile.website_url"
      />
    </div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue'
import { PropType } from '@nuxtjs/composition-api'
import { Profile } from '@/types/api'
export default Vue.extend({
  name: 'AboutItem',
  props: {
    profile: {
      required: true,
      type: Object as PropType<Profile>,
    },
  },
  computed: {
    full_name (): string {
      return `${this.profile.first_name} ${this.profile.last_name}`
    },
  },
})
</script>
