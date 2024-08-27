<template>
  <div v-if="shows" class="container-fluid">
    <div class="row">
      <div v-for="(show, i) in shows" v-bind:key="i" class="col-12">
        <div class="homepage tv-show" v-if="show.last_episodes.length > 0">
          <div v-if="show.cover" class="cover">
            <img :src="show.cover" :alt="show.name" />
          </div>
          <div class="homepage-title">
            <a :href="show.link" hreflang="fa"
              ><h2>{{ show.name }}</h2></a
            >
          </div>
          <swiper
            v-if="show.cover"
            :options="swiperOption"
            class="tv-show-slides tv-show-have-cover"
          >
            <swiper-slide v-for="(slide, index) in show.last_episodes" :key="index">
              <a class="tv-shows item" :href="slide.link">
                <img :src="slide.thumb" />
                <div class="info">
                  <span class="name">{{slide.name}}</span>
                  <span class="watch">مشاهده این قسمت</span>
                </div>
              </a>
            </swiper-slide>
          </swiper>
          <swiper v-else :options="swiperOption" class="tv-show-slides">
            <swiper-slide v-for="(slide, index) in show.last_episodes" :key="index">
              <a class="tv-shows item" :href="slide.link">
                <img :src="slide.thumb" />
                <div class="info">
                  <span class="name">{{slide.name}}</span>
                  <span class="watch">مشاهده این قسمت</span>
                </div>
              </a>
            </swiper-slide>
          </swiper>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "tv-shows",
  data() {
    return {
      swiperOption: {
        slidesPerView: 5,
        spaceBetween: 10,
      },
      shows: [],
    };
  },
  mounted() {
    this.getData();
  },
  methods: {
    getData() {
      let promise = this.axios.get(this.$api("tv/all"));
      promise
        .then((response) => {
          this.shows = response.data.data;
          return response;
        })
        .catch((error) => {
          return error;
        });
    },
  },
};
</script>
