<template>
  <FullNavbar></FullNavbar>
  <div class="container">
    <div class="accordion" id="accordionExample">
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" v-bind:data-bs-target="'#collapseOne'" aria-expanded="true" aria-controls="collapseOne">
            Создать уведомление
          </button>
        </h2>
        <div v-bind:id="'collapseOne'" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="floatingInput" v-model="text" placeholder="Текст" required>
              <label for="floatingInput">Текст уведомления</label>
            </div>
            <div class="form-floating mb-3">
              <input type="datetime-local" class="form-control" id="floatingInput" v-model="date" placeholder="Время до какого действительно" required>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" v-model="type" value="All">
              <label class="form-check-label" for="inlineRadio1">Для всех</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" v-model="type" value="Department">
              <label class="form-check-label" for="inlineRadio2">Для определенного отдела</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" v-model="type" value="User">
              <label class="form-check-label" for="inlineRadio3">Для конкретного пользователя</label>
            </div>
            <div v-if="type === 'Department' || type ==='User'" class="form-check form-check-inline">
              <input type="text" class="form-control" id="floatingInput" v-model="toSend" placeholder="Поле поиска">
            </div>
            <div class="row-cols-2 d-flex justify-content-center">
              <div class="mb-3 ">
                <button class="btn btn-outline-primary" @click="add()">Создать</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-5">
      <div v-for="notification in notifications" v-bind:key="notification" class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ notification.date }}</h5>
            <p class="card-text">{{ notification.text }}</p>
            <button @click="del(notification.id)" class="btn btn-danger">Удалить</button>
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
  name: "NotificationsViews",
  data(){
    return {
      text:"",
      date:"",
      type:"",
      toSend:"",
      notifications:[],
    }
  },
  methods: {
    add(){
      if (this.type === "All") {
        let data = {
          text: this.text,
          date: new Date(),
          type: "All",

        }
        axios.post("http://194.67.93.27:84/api/v1/notification/new", data).then(responce => {
          console.log(responce)
          setTimeout(function (){console.log(responce)},2000)
          axios.get("http://194.67.93.27:84/api/v1/notification/all").then(responce => {
            this.notifications = responce.data
          })
        })
      }
      if ( this.type === "Department") {
        let data = {
          text: this.text,
          date: new Date(),
          type: "Department",
          department: this.toSend,
        }
        axios.post("http://194.67.93.27:84/api/v1/notification/new", data).then(responce => {
          console.log(responce)
          setTimeout(function (){console.log(responce)},2000)
          axios.get("http://194.67.93.27:84/api/v1/notification/all").then(responce => {
            this.notifications = responce.data
          })
        })
      }
      if ( this.type === "User") {
        let data = {
          text: this.text,
          date: new Date(),
          type: "User",
          username: this.toSend,
        }
        axios.post("http://194.67.93.27:84/api/v1/notification/new", data).then(responce => {

          setTimeout(function (){console.log(responce)},2000)
          axios.get("http://194.67.93.27:84/api/v1/notification/all").then(responce => {
            this.notifications = responce.data
          })
        })

      }

    },
    del (id){
      axios.post(`http://194.67.93.27:84/api/v1/notification/delete/${id}`,{})
      axios.get("http://194.67.93.27:84/api/v1/notification/all").then(responce => {
        this.notifications = responce.data
      })
    }
  },
  components: {FullNavbar},
  beforeCreate() {
    axios.get("http://194.67.93.27:84/api/v1/notification/all").then(responce => {
      this.notifications = responce.data
    })
  }
}
</script>

<style scoped>

</style>