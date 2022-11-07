<template>
    <div class="popup" :style="setPosition">
        <div class="popup__flex popup__header">
            <div class="popup__title">
                Events
            </div>
            <div class="popup__close" @click="closePopup">
                <img src="/images/close_icon.png">
            </div>
        </div>
        <div class="popup__events-list">
            <div v-for="(event, index) in events" :key="index" class="popup__event">
                <div class="popup__flex">
                    <div class="popup__event--title">
                        {{ event.name }}
                    </div>
                    <div class="popup__event--edit" @click="editEvent(event)">
                        <img src="/images/edit_icon.png">
                    </div>
                </div>
                <div class="popup__event--description">
                    {{ event.description }}
                </div>
                <div class="popup__event--location">
                    {{ event.location }}
                </div>
                <div class="popup__flex">
                    <div class="popup__event--time">
                        {{ eventTime(event) }}
                    </div>
                    <div class="popup__event--type" :class="'popup__event' + eventClass(event.type)">
                        {{ eventType(event.type) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="popup__add">
            <div class="popup__button" @click="addEvent">
                Add event
            </div>
        </div>
    </div>
</template>

<script>
import {EventTypesMappingMixin} from '../../mixins/event_types_mapping';

export default {
    name: "Popup",
    props: {
        positionXY: {
            type: Array,
            required: true
        },
        events: {
            type: Array,
            default: function () {return []}
        }
    },
    mixins: [EventTypesMappingMixin],
    data() {
        return {
            //
        }
    },
    computed: {
        setPosition() {
            return 'left: ' + this.positionXY[0] + 'px; top: ' + this.positionXY[1] + 'px;';
        }
    },
    methods: {
        eventType(typeEnum) {
            return this.eventTypes[typeEnum].name;
        },
        eventClass(typeEnum) {
            return this.eventTypes[typeEnum].short;
        },
        addEvent() {
            this.$emit('addEvent');
        },
        editEvent(eventData) {
            this.$emit('editEvent', eventData);
        },
        closePopup() {
            this.$emit('hidePopup');
        },
        eventTime(event) {
            const dayOfMonth = event.time.getDate();
            const shortMonth = event.time.toLocaleString('en-US', { month: 'long' });
            const time = event.time.toTimeString().split(':');
            return dayOfMonth + ' ' + shortMonth + ', ' + time[0] + ':' + time[1];
        }
    }
}
</script>
