<template>
  <swiper :options="swiperOption" class="advertise-slides">
    <swiper-slide v-for="(slide, index) in slides" :key="index">
      <a v-if="slide.link != null" class="ads ads-item" :href="slide.link">
        <img :src="slide.image" />
      </a>
      <a v-else class="ads ads-item" :to="site_url">
        <img :src="slide.image" />
      </a>
    </swiper-slide>
  </swiper>
</template>

<script>
export default {
  name: "advertise-boxs",
  data() {
    return {
      swiperOption: {
        speed: 600,
        slidesPerView: 3,
        spaceBetween: 10,
      },
      slides: [],
    };
  },
  mounted() {
    this.getData();
  },
  methods: {
    getData() {
      let promise = this.axios.get(this.$api("ads"));
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
