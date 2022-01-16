<template>
  <span>
    <div class="row">
      <GridVue class="input-field" tamanho="12">
        <textarea id="textarea1" class="materialize-textarea"></textarea>
        <label for="textarea1">O que esta acontecendo?</label>
      </GridVue>
      <p>
        <GridVue tamanho="2 offset-s10" class="btn waves-effect waves-light">Publicar</GridVue>
      </p>
    </div>
    <CardConteudoVue
      perfil="http://materializecss.com/images/yuna.jpg"
      nome="Maria Silva"
      data="13/01/18 13:30"
    >
      <CardDetalheVue 
        img="http://materializecss.com/images/sample-1.jpg"
        titulo="Card Title" txt="I am a very simple card. I am good at containing small bits of information.
        I am convenient because I require little markup to use effectively."
      />
    </CardConteudoVue>
  </span>
</template>

<script>
import CardConteudoVue from '@/components/social/CardConteudoVue'
import CardDetalheVue from '@/components/social/CardDetalheVue'
import GridVue from '@/components/layouts/GridVue'
export default {
  name: 'Home',
  components:{
    CardConteudoVue, CardDetalheVue, GridVue
  },
  data () {
    return {

    }
  },
}
</script>

<style scoped>

</style>
