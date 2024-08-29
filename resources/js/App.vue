<!-- resources/js/App.vue -->
<template>
  <div id="app">
    <nav class="fixed top-0">
      <div>
        <router-link to="/">
          Home
        </router-link>
      </div>
      <div>
        <router-link to="/game">
          Game
        </router-link>
      </div>
    </nav>
    <main>
      <router-view />
    </main>
  </div>
</template>

<script>
export default {
    name: 'App',
}
</script>

<style></style>
