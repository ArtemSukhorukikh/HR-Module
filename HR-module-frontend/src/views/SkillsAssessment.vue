<template>
  <FullNavbar/>
  <section class=" mt-0" style="background-color: white;">
    <div class="container mt-2">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
          <div class="card text-black" style="border-radius: 25px;">
            <div class="card-body p-md-5">
              <div class="row justify-content-center">
                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                  <p class="text-center h1 fw-bold mb-1 mx-1 mx-md-4 mt-4">Оценка компетенции сотрудника</p>

                  <form class="mx-1 mx-md-4">

                    <div class="d-flex flex-row align-items-center mb-2">
                      <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <label class="form-label" for="form3Example3c">Сотрудник</label>
                        <select class="form-control form-control" v-model="user">
                          <option v-for="item in users" v-bind:key="item" v-bind:value="item.id">{{item.lastname + ' ' + item.firstname}}</option>
                        </select>
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-2">
                      <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <label class="form-label" for="form3Example3c">Компетенция</label>
                        <select class="form-control form-control" v-model="skill">
                          <option v-for="item in skills" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
                        </select>
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-2">
                      <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <label class="form-label" for="form3Example3c">Оценка</label>
                        <select class="form-control form-control" v-model="estimation">
                          <option value="0">0</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                        </select>
                      </div>
                    </div>

                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                      <button @click="astimate" type="button" class="btn btn-primary btn-lg">Подтвердить оценку</button>
                    </div>

                  </form>

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
import FullNavbar from "@/components/Navbars/FullNavbar";
import axios from "axios";
export default {
  name: "SkillsAssessment",
  components: {FullNavbar},
  data() {
    return {
      "users": {},
      "skills": {},
      "user": '',
      "skill": '',
      "estimation": ''
    };
  },
  beforeCreate() {
    axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
    axios
        .get("http://localhost:84/api/v1/skills/department/" + localStorage.getItem('userId'))
        .then(response => {
          this.skills = response.data.skills
          console.log(this.skills)
        });
    axios
        .get("http://localhost:84/api/v1/department/users/" + localStorage.getItem('userId'))
        .then(response => {
          this.users = response.data.users
          console.log(this.users)
        });
  },
  methods: {
    astimate(){
      console.log(this.user)
      console.log(this.skill)
      console.log(this.estimation)
      axios
          .post('http://localhost:84/api/v1/skillAssessment/new',{
            user_id: this.user,
            skills_id: this.skill,
            estimation: this.estimation})
          .then(response => {
            console.log(response)
          });
    }
  }
}
</script>

<style scoped>

</style>