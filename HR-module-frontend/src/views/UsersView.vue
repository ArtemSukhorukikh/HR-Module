<template>
  <FullNavbar></FullNavbar>
  <div id="pageContainer" class="container-sm d-flex justify-content-center w-100">
    <div class="m-5 px-2">
      <label for="exampleFormControlInput1" class="form-label">Норма часов в месяц</label>
      <input type="number" v-model="mounthHours" class="form-control" id="exampleFormControlInput1" placeholder="140">
    </div>
    <table ref="content" class="mt-5 table">
      <thead class="thead-light table-primary">
      <tr>
        <th scope="col">Имя пользователя</th>
        <th scope="col">ФИО сотрудника</th>
        <th scope="col">Должность</th>
        <th scope="col">Дата найма</th>
        <th scope="col">Отдел</th>
        <th scope="col">Часов в месяц</th>
        <th scope="col">Часов в среднем на задачу</th>
        <th scope="col">Средняя оценка</th>
        <th scope="col">Эффектичность</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="user in users" v-bind:key="user">
        <th scope="row"><router-link :to="{  name : 'userPage', params: { username: user.username   } }" class="link-primary">{{ user.username }}</router-link></th>
        <td>{{ user.userInfo.lastname}} {{ user.userInfo.firstname}} {{ user.userInfo.patronymic}}</td>
        <td>{{ user.userInfo.position }}</td>
        <td>{{ user.userInfo.dateofhiring }}</td>
        <td>{{ user.department }}</td>
        <td class="" :class="mounthHours < user.hours ?'table-danger':''" >{{ user.hours }}</td>
        <td>{{ user.speed }}</td>
        <td>{{ user.avgMark }}</td>
        <td>{{ user.effectiveness }}</td>
      </tr>

      </tbody>
    </table>
    <div>

    </div>

  </div>
</template>

<script>

import FullNavbar from "@/components/Navbars/FullNavbar";
import axios from "axios"


export default {
  name: "UsersAllView",
  data() {
    return {
      mounthHours:140,
      users:[]
    }
  },
  components: {FullNavbar},
  beforeCreate() {
    axios.get("http://194.67.93.27:84/api/v1/users/all").then(responce => {
      console.log(responce)

      this.users = responce.data.users
    }).catch(errors =>{
      console.log(errors)
    })
  }
}
</script>

<style scoped>

</style>