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
        id="institution"
        :model-value.sync="editEducation.institution"
        :errors="errors.institution"
        type="text"
        class="pb-8 pr-6 w-full lg:w-1/2"
        label="Institution name"
        required
      />
      <TextInput
        id="location"
        :model-value.sync="editEducation.location"
        :errors="errors.location"
        type="text"
        class="pb-8 pr-6 w-full lg:w-1/2"
        label="Institution location"
        required
      />
      <TextInput
        id="degree"
        :model-value.sync="editEducation.degree"
        :errors="errors.degree"
        type="text"
        class="pb-8 pr-6 w-full lg:w-1/2"
        label="Degree"
        required
      />
      <TextInput
        id="major"
        :model-value.sync="editEducation.major"
        :errors="errors.major"
        type="text"
        class="pb-8 pr-6 w-full lg:w-1/2"
        label="Major"
        required
      />
      <textarea-input
        id="description"
        :model-value.sync="editEducation.description"
        :errors="errors.description"
        type="tel"
        class="pb-8 pr-6 w-full"
        label="Description"
      />
      <TextInput
        id="from"
        :model-value.sync="editEducation.from"
        :errors="errors.from"
        type="date"
        class="pb-8 pr-6 w-full lg:w-1/2"
        label="From"
        required
      />
      <TextInput
        id="to"
        :model-value.sync="editEducation.to"
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
import { Education } from '~/client/types/api'
export default Vue.extend({
  props: {
    education: {
      required: true,
      type: Object as PropType<Education>,
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
    const editEducation: Education = {} as Education
    return {
      editEducation,
      isBeingEdited,
      errors,
      submitting,
    }
  },
  computed: {
    isNew (): Boolean {
      return (this.education.id === -1)
    },
    submitLabel (): string {
      return this.isNew ? 'Create education' : 'Update education'
    },
  },
  created () {
    this.editEducation = { ...this.education }
  },
  methods: {
    submit (): void {
      this.submitting = true
      this.errors = {}

      const data = {
        ...this.editEducation,
        profile_id: this.profileId,
      }

      this.$axios({
        method: this.isNew ? 'post' : 'put',
        url: this.isNew ? 'educations' : `educations/${this.education.id}`,
        data,
      })
        .then((data) => {
          this.$toast.show({
            type: 'success',
            message: this.isNew ? 'Education added' : 'Education updated',
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

      this.$axios.delete(`educations/${this.education.id}`)
        .then(() => {
          this.$toast.show({
            type: 'success',
            message: 'Education deleted',
            timeout: 6,
          })
          this.$emit('close')
          this.$emit('delete', this.education.id)
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
        this.$emit('delete', this.education.id)
      else
        this.$modal.show({
          type: 'danger',
          title: 'Deleting education',
          body: `Are you sure you want to delete the education at ${this.editEducation.institution}?`,
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
