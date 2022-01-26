<template>
  <div class="row">
    <GridVue class="input-field" tamanho="12">
      <input type="text" v-model="conteudo.titulo">
      <textarea v-if="conteudo.titulo" placeholder="Conteúdo" v-model="conteudo.texto" class="materialize-textarea"></textarea>
      <input v-if="conteudo.titulo && conteudo.texto" type="text" placeholder="Link" v-model="conteudo.link">
      <input v-if="conteudo.titulo && conteudo.texto" type="text" placeholder="Url da imagem" v-model="conteudo.imagem">
      <label>O que esta acontecendo?</label>
    </GridVue>
    <p class="right-align">
      <button v-if="conteudo.titulo && conteudo.texto" @click="addConteudo" class="btn waves-effect waves-light">Publicar</button>
    </p>
  </div>
</template>

<script>
import GridVue from '@/components/layouts/GridVue'
export default {
  name: "PublicarConteudoVue",
  props: ['usuario'],
  components: {
    GridVue
  },
  data () {
    return {
      conteudo: {
        titulo: "",
        texto: "",
        link: "",
        imagem: ""
      },
    }
  },
  methods: {
    addConteudo(){
      this.$http.post(this.$urlAPI + `conteudo/adicionar`, this.conteudo, {
        headers: {
          "Authorization": "Bearer " + this.usuario.token
        }
      }).then((response) => {
        if(response.data.status){
          this.conteudo = response.data.conteudo;
          alert("Conteúdo cadastrado com sucesso!");
          this.resetaConteudo();
        } else if(response.data.status == false && response.data.validacao) {
          let errors = "";
          for (let error of Object.values(response.data.erros)){
            errors += error + " ";
          }
          alert(errors);
        }
      }).catch((error) => {
        console.error(error);
        alert("Erro! Tente novamente mais tarde.")
      })
    },
    resetaConteudo(){
      this.conteudo = {
        titulo: "",
        texto: "",
        link: "",
        imagem: ""
      }
    }
  }
}
</script>

<style>

</style>