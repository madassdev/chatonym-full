
<template>
  <div
    class="relative image cursor-pointer my-2 w-5/6 m:w-2/3 mx-auto flex items-center justify-center hiddesn"
  >
    <img
      :src="imageFromObject"
      class="rounded-2xl feed-img object-cover h-44 w-full"
      alt=""
      srcset=""
    />
    <div
    v-if="spin"
      class="absolute rounded-2xl flex items-center justify-center h-full w-full bg-black bg-opacity-40"
    >
      <Spinner text="" color="h-8 w-8 text-white"/>
    </div>
  </div>
</template>
<script>
const default_layout = "default";
import Spinner from "./Spinner";
export default {
  computed: {
    imageFromObject: function () {
      if (this.image !== null) {
        return URL.createObjectURL(this.image);
      }
    },
  },
  props: ["image", "spin"],
  data() {
    return {};
  },
  components:{
      Spinner
  },
  methods: {
    imageClicked() {
      this.$emit("imageClicked", this.image_url);
    },
  },
};
</script>