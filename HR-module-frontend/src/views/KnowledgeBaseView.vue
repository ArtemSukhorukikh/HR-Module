<template>
  <FullNavbar/>
  <div class="container">


    <div class="accordion" id="accordionExample">
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            #1
          </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            <div>qwe</div>
          </div>
        </div>
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
    console.log(localStorage.getItem('token'));
    axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
    axios
        .get("http://localhost:84/api/v1/educationalResources/all",)
        .then(response => (this.info = response));
    console.log(this.info)
  }
}
</script>

<style scoped>

</style>