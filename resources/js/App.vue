<!-- resources/js/App.vue -->
<template>
  <div 
    id="app"
  > 
    <nav class="fixed top-4 left-0 w-full flex items-center justify-between">
      <div class="flex items-center justify-center ">
        <router-link class="w-full h-full px-4  text-center" to="/">
          <svg
            class="fill-white w-10 lg:w-14 p-3 bg-slate-500/50 hover:bg-slate-400/50 drop-shadow-md hover:shadow-md cursor-pointer transition-all duration-200 ease-in-out rounded-lg"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
          ><path d="M20 20C20 20.5523 19.5523 21 19 21H5C4.44772 21 4 20.5523 4 20V11L1 11L11.3273 1.6115C11.7087 1.26475 12.2913 1.26475 12.6727 1.6115L23 11L20 11V20ZM11 13V19H13V13H11Z" /></svg>
        </router-link>
      </div>
      <div class="flex items-center justify-center ">
        <router-link class="w-full h-full px-4 text-center" to="/about">
          <svg
            class="fill-white p-3 w-10 lg:w-14 bg-slate-500/50 hover:bg-slate-400/50 drop-shadow-md hover:shadow-md cursor-pointer transition-all duration-200 ease-in-out rounded-lg"
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 7H13V9H11V7ZM11 11H13V17H11V11Z"></path></svg>
        </router-link>
      </div>
    </nav>
    <main 
      class="bg-gradient-to-br from-blue-700 via-70% via-red-300 to-orange-400 w-screen h-screen flex flex-col items-center justify-center"
    >
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
