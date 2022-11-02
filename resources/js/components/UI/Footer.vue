<template>
    <div class="footer">
        <div class="footer__content">
            <div class="footer__logo">
                LOGO
            </div>
            <div class="footer__menu">
                <div v-for="item in menuItems" class="footer__menu--item">
                    <a :href="item.link" :class="{ 'disabled-link': item.disabled }">
                        {{item.title}}
                    </a>
                </div>
            </div>
            <div class="footer__description">
                © {{ currentYear }} All rights reserved
            </div>
        </div>
    </div>
</template>

<script>
import {MainMenuMixin} from '../../mixins/main_menu';

export default {
    name: "Footer",
    mixins: [MainMenuMixin],
    data() {
        return {
            currentYear: 2022
        }
    },
    mounted() {
        this.$set(this, 'currentYear', new Date().getFullYear());
    }
}
</script>
