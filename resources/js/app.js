import Vue from 'vue'
import VueAwesomeSwiper from 'vue-awesome-swiper';
import VueAxios from 'vue-axios'
import axios from 'axios'
import 'jquery'

require('./bootstrap');

import HomepageSlider from './components/HomepageSlider.vue';
import AdvertiseBoxs from './components/AdvertiseBoxs.vue';
import LastesTvShow from './components/LastesTvShow.vue';
import SpecialTvShow from './components/SpecialTvShow.vue';
import HomePageTvShows from './components/HomePageTvShows.vue';
import TvShows from './components/TvShows.vue';
import EpisodePlayer from './components/EpisodePlayer.vue';

Vue.component('pagination', require('laravel-vue-pagination'));
Vue.use(VueAxios, axios)
Vue.use(VueAwesomeSwiper);

Vue.prototype.$api = function (endpoint) {
  let ur = document.querySelector('meta[name="app_url"]').getAttribute('content') + "/api/v1/";
  return ur + endpoint;
};
Vue.prototype.$asestUrl = function (endpoint) {
  let ur = document.querySelector('meta[name="app_url"]').getAttribute('content') + "/assest/";
  return ur + endpoint;
};
Vue.component('homepage-slide', HomepageSlider);
Vue.component('advertise-boxs', AdvertiseBoxs);
Vue.component('lastes-tv-shows', LastesTvShow);
Vue.component('special-tv-shows', SpecialTvShow);
Vue.component('homepage-tv-shows', HomePageTvShows);
Vue.component('tv-shows', TvShows);
Vue.component('episode-player', EpisodePlayer);



const app = new Vue({
  el: '#app',
});
