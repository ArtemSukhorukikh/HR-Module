<template>
  <FullNavbar/>
  <ProfilePage v-bind:currentUser = "false"  v-bind:userName = "this.$route.params.id"/>
</template>

<script>
import ProfilePage from "@/components/ProfilePage";
import FullNavbar from "@/components/Navbars/FullNavbar";
export default {
  name: "UserView",
  components: {FullNavbar, ProfilePage},
}
</script>

<style scoped>

</style>