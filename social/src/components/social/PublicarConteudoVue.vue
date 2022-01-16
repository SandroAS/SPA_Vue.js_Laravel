<template>
  <div class="row">
    <GridVue class="input-field" tamanho="12">
      <textarea v-model="conteudo" class="materialize-textarea"></textarea>
      <label>O que esta acontecendo?</label>
    </GridVue>
    <p>
      <GridVue tamanho="2 offset-s10" class="btn waves-effect waves-light">Publicar</GridVue>
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
      conteudo: "",
    }
  }
}
</script>

<style>

</style>