<template>
  <div>
    <div v-if="img" class="card-image">
      <a v-if="link" :href="link" target="_blank">
        <img :src="img">
        <span class="card-title">{{ titulo || ''}}</span>
      </a>
      <span v-if="!link">
        <img :src="img">
        <span class="card-title">{{ titulo || ''}}</span>
      </span>
    </div>
    <div class="card-content">
      <span v-if="!img">
        <span class="card-title">{{ titulo || ''}}</span>
      </span>
      <p>{{txt}}</p>
      <p v-if="link"><a :href="link" target="_blank">{{ 'Confira mais aqui...' }}</a></p>
    </div>
  </div>
</template>

<script>
export default {
  name: "CardDetalheVue",
  props: ['img', 'titulo', 'txt', 'link'],
}
</script>

<style>

</style>