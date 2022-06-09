<template>
  <LoginNavbar/>
  <section class=" mt-0" style="background-color: white;">
    <div class="container mt-2">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
          <div class="card text-black" style="border-radius: 25px;">
            <div class="card-body p-md-5">
              <div class="row justify-content-center">
                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                  <p class="text-center h1 fw-bold mb-1 mx-1 mx-md-4 mt-4">Регистрация</p>

                  <form class="mx-1 mx-md-4">

                    <div class="d-flex flex-row align-items-center mb-2">
                      <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <label class="form-label" for="form3Example1c">Имя пользователя в системе RedMine</label>
                        <input type="text" id="form3Example1c" v-model="username" class="form-control" />

                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-2">
                      <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <label class="form-label" for="form3Example4c">Пароль</label>
                        <input type="password" id="form3Example4c" v-model="password" class="form-control" />
                      </div>

                    </div>
                    <div class="d-flex flex-row align-items-center mb-2">
                      <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <label class="form-label" for="form3Example3c">Имя</label>
                        <input type="text" id="form3Example3c" v-model="firstname" class="form-control" />
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-2">
                      <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <label class="form-label" for="form3Example3c">Фамилия</label>
                        <input type="text" id="form3Example3c" v-model="lastname" class="form-control" />
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-2">
                      <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <label class="form-label" for="form3Example3c">Отчество</label>
                        <input type="text" id="form3Example3c" v-model="patronymic" class="form-control" />
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-2">
                      <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <label class="form-label" for="form3Example3c">Должность</label>
                        <input type="text" id="form3Example3c" v-model="position" class="form-control" />
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-2">
                      <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <label class="form-label" for="form3Example3c">Дата приема на работу</label>
                        <input type="date" id="form3Example3c" v-model="dateofhiring" class="form-control" />
                      </div>
                    </div>

                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                      <button @click="register" type="button" class="btn btn-primary btn-lg">Регистрация</button>
                    </div>

                  </form>

                </div>
                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                  <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                       class="img-fluid" alt="Sample image">

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import axios from "axios";
import LoginNavbar from "@/components/Navbars/LoginNavbar";
export default {
  name: "RegistrationView",
  components: {LoginNavbar},
  data() {
    return {
      "username": "",
      "password": "",
      "lastname": "",
      "firstname": "",
      "patronymic": "",
      "position": "",
      "dateofhiring": "",
    }
  },
  methods: {
    register() {
      console.log(this.dateofhiring)
      axios.post('http://localhost:84/api/v1/register',{
        username: this.username,
        password: this.password,
        lastname: this.lastname,
        firstname: this.firstname,
        patronymic: this.patronymic,
        position: this.position,
        dateofhiring: this.dateofhiring
      }).then(responce => {
        localStorage.setItem('token', responce.data.token)
        localStorage.setItem('roles', JSON.stringify(responce.data.roles))
        let date;
        date = new Date()
        localStorage.setItem('date', date.toString())
        this.$router.push("/")
      }).catch(errors =>{
        console.log(errors)
      })
    }
  },
}
</script>

<style scoped>

</style>