<template>
    <v-navigation-drawer v-if="isDesktop" app class="bg-green-darken-4" :width="220" expand-on-hover v-bind:rail="!isDesktop" permanent>
        <v-list v-if="role === 'clerk'" density="compact" nav>
            <v-list-item :class="{ 'v-list-item--active': isActive('/clerk') }" @click="$router.replace('/clerk')"
                prepend-icon="mdi mdi-format-list-text" title="Task" value="/clerk"></v-list-item>
            <v-list-item :class="{ 'v-list-item--active': isActive('/messages') }" @click="$router.replace('/messages')"
                prepend-icon="mdi mdi-message-outline" title="Messages" value="shared"></v-list-item>
            <v-list-item prepend-icon="mdi-star" title="Starred" value="starred"></v-list-item>
        </v-list>
        <v-list v-if="role === 'client'" density="compact" nav>
                <v-list-item :class="{ 'v-list-item--active': isActive('/client') }" @click="$router.replace('/client')"
                    prepend-icon="mdi mdi-file-outline" title="Application" value="/clerk"></v-list-item>
                <v-list-item :class="{ 'v-list-item--active': isActive('/messages') }" @click="$router.replace('/messages')"
                    prepend-icon="mdi mdi-message-outline" title="Messages" value="shared"></v-list-item>
                <v-list-item prepend-icon="mdi-star" title="Starred" value="starred"></v-list-item>
            </v-list>
    </v-navigation-drawer>
</template>

<script>
import axios from 'axios'

export default {
    name: 'navDrawer',
    data() {
        return {
            isDesktop: false,
            role: 'client',
        }
    },
    mounted() {
        this.isDesktop = this.updateBreakpoint();
        window.addEventListener('resize', this.onResize);
        this.checkAccount();
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.onResize);
    },
    methods: {
        async checkAccount(){
            const d = await axios.post('check_navbar', {
                token: sessionStorage.getItem('token')
            });
            this.role = d.data.role;
            
        },
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