<template>
  <modal-window-department-create ref="modal" v-show="isModalCreateVisible" @close="closeModal"></modal-window-department-create>
  <modal-window-department-update ref="modal" v-show="isModalUpdateVisible" @close="closeModal"></modal-window-department-update>
  <button @click="openModalCreate()" class="btn btn-outline-primary my-2 " >Создать отдел</button>
  <div class='container'>
    <vue-tree
        style="width: 800px; height: 600px; border: 1px solid gray;"
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
          <button @click="openModalUpdate(node)" class="btn btn-outline-primary my-2 " >Создать отдел</button>
        </div>
      </template>
    </vue-tree>
  </div>
</template>
<script>
import VueTree from "@ssthouse/vue3-tree-chart";
import "@ssthouse/vue3-tree-chart/dist/vue3-tree-chart.css";
import axios from "axios";
import ModalWindowDepartmentCreate from "@/components/modal-windows/modal-window-department-create";
import ModalWindowDepartmentUpdate from "@/components/modal-windows/modal-window-department-update";
export default {
  components: {ModalWindowDepartmentUpdate, ModalWindowDepartmentCreate, VueTree },
  name: 'TestTest',
  data() {
    return {
      userMain: true,
      isModalCreateVisible: false,
      isModalUpdateVisible: false,
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
      this.$refs.modal.departments = this.departments
    },
    openModalUpdate(node) {
      this.isModalUpdateVisible = true;
      this.$refs.modal.id = node.id
      this.$refs.modal.dep_name = node.dep
      this.$refs.modal.departments = this.departments

    },
    closeModal() {
      this.isModalUpdateVisible = false;
      this.isModalCreateVisible = false;
      axios
          .get("http://localhost:84/api/v1/department")
          .then(response => {
            this.vehicules = response.data
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
  color: white;
  background-color: #f7c616;
  border-radius: 4px;
}
</style>