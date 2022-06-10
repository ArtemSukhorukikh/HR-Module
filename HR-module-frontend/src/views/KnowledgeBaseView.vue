<template>
  <FullNavbar/>

  <div class="container">
    <div class="row">
      <div class="col-4">
        <div class="accordion" id="accordionExample">
          <div class="accordion-item" v-for="item in educationResourcesAll" v-bind:key="item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                {{ item.competence }}
              </button>
            </h2>

            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" v-for="item_ in item.educationResourcesCompetence" v-bind:key="item_">
              <div class="accordion-body">
                <button v-on:click="checkFeedback(item_.id)">{{ item_.name }}//</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div v-if="feedbacks">
          <div class="card" v-for="item in feedbacks" v-bind:key="item">
            <h5 class="card-title">
              {{item.userFIO}}
            </h5>
            <h6 class="card-subtitle mb-2 text-muted">
              Оценка: {{item.estimation}} Дата: {{item.date}}
            </h6>
            <div class="card-body">
              {{item.note}}
            </div>
          </div>
        </div>

      </div>
      <div class="col">
        <div>{{educationResources.name}}</div>
        <div>{{educationResources.link}}</div>
        <div>{{educationResources.description}}</div>
        <div>{{educationResources.price}}</div>
        <div>{{educationResources.date}}</div>
        <div>{{educationResources.type}}</div>
        <form class="w-100">
          <h1 class="h1 fw-bold text-black mb-3 ">Отзыв</h1>

          <div class="form-floating">
            <input v-model="feedbackDTO.note" type="text" class="form-control" id="floatingPassword" placeholder="Пароль">
            <label for="floatingPassword">Отзыв</label>
          </div>
          <select class="form-select form-select-sm" aria-label=".form-select-sm example" v-model="feedbackDTO.estimation">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>

          <button @click="sendFeedback" class="w-100 btn btn-lg btn-primary" type="submit">Оставить отзыв</button>
        </form>
      </div>
    </div>






  </div>


</template>

<script>
import FullNavbar from "@/components/Navbars/FullNavbar";
import axios from "axios";
import moment from 'moment'
export default {
  name: "KnowledgeBase",
  components: {FullNavbar},
  data() {
    return {
      "educationResourcesAll": {},
      "feedbacks": {},
      "educationResources": {},
      "feedbackDTO": {
        "id": '',
        "userFIO": '',
        "userId": '',
        "educationalResourcesId": '',
        "estimation": '',
        "note": '',
        "date": ''
      }
    };
  },
  beforeCreate() {
    axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
    axios
        .get("http://localhost:84/api/v1/educationalResources/all",)
        .then(response => {
          this.educationResourcesAll = response.data.educationResourcesAll
          console.log(this.educationResourcesAll)
        });
  },
  methods:{
    checkFeedback(id_) {
      axios
          .get("http://localhost:84/api/v1/feedback/resource/" + id_)
          .then(response => {
            this.feedbacks = response.data.feedbackDTO
            console.log(this.feedbacks)
          });
      axios
          .get("http://localhost:84/api/v1/educationalResources/" + id_)
          .then(response => {
            this.educationResources = response.data
            console.log(this.educationResources)
          });
    },
    sendFeedback() {
      let date;
      date = new Date()
      this.feedbackDTO.date = moment(date).format("YYYY-MM-DD")
      this.feedbackDTO.userId =  localStorage.getItem('userId')
      this.feedbackDTO.educationalResourcesId = this.educationResources.id
      console.log(this.feedbackDTO)
      axios
          .post('http://localhost:84/api/v1/feedback/new',{
            id: "",
            userFIO: "",
            user_id: this.feedbackDTO.userId,
            educational_resources_id: this.feedbackDTO.educationalResourcesId,
            estimation: this.feedbackDTO.estimation,
            note: this.feedbackDTO.note,
            date: this.feedbackDTO.date})
          .then(response => {
            console.log(response)
          });
    }
  }
}
</script>

<style scoped>

</style>