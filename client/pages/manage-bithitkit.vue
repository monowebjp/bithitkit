<template>
  <div>
    <div>
      <input type="text" name="title">
    </div>
    <div>
      <textarea v-model="markdown"></textarea>
    </div>
    <div v-html="$md.render(markdown)"></div>
    <div>
      <button>送信</button>
    </div>
  </div>
</template>

<style lang="scss" scoped>
</style>x

<script lang="ts">
export default {
  data() {
    return {
      markdown: ""
    }
  }
}
</script>
