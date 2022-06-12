<template>
  <FullNavbar/>
  <modal-window-skills-form ref="modal" v-show="isModalVisible" @close="closeModal"></modal-window-skills-form>

  <div>
    <button class="btn btn-outline-primary my-2 m-3" ><router-link to="/compRed"></router-link>Настройка компетенций</button>
    <button class="btn btn-outline-primary my-2 m-3" ><router-link class="link"  to="/skillsRed"></router-link>Настройка навыков</button>
    <button class="btn btn-outline-primary my-2 m-3" @click="openModal">Оценка навыков сотрудника</button>
  </div>

  <table class="table table-responsive table-striped w-75 mx-auto table-bordered">
    <thead class="thead-light">
    <tr>
      <th scope="col" class="w-25" >Навыки</th>
      <th scope="col" v-for="item in users" v-bind:key="item">{{ item.firstname + ' ' + item.lastname }}</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="item in skillsAssessment" v-bind:key="item">
      <th scope="row" class="">{{ item.name }}</th>
      <td v-for="item_ in item.skill_assessments" v-bind:key="item_">{{item_}}</td>
    </tr>
    </tbody>
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
      isModalVisible: false,
      "users": {},
      "skillsAssessment": {},
      "skills": {},
      "users0": {}
    };
  },
  beforeCreate() {
    axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
    axios
        .get("http://localhost:84/api/v1/competenceMatrix/" + localStorage.getItem('userId'))
        .then(response => {
          this.users = response.data.users
          this.skillsAssessment = response.data.skill_assessment
          console.log(this.users)
          console.log(this.skillsAssessment)
        });
    axios
        .get("http://localhost:84/api/v1/skills/department/" + localStorage.getItem('userId'))
        .then(response => {
          this.skills = response.data.skills
          console.log(this.skills)
        });
    axios
        .get("http://localhost:84/api/v1/department/users/" + localStorage.getItem('userId'))
        .then(response => {
          this.users0 = response.data.users
          console.log(this.users)
        });
  },
  methods: {
    openModal() {
      this.isModalVisible = true;
      this.$refs.modal.users = this.users0
      this.$refs.modal.skills = this.skills
      console.log(this.$refs.modal.users)
      console.log(this.$refs.modal.skills)
    },
    closeModal() {
      this.isModalVisible = false;
    },
  }
}
</script>

<style scoped>

</style>