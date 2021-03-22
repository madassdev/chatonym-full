<template>
  <div
    class="reply-template w-5/6 mx-auto px-4 my-1 border-l border-gray-300 hiddden"
  >
    <div class="w-full h-24 mb-2 overflow-hidden" v-if="image || hasMockImage">
      <MockImage
        v-if="hasMockImage"
        :image="reply.mock_image"
        :spin="reply.is_uploading"
      />
      <FeedImage
        @imageClicked="imageClicked"
        :image_url="image"
        v-if="image"
      />
    </div>
    <p
      class="font-light truncate-2 text-gray-600 text-xs-12 leading-1 reply-text"
    >
      {{ reply.message }}
    </p>
    <p class="font-light text-gray-400 text-xs-10 flex items-center space-x-1">
      <i class="mdi mdi-circle text-gray-400" style="font-size: 4px"></i>
      <span class="reply-date">
        {{ reply.created_at | moment("calendar") }}
      </span>
    </p>
  </div>
</template>

<script>
import FeedImage from "./FeedImage";
import MockImage from "./MockImage";
export default {
  props: ["reply"],
  computed: {
    image: function () {
      if (
        this.reply.image_url !== null &&
        Array.isArray(this.reply.image_url) &&
        this.reply.image_url.length > 0 &&
        typeof this.reply.image_url[0] === "object" &&
        "url" in this.reply.image_url[0]
      ) {
        return this.reply.image_url[0].url;
      }
      return false
    },
    hasMockImage: function () {
      return typeof this.reply.mock_image !== "undefined" && this.reply.mock_image !== null;
      //   return true;
    },
  },
  data() {
    return {};
  },
  mounted() {
    // console.log(this.replies);
  },
  components: {
    FeedImage,
    MockImage,
  },
  methods: {
    imageClicked() {
      this.$emit("imageClicked", this.image);
    },
  },
};
</script>
