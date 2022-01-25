<template>
  <LoginTamplate>

    <span slot="menuesquerdo">
      <img class="responsive-img" src="https://assets.bizcapital.com.br/staging-blog/uploads/20190603184146/Img_Redes_Sociais_para_Neg%C3%B3cios_2-2-585x350.jpg" alt="Capa Login">
    </span>
    <span slot="principal">
      <h2>Cadastro</h2>

      <input type="text" placeholder="Nome" v-model="usuario.name" autocomplete="off">
      <input type="email" placeholder="E-mail" v-model="usuario.email" autocomplete="off">
      <input type="password" placeholder="Senha" v-model="usuario.password" autocomplete="off">
      <input type="password" placeholder="Confirme sua Senha" v-model="usuario.password_confirmation" autocomplete="off">
      <button type="button" class="btn" @click="cadastro()">Enviar</button>
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
      usuario: {
        name: "",
        email: "",
        password: "",
        password_confirmation: ""
      }
    }
  },
  methods: {
    cadastro() {
      this.$http.post(this.$urlAPI + `cadastro`, {
        name: this.usuario.name,
        email: this.usuario.email,
        password: this.usuario.password,
        password_confirmation: this.usuario.password_confirmation,
      }).then((response) => {
        if(response.data.token){
          alert("Cadastro realizado com sucesso!");
          sessionStorage.setItem('usuario', JSON.stringify(response.data))
          this.$router.push('/')
        } else if(response.data.status == false) {
          alert("Erro no cadastro! Tente novamente mais tarde.");
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
