<template>
    <div class="chat">
            <button class="btn btn-outline-secondary btn-lg" @click="showChatWindow"> Chat </button>
            <FriendsList :friends="friends" @selected="startConversationWith" 
            v-bind:style="{ display: classShowChat }" />
            <ChatPortal :friend="selectedFriend" :messages="messages" @new="saveNewMessage" @closePanel="closePanel"
            v-bind:style="{ display: classShowChatPanel }" />       
    </div>
</template>

<script>
    export default {
        data() {
            return {
                selectedFriend: null,
                messages: [],
                friends: [],
                classShowChat: 'none',
                classShowChatPanel: 'none',
            };
        },
        props: {
            user: {
                type: Object,
                required: true
            }
        },
        mounted() {
            Echo.private(`messages.${this.user.id}`)
                .listen('NewMessage', (e) => {
                    this.hanleIncoming(e.message);
                });
            axios.get('/api/v1/getFriends', { headers: { "Authorization" : 'Bearer ' + window.api_token } })
                .then((response) => {
                    this.friends = response.data;
            });
        },
        methods: {
            startConversationWith(friend) {
                this.updateUnreadCount(friend, true);

                axios.get(`/api/v1/getMessages/${friend.id}`, { headers: { "Authorization" : 'Bearer ' + window.api_token } })
                    .then((response) => {
                        this.messages = response.data;
                        this.selectedFriend = friend;
                        this.classShowChatPanel = 'block';
                    })
            },
            saveNewMessage(message) {
                this.messages.push(message);
            },
            showChatWindow(){
                if(this.classShowChat == 'none'){
                    this.classShowChat = 'block';
                }else{
                    this.classShowChat = 'none';
                    this.classShowChatPanel = 'none';
                    this.selectedFriend = null;
                }
            },
            closePanel(){
                this.classShowChatPanel = 'none';
                this.selectedFriend = null;
            },
            hanleIncoming(message) {
                if (this.selectedFriend && message.from == this.selectedFriend.id) {
                    this.saveNewMessage(message);
                    return;
                }
                this.updateUnreadCount(message.from_contact, false);
            },
            updateUnreadCount(friend, reset) {
                this.friends = this.friends.map((single) => {
                    if (single.id !== friend.id) {
                        return single;
                    }
                    if (reset)
                        single.unread = 0;
                    else
                        single.unread += 1;
                    return single;
                })
            }
        }
    }
</script>

<style lang="scss" scoped>
.chat {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    max-height: 50px;

    button {
        width: 200px;
        padding: 0px;
        margin: 10px;
        float: right;
    }
}


</style>