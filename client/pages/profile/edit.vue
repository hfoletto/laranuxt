<template>
  <LoadingSpinner v-if="loading" class="my-8" />
  <div v-else>
    <div class="bg-white rounded-md shadow overflow-hidden my-8 max-w-4xl w-full">
      <div class="p-8 flex align-center justify-between border-b border-gray-100">
        <h1 class="text-3xl font-bold">
          <a href="/profile" class="text-indigo-400 hover:text-indigo-600">Profile</a>
          <span class="text-indigo-400 font-medium">/</span>
          Edit
        </h1>
        <PushButton theme="white" @click="logout">
          Sign out
          <mdicon name="logout" :size="18" class="ml-2" />
        </PushButton>
      </div>
      <form class="w-full" @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <div class="lg:flex lg:items-center w-full">
            <div class="w-full">
              <ImageUpload
                id="avatar"
                v-model="photo"
                :error="errors.photo"
                class="pb-8 pr-6 w-full"
                :current-image="profile.photo"
                label="Photo"
              />
            </div>
            <div class="w-full">
              <TextInput
                id="first_name"
                :model-value.sync="profile.first_name"
                :errors="errors.first_name"
                class="pb-8 pr-6 w-full"
                label="First name"
                required
              />
              <TextInput
                id="last_name"
                :model-value.sync="profile.last_name"
                :errors="errors.last_name"
                class="pb-8 pr-6 w-full"
                label="Last name"
                required
              />
              <TextInput
                id="job_title"
                :model-value.sync="profile.job_title"
                :errors="errors.job_title"
                class="pb-8 pr-6 w-full"
                label="Job Title"
                required
              />
              <TextInput
                id="email"
                :model-value.sync="profile.email"
                :errors="errors.email"
                type="email"
                class="pb-8 pr-6 w-full"
                label="Email"
                required
              />
            </div>
          </div>
          <TextInput
            id="phone_number"
            :model-value.sync="profile.phone_number"
            :errors="errors.phone_number"
            type="tel"
            class="pb-8 pr-6 w-full lg:w-1/2"
            label="Phone Number"
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
            required
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
    <div class="bg-white rounded-md shadow overflow-hidden my-8 max-w-4xl w-full">
      <h1 class="p-8 text-3xl font-bold">
        Experience
      </h1>
      <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
        <Experience
          v-for="experience in profile.experience"
          :key="experience.id"
          class="pl-4 pr-6 mb-8 border-l-4 border-gray-700 w-full"
          :experience="experience"
          :profile-id="profile.id"
          editable
          @create="createExperience"
          @update="updateExperience"
          @delete="deleteExperience"
        />
      </div>
      <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center flex-row-reverse">
        <PushButton theme="white" :disabled="!canAddNewExperience" @click="newExperience">Add experience</PushButton>
      </div>
    </div>
    <div class="bg-white rounded-md shadow overflow-hidden my-8 max-w-4xl w-full">
      <h1 class="p-8 text-3xl font-bold">
        Education
      </h1>
      <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
        <Education
          v-for="education in profile.education"
          :key="education.id"
          class="pl-4 pr-6 mb-8 border-l-4 border-gray-700 w-full"
          :education="education"
          :profile-id="profile.id"
          editable
          @create="createEducation"
          @update="updateEducation"
          @delete="deleteEducation"
        />
      </div>
      <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center flex-row-reverse">
        <PushButton theme="white" :disabled="!canAddNewEducation" @click="newEducation">Add education</PushButton>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue'
import { Profile, Experience as ExperienceType, Education as EducationType } from '@/types/api'
import Experience from '@/components/profile/Experience.vue'
import Education from '@/components/profile/Education.vue'
export default Vue.extend({
  components: { Education, Experience },
  middleware: 'auth',
  data () {
    const loading: boolean = true
    const submitting: boolean = false
    const profile: Profile = {} as Profile
    const errors: Object = {}
    const photo: File | null = null
    return {
      loading,
      submitting,
      profile,
      errors,
      photo,
    }
  },
  computed: {
    canAddNewExperience (): Boolean {
      return (this.profile.experience[this.profile.experience.length - 1].id !== -1)
    },
    canAddNewEducation (): Boolean {
      return (this.profile.education[this.profile.education.length - 1].id !== -1)
    },
  },
  mounted () {
    this.fetchInfo()
      .finally(() => {
        this.loading = false
      })
  },
  methods: {
    async fetchInfo (): Promise<void> {
      this.profile = (await this.$axios.get('profiles')).data
    },
    submit (): void {
      this.submitting = true
      this.errors = {}

      const fields_to_submit = [
        'first_name', 'last_name', 'job_title', 'email', 'phone_number', 'location',
        'introduction', 'github_url', 'linkedin_url', 'twitter_url', 'website_url',
      ]

      const form_data = new FormData()
      form_data.append('_method', 'PUT')

      fields_to_submit.forEach((key) => {
        const value = this.profile[key as keyof Profile]
        if (typeof value === 'string' || value instanceof Blob)
          form_data.append(key, value)
      })
      if (this.photo !== null)
        form_data.append('photo', this.photo!)

      this.$axios.post(`profiles/${this.profile.id}`, form_data, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      })
        .then((data) => {
          this.profile = {
            ...data.data,
            experience: this.profile.experience,
            education: this.profile.education,
          }
          this.photo = null
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
    newExperience (): void {
      this.profile.experience.push({
        id: -1,
        title: '',
        company: '',
        location: '',
        description: '',
        from: '',
        to: null,
        currently_working: false,
        created_at: new Date(),
        updated_at: new Date(),
      })
    },
    createExperience (experience: ExperienceType) {
      this.profile.experience = this.profile.experience.filter(el => el.id !== -1)
      this.profile.experience.push(experience)
    },
    updateExperience (experience: ExperienceType): void {
      this.profile.experience = this.profile.experience.map((el) => {
        if (el.id === experience.id) return experience
        return el
      })
    },
    deleteExperience (experience_id: Number): void {
      this.profile.experience = this.profile.experience.filter(el => el.id !== experience_id)
    },
    newEducation (): void {
      this.profile.education.push({
        id: -1,
        institution: '',
        location: '',
        degree: '',
        major: '',
        description: '',
        from: '',
        to: null,
        currently_attending: false,
        created_at: new Date(),
        updated_at: new Date(),
      })
    },
    createEducation (education: EducationType) {
      this.profile.education = this.profile.education.filter(el => el.id !== -1)
      this.profile.education.push(education)
    },
    updateEducation (education: EducationType): void {
      this.profile.education = this.profile.education.map((el) => {
        if (el.id === education.id) return education
        return el
      })
    },
    deleteEducation (education_id: Number): void {
      this.profile.education = this.profile.education.filter(el => el.id !== education_id)
    },
    logout ():void {
      this.loading = true
      this.$auth.logout()
    },
  },
})
</script>
