<template>
  <div
    class="bg-gradient-to-br from-blue-700 via-70% via-red-300 to-orange-400 w-screen h-screen flex flex-col items-center justify-center"
  >
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
  </div>
</template>

<script>
export default {
    name: 'HomePage',
}
</script>
