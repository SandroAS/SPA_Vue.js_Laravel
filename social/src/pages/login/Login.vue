<template>
  <LoginTamplate>

    <span slot="menuesquerdo">
      <img class="responsive-img" src="https://assets.bizcapital.com.br/staging-blog/uploads/20190603184146/Img_Redes_Sociais_para_Neg%C3%B3cios_2-2-585x350.jpg" alt="Capa Login">
    </span>
    <span slot="principal">
      <h2>Login</h2>

      <input type="email" placeholder="E-mail" v-model="usuario.email">
      <input type="password" placeholder="Senha" v-model="usuario.password">
      <button type="button" class="btn" @click="login()">Entrar</button>
      <router-link to="/cadastro" class="btn orange">Cadastre-se</router-link>
    </span>

  </LoginTamplate>
</template>

<script>
import LoginTamplate from '@/tamplates/LoginTemplate'
import axios from 'axios'
export default {
  name: 'Login',
  components:{
   LoginTamplate
  },
  data () {
    return {
      usuario: {
        email: "",
        password: "",
      }
    }
  },
  methods: {
    login() {
      axios.post('http://127.0.0.1:8000/api/login', {
        email: this.usuario.email,
        password: this.usuario.password,
      }).then((response) => {
        if(response.data.token){
          alert("Login realizado com sucesso!");
        } else if(response.data.status) {
          alert("Login inválido!");
        } else {
          let errors = "";
          for (let error of Object.values(response.data)){
            errors += error + " ";
          }
          alert(errors);
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
