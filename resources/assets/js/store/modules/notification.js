export default {
  state: {
    notificationShown: false,
    type: '',
    message: ''
  },

  mutations: {
    togglePopupVisibility (state, status) {
      state.notificationShown = status
    },
    setType (state, type) {
      state.type = type
    },
    setMessage (state, message) {
      state.message = message
    }
  },

  actions: {
   async showNotification ({ commit }, data) {
      commit('togglePopupVisibility', true)
      commit('setType', data.type)
      commit('setMessage', data.message)
      setTimeout(() => {
        commit('togglePopupVisibility', false)
      }, 4000)
    },
    closeNotification ({ commit }) {
      commit('togglePopupVisibility', false)
    }
  }
}
