<template>
  <LoginTamplate>

    <span slot="menuesquerdo">
      <img class="responsive-img" src="https://assets.bizcapital.com.br/staging-blog/uploads/20190603184146/Img_Redes_Sociais_para_Neg%C3%B3cios_2-2-585x350.jpg" alt="Capa Login">
    </span>
    <span slot="principal">
      <span v-if="!cadastro">
        <h2>Login</h2>

        <input type="email" placeholder="E-mail">
        <input type="password" placeholder="Senha">
        <button type="button" class="btn">Entrar</button>
        <button type="button" class="btn orange" @click="cadastro = !cadastro">Cadastre-se</button>
      </span>
      <span v-if="cadastro">
        <h2>Cadastro</h2>

        <input type="text" placeholder="Nome">
        <input type="email" placeholder="E-mail">
        <input type="password" placeholder="Senha">
        <input type="password" placeholder="Confirme sua Senha">
        <button type="button" class="btn">Enviar</button>
      </span>
    </span>

  </LoginTamplate>
</template>

<script>
import LoginTamplate from '@/tamplates/LoginTemplate'
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
      cadastro: false,
    }
  },
}
</script>

<style scoped>

</style>
