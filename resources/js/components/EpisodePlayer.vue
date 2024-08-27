<template>
  <!-- <div class="player-container">
    <vue-core-video-player v-if="episode" :src="episode"></vue-core-video-player>
  </div> -->

  <!-- <div class="player-container">
      <vue-core-video-player v-if="episode" :core="HLSCore" :src="episode"></vue-core-video-player>
    </div> -->

  <div>
    <video ref="videoPlayer" class="video-js"></video>
  </div>
</template>

<script>
import HLSCore from "@core-player/playcore-hls";
import videojs from 'video.js';
export default {
  name: "episode-player",
  props: {
    episode: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      HLSCore,
      player: null,
      videoOptions: {
				autoplay: true,
				controls: true,
				sources: [
					{
						src:
							this.episode,
						  type: "video/mp4"
					}
				]
			}
    };
  },
  mounted() {
    this.player = videojs(this.$refs.videoPlayer, this.videoOptions, function onPlayerReady() {
      console.log("onPlayerReady", this);
    });
  },
  methods: {
    errorHandle(e) {
      console.error(e.code);
    },
  },
  beforeDestroy() {
    if (this.player) {
      this.player.dispose();
    }
  },
};
</script>
