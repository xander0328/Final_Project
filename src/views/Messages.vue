<template>
    <v-app>

        <appBar></appBar>
        <navDrawer></navDrawer>

        <v-main style="height: 250px">
            <v-card :elevation="0">
                <v-toolbar color="light-green-lighten-2">
                    <v-toolbar-title>Messages</v-toolbar-title>
                </v-toolbar>
            </v-card>
        </v-main>
    </v-app>
</template>

<script>
import navDrawer from '../components/NavDrawer.vue'
import bottomNav from '../components/BottomNav.vue'
import appBar from '../components/AppBar.vue'


export default {
    name: 'Messages',
    components: {
        navDrawer, bottomNav, appBar,
    },
}
</script>


