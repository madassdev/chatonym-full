
<template>
  <div class="">
    <div
      id="palette-preview-box"
      class="hidden rounded-xl bg-cha-secondary m-3 mb-0 p-3"
    >
      <div
        id="palette-preview"
        class="relative w-3/4 mx-auto h-24 px-5 py-3 rounded-2xl gra-orange text-white"
        gradient-bg="gra-orange"
      >
        <p class="preview-text text-xs text-gray-100">
          Type a message in the input box below to preview
        </p>
        <i
          class="palette-close mdi mdi-close absolute top-0 right-2 cursor-pointer"
        ></i>
      </div>
    </div>

    <div class="m-3 mb-0 bg-cha-secondary p-3 rounded-2xl">
      <div class="flex">
        <div class="w-1/6 px-2">
          <img
            src="img/placeholders/profile.jpg"
            class="rounded-full float-right w-8 h-8 md:w-12 md:h-12 object-cover"
            alt=""
          />
        </div>
        <div class="w-5/6 texting flex flex-col pr-4">
          <div
            class="mb-3 textarea flex space-x-4 items-center pr-3 rounded-full bg-white"
          >
            <textarea
              name=""
              id="feed-message"
              cols="30"
              rows="3"
              v-model="message"
              class="text-xs text-gray-600 border-0 resize-none rounded-xl w-full py-1 placeholder-gray-400"
              placeholder="Write something.."
            ></textarea>
            <i
              class="mdi mdi-emoticon-happy-outline text-xl hidden text-gray-400"
            ></i>
            <MediaUploaderIcon @mediaSelected="mediaSelected"/>
            <i @click="sendClicked" class="mdi mdi-send text-xl text-cha-primary cursor-pointer"></i>

          </div>

          <div class="styling px-4 flex items-center relative">
            <!-- <div class="w-3/4">
              <div class="w-8 cursor-pointer" id="palette-selector">
                <img
                  src="img/icons/rainbow.svg"
                  class="rounded-full w-8"
                  alt=""
                />
                <div
                  id="palette"
                  class="hidden absolute z-10 bg-cha-secondarys bg-gray-50 shadow-lg left-10 top-3 p-1 md:p-2 grid grid-cols-8 md:gap-2 gap-1 rounded w-full sm:w-2/3 md:w-5/6"
                >
                  @foreach(['a', 'b', 'c'] as $c)
                  <div
                    class="gra-orange w-6 h-6 md:w-8 md:h-8 rounded palette-color"
                    gradient-bg="gra-orange"
                  ></div>
                  <div
                    class="gra-oxblood w-6 h-6 md:w-8 md:h-8 rounded palette-color"
                    gradient-bg="gra-oxblood"
                  ></div>
                  <div
                    class="gra-quepal w-6 h-6 md:w-8 md:h-8 rounded palette-color"
                    gradient-bg="gra-quepal"
                  ></div>
                  <div
                    class="gra-cherry w-6 h-6 md:w-8 md:h-8 rounded palette-color"
                    gradient-bg="gra-cherry"
                  ></div>
                  <div
                    class="gra-amin w-6 h-6 md:w-8 md:h-8 rounded palette-color"
                    gradient-bg="gra-amin"
                  ></div>
                  @endforeach
                </div>
              </div>
            </div> -->

            <div class="icons flex items-center w-1/2 justify-end space-x-4">
              <!-- <i class="mdi mdi-plus text-cha-primary text-xl"></i> -->

              <!-- <div
                id="imgBtn"
                @click="uploadClicked"
                class="flex items-center justify-center top-2 right-2 h-8 w-8 cursor-pointer rounded-full"
              >
                <input
                  id="imageInput"
                  type="file"
                  ref="fileInput"
                  :v-model="file"
                  class="h-0 w-0"
                  accept="image/*"
                  @change="imageSelected"
                />
                <i
                  class="mdi mdi-camera-image text-cha-primary text-xl cursor-pointer media-upload image"
                ></i>
              </div> -->
              <!-- <i class="mdi mdi-video-plus text-cha-primary text-xl cursor-pointer media-upload video"></i> -->
              <!-- <img src="{{
                                                    asset('img/icons/GIF.svg')
                                                }}" class="w-5 cursor-pointer" alt="" /> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
const default_layout = "default";
import MediaUploaderIcon from './MediaUploaderIcon'

export default {
  computed: {},
  props: ["image_url"],
  data() {
    return {
      mediaCaption: "",
      mediaObject: null,
      message: "",
      media: null,
    };
  },
  components:{
      MediaUploaderIcon,
  },
  mounted(){
      this.message=""
  },
  methods: {
      reset(){
        this.message=""  
      },
    sendClicked(){
        if(!auth){
            doLogin()
        }else{
            this.$emit("sendClicked", this.message);
        }
    },
    mediaSelected(mediaObject){
        this.openMediaModal(this.message, mediaObject)
    },
    openMediaModal(caption, media) {
      this.mediaCaption = caption;
      this.mediaObject = media;
      this.$store.dispatch('openMediaModal', {media: media, caption: caption})
    },
  },
};
</script>