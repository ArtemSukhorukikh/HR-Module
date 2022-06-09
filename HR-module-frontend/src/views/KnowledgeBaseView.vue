<template>
  <FullNavbar/>
  <div class="container-lg">
    <div class="row">
      <div class="col-3">
        Список
      </div>
      <div class="col">
        Иформация<p/>
        qwe
      </div>
    </div>
  </div>


</template>

<script>
import FullNavbar from "@/components/Navbars/FullNavbar";
import axios from "axios";
export default {
  name: "KnowledgeBase",
  components: {FullNavbar},
  data() {
    return {
      info: null
    };
  },
  beforeCreate() {
    // let config = {
    //   headers: {
    //
    //   }
    // }
    axios
        .get("http://localhost:84/api/v1/educationalResources/all",)
        .then(response => (this.info = response));
    console.log()
  }
}
</script>

<style scoped>

</style>