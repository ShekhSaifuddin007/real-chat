<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Live Chat
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-300">
                    <div class="w-full p-4 bg-gray-300 font-bold">
                        Messenger App
                    </div>
                    <div class="flex justify-between">
                        <Conversation :contact="selectContact" :messages="messages" @newMessage="newMessage"/>
                        <ContactList :contacts="contacts" @selected="startConversation"/>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Conversation from "@/Chat/Conversation";
    import ContactList from "@/Chat/ContactList";

    export default {
        props: {
            user: {
                type: Object,
                required: true
            }
        },

        components: {
            ContactList,
            Conversation,
            AppLayout,
        },
        data() {
            return {
                selectContact: null,
                messages: [],
                contacts: [],
            }
        },
        mounted() {
            Echo.private(`messages.${this.user.id}`)
                .listen('NewMessage', (e) => {
                    this.handleIncoming(e.message)
                })

            axios.get('contacts').then(response => {
                this.contacts = response.data
            }).catch(error => {
                console.log(error)
            })
        },
        methods: {
            startConversation(contact) {
                axios.get(`conversation/${contact.id}`)
                    .then(response => {
                        this.messages = response.data
                        this.selectContact = contact
                    }).catch(error => {
                        console.log(error)
                })
            },
            newMessage(message) {
                this.messages.push(message)
            },
            handleIncoming(message) {
                if (this.selectContact && message.from === this.selectContact.id) {
                    this.newMessage(message)
                    return
                }
                alert(message.text)
            }
        }
    }
</script>
