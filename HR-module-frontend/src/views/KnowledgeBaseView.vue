<template>
  <FullNavbar/>
  <modal-window-feedback ref="modal" v-show="isModalVisible" @close="closeModal"></modal-window-feedback>

  <div class="container mt-3">
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
                <a class="link-primary" @click="checkFeedback(item_.id)">{{ item_.name }}</a>
              </div>
            </div>
          </div>
        </div>
        <router-link v-if="userMain" class="btn btn-outline-primary my-2 "  to="/settingRes">Настройка базы знаний</router-link>
      </div>
      <div class="col-sm">
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
      <div class="col-sm w-25" >
        <div v-if="educationResources.id">
          <a v-bind:href="'http://'+educationResources.link"><h1 class="text-black mb-3 ">{{educationResources.name}}</h1></a>

          <p class="text-black mb-3 text-left">{{educationResources.description}}</p>
          <div class="text-black mb-3 ">Цена ресурса: {{educationResources.price}} руб.</div>
          <div class="text-black mb-3 " v-if="educationResources.type === 0">Тип ресурса: Книга</div>
          <div class="text-black mb-3 " v-if="educationResources.type === 1">Тип ресурса: Онлайн курс</div>
          <div class="text-black mb-3 " v-if="educationResources.type === 2">Тип ресурса: Онлайн тренинг</div>
          <div class="text-black mb-3 " v-if="educationResources.type === 3">Тип ресурса: Личный ресурс</div>
          <div class="text-black mb-3 " v-if="educationResources.type === 4">Тип ресурса: Онлайн курс компании</div>
          <div class="text-black mb-3 " v-if="educationResources.type === 5">Тип ресурса: Онлайн тренинг компании</div>
          <div v-if="!userFeedback">
            <button @click="openModal()" class="btn btn-outline-primary my-2 " >Оставить отзыв</button>
          </div>
          <div class="card" v-if="userFeedback">
            <div class="card-body">
              <form class="w-100">
                <h5 class="fw-bold text-black mb-3 ">Ваш отзыв</h5>
                <div class="text-black mb-3 ">{{ userFeedback.note }}</div>
                <div class="text-black mb-3 ">Оценка: {{ userFeedback.estimation }}</div>
                <button @click="deleteFeedback(); " class="w-100 btn btn-lg btn-primary" type="submit">Удалить отзыв</button>
              </form>
            </div>
          </div>


        </div>
      </div>
    </div>


  </div>


</template>

<script>
import FullNavbar from "@/components/Navbars/FullNavbar";
import axios from "axios";
import moment from 'moment'
import ModalWindowFeedback from "@/components/modal-windows/modal-window-feedback";
export default {
  name: "KnowledgeBase",
  components: {ModalWindowFeedback, FullNavbar},
  data() {
    return {
      userMain: false,
      isModalVisible: false,
      isFeedback: '',
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
  beforeCreate() {
    axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
    axios
        .get("http://194.67.93.27:84/api/v1/educationalResources/all",)
        .then(response => {
          this.educationResourcesAll = response.data.educationResourcesAll
          console.log(this.educationResourcesAll)
        });
    console.log(this.$route.params)
    let roles = JSON.parse(localStorage.getItem('roles'))
    for (let i in roles){
      if (roles[i] === "ROLE_MAIN"){
        this.userMain = true
      }
    }
  },
  created() {

    if(this.$route.params.id != null){
      console.log(this.$route.params.id)
      this.checkFeedback(this.$route.params.id)
    }
  },
  methods:{
    openModal() {
      this.isModalVisible = true;
      this.$refs.modal.educationResources = this.educationResources.id
    },
    closeModal() {
      this.isModalVisible = false;
      this.checkFeedback(this.educationResources.id)
    },
    deleteFeedback(){
      axios
          .post("http://194.67.93.27:84/api/v1/feedback/delete/" + this.userFeedback.id)
          .then(response => {
            console.log(response.data)
            this.checkFeedback(this.educationResources.id)
          });
    },
    getDate(date){
      return moment(date).format("YYYY-MM-DD")
    },
    checkFeedback(id_) {
      axios
          .get("http://194.67.93.27:84/api/v1/feedback/resource/" + id_)
          .then(response => {
            this.feedbacks = response.data.feedbackDTO
            console.log(this.feedbacks)
          });
      axios
          .get("http://194.67.93.27:84/api/v1/educationalResources/" + id_)
          .then(response => {
            this.educationResources = response.data
            console.log(this.educationResources)
          });
      console.log(id_, localStorage.getItem('id'))
      axios
          .get("http://194.67.93.27:84/api/v1/feedback/user/" + id_ + "/" + localStorage.getItem('id'))
          .then(response => {
            this.userFeedback = response.data
            console.log(this.userFeedback)
          });
    },
    sendFeedback() {
      let date;
      date = new Date()
      this.feedbackDTO.date = moment(date).format("YYYY-MM-DD")
      this.feedbackDTO.userId =  localStorage.getItem('id')
      this.feedbackDTO.educationalResourcesId = this.educationResources.id
      console.log(this.feedbackDTO)
      axios
          .post('http://194.67.93.27:84/api/v1/feedback/new',{
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