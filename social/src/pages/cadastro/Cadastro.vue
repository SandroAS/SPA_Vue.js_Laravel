<template>
  <LoginTamplate>

    <span slot="menuesquerdo">
      <img class="responsive-img" src="https://assets.bizcapital.com.br/staging-blog/uploads/20190603184146/Img_Redes_Sociais_para_Neg%C3%B3cios_2-2-585x350.jpg" alt="Capa Login">
    </span>
    <span slot="principal">
      <h2>Cadastro</h2>

      <input type="text" placeholder="Nome">
      <input type="email" placeholder="E-mail">
      <input type="password" placeholder="Senha">
      <input type="password" placeholder="Confirme sua Senha">
      <button type="button" class="btn">Enviar</button>
      <router-link to="/login" class="btn orange">Já tenho conta</router-link>
    </span>
    
  </LoginTamplate>
</template>

<script>
import LoginTamplate from '@/tamplates/LoginTemplate'
export default {
  name: 'Cadastro',
  components:{
    LoginTamplate
  },
  data () {
    return {
      
    }
  },
}
</script>

<style scoped>

</style>
