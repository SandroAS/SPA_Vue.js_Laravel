<template>
  <LoginTamplate>

    <h2>Cadastro</h2>

    <input type="text" placeholder="Nome">
    <input type="email" placeholder="E-mail">
    <input type="password" placeholder="Senha">
    <input type="password" placeholder="Confirme sua Senha">
    <button type="button" class="btn">Enviar</button>
    <router-link to="/login" class="btn orange">Já tenho conta</router-link>

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
