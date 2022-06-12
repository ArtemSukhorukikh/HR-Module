<template>
  <transition>
    <div class="modal-backdrop">
      <div  class=" modal">
        <header class="modal-header">
          <slot name="header">
            Создание отызва

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
              <div class="form-floating mb-3">
                <textarea type="text" class="form-control" id="floatingInput" v-model="feedback" placeholder="Отзыв" required/>
                <label for="floatingInput">Отзыв</label>
              </div>
              <select class="form-select form-select-sm" aria-label=".form-select-sm example " v-model="estimation">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
              <div class="mb-3 d-flex justify-content-center">
                <button class="btn btn-outline-primary" @click="sendFeedback()">Добавить отзыв</button>
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
import moment from "moment";
export default {
  name: "modal-window-feedback",
  data: function () {
    return {
      show: false,
      error: false,
      ok:"",
      id:"",
      feedback:"",
      estimation:"",
      educationResources:"",



    }
  },
  methods: {
    sendFeedback(){
      let date;
      date = new Date()
      let date_ = moment(date).format("YYYY-MM-DD")
      let userId =  localStorage.getItem('userId')
      axios.post(`http://localhost:84/api/v1/feedback/new`,{
        user_id: userId,
        educational_resources_id: this.educationResources,
        estimation: this.estimation,
        note: this.feedback,
        date: date_
      }).then(responce => {
        console.log(responce)
        setTimeout(this.$router.go(), 2000)
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