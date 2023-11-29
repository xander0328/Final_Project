<template>
    <v-bottom-navigation v-if="!isDesktop" class="bg-light-green-lighten-1" color="primary">
        <v-btn>
            <v-icon>mdi-history</v-icon>
            Recents
        </v-btn>

        <v-btn>
            <v-icon>mdi-heart</v-icon>
            Favorites
        </v-btn>

        <v-btn>
            <v-icon>mdi-map-marker</v-icon>
            Nearby
        </v-btn>
    </v-bottom-navigation>
</template>

<script>
export default {
    name: 'bottomNav',
    data() {
        return {
            isDesktop: false,
        }
    },
    mounted() {
        this.isDesktop = this.updateBreakpoint();
        window.addEventListener('resize', this.onResize);
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.onResize);
    },
    methods: {
        isActive(route) {
            return this.$route.path === route;
        },
        updateBreakpoint() {
            return document.documentElement.clientWidth > 800;
        },

        onResize() {
            this.isDesktop = this.updateBreakpoint();
            console.log("Tab width:", document.documentElement.clientWidth, this.updateBreakpoint());
        },
    }
}
</script>