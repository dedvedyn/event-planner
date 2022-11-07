export const EventTypesMappingMixin = {
    data() {
        return {
            eventTypes: {
                'MEETING_WITH_EXPERT': {
                    name: 'Meeting with an expert',
                    short: '--metexp',
                    color: '#FF4E6B',
                    isActive: false
                },
                'QUESTION_ANSWER': {
                    name: 'Question-answer',
                    short: '--qa',
                    color: '#00CC66',
                    isActive: false
                },
                'CONFERENCE': {
                    name: 'Conference',
                    short: '--conf',
                    color: '#FFBB33',
                    isActive: false
                },
                'WEBINAR': {
                    name: 'Webinar',
                    short: '--web',
                    color: '#4DB4FF',
                    isActive: false
                }
            }
        }
    }
}
