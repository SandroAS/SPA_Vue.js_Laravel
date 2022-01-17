<template>
  <SiteTemplate>

    <span slot="menuesquerdo">
      <img class="responsive-img" src="https://assets.bizcapital.com.br/staging-blog/uploads/20190603184146/Img_Redes_Sociais_para_Neg%C3%B3cios_2-2-585x350.jpg" alt="Capa Login">
    </span>
    <span slot="principal">
      <h2>Perfil</h2>

      <input type="text" placeholder="Nome" v-model="usuario.name">
      <input type="email" placeholder="E-mail" v-model="usuario.email">
        <div class="file-field input-field">
          <div class="btn">
            <span>File</span>
            <input type="file">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text" autocomplete="off">
          </div>
        </div>
      <input type="password" placeholder="Senha" v-model="usuario.password" autocomplete="off">
      <input type="password" placeholder="Confirme sua Senha" v-model="usuario.password_confirmation" autocomplete="new-password">
      <button type="button" class="btn" @click="perfil()">Atualizar</button>

    </span>

  </SiteTemplate>
</template>

<script>
import SiteTemplate from '@/tamplates/SiteTemplate'
import axios from 'axios'
export default {
  name: 'Perfil',
  components:{
   SiteTemplate
  },
  data () {
    return {
      usuarioAuth: false,
      usuario: {
        email: "",
        password: "",
      }
    }
  },
  created(){
    let uauarioAux = sessionStorage.getItem('usuario')
    if(uauarioAux){
      this.usuarioAuth = JSON.parse(uauarioAux);
      this.usuario.name = this.usuarioAuth.name;
      this.usuario.email = this.usuarioAuth.email;
      this.usuario.password = this.usuarioAuth.password;
    }
  },
  methods: {
    perfil() {
      axios.put('http://127.0.0.1:8000/api/perfil', {
        name: this.usuario.name,
        email: this.usuario.email,
        password: this.usuario.password,
        password_confirmation: this.usuario.password_confirmation,
      }, {
        headers: {
          "authorization": "Bearer " + this.usuarioAuth.token
        }
      }).then((response) => {
        console.log(response)
        // if(response.data.token){
        //   console.log(response)
        //   alert("Perfil do usuário atualizado com sucesso!");
        // } else if(response.data.status == false) {
        //   alert("Login não existe!!");
        // } else {
        //   let errors = "";
        //   for (let error of Object.values(response.data)){
        //     errors += error + " ";
        //   }
        //   alert(errors);
        // }
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
