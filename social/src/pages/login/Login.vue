<template>
  <LoginTamplate>

    <span slot="menuesquerdo">
      <img class="responsive-img" src="https://assets.bizcapital.com.br/staging-blog/uploads/20190603184146/Img_Redes_Sociais_para_Neg%C3%B3cios_2-2-585x350.jpg" alt="Capa Login">
    </span>
    <span slot="principal">
      <h2>Login</h2>

      <input type="email" placeholder="E-mail" v-model="usuario.email" autocomplete="off">
      <input type="password" placeholder="Senha" v-model="usuario.password" autocomplete="off">
      <button type="button" class="btn" @click="login()">Entrar</button>
      <router-link to="/cadastro" class="btn orange">Cadastre-se</router-link>
    </span>

  </LoginTamplate>
</template>

<script>
import LoginTamplate from '@/tamplates/LoginTemplate'

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
      this.$http.post(this.$urlAPI + `login`, {
        email: this.usuario.email,
        password: this.usuario.password,
      }).then((response) => {
        if(response.data.status){
          this.$store.commit('setUsuario', response.data.usuario);
          sessionStorage.setItem('usuario', JSON.stringify(response.data.usuario))
          this.$router.push('/')
        } else if(response.data.status == false && response.data.validacao) {
          alert("Login não existe!!");
        } else {
          let errors = "";
          for (let error of Object.values(response.data.erros)){
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
