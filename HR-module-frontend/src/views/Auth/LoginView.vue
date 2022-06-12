<template>
  <LoginNavbar/>
  <main class="position-absolute top-50 start-50 translate-middle">
  <form class="w-100">
    <h1 class="h1 fw-bold text-black mb-3 ">Вход</h1>

    <div class="form-floating">
      <input v-model="username" type="text" class="form-control" id="floatingInput" placeholder="имя пользователя">
      <label for="floatingInput">Имя пользователя</label>
    </div>
    <div class="form-floating">
      <input v-model="password" type="password" class="form-control" id="floatingPassword" placeholder="Пароль">
      <label for="floatingPassword">Пароль</label>
    </div>

    <button @click="login" class="w-100 mt-4 btn btn-lg btn-primary" type="submit">Вход</button>
  </form>
    <div v-if="errorAuth" class="alert alert-danger" role="alert">
      Неправильная пара логин/пароль
    </div>
    <div v-if="errorServer" class="alert alert-danger" role="alert">
      Нет доступа к серверу авторизации, попробуйте позже
    </div>
  </main>
</template>

<script>
import LoginNavbar from "@/components/Navbars/LoginNavbar";
import axios from "axios";
export default {
  name: "LoginView",
  components: {LoginNavbar},
  data() {
    return {
      'errorServer': false,
      'errorAuth': false,
      'username': '',
      'password': '',
    }
  },
  methods: {
    login() {
      axios.post('http://localhost:84/api/v1/auth',{username: this.username, password: this.password}).then(responce => {
        localStorage.setItem('token', responce.data.token)
        let date;
        date = new Date()
        localStorage.setItem('date', date.toString())
        this.$router.go('/')
      }).catch(errors =>{
        if (errors.request.status === 401) {
          this.errorAuth = true
        }
        if (errors.request.status >= 500) {
          this.$router.go(`error/${errors.request.status}`)
        }
      })
    }
  },
}
</script>

<style>
.bd-placeholder-img {
  font-size: 1.125rem;
  text-anchor: middle;
  -webkit-user-select: none;
  -moz-user-select: none;
  user-select: none;
}

@media (min-width: 768px) {
  .bd-placeholder-img-lg {
    font-size: 3.5rem;
  }
}

.b-example-divider {
  height: 3rem;
  background-color: rgba(0, 0, 0, .1);
  border: solid rgba(0, 0, 0, .15);
  border-width: 1px 0;
  box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
}

.b-example-vr {
  flex-shrink: 0;
  width: 1.5rem;
  height: 100vh;
}

.bi {
  vertical-align: -.125em;
  fill: currentColor;
}

.nav-scroller {
  position: relative;
  z-index: 2;
  height: 2.75rem;
  overflow-y: hidden;
}

.nav-scroller .nav {
  display: flex;
  flex-wrap: nowrap;
  padding-bottom: 1rem;
  margin-top: -1px;
  overflow-x: auto;
  text-align: center;
  white-space: nowrap;
  -webkit-overflow-scrolling: touch;
}
</style>