<template>
  <span>
    <header>
      <NavBar logo="Social" cor="green darken-1"/>
    </header>
    <main>
      <div class="container">
        <router-view/>
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
export default {
  name: 'App',
  components: {
    NavBar, FooterVue
  }
}
</script>

<style>

</style>
