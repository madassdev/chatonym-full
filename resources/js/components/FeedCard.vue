
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
        <MockImage
          v-if="hasMockImage"
          :image="feed.mock_image"
          :spin="feed.is_uploading"
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
        <div class="replies" v-if="!feed.is_mock" @click="replyClicked">
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
      <TextInput
        v-if="is_replying"
        @mediaSelected="mediaSelected"
        @sendClicked="replySubmitted"
      />
      <div class="feed-replies">
        <div class="replies-container flex flex-col space-y-2">
          <FeedReply
            v-for="reply in replies"
            v-bind:key="reply.id"
            :reply="reply"
            @imageClicked="imageClicked"
          />
        </div>
        <div
          class="see-more hiddden mx-auto w-3/4"
          v-if="!feed.is_mock && this.replies.length > 0"
        >
          <a href="#" class="text-cha-primary text-xs">See more...</a>
        </div>
      </div>
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
import TextInput from "../components/TextInput";
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
  props: ["feed", "finder"],
  data() {
    return {
      replies: Array.isArray(this.feed.replies)
        ? this.feed.replies.slice(0, 2)
        : [],
      is_replying: false,
      reply_message: "",
    };
  },
  created() {},
  mounted() {
  },
  components: {
    FeedImage,
    Reaction,
    FeedReply,
    MockImage,
    TextInput,
  },
  methods: {
    reactToFeed(reaction) {
      var reaction_made = this.$store.dispatch("reactToFeed", {
        feed: this.feed,
        reaction: reaction,
      });
    },
    imageClicked(image_url) {
      this.$emit("imageClicked", image_url);
    },
    replyClicked() {
      if (!auth) {
        doLogin();
        return;
      }
      this.is_replying = true;
    },
    async saveReply(reply) {
      this.is_replying = false;
      var store = this.$store;
      var feed = this.feed
      var saved_reply = reply;
      var replies = this.replies;
      if (reply.is_uploading) {
        replies.unshift(saved_reply);
        var cloudinary_image_url = await this.$store
          .dispatch("uploadToCloudinary", {
            image: reply.mock_image,
          })
          .then(async (uploaded_image) => {
            Object.assign(
              replies.find((rep) => rep.id === saved_reply.id),
              { is_uploading: false }
            );
            //send to backend
            store.dispatch('replyToFeed',{
                feed:feed,
                message:saved_reply.message,
                image_url:uploaded_image,
            })
          });
      } else {
        await this.$store.dispatch("replyToFeed", {
          feed: this.feed,
          message: reply.message,
        });
        this.replies.unshift(saved_reply);
        this.feed.replies.push(saved_reply);
      }
    },
    async replySubmitted(payload) {
      if (payload.message !== "") {
        const timestamp = Date.now();
        const mock_reply = {
          id: timestamp,
          message: payload.message,
          created_at: timestamp,
          is_mock: true,
          mock_image: null,
          is_uploading: false,
        };
        // const image_url = [];
        this.saveReply(mock_reply);
      }

    },
    saveReplyMedia(caption, media) {
      if (caption !== "") {
        const timestamp = Date.now();
        const mock_reply = {
          id: timestamp,
          message: caption,
          created_at: timestamp,
          is_mock: true,
          mock_image: media,
          is_uploading: true,
          mock_image: media,
          is_uploading: media !== null,
        };
        this.saveReply(mock_reply);
      }
    },
    mediaSelected(payload) {
      this.openMediaModal(payload.message, payload.media, {
        type: "feedReply",
        ref: this.finder,
      });
    },
    openMediaModal(caption, media, intent) {
      this.mediaCaption = caption;
      this.mediaObject = media;
      this.$store.dispatch("openMediaModal", {
        media: media,
        caption: caption,
        intent: intent,
      });
    },
  },
};
</script>