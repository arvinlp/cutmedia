<template>
  <div v-if="show_second > 0" class="counter_box">
    <div class="c-counter">
      <span>{{ h }}</span
      >:<span>{{ m }}</span
      >:<span>{{ s }}</span>
    </div>
    <span class="fa fa-clock-o"></span>
    <!-- <p class="discount_counter_title">زمان باقی ماننده تا پایان سفارش</p>-->
  </div>
</template>

<script>
export default {
  name: "",
  data() {
    return {
    };
  },
  props: [

  ],
  mounted() {
  },
  methods: {
  },
};
</script>

<style scoped></style>
