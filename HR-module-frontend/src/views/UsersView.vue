<template>
  <FullNavbar></FullNavbar>
  <div class="container-sm">
    <table class="mt-5 table">
      <thead class="thead-light table-primary">
      <tr>
        <th scope="col"></th>
        <th scope="col">Имя пользователя</th>
        <th scope="col">ФИО сотрудника</th>
        <th scope="col">Должность</th>
        <th scope="col">Дата начала работы</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <th scope="row">1</th>
        <td>Mark</td>
        <td>Otto</td>
        <td>@mdo</td>
      </tr>
      <tr>
        <th scope="row">2</th>
        <td>Jacob</td>
        <td>Thornton</td>
        <td>@fat</td>
      </tr>
      <tr>
        <th scope="row">3</th>
        <td>Larry</td>
        <td>the Bird</td>
        <td>@twitter</td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import FullNavbar from "@/components/Navbars/FullNavbar";
import axios from "axios"
export default {
  name: "UsersAllView",
  data() {
    return {
      users:[]
    }
  },
  components: {FullNavbar},
  beforeCreate() {
    axios.get("http://localhost:84/api/v1/users/all").then(responce => {
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