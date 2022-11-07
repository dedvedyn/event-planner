<template>
    <div class="window-modal">
        <div class="window-modal__container">
            <div class="window-modal__header">
                <div class="window-modal__header--name">
                    Edit event
                </div>
                <div class="window-modal__close" @click="closeModal">
                    <img src="/images/close_icon.png">
                </div>
            </div>
            <div class="window-modal__body">
                <input
                    type="text"
                    name="name"
                    placeholder="Event name..."
                    v-model="editedEvent.name"
                >
                <textarea
                    name="description"
                    placeholder="Event description..."
                    v-model="editedEvent.description"
                ></textarea>
                <input
                    type="text"
                    name="location"
                    placeholder="Event location..."
                    v-model="editedEvent.location"
                >
                <div class="window-modal__date">
                    <div class="window-modal__day">
                        {{ dateDay }} at
                    </div>
                    <select v-model="editedEvent.hourMinute" class="window-modal__time">
                        <option v-for="hour in dayHours" :value="hour.time">
                            {{ hour.time }}
                        </option>
                    </select>
                </div>
                <select v-model="editedEvent.type" class="window-modal__type">
                    <option v-for="(eventType, key) in eventTypes" :value="key">
                        {{ eventType.name }}
                    </option>
                </select>
            </div>
            <div class="window-modal__footer">
                <div class="window-modal__footer--cancel" @click="closeModal">
                    Cancel
                </div>
                <div class="window-modal__footer--delete" @click="deleteEvent">
                    Delete
                </div>
                <div class="window-modal__footer--add" @click="saveEvent">
                    Save
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {EventTypesMappingMixin} from '../../mixins/event_types_mapping';
import {DayHoursMixin} from '../../mixins/day_hours';
import {mapActions, mapGetters} from "vuex";

export default {
    name: "EditModal",
    props: {
        event: {
            type: Object,
            required: true
        }
    },
    mixins: [EventTypesMappingMixin, DayHoursMixin],
    data() {
        return {
            editedEvent: {
                time: new Date()
            }
        }
    },
    computed: {
        ...mapGetters({
            datesFromTo: 'datesFromTo'
        }),
        dateDay() {
            const dayOfMonth = this.editedEvent.time.getDate();
            const shortMonth = this.editedEvent.time.toLocaleString('en-US', { month: 'short' });
            return dayOfMonth + ' ' + shortMonth + ' ';
        }
    },
    watch: {
        event: {
            deep: true,
            immediate: false,
            handler(value) {
                let eventToSet = structuredClone(value);
                const toTimeString = eventToSet.time.toTimeString().split(':');
                eventToSet.hourMinute = toTimeString[0] + ':' + toTimeString[1];
                this.$set(this, 'editedEvent', eventToSet);
            }
        },
    },
    methods: {
        ...mapActions({
            getEvents: 'getEvents'
        }),
        closeModal() {
            this.$emit('hideEditModal');
        },
        deleteEvent() {
            axios.post('/events/delete/', {id: this.editedEvent.id})
                .then(({data}) => {
                    if (data.success) {
                        this.getEvents(this.datesFromTo);
                        this.closeModal();
                    } else {
                        console.log('Can`t delete event')
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        saveEvent() {
            this.updateEventTimeBeforeSave();

            axios.post('/events/edit/', this.editedEvent)
                .then(({data}) => {
                    if (data.success) {
                        this.getEvents(this.datesFromTo);
                        this.closeModal();
                    } else {
                        console.log('Can`t save event')
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        updateEventTimeBeforeSave() {
            const hourMinuteArray = this.editedEvent.hourMinute.split(':');
            this.editedEvent.time.setHours(+hourMinuteArray[0]);
            this.editedEvent.time.setMinutes(+hourMinuteArray[1]);
        }
    }
}
</script>
