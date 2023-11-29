<template>
    <v-app>

        <appBar></appBar>
        <navDrawer></navDrawer>

        <v-main style="height: 250px">
            <taskPanel></taskPanel>
        </v-main>
    </v-app>
</template>

<script>
import navDrawer from '../components/NavDrawer.vue'
import bottomNav from '../components/BottomNav.vue'
import taskPanel from '../components/Clerk/TaskPanel.vue'
import appBar from '../components/AppBar.vue'
import lightbox from '../components/Lightbox.vue'

export default {
    name: 'Admin',
    components: {
        navDrawer, bottomNav, taskPanel, appBar, lightbox,
    },
}
</script>


