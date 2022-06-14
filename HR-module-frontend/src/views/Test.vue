<template>
  <div class='container'>
    <vue-tree
        style="width: 800px; height: 600px; border: 1px solid gray;"
        :dataset="vehicules"
        :config="treeConfig"
        linkStyle="straight"
    >
      <template v-slot:node="{ node, collapsed }">
        <div
            class="rich-media-node"
            :style="{ border: collapsed ? '2px solid grey' : '' }"
        >
          <span style="padding: 4px 0; font-weight: bold;"
          >{{ node.name }}</span
          >
        </div>
      </template>
    </vue-tree>
  </div>
</template>
<script>
import VueTree from "@ssthouse/vue3-tree-chart";
import "@ssthouse/vue3-tree-chart/dist/vue3-tree-chart.css";
import axios from "axios";
export default {
  components: { VueTree },
  name: 'TestTest',
  data() {
    return {
      vehicules: {
      },
      treeConfig: { nodeWidth: 100, nodeHeight: 150, levelHeight: 100 }
    }
  },
  beforeCreate() {
    axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('token')
    axios
        .get("http://localhost:84/api/v1/department")
        .then(response => {
          this.vehicules = response.data
          console.log(this.vehicules)
        });
  },
}
</script>

<style scoped>
.container {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.rich-media-node {
  width: 80px;
  padding: 8px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: center;
  color: white;
  background-color: #f7c616;
  border-radius: 4px;
}
</style>