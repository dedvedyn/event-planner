export const MainMenuMixin = {
    data() {
        return {
            menuItems: [
                {
                    title: 'Main',
                    link: '/main',
                    disabled: true,
                    active: false
                },
                {
                    title: 'Events',
                    link: '/events',
                    disabled: true,
                    active: false
                },
                {
                    title: 'Calendar',
                    link: '/calendar',
                    disabled: false,
                    active: false
                },
                {
                    title: 'FAQ',
                    link: '/faq',
                    disabled: true,
                    active: false
                },
            ]
        }
    }
}
