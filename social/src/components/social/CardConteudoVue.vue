<template>
  <div class="card">
    <div class="card-content">
      <div class="row valign-wrapper">
        <GridVue tamanho="1">
          <img :src="perfil" :alt="nome" class="circle responsive-img">
        </GridVue>
        <GridVue tamanho="11">
          <span class="black-text">
            <strong>{{nome}}</strong> - <small>{{data}}</small>
          </span>
        </GridVue>
      </div>
      <slot />
    </div>
    <div class="card-action">
      <p>
        <i class="material-icons">favorite_border</i>
        <i class="material-icons">insert_comment</i>
      </p>
    </div>
  </div>
</template>

<script>
import GridVue from '@/components/layouts/GridVue'
export default {
  name: 'CardConteudoVue',
  components:{
    GridVue
  },
  props:['perfil','nome','data'],
  data () {
    return {

    }
  }
}
</script>

<style scoped>

</style>
