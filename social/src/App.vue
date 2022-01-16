<template>
  <span>
    <header>
      <NavBar logo="Social" cor="green darken-1"/>
    </header>
    <main>
      <div class="container">
        <div class="row">
          <GridVue tamanho="4">
            <CardMenuVue>
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
            </CardMenuVue>
            <CardMenuVue>
              <h3>Teste</h3>
            </CardMenuVue>
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
import CardMenuVue from '@/components/layouts/CardMenuVue'
export default {
  name: 'App',
  components: {
    NavBar, FooterVue, GridVue, CardMenuVue
  }
}
</script>

<style>

</style>
