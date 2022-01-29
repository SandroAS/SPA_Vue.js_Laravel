<template>
  <div class="row">
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
          <a style="cursor: pointer;" @click="curtida(id)">
            <i class="material-icons">{{ curtiu }}</i>{{ totalCurtidas }}
          </a>
          <i class="material-icons">insert_comment</i>
        </p>
      </div>
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
  props:['id', 'perfil','nome','data'],
  data () {
    return {
      curtiu: 'favorite_border',
      totalCurtidas: 0
    }
  },
  methods: {
    curtida(id){
      this.$http.put(this.$urlAPI + `conteudo/curtir/` + id, {}, {
        headers: {
          "Authorization": "Bearer " + this.$store.getters.getToken
        }
      }).then((response) => {
        if(response.status) {
          this.totalCurtidas = response.data.curtidas;
          if(this.curtiu == 'favorite_border') {
            this.curtiu = 'favorite';
          } else {
            this.curtiu = 'favorite_border';
          }
        } else {
          alert(response.data.erro);
        }
      }).catch((error) => {
        console.error(error);
        alert("Erro! Tente novamente mais tarde.")
      })
    }
  }
}
</script>

<style scoped>

</style>
