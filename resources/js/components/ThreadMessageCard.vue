
<template>
  <div>
    <div
      class="feed rounded-r-xl rounded-bl-xl bg-cha-secondary m-3 my-1 p-3"
      id="feed-placeholder"
    >
      <div
        v-if="feed.parent !== null"
        class="h-16 overflow-scroll p-3 mb-2  border-purple-300 border-l-4 rounded rounded-r-xl"
      >
        <p class="text-xs font-bold text-gray-400" v-html="feed.parent.message">{{feed.parent.message}}</p>
      </div>
      <div class="feed-body mb-1 max-sh-40 zoverflow-hidden relative">
        <FeedImage
          @imageClicked="imageClicked"
          v-if="image"
          :image_url="image"
        />
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
              {{ feed.created_at | moment("LT - MMM DD, YYYY") }}
            </span>
          </p>
        </div>
      </div>
      <div
        class="w-full my-2 text-xs text-gray-600 mx-auto feed-footer flex items-center px-3"
      >
        <Reaction
          :reaction="feed.reacted_by_user"
          @reactionMade="reactToFeed"
          :count="feed.reactions_count"
        />
        <div class="replies">
          <span
            @click="replyClicked"
            class="cursor-pointer text-cha-primary feed-comments-link flex items-center space-x-1"
          >
            <i class="mdi mdi-reply text-lg"></i>
            <span> Reply </span>
          </span>
        </div>
      </div>

      <FeedReply v-if="replies" :replies="replies" />
    </div>
  </div>
</template>
<script>
import FeedImage from "../components/FeedImage";
import Reaction from "../components/Reaction";
import FeedReply from "../components/FeedReply";
import MicroModal from "micromodal";

const default_layout = "default";

export default {
  computed: {
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
        : false,
    };
  },
  components: {
    FeedImage,
    Reaction,
    FeedReply,
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
    replyClicked() {
      this.$emit("replyClicked", this.feed);
    },
  },
};
</script>