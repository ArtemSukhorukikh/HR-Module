<template>
  <FullNavbar/>

  <div class="container" style="max-width: 600px">
    <form class="mx-1 mx-md-4">

      <h1>Создание навыка для компетенции отдела</h1>

      <label class="form-label mt-3">Компетенция</label>
      <select class="form-select form-select-sm mt-3" aria-label=".form-select-sm example" v-model="competence.id" >
        <option disabled="disabled">Сделайте выбор</option>
        <option v-for="item in competences" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
      </select>

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

  <div class="container" style="max-width: 600px">
    <form class="mx-1 mx-md-4">

      <h1>Изменение компетенции отдела</h1>

      <label class="form-label mt-3">Компетенция</label>
      <select class="form-select form-select-sm mt-3" aria-label=".form-select-sm example" v-model="competence.id" @change="checkSkills()">
        <option disabled="disabled">Сделайте выбор</option>
        <option v-for="item in competences" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
      </select>

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

  <div class="container" style="max-width: 600px">
    <form class="mx-1 mx-md-4">

      <h1>Удаление навыка компетенции отдела</h1>

      <label class="form-label mt-3">Компетенция</label>
      <select class="form-select form-select-sm mt-3" aria-label=".form-select-sm example" v-model="competence.id" @change="checkSkills()">
        <option disabled="disabled">Сделайте выбор</option>
        <option v-for="item in competences" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
      </select>

      <label class="form-label mt-3">Навык</label>
      <select class="form-select form-select-sm mt-3" aria-label=".form-select-sm example" v-model="skill.id" @change="checkSkill()">
        <option disabled="disabled">Сделайте выбор</option>
        <option v-for="item in skills" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
      </select>

      <button @click="deleteSkill" class="w-100 btn btn-lg btn-primary mt-3" type="submit">Удалить навык</button>

    </form>

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
    axios
        .get("http://localhost:84/api/v1/competence/list/" + localStorage.getItem('userId'))
        .then(response => {
          this.competences = response.data.competence_dto_s
          console.log(this.competences)
        });
  },
  methods: {
      checkSkills(){
        axios
            .get("http://localhost:84/api/v1/skills/competence/" + this.competence.id)
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
          .post('http://localhost:84/api/v1/skills/new',{
            competence_id: this.competence.id,
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