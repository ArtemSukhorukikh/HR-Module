<template>
  <div></div>
</template>

<script>
export default {
  name: "LogOut",
  created() {
    localStorage.removeItem('token')
    localStorage.removeItem('date')
    this.$router.go('/login')
  }
}
</script>

<style scoped>

</style>