<template>
  <FullNavbar/>

  <div class="container bg-light w-75 min-vh-100">

    <ul class="nav nav-tabs mx-auto" id="myTab" role="tablist">
      <li class="nav-item mx-auto" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#new" type="button" role="tab" aria-controls="new" aria-selected="true" >Создать</button>
      </li>
      <li class="nav-item mx-auto" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#change" type="button" role="tab" aria-controls="change" aria-selected="false" @click="checkComps">Изменить</button>
      </li>
      <li class="nav-item mx-auto" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#delete" type="button" role="tab" aria-controls="delete" aria-selected="false" @click="checkComps">Удалить</button>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">

      <div class="tab-pane fade show active" id="new" role="tabpanel" aria-labelledby="home-tab">

        <div class="container" style="max-width: 600px">
          <form class="mx-1 mx-md-4">

            <h1>Создание компетенции для отдела</h1>

            <label class="form-label">Последняя компетенция: {{ competences[0].name }}</label>

            <div class="form-floating mt-3">
              <input v-model="competence.name" type="text" class="form-control" id="name" placeholder="Название">
              <label for="name">Название</label>
            </div>

            <div class="form-floating  mt-3">
              <input v-model="competence.description" type="text" class="form-control" id="description" placeholder="Описание">
              <label for="description">Описание</label>
            </div>

            <div class="form-floating  mt-3">
              <input v-model="competence.need_rating" type="text" class="form-control" id="price" placeholder="Необходимый рейтинг">
              <label for="price">Необходимый рейтинг</label>
            </div>

            <button @click="createComp" class="w-100 btn btn-lg btn-primary mt-3" type="submit">Создать компетенцию</button>

          </form>
        </div>

      </div>

      <div class="tab-pane fade" id="change" role="tabpanel" aria-labelledby="profile-tab">

        <div class="container" style="max-width: 600px">
          <form class="mx-1 mx-md-4">

            <h1>Изменение компетенции отдела</h1>

            <label class="form-label mt-3">Компетенция</label>
            <select class="form-select form-select-sm mt-3" aria-label=".form-select-sm example" v-model="competence.id" @change="checkComp">
              <option disabled="disabled">Сделайте выбор</option>
              <option v-for="item in competences" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
            </select>

            <div class="form-floating mt-3">
              <input v-model="competence.name" type="text" class="form-control" id="name" placeholder="Название">
              <label for="name">Название</label>
            </div>

            <div class="form-floating  mt-3">
              <input v-model="competence.description" type="text" class="form-control" id="description" placeholder="Описание">
              <label for="description">Описание</label>
            </div>

            <div class="form-floating  mt-3">
              <input v-model="competence.need_rating" type="text" class="form-control" id="price" placeholder="Необходимый рейтинг">
              <label for="price">Необходимый рейтинг</label>
            </div>

            <button @click="changeComp" class="w-100 btn btn-lg btn-primary mt-3" type="submit">Изменить компетенцию</button>

          </form>

        </div>

      </div>

      <div class="tab-pane fade" id="delete" role="tabpanel" aria-labelledby="contact-tab">

        <div class="container" style="max-width: 600px">
          <form class="mx-1 mx-md-4">

            <h1>Удаление компетенции отдела</h1>

            <label class="form-label mt-3">Компетенция</label>
            <select class="form-select form-select-sm mt-3" aria-label=".form-select-sm example" v-model="competence.id" >
              <option disabled="disabled">Сделайте выбор</option>
              <option v-for="item in competences" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
            </select>

            <button @click="deleteComp" class="w-100 btn btn-lg btn-primary mt-3" type="submit">Удалить компетенцию</button>

          </form>

        </div>

      </div>
    </div>

  </div>


</template>

<script>
import FullNavbar from "@/components/Navbars/FullNavbar";
import axios from "axios";
export default {
  name: "CreateChangeCompetence",
  components: {FullNavbar},
  data() {
    return {
      "competences": {},
      "competence": {
        "id": '',
        "name": '',
        "description": '',
        "need_rating": ''
      }
    };
  },
  beforeCreate() {
    axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
    axios
        .get("http://localhost:84/api/v1/competence/list/" + localStorage.getItem('id'))
        .then(response => {
          this.competences = response.data.competence_dto_s
          console.log(this.competences)
        });
  },
  methods: {
    checkComps(){
      axios
          .get("http://localhost:84/api/v1/competence/list/" + localStorage.getItem('id'))
          .then(response => {
            this.competences = response.data.competence_dto_s
            console.log(this.competences)
          });
    },
    checkComp(){
      axios
          .get("http://localhost:84/api/v1/competence/" + this.competence.id)
          .then(response => {
            this.competence = response.data
            console.log(this.competences)
          });
    },
    createComp(){
      axios
          .post('http://localhost:84/api/v1/competence/add/' + this.competences[0].id,{
            name: this.competence.name,
            description: this.competence.description,
            need_rating: this.competence.need_rating,
            type: 0
          })
          .then(response => {
            console.log(response.data)
            this.checkComps()
          });
    },
    changeComp(){
      axios
          .post('http://localhost:84/api/v1/competence/change/' + this.competence.id,{
            name: this.competence.name,
            description: this.competence.description,
            need_rating: this.competence.need_rating,
            type: 0
          })
          .then(response => {
            console.log(response.data)
            this.checkComps()
          });
    },
    deleteComp(){
      axios
          .post('http://localhost:84/api/v1/competence/delete/' + this.competence.id)
          .then(response => {
            console.log(response.data)

            this.checkComps()
          });
    }
  }
}
</script>

<style scoped>

</style>