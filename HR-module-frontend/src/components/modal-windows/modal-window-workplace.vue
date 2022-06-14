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
              <div v-if="error" class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>При изменении данных произошла ошибка!</strong> Возможно данное рабочее место уже занято или за вами уже закреплено место.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
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
                  {{this.office.workplaces.RoomInTheOffice}}
                </div>
              </div>
              <div v-if="this.office.workplaces.showUser" class="row">
                <div class="col">
                  <div class="col">ФИО</div>
                  <div class="col">Должность</div>
                  <div class="col">Контакты</div>
                </div>
                <div class="col">
                  <div class="row-col">
                    {{this.office.workplaces.user.firstname }} {{this.office.workplaces.user.lastname}} {{this.office.workplaces.user.patronymic}}
                  </div>
                  <div class="col">{{this.office.workplaces.user.position}}</div>
                  <div class="col">

                  </div>
                </div>
              </div>
              <div v-else class="col">
                <button @click="setPlace()" class="mt-4 btn btn-outline-primary">Занять место</button>
              </div>
              <div v-if="isUser" class="row"><button @click="unsetPlace()" class="btn btn-outline-danger">Удалить</button></div>
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
      error:"",
      office: {
        name:"",
        floor:"",
        workplaces:{
            id:0,
            RoomInTheOffice: 0,
            user:{
              username:"",
              dateofhiring: ' ',
              firstname:'',
              lastname:'',
              patronymic:'',
              position:'',
              contacts: {},
            },
            showUser : false,
      },
      },
      place: 0,
      isUser:"",
      setUsername:"",
      userHR:false
    }
  },
  created() {
    let roles = JSON.parse(localStorage.getItem('roles'))
    for (let i in roles){
      if (roles[i] === "ROLE_HR"){
        this.userHR = true
      }
    }
  },
  methods: {
    close() {
      this.setUsername = ""
      this.error = false
      this.isUser = false
      this.$emit('close');

    },
    setPlace() {
      axios.post(`http://localhost:84/api/v1/offices/set/workplace/${this.office.workplaces.id}`,{
        'username':localStorage.getItem('username')
      }).then(response => {
        console.log(response.data)
      }).catch(errors =>{
        if (errors.request.status === 400) {
          this.error = true

        }
        if (errors.request.status === 401) {
          //this.$router.go('/login')
        }
        if (errors.request.status >= 500) {
          //this.$router.go(`/error/${errors.request.status}`)
        }
      })
    },
    unsetPlace() {
      axios.post(`http://localhost:84/api/v1/offices/unset/workplace/${this.office.workplaces.id}`,{}).then(response => {
        console.log(response.data)
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