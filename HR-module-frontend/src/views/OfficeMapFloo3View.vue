<template>
  <FullNavbar/>
  <div>
    <modal-window-workplace ref="modal" v-show="isModalVisible" @close="closeModal"></modal-window-workplace>
    <img class="w-auto h-auto" src="../assets/img/Floor3.png" usemap="#image-map">
    <map name="image-map">
      <area @click="clickOnMap(1,1)" target="" alt="" coords="79,102,139,143" shape="0">
      <area @click="clickOnMap(1,3)" target="" alt="" coords="80,199,138,147" shape="0">
      <area @click="clickOnMap(1,2)" target="" alt="" coords="149,99,207,147" shape="0">
      <area @click="clickOnMap(1,4)" target="" alt="" coords="149,149,202,194" shape="0">
      <area @click="clickOnMap(1,5)" target="" alt="" coords="79,236,135,280" shape="">
      <area @click="clickOnMap(1,6)" target="" alt="" coords="79,286,136,328" shape="0">
      <area @click="clickOnMap(2,1)" target="" alt="" coords="316,94,358,138" shape="0">
      <area @click="clickOnMap(2,2)" target="" alt="" coords="364,96,399,140" shape="0">
      <area @click="clickOnMap(2,3)" target="" alt="" coords="331,145,386,185" shape="0">
      <area @click="clickOnMap(2,4)" target="" alt="" coords="399,94,450,138" shape="0">
      <area @click="clickOnMap(2,5)" target="" alt="" coords="452,98,497,142" shape="0">
      <area @click="clickOnMap(2,6)" target="" alt="" coords="508,57,552,107" shape="0">
      <area @click="clickOnMap(2,7)" target="" alt="" coords="556,59,603,102" shape="0">
      <area @click="clickOnMap(2,8)" target="" alt="" coords="655,56,708,93" shape="0">
      <area @click="clickOnMap(2,9)" target="" alt="" coords="709,56,748,89" shape="0">
      <area @click="clickOnMap(2,10)" target="" alt="" coords="658,97,703,129" shape="0">
      <area @click="clickOnMap(2,11)" target="" alt="" coords="709,97,745,132" shape="0">
      <area @click="clickOnMap(2,12)" target="" alt="" coords="312,216,356,260" shape="0">
      <area @click="clickOnMap(2,13)" target="" alt="" coords="359,216,403,260" shape="0">
      <area @click="clickOnMap(2,14)" target="" alt="" coords="421,214,467,267" shape="0">
      <area @click="clickOnMap(2,15)" target="" alt="" coords="659,183,703,223" shape="0">
      <area @click="clickOnMap(2,16)" target="" alt="" coords="708,179,747,224" shape="0">
      <area @click="clickOnMap(2,17)" target="" alt="" coords="658,227,706,265" shape="0">
      <area @click="clickOnMap(2,18)" target="" alt="" coords="706,226,748,257" shape="0">
      <area @click="clickOnMap(3,1)" target="" alt="" coords="1426,55,1479,105" shape="0">
      <area @click="clickOnMap(3,2)" target="" alt="" coords="1469,122,1516,172" shape="0">
      <area @click="clickOnMap(3,3)" target="" alt="" coords="1419,173,1463,216" shape="0">
      <area @click="clickOnMap(3,4)" target="" alt="" coords="1469,175,1513,218" shape="0">
      <area @click="clickOnMap(3,5)" target="" alt="" coords="1534,176,1584,226" shape="0">
      <area @click="clickOnMap(3,6)" target="" alt="" coords="1536,227,1585,269" shape="0">
      <area @click="clickOnMap(3,7)" target="" alt="" coords="1419,224,1464,270" shape="0">
      <area @click="clickOnMap(3,8)" target="" alt="" coords="1469,223,1514,270" shape="0">
      <area @click="clickOnMap(3,9)" target="" alt="" coords="1407,326,1447,369" shape="0">
      <area @click="clickOnMap(3,10)" target="" alt="" coords="1403,382,1451,431" shape="0">
      <area @click="clickOnMap(3,11)" target="" alt="" coords="1454,379,1498,427" shape="0">
      <area @click="clickOnMap(3,12)" target="" alt="" coords="1532,363,1584,410" shape="0">
      <area @click="clickOnMap(3,13)" target="" alt="" coords="1534,417,1582,455" shape="0">
      <area @click="clickOnMap(3,14)" target="" alt="" coords="1406,434,1450,471" shape="0">
      <area @click="clickOnMap(3,15)" target="" alt="" coords="1454,430,1495,465" shape="0">
      <area @click="clickOnMap(3,16)" target="" alt="" coords="1403,494,1458,537" shape="0">
      <area @click="clickOnMap(4,1)" target="" alt="" coords="1177,332,1226,382" shape="0">
      <area @click="clickOnMap(4,2)" target="" alt="" coords="1130,377,1174,430" shape="0">
      <area @click="clickOnMap(4,3)" target="" alt="" coords="1179,383,1222,425" shape="0">
      <area @click="clickOnMap(4,4)" target="" alt="" coords="1323,323,1382,370" shape="0">
      <area @click="clickOnMap(4,5)" target="" alt="" coords="1328,375,1378,415" shape="0">
      <area @click="clickOnMap(4,6)" target="" alt="" coords="1294,483,1348,530" shape="0">
      <area @click="clickOnMap(4,7)" target="" alt="" coords="1348,479,1389,527" shape="0">
      <area @click="clickOnMap(5,1)" target="" alt="" coords="852,325,898,376" shape="0">
      <area @click="clickOnMap(5,2)" target="" alt="" coords="901,324,951,374" shape="0">
      <area @click="clickOnMap(5,3)" target="" alt="" coords="1010,328,1071,378" shape="0">
      <area @click="clickOnMap(5,4)" target="" alt="" coords="1071,327,1119,379" shape="0">
      <area @click="clickOnMap(5,5)" target="" alt="" coords="851,433,898,482" shape="0">
      <area @click="clickOnMap(5,6)" target="" alt="" coords="910,447,955,496" shape="0">
      <area @click="clickOnMap(5,7)" target="" alt="" coords="955,451,998,493" shape="0">
      <area @click="clickOnMap(5,8)" target="" alt="" coords="1018,423,1068,467" shape="0">
      <area @click="clickOnMap(5,9)" target="" alt="" coords="1070,424,1116,471" shape="0">
      <area @click="clickOnMap(6,1)" target="" alt="" coords="651,319,699,369" shape="0">
      <area @click="clickOnMap(6,2)" target="" alt="" coords="702,323,748,374" shape="0">
      <area @click="clickOnMap(6,3)" target="" alt="" coords="790,370,839,417" shape="0">
      <area @click="clickOnMap(6,4)" target="" alt="" coords="653,411,698,461" shape="0">
      <area @click="clickOnMap(6,5)" target="" alt="" coords="701,423,752,458" shape="0">
      <area @click="clickOnMap(6,6)" target="" alt="" coords="789,417,842,464" shape="0">
      <area @click="clickOnMap(6,7)" target="" alt="" coords="690,471,736,513" shape="0">
      <area @click="clickOnMap(7,1)" target="" alt="" coords="527,386,575,440" shape="0">
      <area @click="clickOnMap(7,2)" target="" alt="" coords="595,387,646,437" shape="0">
      <area @click="clickOnMap(7,3)" target="" alt="" coords="527,456,577,509" shape="0">
      <area @click="clickOnMap(7,4)" target="" alt="" coords="595,458,640,510" shape="0">
      <area @click="clickOnMap(8,1)" target="" alt="" coords="286,314,336,373" shape="0">
      <area @click="clickOnMap(8,2)" target="" alt="" coords="338,319,384,371" shape="0">
      <area @click="clickOnMap(8,3)" target="" alt="" coords="418,343,469,397" shape="0">
      <area @click="clickOnMap(8,4)" target="" alt="" coords="471,372,518,413" shape="0">
      <area @click="clickOnMap(8,5)" target="" alt="" coords="294,414,343,466" shape="0">
      <area @click="clickOnMap(8,6)" target="" alt="" coords="344,418,397,462" shape="0">
      <area @click="clickOnMap(8,7)" target="" alt="" coords="411,425,462,474" shape="0">
      <area @click="clickOnMap(8,8)" target="" alt="" coords="464,430,511,480" shape="0">
    </map>
  </div>

</template>

<script>
import FullNavbar from "@/components/Navbars/FullNavbar";
import ModalWindowWorkplace from "@/components/modal-windows/modal-window-workplace";
import axios from "axios";
export default {
  name: "OfficeMapFloor3View",
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
      axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
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
  .part {
    box-sizing: border-box;
    width: 65px;
    height: 65px;
    border: 1px solid #000000;
  }
  .button-part {

    background: transparent;
    border: none !important;
    font-size:0;
  }
</style>