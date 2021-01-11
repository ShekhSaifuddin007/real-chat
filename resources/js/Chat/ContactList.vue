<template>
    <div class="contact-list w-2/6 py-4 pl-0 border-l">
        <ul>
            <li v-for="(contact, index) in contacts" :key="contact.id"
                @click="selectContact(index, contact)"
                class="contact-row flex p-3 border-b h-20 cursor-pointer"
                :class="{'selected' : index == selected}">
                <div class="avatar">
                    <img :src="contact.profile_photo_path" :alt="contact.name">
                </div>
                <div class="contact-info">
                    <p class="name font-semibold mb-2 text-lg">{{ contact.name }}</p>
                    <p class="email">{{ contact.email }}</p>
                </div>
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
                selected: 0
            }
        },
        methods: {
            selectContact(index, contact) {
                this.selected = index
                this.$emit('selected', contact)
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
