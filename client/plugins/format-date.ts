import Vue from 'vue'

Vue.filter('formatDate', (dateStr: string) => {
  const date = new Date(dateStr)
  const options:Intl.DateTimeFormatOptions = { month: 'short', year: 'numeric' }
  return date.toLocaleString('en-US', options)
})
