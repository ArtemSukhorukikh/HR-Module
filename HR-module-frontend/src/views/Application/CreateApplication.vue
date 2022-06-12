<template>
  <FullNavbar/>

  <div class="container bg-light">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#FT" type="button" role="tab" aria-controls="FT" aria-selected="true">Прохождение обучения</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#POT" type="button" role="tab" aria-controls="POT" aria-selected="false">Покупка обучающего ресурса</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#POPT" type="button" role="tab" aria-controls="POPT" aria-selected="false">Покупка личного обучающего ресурса</button>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="FT" role="tabpanel" aria-labelledby="home-tab">
        <section class=" mt-0" style="background-color: white;">
          <div class="container mt-2">
            <div class="row d-flex justify-content-center align-items-center h-100 bg-light">
              <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                  <div class="card-body p-md-5">
                    <div class="row justify-content-center">
                      <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                        <p class="text-center h1 fw-bold mb-1 mx-1 mx-md-4 mt-4">Заявление на прохождение обучения</p>

                        <form class="mx-1 mx-md-4">

                          <label class="form-label mt-3">Обучающий ресурс</label>
                          <select class="form-select form-select-sm mt-3" aria-label=".form-select-sm example" v-model="applicationDTO.ed_res_id" >
                            <option disabled="disabled">Сделайте выбор</option>
                            <option v-for="item in educationResourcesAll" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
                          </select>

                          <div class="d-flex flex-row align-items-center mb-2 mt-1">
                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                              <label class="form-label" for="form3Example3c">Дата начала обучения</label>
                              <input type="date" id="form3Example3c" v-model="applicationDTO.start_date" class="form-control" />
                            </div>
                          </div>

                          <div class="d-flex flex-row align-items-center mb-2 mt-1">
                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                              <label class="form-label" for="form3Example3c">Дата окончания обучения</label>
                              <input type="date" id="form3Example3c" v-model="applicationDTO.end_date" class="form-control" />
                            </div>
                          </div>

                          <div class="form-floating mt-3">
                            <input v-model="applicationDTO.note" type="text" class="form-control" id="floatingPassword" placeholder="Примечание">
                            <label for="floatingPassword">Примечание</label>
                          </div>

                          <label class="mt-1">Способ прохождения</label>
                          <select class="form-select form-select-sm" aria-label=".form-select-sm example mt-3" v-model="applicationDTO.method_of_passage">
                            <option value="1">На рабочем месте</option>
                            <option value="2">Удаленно</option>
                          </select>

                          <button @click="sendApplication" class="w-100 btn btn-lg btn-primary mt-3" type="submit">Отправить заявку</button>
                        </form>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <div class="tab-pane fade" id="POPT" role="tabpanel" aria-labelledby="profile-tab">


        <section class=" mt-0" style="background-color: white;">
          <div class="container mt-2">
            <div class="row d-flex justify-content-center align-items-center h-100 bg-light">
              <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                  <div class="card-body p-md-5">
                    <div class="row justify-content-center">
                      <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                        <p class="text-center h1 fw-bold mb-1 mx-1 mx-md-4 mt-4">Заявление на покупку личного обучения</p>

                        <form class="mx-1 mx-md-4">

                          <div class="form-floating mt-3">
                            <input v-model="applicationPOPTDTO.note" type="text" class="form-control" id="floatingPassword" placeholder="Примечание">
                            <label for="floatingPassword">Примечание</label>
                          </div>

                          <div class="form-floating mt-3">
                            <input v-model="applicationPOPTDTO.link" type="text" class="form-control" id="floatingPassword" placeholder="Ссылка">
                            <label for="floatingPassword">Ссылка</label>
                          </div>

                          <button @click="sendApplicationPOPT" class="w-100 btn btn-lg btn-primary mt-3" type="submit">Отправить заявку</button>

                        </form>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <form class="mx-1 mx-md-4">



        </form>
      </div>
      <div class="tab-pane fade" id="POT" role="tabpanel" aria-labelledby="contact-tab">

        <section class=" mt-0" style="background-color: white;">
          <div class="container mt-2">
            <div class="row d-flex justify-content-center align-items-center h-100 bg-light">
              <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                  <div class="card-body p-md-5">
                    <div class="row justify-content-center">
                      <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                        <p class="text-center h1 fw-bold mb-1 mx-1 mx-md-4 mt-4">Заявление на покупку обучения</p>

                        <form class="mx-1 mx-md-4">

                          <div class="form-floating mt-3">
                            <input v-model="applicationPOTDTO.note" type="text" class="form-control" id="floatingPassword" placeholder="Примечание">
                            <label for="floatingPassword">Примечание</label>
                          </div>

                          <div class="form-floating mt-3">
                            <input v-model="applicationPOTDTO.description" type="text" class="form-control" id="floatingPassword" placeholder="Примечание">
                            <label for="floatingPassword">Описание</label>
                          </div>

                          <div class="form-floating mt-3">
                            <input v-model="applicationPOTDTO.link" type="text" class="form-control" id="floatingPassword" placeholder="Ссылка">
                            <label for="floatingPassword">Ссылка</label>
                          </div>

                          <button @click="sendApplicationPOT" class="w-100 btn btn-lg btn-primary mt-3" type="submit">Отправить заявку</button>

                        </form>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

      </div>
    </div>

  </div>

</template>

<script>
import FullNavbar from "@/components/Navbars/FullNavbar";
import axios from "axios";
import moment from "moment";
export default {
  name: "CreateApplication",
  components: {FullNavbar},
  data() {
    return {
      "educationResourcesAll": {},
      "applicationDTO": {
        "id": '',
        "start_date": '',
        "end_date": '',
        "method_of_passage": '',
        "note": '',
        "status": '0',
        "user_id": localStorage.getItem('userId'),
        "ed_res_id": ''
      },
      "applicationPOTDTO": {
        "id": '',
        "user_id": localStorage.getItem('userId'),
        "link": '',
        "note": '',
        "status": '0'
      },
      "applicationPOPTDTO": {
        "id": '',
        "user_id": localStorage.getItem('userId'),
        "description": '',
        "link": '',
        "note": '',
        "status": '0'
      }
    };
  },
  beforeCreate() {
    axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
    axios
        .get("http://localhost:84/api/v1/educationalResources/findAll",)
        .then(response => {
          this.educationResourcesAll = response.data.educationResourcesCompetence
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
    sendApplication() {
      this.applicationDTO.start_date = moment(this.start_date).format("YYYY-MM-DD")
      this.applicationDTO.end_date = moment(this.end_date).format("YYYY-MM-DD")
      this.applicationDTO.user_id =  localStorage.getItem('userId')
      console.log(this.method_of_passage)
      console.log(this.applicationDTO)
      axios
          .post('http://localhost:84/api/v1/applicationFT/new',{
            id: this.applicationDTO.id,
            user_id: this.applicationDTO.user_id,
            ed_res_id: String(this.applicationDTO.ed_res_id),
            start_date: this.applicationDTO.start_date,
            end_date: this.applicationDTO.end_date,
            method_of_passage: this.applicationDTO.method_of_passage,
            note: this.applicationDTO.note,
            status: "0"})
          .then(response => {
            console.log(response)
          });
    },
    sendApplicationPOPT() {
      this.user_id =  localStorage.getItem('userId')
      console.log(this.applicationDTO)
      axios
          .post('http://localhost:84/api/v1/applicationPOPT/new',{
            id: '',
            user_id: localStorage.getItem('userId'),
            link: this.applicationPOPTDTO.link,
            note: this.applicationPOPTDTO.note,
            status: '0'})
          .then(response => {
            console.log(response)
          });
    },
    sendApplicationPOT() {
      this.start_date = moment(this.start_date).format("YYYY-MM-DD")
      this.end_date = moment(this.end_date).format("YYYY-MM-DD")
      this.user_id =  localStorage.getItem('userId')
      console.log(this.applicationDTO)
      axios
          .post('http://localhost:84/api/v1/applicationPOT/new',{
            id: '',
            user_id: localStorage.getItem('userId'),
            description: this.applicationPOTDTO.description,
            link: this.applicationPOTDTO.link,
            note: this.applicationPOTDTO.note,
            status: '0'})
          .then(response => {
            console.log(response)
          });
    }
  }
}
</script>

<style scoped>

</style>