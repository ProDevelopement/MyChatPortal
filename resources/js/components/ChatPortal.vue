<template>
    <div class="chatPortal">
        <div class="headerChat">
            <h3>{{ friend ? friend.name : 'Select a Friend' }}<small class="float-right" @click="closePanel">close</small></h3>
            
        </div>
        <chatFeed :friend="friend" :messages="messages"></chatFeed>
        <chatComposer @send="sendMessage"></chatComposer>
    </div>
</template>

<script>
    export default {
        props: {
            friend: {
                type: Object,
                default: null
            },
            messages: {
                type: Array,
                default: []
            }
        },
        mounted() {
            console.log('Component ChatPortal mounted.')
        },
        methods: {
            sendMessage(text) {
                if (!this.friend) {
                    return;
                }
                axios.post('/api/v1/sendMsg', {
                    friend_id: this.friend.id,
                    text: text },
                    {headers: { "Authorization" : 'Bearer ' + window.api_token }}).then((response) => {
                    this.$emit('new', response.data);
                })
            },
            closePanel(){
                this.$emit('closePanel');
            }
        }
    }
</script>

<style lang="scss" scoped>
.chatPortal {
    position: absolute;
    max-height: 600px;
    width: 350px;
    background: #fff;
    border: 1px solid;
    border-color: #a6aaad;
    bottom:50px;
    right:220px;
    overflow: scroll;

    h3 {
        border-bottom: 1px dashed;
    }
    small {
        color: #455665;
        float: right;
        font-size: 50%;
        padding: 3px;
    }
}

</style>