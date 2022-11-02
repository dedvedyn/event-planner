<template>
    <div class="month">
        <div class="month__title">
            {{ monthTitle }}
        </div>
        <div class="month__days">
            <div v-for="day in weekDays" :key="day.id" class="month__days--day">
                {{ day.short_name }}
            </div>
        </div>
        <div class="month__dates">
            <div v-for="week in weeksDaysOfMonth" class="month__week">
                <div v-for="day in week" class="month__week--day">
                    <div
                        class="month__week--day--number"
                        :class="{ 'month__week--day--disabled': !day.isCurrentMonth }"
                        @click="selectDay(day.isCurrentMonth, $event)"
                    >
                        {{ day.date }}
                    </div>
                    <div class="month__week--day--events">
<!--                        <div class="month__week&#45;&#45;day&#45;&#45;event" style="background-color: #4DB4FF;"></div>-->
<!--                        <div class="month__week&#45;&#45;day&#45;&#45;event" style="background-color: #FF4E6B;"></div>-->
<!--                        <div class="month__week&#45;&#45;day&#45;&#45;event" style="background-color: #00CC66;"></div>-->
<!--                        <div class="month__week&#45;&#45;day&#45;&#45;event" style="background-color: #FFBB33;"></div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {WeekDaysMixin} from '../../mixins/week_days';

export default {
    name: "Month",
    props: {
        isSundayFirst: {
            type: Boolean,
            default: false
        },
        monthId: {
            type: Number,
            required: true
        },
        year: {
            type: Number,
            required: true
        }
    },
    mixins: [WeekDaysMixin],
    data() {
        return {
            monthTitle: '',
            weeksDaysOfMonth: []
        }
    },
    beforeMount() {
        this.mountWeeksDaysOfMonth();
    },
    mounted() {
        this.mountDays();
        this.mountMonthTitle();
    },
    methods: {
        mountDays() {
            if (this.isSundayFirst) {
                const sunday = this.weekDays.pop();
                this.weekDays.unshift(sunday);
            }
        },
        mountWeeksDaysOfMonth() {
            let weekLength = 7;
            let firstDayOfWeek = this.isSundayFirst ? 0 : 1;

            let firstOfMonth = new Date(this.year, this.monthId, 1);
            let lastOfMonth = new Date(this.year, this.monthId + 1, 0);
            let lastOfPrevMonth = new Date(this.year, this.monthId, 0);

            let firstDayOfMonth = firstOfMonth.getDay();

            const prevDates = [];
            const dates = [];
            const nextDates = [];

            for (let date = 1; date <= lastOfMonth.getDate(); date++) {
                dates.push({
                    date: date,
                    isCurrentMonth: true
                });
            }

            if (0 === firstDayOfWeek) {
                const countDaysFromPrevMonth = firstDayOfMonth - firstDayOfWeek;
                const firstDisplayedDayOfPrevMonth = lastOfPrevMonth.getDate() - (countDaysFromPrevMonth - 1);
                for (let date = firstDisplayedDayOfPrevMonth; date <= lastOfPrevMonth.getDate(); date++) {
                    prevDates.push({
                        date: date,
                        isCurrentMonth: false
                    });
                }
            } else {
                // TODO: UPDATE
            }

            const prevCurrentDates = prevDates.concat(dates);

            const countDaysFromNextMonth = weekLength - (prevCurrentDates.length % weekLength);
            if (countDaysFromNextMonth < 7) {
                for (let date = 1; date <= countDaysFromNextMonth; date++) {
                    nextDates.push({
                        date: date,
                        isCurrentMonth: false
                    });
                }
            }

            const prevCurrentNextDates = prevCurrentDates.concat(nextDates);

            for (let i = 0; i < Math.ceil(prevCurrentNextDates.length / weekLength); i++) {
                this.weeksDaysOfMonth[i] = prevCurrentNextDates.slice((i*weekLength), (i*weekLength) + weekLength);
            }
        },
        mountMonthTitle() {
            const date = new Date(this.year, this.monthId);
            this.$set(
                this,
                'monthTitle',
                date.toLocaleString('en-US', {month: 'long'})
            );
        },
        selectDay(isCurrentMonth, event) {
            if (isCurrentMonth) {
                const maxX = document.documentElement.clientWidth - 375;
                const maxY = document.documentElement.scrollHeight - 685;
                const positionX = event.pageX < maxX ? event.pageX : maxX;
                const positionY = event.pageY < maxY ? event.pageY : maxY;
                const selectedDate = [this.year, this.monthId + 1, event.path[0].innerText].join('-');
                this.$emit('show-events', [positionX + 15, positionY + 15], selectedDate);
            }
        }
    }
}
</script>
