<template>
  <SiteTemplate>
    <span slot="menuesquerdo">
      <div class="row valign-wrapper">
        <GridVue tamanho="4">
          <img src="https://materializecss.com/images/yuna.jpg" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
        </GridVue>
        <GridVue tamanho="8">
          <span class="black-text">
            <h4>Maria Silva</h4>
            This is a square image. Add the "circle" class to it to make it appear circular.
          </span>
        </GridVue>
      </div>
    </span>
    <span slot="principal">
      <PublicarConteudoVue/>
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

    }
  },
}
</script>

<style scoped>

</style>
