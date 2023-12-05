<template>
    <v-app>

        <appBar></appBar>
        <navDrawer></navDrawer>

        <v-main style="height: 250px" class="overflow-auto">
            <v-toolbar class="overflow-auto" color="light-green-lighten-2">
                <v-toolbar-title>
                    <div>Application</div>
                    <div class="text-body-2">Issuance of Land Transfer Clearance</div>
                </v-toolbar-title>
            </v-toolbar>
            <v-stepper density="compact" elevation="0" :model-value="phase" alt-labels>
                <v-stepper-header>
                    <v-stepper-item color="green" subtitle="Information" value="1"></v-stepper-item>

                    <v-divider></v-divider>

                    <v-stepper-item color="green" subtitle="Documents" value="2"></v-stepper-item>

                    <v-divider></v-divider>

                    <v-stepper-item color="green" subtitle="Download" value="3"></v-stepper-item>
                </v-stepper-header>
            </v-stepper>
            <v-col v-if="phase == '1'">
                <v-form>
                    <v-card :elevation="3" class="mb-3">
                        <v-card-text>
                            <div class="text-h6 mb-2">Transferor</div>
                            <v-text-field :counter="10" label="First Name"></v-text-field>
                            <v-text-field :counter="10" label="Middle Name"></v-text-field>
                            <v-text-field :counter="10" label="Last Name"></v-text-field>
                            <div class="text-h6 mb-2">Transferee</div>
                            <v-text-field :counter="10" label="First Name"></v-text-field>
                            <v-text-field :counter="10" label="Middle Name"></v-text-field>
                            <v-text-field :counter="10" label="Last Name"></v-text-field>
                            <div class="text-h6 mb-2">Applicants' Address</div>

                            <v-col :class="{ 'pb-0': isDesktop, 'pa-0': !isDesktop }">
                                <v-autocomplete label="Province" :items="province" item-title="name" item-value="code">
                                    <template v-slot:item="{ props, item }">
                                        <v-list-item @click="updateCity(item?.raw)" v-bind="props"
                                            :title="item?.raw?.name"></v-list-item>
                                    </template>
                                </v-autocomplete>
                            </v-col>
                            <div :class="{ 'd-flex': isDesktop }">
                                <v-col :class="{ 'pa-0': !isDesktop }">
                                    <v-autocomplete label="City/Municipality" :items="city" item-title="name"
                                        item-value="code">
                                        <template v-slot:item="{ props, item }">
                                            <v-list-item @click="updateBrgy(item?.raw)" v-bind="props"
                                                :title="item?.raw?.name"></v-list-item>
                                        </template>
                                    </v-autocomplete>
                                </v-col>
                                <v-col :class="{ 'pa-0': !isDesktop }">
                                    <v-autocomplete label="Barangay" :items="barangay" item-title="name" item-value="code">
                                        <template v-slot:item="{ props, item }">
                                            <v-list-item @click="setBrgy(item?.raw)" v-bind="props"
                                                :title="item?.raw?.name"></v-list-item>
                                        </template>
                                    </v-autocomplete>
                                </v-col>
                            </div>
                        </v-card-text>
                    </v-card>
                    <v-card :elevation="3" class="mb-3">
                        <v-card-text>
                            <div class="text-h6 mb-2">Mode of Conveyance</div>
                            <v-autocomplete label="Select a mode" :items="conveyance" item-title="name" item-value="name">
                            </v-autocomplete>
                            <div class="text-h6 mb-2">Land Information</div>
                            <v-row>
                                <v-col :class="{ 'pa-0': !isDesktop }">
                                    <v-text-field :counter="10" label="TCT/OCT No."></v-text-field>
                                </v-col>
                                <v-col :class="{ 'pa-0': !isDesktop }">
                                    <v-text-field :counter="10" label="Lot No."></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col :class="{ 'pa-0': !isDesktop }">
                                    <v-text-field :counter="10" label="Survey No."></v-text-field>
                                </v-col>
                                <v-col :class="{ 'pa-0': !isDesktop }">
                                    <v-text-field type="number" min="1" max="5" label="Area (hectares)"></v-text-field>
                                </v-col>
                            </v-row>
                            <div class="text-subtitle-1 mb-2">Location</div>
                            <v-col :class="{ 'pb-0': isDesktop, 'pa-0': !isDesktop }">
                                <v-autocomplete label="Province" :items="province" item-title="name" item-value="code">
                                    <template v-slot:item="{ props, item }">
                                        <v-list-item @click="updateCity(item?.raw)" v-bind="props"
                                            :title="item?.raw?.name"></v-list-item>
                                    </template>
                                </v-autocomplete>
                            </v-col>
                            <div :class="{ 'd-flex': isDesktop }">
                                <v-col :class="{ 'pa-0': !isDesktop }">
                                    <v-autocomplete label="City/Municipality" :items="city" item-title="name"
                                        item-value="code">
                                        <template v-slot:item="{ props, item }">
                                            <v-list-item @click="updateBrgy(item?.raw)" v-bind="props"
                                                :title="item?.raw?.name"></v-list-item>
                                        </template>
                                    </v-autocomplete>
                                </v-col>
                                <v-col :class="{ 'pa-0': !isDesktop }">
                                    <v-autocomplete label="Barangay" :items="barangay" item-title="name" item-value="code">
                                        <template v-slot:item="{ props, item }">
                                            <v-list-item @click="setBrgy(item?.raw)" v-bind="props"
                                                :title="item?.raw?.name"></v-list-item>
                                        </template>
                                    </v-autocomplete>
                                </v-col>
                            </div>
                        </v-card-text>
                    </v-card>
                    <div class="text-right">
                        <v-btn @click="" color="green-darken-4" append-icon="mdi mdi-chevron-right">Next</v-btn>
                    </div>
                </v-form>
            </v-col>
            <v-col v-if="phase == '2'">
                <v-expansion-panels class="mb-3" v-model="panel">
                    <v-expansion-panel title="For the Transferor">
                        <template v-slot:text>
                            <v-card :class="{ 'ma-2': isDesktop }">
                                <v-list density="compact" justify="center">
                                    <v-list-item>
                                        <div :class="{ 'd-flex': isDesktop }">
                                            <v-col>
                                                <div>Application for Issuance of Land Transfer Clearance</div>
                                            </v-col>
                                            <v-col cols="">
                                                <div><v-file-input density="compact"></v-file-input></div>
                                            </v-col>
                                        </div>
                                        <hr v-if="!isDesktop">
                                    </v-list-item>
                                    <v-list-item>
                                        <div :class="{ 'd-flex': isDesktop }">
                                            <v-col>
                                                <div>Official Receipt and Electronic Copy of the Title</div>
                                            </v-col>
                                            <v-col>
                                                <div><v-file-input density="compact"></v-file-input></div>
                                            </v-col>
                                        </div>
                                        <hr v-if="!isDesktop">
                                    </v-list-item>
                                    <v-list-item>
                                        <div :class="{ 'd-flex': isDesktop }">
                                            <v-col>
                                                <div>Deed or document to be registered </div>
                                            </v-col>
                                            <v-col>
                                                <div><v-file-input density="compact"></v-file-input></div>
                                            </v-col>
                                        </div>
                                        <hr v-if="!isDesktop">
                                    </v-list-item>
                                    <v-list-item>
                                        <div :class="{ 'd-flex': isDesktop }">
                                            <v-col>
                                                <div>Affidavit of Aggregate Landholding</div>
                                            </v-col>
                                            <v-col>
                                                <div><v-file-input density="compact"></v-file-input></div>
                                            </v-col>
                                        </div>
                                        <hr v-if="!isDesktop">
                                    </v-list-item>
                                    <v-list-item>
                                        <div :class="{ 'd-flex': isDesktop }">
                                            <v-col>
                                                <div>Affidavit of Retention, Non-tenancy/tenancy</div>
                                            </v-col>
                                            <v-col>
                                                <div><v-file-input density="compact"></v-file-input></div>
                                            </v-col>
                                        </div>
                                        <hr v-if="!isDesktop">
                                    </v-list-item>
                                    <v-list-item>
                                        <div :class="{ 'd-flex': isDesktop }">
                                            <v-col>
                                                <div>Municipal Assessor's Certificate of Aggregate Landholding</div>
                                            </v-col>
                                            <v-col>
                                                <div><v-file-input density="compact"></v-file-input></div>
                                            </v-col>
                                        </div>
                                        <hr v-if="!isDesktop">
                                    </v-list-item>
                                    <v-list-item>
                                        <div :class="{ 'd-flex': isDesktop }">
                                            <v-col>
                                                <div>City Assessor's Certificate of Aggregate Landholding</div>
                                            </v-col>
                                            <v-col>
                                                <div><v-file-input density="compact"></v-file-input></div>
                                            </v-col>
                                        </div>
                                        <hr v-if="!isDesktop">
                                    </v-list-item>
                                    <v-list-item>
                                        <div :class="{ 'd-flex': isDesktop }">
                                            <v-col>
                                                <div>Provincial Assessor's Certificate of Aggregate Landholding</div>
                                            </v-col>
                                            <v-col>
                                                <div><v-file-input density="compact"></v-file-input></div>
                                            </v-col>
                                        </div>
                                    </v-list-item>
                                </v-list>
                            </v-card>
                        </template>
                    </v-expansion-panel>
                    <v-expansion-panel title="For the Transferee">
                        <template v-slot:text>
                            <v-card :class="{ 'ma-2': isDesktop }">
                                <v-list>
                                    <v-list-item>
                                        <div :class="{ 'd-flex': isDesktop }">
                                            <v-col>
                                                <div>Affidavit of Aggregate Landholding</div>
                                            </v-col>
                                            <v-col>
                                                <div><v-file-input density="compact"></v-file-input></div>
                                            </v-col>
                                        </div>
                                        <hr v-if="!isDesktop">
                                    </v-list-item>

                                    <v-list-item>
                                        <div :class="{ 'd-flex': isDesktop }">
                                            <v-col>
                                                <div>Municipal Assessor's Certificate of Aggregate Landholding</div>
                                            </v-col>
                                            <v-col>
                                                <div><v-file-input density="compact"></v-file-input></div>
                                            </v-col>
                                        </div>
                                        <hr v-if="!isDesktop">
                                    </v-list-item>
                                    <v-list-item>
                                        <div :class="{ 'd-flex': isDesktop }">
                                            <v-col>
                                                <div>City Assessor's Certificate of Aggregate Landholding</div>
                                            </v-col>
                                            <v-col>
                                                <div><v-file-input density="compact"></v-file-input></div>
                                            </v-col>
                                        </div>
                                        <hr v-if="!isDesktop">
                                    </v-list-item>
                                    <v-list-item>
                                        <div :class="{ 'd-flex': isDesktop }">
                                            <v-col>
                                                <div>Provincial Assessor's Certificate of Aggregate Landholding</div>
                                            </v-col>
                                            <v-col>
                                                <div><v-file-input density="compact"></v-file-input></div>
                                            </v-col>
                                        </div>
                                        <hr v-if="!isDesktop">
                                    </v-list-item>
                                    <v-list-item>
                                        <div :class="{ 'd-flex': isDesktop }">
                                            <v-col>
                                                <div>Municipal Agrarian Reform Program Officer Certification</div>
                                            </v-col>
                                            <v-col>
                                                <div><v-file-input density="compact"></v-file-input></div>
                                            </v-col>
                                        </div>
                                    </v-list-item>
                                </v-list>
                            </v-card>
                        </template>
                    </v-expansion-panel>
                </v-expansion-panels>
                <div class="text-right">
                    <v-btn class="me-2" color="green-darken-2" prepend-icon="mdi mdi-chevron-left">Back</v-btn>
                    <v-btn color="green-darken-4" append-icon="mdi mdi-chevron-right">Next</v-btn>
                </div>
            </v-col>
            <v-col v-if="phase == '3'">
                <v-form>
                    <div class="text-center">
                        <v-btn @click="" color="green-darken-4" prepend-icon="mdi mdi-file-pdf-box">
                            Download Application Form
                        </v-btn>
                        <v-col>
                            <iframe :src="pdfUrl" width="100%" height="600px"></iframe>
                        </v-col>
                    </div>
                </v-form>
            </v-col>
        </v-main>
        <bottomNav></bottomNav>
    </v-app>
</template>

<script>
import navDrawer from '../components/NavDrawer.vue'
import bottomNav from '../components/BottomNav.vue'
import appBar from '../components/AppBar.vue'
import axios from 'axios'

export default {
    name: 'Client',
    components: {
        navDrawer, bottomNav, appBar,
    },
    data() {
        return {
            conveyance: ['Deed of Sale', 'Deed of Donation', ''],
            isDesktop: false,
            panel: [0, 1],
            phase: '3',
            barangay: [],
            city: [],
            province: [],
            selectedProvince: [],
            selectedCity: [],
            selectedBrgy: [],
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
        this.loadprovince();
    },
    methods: {

        async loadprovince() {
            const d = await axios.get('https://psgc.gitlab.io/api/provinces/');
            this.province = d.data;

        },
        async updateCity(a) {
            // console.log(a);
            this.selectedProvince = a;
            const d = await axios.get('https://psgc.gitlab.io/api/provinces/' + this.selectedProvince.code + '/cities-municipalities');
            this.city = d.data;

        },
        async updateBrgy(a) {
            // console.log(a);
            this.selectedCity = a;
            const d = await axios.get('https://psgc.gitlab.io/api/cities-municipalities/' + this.selectedCity.code + '/barangays');
            this.barangay = d.data;

        },
        async setBrgy(a) {
            this.selectedProvince = a;
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


