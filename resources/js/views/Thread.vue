<template>
  <div>
    <section
      class="fixed hiddesn top-12 shadow-lg thread-info p-4 px-8 duration-300 w-full bg-gray-50 z-10"
    >
      <p class="text-xl font-black text-cha-primary">{{ appThread.name }}</p>
      <p class="text-xs text-gray-500">{{ appThread.description }}</p>
      <!-- <div class="icons text-cha-primary my-3">
        <i class="mdi mdi-message-text-outline"></i>
        <span class="text-xs">
          {{ appThread.messages_count }}
        </span>
      </div> -->
    </section>
    <div class="main-vh h-screen pb-20">
      <section class="overflow-y-scroll h-full pt-40" id="messagesViewport">
        <Spinner v-if="loadingThreadMessages" :text="'Loading messages..'" />
        <ThreadMessageCard
          v-for="threadMesasge in threadMessages"
          :key="threadMesasge.id"
          :feed="threadMesasge"
          @imageClicked="openImageModal"
          @replyClicked="replyClicked"
        />
        <!-- <ThreadCard/> -->
        <ImageModal :image_url="modal_image_url" />
        <MediaUploadModal
          :message="messageMediaText"
          :image="mediaImageObject"
        />
        <div id="bottom" class="bottom"></div>
      </section>
      <div class="fixed z-20 bottom-0 w-full md:w-1/2 reply-chat text-white">
        <div class="wrap p-1 bg-cha-secondary w-full">
          <div
            v-if="is_replying"
            class="relative h-16 overflow-hidden p-3 mb-2 bg-gray-200 border-purple-800 border-l-4 rounded"
          >
            <p class="text-xs text-gray-500" v-html="is_replying.message">
              {{ is_replying.message }} {{ is_replying.message }}
            </p>
            <span
              @click="replyCanceled"
              class="absolute cursor-pointer rounded-full p-1 bg-black h-3 w-3 flex items-center justify-center right-1 top-1"
            >
              <i class="mdi mdi-close text-xs"></i>
            </span>
          </div>
          <div
            class="w-full mx-auto rounded-full flex items-center mb-1 md:space-x-1 space-x-2"
          >
            <div
              class="textarea flex space-x-4 items-center pr-3 w-full rounded-full bg-white"
            >
              <textarea
                name=""
                ref="replyInput"
                v-model="reply_message"
                id="reply-message"
                cols="30"
                class="shadow-lg px-4 py-1 text-xs text-gray-600 border-0 resize-none rounded-full w-full placeholder-gray-400"
                placeholder="Write something.."
              ></textarea>
              <i
                class="mdi mdi-camera text-xl hiddens cursor-pointer text-gray-400"
              ></i>
              <i
                @click="replySubmitted"
                class="mdi mdi-send text-xl text-cha-primary cursor-pointer reply-send"
              ></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
var app_url = $("head base").attr("href");
var feeds_url = "https://chatonym.dv";
const default_layout = "default";
import Spinner from "../components/Spinner";
import ThreadMessageCard from "../components/ThreadMessageCard";
import ImageModal from "../components/ImageModal";
import NewFeed from "../components/NewFeed";
import MediaUploadModal from "../components/MediaUploadModal";
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters([
      "appThread",
      "appUser",
      "threadMessages",
      "loadingThreadMessages",
      "shouldFetchThreadMessages",
      "nextThreadMessagesUrl",
    ]),
  },
  data() {
    return {
      is_replying: false,
      reply_message: null,
      modal_image_url: "/img/placeholders/smileys.jpg",
      messageMediaText: "",
      mediaImageObject: null,
    };
  },
  async mounted() {
    this.scrollPageDown();
    var v = this;
    await this.$store.dispatch("fetchThreadMessages").then(() => {
      v.scrollToFeedsBottom();
    });
    var scroll = this.handleScroll;
    $("#messagesViewport").scroll(function () {
      scroll();
    });
    $(messagesViewport).on('touchmove' ,scroll())
  },
  components: {
    Spinner,
    ThreadMessageCard,
    ImageModal,
    NewFeed,
    MediaUploadModal,
  },
  destroyed() {
    window.removeEventListener("scroll", this.handleScroll);
  },
  methods: {
    async sendClicked(message) {
      var message_data = {
        message: message,
      };
      await this.$store.dispatch("saveNewFeed", message_data);
    },
    scrollPageDown() {
      $("html, body").animate({ scrollTop: $(document).height() }, 500);
    },
    async handleScroll(event) {
      var scrollPosition = new ScrollPosition(
        document.getElementById("messagesViewport")
      );
      if (
        $("#messagesViewport").scrollTop() == 0 &&
        this.shouldFetchThreadMessages
      ) {
        this.$store.commit("setLoadingThreadMessages", true);
        scrollPosition.prepareFor("up");
        var store = this.$store;
        setTimeout(async function () {
          await store.dispatch("fetchMoreThreadMessages").then(() => {
            scrollPosition.restore();
            store.commit("setShouldFetchThreadMessages", true);
          });
        }, 200);
        this.$store.commit("setShouldFetchThreadMessages", true);
        if (this.nextThreadMessagesUrl === null) {
          this.$store.commit("setShouldFetchThreadMessages", false);
        }
      }
    },
    openImageModal(image_url) {
      if (!auth) {
        doLogin();
      } else {
        this.modal_image_url = image_url;
        MicroModal.show("feed-open-modal");
      }
    },
    openUploadModal(message, image) {
      this.messageMediaText = message;
      this.mediaImageObject = image;
      var reset = this.resetModal;
      MicroModal.show("media-upload-modal", {
        onClose: function (modal) {
          reset();
        },
      });
    },
    resetModal() {
      this.$refs.newFeed.resetFile();
    },
    replyClicked(feed) {
      $(".main-vh").removeClass("pb-20").addClass("pb-36");
      this.scrollPageDown();
      this.$refs.replyInput.focus();
      this.is_replying = feed;
    },
    replyCanceled() {
      $(".main-vh").removeClass("pb-36").addClass("pb-20");
      this.is_replying = false;
      this.$refs.replyInput.focus();
    },
    scrollToFeedsBottom(duration = 0) {
      $("#messagesViewport").animate(
        { scrollTop: $("#messagesViewport")[0].scrollHeight },
        duration
      );
    },
    async replySubmitted() {
      if (this.reply_message) {
        var v = this;
        await this.$store
          .dispatch("sendNewThreadMessage", {
            message: this.reply_message,
            replying: this.is_replying,
          })
          .then(() => {
            v.scrollToFeedsBottom();
          });
        this.replyCanceled();
        this.reply_message = null;
      }
    },
  },
};
</script>