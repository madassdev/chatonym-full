<template>
  <div
    class="feed rounded-xl bg-cha-secondary m-3 my-1 p-3"
    id="feed-placeholder"
  >
    <!-- <div class="feed-body mb-1 max-sh-40 zoverflow-hidden relative">
        <FeedImage
          @imageClicked="imageClicked"
          v-if="image"
          :image_url="image"
        /> -->
    <div
      class="text w-full mx-auto p-3 rounded-xl max-h-24 md:max-h-40 overflow-scroll"
    >
      <p class="font-light text-sm feed-message" v-html="feed.message">
        {{ feed.message }}
      </p>
      <p class="font-light text-sm feed-message">
        {{ feed.id }}
      </p>
      <p
        class="font-light text-gray-500 text-xs-10 flex items-center space-x-1 mt-1"
      >
        <i class="mdi mdi-circle text-gray-400" style="font-size: 4px"></i>
        <span class="feed-date">
          {{ feed.created_at | moment("calendar") }}
        </span>
      </p>
    </div>
    <button class="p-1 bg-cha-primary" @click="unmock">Load</button>

  </div>
</template>

<script>
export default {
  props: ["feed"],
  mounted() {},
  methods:{
      unmock(){
          this.$emit('unmock', this.feed.id)
      }
  }
};
</script>
