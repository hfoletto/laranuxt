<template>
  <div class="content w-full p-12 bg-white">
    <div id="profile" class="prose">
      <h2 class="text-3xl uppercase font-bold tracking-widest text-gray-700">Profile</h2>
      <p class="mt-4">{{ profile.introduction }}</p>
    </div>
    <hr class="my-8" />
    <div>
      <h2 class="text-3xl uppercase font-bold tracking-widest text-gray-700">Experience</h2>
      <Experience
        v-for="experience in profile.experience"
        :key="experience.id"
        class="mt-8 pl-4 ml-4 border-l-4 border-gray-700"
        :experience="experience"
      />
    </div>
    <hr class="mt-8 mb-12" />
    <div>
      <h2 class="text-3xl uppercase font-bold tracking-widest text-gray-700">Education</h2>
      <div v-for="education in profile.education" :key="education.id" class="mt-8 pl-4 ml-4 border-l-4 border-gray-700">
        <section class="mb-2 flex items-center">
          <span class="text-xl font-bold text-gray-700">{{ education.institution }}</span>
          <span class="ml-4 text-gray-500">{{ education.location }}</span>
        </section>
        <section class="mb-4 flex items-center">
          <span class="font-semibold">{{ education.degree }} in {{ education.major }}</span>
          <span class="ml-4 text-gray-500">
            {{ education.from | formatDate }} -
            {{ education.currently_working ? 'Present' : $options.filters.formatDate(education.to) }}
          </span>
        </section>
        <p v-if="education.description">{{ education.description }}</p>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue'
import { PropType } from '@nuxtjs/composition-api'
import { Profile } from '@/types/api'
import Experience from '@/components/profile/Experience.vue'
export default Vue.extend({
  name: 'AboutItem',
  components: { Experience },
  props: {
    profile: {
      required: true,
      type: Object as PropType<Profile>,
    },
  },
})
</script>

<style scoped>

</style>
