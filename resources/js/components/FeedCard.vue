
<template>
  <div>
    <div
      class="feed rounded-xl bg-cha-secondary m-3 my-1 p-3"
      id="feed-placeholder"
    >
      <div class="feed-body mb-1 max-sh-40 zoverflow-hidden relative">
        <FeedImage
          @imageClicked="imageClicked"
          v-if="image"
          :image_url="image"
        />
        <MockImage v-if="hasMockImage" :image="feed.mock_image" :spin="feed.is_uploading" />
        <div
          class="text w-full mx-auto p-3 rounded-xl max-h-24 md:max-h-40 overflow-scroll"
        >
          <p class="font-light text-sm feed-message" v-html="feed.message">
            <!-- {{ feed.message }} -->
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
      </div>
      <div
        class="w-full my-2 text-xs text-gray-600 mx-auto feed-footer flex items-center px-3"
      >
        <Reaction
          v-if="!feed.is_mock"
          :reaction="feed.reacted_by_user"
          @reactionMade="reactToFeed"
          :count="feed.reactions_count"
        />
        <div class="replies" v-if="!feed.is_mock">
          <span
            class="cursor-pointer feed-comments-link flex items-center space-x-1"
          >
            <i
              class="mdi mdi-message-text-outline text-lg text-cha-primary"
            ></i>
            <span
              v-if="feed.replies.length"
              class="replies-icon-count text-cha-primary"
              >{{ feed.replies.length }}</span
            >
          </span>
        </div>
      </div>

      <FeedReply
        v-if="!feed.is_mock && this.replies.length > 0"
        :replies="this.replies"
      />
      <button
        @click="
          addReply({
            id: Math.floor(Math.random() * 100),
            message: 'A very nice buttoned comment my-5',
            created_at: Date.now(),
          })
        "
        v-show="1 != 1"
        class="bg-cha-primary p-2 text-white"
      >
        Add comment
      </button>
    </div>
  </div>
</template>
<script>
import FeedImage from "../components/FeedImage";
import Reaction from "../components/Reaction";
import MockImage from "../components/MockImage";
import FeedReply from "../components/FeedReply";
import MicroModal from "micromodal";

const default_layout = "default";

export default {
  computed: {
    hasMockImage: function () {
      return (
        typeof this.feed.mock_image !== "undefined" &&
        this.feed.mock_image !== null
      );
    },
    image: function () {
      if (
        this.feed.image_url !== null &&
        Array.isArray(this.feed.image_url) &&
        this.feed.image_url.length > 0 &&
        typeof this.feed.image_url[0] === "object" &&
        "url" in this.feed.image_url[0]
      ) {
        return this.feed.image_url[0].url;
      }
    },
  },
  props: ["feed"],
  data() {
    return {
      replies: Array.isArray(this.feed.replies)
        ? this.feed.replies.slice(0, 2)
        : [],
    };
  },
  mounted() {
    //   clog(this.feed.is_mock)
  },
  components: {
    FeedImage,
    Reaction,
    FeedReply,
    MockImage,
  },
  methods: {
    reactToFeed(reaction) {
      //   console.log(
      //     "feed card making reaction: " +
      //       reaction +
      //       " on feed id of:" +
      //       this.feed.id
      //   );
    },
    addReply(reply) {
      this.replies.unshift(reply);
    },
    imageClicked(image_url) {
      this.$emit("imageClicked", image_url);
    },
  },
};
</script>