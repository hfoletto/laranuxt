<template>
  <form class="w-full relative" @submit.prevent="submit">
    <div
      v-if="!isNew"
      class="absolute top-0 right-6 bg-gray-500 rounded-full p-2 cursor-pointer hover:bg-gray-800"
      @click="$emit('close')"
    >
      <mdicon
        name="close"
        class="text-white"
        :size="18"
      />
    </div>
    <div class="p-8 pl-2 -mr-6 -mb-8 flex flex-wrap">
      <TextInput
        id="name"
        :model-value.sync="editSkill.name"
        :errors="errors.name"
        type="text"
        class="pb-8 pr-6 w-full lg:w-2/3"
        label="Name"
        required
      />
      <TextInput
        id="years_of_experience"
        :model-value.sync="editSkill.years_of_experience"
        :errors="errors.years_of_experience"
        type="number"
        class="pb-8 pr-6 w-full lg:w-1/3"
        label="Years of experience"
      />
    </div>
    <div class="flex justify-between items-center mb-4">
      <PushButton theme="red" :disabled="submitting" @click="openDeleteModal">
        {{ isNew ? 'Cancel' : 'Delete' }}
      </PushButton>
      <PushButton theme="indigo" type="submit" :disabled="submitting">
        <mdicon v-if="submitting" name="loading" :size="18" class="animate-spin mr-2" />
        {{ submitting ? 'Processing...' : submitLabel }}
      </PushButton>
    </div>
  </form>
</template>

<script lang="ts">
import Vue from 'vue'
import { PropType } from '@nuxtjs/composition-api'
import { Skill } from '~/client/types/api'
export default Vue.extend({
  props: {
    skill: {
      required: true,
      type: Object as PropType<Skill>,
    },
    profileId: {
      required: true,
      type: Number,
    },
  },
  data () {
    const errors: Object = {}
    const isBeingEdited: boolean = true
    const submitting: boolean = false
    const editSkill: Skill = {} as Skill
    return {
      editSkill,
      isBeingEdited,
      errors,
      submitting,
    }
  },
  computed: {
    isNew (): Boolean {
      return (this.skill.id === -1)
    },
    submitLabel (): string {
      return this.isNew ? 'Create skill' : 'Update skill'
    },
  },
  created () {
    this.editSkill = { ...this.skill }
  },
  methods: {
    submit (): void {
      this.submitting = true
      this.errors = {}

      const data = {
        ...this.editSkill,
        profile_id: this.profileId,
      }

      this.$axios({
        method: this.isNew ? 'post' : 'put',
        url: this.isNew ? 'skills' : `skills/${this.skill.id}`,
        data,
      })
        .then((data) => {
          this.$toast.show({
            type: 'success',
            message: this.isNew ? 'Skill added' : 'Skill updated',
            timeout: 6,
          })
          this.$emit('close')
          this.$emit(this.isNew ? 'create' : 'update', data.data)
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
    delete (): void {
      this.submitting = true
      this.errors = {}

      this.$axios.delete(`skills/${this.skill.id}`)
        .then(() => {
          this.$toast.show({
            type: 'success',
            message: 'Skill deleted',
            timeout: 6,
          })
          this.$emit('close')
          this.$emit('delete', this.skill.id)
        })
        .catch(() => {
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
    openDeleteModal (): void {
      if (this.isNew)
        this.$emit('delete', this.skill.id)
      else
        this.$modal.show({
          type: 'danger',
          title: 'Deleting skill',
          body: `Are you sure you want to delete the ${this.editSkill.name} skill?`,
          primary: {
            label: 'Confirm',
            theme: 'red',
            action: () => this.delete(),
          },
          secondary: {
            label: 'Cancel',
            theme: 'white',
            action: () => {},
          },
        })
    },
  },
})
</script>
