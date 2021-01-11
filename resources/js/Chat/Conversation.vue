<template>
    <div class="conversation flex flex-col justify-between w-5/6">
        <div class="px-4 py-3 bg-white shadow-md flex items-center justify-center font-semibold w-full">
            {{ contact ? contact.name : 'Select A contact' }}
        </div>
        <MessagesFeed :contact="contact" :messages="messages"/>
        <MessageComposer @sentMessage="sentMessage"/>
    </div>
</template>

<script>
import MessagesFeed from "@/Chat/MessagesFeed";
import MessageComposer from "@/Chat/MessageComposer";
export default {
    name: "Conversation",
    components: {MessageComposer, MessagesFeed},
    props: {
        contact: {
            type: Object,
            default: null
        },
        messages: {
            type: Array,
            default: []
        }
    },
    methods: {
        sentMessage(text) {
            if (this.contact) {
                axios.post('conversation/send', {
                    contact_id: this.contact.id,
                    text: text
                })
                .then(response => {
                    this.$emit('newMessage', response.data)
                })
                .catch(error => {
                    console.log(error)
                })
            }
        }
    }
}
</script>

<style scoped>

</style>
