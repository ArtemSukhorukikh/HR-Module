<template>
  <div id="floor3">
    <img class="d-flex justify-content-center mx-lg-auto" src="../assets/img/Floor3Full.png">
    <div class="position-absolute part" style="
      margin-left: 94rem;
      top: 8rem;
    "><button class="w-100 h-100 button-part"></button></div>
  </div>
</template>

<script>
export default {
  name: "OfficeMapFloor3View"
}
</script>

<style scoped>
  .part {
    box-sizing: border-box;
    width: 65px;
    height: 65px;
    border: 1px solid #000000;
  }
  .button-part {

    background: transparent;
    border: none !important;
    font-size:0;
  }
</style>