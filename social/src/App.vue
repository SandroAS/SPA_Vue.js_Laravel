<template>
  <div>
    <NavBar logo="Social" cor="green darken-1"/>
    <router-view/>
  </div>
</template>

<script>
import NavBar from '@/components/layouts/NavBar'
export default {
  name: 'App',
  components: {
    NavBar
  }
}
</script>

<style>

</style>
