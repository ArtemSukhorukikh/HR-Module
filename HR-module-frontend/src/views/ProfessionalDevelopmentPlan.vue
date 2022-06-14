<template>
  <FullNavbar/>

  <div v-if="userHR" >
    <label class="form-label mt-3">Отдел</label>
    <select class="form-select form-select-sm mt-3 mx-auto w-auto mb-4" aria-label=".form-select-sm example" v-model="department_id" @change="checkPlan()">
      <option disabled="disabled">Сделайте выбор</option>
      <option v-for="item in departments" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
    </select>
  </div>

  <table class="table table-responsive table-striped w-75 mx-auto table-bordered mt-3">
    <thead class="thead-light">
    <tr>
      <th scope="col" class="w-25" >Сотрудник</th>
      <th scope="col" class="w-25" >Должность</th>
      <th scope="col" class="w-25" >Дата проведения</th>
      <th scope="col" class="w-25" >Образовательный ресурс</th>
      <th scope="col" class="w-25" >Способ прохождения</th>
      <th scope="col" class="w-25" >Уровень компетенции</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="item in developmentPlan" v-bind:key="item">
      <td>{{item.name}}</td>
      <td>{{item.position}}</td>
      <td>{{getData(item.start_date, item.end_date)}}</td>
      <td>{{item.res_name}}</td>
      <td v-if="item.type === '1'">На рабочем месте</td>
      <td v-if="item.type === '2'">Удалённо</td>
      <td>{{item.comp_name}}</td>
    </tr>
    </tbody>
  </table>
</template>

<script>
import FullNavbar from "@/components/Navbars/FullNavbar";
import axios from "axios";
import moment from "moment";
export default {
  name: "ProfessionalDevelopmentPlan",
  components: {FullNavbar},
  data(){
    return {
      department_id: {},
      departments: {},
      userHR: false,
      "developmentPlan": {}
    };
  },
  beforeCreate() {
    axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
    axios
        .get("http://localhost:84/api/v1/developmentPlan/" + localStorage.getItem('userId'))
        .then(response => {
          this.developmentPlan = response.data.dev_plan
          console.log(response.data)
        });
    axios
        .get("http://localhost:84/api/v1/department/findAll")
        .then(response => {
          this.departments = response.data
          console.log(this.departments)
        });
    let roles = JSON.parse(localStorage.getItem('roles'))
    for (let i in roles){
      if (roles[i] === "ROLE_HR"){
        this.userHR = true
      }
    }
  },
  methods: {
    checkPlan() {
      axios
          .get("http://localhost:84/api/v1/developmentPlan/department/" + this.department_id)
          .then(response => {
            this.users = response.data.users
            this.skillsAssessment = response.data.skill_assessment
            this.competences = response.data.competences
            console.log(this.users)
            console.log(this.skillsAssessment)
          });
    },
    getData(start, end) {
      return moment(start).format("YYYY-MM-DD") + ' ' + moment(end).format("YYYY-MM-DD")
    }
  }
}
</script>

<style scoped>

</style>