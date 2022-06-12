<template>
  <FullNavbar/>

  <div class="container">
    <div class="row">
      <div class="col-4">
        <div class="accordion" id="accordionExample">
          <div class="accordion-item" v-for="(item, index) in educationResourcesAll" v-bind:key="item">
            <h2 class="accordion-header" v-bind:id="'heading'+index">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" v-bind:data-bs-target="'#collapse'+ index" aria-expanded="false" v-bind:aria-controls="'#collapse'+ index">
                {{ item.competence }}
              </button>
            </h2>

            <div v-bind:id="'collapse'+ index " class="accordion-collapse collapse" v-bind:aria-labelledby="'heading'+ index">
              <div class="accordion-body" v-for="item_ in item.educationResourcesCompetence" v-bind:key="item_">
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
              Оценка: {{item.estimation}}
            </h6>
            <h6 class="card-subtitle mb-2 text-muted">
              Дата: {{getDate(item.date)}}
            </h6>
            <div class="card-body">
              {{item.note}}
            </div>
          </div>
        </div>

      </div>
      <div class="col">
        <h1 class="text-black mb-3 ">{{educationResources.name}}</h1>
        <div class="text-black mb-3 ">Описание: {{educationResources.description}}</div>
        <div class="text-black mb-3 ">Цена ресурса: {{educationResources.price}}</div>
        <div class="text-black mb-3 ">Дата добавления: {{educationResources.date}}</div>
        <div class="text-black mb-3 " v-if="educationResources.type === 0">Тип ресурса: Книга</div>
        <div class="text-black mb-3 " v-if="educationResources.type === 1">Тип ресурса: Онлайн курс</div>
        <div class="text-black mb-3 " v-if="educationResources.type === 2">Тип ресурса: Онлайн тренинг</div>
        <div class="text-black mb-3 ">Ссылка: {{educationResources.link}} </div>
        <form class="w-100">
          <div v-if="userFeedback">
            <h3 class="fw-bold text-black mb-3 ">Ваш отзыв</h3>
            <div class="text-black mb-3 ">{{ userFeedback.note }}</div>
            <div class="text-black mb-3 ">Оценка: {{ userFeedback.estimation }}</div>
            <button @click="deleteFeedback()" class="w-100 btn btn-lg btn-primary" type="submit">Удалить отзыв</button>
          </div>
          <div v-if="!userFeedback">
            <h3 class="h1 fw-bold text-black mb-3 ">Отзыв</h3>
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
          </div>

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
      },
      "userFeedback": {}
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
    deleteFeedback(){
      axios
          .post("http://localhost:84/api/v1/feedback/delete/" + this.userFeedback.id)
          .then(response => {
            console.log(response.data)
          });
      this.userFeedback = null
      console.log(this.educationResources.id)
      this.checkFeedback(this.educationResources.id)
    },
    getDate(date){
      return moment(date).format("YYYY-MM-DD")
    },
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
      console.log(id_, localStorage.getItem('userId'))
      axios
          .get("http://localhost:84/api/v1/feedback/user/" + id_ + "/" + localStorage.getItem('userId'))
          .then(response => {
            this.userFeedback = response.data
            console.log(this.userFeedback)
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
      this.checkFeedback(this.educationResources.id)
    }
  }
}
</script>

<style scoped>

</style>