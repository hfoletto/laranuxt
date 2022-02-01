<template>
  <div v-if="!isBeingEdited" :class="$attrs.class">
    <section class="mb-2 flex items-center relative">
      <span class="text-xl font-bold text-gray-700">{{ experience.company }}</span>
      <span v-if="experience.company" class="ml-4 text-gray-500">{{ experience.location }}</span>
      <div
        v-if="editable"
        class="absolute top-0 right-0 bg-gray-500 rounded-full p-2 cursor-pointer hover:bg-gray-800"
        @click="isBeingEdited = true"
      >
        <mdicon
          name="pencil"
          class="text-white"
          :size="18"
        />
      </div>
    </section>
    <section class="mb-4 flex items-center">
      <span class="font-semibold">{{ experience.title }}</span>
      <span class="ml-4 text-gray-500">
        {{ experience.from | formatDate }} -
        {{ experience.currently_working ? 'Present' : $options.filters.formatDate(experience.to) }}
      </span>
    </section>
    <p v-if="experience.description" class="whitespace-pre-line">{{ experience.description }}</p>
  </div>
  <edit-experience
    v-else
    :experience="experience"
    :profile-id="profileId"
    @close="isBeingEdited = false"
    v-on="$listeners"
  />
</template>

<script lang="ts">
import Vue from 'vue'
import { PropType } from '@nuxtjs/composition-api'
import { Experience } from '@/types/api'
import EditExperience from '@/components/profile/EditExperience.vue';
export default Vue.extend({
  components: { EditExperience },
  props: {
    experience: {
      required: true,
      type: Object as PropType<Experience>,
    },
    editable: {
      type: Boolean,
      default: false,
    },
    profileId: {
      type: Number,
    },
  },
  data () {
    const isBeingEdited: boolean = false
    return {
      isBeingEdited,
    }
  },
  created () {
    if (this.experience.id === -1 && this.editable)
      this.isBeingEdited = true
  },
})
</script>
