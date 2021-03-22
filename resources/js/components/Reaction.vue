<template>
  <div class="w-2/3 reactions flex items-center justify-between relative">
    <div class="w-full add-reaction flex space-x-4 items-center">
      <img
        :src="iconImage"
        @click="toggleReaction()"
        class="h-6 select-reaction cursor-pointer"
      />
      <div class="w-1/3 flex items-center text-lg text-cha-primary">
        😅
        <span class="reactions_count text-xs"> {{ c }}</span>
      </div>
    </div>
    <div class="reactions-container absolute z-1 left-0 -bottom-6">
      <div
        v-if="openReactions"
        class="reaction-container flex items-center shadow-lg flex-auto space-x-2 md:space-x-4 rounded-full px-2 py-1 bg-gray-50"
      >
        <img
          src="/img/icons/like.svg"
          @click="reactionMade('like')"
          class="h-6 w-6 cursor-pointer"
          alt=""
        />
        <img
          src="/img/icons/laugh.svg"
          @click="reactionMade('laugh')"
          class="h-6 w-6 cursor-pointer"
          alt=""
        />
        <img
          src="/img/icons/smile.svg"
          @click="reactionMade('smile')"
          class="h-6 w-6 cursor-pointer"
          alt=""
        />
        <img
          src="/img/icons/applaud.svg"
          @click="reactionMade('applaud')"
          class="h-6 w-6 cursor-pointer"
          alt=""
        />
        <img
          src="/img/icons/surprise.svg"
          @click="reactionMade('surprise')"
          class="h-6 w-6 cursor-pointer"
          alt=""
        />
        <img
          src="/img/icons/angry.svg"
          @click="reactionMade('angry')"
          class="h-6 w-6 cursor-pointer"
          alt=""
        />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["reaction", "count"],
  computed: {
    reactionIcon: function () {
      if (this.r) {
        this.iconImage = `/img/icons/${this.r.reaction}.svg`;
      }
    },
  },
  data() {
    return {
      r: this.reaction,
      c:this.count,
      openReactions: false,
      iconImage: "/img/icons/add-smiley.svg",
    };
  },
  created() {
    window.addEventListener("click", (e) => {
      if (!this.$el.contains(e.target)) {
        this.openReactions = false;
      }
    });
  },
  mounted() {
    if (this.r) {
      this.iconImage = `/img/icons/${this.r.reaction}.svg`;
    }
  },
  methods: {
    toggleReaction() {
      this.openReactions = true;
    },
    reactionMade(reaction) {
      if (!auth) {
        doLogin();
        return;
      }
      if (!this.r) {
        this.c++;
      }
        this.iconImage = `/img/icons/${reaction}.svg`;
      this.r = {
        reaction: reaction,
      };
      this.openReactions = false;
      this.$emit("reactionMade", reaction);
    },
  },
};
</script>
