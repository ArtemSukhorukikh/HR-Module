<template>
  <FullNavbar></FullNavbar>
  <div class="container">
    <ul class="list-group">
      <li v-for="task in tasks" v-bind:key="task" class="list-group-item">
        <div class="card">
          <div class="card-header">
            {{ task.status }}
          </div>
          <div class="card-body">
            <h5 class="card-title">{{ task.name }}</h5>
            <p class="card-text">{{ task.description }}</p>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">Начата:{{ task.start_date }}</li>
              <li v-if="task.updated_on" class="list-group-item">Обновлена: {{ task.updated_on }}</li>
              <li v-if="task.closed_on" class="list-group-item">Дата закрытия задачи: {{ task.closed_on }}</li>
            </ul>
          </div>
        </div>
      </li>
      <li class="list-group-item">A second item</li>
      <li class="list-group-item">A third item</li>
      <li class="list-group-item">A fourth item</li>
      <li class="list-group-item">And a fifth one</li>
    </ul>
  </div>
</template>

<script>
import FullNavbar from "@/components/Navbars/FullNavbar";
import axios from "axios"
export default {
  name: "TasksView",
  data() {
    return {tasks:[

      ]}
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