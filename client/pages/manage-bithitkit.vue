<template>
  <div>
    <button @click="login">ログインボタン</button>
  </div>
</template>

<style lang="scss" scoped>
div {
  box-sizing: content-box;
  max-width: convertRem(640);
  padding: 0 convertRem(22);
  height: 100vh;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: center;
}

button {
  display: block;
  width: 100%;
  height: convertRem(80);
  background: $primaryBtnBgColor;
  color: $primaryBtnFontColor;
  border-radius: convertRem(8);
}
</style>

<script lang="ts">
export default {
  methods: {
    login () {
      location.href = 'http://localhost:8088/auth/redirect/'
    }
  }
}
</script>
