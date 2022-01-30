// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import axios from 'axios'
import Vuex from 'vuex'
import slug from 'slug'

Vue.use(Vuex)

Vue.config.productionTip = false
Vue.prototype.$http = axios
Vue.prototype.$urlAPI = 'http://127.0.0.1:8000/api/'
Vue.prototype.$slug = slug

var store = {
  state: {
    usuario: sessionStorage.getItem('usuario') ? JSON.parse(sessionStorage.getItem('usuario')) : null,
    conteudosLinhaTempo: []
  },
  getters: {
    getUsuario(state){
      return state.usuario;
    },
    getToken(state){
      return state.usuario.token;
    },
    getConteudosLinhaTempo(state){
      return state.conteudosLinhaTempo;
    }
  },
  mutations: {
    setUsuario(state, value){
      state.usuario = value;
    },
    setConteudosLinhaTempo(state, value){
      state.conteudosLinhaTempo = value;
    },
    setPaginacaoConteudosLinhaTempo(state,lista){
      for(let item of lista){
        state.conteudosLinhaTempo.push(item);
      }
    }
  }
};

Vue.directive('scroll', {
  inserted: function (el, binding) {
    let f = function (evt) {
      if(binding.value(evt, el)) {
        window.removeEventListener('scroll', f)
      }
    }
    window.addEventListener('scroll', f)
  }
})

/* eslint-disable no-new */
new Vue({
  el: '#app',
  store: new Vuex.Store(store),
  router,
  components: { App },
  template: '<App/>'
})
