<template>
  <div class="container w-100">
    <header class="d-flex justify-content-center py-3">
      <ul class="nav nav-pills">
        <li class="nav-item mx-5"><router-link class="nav-link"  to="/">Профиль</router-link></li>
        <li class="nav-item mx-5"><router-link class="nav-link"  to="/knowledgeBase">База знаний</router-link></li>
        <li class="nav-item mx-5"><router-link class="nav-link"  to="/officemap/floor2">Карта офиса этаж 2</router-link></li>
        <li class="nav-item mx-5"><router-link class="nav-link"  to="/officemap/floor3">Карта офиса этаж 3</router-link></li>
        <button @click="exit">Выйти</button>
      </ul>
    </header>
  </div>
</template>

<script>
export default {
  name: "FullNavbar",
  methods: {
    exit(){
      localStorage.removeItem('token');
      localStorage.removeItem('date');
      location.reload();
    }
  }
}

</script>

<style scoped>
  nav {
    font-style: normal;
    font-weight: 300;
    font-size: 25px;
    line-height: 29px;
  }
  .container {
    border-bottom: 1px solid #000000;
  }
</style>