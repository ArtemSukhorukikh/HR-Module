<template>
  <div class="modal-backdrop">
    <div  class="w-25 modal">
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
          {{this.office.name}}
        </slot>
      </section>
    </div>
  </div>
</template>

<script>
export default {
  name: "modal-window-workplace",
  data: function () {
    return {
      show: false,
      office: [],
      place: [],
    }
  },
  methods: {
    close() {
      this.$emit('close');
    },
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