<template>
  <div></div>
</template>

<script>
export default {
  name: "LogOut",
  created() {
    localStorage.removeItem('token')
    localStorage.removeItem('date')
    localStorage.removeItem('roles')
    localStorage.removeItem('username')
    localStorage.removeItem('id')
    this.$router.go('/login')
  }
}
</script>

<style scoped>

</style>