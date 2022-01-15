<template>
  <span>
    <header>
      <NavBar logo="Social" cor="green darken-1"/>
    </header>
    <main>
      <div class="container">
        <div class="row">
          <GridVue tamanho="4">
            Menu
          </GridVue>
          <GridVue tamanho="8">
            <router-view/>
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
export default {
  name: 'App',
  components: {
    NavBar, FooterVue, GridVue
  }
}
</script>

<style>

</style>
