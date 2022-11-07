import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        datesFromTo: [],
        events: []
    },
    getters: {
        datesFromTo: (state) => state.datesFromTo,
        events: (state) => state.events,
    },
    mutations: {
        setDatesFromTo (state, datesFromTo) {
            state.datesFromTo = datesFromTo;
        },
        setEvents (state, events) {
            state.events = events;
        },
    },
    actions: {
        getEvents ({state, commit}, datesFromTo) {
            commit('setDatesFromTo', datesFromTo);
            axios.post('/events/getAll/', {datesFromTo})
                .then(({data}) => {
                    data.map(function (item) {
                        item.time = new Date(item.time * 1000);
                        item.toShow = true;
                        return item;
                    });
                    commit('setEvents', data);
                });
        },
        changeEventsVisibility({state, commit}, eventsToShow) {
            let events = this.getters.events;
            if (eventsToShow.length === 0) {
                for (let i = 0; i < events.length; i++) {
                    events[i].toShow = true;
                }
            } else {
                for (let i = 0; i < events.length; i++) {
                    events[i].toShow = eventsToShow.includes(events[i].type);
                }
            }
            commit('setEvents', events);
        }
    }
});
