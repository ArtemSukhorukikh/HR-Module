<template>
  <FullNavbar/>

  <div class="container bg-light w-75 min-vh-100">

    <ul class="nav nav-tabs mx-auto" id="myTab" role="tablist">
      <li class="nav-item mx-auto" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#new" type="button" role="tab" aria-controls="new" aria-selected="true" >Создать</button>
      </li>
      <li class="nav-item mx-auto" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#change" type="button" role="tab" aria-controls="change" aria-selected="false" @click="checkSkills()">Изменить</button>
      </li>
      <li class="nav-item mx-auto" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#delete" type="button" role="tab" aria-controls="delete" aria-selected="false" @click="checkSkills()">Удалить</button>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">

      <div class="tab-pane fade show active" id="new" role="tabpanel" aria-labelledby="home-tab">

        <div class="container" style="max-width: 600px">
          <form class="mx-1 mx-md-4">

            <h1>Создание навыка для компетенции отдела</h1>

            <div class="form-floating mt-3">
              <input v-model="skill.name" type="text" class="form-control" id="name" placeholder="Название">
              <label for="name">Название</label>
            </div>

            <div class="form-floating  mt-3">
              <input v-model="skill.description" type="text" class="form-control" id="description" placeholder="Описание">
              <label for="description">Описание</label>
            </div>

            <button @click="createSkill" class="w-100 btn btn-lg btn-primary mt-3" type="submit">Создать навык</button>

          </form>
        </div>

      </div>

      <div class="tab-pane fade" id="change" role="tabpanel" aria-labelledby="profile-tab">

        <div class="container" style="max-width: 600px">
          <form class="mx-1 mx-md-4">

            <h1>Изменение компетенции отдела</h1>

            <label class="form-label mt-3">Навык</label>
            <select class="form-select form-select-sm mt-3" aria-label=".form-select-sm example" v-model="skill.id" @change="checkSkill()">
              <option disabled="disabled">Сделайте выбор</option>
              <option v-for="item in skills" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
            </select>

            <div class="form-floating mt-3">
              <input v-model="skill.name" type="text" class="form-control" id="name" placeholder="Название">
              <label for="name">Название</label>
            </div>

            <div class="form-floating  mt-3">
              <input v-model="skill.description" type="text" class="form-control" id="description" placeholder="Описание">
              <label for="description">Описание</label>
            </div>

            <button @click="changeSkill" class="w-100 btn btn-lg btn-primary mt-3" type="submit">Изменить компетенцию</button>

          </form>

        </div>

      </div>

      <div class="tab-pane fade" id="delete" role="tabpanel" aria-labelledby="contact-tab">

        <div class="container" style="max-width: 600px">
          <form class="mx-1 mx-md-4">

            <h1>Удаление навыка компетенции отдела</h1>

            <label class="form-label mt-3">Навык</label>
            <select class="form-select form-select-sm mt-3" aria-label=".form-select-sm example" v-model="skill.id">
              <option disabled="disabled">Сделайте выбор</option>
              <option v-for="item in skills" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
            </select>

            <button @click="deleteSkill" class="w-100 btn btn-lg btn-primary mt-3" type="submit">Удалить навык</button>

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
  name: "CreateChangeSkill",
  components: {FullNavbar},
  data() {
    return {
      "skills": {},
      "skill": {
        "id": '',
        "name": '',
        "description": ''
      },
      "competences": {},
      "competence": {
        "id": ''
      }
    };
  },
  beforeCreate() {
    console.log(localStorage.getItem('userId'))
    axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
  },
  methods: {
      checkSkills(){
        axios
            .get("http://localhost:84/api/v1/skills/competence/" + localStorage.getItem('userId'))
            .then(response => {
              this.skills = response.data.skills
              console.log(this.skills)
            })
      },
    checkSkill(){
      axios
          .get("http://localhost:84/api/v1/skills/" + this.skill.id)
          .then(response => {
            this.skill.name = response.data.name
            this.skill.description = response.data.description
            console.log(this.skill)
          })
    },
    createSkill(){
      axios
          .post('http://localhost:84/api/v1/skills/new/' + localStorage.getItem('userId'),{
            name: this.skill.name,
            description: this.skill.description
          })
          .then(response => {
            console.log(response.data)
          });
    },
    changeSkill(){
      axios
          .post('http://localhost:84/api/v1/skills/change/' + this.skill.id,{
            name: this.skill.name,
            description: this.skill.description,
            competence_id: this.competence.id
          })
          .then(response => {
            console.log(response.data)
          });
    },
    deleteSkill(){
      axios
          .post('http://localhost:84/api/v1/skills/delete/' + this.skill.id)
          .then(response => {
            console.log(response.data)
          });
    }
  }
}
</script>

<style scoped>

</style>