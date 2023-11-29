<template>
    <v-app>
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


        <v-app-bar :elevation="5">
            <template v-slot:prepend>
                <v-avatar class="rounded-0" image="dar.svg"></v-avatar>
            </template>
            <v-app-bar-title>
                <div>Department of Agrarian Reform</div>
                <div class="text-subtitle-2">MIMAROPA Region</div>
            </v-app-bar-title>
            <template v-slot:append>
                <div :class="{ 'd-none': !isDesktop }" class="text-left">
                    <v-menu open-on-hoverv-model="menu" :close-on-content-click="false" location="bottom">
                        <template v-slot:activator="{ props }">
                            <v-btn v-bind="props" icon>
                                <v-avatar image="https://randomuser.me/api/portraits/women/85.jpg"></v-avatar>
                            </v-btn>
                        </template>

                        <v-list class="text-left">
                            <v-list-item title="Jenny Lim" subtitle="Clerk" value="profile">
                                <template v-slot:prepend>
                                    <v-icon color="success" icon="mdi mdi-account-circle" size="x-large"></v-icon>
                                </template>
                            </v-list-item>

                            <v-list-item value="logout">
                                <v-list-item-title class="text-body-2">Logout</v-list-item-title>
                                <template v-slot:prepend>
                                    <v-icon color="error" icon="mdi mdi-logout-variant" size="x-large"></v-icon>
                                </template>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </div>
            </template>
        </v-app-bar>
        <v-navigation-drawer app class="bg-light-green-lighten-1" expand-on-hover v-bind:rail="isDesktop"
            v-bind:permanent="isDesktop">

            <v-list density="compact" nav>
                <v-list-item :class="{ 'v-list-item--active': isActive('/clerk') }"  @click="$router.replace('/clerk')" prepend-icon="mdi mdi-format-list-text" title="Task" value="/clerk"></v-list-item>
                <v-list-item :class="{ 'v-list-item--active': isActive('/message') }"  @click="$router.replace('/message')" prepend-icon="mdi mdi-message-outline" title="Messages" value="shared"></v-list-item>
                <v-list-item prepend-icon="mdi-star" title="Starred" value="starred"></v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-main style="height: 250px">
            <v-card :elevation="0">
                <v-toolbar color="light-green-lighten-3">
                    <v-toolbar-title>Tasks</v-toolbar-title>
                </v-toolbar>
                <div class="d-flex flex-row">
                    <v-tabs v-model="tab" direction="vertical" color="light-green-darken-3">
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

                    <v-window v-model="tab"><v-col cols="12">
                            <v-window-item value="option-1">

                                <v-card flat><v-card-text>
                                        <v-expansion-panels>
                                            <v-expansion-panel title="Item"
                                                text="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."></v-expansion-panel>
                                        </v-expansion-panels>
                                    </v-card-text></v-card>

                            </v-window-item></v-col>
                        <v-window-item value="option-2">
                            <v-card flat>
                                <v-card-text>
                                    <p>

                                    </p>
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
        </v-main>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            isDesktop: false,
            tab: 'option-1',
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

        //test
        openFileInNewTab() {
            // Replace 'path/to/your/file.txt' with the actual path to your file
            const filePath = './dar.svg';

            // Create a file URL
            // const fileURL = URL.createObjectURL(new Blob([filePath]));

            // Open the file URL in a new tab
            window.open(filePath, '_blank');
        }

    },
}
</script>


