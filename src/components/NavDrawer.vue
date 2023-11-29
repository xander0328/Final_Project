<template>
    <v-navigation-drawer app class="bg-green-darken-4" :width="220" expand-on-hover v-bind:rail="!isDesktop" permanent>
        <v-list density="compact" nav>
            <v-list-item :class="{ 'v-list-item--active': isActive('/clerk') }" @click="$router.replace('/clerk')"
                prepend-icon="mdi mdi-format-list-text" title="Task" value="/clerk"></v-list-item>
            <v-list-item :class="{ 'v-list-item--active': isActive('/messages') }" @click="$router.replace('/messages')"
                prepend-icon="mdi mdi-message-outline" title="Messages" value="shared"></v-list-item>
            <v-list-item prepend-icon="mdi-star" title="Starred" value="starred"></v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
export default {
    name: 'navDrawer',
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