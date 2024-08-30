<template>
  <picture>
    <source
      srcset="/images/kudosu_logo.webp"
      type="image/webp"
    >
    <source
      srcset="/images/kudosu_logo.png"
      type="image/png"
    >
    <img
      class="w-48 sm:w-56 md:w-64 lg:w-72 2xl:w-96 h-auto object-contain pb-10 hover:scale-105 animate-wiggle duration-200 ease-in-out transition-all"
      alt="Kudosu logo"
    >
  </picture>
  <div class="grid grid-cols-1 gap-4 w-96 px-4 max-w-full">
    <div class="w-full flex items-center justify-center text-white font-bold text-xl lg:text-2xl bg-slate-600/50 hover:bg-slate-500/50 drop-shadow-md hover:shadow-md cursor-pointer transition-all duration-200 ease-in-out rounded-lg ">
      <router-link class="w-full h-full py-4 text-center" to="/play/daily/">
        Daily Challenge
      </router-link>
    </div>
    <div class="w-full flex items-center justify-center text-white font-bold text-xl lg:text-2xl bg-slate-600/50 hover:bg-slate-500/50 drop-shadow-md hover:shadow-md cursor-pointer transition-all duration-200 ease-in-out rounded-lg ">
      <router-link class="w-full h-full py-4 text-center" to="/play/random/">
        Random Challenges
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
    name: 'HomePage',
}
</script>
