
<template>
  <div
    class="modal micromodal-slide"
    id="media-upload-modal"
    aria-hidden="true"
  >
    <div class="modal__overlay md:pb-64" tabindex="-1" data-micromodal-close>
      <div
        class="modal__container p-3 w-full mx-2"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modal-1-title"
      >
        <header class="modal__header text-cha-primary">
          <h2 class="modal__title" id="modal-1-title">Upload media</h2>
          <button
            class="modal__close"
            aria-label="Close modal"
            data-micromodal-close
          ></button>
        </header>
        <main class="modal__content p-3" id="modal-1-content">
          <div class="w-full texting space-y-8 flex flex-col">
            <div
              class="flex items-center justify-center h-36 w-2/3 mx-auto relative"
            >
              <img
                id="media-preview"
                :src="imageFromObject"
                class="h-32 w-full rounded-xl object-cover"
              />
              <span
                data-micromodal-close
                class="media-modal-close cursor-pointer rounded-full -top-1 -right-1 shadow h-4 w-4 absolute bg-gray-800 text-white flex items-center justify-center"
              >
                <i class="mdi mdi-close text-xs-10"></i>
              </span>
              <div
                class="upload-spinner-overlay flex items-center justify-center bg-black opacity-0 absolute w-full h-32 rounded-xl"
              ></div>
              <div
                class="upload-spinner flex items-center justify-center absolute w-full h-32 rounded-xl hidden"
              >
                <svg
                  class="animate-spin -ml-1 mr-3 h-8 w-8 text-white"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <circle
                    class="opacity-25"
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="4"
                  ></circle>
                  <path
                    class="opacity-75"
                    fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                  ></path>
                </svg>
              </div>
            </div>
            <div class="flex items-center">
              <div class="w-1/6 px-2">
                <img
                  src="img/placeholders/profile.jpg"
                  class="rounded-full float-right w-4 h-4 md:w-8 md:h-8 object-cover"
                  alt=""
                />
              </div>
              <div
                class="mb-3 textarea flex space-x-4 items-center pr-3 rounded-full bg-white w-5/6"
              >
                <textarea
                  name=""
                  ref="mediaCaption"
                  id="media-message"
                  cols="30"
                  rows="3"
                  :value="caption"
                  class="text-xs text-gray-600 border-0 resize-none rounded-xl w-full py-1 placeholder-gray-400"
                  placeholder="Write something.."
                ></textarea>
                <i
                  class="mdi mdi-emoticon-happy-outline text-xl hidden text-gray-400"
                ></i>
                <i
                  class="mdi mdi-send text-xl text-cha-primary media-send cursor-pointer"
                  @click="sendMedia"
                ></i>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </div>
</template>
<script>
const default_layout = "default";

export default {
  computed: {
    imageFromObject: function () {
      if (this.media !== null && typeof this.media !== 'undefined') {
        return URL.createObjectURL(this.media);
      }
    },
  },
  props: ["caption", "media", "intent"],
  mounted() {},

  methods: {
    sendMedia() {
      this.$store.dispatch("closeMediaModal");
      this.$emit("mediaSent", this.$refs.mediaCaption.value, this.media, this.intent);
    },
  },
};
</script>