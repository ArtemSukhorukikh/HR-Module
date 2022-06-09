<template>
  <FullNavbar/>
  <ul>
    <li v-for="item in educationResourcesAll " v-bind:key="item">
      <div>{{ item['competence'] }}</div>
    </li>
  </ul>

  <div class="container">
    <div>{{educationResourcesAll}}</div>

    <div class="accordion" id="accordionExample">



      <ul>
        <li v-for="item in educationResourcesAll" v-bind:key="item">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                {{ item.competence }}
              </button>
            </h2>

            <ul>
              <li v-for="item_ in item.educationResourcesCompetence" v-bind:key="item_">
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <div>{{ item_.name }}//</div>
                  </div>
                </div>
              </li>
            </ul>

          </div>
        </li>
      </ul>


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
      "educationResourcesAll":
        {}

    };
  },
  beforeCreate() {
    axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
    axios
        .get("http://localhost:84/api/v1/educationalResources/all",)
        .then(response => {
          this.educationResourcesAll = response.data
          console.log(this.educationResourcesAll)
        });

  },
  beforeUpdate() {
    console.log(this.educationResourcesAll)
  }
}
</script>

<style scoped>

</style>