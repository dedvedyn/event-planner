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
                    <div class="popup__event--edit">
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
                        {{ event.time }}
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
        dateString: {
            type: String,
            required: true
        },
        positionXY: {
            type: Array,
            required: true
        }
    },
    mixins: [EventTypesMappingMixin],
    data() {
        return {
            events: [
                {
                    name: 'Test event',
                    description: 'This event from Vue component. After Frontend development need to update DB and add ability to create real events.',
                    type: 'QUESTION_ANSWER',
                    location: 'Gulliver, Kyiv, Ukraine',
                    time: '15 november, 18:00'
                },
                {
                    name: 'Nothing But Thieves',
                    description: 'The popular indie rock band Nothing But Thieves will come to Kyiv on October 29, 2022 with a big solo concert. The British have repeatedly given cool performances at the largest Ukrainian festivals, filmed music videos in Kyiv, and now they are preparing a special show for the most loyal fans!',
                    type: 'MEETING_WITH_EXPERT',
                    location: 'Gulliver, Kyiv, Ukraine',
                    time: '10 december, 10:00'
                }
            ]
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
        closePopup() {
            this.$emit('hideEvents');
        }
    }
}
</script>
