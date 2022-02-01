<template>
  <div v-if="!isBeingEdited" :class="$attrs.class">
    <section class="mb-2 lg:flex lg:items-center relative">
      <span class="block text-xl font-bold text-gray-700">{{ education.institution }}</span>
      <span class="block lg:ml-4 text-gray-500">{{ education.location }}</span>
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
    <section class="mb-4 lg:flex lg:items-center">
      <span class="block font-semibold">{{ education.degree }} in {{ education.major }}</span>
      <span class="block lg:ml-4 text-gray-500">
        {{ education.from | formatDate }} -
        {{ education.currently_attending ? 'Present' : $options.filters.formatDate(education.to) }}
      </span>
    </section>
    <p v-if="education.description" class="whitespace-pre-line">{{ education.description }}</p>
  </div>
  <edit-education
    v-else
    :education="education"
    :profile-id="profileId"
    @close="isBeingEdited = false"
    v-on="$listeners"
  />
</template>

<script lang="ts">
import Vue from 'vue'
import { PropType } from '@nuxtjs/composition-api'
import { Education } from '@/types/api'
import EditEducation from '@/components/profile/EditEducation.vue'
export default Vue.extend({
  components: { EditEducation },
  props: {
    education: {
      required: true,
      type: Object as PropType<Education>,
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
    if (this.education.id === -1 && this.editable)
      this.isBeingEdited = true
  },
})
</script>
