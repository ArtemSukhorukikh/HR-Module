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
                <input type="text" class="form-control" id="floatingInput" v-model="link" placeholder="Телеграм" required>
                <label for="floatingInput">Ресурс</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" v-model="source" placeholder="@yournickname" required>
                <label for="floatingInput">Имя</label>
              </div>
              <div class="row-cols-2 d-flex justify-content-center">
                <div class="mb-3 ">
                  <button class="btn btn-outline-primary" @click="updateContactInfo">Сохранить</button>
                </div>
                <div class="mb-3">
                  <button class="btn btn-outline-danger" @click="deleteContactInfo">Удалить</button>
                </div>
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
  name: "modal-window-contact-form",
  data: function () {
    return {
      id:"",
      method:"",
      show: false,
      error: false,
      ok:"",
      username:"",
      link:"",
      source:""
    }
  },
  methods: {
    deleteContactInfo(){
      axios.post(`http://localhost:84/api/v1/contacts/delete/${this.id}`,{
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
    updateContactInfo(){
        axios.post(`http://localhost:84/api/v1/contacts/${this.method}`,{
          id:this.id,
          username: this.username,
          link: this.link,
          sourse: this.source,
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