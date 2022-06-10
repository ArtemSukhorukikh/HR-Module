<template>
  <div class="d-flex align-items-center justify-content-center vh-100">
    <div class="text-center">
      <h1 class="display-1 fw-bold">404</h1>
      <p class="fs-3"> <span class="text-danger">Извините!</span> Страница не найдена.</p>
      <p class="lead">
        Страница, которую вы ищите не существует.
      </p>
      <router-link class="btn btn-light" to="/">Вернутся на главную страницу</router-link>
    </div>
  </div>

</template>

<script>
export default {
  name: "PageNotFound"
}
</script>

<style scoped>

</style>