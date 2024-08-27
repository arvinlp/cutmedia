<template>
  <swiper :options="swiperOption" class="homepage-slides">
    <swiper-slide v-for="(slide, index) in slides" :key="index">
      <img :src="slide.image" />
    </swiper-slide>
    <div class="swiper-button-prev swiper-button-white"></div>
    <div class="swiper-button-next swiper-button-white"></div>
  </swiper>
</template>

<script>
export default {
  name: "homepage-slide",
  data() {
    return {
      swiperOption: {
        autoplay: {
          delay: 2500,
        },
        speed: 600,
        parallax: true,
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
      },
      slides: [],
    };
  },
  mounted() {
    this.getData();
  },
  methods: {
    getData() {
      let promise = this.axios.get(this.$api("slides"));
      console.log(this.$api("slides"));
      promise
        .then((response) => {
          this.slides = response.data;
          return response;
        })
        .catch((error) => {
          return error;
        });
    },
  },
};
</script>
