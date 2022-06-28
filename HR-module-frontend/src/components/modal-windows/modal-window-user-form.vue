<template>
  <transition>
    <div class="modal-backdrop">
      <div  class=" modal">
        <header class="modal-header">
          <slot name="header">
            Редактирование информации

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
              <div v-if="error" class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>При изменении данных произошла ошибка!</strong> Попробуйте проверьте данные или произведите операцию позже.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <div v-if="ok" class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Данные изменены</strong> Изменение данных произошло успешно.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" v-model="lastname" placeholder="Иванов" required>
                <label for="floatingInput">Фамилия</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" v-model="firstname" id="floatingInput" placeholder="Иван" required>
                <label for="floatingInput">Имя</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" v-model="patronymic" placeholder="Иванович" required>
                <label for="floatingInput">Отчество</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" v-model="username" placeholder="Username" required>
                <label for="floatingInput">Имя пользователя</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" v-model="department" placeholder="Отдел" required>
                <label for="floatingInput">Отдел</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" v-model="position" placeholder="Должномть" required>
                <label for="floatingInput">Должность</label>
              </div>
              <div class="form-floating mb-3">
                <input type="date" class="form-control" id="floatingInput"  v-model="dateofhiring">
                <label for="floatingInput">Дата приема на работу</label>
              </div>
              <div class="mb-3 d-flex justify-content-center">
                <button class="btn btn-outline-primary" @click="updateUserInfo()">Сохранить</button>
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
  name: "modal-window-user-form",
  data: function () {
    return {
      show: false,
      error: false,
      ok:"",
      id:"",
      username:"",
      firstname:"",
      lastname:"",
      patronymic:"",
      position:"",
      dateofhiring: "",
      department: "",



    }
  },
  methods: {
    updateUserInfo(){
      axios.post(`http://194.67.93.27:84/api/v1/users/update/${this.id}`,{
        username: this.username,
        lastname: this.lastname,
        firstname: this.firstname,
        patronymic: this.patronymic,
        position: this.position,
        dateofhiring: this.dateofhiring,
        department: this.department
      }).then(responce => {
        console.log(responce)
        this.ok = true
        this.error = false
        setTimeout(this.$router.go(this.$router.currentRoute), 2000)
      }).catch(errors => {
        this.error = true
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