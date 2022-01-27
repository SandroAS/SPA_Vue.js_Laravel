<template>
  <SiteTemplate>

    <span slot="menuesquerdo">
      <img class="responsive-img" :src="usuario.imagem" alt="Capa Login">
    </span>
    <span slot="principal">
      <h2>Perfil</h2>

      <input type="text" placeholder="Nome" v-model="usuario.name">
      <input type="email" placeholder="E-mail" v-model="usuario.email">
        <div class="file-field input-field">
          <div class="btn">
            <span>Imagem</span>
            <input type="file" @change="salvarImagem">
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

export default {
  name: 'Perfil',
  components:{
   SiteTemplate
  },
  data () {
    return {
      usuarioAuth: false,
      usuario: {
        name: "",
        email: "",
        imagem: "",
        password: "",
      }
    }
  },
  created(){
    if(this.$store.getters.getUsuario){
      this.usuario = JSON.parse(this.$store.getters.getUsuario);
    }
  },
  methods: {
    salvarImagem(evt) {
      let arquivo = evt.target.files || evt.dataTransfer.files;
      if(!arquivo.length){
        return;
      }
      let reader = new FileReader();
      reader.onloadend = (evt) => {
        this.usuario.imagem = evt.target.result;
      };
      reader.readAsDataURL(arquivo[0]);
    },
    perfil() {
      this.$http.put(this.$urlAPI + `perfil`, this.usuario, {
        headers: {
          "Authorization": "Bearer " + this.usuario.token
        }
      }).then((response) => {
        if(response.data.status){
          this.usuario = response.data.usuario;
          sessionStorage.setItem('usuario', JSON.stringify(response.data.usuario))
          alert("Perfil do usuário atualizado com sucesso!");
        } else if(response.data.status == false && response.data.validacao) {
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
