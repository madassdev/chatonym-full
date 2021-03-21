
<template>
  <div
    @click="imageClicked"
    class="image cursor-pointer my-2 w-5/6 m:w-2/3 mx-auto flex items-center justify-center hiddesn"
  >
    <img
      :src="image_url"
      class="rounded-2xl feed-img object-cover h-44 w-full"
      alt=""
      srcset=""
    />
  </div>
</template>
<script>
const default_layout = "default";

export default {
  computed: {},
  props: ["image_url"],
  data() {
    return {};
  },
  methods:{
      imageClicked(){
          this.$emit('imageClicked', this.image_url)
      }
  }
};
</script>