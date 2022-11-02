export const EventTypesMappingMixin = {
    data() {
        return {
            eventTypes: {
                'CONFERENCE': {
                    name: 'Conference',
                    short: '--conf'
                },
                'MEETING_WITH_EXPERT': {
                    name: 'Meeting with an expert',
                    short: '--metexp',
                },
                'WEBINAR': {
                    name: 'Webinar',
                    short: '--web'
                },
                'QUESTION_ANSWER': {
                    name: 'Question-answer',
                    short: '--qa',
                }
            }
        }
    }
}
