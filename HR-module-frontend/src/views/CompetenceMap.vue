<template>
  <FullNavbar/>
  <div v-for="item in competences" v-bind:key="item">
    <h6 @click="getDescription(item.id)">{{item.name}}</h6>
    <button class="button" type="button" @click="getDescription(item)">
      {{item.name}}
    </button>
    <div class="progress" >
      <div class="progress-bar" role="progressbar" v-bind:style="{ width: getPersent(item.need_rating) }" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
  </div>
  <div v-if="descriptions">
    <div>
      {{ descriptions.description }}
    </div>
    <div v-for="item in descriptions.educationResources" v-bind:key="item">
      {{ item.name }}
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
      "competences": {},
      "descriptions": {
        "description": "",
        "educationResources": []
      }
    };
  },
  beforeCreate() {
    console.log(localStorage.getItem('userId'))
    axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
        axios
            .get("http://localhost:84/api/v1/competence/department/" + localStorage.getItem('userId'))
            .then(response => {
              this.competences = response.data.competence_dto_s
              this.rating = response.data.rating
              console.log(this.competences)
              console.log(this.rating.toFixed(2))
            });
  },
  methods: {
    getPersent( needRating ) {
      console.log(needRating)
      let test = ((this.rating.toFixed(2) * 100) / parseFloat(needRating) ).toFixed(2)
      if (test > 100){
        console.log(100)
        return "100%"
      }
      console.log(test)
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