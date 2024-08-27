<template>
  <swiper :options="swiperOption" class="special-slides">
    <swiper-slide v-for="(slide, index) in slides" :key="index">
      <a class="tv-shows item" :href="slide.link">
        <img :src="slide.thumb" />
        <div class="info">
          <span class="name">{{ slide.name }}</span>
          <span class="watch">مشاهده این قسمت</span>
        </div>
      </a>
    </swiper-slide>
  </swiper>
</template>

<script>
export default {
  name: "special-tv-shows",
  data() {
    return {
      swiperOption: {
        slidesPerView: 5,
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
      let promise = this.axios.get(this.$api("tv/special"));
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
