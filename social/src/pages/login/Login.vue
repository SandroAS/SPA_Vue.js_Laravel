<template>
  <LoginTamplate>

    <h2>Login</h2>

    <input type="email" placeholder="E-mail">
    <input type="password" placeholder="Senha">
    <button type="button" class="btn">Entrar</button>

  </LoginTamplate>
</template>

<script>
import LoginTamplate from '@/tamplates/LoginTamplate'
import CardConteudoVue from '@/components/social/CardConteudoVue'
import CardDetalheVue from '@/components/social/CardDetalheVue'
import PublicarConteudoVue from '@/components/social/PublicarConteudoVue'
export default {
  name: 'Home',
  components:{
    CardConteudoVue, CardDetalheVue, PublicarConteudoVue, LoginTamplate
  },
  data () {
    return {

    }
  },
}
</script>

<style scoped>

</style>
