<template>
  <FullNavbar/>
  <div class="container bg-light">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#new" type="button" role="tab" aria-controls="new" aria-selected="true" @click="clear">Создать</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#change" type="button" role="tab" aria-controls="change" aria-selected="false" @click="clear">Изменить</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#delete" type="button" role="tab" aria-controls="delete" aria-selected="false" @click="clear">Удалить</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#add" type="button" role="tab" aria-controls="add" aria-selected="false" @click="clear">Добавить</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#remove" type="button" role="tab" aria-controls="remove" aria-selected="false" @click="clear">Убрать</button>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">

      <div class="tab-pane fade show active" id="new" role="tabpanel" aria-labelledby="home-tab">

        <div class="container" style="max-width: 600px">
          <form class="mx-1 mx-md-4">

            <h1>Создание образовательного ресурса для отдела</h1>

            <label class="form-label mt-3">Компетенция</label>
            <select class="form-select form-select-sm mt-3" aria-label=".form-select-sm example" v-model="competence.id" >
              <option disabled="disabled">Сделайте выбор</option>
              <option v-for="item in competences" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
            </select>

            <div class="form-floating mt-3">
              <input v-model="educationRes.name" type="text" class="form-control" id="name" placeholder="Название">
              <label for="name">Название</label>
            </div>

            <div class="form-floating  mt-3">
              <input v-model="educationRes.description" type="text" class="form-control" id="description" placeholder="Описание">
              <label for="description">Описание</label>
            </div>

            <div class="form-floating  mt-3">
              <input v-model="educationRes.link" type="text" class="form-control" id="link" placeholder="Ссылка">
              <label for="link">Ссылка</label>
            </div>

            <div class="form-floating  mt-3">
              <input v-model="educationRes.price" type="text" class="form-control" id="link" placeholder="Цена">
              <label for="link">Цена</label>
            </div>

            <label for="type" class="mt-3">Тип ресурса</label>
            <select class="form-select form-select-sm mt-1" aria-label=".form-select-sm example" v-model="educationRes.type" id="type">
              <option value="0">Книга</option>
              <option value="1">Онлайн курс</option>
              <option value="2">Онлайн тренинг</option>
              <option value="3">Личный ресурс</option>
            </select>

            <button @click="newEdRes" class="w-100 btn btn-lg btn-primary mt-3" type="submit">Создать компетенцию</button>

          </form>
        </div>

      </div>

      <div class="tab-pane fade" id="change" role="tabpanel" aria-labelledby="profile-tab">

        <div class="container" style="max-width: 600px">
          <form class="mx-1 mx-md-4">

            <h1>Измененить образовательный ресурс отдела</h1>

            <label class="form-label mt-3">Компетенция</label>
            <select class="form-select form-select-sm mt-3" aria-label=".form-select-sm example" v-model="competence.id" @change="findResource">
              <option disabled="disabled">Сделайте выбор</option>
              <option v-for="item in competences" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
            </select>

            <label class="form-label mt-3">Образовательный ресурс</label>
            <select class="form-select form-select-sm mt-3" aria-label=".form-select-sm example" v-model="idRes" @change="findRes">
              <option disabled="disabled">Сделайте выбор</option>
              <option v-for="item in educationResources" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
            </select>

            <div class="form-floating mt-3">
              <input v-model="educationRes.name" type="text" class="form-control" id="name" placeholder="Название">
              <label for="name">Название</label>
            </div>

            <div class="form-floating  mt-3">
              <input v-model="educationRes.description" type="text" class="form-control" id="description" placeholder="Описание">
              <label for="description">Описание</label>
            </div>

            <div class="form-floating  mt-3">
              <input v-model="educationRes.link" type="text" class="form-control" id="link" placeholder="Ссылка">
              <label for="link">Ссылка</label>
            </div>

            <div class="form-floating  mt-3">
              <input v-model="educationRes.price" type="text" class="form-control" id="link" placeholder="Цена">
              <label for="link">Цена</label>
            </div>

            <label for="type" class="mt-3">Способ прохождения</label>
            <select class="form-select form-select-sm mt-1" aria-label=".form-select-sm example" v-model="educationRes.type" id="type">
              <option value="0">Книга</option>
              <option value="1">Онлайн курс</option>
              <option value="2">Онлайн тренинг</option>
              <option value="3">Личный ресурс</option>
            </select>

            <button @click="changeEdRes" class="w-100 btn btn-lg btn-primary mt-3" type="submit">Изменить компетенцию</button>

          </form>

        </div>

      </div>

      <div class="tab-pane fade" id="delete" role="tabpanel" aria-labelledby="contact-tab">

        <div class="container" style="max-width: 600px">
          <form class="mx-1 mx-md-4">

            <h1>Удаление образовательного ресурса отдела</h1>

            <label class="form-label mt-3">Компетенция</label>
            <select class="form-select form-select-sm mt-3" aria-label=".form-select-sm example" v-model="competence.id" @change="findResource">
              <option disabled="disabled">Сделайте выбор</option>
              <option v-for="item in competences" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
            </select>

            <label class="form-label mt-3">Образовательный ресурс</label>
            <select class="form-select form-select-sm mt-3" aria-label=".form-select-sm example" v-model="idRes">
              <option disabled="disabled">Сделайте выбор</option>
              <option v-for="item in educationResources" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
            </select>

            <button @click="deleteEdRes" class="w-100 btn btn-lg btn-primary mt-3" type="submit">Удалить образовательного ресурса</button>

          </form>

        </div>

      </div>

      <div class="tab-pane fade" id="add" role="tabpanel" aria-labelledby="contact-tab">

        <div class="container" style="max-width: 600px">
          <form class="mx-1 mx-md-4">

            <h1>Добавить компетенции образовательный ресурс</h1>

            <label class="form-label mt-3">Компетенция</label>
            <select class="form-select form-select-sm mt-3" aria-label=".form-select-sm example" v-model="competence.id">
              <option disabled="disabled">Сделайте выбор</option>
              <option v-for="item in competences" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
            </select>

            <label class="form-label mt-3">Образовательный ресурс</label>
            <select class="form-select form-select-sm mt-3" aria-label=".form-select-sm example" v-model="idRes">
              <option disabled="disabled">Сделайте выбор</option>
              <option v-for="item in educationResources" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
            </select>

            <button @click="findAllResource" class="w-100 btn btn-lg btn-primary mt-3" type="submit">Добавить ресурс</button>
            <button @click="compAddEdRes" class="w-100 btn btn-lg btn-primary mt-3" type="submit">Добавить ресурс</button>

          </form>

        </div>

      </div>

      <div class="tab-pane fade" id="remove" role="tabpanel" aria-labelledby="contact-tab">

        <div class="container" style="max-width: 600px">
          <form class="mx-1 mx-md-4">

            <h1>Убрать образовательный ресурс из компетенции</h1>

            <label class="form-label mt-3">Компетенция</label>
            <select class="form-select form-select-sm mt-3" aria-label=".form-select-sm example" v-model="competence.id" @change="findResource">
              <option disabled="disabled">Сделайте выбор</option>
              <option v-for="item in competences" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
            </select>

            <label class="form-label mt-3">Образовательный ресурс</label>
            <select class="form-select form-select-sm mt-3" aria-label=".form-select-sm example" v-model="idRes">
              <option disabled="disabled">Сделайте выбор</option>
              <option v-for="item in educationResources" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
            </select>

            <button @click="findAllResource" class="w-100 btn btn-lg btn-primary mt-3" type="submit">Добавить ресурс</button>
            <button @click="compDeleteEdRes" class="w-100 btn btn-lg btn-primary mt-3" type="submit">Удалить ресурс</button>

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
  name: "SettingsResourcesView",
  components: {FullNavbar},
  data() {
    return {
      "idRes": '',
      "competences": {},
      "competence": {
        "id": ''
      },
      "competence2": {
        "id": ''
      },
      "educationRes": {
        "id": '',
        "name": '',
        "description": '',
        "link": '',
        "price": '',
        "type": ''
      },
      "educationResources": {}
    };
  },
  beforeCreate() {
    console.log(localStorage.getItem('userId'))
    axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
    axios
        .get("http://localhost:84/api/v1/competence/list/" + localStorage.getItem('userId'))
        .then(response => {
          this.competences = response.data.competence_dto_s
          console.log(this.competences)
        });
  },
  methods: {
    clear() {
      this.idRes = null
      this.competence.id = null
      this.competence2 = null
      this.educationRes.id = null
      this.educationRes.price = null
      this.educationRes.name = null
      this.educationRes.type = null
      this.educationRes.link = null
      this.educationRes.description = null
      this.educationResources = null
    },
    findAllResource() {
      axios
          .get("http://localhost:84/api/v1/educationalResources/findAll")
          .then(response => {
            this.educationResources = response.data.educationResourcesCompetence
            console.log(this.educationResources)
          });
    },
    findResource() {
      axios
          .get("http://localhost:84/api/v1/educationalResources/findCompetence/" + this.competence.id)
          .then(response => {
            this.educationResources = response.data.educationResourcesCompetence
            console.log(this.competences)
          });
    },
    findRes() {
      axios
          .get("http://localhost:84/api/v1/educationalResources/" + this.idRes)
          .then(response => {
            this.educationRes = response.data
            console.log(this.educationRes)
          });
    },
    newEdRes(){
      axios
          .post('http://localhost:84/api/v1/educationalResources/new/' + this.competence.id,{
            name: this.educationRes.name,
            description: this.educationRes.description,
            link: this.educationRes.link,
            price: this.educationRes.price,
            type: this.educationRes.type,
          })
          .then(response => {
            console.log(response.data)
          });
    },
    changeEdRes(){
      console.log(this.educationRes.type)
      axios
          .post('http://localhost:84/api/v1/educationalResources/change/' + this.educationRes.id,{
            name: this.educationRes.name,
            description: this.educationRes.description,
            link: this.educationRes.link,
            price: this.educationRes.price,
            type: this.educationRes.type,
          })
          .then(response => {
            console.log(response.data)
          });
      this.findRes()
    },
    deleteEdRes(){
      axios
          .post('http://localhost:84/api/v1/educationalResources/delete/' + this.idRes)
          .then(response => {
            console.log(response.data)
          });
      this.findRes()
    },
    compAddEdRes(){
      axios
          .post('http://localhost:84/api/v1/educationalResources/add/' + this.competence.id  + "/" + this.idRes)
          .then(response => {
            console.log(response.data)
          });
      this.findRes()
    },
    compDeleteEdRes(){
      axios
          .post('http://localhost:84/api/v1/educationalResources/delete/' + this.competence.id  + "/" + this.idRes)
          .then(response => {
            console.log(response.data)
          });
      this.findRes()
    }

  }
}
</script>

<style scoped>

</style>