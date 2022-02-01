<template>
  <div v-if="!isBeingEdited" :class="$attrs.class">
    <section class="mb-2 flex items-center relative">
      <span class="text-xl font-bold text-gray-700">{{ skill.name }}</span>
      <span v-if="skill.years_of_experience" class="ml-4 text-gray-500">{{ skill.years_of_experience }} years of experience</span>
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
  </div>
  <edit-skill
    v-else
    :skill="skill"
    :profile-id="profileId"
    @close="isBeingEdited = false"
    v-on="$listeners"
  />
</template>

<script lang="ts">
import Vue from 'vue'
import { PropType } from '@nuxtjs/composition-api'
import { Skill } from '@/types/api'
import EditSkill from '@/components/profile/EditSkill.vue'
export default Vue.extend({
  components: { EditSkill },
  props: {
    skill: {
      required: true,
      type: Object as PropType<Skill>,
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
    if (this.skill.id === -1 && this.editable)
      this.isBeingEdited = true
  },
})
</script>
