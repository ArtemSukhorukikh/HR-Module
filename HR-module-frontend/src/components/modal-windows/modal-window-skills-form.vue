<template>
  <transition>
    <div class="modal-backdrop">
      <div  class=" modal">
        <header class="modal-header">
          <slot name="header">
            Оценка сотрудника

            <button
                type="button"
                class="btn-close"
                @click="close"
            >
              x
            </button>
          </slot>
        </header>
        <section class="modal-body">
          <slot name="body">
            <div class="container">


              <div class="d-flex flex-row align-items-center mb-2">
                <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                <div class="form-outline flex-fill mb-0">
                  <label class="form-label" for="form3Example3c">Сотрудник</label>
                  <select class="form-control form-control" v-model="user">
                    <option v-for="item in users" v-bind:key="item" v-bind:value="item.id">{{item.lastname + ' ' + item.firstname}}</option>
                  </select>
                </div>
              </div>

              <div class="d-flex flex-row align-items-center mb-2">
                <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                <div class="form-outline flex-fill mb-0">
                  <label class="form-label" for="form3Example3c">Навык</label>
                  <select class="form-control form-control" v-model="skill">
                    <option v-for="item in skills" v-bind:key="item" v-bind:value="item.id">{{item.name}}</option>
                  </select>
                </div>
              </div>

              <div class="d-flex flex-row align-items-center mb-2">
                <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                <div class="form-outline flex-fill mb-0">
                  <label class="form-label" for="form3Example3c">Оценка</label>
                  <select class="form-control form-control" v-model="estimation">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                  </select>
                </div>
              </div>


              <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                <button @click="astimate" type="button" class="btn btn-primary btn-lg">Подтвердить оценку</button>
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
  name: "modal-window-skills-form",
  data: function () {
    return {
      show: false,
      error: false,
      ok:"",
      users: {},
      skills: {},
      "user": '',
      "skill": '',
      "estimation": ''
    }
  },
  methods: {
    astimate(){
      console.log(this.user)
      console.log(this.skill)
      console.log(this.estimation)
      axios
          .post('http://localhost:84/api/v1/skillAssessment/new',{
            user_id: this.user,
            skills_id: this.skill,
            estimation: this.estimation})
          .then(response => {
            console.log(response)
          });
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