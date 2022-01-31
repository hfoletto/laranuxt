
export interface MetApiResponse {
  benchmark: number
  status: 'success' | 'failure'
  query: {
    options: Record<string, any>
    params: Record<string, any>
  }
  paginate?: {
    current_page: number
    first_item: number
    last_item: number
    last_page: number
    pages: Array<number>
    per_page: number
    total: number
  }
  data: any
}

export interface User {
  name: string
  job: string
  email: string
  phone: string
  avatar: string
}

export type Users = Array<User>

export interface Profile {
  id: number,
  first_name: string,
  last_name: string,
  job_title: string,
  email: string,
  phone_number: string | null,
  location: string | null,
  introduction: string | null,
  github_url: string | null,
  linkedin_url: string | null,
  twitter_url: string | null,
  website_url: string | null,
  created_at: Date,
  updated_at: Date,
  experience: Array<Experience>,
  education: Array<Education>,
}

export interface Experience {
  id: number,
  title: string,
  company: string | null,
  location: string | null,
  description: string | null,
  from: string,
  to: string | null
  currently_working: boolean,
  created_at: Date,
  updated_at: Date,
}

export interface Education {
  id: number,
  institution: string,
  major: string,
  degree: string,
  location: string,
  description: string | null,
  from: string,
  to: string | null
  currently_attending: boolean,
  created_at: Date,
  updated_at: Date,
}
