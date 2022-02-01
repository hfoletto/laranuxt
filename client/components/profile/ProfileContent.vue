<template>
  <div class="content w-full p-12 bg-white">
    <div id="profile" class="prose">
      <h2 class="text-3xl uppercase font-bold tracking-widest text-gray-700">Profile</h2>
      <p class="mt-4">{{ profile.introduction }}</p>
    </div>
    <hr class="my-8">
    <div>
      <h2 class="text-3xl uppercase font-bold tracking-widest text-gray-700">Experience</h2>
      <Experience
        v-for="experience in profile.experience"
        :key="experience.id"
        class="mt-8 pl-4 ml-4 border-l-4 border-gray-700"
        :experience="experience"
      />
    </div>
    <hr class="mt-8 mb-12">
    <div>
      <h2 class="text-3xl uppercase font-bold tracking-widest text-gray-700">Education</h2>
      <Education
        v-for="education in profile.education"
        :key="education.id"
        class="mt-8 pl-4 ml-4 border-l-4 border-gray-700"
        :education="education"
      />
    </div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue'
import { PropType } from '@nuxtjs/composition-api'
import { Profile } from '@/types/api'
import Experience from '@/components/profile/Experience.vue'
import Education from '@/components/profile/Education.vue'
export default Vue.extend({
  name: 'AboutItem',
  components: { Experience, Education },
  props: {
    profile: {
      required: true,
      type: Object as PropType<Profile>,
    },
  },
})
</script>
