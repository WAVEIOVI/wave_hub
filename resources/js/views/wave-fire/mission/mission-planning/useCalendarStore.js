import axios from '@axios'

export const useCalendarStore = defineStore('calendar', {
  // arrow function recommended for full type inference
  state: () => ({
    availableCalendars: [
      {
        color: 'error',
        label: 'prevision',
      },
      {
        color: 'warning',
        label: 'pending',
      },
      {
        color: 'success',
        label: 'completed',
      },
    ],
    selectedCalendars: ['prevision', 'pending', 'completed'],
  }),
  actions: {
    fetchEvents() {
      const filters = []
      if (this.selectedCalendars) {
        filters.push({
          field: 'calendar',
          operator: 'in',
          value: this.selectedCalendars,
        })
      }
    
      return new Promise((resolve, reject) => {
        axios
          .post('/api/mission-events/search', { filters })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    addEvent(event) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/mission-events', event)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    updateEvent(event) {
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/mission-events/${event.id}`, event)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    removeEvent(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/mission-events/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
  },
})
