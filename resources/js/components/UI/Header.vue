<template>
    <div class="header">
        <div class="header__left-side">
            <div class="header__logo">
                LOGO
            </div>
        </div>
        <div class="header__right-side">
            <div class="header__menu">
                <div
                    v-for="item in menuItems"
                    class="header__menu--item"
                    :class="{ 'header__menu--active': currentPage === item.link }"
                >
                    <a :href="item.link" :class="{ 'disabled-link': item.disabled }">
                        {{item.title}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {MainMenuMixin} from '../../mixins/main_menu';

export default {
    name: "Header",
    mixins: [MainMenuMixin],
    data() {
        return {
            currentPage: ''
        }
    },
    mounted() {
        this.calculateCurrentPage();
    },
    methods: {
        calculateCurrentPage() {
            this.$set(this, 'currentPage', this.$route.fullPath);
        }
    }
}
</script>
