<template>
    <div class="event-filters">
        <div
            v-for="(filter, key) in filters"
            class="event-filters__filter"
            :key="key"
            :class="classObject(filter)"
            @click="filterByType(filter, key)"
        >
            {{ filter.name }}
        </div>
    </div>
</template>

<script>
import {EventTypesMappingMixin} from '../../mixins/event_types_mapping';
import {mapActions} from "vuex";

export default {
    name: "EventFilters",
    mixins: [EventTypesMappingMixin],
    data() {
        return {
            filters: {},
            filterValues: []
        }
    },
    mounted() {
        this.$set(this, 'filters', this.eventTypes);
    },
    methods: {
        ...mapActions({
            changeEventsVisibility: 'changeEventsVisibility'
        }),
        filterByType(filter, key) {
            if (this.filterValues.indexOf(key) === -1) {
                this.filterValues.push(key);
                this.switchActiveState(key, true);
            } else {
                this.filterValues.splice(this.filterValues.indexOf(key), 1);
                this.switchActiveState(key, false);
            }
            this.changeEventsVisibility(this.filterValues);
        },
        switchActiveState(key, state) {
            this.filters[key].isActive = state;
        },
        classObject(filter) {
            const short = 'event-filters__filter' + filter.short;
            const active = filter.isActive ? short + '--active' : '';
            return [short, active];
        }
    }
}
</script>
