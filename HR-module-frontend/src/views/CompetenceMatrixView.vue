<template>
  <FullNavbar/>

  <table class="table">
    <thead>
    <tr>
      <th scope="col" >Навыки</th>
      <th scope="col" v-for="item in users" v-bind:key="item">{{ item.firstname + ' ' + item.lastname }}</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="item in skillsAssessment" v-bind:key="item">
      <th scope="row">{{ item.name }}</th>
      <td v-for="item_ in item.skill_assessments" v-bind:key="item_">{{item_}}</td>
    </tr>
    <tr >
      <th scope="row">Рейтинг</th>
      <td v-for="item in users" v-bind:key="item">{{item.rating.toFixed(2)}}</td>
    </tr>
    </tbody>
  </table>
  <router-link class="link"  to="/officemap/floor3">Карта офиса этаж 3</router-link>

</template>

<script>
import FullNavbar from "@/components/Navbars/FullNavbar";
import axios from "axios";
export default {
  name: "CompetenceMatrixView",
  components: {FullNavbar},
  data() {
    return {
      "users": {},
      "skillsAssessment": {}
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
  }
}
</script>

<style scoped>

</style>