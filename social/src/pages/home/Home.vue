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
        v-for="conteudo in listaConteudos" :key="conteudo.id"
        :totalcomentarios="conteudo.total_comentarios"
        :curtiuconteudo="conteudo.curtiu_conteudo"
        :totalcurtidas="conteudo.total_curtidas"
        :id="conteudo.id"
        :perfil="conteudo.user.imagem"
        :nome="conteudo.user.name"
        :data="conteudo.data"
      >
      
        <CardDetalheVue 
          :img="conteudo.imagem"
          :titulo="conteudo.titulo"
          :txt="conteudo.texto"
          :link="conteudo.link"
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
      },
    }
  },
  created(){
    if(this.$store.getters.getUsuario){
      this.usuario = this.$store.getters.getUsuario;
      this.$http.get(this.$urlAPI + `conteudo/lista`, {
        headers: {
          "Authorization": "Bearer " + this.usuario.token
        }
      }).then((response) => {
        if(response.data.status){
          this.$store.commit('setConteudosLinhaTempo', response.data.conteudos.data)
        }
      }).catch((error) => {
        console.error(error);
        alert("Erro! Tente novamente mais tarde.")
      })
    }
  },
  computed: {
    listaConteudos(){
      return this.$store.getters.getConteudosLinhaTempo;
    }
  }
}
</script>

<style scoped>

</style>
