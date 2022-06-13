<template>
  <FullNavbar></FullNavbar>
  <div class="container-sm">
    <div class="container bg-light">
      <div class="main-body">

        <div class="row pt-4 gutters-sm">
          <div class="col-md-4 mb-3">
            <div class="card">
              <div class="card-body">
                <div class="d-flex flex-column align-items-center text-center">
                  <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-journal-bookmark-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M6 1h6v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8V1z"/>
                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
                  </svg>
                  <div class="mt-3">
                    <h4>{{ name }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card mb-3">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Название проекта</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    {{name}}
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Описание</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    {{description}}
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Статус</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    {{ status}}
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Дата начала</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    {{ created_on}}
                  </div>
                </div>
                <hr>
                <div v-if='closed_on' class="row">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Дата окончания</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    {{ closed_on}}
                  </div>
                  <hr>
                </div>

                <div v-if='team' class="row">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Команда</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    <ul v-for="user in team" v-bind:key="user" class="list-group">
                      <li class="list-group-item">{{user}}</li>
                    </ul>
                  </div>
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
                  <div v-for="task in tasks" v-bind:key = "task" class="card bg-light mx-5 mb-3" style="width: 15rem;">
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
    </div>
  </div>
</template>

<script>
import axios from "axios";
import FullNavbar from "@/components/Navbars/FullNavbar";
export default {
  name: "ProjectView",
  data(){
    return {
      name:"",
      description:"",
      status:"",
      team:[],
      tasks:[],
      created_on:"",
      closed_on:""
    }
  },
  components: {FullNavbar},
  beforeCreate() {
    axios.get(`http://localhost:84/api/v1/project/${this.$route.params.id}`).then(responce => {
      console.log(responce)
      this.name = responce.data.name
      this.team = responce.data.team
      this.description = responce.data.description
      this.tasks = responce.data.tasks
      this.created_on = responce.data.created_on
      this.closed_on = responce.data.closed_on
      if (responce.data.status == 1){
        this.status = "Открыт"
      } else {
        this.status = "Закрыт"
      }
    }).catch(error =>{
      console.log(error)
      if (error.request.status === 404){
        this.$router.go('PageNorFound')
      }
    })
  }
}
</script>

<style scoped>

</style>