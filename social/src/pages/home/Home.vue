<template>
  <SiteTemplate>
    <span slot="menuesquerdo">
      <div class="row valign-wrapper">
        <GridVue tamanho="4">
          <img :src="usuario.imagem" :alt="usuario.name" class="circle responsive-img"> <!-- notice the "circle" class -->
        </GridVue>
        <GridVue tamanho="8">
          <span class="black-text">
            <h4>{{ usuario.name }}</h4>

          </span>
        </GridVue>
      </div>
    </span>
    <span slot="principal">
      <PublicarConteudoVue/>
      <CardConteudoVue
        :perfil="usuario.imagem"
        :nome="usuario.name"
        data="13/01/18 13:30"
      >
        <CardDetalheVue 
          img="http://materializecss.com/images/sample-1.jpg"
          titulo="Card Title" txt="I am a very simple card. I am good at containing small bits of information.
          I am convenient because I require little markup to use effectively."
        />
      </CardConteudoVue>
    </span>
  </SiteTemplate>
</template>

<script>
import SiteTemplate from '@/tamplates/SiteTemplate'
import CardConteudoVue from '@/components/social/CardConteudoVue'
import CardDetalheVue from '@/components/social/CardDetalheVue'
import PublicarConteudoVue from '@/components/social/PublicarConteudoVue'
import GridVue from '@/components/layouts/GridVue'
export default {
  name: 'Home',
  components:{
    CardConteudoVue, CardDetalheVue, PublicarConteudoVue, SiteTemplate, GridVue
  },
  data () {
    return {
      usuarioAuth: false,
      usuario: {
        name: "",
        email: "",
        imagem: "",
        password: "",
      }
    }
  },
  created(){
    if(this.$store.getters.getUsuario){
      this.usuario = JSON.parse(this.$store.getters.getUsuario);
    }
  },
}
</script>

<style scoped>

</style>
