<template>
  <CardConteudoVue perfil="http://materializecss.com/images/yuna.jpg"
  nome="Maria Silva"
  data="13/01/18 13:30">
  <CardDetalheVue img="http://materializecss.com/images/sample-1.jpg" titulo="Card Title" txt="I am a very simple card. I am good at containing small bits of information.
    I am convenient because I require little markup to use effectively."/>

  </CardConteudoVue>
</template>

<script>
import CardConteudoVue from '@/components/social/CardConteudoVue'
import CardDetalheVue from '@/components/social/CardDetalheVue'
export default {
  name: 'Home',
  components:{
    CardConteudoVue, CardDetalheVue
  },
  data () {
    return {

    }
  },
}
</script>

<style scoped>

</style>
