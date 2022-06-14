<template>
  <div class="px-2 w-100">
    <header class="d-flex justify-content-center py-3">
      <ul class="nav nav-pills">
        <li class="nav-item mx-5"><router-link class="nav-link"  to="/">Профиль</router-link></li>
        <li class="nav-item mx-5"><router-link class="nav-link"  :to="{  name : 'knowledgeBase', params: { id: 'null'   } }">База знаний</router-link></li>
        <li class="nav-item mx-5"><router-link class="nav-link"  to="/officemap/floor2">Карта офиса этаж 2</router-link></li>
        <li class="nav-item mx-5"><router-link class="nav-link"  to="/officemap/floor3">Карта офиса этаж 3</router-link></li>
        <li v-if="userHR" class="nav-item mx-5"><router-link class="nav-link"  to="/users-all">Информация о пользователях</router-link></li>
        <li v-if="userPM" class="nav-item mx-5"><router-link class="nav-link"  to="/tasks">Информация о задачах</router-link></li>
        <li v-if="userHR" class="nav-item mx-5"><router-link class="nav-link"  to="/notifications">Уведомления</router-link></li>
        <li class="nav-item mx-5"><router-link class="nav-link"  to="/logout">Выход</router-link></li>
      </ul>
    </header>
  </div>
</template>

<script>
export default {
  name: "FullNavbar",
  data (){
    return {
      userHR: false,
      userPM: false,
    }
  },
  methods: {
    exit(){
      localStorage.removeItem('token');
      localStorage.removeItem('date');
      location.reload();
    }
  },
  mounted() {

    let roles = JSON.parse(localStorage.getItem('roles'))
    for (let i in roles){
      if (roles[i] === "ROLE_HR"){
        this.userHR = true
      }
      if (roles[i] === "ROLE_PM"){
        this.userPM = true
      }
    }

  },
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