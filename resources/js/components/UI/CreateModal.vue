<template>
    <div class="window-modal">
        <div class="window-modal__container">
            <div class="window-modal__header">
                <div class="window-modal__header--name">
                    Add event
                </div>
                <div class="window-modal__close" @click="closeModal">
                    <img src="/images/close_icon.png">
                </div>
            </div>
            <div class="window-modal__body">
                <input type="text" name="name" placeholder="Event name..." v-model="event.name">
                <textarea
                    name="description"
                    placeholder="Event description..."
                    v-model="event.description"
                ></textarea>
                <input type="text" name="location" placeholder="Event location..." v-model="event.location">
                <div class="window-modal__date">
                    <div class="window-modal__day">
                        {{ dateDay }} at
                    </div>
                    <select v-model="event.hourMinute" class="window-modal__time">
                        <option v-for="hour in dayHours" :value="hour.time">
                            {{ hour.time }}
                        </option>
                    </select>
                </div>
                <select v-model="event.type" class="window-modal__type">
                    <option v-for="(eventType, key) in eventTypes" :value="key">
                        {{ eventType.name }}
                    </option>
                </select>
            </div>
            <div class="window-modal__footer">
                <div class="window-modal__footer--cancel" @click="closeModal">
                    Cancel
                </div>
                <div class="window-modal__footer--add" @click="createNewEvent">
                    Add
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
    name: "CreateModal",
    props: {
        dateString: {
            type: String,
            required: true
        },
    },
    mixins: [EventTypesMappingMixin, DayHoursMixin],
    data() {
        return {
            event: {
                name: '',
                description: '',
                location: '',
                time: '',
                hourMinute: '',
                type: '',
            }
        }
    },
    computed: {
        ...mapGetters({
            datesFromTo: 'datesFromTo'
        }),
        dateDay() {
            const date = new Date(this.dateString);
            const dayOfMonth = date.getDate();
            const shortMonth = date.toLocaleString('en-US', { month: 'short' });
            return dayOfMonth + ' ' + shortMonth + ' ';
        }
    },
    methods: {
        ...mapActions({
            getEvents: 'getEvents'
        }),
        closeModal() {
            this.$emit('hideCreateModal');
            this.clearValues();
        },
        createNewEvent() {
            this.updateEventTimeBeforeSave();

            axios.post('/events/add/', this.event)
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
            this.$set(this.event, 'time', new Date(this.dateString));
            const hourMinuteArray = this.event.hourMinute.split(':');
            this.event.time.setHours(+hourMinuteArray[0]);
            this.event.time.setMinutes(+hourMinuteArray[1]);
        },
        clearValues() {
            this.$set(this, 'event',
                {
                    name: '',
                    description: '',
                    location: '',
                    time: '',
                    hourMinute: '',
                    type: '',
                }
            )
        }
    }
}
</script>
