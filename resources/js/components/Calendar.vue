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
                    @show-events="showEvents"
                ></month>
            </template>
        </div>
        <popup
            v-show="showPopup"
            :dateString="'2022-11-15'"
            :position-x-y="positionPopup"
            @addEvent="showCreateModal"
            @hidePopup="hideEvents"
        ></popup>
        <create-modal
            v-show="showModalCreate"
            :dateString="dateStringToModalCreate"
            @hideCreateModal="hideCreateModal"
        ></create-modal>
    </div>
</template>

<script>
import Month from './blocks/Month';
import EventFilters from './blocks/EventFilters';
import Popup from './UI/Popup';
import CreateModal from './UI/CreateModal';

export default {
    name: "Calendar",
    components: {Month, EventFilters, Popup, CreateModal},
    data() {
        return {
            monthsCount: 6,
            months: [],
            positionPopup: [],
            showPopup: false,
            showModalCreate: false,
            dateStringToModalCreate: ''
        }
    },
    beforeMount() {
        this.mountMonths();
    },
    methods: {
        mountMonths() {
            for (let i = 0; i < this.monthsCount; i++) {
                const monthNow = new Date().getMonth();
                const yearNow = new Date().getFullYear();

                this.months[i] = {
                    id: monthNow + i < 12 ? monthNow + i : monthNow + i - 12,
                    year: monthNow + i < 12 ? yearNow : yearNow + 1
                };
            }
        },
        showEvents(position, date) {
            this.$set(this, 'positionPopup', position);
            this.$set(this, 'dateStringToModalCreate', date);
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
        }
    }
}
</script>
