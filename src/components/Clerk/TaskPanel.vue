<template>
    <v-card :elevation="0">
        <v-toolbar color="light-green-lighten-2">
            <v-toolbar-title>Tasks</v-toolbar-title>
        </v-toolbar>
        <div>
            <v-tabs v-model="tab" fixed-tabs color="green-darken-4">
                <v-tab value="option-1">
                    <v-icon start>
                        mdi-account
                    </v-icon>
                    Account Verification
                </v-tab>
                <v-tab value="option-2">
                    <v-icon start>
                        mdi mdi-file-check
                    </v-icon>
                    Receipt Confirmation
                </v-tab>
                <v-tab value="option-3">
                    <v-icon start>
                        mdi mdi-certificate
                    </v-icon>
                    Certification
                </v-tab>
            </v-tabs>


            <v-window v-model="tab">
                <v-window-item value="option-1">
                    <v-card><v-card-text>
                            <v-skeleton-loader :loading="loading" v-for="verify in verify" type="list-item-avatar">
                                <v-row no-gutter><v-col class="mb-2"><v-card elevation="5" class="mx-auto"
                                            :title="verify.fname + ' ' + verify.lname"
                                            v-bind:prepend-avatar="verify.profile">
                                            <template v-slot:append>
                                                <v-card-actions @click="viewClient(verify.id)">
                                                    <v-btn>Review</v-btn>
                                                </v-card-actions>
                                            </template>
                                        </v-card></v-col></v-row>
                            </v-skeleton-loader>
                        </v-card-text></v-card>
                </v-window-item>
                <v-window-item value="option-2">
                    <v-card flat>
                        <v-card-text>

                        </v-card-text>
                    </v-card>
                </v-window-item>
                <v-window-item value="option-3">
                    <v-card flat>
                        <v-card-text>
                            <p>

                            </p>
                        </v-card-text>
                    </v-card>
                </v-window-item>
            </v-window>
        </div>
    </v-card>
</template>

<script>
import { storage } from '@/firebase';
import { ref, getDownloadURL } from 'firebase/storage';
import axios from 'axios'
import router from '@/router'

export default {
    name: 'taskPanel',
    data() {
        return {
            loading: true,
            isDesktop: false,
            tab: 'option-1',
            verify: [],
            receipt: [],
            image: 'client_files/download.jpg',
        }
    },
    async mounted() {
        setTimeout(() => {
            this.loading = false;
            console.log('myVariable is now false.');
        }, 1000);
        this.interval = setInterval(async () => { await this.getInfo(); }, 3000);

        this.isDesktop = this.updateBreakpoint();
        window.addEventListener('resize', this.onResize);


    },
    beforeDestroy() {
        window.removeEventListener('resize', this.onResize);
        clearInterval(this.interval);
    },
    created() {
        this.getInfo();

    },
    methods: {
        async viewClient(data) {
            sessionStorage.setItem('id', data);
            this.$router.push('/clerk/view_client');
        },
        async getInfo() {
            try {
                const inf = await axios.get('getClerkTask');
                

                if(this.verify.length != inf.data.verify.length){
                    this.verify = inf.data.verify
                    for (let img of this.verify) {
                    getDownloadURL(ref(storage, img.profile)).then(
                        (download_url) => (img.profile = download_url)
                    )
                }
                }
                
                
            } catch (error) {
                console.log(error);
            }
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
}
</script>