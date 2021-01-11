<template>
     <div class="message-composer p-4">
         <textarea
             v-model="message"
             @keydown.enter.prevent="sentMessage"
             class="w-full border-2 border-gray-200 rounded-md resize-none focus:border-gray-300 focus:ring-0"
             placeholder="Type Message...">
         </textarea>
     </div>
</template>

<script>
    export default {
        name: "MessageComposer",
        data() {
            return {
                message: ''
            }
        },
        methods: {
            sentMessage() {
                if (this.message !== '') {
                    this.$emit('sentMessage', this.message)
                    this.message = ''
                }
            }
        }
    }
</script>

<style scoped>
    /*.message-composer textarea {

    }*/
</style>
