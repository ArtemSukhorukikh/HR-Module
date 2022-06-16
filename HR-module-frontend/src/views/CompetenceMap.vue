<template>
  <FullNavbar/>
  <div class="container bg-light min-vh-100 w-75">

    <div v-for="item in competences" v-bind:key="item" class="card m-3 w-75 mx-auto">
      <div class="card-body">
        <a class="h6 link" @click="getDescription(item)"> {{item.name}}</a>
        <div class="progress" >
          <div class="progress-bar" role="progressbar" v-bind:style="{ width: getPersent(item.need_rating) }" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>
    </div>

    <div v-if="descriptions" class="card mb-3 mx-auto w-75">
      <div class="card-body">
        <div class="row">
          <div class="col-sm">
            <p>Ваш рейтинг: {{ rating.toFixed(2) }}</p>
          </div>
          <div class="col-sm">
            <p>Ваш текущий уровень грейда:</p>
            <p>{{ competence_name }}</p>
          </div>
        </div>
      </div>
    </div>

    <div v-if="descriptions" class="card mb-3 mx-auto w-75">
      <div class="card-body">
        <div class="row">
          <div class="col-sm">
            <p>Описание грейда:</p>
            <p> {{ descriptions.description }} </p>
          </div>
          <div class="col-sm">
            <p>Список образовательных ресурсов:</p>
            <p v-for="item in descriptions.educationResources" v-bind:key="item">
              <router-link :to="{  name : 'knowledgeBase', params: { id: item.id   } }" class="link-primary">{{ item.name }}
              </router-link>
            </p>
          </div>
        </div>
      </div>
    </div>

  </div>

</template>

<script>
import FullNavbar from "@/components/Navbars/FullNavbar";
import axios from "axios";
export default {
  name: "CompetenceMap",
  components: {FullNavbar},
  data() {
    return {
      "rating": {},
      "competence_name": "",
      "competences": {},
      "descriptions": {
        "description": "",
        "educationResources": []
      }
    };
  },
  beforeCreate() {
    console.log(localStorage.getItem('id'))
    axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
        axios
            .get("http://localhost:84/api/v1/competence/department/" + localStorage.getItem('id'))
            .then(response => {
              this.competences = response.data.competence_dto_s
              this.rating = response.data.rating
              this.competence_name = response.data.comp_name
              console.log(localStorage.getItem('id'))
            });
    this.descriptions = null
  },
  methods: {
    checkEdRes(){

    },
    getPersent( needRating ) {
      let test = ((this.rating.toFixed(2) * 100) / parseFloat(needRating) ).toFixed(2)
      if (test > 100){
        console.log(100)
        return "100%"
      }
      return test + "%"
    },
    getDescription( item ) {
      this.descriptions.description = item.description
      axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
      axios
          .get("http://localhost:84/api/v1/educationalResources/findCompetence/" + item.id)
          .then(response => {
            this.descriptions.educationResources = response.data.educationResourcesCompetence
            console.log(this.descriptions)
          });
    }
  }
}
</script>

<style scoped>

</style>