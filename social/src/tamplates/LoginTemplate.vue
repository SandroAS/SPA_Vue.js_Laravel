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
          <GridVue tamanho="8">
            <CardMenuVue>
              <slot name="menuesquerdo"/>
            </CardMenuVue>
          </GridVue>
          <GridVue tamanho="4">
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
  name: 'LoginTemplate',
  components: {
    NavBar, FooterVue, GridVue, CardMenuVue
  },
  data() {
    return {
      usuario: false
    }
  },
  created(){
    if(this.$store.getters.getUsuario){
      this.usuario = JSON.parse(this.$store.getters.getUsuario);
      this.$router.push('/')
    }
  }
}
</script>

<style>

</style>
