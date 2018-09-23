<template>
    <div class="chatFeed" ref="feed">
        <ul v-if="friend">
        	<li v-for="message in messages" :class="`message${message.to == friend.id ? ' sender' : ' receiver'}`" :key="message.id">
				<div class="text">
                    {{ message.text }}
                </div>
        	</li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: {
            friend: {
                type: Object
            },
            messages: {
                type: Array,
                required: true
            }
        },
        mounted() {
            console.log(this.messages)
        },
        methods: {
            scrollToBottom() {
                setTimeout(() => {
                    this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
                }, 50);
            }
        },
        watch: {
            friend(friend) {
                this.scrollToBottom();
            },
            messages(messages) {
                this.scrollToBottom();
            }
        }
    }
</script>

<style lang="scss" scoped>
.chatFeed {
	order: 2;
    height: 100%;
    max-height: 470px;
    overflow: scroll;

	ul {
        list-style-type: none;
        padding: 5px;
        li {
            &.message {
                margin: 1px 0;
                width: 100%;
                .text {
                    max-width: 200px;
                    border-radius: 5px;
                    padding: 2px;
                    display: inline-block;
                }
                &.receiver {
                    text-align: right;
                    .text {
                        background: #b2b2b2;
                    }
                }
                &.sender {
                    text-align: left;
                    .text {
                        background: #81c4f9;
                    }
                }
            }
        }
	}
}
</style>