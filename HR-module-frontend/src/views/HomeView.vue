<template>
  <FullNavbar/>
  <div class="home">
    <ProfilePage v-bind:current-user="true"></ProfilePage>
  </div>
</template>

<script>
// @ is an alias to /src
import FullNavbar from "@/components/Navbars/FullNavbar";
import ProfilePage from "@/components/ProfilePage";
export default {
  name: 'HomeView',
  components: {
    ProfilePage,
    FullNavbar,
  }
}
</script>
