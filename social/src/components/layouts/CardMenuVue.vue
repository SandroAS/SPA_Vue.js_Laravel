<template>
  <div class="card-panel grey lighten-5 z-depth-1">
    <slot />
  </div>
</template>

<script>
import CardMenuVue from '@/components/layouts/CardMenuVue'
export default {
  name: "CardMenuVue",
  components: {
    CardMenuVue
  },
  props: [],
}
</script>

<style>

</style>