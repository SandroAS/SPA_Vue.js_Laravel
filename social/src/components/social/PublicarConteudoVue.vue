<template>
  <div class="row">
    <GridVue class="input-field" tamanho="12">
      <input type="text" v-model="conteudo.titulo">
      <textarea v-if="conteudo.titulo" placeholder="Conteúdo" v-model="conteudo.texto" class="materialize-textarea"></textarea>
      <input v-if="conteudo.titulo && conteudo.texto" type="text" placeholder="Link" v-model="conteudo.titulo">
      <input v-if="conteudo.titulo && conteudo.texto" type="text" placeholder="Url da imagem" v-model="conteudo.titulo">
      <label>O que esta acontecendo?</label>
    </GridVue>
    <p>
      <GridVue v-if="conteudo.titulo && conteudo.texto" tamanho="2 offset-s10" class="btn waves-effect waves-light">Publicar</GridVue>
    </p>
  </div>
</template>

<script>
import GridVue from '@/components/layouts/GridVue'
export default {
  name: "PublicarConteudoVue",
  props: [],
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
  }
}
</script>

<style>

</style>