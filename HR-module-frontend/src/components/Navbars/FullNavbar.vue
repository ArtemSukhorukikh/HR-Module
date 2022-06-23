<template>
  <div class="px-2 w-100">
    <header class="d-flex justify-content-center py-3">
      <ul class="nav nav-pills">
        <li class="nav-item"><router-link class="nav-link"  to="/">Профиль</router-link></li>
        <li class="nav-item"><router-link class="nav-link"  :to="{  name : 'knowledgeBase', params: { id: 'null' } }">База знаний</router-link></li>
        <li class="nav-item"><router-link class="nav-link"  to="/officemap/floor2">Карта офиса этаж 2</router-link></li>
        <li class="nav-item"><router-link class="nav-link"  to="/officemap/floor3">Карта офиса этаж 3</router-link></li>
        <li v-if="!userMain" class="nav-item "><router-link class="nav-link"  to="/UserAFT">Список заявок</router-link></li>
        <li v-if="!userMain" class="nav-item "><router-link class="nav-link"  to="/CreateAFT">Создание заявок</router-link></li>
        <li v-if="!userMain" class="nav-item "><router-link class="nav-link"  to="/compMap">Карта грейдов</router-link></li>
        <li v-if="userHR" class="nav-item "><router-link class="nav-link"  to="/users-all">Информация о пользователях</router-link></li>
        <li v-if="userHR || userMain" class="nav-item "><router-link class="nav-link"  to="/compMatr">Матрица компетенций</router-link></li>
        <li v-if="userHR || userMain" class="nav-item "><router-link class="nav-link"  to="/DevPlan">План прохождения обучения</router-link></li>
        <li v-if="userHR" class="nav-item "><router-link class="nav-link"  to="/departments">Отделы</router-link></li>
        <li v-if="userMain" class="nav-item "><router-link class="nav-link"  to="/DepAFT">Заявки</router-link></li>
        <li v-if="userPM" class="nav-item "><router-link class="nav-link"  to="/tasks">Информация о задачах</router-link></li>
        <li v-if="userHR" class="nav-item "><router-link class="nav-link"  to="/notifications">Уведомления</router-link></li>
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
      id: {},
      userHR: false,
      userMain: false,
      userPM: false
    }
  },
  methods: {
    getRoute(){
      this.$router.push({path: this.id})
    },
    exit(){
      localStorage.removeItem('token');
      localStorage.removeItem('date');
      location.reload();
    }
  },
  beforeMount() {
    let roles = JSON.parse(localStorage.getItem('roles'))
    for (let i in roles){
      if (roles[i] === "ROLE_HR"){
        this.userHR = true
      }
      if (roles[i] === "ROLE_MAIN"){
        this.userMain = true
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