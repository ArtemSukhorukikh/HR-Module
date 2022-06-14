<template>
  <FullNavbar></FullNavbar>
  <modal-window-department-create ref="modalCreate" v-show="isModalCreateVisible" @close="closeModal"></modal-window-department-create>
  <modal-window-department-update ref="modalUpdate" v-show="isModalUpdateVisible" @close="closeModal"></modal-window-department-update>
  <ModalWindowDepartmentUpdateTarget ref="modalUpdateTarg" v-show="isModalUpdateTargVisible" @close="closeModal"></ModalWindowDepartmentUpdateTarget>
  <button @click="openModalCreate()" class="btn btn-outline-primary my-2 m-2" >Создать отдел</button>
  <button @click="openModalUpdateTarg()" class="btn btn-outline-primary my-2 m-2" >Изменить отдел</button>
  <router-link class="btn btn-outline-primary my-2 m-2" to="/registration">Регистрация</router-link>
  <div class='container'>
    <vue-tree
        style="width: 1240px; height: 800px; border: 1px solid gray;"
        :dataset="vehicules"
        :config="treeConfig"
        linkStyle="straight"
    >
      <template v-slot:node="{ node, collapsed }">
        <div
            class="rich-media-node"
            :style="{ border: collapsed ? '2px solid grey' : '' }"
        >
          <span style="padding: 4px 0; font-weight: bold;"
          >{{ node.name }}</span>
          <span>{{ node.director_name }}</span>
          <button @click="openModalUpdate(node)" class="btn btn-outline-primary my-2 " >Изменить</button>
          <button @click="deleteDep(node.id)" class="btn btn-outline-primary my-2 " >Удалить</button>
        </div>
      </template>
    </vue-tree>
  </div>
</template>
<script>
import VueTree from "@ssthouse/vue3-tree-chart";
import FullNavbar from "@/components/Navbars/FullNavbar";
import "@ssthouse/vue3-tree-chart/dist/vue3-tree-chart.css";
import axios from "axios";
import ModalWindowDepartmentCreate from "@/components/modal-windows/modal-window-department-create";
import ModalWindowDepartmentUpdate from "@/components/modal-windows/modal-window-department-update";
import ModalWindowDepartmentUpdateTarget from "@/components/modal-windows/modal-window-department-update_target";
export default {
  components: {ModalWindowDepartmentUpdateTarget, ModalWindowDepartmentUpdate, ModalWindowDepartmentCreate, FullNavbar, VueTree },
  name: 'TestTest',
  data() {
    return {
      userMain: true,
      isModalCreateVisible: false,
      isModalUpdateVisible: false,
      isModalUpdateTargVisible: false,
      vehicules: {
      },
      departments:  {},
      treeConfig: { nodeWidth: 200, nodeHeight: 150, levelHeight: 200 }
    }
  },
  beforeCreate() {
    axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
    axios
        .get("http://localhost:84/api/v1/department")
        .then(response => {
          this.vehicules = response.data
          console.log(this.vehicules)
        });
    axios
        .get("http://localhost:84/api/v1/department/findAll")
        .then(response => {
          this.departments = response.data
          console.log(this.vehicules)
        });
  },
  methods: {
    openModalCreate() {
      this.isModalCreateVisible = true;
      this.$refs.modalCreate.departments = this.departments
    },
    openModalUpdate(node) {
      this.isModalUpdateVisible = true;
      this.$refs.modalUpdate.id = node.id
      if (node.name){
        this.$refs.modalUpdate.dep_name = node.name
      }
      this.$refs.modalUpdate.departments = this.departments
    },
    openModalUpdateTarg() {
      this.isModalUpdateTargVisible = true;
      this.$refs.modalUpdateTarg.departments = this.departments
    },
    closeModal() {
      this.isModalUpdateVisible = false;
      this.isModalCreateVisible = false;
      this.isModalUpdateTargVisible = false;
      axios
          .get("http://localhost:84/api/v1/department")
          .then(response => {
            this.vehicules = response.data
            console.log(this.vehicules)
          });
      axios
          .get("http://localhost:84/api/v1/department/findAll")
          .then(response => {
            this.departments = response.data
            console.log(this.vehicules)
          });
    },
    deleteDep(id){
      axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
      axios.post(`http://localhost:84/api/v1/department/delete/` + id).then(responce => {
        console.log(responce)
        axios
            .get("http://localhost:84/api/v1/department")
            .then(response => {
              this.vehicules = response.data
              console.log(this.vehicules)
            });
        axios
            .get("http://localhost:84/api/v1/department/findAll")
            .then(response => {
              this.departments = response.data
              console.log(this.vehicules)
            });
      }).catch(errors => {
        console.log(errors)
      })
      axios
          .get("http://localhost:84/api/v1/department")
          .then(response => {
            this.vehicules = response.data
            console.log(this.vehicules)
          });
      axios
          .get("http://localhost:84/api/v1/department/findAll")
          .then(response => {
            this.departments = response.data
            console.log(this.vehicules)
          });
    },
  }
}
</script>

<style scoped>
.container {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.rich-media-node {
  padding: 8px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: center;
  color: black;
  background-color: whitesmoke;
  border-radius: 4px;
}
</style>