<template>
  <SiteTemplate>
    <span slot="menuesquerdo">
      <div class="row valign-wrapper">
        <GridVue tamanho="4">
          <router-link :to="'/pagina/' + usuario.id + '/' + $slug(usuario.name, {lower: true})">
            <img :src="usuario.imagem" :alt="usuario.name" class="circle responsive-img">
          </router-link>
        </GridVue>
        <GridVue tamanho="8">
          <span class="black-text">
            <router-link :to="'/pagina/' + usuario.id + '/' + $slug(usuario.name, {lower: true})">
              <h4>{{ usuario.name }}</h4>
            </router-link>
          </span>
        </GridVue>
      </div>
    </span>
    <span slot="menuesquerdoamigos">
      <h3>Seguindo</h3>
      <router-link v-for="amigo in amigos" :key="amigo.id" :to="'/pagina/' + amigo.id + '/' + $slug(amigo.name, {lower: true})">
        <li>{{amigo.name}}</li>
      </router-link>
      <li v-if="!amigos.length">Nenhum Usuário</li>

      <h3>Seguidores</h3>
      <router-link v-for="seguidor in seguidores" :key="seguidor.email" :to="'/pagina/' + seguidor.id + '/' + $slug(seguidor.name, {lower: true})">
        <li>{{seguidor.name}}</li>
      </router-link>
      <li v-if="!seguidores.length">Nenhum Usuário</li>
    </span>
    <span slot="principal">
      <PublicarConteudoVue/>
      <CardConteudoVue
        v-for="conteudo in listaConteudos" :key="conteudo.id"
        :comentarios="conteudo.comentarios"
        :curtiuconteudo="conteudo.curtiu_conteudo"
        :totalcurtidas="conteudo.total_curtidas"
        :id="conteudo.id"
        :usuarioid="conteudo.user.id"
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
      usuario: {
        name: "",
        email: "",
        imagem: "",
        password: "",
      },
      urlProximaPagina: null,
      pararScroll: false,
      amigos: [],
      seguidores: []
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

          this.$http.get(this.$urlAPI + `usuario/lista-amigos`, {
            headers: {
              "Authorization": "Bearer " + this.usuario.token
            }
          }).then((response) => {
            if(response.data.status){
              this.amigos = response.data.amigos;
              this.seguidores = response.data.seguidores;
            } else {
              alert(response.data.erro);
            }
          }).catch((error) => {
            console.error(error);
            alert("Erro! Tente novamente mais tarde.")
          })

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
        if(response.data.status && this.$route.name == "Home"){
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
