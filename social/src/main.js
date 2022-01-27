// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import axios from 'axios'
import Vuex from 'vuex'
Vue.use(Vuex)

Vue.config.productionTip = false
Vue.prototype.$http = axios
Vue.prototype.$urlAPI = 'http://127.0.0.1:8000/api/'

var store = {
  state: {
    nome: 'Rede Social',
    sobrenome: 'Souza'
  },
  getters: {
    getNome(state){
      return state.nome;
    },
    getNomeCompleto(state){
      return state.nome + ' ' + state.sobrenome;
    }
  },
  mutations: {
    setNome(state, value){
      state.nome = value;
    }
  }
};

/* eslint-disable no-new */
new Vue({
  el: '#app',
  store: new Vuex.Store(store),
  router,
  components: { App },
  template: '<App/>'
})
