<template>
  <FullNavbar/>
  <modal-window-skills-form ref="modal" v-show="isModalVisible" @close="closeModal"></modal-window-skills-form>

  <div v-if="userMain">
    <router-link to="/compRed" class="btn btn-outline-primary my-2 m-3">Настройка грейдов</router-link>
    <router-link  to="/skillsRed" class="btn btn-outline-primary my-2 m-3">Настройка компетенции</router-link>
    <button class="btn btn-outline-primary my-2 m-3" @click="openModal">Оценка навыков сотрудника</button>
  </div>

  <div v-if="userHR" >
    <label class="form-label mt-3">Отдел</label>
    <select class="form-select form-select-sm mt-3 mx-auto w-auto mb-4" aria-label=".form-select-sm example" v-model="department_id"  @change="checkMatr()">
      <option disabled="disabled">Сделайте выбор</option>
      <option v-for="item in departments" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
    </select>
  </div>

  <table class="table table-responsive table-striped w-75 mx-auto table-bordered">
    <thead class="thead-light">
    <tr>
      <th scope="col" class="w-25" >Компетенции</th>
      <th scope="col" v-for="item in users" v-bind:key="item">{{ item.firstname + ' ' + item.lastname }}</th>
      <th>#</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="item in skillsAssessment" v-bind:key="item">
      <th scope="row" class="">{{ item.name }}</th>
      <td v-for="item_ in item.skill_assessments" v-bind:key="item_">{{item_.toFixed(2)}}</td>
    </tr>
    </tbody>
    <tfoot>
    <th scope="row" class="">Грейд</th>
    <td v-for="item in competences" v-bind:key="item">{{item}}</td>
    </tfoot>
    <tfoot>
    <th scope="row" class="">Рейтинг</th>
    <td v-for="item in users" v-bind:key="item">{{item.rating.toFixed(2)}}</td>
    </tfoot>
  </table>



</template>

<script>
import FullNavbar from "@/components/Navbars/FullNavbar";
import axios from "axios";
import ModalWindowSkillsForm from "@/components/modal-windows/modal-window-skills-form";
export default {
  name: "CompetenceMatrixView",
  components: {ModalWindowSkillsForm, FullNavbar},
  data() {
    return {
      department_id: {},
      departments: {},
      isModalVisible: false,
      userHR: false,
      userMain: true,
      "users": {},
      "skillsAssessment": {},
      "competences": {},
      "skills": {},
      "users0": {},
      "sum": 0
    };
  },
  beforeCreate() {
    axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
    axios
        .get("http://localhost:84/api/v1/competenceMatrix/" + localStorage.getItem('id'))
        .then(response => {
          this.users = response.data.users
          this.skillsAssessment = response.data.skill_assessment
          this.competences = response.data.competences
          console.log(this.users)
          console.log(this.skillsAssessment)
        });
    axios
        .get("http://localhost:84/api/v1/skills/department/" + localStorage.getItem('id'))
        .then(response => {
          this.skills = response.data.skills
          console.log(this.skills)
        });
    axios
        .get("http://localhost:84/api/v1/department/users/" + localStorage.getItem('id'))
        .then(response => {
          this.users0 = response.data.users
          console.log(this.users)
        });
    axios
        .get("http://localhost:84/api/v1/department/findAll")
        .then(response => {
          this.departments = response.data
          console.log(this.departments)
        });
  },
  beforeMount() {
    let roles = JSON.parse(localStorage.getItem('roles'))
    console.log(roles)
    for (let i in roles){
      if (roles[i] === "ROLE_MAIN"){
        this.userMain = true
      }
      if (roles[i] === "ROLE_HR"){
        this.userHR = true
      }
    }
  },
  methods: {
    checkMatr() {
      axios
          .get("http://localhost:84/api/v1/competenceMatrix/department/" + this.department_id)
          .then(response => {
            this.users = response.data.users
            this.skillsAssessment = response.data.skill_assessment
            this.competences = response.data.competences
            console.log(this.users)
            console.log(this.skillsAssessment)
          });
    },
    openModal() {
      this.isModalVisible = true;
      this.$refs.modal.users = this.users0
      this.$refs.modal.skills = this.skills
      console.log(this.$refs.modal.users)
      console.log(this.$refs.modal.skills)
    },
    closeModal() {
      this.isModalVisible = false;
      axios
          .get("http://localhost:84/api/v1/competenceMatrix/" + localStorage.getItem('id'))
          .then(response => {
            this.users = response.data.users
            this.skillsAssessment = response.data.skill_assessment
            this.competences = response.data.competences
            console.log(this.users)
            console.log(this.skillsAssessment)
          });
    },
  }
}
</script>

<style scoped>

</style>