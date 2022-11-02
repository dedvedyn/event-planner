<template>
    <div class="event-filters">
        <div
            v-for="filter in filters"
            class="event-filters__filter"
            :class="[{'event-filters__active':filter.isActive}, 'event-filters__filter' + filter.short]"
        >
            {{ filter.name }}
        </div>
    </div>
</template>

<script>
export default {
    name: "EventFilters",
    data() {
        return {
            filters: [
                {
                    name: 'Meeting with an expert',
                    short: '--metexp',
                    isActive: false
                },
                {
                    name: 'Question-answer',
                    short: '--qa',
                    isActive: false
                },
                {
                    name: 'Conference',
                    short: '--conf',
                    isActive: false
                },
                {
                    name: 'Webinar',
                    short: '--web',
                    isActive: false
                },
            ]
        }
    }
}
</script>
