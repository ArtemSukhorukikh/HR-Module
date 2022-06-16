<template>
  <FullNavbar/>
  <div class="container" style="max-width: 600px">

    <form class="mx-1 mx-md-4">

      <label class="form-label">Грейд</label>
      <select class="form-select form-select-sm  mt-1" aria-label=".form-select-sm example" v-model="educationalResource.id_competence" >
        <option disabled="disabled">Сделайте выбор</option>
        <option v-for="item in competences" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
      </select>

      <div class="form-floating mt-3">
        <input v-model="educationalResource.name" type="text" class="form-control" id="name" placeholder="Название">
        <label for="name">Название</label>
      </div>

      <div class="form-floating  mt-3">
        <input v-model="educationalResource.description" type="text" class="form-control" id="description" placeholder="Описание">
        <label for="description">Описание</label>
      </div>

      <div class="form-floating  mt-3">
        <input v-model="educationalResource.link" type="text" class="form-control" id="link" placeholder="Ссылка">
        <label for="link">Ссылка</label>
      </div>

      <div class="form-floating  mt-3">
        <input v-model="educationalResource.price" type="text" class="form-control" id="price" placeholder="Цена">
        <label for="price">Цена</label>
      </div>


      <label for="type" class="mt-3">Способ прохождения</label>
      <select class="form-select form-select-sm mt-1" aria-label=".form-select-sm example" v-model="educationalResource.type" id="type">
        <option value="0">Книга</option>
        <option value="1">Онлайн курс</option>
        <option value="2">Онлайн тренинг</option>
        <option value="3">Личный ресурс</option>
      </select>

      <button @click="createEdRes" class="w-100 btn btn-lg btn-primary mt-3" type="submit">Создать ресурс</button>

    </form>

  </div>

</template>

<script>
import FullNavbar from "@/components/Navbars/FullNavbar";
import axios from "axios";
export default {
  name: "CreateEducationResource",
  components: {FullNavbar},
  data() {
    return {
      "applicationPOT": {},
      "applicationPOPT": {},
      "educationalResource" : {
        "id_competence": '',
        "name": '',
        "type": '',
        "description": '',
        "link": '',
        "price": ''
      },
      "competences": {}
    };
  },
  beforeCreate() {
    axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
    axios
        .get("http://localhost:84/api/v1/competence/all",)
        .then(response => {
          this.competences = response.data.competence_dto_s
          console.log(this.competences)
        });
  },
  methods: {
    createEdRes(){
      axios
          .post('http://localhost:84/api/v1/educationalResources/new',{
            id: "",
            id_competence: this.educationalResource.id_competence,
            name: this.educationalResource.name,
            type: this.educationalResource.type,
            description: this.educationalResource.description,
            link: this.educationalResource.link,
            price: this.educationalResource.price})
          .then(response => {
            console.log(response.data)
          });
    }
  }
}
</script>

<style scoped>

</style>