<template>
  <span>
    <header>
      <NavBar logo="Social" cor="green darken-1"/>
    </header>
    <main>
      <div class="container">
        <div class="row">
          <GridVue tamanho="6">
            <CardMenuVue>
              
            </CardMenuVue>
          </GridVue>
          <GridVue tamanho="6">
            <slot/>
          </GridVue>
        </div>
      </div>
    </main>
    <FooterVue cor="green darken-1" logo="Social" descricao="Teste de descrição" ano="2022">
      <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
      <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
      <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
      <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
    </FooterVue>
  </span>
</template>

<script>
import NavBar from '@/components/layouts/NavBar'
import FooterVue from '@/components/layouts/FooterVue'
import GridVue from '@/components/layouts/GridVue'
import CardMenuVue from '@/components/layouts/CardMenuVue'
export default {
  name: 'LoginTemplate',
  components: {
    NavBar, FooterVue, GridVue, CardMenuVue
  }
}
</script>

<style>

</style>
