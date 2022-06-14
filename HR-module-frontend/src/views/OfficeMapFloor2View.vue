<template>
  <FullNavbar/>
  <div v-show="loaded">
    <img class="mt-2" src="../assets/img/Floor2.png" usemap="#image-map">
    <modal-window-workplace ref="modal" v-show="isModalVisible" @close="closeModal"></modal-window-workplace>
    <map name="image-map">
      <area @click="clickOnMap(9,1)" alt="" coords="1375,63,1425,116" shape="">
      <area @click="clickOnMap(9,2)" alt=""   coords="1444,231,1509,290" shape="0">
      <area @click="clickOnMap(9,3)" alt=""  coords="1528,231,1588,278" shape="0">
      <area @click="clickOnMap(9,4)" alt=""  coords="1525,279,1584,338" shape="0">
      <area @click="clickOnMap(9,5)" alt=""  coords="1308,309,1357,365" shape="0">
      <area @click="clickOnMap(9,6)" alt=""  coords="1308,369,1357,416" shape="0">
      <area @click="clickOnMap(9,7)" alt=""  coords="1523,406,1575,456" shape="0">
      <area @click="clickOnMap(9,8)" alt=""  coords="1488,451,1554,506" shape="0">
      <area @click="clickOnMap(9,9)" alt=""  coords="1457,496,1515,543" shape="0">
      <area @click="clickOnMap(9,10)" alt=""  coords="1320,483,1378,535" shape="0">
      <area @click="clickOnMap(9,11)" alt=""  coords="1319,559,1395,617" shape="0">
      <area @click="clickOnMap(10,1)" alt=""  coords="1092,386,1166,437" shape="0">
      <area @click="clickOnMap(10,2)" alt=""  coords="1092,436,1169,490" shape="0">
      <area @click="clickOnMap(11,1)" alt=""  coords="708,283,771,330" shape="0">
      <area @click="clickOnMap(11,2)" alt=""  coords="774,281,832,327" shape="0">
      <area @click="clickOnMap(11,3)" alt=""  coords="842,280,892,341" shape="0">
      <area @click="clickOnMap(11,4)" alt=""  coords="901,303,952,359" shape="0">
      <area @click="clickOnMap(11,5)" alt=""  coords="1000,386,938,326" shape="0">
      <area @click="clickOnMap(11,6)" alt=""  coords="851,352,901,393" shape="0">
      <area @click="clickOnMap(11,7)" alt=""  coords="709,332,774,381" shape="0">
      <area @click="clickOnMap(11,8)" alt=""  coords="777,335,836,384" shape="0">
      <area @click="clickOnMap(11,9)" alt=""  coords="705,393,774,448" shape="0">
      <area @click="clickOnMap(11,10)" alt=""  coords="774,395,830,444" shape="0">
      <area @click="clickOnMap(11,11)" alt=""  coords="855,427,915,483" shape="0">
      <area @click="clickOnMap(11,12)" alt=""  coords="933,423,995,474" shape="0">
      <area @click="clickOnMap(11,13)" alt=""  coords="1030,421,1089,472" shape="0">
      <area @click="clickOnMap(11,14)" alt=""  coords="932,480,998,522" shape="0">
      <area @click="clickOnMap(11,15)" alt=""  coords="1033,472,1095,531" shape="0">
      <area @click="clickOnMap(11,16)" alt=""  coords="701,450,777,503" shape="0">
      <area @click="clickOnMap(11,17)" alt=""  coords="780,452,827,502" shape="0">
      <area @click="clickOnMap(11,18)" alt=""  coords="759,516,820,571" shape="0">
      <area @click="clickOnMap(11,19)" alt=""  coords="846,506,901,563" shape="0">
      <area @click="clickOnMap(12,1)" alt=""  coords="550,511,605,564" shape="0">
      <area @click="clickOnMap(12,2)" alt=""  coords="634,507,696,575" shape="0">
    </map>
  </div>
  <div class="container">
    <div v-for="office in dataOffices.offices" v-bind:key="office">
      <div v-if="office.floor === 2">
        <table class="table">
          <thead>
          <tr>
            <th scope="col">Кабинет</th>
            <th scope="col">№ Рабочего места</th>
            <th scope="col">Работник</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="workplace in office.workplaces" v-bind:key="workplace">
            <td>{{ office.name }}</td>
            <td> {{ workplace.RoomInTheOffice}}</td>
            <td v-if="workplace.user"><router-link :to="{  name : 'userPage', params: { username: workplace.user.username   } }" class="link-primary">{{ workplace.user.userInfo.lastname }}  {{ workplace.user.userInfo.firstname}} {{ workplace.user.userInfo.patronymic}}</router-link></td>
            <td v-else> Рабочее место не занято</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</template>

<script>
import FullNavbar from "@/components/Navbars/FullNavbar";
import ModalWindowWorkplace from "@/components/modal-windows/modal-window-workplace";
import axios from 'axios'
export default {
  name: "OfficeMapFloor2View",
  data() {
    return {
      loaded: false,
      isModalVisible: false,
      dataOffices:{
        offices: undefined
      }
    };
  },
  components: {ModalWindowWorkplace, FullNavbar},
  beforeCreate() {
    axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
    axios.get('http://localhost:84/api/v1/offices').then(response => {
      console.log(response.data)
      this.dataOffices = (response.data)
      this.loaded = true
    }).catch(errors =>{
      console.log(errors)
    })
  },
  methods: {
    clickOnMap(officeNumber, place) {

      this.isModalVisible = true;
      this.$refs.modal.office.name = this.dataOffices.offices[officeNumber - 1].name
      this.$refs.modal.office.floor = this.dataOffices.offices[officeNumber - 1].floor
      this.$refs.modal.office.workplaces.id = this.dataOffices.offices[officeNumber - 1].workplaces[place - 1].id
      this.$refs.modal.office.workplaces.RoomInTheOffice = this.dataOffices.offices[officeNumber - 1].workplaces[place - 1].RoomInTheOffice
      if (this.dataOffices.offices[officeNumber - 1].workplaces[place - 1].user) {
        this.$refs.modal.office.workplaces.showUser = true
        this.$refs.modal.office.workplaces.user.firstname = this.dataOffices.offices[officeNumber - 1].workplaces[place - 1].user.userInfo.firstname
        this.$refs.modal.office.workplaces.user.lastname = this.dataOffices.offices[officeNumber - 1].workplaces[place - 1].user.userInfo.lastname
        this.$refs.modal.office.workplaces.user.patronymic = this.dataOffices.offices[officeNumber - 1].workplaces[place - 1].user.userInfo.patronymic
        this.$refs.modal.office.workplaces.user.position = this.dataOffices.offices[officeNumber - 1].workplaces[place - 1].user.userInfo.position
        this.$refs.modal.office.workplaces.user.contacts = this.dataOffices.offices[officeNumber - 1].workplaces[place - 1].user.userInfo.contacts
        this.$refs.modal.office.workplaces.user.username = this.dataOffices.offices[officeNumber - 1].workplaces[place - 1].user.username
        if (this.$refs.modal.office.workplaces.user.username === localStorage.getItem('username')) {
          this.$refs.modal.isUser = true
        }
      }
      else {
        this.$refs.modal.office.workplaces.showUser = false
        this.$refs.modal.office.workplaces.user.firstname = ""
        this.$refs.modal.office.workplaces.user.lastname = ""
        this.$refs.modal.office.workplaces.user.patronymic = ""
        this.$refs.modal.office.workplaces.user.position = ""
      }
      this.$refs.modal.place = place - 1
      this.$refs.modal.render = true;
    },
    closeModal() {
      this.isModalVisible = false;
      axios.get('http://localhost:84/api/v1/offices').then(response => {
        console.log(response.data)
        this.dataOffices = (response.data)
        this.loaded = true
      }).catch(errors =>{
        console.log(errors)
      })
    }
  }
}
</script>

<style scoped>

</style>