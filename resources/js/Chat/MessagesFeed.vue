<template>
     <div class="message-feed bg-gray-200 h-full p-4" ref="scrollFeed">
         <ul v-if="contact">
             <li
                 v-for="message in messages"
                 :key="message.id"
                 :class="`message ${message.to === contact.id ? 'sent' : 'received'}`">
                <div class="text">
                    {{ message.text }}
                </div>
             </li>
         </ul>
     </div>
</template>

<script>
    export default {
        name: "MessagesFeed",
        props: {
            contact: {
                type: Object
            },
            messages: {
                type: Array,
                required: true
            }
        },
        methods: {
            scrollDown() {
                setTimeout(() => {
                    this.$refs.scrollFeed.scrollTop = this.$refs.scrollFeed.scrollHeight - this.$refs.scrollFeed.clientHeight
                }, 50)
            }
        },
        watch: {
            contact(contact) {
                this.scrollDown()
            },
            messages(messages) {
                this.scrollDown()
            }
        }
    }
</script>

<style scoped>
    .message-feed {
        max-height: 515px;
        overflow-y: scroll;
        overflow-x: hidden;
    }
    li .text {
        max-width: 250px;
        border-radius: 10px;
        padding: 12px;
        display: inline-block;
    }
    li.message {
        margin: 10px 0;
        width: 100%;
    }
    li.received {
        text-align: left;
    }
    li.received .text {
        background: #cbd5e0;
    }
    li.sent {
        text-align: right;
    }
    li.sent .text {
        --tw-bg-opacity: 1;
        background-color: rgba(165, 180, 252, var(--tw-bg-opacity));
    }
</style>
