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
        :comentarios="conteudo.comentarios"
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
      <div v-scroll="handleScroll"></div>
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
      urlProximaPagina: null,
      pararScroll: false
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
          this.urlProximaPagina = response.data.conteudos.next_page_url;
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
  },
  methods: {
    handleScroll(evt, el){
      if(this.pararScroll) return;
      if(window.scrollY >= document.body.clientHeight - 1069) {
        this.pararScroll = true;
        this.carregaPaginacao();
      }
    },
    carregaPaginacao(){
      if(!this.urlProximaPagina ){
        return;
      }
      this.$http.get(this.urlProximaPagina, {
        headers: {
            "Authorization":"Bearer "+this.$store.getters.getToken
        }
      }).then(response => {
        if(response.data.status){
          this.$store.commit('setPaginacaoConteudosLinhaTempo',response.data.conteudos.data);
          this.urlProximaPagina = response.data.conteudos.next_page_url;
          this.pararScroll = false;
        }
      }).catch(error => {
        console.log(error)
        alert("Erro! Tente novamente mais tarde!");
      })
    }
  }
}
</script>

<style scoped>

</style>
