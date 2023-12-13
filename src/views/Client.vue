<template>
    <v-app>

        <appBar></appBar>
        <navDrawer></navDrawer>

        <v-main v-if="section == '3'" style="height: 250px" class="overflow-auto">
            <!-- <v-toolbar class="overflow-auto" color="light-green-lighten-2">
                <v-toolbar-title>
                    <div>Application</div>
                    <div class="text-body-2">Issuance of Land Transfer Clearance</div>
                </v-toolbar-title>
            </v-toolbar> -->
            <v-container class="fill-height">
                <v-row justify="center" align="center">
                    <v-col elevation="5" class="text-center"><span class="text-h4 text-green-darken-3">Thank you for
                            registering!</span> <br> Your account is under review. We'll notify you once verified.
                        <br>Appreciate your patience!
                    </v-col>
                </v-row>
            </v-container>
        </v-main>

        <v-main v-if="section == '4'" style="height: 250px" class="overflow-auto">
            <v-toolbar class="overflow-auto" color="light-green-lighten-2">
                <v-toolbar-title>
                    <div>Application</div>
                    <div class="text-body-2">Issuance of Land Transfer Clearance</div>
                </v-toolbar-title>
            </v-toolbar>
            <v-stepper density="compact" elevation="0" :model-value="window" alt-labels>
                <v-stepper-header>
                    <v-stepper-item color="green" subtitle="Information" value="1"></v-stepper-item>

                    <v-divider></v-divider>

                    <v-stepper-item color="green" subtitle="Download" value="2"></v-stepper-item>

                    <v-divider></v-divider>

                    <v-stepper-item color="green" subtitle="Documents" value="3"></v-stepper-item>
                </v-stepper-header>
            </v-stepper>
            <v-col v-if="window === '1'">
                <v-form @submit.prevent="apply()" ref="apply">
                    <v-card :elevation="3" class="mb-3">
                        <v-card-text>

                            <div class="text-h6 mb-2">Transferor(s)</div>
                            <div v-for="(input, index) in formData1.transferor" :key="input.no" class="transferee">
                                <hr v-if="input.no > 1" class="mb-2">
                                <v-row class="my-2" justify="space-between">
                                    <v-col>
                                        <div>Transferor No. {{ index + 1 }} </div>
                                    </v-col>
                                    <v-col class="text-end"><v-btn @click="removeTransferor(index)" color="red"
                                            density="compact" v-if="input.no > 1" variant='outlined'
                                            prepend-icon="mdi mdi-minus-circle-outline">Delete</v-btn>
                                    </v-col>
                                </v-row>
                                <v-text-field v-model="input.fname" :rules="rules.info" label="First Name"></v-text-field>
                                <v-text-field v-model="input.mname" label="Middle Name"></v-text-field>
                                <v-text-field v-model="input.lname" :rules="rules.info" label="Last Name"></v-text-field>

                            </div>
                            <div class="text-end mb-2"><v-btn @click="addTransferor()" color="light-green">Add
                                    Transferor</v-btn></div>

                            <div class="text-h6 mb-2">Transferee(s)</div>
                            <div v-for="(input, index) in formData1.transferee" :key="input.no" class="transferee">
                                <hr v-if="input.no > 1" class="mb-2">
                                <v-row class="my-2" justify="space-between">
                                    <v-col>
                                        <div>Transferee No. {{ index + 1 }} </div>
                                    </v-col>
                                    <v-col class="text-end">
                                        <v-btn @click="removeInput(index)" color="red" density="compact" v-if="input.no > 1"
                                            variant='outlined' prepend-icon="mdi mdi-minus-circle-outline">Delete</v-btn>
                                    </v-col>
                                </v-row>
                                <v-text-field v-model="input.fname" :rules="rules.info" label="First Name"></v-text-field>
                                <v-text-field v-model="input.mname" label="Middle Name"></v-text-field>
                                <v-text-field v-model="input.lname" :rules="rules.info" label="Last Name"></v-text-field>

                            </div>

                            <div class="text-end mb-2"><v-btn @click="addTransferee()" color="light-green">Add
                                    Transferee</v-btn></div>

                            <div class="text-h6 mb-2">Attorney-in-fact <span class="text-subtitle-2">(leave blank if
                                    none)</span></div>
                            <v-text-field v-model="formData1.spa.fname" :rules="rules.atty.fname"
                                label="First Name"></v-text-field>
                            <v-text-field v-model="formData1.spa.mname" label="Middle Name"></v-text-field>
                            <v-text-field v-model="formData1.spa.lname" :rules="rules.atty.lname"
                                label="Last Name"></v-text-field>

                            <div class="text-h6 mb-2">Applicants' Address</div>
                            <v-col :class="{ 'pa-0': !isDesktop }">
                                <v-autocomplete v-model="formData1.app_address.province" label="Province"
                                    :items="app.province" :rules="rules.info" item-title="name" item-value="item">
                                    <template v-slot:item="{ props, item }">
                                        <v-list-item @click="updateCity(item?.raw, 'app')" v-bind="props"
                                            :title="item?.raw?.name"></v-list-item>
                                    </template>
                                </v-autocomplete>
                            </v-col>
                            <div :class="{ 'd-flex': isDesktop }">
                                <v-col :class="{ 'pa-0': !isDesktop }">
                                    <v-autocomplete v-model="formData1.app_address.city" label="City/Municipality"
                                        :items="app.city" :rules="rules.info" item-title="name" item-value="item">
                                        <template v-slot:item="{ props, item }">
                                            <v-list-item @click="updateBrgy(item?.raw, 'app')" v-bind="props"
                                                :title="item?.raw?.name"></v-list-item>
                                        </template>
                                    </v-autocomplete>
                                </v-col>
                                <v-col :class="{ 'pa-0': !isDesktop }">
                                    <v-autocomplete v-model="formData1.app_address.barangay" label="Barangay"
                                        :items="app.barangay" :rules="rules.info" item-title="name" item-value="item">
                                        <template v-slot:item="{ props, item }">
                                            <v-list-item @click="setBrgy(item?.raw, 'app')" v-bind="props"
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
                            <v-text-field v-model="formData1.conveyance" :rules="rules.info" label="Mode"></v-text-field>
                            <div class="text-h6 mb-2">Land Information</div>
                            <v-row>
                                <v-col>
                                    <v-text-field v-model="formData1.tct" :rules="rules.info"
                                        label="TCT/OCT No."></v-text-field>
                                </v-col>
                                <v-col>
                                    <v-text-field v-model="formData1.lot" :rules="rules.info"
                                        label="Lot No."></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-text-field v-model="formData1.survey" :rules="rules.info"
                                        label="Survey No."></v-text-field>
                                </v-col>
                                <v-col>
                                    <v-text-field v-model="formData1.area" :rules="rules.info" type="number" min="1" max="5"
                                        label="Area (hectares)"></v-text-field>
                                </v-col>
                            </v-row>
                            <div class="text-subtitle-1 mb-2">Location</div>
                            <div :class="{ 'd-flex': isDesktop }">
                                <v-col :class="{ 'pa-0': !isDesktop }">
                                    <v-autocomplete v-model="formData1.land_address.city" :rules="rules.info"
                                        label="City/Municipality" :items="land.city" item-title="name" item-value="item">
                                        <template v-slot:item="{ props, item }">
                                            <v-list-item @click="updateBrgy(item?.raw, 'land')" v-bind="props"
                                                :title="item?.raw?.name"></v-list-item>
                                        </template>
                                    </v-autocomplete>
                                </v-col>
                                <v-col :class="{ 'pa-0': !isDesktop }">
                                    <v-autocomplete v-model="formData1.land_address.barangay" :rules="rules.info"
                                        label="Barangay" :items="land.barangay" item-title="name" item-value="item">
                                        <template v-slot:item="{ props, item }">
                                            <v-list-item @click="setBrgy(item?.raw, 'land')" v-bind="props"
                                                :title="item?.raw?.name"></v-list-item>
                                        </template>
                                    </v-autocomplete>
                                </v-col>
                            </div>
                        </v-card-text>
                    </v-card>
                    <div class="text-right">
                        <v-btn type="submit" color="green-darken-4" append-icon="mdi mdi-chevron-right">Next</v-btn>
                    </div>
                </v-form>
            </v-col>

            <v-col v-if="window === '2'">
                <v-form>
                    <div class="text-center">
                        <v-btn @click="downloadPDF()" color="green-darken-4" prepend-icon="mdi mdi-file-pdf-box">
                            Download Application Form
                        </v-btn>
                        <v-col>
                            <div ref="pdfContainer"></div>
                        </v-col>
                        <v-col class="text-right"><v-btn @click="window3()" color="green-darken-4"
                                append-icon="mdi mdi-chevron-right">Next</v-btn></v-col>
                    </div>
                </v-form>
            </v-col>
            <v-col v-if="window === '3'">
                <v-col><span class="fw-bold text-info">Note:</span> Gather all necessary documents/forms first before
                    entering the information, as they will be deleted if the page is reloaded.</v-col>
                <v-form @submit.prevent="submitDocuments()" ref="documents">
                    <v-expansion-panels class="mb-3" v-model="panel">
                        <v-expansion-panel title="For Transferor(s)">
                            <template v-slot:text>
                                <v-card elevation="0" :class="{ 'ma-2': isDesktop }">
                                    <v-list density="compact" justify="center">
                                        <v-list-item>
                                            <div :class="{ 'd-flex': isDesktop }">
                                                <v-col>
                                                    <div>Notarized LTC Form No.1 (Application for Issuance of Land Transfer
                                                        Clearance)</div>
                                                </v-col>
                                                <v-col cols="">
                                                    <div><v-file-input :rules="rules.info" :accept="'application/pdf'"
                                                            v-model="formData2.app_clearance" label="Attach file here"
                                                            density="compact"></v-file-input></div>
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
                                                    <div><v-file-input :rules="rules.info" :accept="'application/pdf'"
                                                            v-model="formData2.official_receipt" label="Attach file here"
                                                            density="compact"></v-file-input></div>
                                                </v-col>
                                            </div>
                                            <hr v-if="!isDesktop">
                                        </v-list-item>
                                        <v-list-item>
                                            <div :class="{ 'd-flex': isDesktop }">
                                                <v-col>
                                                    <div>Notarized Deed of Conveyance </div>
                                                </v-col>
                                                <v-col>
                                                    <div><v-file-input :rules="rules.info" :accept="'application/pdf'"
                                                            v-model="formData2.deed" label="Attach file here"
                                                            density="compact"></v-file-input></div>
                                                </v-col>
                                            </div>
                                            <hr v-if="!isDesktop">
                                        </v-list-item>
                                        <v-list-item>
                                            <div :class="{ 'd-flex': isDesktop }">
                                                <v-col>
                                                    <div>Latest Tax Declaration</div>
                                                </v-col>
                                                <v-col>
                                                    <div><v-file-input :rules="rules.info" :accept="'application/pdf'"
                                                            v-model="formData2.latest_tax" label="Attach file here"
                                                            density="compact"></v-file-input></div>
                                                </v-col>
                                            </div>
                                            <hr v-if="!isDesktop">
                                        </v-list-item>
                                        <v-list-item>
                                            <div :class="{ 'd-flex': isDesktop }">
                                                <v-col>
                                                    <div>Affidavit of Transferor</div>
                                                </v-col>
                                                <v-col>
                                                    <div><v-file-input :rules="rules.info" :accept="'application/pdf'"
                                                            v-model="formData2.affidavit_transferor"
                                                            label="Attach file here" density="compact"></v-file-input></div>
                                                </v-col>
                                            </div>
                                            <hr v-if="!isDesktop">
                                        </v-list-item>
                                        <v-list-item>
                                            <div :class="{ 'd-flex': isDesktop }">
                                                <v-col>
                                                    <div>Municipal Certificate of Aggregate Landholding</div>
                                                </v-col>
                                                <v-col>
                                                    <div><v-file-input :rules="rules.info" :accept="'application/pdf'"
                                                            v-model="formData2.municipal_aggregate" label="Attach file here"
                                                            density="compact"></v-file-input></div>
                                                </v-col>
                                            </div>
                                            <hr v-if="!isDesktop">
                                        </v-list-item>
                                        <v-list-item>
                                            <div :class="{ 'd-flex': isDesktop }">
                                                <v-col>
                                                    <div>City Certificate of Aggregate Landholding</div>
                                                </v-col>
                                                <v-col>
                                                    <div><v-file-input :rules="rules.info" :accept="'application/pdf'"
                                                            v-model="formData2.city_aggregate" label="Attach file here"
                                                            density="compact"></v-file-input></div>
                                                </v-col>
                                            </div>
                                            <hr v-if="!isDesktop">
                                        </v-list-item>
                                        <v-list-item>
                                            <div :class="{ 'd-flex': isDesktop }">
                                                <v-col>
                                                    <div>Provincial Certificate of Aggregate Landholding</div>
                                                </v-col>
                                                <v-col>
                                                    <div><v-file-input :rules="rules.info" :accept="'application/pdf'"
                                                            v-model="formData2.provincial_aggregate"
                                                            label="Attach file here" density="compact"></v-file-input></div>
                                                </v-col>
                                            </div>
                                        </v-list-item>
                                    </v-list>
                                </v-card>
                            </template>
                        </v-expansion-panel>
                        <v-expansion-panel title="For Transferee(s)">
                            <template v-slot:text>
                                <v-card elevation="0" :class="{ 'ma-2': isDesktop }">
                                    <v-list>
                                        <v-list-item>
                                            <div :class="{ 'd-flex': isDesktop }">
                                                <v-col>
                                                    <div>Affidavit of Aggregate Landholding</div>
                                                </v-col>
                                                <v-col>
                                                    <div><v-file-input :rules="rules.info" :accept="'application/pdf'"
                                                            v-model="formData2.municipal_aggregate_transferee"
                                                            label="Attach file here" density="compact"></v-file-input></div>
                                                </v-col>
                                            </div>
                                            <hr v-if="!isDesktop">
                                        </v-list-item>

                                        <v-list-item>
                                            <div :class="{ 'd-flex': isDesktop }">
                                                <v-col>
                                                    <div>Municipal Certificate of Aggregate Landholding</div>
                                                </v-col>
                                                <v-col>
                                                    <div><v-file-input :rules="rules.info" :accept="'application/pdf'"
                                                            v-model="formData2.city_aggregate_transferee"
                                                            label="Attach file here" density="compact"></v-file-input></div>
                                                </v-col>
                                            </div>
                                            <hr v-if="!isDesktop">
                                        </v-list-item>
                                        <v-list-item>
                                            <div :class="{ 'd-flex': isDesktop }">
                                                <v-col>
                                                    <div>City Certificate of Aggregate Landholding</div>
                                                </v-col>
                                                <v-col>
                                                    <div><v-file-input :rules="rules.info" :accept="'application/pdf'"
                                                            v-model="formData2.provincial_aggregate_transferee"
                                                            label="Attach file here" density="compact"></v-file-input></div>
                                                </v-col>
                                            </div>
                                            <hr v-if="!isDesktop">
                                        </v-list-item>
                                        <v-list-item>
                                            <div :class="{ 'd-flex': isDesktop }">
                                                <v-col>
                                                    <div>Provincial Certificate of Aggregate Landholding</div>
                                                </v-col>
                                                <v-col>
                                                    <div><v-file-input :rules="rules.info" :accept="'application/pdf'"
                                                            v-model="formData2.affidavit_aggregate_transferee"
                                                            label="Attach file here" density="compact"></v-file-input></div>
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
                                                    <div><v-file-input :rules="rules.info" :accept="'application/pdf'"
                                                            v-model="formData2.marpo_certification" label="Attach file here"
                                                            density="compact"></v-file-input></div>
                                                </v-col>
                                            </div>
                                        </v-list-item>
                                    </v-list>
                                </v-card>
                            </template>
                        </v-expansion-panel>
                        <v-expansion-panel v-if="spa_file" title="For Attorney-in-fact">
                            <template v-slot:text>
                                <v-card elevation="0" :class="{ 'ma-2': isDesktop }">
                                    <v-list>
                                        <v-list-item>
                                            <div :class="{ 'd-flex': isDesktop }">
                                                <v-col>
                                                    <div>Special Power of Attorney (SPA)</div>
                                                </v-col>
                                                <v-col>
                                                    <div><v-file-input :rules="rules.info" :accept="'application/pdf'"
                                                            v-model="formData2.spa" label="Attach file here"
                                                            density="compact"></v-file-input></div>
                                                </v-col>
                                            </div>
                                        </v-list-item>
                                    </v-list>
                                </v-card>
                            </template>
                        </v-expansion-panel>
                    </v-expansion-panels>
                    <div class="text-right">
                        <v-btn class="me-2" @click="window = '2'" color="green-darken-2"
                            prepend-icon="mdi mdi-chevron-left">Back</v-btn>
                        <v-btn color="green-darken-4" type="submit" append-icon="mdi mdi-chevron-right">Submit</v-btn>
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
import jsPDF from 'jspdf'
import { storage } from '@/firebase';
import { getDownloadURL, ref, uploadBytes } from 'firebase/storage';

export default {
    name: 'Client',
    components: {
        navDrawer, bottomNav, appBar,
    },
    data() {
        return {
            formData1:
            {
                transferor: [
                    { no: 1, fname: null, mname: null, lname: null },
                ],
                transferee: [
                    { no: 1, fname: null, mname: null, lname: null },
                ],
                app_address: {
                    province: null,
                    city: null,
                    barangay: null
                },
                conveyance: null,
                tct: null,
                lot: null,
                survey: null,
                area: null,
                land_address: {
                    city: null,
                    barangay: null
                },
                spa: {
                    fname: '',
                    mname: '',
                    lname: '',
                },
                token: null,

            },
            formData2: {
                app_clearance: '',
                official_receipt: '',
                deed: '',
                latest_tax: '',
                affidavit_transferor: '',
                municipal_aggregate: '',
                city_aggregate: '',
                provincial_aggregate: '',
                municipal_aggregate_transferee: '',
                city_aggregate_transferee: '',
                provincial_aggregate_transferee: '',
                affidavit_aggregate_transferee: '',
                marpo_certification: '',
                spa: ''
            },

            rules: {
                info: [
                    v => v != '' || 'Required',
                ],
                atty: {
                    fname: [
                        v => (this.formData1.spa.mname !== '' || this.formData1.spa.lname !== '') ? !!v : true || 'Required',

                    ],
                    lname: [
                        v => (this.formData1.spa.fname !== '' || this.formData1.spa.mname !== '') ? !!v : true || 'Required',
                    ]
                }
            },
            isDesktop: false,
            panel: [0, 1, 2],
            section: '4',
            window: '',
            last: '',
            app: {
                barangay: [],
                city: [],
                province: [],
            },
            land: {
                barangay: [],
                city: [],
            },
            pdf: null,
            spa_file: false,

        }
    },
    mounted() {
        this.isDesktop = this.updateBreakpoint();
        window.addEventListener('resize', this.onResize);
        this.checkVerify();
        this.viewPDF();
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.onResize);
    },
    created() {
        // this.loadSection();

        this.loadprovince();
        this.updateCity({ code: '175200000', name: 'Oriental Mindoro', regionCode: '170000000', islandGroupCode: 'luzon', psgc10DigitCode: '1705200000' }, 'land');
    },
    methods: {
        async window3() {
            if(last === ''){
                const d = await axios.post('window3', {
                token: sessionStorage.getItem('token')
            })
            this.window = '3'
            this.last = true
            }else{
                this.window = '3'
            }
            
        },
        async submitDocuments() {
            const {valid}  = await this.$refs.documents.validate();
            // if (valid) {
                const d = await axios.post('acc_id_documents', {
                    token: sessionStorage.getItem('token')
                })

                for(let key in this.formData2){
                    const filePath = 'applications/' + d.data.acc_id + '/' + key + '.pdf';
                    console.log();
                    const fileRef = ref(storage, filePath);

                    uploadBytes(fileRef, this.formData2[key][0]).then((snapshot) => {
                        console.log('Uploaded');
                    }).catch((error) => {
                        console.error('Error uploading file:', error);
                    });
                    console.log(this.formData2[key][0].name = '')
                }
                const a = await axios.post('submit_documents',{
                    token: sessionStorage.getItem('token'),
                    data: this.formData2
                })
                this.window = a.data.window
            // }
        },
        async checkVerify() {
            const d = await axios.post('check_verify', {
                token: sessionStorage.getItem('token')
            });
            if (d.data.section === '4') {
                this.section = '4';
                if (d.data.title === 'Application: Information Submitted') {
                    this.window = '2';
                }
                else if (d.data.title === 'Application: Form Downloaded') {
                    this.window = '3';
                }
                else {
                    this.window = '1';
                }
            }
        },
        async apply() {
            const { valid } = await this.$refs.apply.validate();

            if (valid) {
                this.formData1.token = sessionStorage.getItem('token');
                const d = await axios.post('apply', this.formData1);
                this.window = d.data.window;
                this.spa_file = d.data.spa;
                this.generatePDF();
            }

        },
        addTransferor() {
            const newIndex = this.formData1.transferor.length + 1;
            this.formData1.transferor.push({
                no: newIndex, fname: '', mname: '', lname: ''
            })
        },
        addTransferee() {
            const newIndex = this.formData1.transferee.length + 1;
            this.formData1.transferee.push({
                no: newIndex, fname: '', mname: '', lname: ''
            })
        },
        removeTransferor(index) {
            if (this.formData1.transferor.length > 1) {
                this.formData1.transferor.splice(index, 1);
            }
            console.log(index + 'deleted' + this.formData1.transferee.no);
        },
        removeInput(index) {
            if (this.formData1.transferee.length > 1) {
                this.formData1.transferee.splice(index, 1);
            }
            console.log(index + 'deleted' + this.formData1.transferee.no);
        },
        generatePDF() {
            if (this.window === '2') {
                const pdf = new jsPDF();

                pdf.text(this.isDesktop + ', this is a sample PDF!', 10, 10);
                pdf.viewerPreferences({ 'FitWindow': true }, true);

                this.pdf = pdf;
            }
        },
        viewPDF() {
            if (this.window === '2' && this.$refs.pdfContainer) {
                if (this.isDesktop === true) {
                    this.generatePDF();
                    const pdfDataUri = this.pdf.output('datauristring');
                    this.$refs.pdfContainer.innerHTML = '<embed width="100%" height="600px" src="' + pdfDataUri + '" type="application/pdf">'
                } else {
                    this.$refs.pdfContainer.innerHTML = '';
                }
            }
        },
        downloadPDF() {
            this.generatePDF();
            this.pdf.save("viewerPreferences.pdf");
        },
        async loadprovince() {
            const d = await axios.get('https://psgc.gitlab.io/api/provinces/');
            this.app.province = d.data;

        },
        async updateCity(a, b) {
            console.log(a);
            if (b === 'app') {
                this.formData1.app_address.province = a;
                const d = await axios.get('https://psgc.gitlab.io/api/provinces/' + this.formData1.app_address.province.code + '/cities-municipalities');
                this.app.city = d.data;
            }
            else {
                this.formData1.land_address.province = a;
                const d = await axios.get('https://psgc.gitlab.io/api/provinces/' + this.formData1.land_address.province.code + '/cities-municipalities');
                this.formData1.land_address.province = a.name;

                this.land.city = d.data;
            }
        },
        async updateBrgy(a, b) {
            console.log(a);
            if (b === 'app') {
                this.formData1.app_address.city = a;
                const d = await axios.get('https://psgc.gitlab.io/api/cities-municipalities/' + this.formData1.app_address.city.code + '/barangays');
                this.app.barangay = d.data;
            }
            else {
                this.formData1.land_address.city = a;
                const d = await axios.get('https://psgc.gitlab.io/api/cities-municipalities/' + this.formData1.land_address.city.code + '/barangays');
                this.land.barangay = d.data;
            }
        },
        async setBrgy(a, b) {
            console.log(a);
            if (b === 'app') {
                this.formData1.app_address.barangay = a;
            }
            else {
                this.formData1.land_address.barangay = a;
            }
        },
        updateBreakpoint() {
            return document.documentElement.clientWidth > 800;
        },

        onResize() {
            this.isDesktop = this.updateBreakpoint();
            console.log("Tab width:", document.documentElement.clientWidth, this.updateBreakpoint());
            this.viewPDF()
        },
    }
}
</script>


