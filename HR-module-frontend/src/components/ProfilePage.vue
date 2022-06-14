<template>
  <div id="liveAlertPlaceholder"></div>
  <modal-window-user-form ref="modal" v-show="isModalVisible" @close="closeModal"></modal-window-user-form>
  <modal-window-contact-form ref="contact" v-show="isModalContactVisible" @close="closeContactModal()" ></modal-window-contact-form>
  <div v-if="noError" class="container bg-light">
    <div class="main-body">

      <div class="row gutters-sm">
        <div class="col-md-4 mb-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex flex-column align-items-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                </svg>
                <div class="mt-3">
                  <h4>{{ nameFirstAndLast() }}</h4>
                  <p class="text-secondary mb-1">{{ this.userData.userInfo['position'] }}</p>
                  <p class="text-secondary mb-1">{{ this.userData.userInfo['grade'] }}</p>
                </div>
              </div>
            </div>
          </div>
          <div class="card mt-3">
            <div class="row-cols-2 d-flex justify-content-around">
              <p>Контакты</p>
              <svg v-if="checkHR" @click='openModalContact("new", {})' xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mt-1 bi bi-plus-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
              </svg>
            </div>
            <ul class="list-group list-group-flush">
              <li v-for="contact in userData.contacts" v-bind:key = "contact" class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                <h6 class="mb-0">{{contact['sourse']}}</h6>
                <span class="text-secondary">{{contact['link']}}</span>
                <svg v-if="currentUser || checkHR" @click='openModalContact("update", contact)' xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                </svg>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card mb-3">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Полное имя</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  {{fullName()}}
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Должность</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  {{userData.userInfo['position']}}
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Имя пользователя</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  {{ userData.username}}
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Отдел</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  {{ userData.department}}
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Дата найма</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  {{ userData.userInfo.dateofhiring}}
                </div>
              </div>
                <div v-if="currentUser || checkHR" class="col-sm-12">
                  <button @click="openModal()" class="btn btn-outline-primary my-2 " >Редактировать</button>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
    <div class="row w-100">
      <p>
        <button class="btn btn-primary w-25" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
          Показать достижения
        </button>
      </p>
      <div class="collapse " id="collapseExample">
        <div class="card card-body row d-flex justify-content-evenly">
          <div v-for="achivment in userData.achivments" v-bind:key="achivment" class="card mb-3">
            <div class="card-body">
              <h5 class="card-title">{{achivment.name}}</h5>
              <p class="card-text"> {{achivment.description}}</p>
              <div v-if="checkHR">
                <div class="accordion" id="accordionExample">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" v-bind:data-bs-target="'#collapseOne'+achivment.id" aria-expanded="true" aria-controls="collapseOne">
                        Изменить
                      </button>
                    </h2>
                    <div v-bind:id="'collapseOne'+achivment.id" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                      <div class="accordion-body">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" id="floatingInput" v-model="achivment.name" placeholder="Название" required>
                          <label for="floatingInput">Название достижения</label>
                        </div>
                        <div class="form-floating mb-3">
                          <textarea type="text" class="form-control" id="floatingInput" v-model="achivment.description" placeholder="Описание" required></textarea>
                          <label for="floatingInput">Описание</label>
                        </div>
                        <div class="form-floating mb-3">
                          <input type="number" class="form-control" id="floatingInput" v-model="achivment.value" placeholder="Вес" required/>
                          <label for="floatingInput">Вес достижения</label>
                        </div>
                        <div class="row-cols-2 d-flex justify-content-center">
                          <div class="mb-3 ">
                            <button class="btn btn-outline-primary" @click="updateAchivment(achivment.id, achivment.name, achivment.description, achivment.value)">Изменить</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <button @click="deleteAchivmebt(achivment.id,userData.username)" v-if="checkHR" type="button" class="btn btn-outline-danger my-3">Удалить</button>
            </div>
          </div>
          <div v-if="checkHR">
            <div class="accordion" id="accordionExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Добавить новое достижение
                  </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="floatingInput" v-model="achivment.name" placeholder="Название" required>
                      <label for="floatingInput">Название достижения</label>
                    </div>
                    <div class="form-floating mb-3">
                      <textarea type="text" class="form-control" id="floatingInput" v-model="achivment.description" placeholder="Описание" required></textarea>
                      <label for="floatingInput">Описание</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="number" class="form-control" id="floatingInput" v-model="achivment.value" placeholder="Вес" required/>
                      <label for="floatingInput">Вес достижения</label>
                    </div>
                    <div class="row-cols-2 d-flex justify-content-center">
                      <div class="mb-3 ">
                        <button class="btn btn-outline-primary" @click="addAchivment(userData.username)">Сохранить</button>
                      </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
          </div>
          </div>
      </div>
    </div>
    <div v-if="checkHR || this.currentUser" class="row w-100">
              <p>
                <button class="btn btn-primary w-25" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNotification" aria-expanded="false" aria-controls="collapseExample">
                  Показать уведомления
                </button>
              </p>
              <div class="collapse " id="collapseNotification">
                <div class="card card-body row d-flex justify-content-evenly">
                  <div v-for="notification in userData.notifications" v-bind:key="notification" class="card mb-3">
                    <div class="card-body">
                      <h5 class="card-title">{{notification.text}}</h5>
                      <p class="card-text"> {{notification.date}}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
    <div class=" w-100">
      <h4>Проекты</h4>
      <div v-if="userData.projects.length > 0" class="">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex flex-row mb-3row-cols-3">
              <div v-for="project in userData.projects" v-bind:key = "project" class="card mx-3" style="width: 15rem;">
                <div  class="card-body bg-light">
                  <h5 class="card-title">{{project['name']}}</h5>
                  <p class="card-text">{{project['description']}}</p>
                  <p class="card-text"><small class="text-muted">{{project['created_on']}}</small></p>
                  <router-link class="nav-link" :to="{  name : 'project', params: { id: project.id   } }">Перейти</router-link>
                </div>
              </div>
            </div>
          </div>
      </div>
      </div>
      <div v-else>
        <h5>Нет проектов</h5>
      </div>
    </div>
      <div class="row w-100">
        <h4>Задачи</h4>
          <div v-if="userData.tasks.length > 0">
            <div class="col mb-3">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row col-auto">
                    <div v-for="task in userData.tasks" v-bind:key = "task" class="card bg-light mx-5" style="width: 15rem;">
                      <div class="card-body ">
                        <div class="card-header">{{task['status']}}</div>
                        <h5 class="card-title">{{task['name']}}</h5>
                        <p class="card-text">{{task['description']}}</p>
                        <p class="card-text">Дата создания:{{task['start_date']}}</p>
                        <p class="card-text">Дата обновления:{{task['updated_on']}}</p>
                        <p v-if="task['closed_on']" class="card-text">Дата закрытия:{{task['closed_on']}}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <div v-else><h5>Нет задач</h5></div>
      </div>
      <div v-if="userData.tasks.length > 0" class="my-3">
        <highcharts :constructor-type="'ganttChart'" :options="chartOptions"></highcharts>
      </div>
  </div>
</template>

<script>
import axios from "axios";
import ModalWindowUserForm from "@/components/modal-windows/modal-window-user-form";
import ModalWindowContactForm from "@/components/modal-windows/modal-window-contact-form";


export default {
  name: "ProfilePage",
  components: {
    ModalWindowContactForm,
    ModalWindowUserForm

  },
  data() {
    return {
      achivment:{
        name:"",
        description:"",
        value:0
      },
      isModalVisible: false,
      isModalContactVisible: false,
      chartOptions: {
        accessibility:{
          enabled: false
        },
        title: {
          text: 'Задачи пользователя'
        },

        xAxis: {
          minPadding: 0.05,
          maxPadding: 0.05
        },

        yAxis: {
          categories: []
        },

        series:
          // name: 'Project 1',
          // data: [{
          //   start: Date.UTC(2022, 6, 1),
          //   end: Date.UTC(2022, 6, 12),
          //   y: 0,
          // }, {
          //   start: Date.UTC(2022, 11, 2),
          //   end: Date.UTC(2022, 11, 5),
          //   y: 1,
          //
          // }, {
          //   start: Date.UTC(2022, 11, 8),
          //   end: Date.UTC(2022, 11, 9),
          //   y: 2,
          // }, {
          //   start: Date.UTC(2022, 11, 9),
          //   end: Date.UTC(2022, 11, 19),
          //   y: 1,
          // }, {
          //   start: Date.UTC(2022, 11, 10),
          //   end: Date.UTC(2022, 11, 23),
          //   y: 2,


          // }],

        [],
      },
      "noError":false,
      userData: {
        userid: "",
        username: "",
        roles:[],
        userInfo:{
          'dateofhiring':'',
          'firstname':'',
          'lastname':'',
          'patronymic':'',
          'position':''
        },
        contacts:{

        },
        projects: {

        },
        tasks: {

        },
        department:"",
        achivments:[]
      },
    }
  },
  computed: {
    checkHR() {
      let roles = JSON.parse(localStorage.getItem('roles'))
      console.log(roles)
      for (let i in roles){

        if (roles[i] === "ROLE_HR"){
          console.log('find')
          return true
        }
      }
      return false
    },
    checkPM() {
      let roles = JSON.parse(localStorage.getItem('roles'))
      console.log(roles)
      for (let i in roles){

        if (roles[i] === "ROLE_HR"){
          console.log('find')
          return true
        }
      }
      return false
    },
  },
  props: {
    "currentUser": {
      require: true,
    },
    'userName':{
      type: String,
      require: false
    }
  },
  methods: {
    updateAchivment(id, name, description, value) {
      axios.post(`http://localhost:84/api/v1/achievements/update/${id}`,{name:name,description:description,value:value}).then(this.update())
    },
    addAchivment(username){
      axios.post("http://localhost:84/api/v1/achievements/new",{
        name:this.achivment.name,
        description:this.achivment.description,
        value:this.achivment.value
      }).then(response => {
        axios.post("http://localhost:84/api/v1/achievements/add",{
          id:response.data,
          username:username,
        }).then(this.update())
      })
    },
    deleteAchivmebt(id,username) {
      axios.post("http://localhost:84/api/v1/achievements/unset",{
        id:id,
        username:username
      }).then(this.update())
    },
    nameFirstAndLast(){
      if (this.userData !== null) return this.userData.userInfo['firstname'] + " " + this.userData.userInfo['lastname'];
    },
    fullName(){
      if (this.userData !== null) return  this.userData.userInfo['lastname'] + " " + this.userData.userInfo['firstname'] + " " + this.userData.userInfo['patronymic'] ;
    },
    openModalContact(method, contact) {
      this.isModalContactVisible = true
      this.$refs.contact.method = method
      this.$refs.contact.username = this.userData.username
      if (method === 'update') {
        this.$refs.contact.link = contact.link
        this.$refs.contact.source = contact.sourse
        this.$refs.contact.id = contact.id
      }
    },
    closeContactModal() {
      this.isModalContactVisible = false;
    },
    openModal() {
      this.isModalVisible = true;
      this.$refs.modal.firstname = this.userData.userInfo.firstname
      this.$refs.modal.lastname = this.userData.userInfo.lastname
      this.$refs.modal.patronymic = this.userData.userInfo.patronymic
      this.$refs.modal.position = this.userData.userInfo.position
      this.$refs.modal.dateofhiring = this.userData.userInfo.dateofhiring
      this.$refs.modal.username = this.userData.username
      this.$refs.modal.id = this.userData.id
      this.$refs.modal.department = this.userData.department
    },
    closeModal() {
      this.isModalVisible = false;
    },
    update() {
      if (this.currentUser === false) {
        axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
        axios.post("http://localhost:84/api/v1/users/search", {"username": this.userName}).then(responce => {
          this.userData = responce.data
          this.noError = true

          console.log(this.userData)
        }).catch(error => {
          if (error.request.status === 401) {
            localStorage.removeItem('token')
            localStorage.removeItem('date')
            this.$router.go("/login")
          }
          if (error.request.status === 400 || error.require.status >= 500){
            alert("Пользователь не найден или ошибка доступа к серверу", "danger")
          }
        })
      }
      else {
        axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
        axios.get("http://localhost:84/api/v1/users/current").then( responce => {
          this.userData = responce.data
          localStorage.setItem('roles', JSON.stringify(responce.data['roles']))
          localStorage.setItem('username', responce.data.username)
          localStorage.setItem('id', responce.data.id)
          this.noError = true
          console.log(this.userData)}).catch(error =>{
          if (error.request.status === 401) {
            localStorage.removeItem('token')
            localStorage.removeItem('date')
            this.$router.go("/login")
          }
        })
      }
    }
  },
  beforeCreate() {
    if (this.currentUser === false) {
      axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
      axios.post("http://localhost:84/api/v1/users/search", {"username": this.$route.params.username}).then(responce => {
        this.userData = responce.data
        this.noError = true
        console.log(this.userData)
      }).catch(error => {
        if (error.request.status === 401) {
          localStorage.removeItem('token')
          localStorage.removeItem('date')
          this.$router.go("/login")
        }
        if (error.request.status === 400 || error.require.status >= 500){
          alert("Пользователь не найден или ошибка доступа к серверу", "danger")
        }
      })
    }
    else {
      axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
      axios.get("http://localhost:84/api/v1/users/current").then( responce => {
        this.userData = responce.data
        localStorage.setItem('roles', JSON.stringify(responce.data['roles']))
        localStorage.setItem('username', responce.data.username)
        localStorage.setItem('id', responce.data.id)
        this.noError = true
        console.log(this.userData)}).catch(error =>{
        if (error.request.status === 401) {
          localStorage.removeItem('token')
          localStorage.removeItem('date')
          this.$router.go("/login")
        }
      })
    }

  },
  updated() {
    let count = 0
    this.userData.tasks.forEach(element =>{
      console.log(element.name)
      this.chartOptions.yAxis.categories.push(element.name)
      let startDate = element['start_date'].substr(0,10).split('-')
      let endDate;
      if (element['closed_on']) {
        endDate = element['closed_on'].substr(0,10).split('-')
      } else {
        endDate = element['updated_on'].substr(0,10).split('-')
      }

      console.log(endDate)
      this.chartOptions.series.push({
        name: element['name'],
        data: [{
          start: Date.UTC(startDate[0],startDate[1],startDate[2]),
          end: Date.UTC(endDate[0], endDate[1], endDate[2]),
          y: count
        }]
      })
      count++
    })
  }
}
const alertPlaceholder = document.getElementById('liveAlertPlaceholder')
const alert = (message, type) => {
  const wrapper = document.createElement('div')
  wrapper.innerHTML = [
    `<div class="alert alert-${type} alert-dismissible" role="alert">`,
    `   <div>${message}</div>`,
    '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
    '</div>'
  ].join('')

  alertPlaceholder.append(wrapper)
}
</script>

<style scoped>
body{
  margin-top:20px;
  color: #1a202c;
  text-align: left;
  background-color: #e2e8f0;
}
.main-body {
  padding: 15px;
}
.card {
  box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
}

.card {
  position: relative;
  display: flex;
  flex-direction: column;
  min-width: 0;
  word-wrap: break-word;
  background-color: #fff;
  background-clip: border-box;
  border: 0 solid rgba(0,0,0,.125);
  border-radius: .25rem;
}

.card-body {
  flex: 1 1 auto;
  min-height: 1px;
  padding: 1rem;
}

.gutters-sm {
  margin-right: -8px;
  margin-left: -8px;
}

.gutters-sm>.col, .gutters-sm>[class*=col-] {
  padding-right: 8px;
  padding-left: 8px;
}
.mb-3, .my-3 {
  margin-bottom: 1rem!important;
}

.bg-gray-300 {
  background-color: #e2e8f0;
}
.h-100 {
  height: 100%!important;
}
.shadow-none {
  box-shadow: none!important;
}


</style>