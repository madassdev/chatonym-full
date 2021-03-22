
<template>
  <div>
    <div
      v-for="reply in replies"
      v-bind:key="reply.id"
      class="reply-template w-5/6 mx-auto px-4 my-1 border-l border-gray-300 hiddden"
    >
      <div class="w-full h-24 mb-2 overflow-hidden">
        <FeedImage
          @imageClicked="imageClicked"
          v-if="image"
          :image_url="image"
        />
        <MockImage
          v-if="hasMockImage"
          :image="reply.mock_image"
          :spin="feed.is_uploading"
        />
      </div>
      <p
        class="font-light truncate-2 text-gray-600 text-xs-12 leading-1 reply-text"
      >
        {{ reply.message }}
      </p>
      <p
        class="font-light text-gray-400 text-xs-10 flex items-center space-x-1"
      >
        <i class="mdi mdi-circle text-gray-400" style="font-size: 4px"></i>
        <span class="reply-date">
          {{ reply.created_at | moment("calendar") }}
        </span>
      </p>
    </div>
  </div>
</template>
<script>
const default_layout = "default";
import Spinner from "./Spinner";
export default {
  computed: {
    // imageFromObject: function () {
    //   if (this.image !== null) {
    //     return URL.createObjectURL(this.image);
    //   }
    // },
  },
  props: ["image", "spin"],
  data() {
    return {};
  },
  components: {
    Spinner,
  },
  methods: {
    imageClicked() {
      this.$emit("imageClicked", this.image_url);
    },
  },
};
</script>