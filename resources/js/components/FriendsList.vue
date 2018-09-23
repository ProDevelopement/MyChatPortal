<template>
    <div class="friendList">
      <ul class="list-group">
  		  <li v-for="friend in friends" :key="friend.id" @click="selectFriend(friend)" class="list-group-item">{{ friend.name }}</li>
  		</ul>
    </div>
</template>

<script>
    export default {
        props: {
            friends: {
                type: Array,
                default: []
            }
        },
        mounted() {
            console.log('Component FriendsList mounted.')
        },
        data() {
            return {
                selected: this.friends.length ? this.friends[0] : null
            };
        },
        methods: {
            selectFriend(friend) {
                this.selected = friend;
                this.$emit('selected', friend);
            }
        },
    }
</script>

<style lang="scss" scoped>
.friendList {
  position: absolute;
  max-height: 600px;
  width: 200px;
  max-height: 500px;
  bottom:50px;
  right: 10px;
  overflow: scroll;

  li {
    text-align: center;
  }
}
</style>