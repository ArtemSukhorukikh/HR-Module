<template>
  <transition>
    <div class="modal-backdrop">
      <div  class=" modal">
        <header class="modal-header">
          <slot name="header">
            Создание ответа
            <button type="button" class="btn-close" @click="close">x</button>
          </slot>
        </header>
        <section class="modal-body">
          <slot name="body">
            <div class="container">
              <div class="form-floating mb-3">
                <textarea type="text" class="form-control" id="floatingInput" v-model="answer.login" placeholder="Отзыв" required/>
                <label for="floatingInput">Логин</label>
              </div>
              <div class="form-floating mb-3">
                <textarea type="text" class="form-control" id="floatingInput" v-model="answer.password" placeholder="Отзыв" required/>
                <label for="floatingInput">Пароль</label>
              </div>
              <div class="mb-3 d-flex justify-content-center">
                <button class="btn btn-outline-primary" @click="createAnsw()">Создать ответ</button>
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
  name: "modal-window-answer-create",
  data: function () {
    return {
      show: false,
      error: false,
      ok:"",
      id:"",
      answer: {
        login:"",
        password:"",
      },
      departments:{}
    }
  },
  methods: {
    createAnsw(){
      axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
      axios.post(`http://194.67.93.27:84/api/v1/applicationFT/status`,{
        id: this.id,
        status: 1,
        application_answer: this.answer
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