<template>
  <FullNavbar/>
  <div class="container bg-light w-75 min-vh-100">
    <ul class="nav nav-tabs mx-auto" id="myTab" role="tablist">
      <li class="nav-item mx-auto" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#FT" type="button" role="tab" aria-controls="FT" aria-selected="true" v-on:click="checkApplicationFT">Прохождение обучения</button>
      </li>
      <li class="nav-item mx-auto" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#POT" type="button" role="tab" aria-controls="POT" aria-selected="false" v-on:click="checkApplicationPOT">Покупка обучающего ресурса</button>
      </li>
      <li class="nav-item mx-auto" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#POPT" type="button" role="tab" aria-controls="POPT" aria-selected="false" v-on:click="checkApplicationPOPT">Покупка личного обучающего ресурса</button>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="FT" role="tabpanel" aria-labelledby="home-tab">

        <p class="text-center h1 fw-bold mb-1 mx-1 mx-md-4 mt-4">Заявление на прохождение обучения</p>

        <div class="container mt-2" style="max-width: 200px">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" v-on:click="chStatus(0)">
            <label class="form-check-label" for="flexRadioDefault1">
              В ожидании
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked v-on:click="chStatus(1)">
            <label class="form-check-label" for="flexRadioDefault2">
              Приняты
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked v-on:click="chStatus(2)">
            <label class="form-check-label" for="flexRadioDefault2">
              Отказаны
            </label>
          </div>
        </div>

        <section class=" mt-0" style="background-color: white;">
          <div class="container mt-2">
            <div class="row d-flex justify-content-center align-items-center h-100 bg-light">
              <div class="col-lg-12 col-xl-11" v-for="item in applicationFT" v-bind:key="item">
                <div class="card text-black" style="border-radius: 25px;" v-if="item.status === status">
                  <div class="card-body p-md-5" >
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
                        <div v-if="item.status === 0">
                          <button class="btn btn-primary" @click="deleteApplicationFT(item.id)">Удалить</button>
                        </div>

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

        <div class="container mt-2" style="max-width: 200px">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" v-on:click="chStatus(0)">
            <label class="form-check-label" for="flexRadioDefault1">
              В ожидании
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" v-on:click="chStatus(1)">
            <label class="form-check-label" for="flexRadioDefault3">
              Необходимо купить
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked v-on:click="chStatus(2)">
            <label class="form-check-label" for="flexRadioDefault2">
              Купленные
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked v-on:click="chStatus(3)">
            <label class="form-check-label" for="flexRadioDefault2">
              Отказанные
            </label>
          </div>
        </div>


        <section class=" mt-0" style="background-color: white;">
          <div class="container mt-2">
            <div class="row d-flex justify-content-center align-items-center h-100 bg-light">
              <div class="col-lg-12 col-xl-11">
                <div v-for="item in applicationPOPT" v-bind:key="item">
                  <div class="card text-black" style="border-radius: 25px;" v-if="item.status === status" >
                    <div class="card-body p-md-5" >
                      <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                          <h5 v-if="item.status === 0">
                            Ожидание
                          </h5>
                          <h5 v-if="item.status === 1">
                            Принято, необходимо  купить
                          </h5>
                          <h5 v-if="item.status === 2">
                            Купленно
                          </h5>
                          <h5 v-if="item.status === 3">
                            Отказано
                          </h5>
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
          </div>
        </section>

      </div>
      <div class="tab-pane fade" id="POT" role="tabpanel" aria-labelledby="contact-tab">

        <p class="text-center h1 fw-bold mb-1 mx-1 mx-md-4 mt-4">Заявления на покупку обучения</p>

        <div class="container mt-2" style="max-width: 200px">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" v-on:click="chStatus(0)">
            <label class="form-check-label" for="flexRadioDefault1">
              В ожидании
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" v-on:click="chStatus(1)">
            <label class="form-check-label" for="flexRadioDefault3">
              Необходимо купить
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked v-on:click="chStatus(2)">
            <label class="form-check-label" for="flexRadioDefault2">
              Купленные
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked v-on:click="chStatus(3)">
            <label class="form-check-label" for="flexRadioDefault2">
              Отказанные
            </label>
          </div>
        </div>


        <section class=" mt-0" style="background-color: white;">
          <div class="container mt-2">
            <div class="row d-flex justify-content-center align-items-center h-100 bg-light">
              <div class="col-lg-12 col-xl-11" v-for="item in applicationPOT" v-bind:key="item">
                <div class="card text-black" style="border-radius: 25px;" v-if="item.status === status">
                  <div class="card-body p-md-5" >
                    <div class="row justify-content-center">
                      <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                        <h5 v-if="item.status === 0">
                          Ожидание
                        </h5>
                        <h5 v-if="item.status === 1">
                          Принято, необходимо  купить
                        </h5>
                        <h5 v-if="item.status === 2">
                          Купленно
                        </h5>
                        <h5 v-if="item.status === 3">
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
                        <button class="btn btn-primary" @click="deleteApplicationPOT(item.id)" >Удалить</button>
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
  name: "UserApplications",
  components: {FullNavbar},
  data() {
    return {
      "applicationFT": {},
      "applicationPOPT": {},
      "applicationPOT": {},
      "status": ''
    };
  },
  created() {
    axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
    this.checkApplicationFT()
    this.checkApplicationPOPT()
    this.checkApplicationPOT()
  },
  methods:{
    deleteApplicationFT(id) {
      axios
          .post("http://localhost:84/api/v1/applicationFT/delete/" + id)
          .then(response => {
            console.log(response.data)
          });
      this.checkApplicationFT()
    },
    deleteApplicationPOPT(id) {
      axios
          .post("http://localhost:84/api/v1/applicationPOPT/remove/" + id)
          .then(response => {
            console.log(response.data)
          });
      this.checkApplicationPOPT()
    },
    deleteApplicationPOT(id) {
      axios
          .post("http://localhost:84/api/v1/applicationPOT/remove/" + id)
          .then(response => {
            console.log(response.data)
          });
      this.checkApplicationPOT()
    },
    makeDate(date) {
      return moment(date).format("YYYY-MM-DD")
    },
    chStatus(status) {
      this.status = status
      console.log(this.status)
    },
    checkApplicationFT() {
      axios
          .get("http://localhost:84/api/v1/applicationFT/user/" + localStorage.getItem('userId'))
          .then(response => {
            this.applicationFT = response.data.applicationForTrainingDTO
            console.log(this.applicationFT)
          });
    },
    checkApplicationPOPT() {
      axios
          .get("http://localhost:84/api/v1/applicationPOPT/user/" + localStorage.getItem('userId'))
          .then(response => {
            this.applicationPOPT = response.data.applicationPurchaseOfPersonalTrainingDTO
            console.log(this.applicationPOPT)
          });
    },
    checkApplicationPOT() {
      axios
          .get("http://localhost:84/api/v1/applicationPOT/user/" + localStorage.getItem('userId'))
          .then(response => {
            this.applicationPOT = response.data.applicationPurchaseOfTrainingDTO
            console.log(this.applicationPOT)
          });
    }
  }
}
</script>

<style scoped>

</style>