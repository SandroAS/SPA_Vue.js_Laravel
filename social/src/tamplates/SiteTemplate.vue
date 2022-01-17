<template>
  <span>
    <header>
      <NavBar logo="Social" url="/" cor="green darken-1">
        <li v-if="!usuario"><router-link to="/login">Login</router-link></li>
        <li v-if="!usuario"><router-link to="/cadastro">Cadastre-se</router-link></li>
        <li v-if="usuario"><router-link to="/cadastro">{{ usuario.name }}</router-link></li>
        <li v-if="usuario"><a @click="sair()">Sair</a></li>
      </NavBar>
    </header>
    <main>
      <div class="container">
        <div class="row">
          <GridVue tamanho="4">
            <CardMenuVue>
              <slot name="menuesquerdo"/>
            </CardMenuVue>
            <CardMenuVue>
              <h3>Teste</h3>
            </CardMenuVue>
          </GridVue>
          <GridVue tamanho="8">
            <slot name="principal"/>
          </GridVue>
        </div>
      </div>
    </main>
    <FooterVue cor="green darken-1" logo="Social" descricao="Teste de descrição" ano="2022">
      <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
      <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
      <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
      <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
    </FooterVue>
  </span>
</template>

<script>
import NavBar from '@/components/layouts/NavBar'
import FooterVue from '@/components/layouts/FooterVue'
import GridVue from '@/components/layouts/GridVue'
import CardMenuVue from '@/components/layouts/CardMenuVue'
export default {
  name: 'SiteTemplate',
  components: {
    NavBar, FooterVue, GridVue, CardMenuVue
  },
  data() {
    return {
      usuario: false
    }
  },
  created(){
    let uauarioAux = sessionStorage.getItem('usuario')
    if(uauarioAux){
      this.usuario = JSON.parse(uauarioAux);
    } else {
      this.$router.push('/login')
    }
  },
  methods: {
    sair(){
      sessionStorage.clear();
      this.usuario = false;
      this.$router.push('/login')
    }
  }
}
</script>

<style>

</style>
