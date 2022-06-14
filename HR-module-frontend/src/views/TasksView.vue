<template>
  <FullNavbar></FullNavbar>
  <div class="container">
    <div class="d-flex flex-row mb-3">
      <div class="form-check form-switch mx-3">
        <input v-model="onlyNew" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
        <label class="form-check-label" for="flexSwitchCheckDefault">Только незавершенные</label>
      </div>
      <div class="form-check form-switch">
        <input v-model="onlyBad" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
        <label class="form-check-label" for="flexSwitchCheckDefault">Задачи, которые не попали в оценку трудозатратности</label>
      </div>
    </div>
    <ul class="list-group">
      <li v-for="task in tasksOut" v-bind:key="task" class="list-group-item">
        <div class="card">
          <div class="card-header">
            {{ task.status }}
          </div>
          <div class="card-body">
            <h5 class="card-title">{{ task.name }}</h5>
            <p class="card-text">{{ task.description }}</p>
            <ul class="list-group">
              <li class="list-group-item">Начата:{{ task.start_date }}</li>
              <li v-if="task.updated_on" class="list-group-item">Обновлена: {{ task.updated_on }}</li>
              <li v-if="task.closed_on" class="list-group-item">Дата закрытия задачи: {{ task.closed_on }}</li>
            </ul>
            <ul class="list-group">
              <li class="list-group-item">Трудозатраты:{{ task.estimated_hours }}</li>
              <li v-if="task.updated_on" class="list-group-item">Итоговые трудозатраты: {{ task.taskHours }}</li>
            </ul>
            <div v-if="!task.evaluation && checkPM && task.closed_on">
              <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Добавить оценку
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" v-model="newEvaluation.description" placeholder="Описание" required>
                        <label for="floatingInput">Описание</label>
                      </div>
                      <div class="form-floating mb-3">
                        <input type="number" max="5" min="0" class="form-control" id="floatingInput" v-model="newEvaluation.value" placeholder="Оценка" required>
                      </div>
                      <div class="row-cols-2 d-flex justify-content-center">
                        <div class="mb-3 ">
                          <button class="btn btn-outline-primary" @click="setEvaluation(task.id)">Сохранить</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div v-if="checkPM && task.evaluation">
              <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" v-bind:data-bs-target="'#collapseOne'+task.evaluation.id" aria-expanded="true" aria-controls="collapseOne">
                      Изменить оценку
                    </button>
                  </h2>
                  <div v-bind:id="'collapseOne'+task.evaluation.id" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" v-model="task.evaluation.description" placeholder="Описание" required>
                        <label for="floatingInput">Описание</label>
                      </div>
                      <div class="form-floating mb-3">
                        <input type="number" max="5" min="0" class="form-control" id="floatingInput" v-model="task.evaluation.value" placeholder="Оценка" required>
                      </div>
                      <div class="row-cols-2 d-flex justify-content-center">
                        <div class="mb-3 ">
                          <button class="btn btn-outline-primary" @click="updateEvaluation(task.evaluation.id, task.evaluation)">Изменить</button>
                        </div>
                      </div>
                      <div class="row-cols-2 d-flex justify-content-center">
                        <div class="mb-3 ">
                          <button class="btn btn-outline-denger" @click="deleteEvaluation(task.evaluation.id)">Удалить</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </li>
    </ul>

  </div>
</template>

<script>
import FullNavbar from "@/components/Navbars/FullNavbar";
import axios from "axios"

export default {
  name: "TasksView",
  data() {
    return {
      onlyNew:false,
      onlyBad:false,
      newEvaluation:{
        description:"",
        date:"",
        value:0
      },
      tasks:[
        {
          id: "",
          name: "",
          description: "",
          status: "",
          start_date: "",
          updated_on: "",
          estimated_hours: 0,
          taskHours: 0,
          evaluation: {
            description:"",
            value:"",
            date:"",
          }
        }
      ],
    }
  },
  methods: {
    deleteEvaluation(id) {
      axios.post(`http://localhost:84/api/v1/evaluation/delete/${id}`,{
      }).then(responce =>{
        console.log(responce.data)
        axios.get("http://localhost:84/api/v1/tasks/").then(responce => {
          this.tasks = responce.data
        })
      })
    },
    setEvaluation(id) {
      axios.post(`http://localhost:84/api/v1/evaluation/add/${id}`,{
        description: this.newEvaluation.description,
        date: new Date(),
        value: this.newEvaluation.value
      }).then(responce =>{
        console.log(responce.data)
        axios.get("http://localhost:84/api/v1/tasks/").then(responce => {
          this.tasks = responce.data
        })
      })
    },
    updateEvaluation(id, evaluation) {
      axios.post(`http://localhost:84/api/v1/evaluation/update/${id}`,{
        description: evaluation.description,
        date: new Date(),
        value: evaluation.value
      }).then(responce =>{
        console.log(responce.data)
        axios.get("http://localhost:84/api/v1/tasks/").then(responce => {
          this.tasks = responce.data
        })
      })

    }
  },
  computed:{
    checkPM() {
      let roles = JSON.parse(localStorage.getItem('roles'))
      console.log(roles)
      for (let i in roles){

        if (roles[i] === "ROLE_PM"){
          console.log('find')
          return true
        }
      }
      return false
    },
    tasksOut: function (){
      let arr = []
      if (this.onlyBad === true) {
        this.tasks.forEach(el =>{
          if (this.onlyNew === true) {
            if (el.estimated_hours < el.taskHours && el.status === "Новая") {
              arr.push(el)
            }
          } else {
            if (el.estimated_hours < el.taskHours) {
              arr.push(el)
            }
          }
        })
      } else {
        this.tasks.forEach(el =>{
          if (this.onlyNew === true) {
            if (el.status === "Новая") {
              arr.push(el)
            }
          } else {
            arr.push(el)
          }
        })
      }
      return arr
    }
  },
  components: {FullNavbar},
  beforeCreate() {
    axios.get("http://localhost:84/api/v1/tasks/").then(responce => {
      this.tasks = responce.data
    }).catch(error => {
      console.log(error)
    })
  }
}
</script>

<style scoped>

</style>