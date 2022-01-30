<template>
  <div class="row">
    <div class="card">
      <div class="card-content">
        <div class="row valign-wrapper">
          <GridVue tamanho="1">
            <img :src="perfil" :alt="nome" class="circle responsive-img">
          </GridVue>
          <GridVue tamanho="11">
            <span class="black-text">
              <router-link :to="'/pagina/' + usuarioid">
                <strong>{{nome}}</strong> - <small>{{data}}</small>
              </router-link>
            </span>
          </GridVue>
        </div>
        <slot />
      </div>
      <div class="card-action">
        <p>
          <a style="cursor: pointer;" @click="curtida(id)">
            <i class="material-icons">{{ curtiu }}</i>{{ totalCurtidas }}
          </a>
          <a style="cursor: pointer;" @click="abreComentarios(id)">
            <i class="material-icons">insert_comment</i>{{ listaComentarios.length }}
          </a>
        </p>
        <p v-if="exibirComentario" class="right-align">
          <input v-model="comentario.texto" type="text" placeholder="Comentário">
          <button v-if="comentario.texto" @click="salvarComentario(id)" class="btn waves-effect waves-light orange"><i class="material-icons">send</i></button>
        </p>
        <p v-if="exibirComentario">
          <ul class="collection">
            <li class="collection-item avatar" v-for="comentario in comentarios" :key="comentario.id">
              <img :src="comentario.user.imagem" alt="" class="circle">
              <span class="title">{{ comentario.user.name }} <small> - {{ comentario.data }}</small></span>
              <p>{{ comentario.texto }}</p>
            </li>
          </ul>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import GridVue from '@/components/layouts/GridVue'
export default {
  name: 'CardConteudoVue',
  components:{
    GridVue
  },
  props:['usuarioid', 'comentarios', 'curtiuconteudo', 'totalcurtidas', 'id', 'perfil','nome','data'],
  data () {
    return {
      curtiu: this.curtiuconteudo ? 'favorite' : 'favorite_border',
      totalCurtidas: this.totalcurtidas,
      exibirComentario: false,
      comentario: {
        texto: ""
      },
      listaComentarios: this.comentarios || []
    }
  },
  created(){

  },
  methods: {
    curtida(id){
      this.$http.put(this.$urlAPI + `conteudo/curtir/` + id, {}, {
        headers: {
          "Authorization": "Bearer " + this.$store.getters.getToken
        }
      }).then((response) => {
        if(response.status) {
          this.totalCurtidas = response.data.curtidas;
          this.$store.commit('setConteudosLinhaTempo', response.data.lista.conteudos.data)
          if(this.curtiu == 'favorite_border') {
            this.curtiu = 'favorite';
          } else {
            this.curtiu = 'favorite_border';
          }
        } else {
          alert(response.data.erro);
        }
      }).catch((error) => {
        console.error(error);
        alert("Erro! Tente novamente mais tarde.")
      })
    },
    abreComentarios(id){
      this.exibirComentario = !this.exibirComentario;
    },
    salvarComentario(id){
      if(!this.comentario.texto) return;
      this.$http.post(this.$urlAPI + `comentario/adicionar/` + id, this.comentario, {
        headers: {
          "Authorization": "Bearer " + this.$store.getters.getToken
        }
      }).then((response) => {
        if(response.status) {
          this.$store.commit('setConteudosLinhaTempo', response.data.lista.conteudos.data)
          this.comentario.texto = "";
        } else {
          alert(response.data.erro);
        }
      }).catch((error) => {
        console.error(error);
        alert("Erro! Tente novamente mais tarde.")
      })
    }
  }
}
</script>

<style scoped>

</style>
