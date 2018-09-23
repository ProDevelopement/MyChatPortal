<template>
    <div class="chatComposer">
        <input class="input-control" v-model="message" @keydown.enter="send" placeholder="Message ..."></input>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                message: ''
            };
        },
        methods: {
            send(e) {
                e.preventDefault();
                
                if (this.message == '') {
                    return;
                }
                this.$emit('send', this.message);
                this.message = '';
            }
        }
    }
</script>

<style lang="scss" scoped>
.chatComposer {
    order: 3;
    margin: 5px;
    padding: 0px;
    input {
        width: 100%;
        resize: none;
        border-radius: 3px;
        border: 1px solid lightgray;
        
    }
}
</style>