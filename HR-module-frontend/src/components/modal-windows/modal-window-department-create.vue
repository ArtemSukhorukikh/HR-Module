<template>
  <transition>
    <div class="modal-backdrop">
      <div  class=" modal">
        <header class="modal-header">
          <slot name="header">
            Создание отдела
            <button type="button" class="btn-close" @click="close">x</button>
          </slot>
        </header>
        <section class="modal-body">
          <slot name="body">
            <div class="container">
              <div class="form-floating mb-3">
                <textarea type="text" class="form-control" id="floatingInput" v-model="dep_name" placeholder="Отзыв" required/>
                <label for="floatingInput">Название отдела</label>
              </div>
              <div class="form-floating mb-3">
                <textarea type="text" class="form-control" id="floatingInput" v-model="comp_name" placeholder="Отзыв" required/>
                <label for="floatingInput">Название стартовой компетенции</label>
              </div>
              <label>Какому отделу подчиняется отдел</label>
              <select class="form-select form-select-sm" aria-label=".form-select-sm example " v-model="obeys_id">
                <option >Нет</option>
                <option v-for="item in departments" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
              </select>
              <div class="mb-3 d-flex justify-content-center">
                <button class="btn btn-outline-primary" @click="createDep()">Создать отдел</button>
              </div>
            </div>
          </slot>
        </section>
      </div>
    </div>
  </transition>
</template>

<script>
import axios from "axios";
export default {
  name: "modal-window-department-create",
  data: function () {
    return {
      show: false,
      error: false,
      ok:"",
      id:"",
      dep_name:"",
      comp_name:"",
      obeys_id:"",
      departments:{}
    }
  },
  methods: {
    createDep(){
      axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
      axios.post(`http://localhost:84/api/v1/department/new`,{
        name: this.dep_name,
        main_competence_name: this.comp_name,
        obeys_id: this.obeys_id
      }).then(responce => {
        console.log(responce)
      }).catch(errors => {
        console.log(errors)
      })
    },
    close() {
      this.$emit('close');
    },

  },
}
</script>

<style scoped>
.modal-backdrop {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.3);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal {
  width: 40%;
  background: #FFFFFF;
  box-shadow: 2px 2px 20px 1px;
  overflow-x: auto;
  display: flex;
  flex-direction: column;
}

.modal-header,
.modal-footer {
  padding: 15px;
  display: flex;
}

.modal-header {
  border-bottom: 1px solid #eeeeee;
  color: #0d6efd;;
  justify-content: space-between;
}

.modal-footer {
  border-top: 1px solid #eeeeee;
  justify-content: flex-end;
}

.modal-body {
  position: relative;
  padding: 20px 10px;
}

.btn-close {
  border: none;
  font-size: 20px;
  padding: 20px;
  cursor: pointer;
  font-weight: bold;
  color: #0d6efd;;
  background: transparent;
}

.btn-green {
  color: white;
  background: #0d6efd;;
  border: 1px solid #0d6efd;;
  border-radius: 2px;
}
</style>