<template>
    <div class="contact-list w-2/6 py-4 pl-0 border-l">
        <ul>
            <li v-for="contact in sortedContacts" :key="contact.id"
                @click="selectContact(contact)"
                class="contact-row flex items-center p-3 border-b h-20 cursor-pointer"
                :class="{'selected' : contact == selected}">
                <div class="avatar">
                    <img :src="contact.profile_photo_path" :alt="contact.name">
                </div>
                <div class="contact-info">
                    <p class="name font-semibold mb-2 text-base">
                        <span>{{ contact.name }}</span>
                    </p>
                    <p class="email">{{ contact.email }}</p>
                </div>
                <span v-if="contact.unread"
                    class="bg-purple-400 p-1 rounded-full text-xs text-white font-semibold">{{ contact.unread }}</span>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "ContactList",
        props: {
            contacts: {
                type: Array,
                default: []
            }
        },
        data() {
            return {
                selected: this.contacts.length ? this.contacts[0] : null,
            }
        },
        methods: {
            selectContact(contact) {
                this.selected = contact
                this.$emit('selected', contact)
            }
        },
        computed: {
            sortedContacts() {
                return _.sortBy(this.contacts, [(contact) => {
                    if (contact == this.selected) {
                        return Infinity
                    }
                    return contact.unread
                }]).reverse()
            }
        }
    }
</script>

<style scoped>
    .contact-list {
        max-height: 670px;
        overflow-y: scroll;
        overflow-x: hidden;
    }
    .avatar {
        flex: 1;
        display: flex;
        align-items: center;
    }
    .avatar img {
        width: 40px;
        border-radius: 50%;
        margin: 0 auto;
    }
    .contact-info {
        flex: 3;
        display: flex;
        font-size: 12px;
        overflow: hidden;
        flex-direction: column;
        justify-content: center;
    }
    li.selected {
        --tw-bg-opacity: 1;
        background-color: rgba(156, 163, 175, var(--tw-bg-opacity));
    }
</style>
