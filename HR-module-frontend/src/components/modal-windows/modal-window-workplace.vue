<template>
  <transition>
    <div class="modal-backdrop">
      <div  class=" modal">
        <header class="modal-header">
          <slot name="header">
            Информация о рабочем месте

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
              <div class="row">
                <div class="col">
                  Название офиса:
                </div>
                <div class="col">
                  {{this.office.name}}
                </div>
              </div>
              <div class="row">
                <div class="col">
                  Этаж:
                </div>
                <div class="col">
                  {{this.office.floor}}
                </div>
              </div>
              <div class="row">
                <div class="col">
                  Номер рабочего места:
                </div>
                <div class="col">
                  {{this.office.workplaces[this.place].RoomInTheOffice}}
                </div>
              </div>
              <div v-if="this.office.workplaces[this.place].user" class="row">
                <div class="col">
                  <div class="col">ФИО</div>
                  <div class="col">Должность</div>
                  <div class="col">Контакты</div>
                </div>
                <div class="col">
                  <div class="col">
                    {{this.office.workplaces[this.place].user.userInfo.firstname}} {{this.office.workplaces[this.place].user.userInfo.lastname}} {{this.office.workplaces[this.place].user.userInfo.patronymic}}
                  </div>
                  <div class="col">{{this.office.workplaces[this.place].user.userInfo.position}}</div>
                  <div class="col">

                  </div>
                </div>
              </div>
              <div v-else class="row">
                <div class="col">
                  <button @click="setPlace()" class="mt-4 btn btn-outline-primary">Занять место</button>
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
  name: "modal-window-workplace",
  data: function () {
    return {
      show: false,
      office: {
        workplaces:[{
            id:0,
            RoomInTheOffice: 0,
            user:{}
      }]
      },
      place: 0,
    }
  },
  methods: {
    close() {
      this.$emit('close');
    },
    setPlace() {
      axios.post(`http://localhost:84/api/v1/offices/set/workplace/${this.office.workplaces[this.place].id}`,{}).then(response => {
        console.log(response.data)
        this.$router.go('/officemap/floor2')
      }).catch(errors =>{
        if (errors.request.status === 401) {
          this.$router.go('/login')
        }
        if (errors.request.status >= 500) {
          this.$router.go(`/error/${errors.request.status}`)
        }
      })
    }
  },
}
</script>

<style scoped>
.modal-backdrop {
  width: 500px !important;
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
  width: 30%;
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