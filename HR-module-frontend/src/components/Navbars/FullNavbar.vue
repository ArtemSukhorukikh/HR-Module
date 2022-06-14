<template>
  <div class="px-2 w-100">
    <header class="d-flex justify-content-center py-3">
      <ul class="nav nav-pills">
        <li class="nav-item mx-auto"><router-link class="nav-link"  to="/">Профиль</router-link></li>
        <li class="nav-item mx-auto"><router-link class="nav-link"  :to="{  name : 'knowledgeBase', params: { id: 'null' } }">База знаний</router-link></li>
        <select class="form-select w-auto mx-auto" aria-label="Пример выбора по умолчанию" @change="getRoute()" v-model="id">
          <option selected disabled>Карты</option>
          <option value="/officemap/floor2"><li class="nav-item mx-5">Карта офиса этаж 2</li></option>
          <option value="/officemap/floor3"><li class="nav-item mx-5">Карта офиса этаж 3</li></option>
        </select>
        <div v-if="userHR === false || !userMain === false">
          <select  class="form-select w-auto mx-auto" aria-label="Пример выбора по умолчанию" @change="getRoute()" v-model="id">
            <option selected disabled>Заявки</option>
            <option value="/UserAFT"><li class="nav-item mx-5">Список заявок</li></option>
            <option value="/CreateAFT"><li class="nav-item mx-5">Создание заявок</li></option>
          </select>
        </div>
        <li v-if="!userMain" class="nav-item mx-auto"><router-link class="nav-link"  to="/officemap/floor3">Карта компетенций</router-link></li>
        <li v-if="userHR" class="nav-item mx-auto"><router-link class="nav-link"  to="/users-all">Информация о пользователях</router-link></li>
        <li v-if="userHR || userMain" class="nav-item mx-auto"><router-link class="nav-link"  to="/compMatr">Матрица компетенций</router-link></li>
        <li v-if="userHR || userMain" class="nav-item mx-auto"><router-link class="nav-link"  to="/DevPlan">План прохождения обучения</router-link></li>
        <li v-if="userHR" class="nav-item mx-auto"><router-link class="nav-link"  to="/users-all">Отделы</router-link></li>
        <li v-if="userMain" class="nav-item mx-auto"><router-link class="nav-link"  to="/DepAFT">Заявки</router-link></li>
        <li class="nav-item mx-auto"><router-link class="nav-link"  to="/logout">Выход</router-link></li>
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
      userMain: true,
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
  created() {
    let roles = JSON.parse(localStorage.getItem('roles'))
    for (let i in roles){
      if (roles[i] === "ROLE_HR"){
        this.userHR = true
      }
      if (roles[i] === "ROLE_MAIN"){
        this.userMain = true
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