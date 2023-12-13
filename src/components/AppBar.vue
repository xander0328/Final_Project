<template>
    <v-app-bar :elevation="5">
        <template v-slot:prepend>
            <v-avatar class="rounded-0" image="/dar.svg"></v-avatar>
        </template>
        <v-app-bar-title>
            <div>Department of Agrarian Reform</div>
            <div class="text-subtitle-2">Oriental Mindoro</div>
        </v-app-bar-title>
        <template v-slot:append>
            <div :class="{ 'd-none': !isDesktop }" class="text-left">
                <v-menu open-on-hoverv-model="menu" :close-on-content-click="false" location="bottom">
                    <template v-slot:activator="{ props }">
                        <v-btn v-bind="props" icon>
                            <v-avatar :image="profile"></v-avatar>
                        </v-btn>
                    </template>

                    <v-list class="text-left">
                        <v-list-item :title="name" :subtitle="role" value="profile">
                            <template v-slot:prepend>
                                <v-icon color="success" icon="mdi mdi-account-circle" size="x-large"></v-icon>
                            </template>
                        </v-list-item>

                        <v-list-item value="logout">
                            <v-list-item-title >Logout</v-list-item-title>
                            <template v-slot:prepend>
                                <v-icon color="error" icon="mdi mdi-logout-variant" size="x-large"></v-icon>
                            </template>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </div>
        </template>
    </v-app-bar>
</template>
<script>
import axios from 'axios'
import { storage } from '@/firebase';
import { ref, getDownloadURL } from 'firebase/storage';
export default {
    name: "appBar",
    data() {
        return {
            isDesktop: false,
            role: '',
            profile: '',
            name: '',
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
        async checkAccount() {
            const d = await axios.post('check_navbar', {
                token: sessionStorage.getItem('token')
            });
            this.role = d.data.role.toUpperCase();
            this.name = d.data.name;

            getDownloadURL(ref(storage, d.data.profile)).then(
                (download_url) => (this.profile = download_url)
            )
        },
        updateBreakpoint() {
            return document.documentElement.clientWidth > 800;
        },

        onResize() {
            this.isDesktop = this.updateBreakpoint();
            console.log("Tab width:", document.documentElement.clientWidth, this.updateBreakpoint());
        },

        //test
        openFileInNewTab(link) {
            // Replace 'path/to/your/file.txt' with the actual path to your file
            const filePath = link;

            // Create a file URL
            // const fileURL = URL.createObjectURL(new Blob([filePath]));

            // Open the file URL in a new tab
            window.open(filePath, '_blank');
        }

    },
}
</script>
<style lang="">
    
</style>