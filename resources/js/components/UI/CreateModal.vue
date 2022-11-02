<template>
    <div class="window-modal">
        <div class="window-modal__container">
            <div class="window-modal__header">
                <div class="window-modal__header--name">
                    Add event
                </div>
                <div class="window-modal__close"  @click="closeModal">
                    <img src="/images/close_icon.png">
                </div>
            </div>
            <div class="window-modal__body">
                <input type="text" name="name" placeholder="Event name..." v-model="event.name">
                <textarea
                    name="description"
                    placeholder="Event description..."
                    rows="3"
                    v-model="event.description"
                ></textarea>
                <input type="text" name="location" placeholder="Event location..." v-model="event.location">
                <div class="window-modal__date">
                    <div class="window-modal__day">
                        {{ dateDay }} at
                    </div>
                    <select v-model="event.time" class="window-modal__time">
                        <option>FF</option>
                    </select>
                </div>
                <select v-model="event.type" class="window-modal__type">
                    <option>FF</option>
                </select>
            </div>
            <div class="window-modal__footer">
                <div class="window-modal__footer--cancel">
                    Cancel
                </div>
                <div class="window-modal__footer--add">
                    Add
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CreateModal",
    props: {
        dateString: {
            type: String,
            required: true
        },
    },
    data() {
        return {
            event: {
                name: '',
                description: '',
                location: '',
                date: '',
                time: '',
                type: '',
            }
        }
    },
    computed: {
        dateDay() {
            const date = new Date(this.dateString);
            const dayOfMonth = date.getDate();
            const shortMonth = date.toLocaleString('en-US', { month: 'short' });
            return dayOfMonth + ' ' + shortMonth + ' ';
        }
    },
    methods: {
        closeModal() {
            this.$emit('hideCreateModal');
        }
    }
}
</script>
