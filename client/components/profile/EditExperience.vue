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
        id="title"
        :model-value.sync="editExperience.title"
        :errors="errors.title"
        type="text"
        class="pb-8 pr-6 w-full lg:w-1/3"
        label="Job title"
        required
      />
      <TextInput
        id="company"
        :model-value.sync="editExperience.company"
        :errors="errors.company"
        type="text"
        class="pb-8 pr-6 w-full lg:w-1/3"
        label="Company name"
      />
      <TextInput
        id="location"
        :model-value.sync="editExperience.location"
        :errors="errors.location"
        type="text"
        class="pb-8 pr-6 w-full lg:w-1/3"
        label="Company location"
      />
      <textarea-input
        id="description"
        :model-value.sync="editExperience.description"
        :errors="errors.description"
        type="tel"
        class="pb-8 pr-6 w-full"
        label="Description"
      />
      <TextInput
        id="from"
        :model-value.sync="editExperience.from"
        :errors="errors.from"
        type="date"
        class="pb-8 pr-6 w-full lg:w-1/2"
        label="From"
        required
      />
      <TextInput
        id="to"
        :model-value.sync="editExperience.to"
        :errors="errors.to"
        type="date"
        class="pb-8 pr-6 w-full lg:w-1/2"
        label="To"
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
import { Experience } from '~/client/types/api'
export default Vue.extend({
  props: {
    experience: {
      required: true,
      type: Object as PropType<Experience>,
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
    const editExperience: Experience = {} as Experience
    return {
      editExperience,
      isBeingEdited,
      errors,
      submitting,
    }
  },
  computed: {
    isNew (): Boolean {
      return (this.experience.id === -1)
    },
    submitLabel (): string {
      return this.isNew ? 'Create experience' : 'Update experience'
    },
  },
  created () {
    this.editExperience = { ...this.experience }
  },
  methods: {
    submit (): void {
      this.submitting = true
      this.errors = {}

      const data = {
        ...this.editExperience,
        profile_id: this.profileId,
      }

      this.$axios({
        method: this.isNew ? 'post' : 'put',
        url: this.isNew ? 'experiences' : `experiences/${this.experience.id}`,
        data,
      })
        .then((data) => {
          this.$toast.show({
            type: 'success',
            message: this.isNew ? 'Experience added' : 'Experience updated',
            timeout: 6,
          })
          this.$emit('close')
          this.$emit('update', data.data)
          this.$emit('create', data.data)
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

      this.$axios.delete(`experiences/${this.experience.id}`)
        .then(() => {
          this.$toast.show({
            type: 'success',
            message: 'Experience deleted',
            timeout: 6,
          })
          this.$emit('close')
          this.$emit('delete', this.experience.id)
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
        this.$emit('delete', this.experience.id)
      else
        this.$modal.show({
          type: 'danger',
          title: 'Deleting experience',
          body: `Are you sure you want to delete the ${this.editExperience.title} at ${this.editExperience.company} experience?`,
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
