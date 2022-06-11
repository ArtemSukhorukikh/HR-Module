<template>
  <FullNavbar/>
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#FT" type="button" role="tab" aria-controls="FT" aria-selected="true" v-on:click="checkApplicationFT">Прохождение обучения</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#POT" type="button" role="tab" aria-controls="POT" aria-selected="false" v-on:click="checkApplicationPOT">Покупка обучающего ресурса</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#POPT" type="button" role="tab" aria-controls="POPT" aria-selected="false" v-on:click="checkApplicationPOPT">Покупка личного обучающего ресурса</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="FT" role="tabpanel" aria-labelledby="home-tab">

      <p class="text-center h1 fw-bold mb-1 mx-1 mx-md-4 mt-4">Заявление на прохождение обучения</p>

      <div class="container mt-2  ">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" v-on:click="chStatus0">
          <label class="form-check-label" for="flexRadioDefault1">
            В ожидании
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked v-on:click="chStatus1">
          <label class="form-check-label" for="flexRadioDefault2">
            Все
          </label>
        </div>
      </div>

      <section class=" mt-0" style="background-color: white;">
        <div class="container mt-2">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
              <div class="card text-black" style="border-radius: 25px;" v-for="item in applicationFT" v-bind:key="item">
                <div class="card-body p-md-5">
                  <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                      <h5 class="card-title">
                        Обучющий ресурс: {{ item.ed_name }}
                      </h5>
                      <h5 v-if="item.status === 0">
                        Заявка на рассмотрении
                      </h5>
                      <h5 v-if="item.status === 1">
                        Заявка одобрена
                      </h5>
                      <h5 v-if="item.status === 2">
                        Заявка отказана
                      </h5>
                      <div>
                        <h5 >
                          Описание: {{item.note}}
                        </h5>
                        <h5 v-if="item.method_of_passage === 0">
                          Спосок прохождения обучения: На рабочем месте
                        </h5>
                        <h5 v-if="item.method_of_passage === 1">
                          Спосок прохождения обучения: Удаленно
                        </h5>
                        <h5 >
                          Начало обучения: {{this.makeDate(item.start_date)}}
                        </h5>
                        <h5 >
                          Конец обучения: {{this.makeDate(item.end_date)}}
                        </h5>
                      </div>
                      <button class="btn btn-primary" @click="deleteApplicationFT(item.id)">Удалить</button>
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
      <p class="text-center h1 fw-bold mb-1 mx-1 mx-md-4 mt-4">Заявление на покупку личного обучения</p>

      <div class="container mt-2  ">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" v-on:click="chStatus0">
          <label class="form-check-label" for="flexRadioDefault1">
            В ожидании
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked v-on:click="chStatus1">
          <label class="form-check-label" for="flexRadioDefault2">
            Все
          </label>
        </div>
      </div>


      <section class=" mt-0" style="background-color: white;">
        <div class="container mt-2">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
              <div class="card text-black" style="border-radius: 25px;" v-for="item in applicationPOPT" v-bind:key="item">
                <div class="card-body p-md-5">
                  <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                      <h6 class="card-subtitle" v-if="item.status === 0">
                        Ожидание
                      </h6>
                      <h6 class="card-subtitle" v-if="item.status === 1">
                        Одобрено
                      </h6>
                      <h6 class="card-subtitle" v-if="item.status === 2">
                        Отказано
                      </h6>
                      <div class="card-body">
                        {{item.note}}
                      </div>
                      <button class="btn btn-primary" @click="deleteApplicationPOPT(item.id)">Удалить</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

    </div>
    <div class="tab-pane fade" id="POT" role="tabpanel" aria-labelledby="contact-tab">

      <p class="text-center h1 fw-bold mb-1 mx-1 mx-md-4 mt-4">Заявления на покупку обучения</p>
      <div class="container mt-2  ">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" v-on:click="chStatus0">
          <label class="form-check-label" for="flexRadioDefault1">
            В ожидании
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked v-on:click="chStatus1">
          <label class="form-check-label" for="flexRadioDefault2">
            Все
          </label>
        </div>
      </div>


      <section class=" mt-0" style="background-color: white;">
        <div class="container mt-2">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
              <div class="card text-black" style="border-radius: 25px;" v-for="item in applicationPOT" v-bind:key="item">
                <div class="card-body p-md-5">
                  <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                      <h5 v-if="item.status === 0">
                        Ожидание
                      </h5>
                      <h5 v-if="item.status === 1">
                        Одобрено
                      </h5>
                      <h5 v-if="item.status === 2">
                        Отказано
                      </h5>
                      <div>
                        {{item.description}}
                      </div>
                      <div>
                        {{item.note}}
                      </div>
                      <div>
                        {{item.Link}}
                      </div>
                      <button class="btn btn-primary" @click="deleteApplicationPOT(item.id)">Удалить</button>
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


</template>

<script>
import FullNavbar from "@/components/Navbars/FullNavbar";
import axios from "axios";
import moment from "moment";
export default {
  name: "DepartmentApplication",
  components: {FullNavbar},
  data() {
    return {
      "applicationFT": {},
      "applicationPOPT": {},
      "applicationPOT": {},
      "applicationFTtrue": {},
      "applicationFTfalse": {},
      "applicationPOPTtrue": {},
      "applicationPOPTfalse": {},
      "applicationPOTtrue": {},
      "applicationPOTfalse": {}
    };
  },
  beforeCreate() {
    axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
  },
  methods:{
    deleteApplicationFT(id) {
      axios
          .post("http://localhost:84/api/v1/applicationFT/delete/" + id)
          .then(response => {
            console.log(response.data)
          });
      this.checkApplicationFT()
      this.chStatus0()
    },
    deleteApplicationPOPT(id) {
      axios
          .post("http://localhost:84/api/v1/applicationPOPT/remove/" + id)
          .then(response => {
            console.log(response.data)
          });
      this.checkApplicationPOPT()
      this.chStatus0()
    },
    deleteApplicationPOT(id) {
      axios
          .post("http://localhost:84/api/v1/applicationPOT/remove/" + id)
          .then(response => {
            console.log(response.data)
          });
      this.checkApplicationPOT()
      this.chStatus0()
    },
    makeDate(date) {
      return moment(date).format("YYYY-MM-DD")
    },
    chStatus0() {
      this.applicationFT = this.applicationFTfalse
      this.applicationPOPT = this.applicationPOPTfalse
      this.applicationPOT = this.applicationPOTfalse
      console.log(this.applicationFT)
      console.log(this.applicationPOPT)
      console.log(this.applicationPOT)
    },
    chStatus1() {
      this.applicationFT = this.applicationFTtrue
      this.applicationPOPT = this.applicationPOPTtrue
      this.applicationPOT = this.applicationPOTtrue
    },
    checkApplicationFT() {
      axios
          .get("http://localhost:84/api/v1/applicationFT/userFalse/" + localStorage.getItem('userId'))
          .then(response => {
            this.applicationFTfalse = response.data.applicationForTrainingDTO
            console.log(this.applicationFTfalse)
          });
      axios
          .get("http://localhost:84/api/v1/applicationFT/user/" + localStorage.getItem('userId'))
          .then(response => {
            this.applicationFTtrue = response.data.applicationForTrainingDTO
            console.log(this.applicationFTtrue)
          });
    },
    checkApplicationPOPT() {
      axios
          .get("http://localhost:84/api/v1/applicationPOPT/userFalse/" + localStorage.getItem('userId'))
          .then(response => {
            this.applicationPOPTfalse = response.data.applicationPurchaseOfPersonalTrainingDTO
            console.log(this.applicationPOPTfalse)
          });
      axios
          .get("http://localhost:84/api/v1/applicationPOPT/user/" + localStorage.getItem('userId'))
          .then(response => {
            this.applicationPOPTtrue = response.data.applicationPurchaseOfPersonalTrainingDTO
            console.log(this.applicationPOPTtrue)
          });
    },
    checkApplicationPOT() {
      axios
          .get("http://localhost:84/api/v1/applicationPOT/userFalse/" + localStorage.getItem('userId'))
          .then(response => {
            this.applicationPOTfalse = response.data.applicationPurchaseOfTrainingDTO
            console.log(this.applicationPOTfalse)
          });
      axios
          .get("http://localhost:84/api/v1/applicationPOT/user/" + localStorage.getItem('userId'))
          .then(response => {
            this.applicationPOTtrue = response.data.applicationPurchaseOfTrainingDTO
            console.log(this.applicationPOTtrue)
          });
    }
  }
}
</script>

<style scoped>

</style>