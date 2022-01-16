<template>
  <div>
    <div class="card-image">
      <img v-if="img" :src="img">
      <span class="card-title">{{ titulo || ''}}</span>
    </div>
    <div v-if="txt" class="card-content">
      <p>{{txt}}</p>
    </div>
  </div>
</template>

<script>
export default {
  name: "CardDetalheVue",
  props: ['img', 'titulo', 'txt'],
}
</script>

<style>

</style>