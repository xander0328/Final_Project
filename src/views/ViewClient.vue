<template>
    <v-app>
        <appBar></appBar>
        <navDrawer></navDrawer>
        <vue-easy-lightbox :visible="visibleRef" :imgs="imgsRef" :index="indexRef" @hide="onHide" />

        <v-main style="height: 250px" class="overflow-auto">
            <v-card :elevation="0">
                <v-toolbar color="light-green-lighten-2">
                    <v-toolbar-title>
                        <div v-for="info in info">{{ info.fname + ' ' + info.lname }}</div>
                        <div class="text-body-2">Client Name</div>
                    </v-toolbar-title>
                    <v-btn v-for="info in info" @click="approve(info.acc_id, 'true', 'Account is approved')" class="rounded-lg me-2" color="light-green-darken-1" variant="flat"
                        prepend-icon="mdi mdi-check-circle-outline">
                        Approve
                    </v-btn>
                    <v-btn v-for="info in info" @click="approve(info.acc_id, 'false', 'Account is declined')" class="rounded-lg" color="red-lighten-1" variant="flat" prepend-icon="mdi mdi-cancel">
                        Decline
                    </v-btn>
                </v-toolbar>

                <div class="ma-5"><div :class="{'d-flex' : isDesktop}">
                        <v-col :cols="{'5' : !isDesktop}" v-for="info in info">
                            <v-card elevation="3" class="mx-auto" title="Data Input">
                                <v-card-text>
                                    <v-container>
                                        <v-row class="text-center" align="center" justify="center"><v-col>
                                                <v-avatar size="100" class="mb-3"
                                                    image="https://randomuser.me/api/portraits/men/4.jpg"></v-avatar>
                                                <v-table>
                                                    <tr>
                                                        <th>First Name:</th>
                                                        <td>{{ info.fname }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Middle Name:</th>
                                                        <td>{{ info.mname }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Last Name:</th>
                                                        <td>{{ info.lname }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Birthday:</th>
                                                        <td>{{ info.birth }}</td>
                                                    </tr>
                                                    <br>
                                                    <tr>
                                                        <th>Baranggay:</th>
                                                        <td>{{ info.baranggay }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>City:</th>
                                                        <td>{{ info.city }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Province:</th>
                                                        <td>{{ info.province }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Contact:</th>
                                                        <td>{{ info.phone }}
                                                        </td>
                                                    </tr>
                                                </v-table></v-col></v-row>
                                    </v-container>

                                </v-card-text>
                            </v-card>
                        </v-col>
                        <v-col v-for="info in info">
                            <v-card elevation="3" title="Identification Card">
                                <v-card-text>
                                    <v-container v-for="(img, index) in imgsRef" :key="index">
                                        <v-row align="center" justify="center">
                                            <button @click="openLightbox(index)">
                                                <img class="mx-auto" :width="500" aspect-ratio="16/9" cover :src="img"
                                                    alt="Image"
                                                    style="max-width: 100%; heightvscode-file://vscode-app/c:/Users/universal/AppData/Local/Programs/Microsoft%20VS%20Code/resources/app/out/vs/code/electron-sandbox/workbench/workbench.html: auto; cursor: pointer;">
                                            </button>
                                        </v-row>
                                    </v-container>

                                </v-card-text>
                            </v-card>
                        </v-col></div>
                </div>

            </v-card>
        </v-main>
    </v-app>
</template>

<script>
import navDrawer from '../components/NavDrawer.vue'
import bottomNav from '../components/BottomNav.vue'
import appBar from '../components/AppBar.vue'

import { defineComponent } from 'vue'
import VueEasyLightbox, { useEasyLightbox } from 'vue-easy-lightbox'
import axios from 'axios'
import router from '@/router'

export default {
    name: 'Admin',
    components: {
        navDrawer, bottomNav, appBar, VueEasyLightbox
    },
    data() {
        return {
            isDesktop: false,
            tab: 'option-1',
            info: [],
        }
    },
    mounted() {
        this.isDesktop = this.updateBreakpoint();
        window.addEventListener('resize', this.onResize);
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.onResize);
    },
    created() {
        this.getInfo();
    },
    methods: {
        async approve(client, ver, msg) {
            const data = await axios.post('approveClient', {
                id: client,
                verify: ver,
                message: msg
            });
            sessionStorage.setItem('message', data.message);
            this.$router.replace('/clerk');
        },
        async getInfo() {
            const d = await axios.post('getClientData', {
                id: sessionStorage.getItem('id')
            });
            this.info = d.data;
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

    },
    setup() {
        const {
            // methods
            show, onHide, changeIndex,
            // refs
            visibleRef, indexRef, imgsRef
        } = useEasyLightbox({
            // src / src[]
            imgs: [
                'https://legaldbol.com/wp-content/uploads/2019/03/78-Standard-Id-Card-Template-Landscape-Now-with-Id-Card-Template-Landscape.jpg',
            ],
            // initial index
            initIndex: 0
        })

        const openLightbox = (index) => {
            changeIndex(index);
            show();
        };

        return {
            visibleRef,
            indexRef,
            imgsRef,
            show,
            onHide,
            openLightbox
        }
    }
}
</script>

<style>
th {
    font-weight: 500;
    text-align: end;
    padding-right: 1rem;
}

td {
    text-align: left;
}
</style>
