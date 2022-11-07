<template>
    <div class="calendar">
        <div class="page-title">
            Calendar
        </div>
        <event-filters></event-filters>
        <div class="calendar__months">
            <template v-for="month in months">
                <month
                    :isSundayFirst=true
                    :monthId=month.id
                    :year=month.year
                    :monthEvents="setMonthEvents(month)"
                    @showEvents="showEvents"
                ></month>
            </template>
        </div>
        <popup
            v-show="showPopup"
            :position-x-y="positionPopup"
            :events="eventsToModal"
            @addEvent="showCreateModal"
            @editEvent="editEvent"
            @hidePopup="hideEvents"
        ></popup>
        <create-modal
            v-show="showModalCreate"
            :dateString="dateStringToModal"
            @hideCreateModal="hideCreateModal"
        ></create-modal>
        <edit-modal
            v-show="showModalEdit"
            :event="eventToEdit"
            @hideEditModal="hideEditModal"
        ></edit-modal>
    </div>
</template>

<script>
import {mapActions, mapGetters, mapMutations} from 'vuex';
import Month from './blocks/Month';
import EventFilters from './blocks/EventFilters';
import Popup from './UI/Popup';
import CreateModal from './UI/CreateModal';
import EditModal from './UI/EditModal';

export default {
    name: "Calendar",
    components: {Month, EventFilters, Popup, CreateModal, EditModal},
    data() {
        return {
            monthsCount: 6,
            months: [],
            positionPopup: [],
            showPopup: false,
            showModalCreate: false,
            showModalEdit: false,
            dateStringToModal: '',
            eventsToModal: [],
            eventToEdit: {},
            localEvents: []
        }
    },
    beforeMount() {
        this.mountMonths();
    },
    mounted() {
        this.getAllEvents();
    },
    computed: {
        ...mapGetters({
            events: 'events'
        }),
    },
    watch: {
        events: {
            deep: true,
            immediate: false,
            handler(value) {
                this.$set(this, 'localEvents', value);
            }
        }
    },
    methods: {
        ...mapActions({
            getEvents: 'getEvents'
        }),
        ...mapMutations({
            setEvents: 'setEvents'
        }),
        mountMonths() {
            const monthNow = new Date().getMonth();
            const yearNow = new Date().getFullYear();
            const dateStart = new Date(yearNow, monthNow, 1);

            for (let i = 0; i < this.monthsCount; i++) {
                let iteratedDate = new Date(yearNow, dateStart.getMonth() + i);
                this.months[i] = {
                    id: iteratedDate.getMonth(),
                    year: iteratedDate.getFullYear()
                };
            }
        },
        showEvents(position, date, currentDayEvents) {
            this.$set(this, 'positionPopup', position);
            this.$set(this, 'dateStringToModal', date);
            this.$set(this, 'eventsToModal', currentDayEvents);
            this.$set(this, 'showPopup', true);
        },
        hideEvents() {
            this.$set(this, 'showPopup', false);
        },
        showCreateModal() {
            this.$set(this, 'showPopup', false);
            this.$set(this, 'showModalCreate', true);
        },
        hideCreateModal() {
            this.$set(this, 'showModalCreate', false);
        },
        showEditModal() {
            this.$set(this, 'showPopup', false);
            this.$set(this, 'showModalEdit', true);
        },
        hideEditModal() {
            this.$set(this, 'showModalEdit', false);
        },
        editEvent(eventData) {
            this.$set(this, 'eventToEdit', eventData);
            this.showEditModal();
        },
        setMonthEvents(month) {
            return this.localEvents.filter(function (localEvent) {
                const eventMonthId = localEvent.time.getMonth();
                const eventYear = localEvent.time.getFullYear();
                if (month.id === eventMonthId && month.year === eventYear) {
                    return localEvent;
                }
            });
        },
        getAllEvents() {
            const yearNow = new Date().getFullYear();
            const monthNow = new Date().getMonth();
            const dateStart = new Date(yearNow, monthNow, 1);
            const dateEnd = new Date(yearNow, dateStart.getMonth() + this.monthsCount, 0, 23,59, 59);
            this.getEvents([dateStart, dateEnd]);
        }
    }
}
</script>
