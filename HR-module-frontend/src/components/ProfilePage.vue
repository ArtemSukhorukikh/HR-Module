<template>
  <div id="liveAlertPlaceholder"></div>
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
                </div>
              </div>
            </div>
          </div>
          <div class="card mt-3">
            <p>Контакты</p>
            <ul class="list-group list-group-flush">
              <li v-for="contact in userData.contacts" v-bind:key = "contact" class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                <h6 class="mb-0">{{contact['source']}}</h6>
                <span class="text-secondary">{{contact['link']}}</span>
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
                <div class="col-sm-12">
                  <a class="btn btn-info " target="__blank" href="https://www.bootdey.com/snippets/view/profile-edit-data-and-skills">Edit</a>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
    <div class="row w-100">
      <h4>Проекты</h4>
      <div class="col mb-3">
        <div class="card h-100">
          <div class="card-body">
            <div class="row-cols-3">
              <div v-for="project in userData.projects" v-bind:key = "project" class="card" style="width: 15rem;">
                <div  class="card-body bg-light">
                  <h5 class="card-title">{{project['name']}}</h5>
                  <p class="card-text">{{project['description']}}</p>
                  <p class="card-text"><small class="text-muted">{{project['created_on']}}</small></p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row w-100">
        <h4>Задачи</h4>
        <div class="col mb-3">
          <div class="card h-100">
            <div class="card-body">
              <div class="row col-auto">
                <div v-for="task in userData.tasks" v-bind:key = "task" class="card bg-light mx-5" style="width: 15rem;">
                  <div class="card-body ">
                    <div class="card-header">{{task['status']}}</div>
                    <h5 class="card-title">{{task['name']}}</h5>
                    <p class="card-text">{{task['description']}}</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div>
        <highcharts :constructor-type="'ganttChart'" :options="chartOptions"></highcharts>
      </div>
  </div>
  </div>
</template>

<script>
import axios from "axios";


export default {
  name: "ProfilePage",
  components: {

  },
  data() {
    return {
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
      "userData": {
        "username": "",
        "roles":[],
        "userInfo":{
          'dateofhiring':'',
          'firstname':'',
          'lastname':'',
          'patronymic':'',
          'position':''
        },
        "contacts":{

        },
        "projects": {

        },
        "tasks": {

        }
      },
    }
  },
  props: {
    "currentUser": {
      require: true,
    },
    'userName':{
      type: String,
      require: false
    },
  },
  methods: {
    nameFirstAndLast(){
      if (this.userData !== null) return this.userData.userInfo['firstname'] + " " + this.userData.userInfo['lastname'];
    },
    fullName(){
      if (this.userData !== null) return  this.userData.userInfo['lastname'] + " " + this.userData.userInfo['firstname'] + " " + this.userData.userInfo['patronymic'] ;
    }
  },
  beforeCreate() {
    if (this.currentUser === false) {
      axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
      axios.post("http://localhost:84/api/v1/users/search", {"id": this.userName}).then(responce => {
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
        localStorage.setItem('role', JSON.stringify(responce.data['roles']))
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
      let endDate = element['closed_on'].substr(0,10).split('-')
      console.log(startDate)
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