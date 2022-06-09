<template>
  <ProfilePage v-bind:currentUser = "false"  v-bind:userName = "this.$route.params.id"/>
</template>

<script>
import ProfilePage from "@/components/ProfilePage";
export default {
  name: "UserView",
  components: {ProfilePage},
}
</script>

<style scoped>

</style>