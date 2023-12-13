<template>
    <v-app>
        <v-container class="fill-height" fluid>
            <v-row justify="space-between" align="center">
                <v-col>
                    <v-card elevation="12" class="mx-auto px-6 py-8" :max-width="isDesktop ? 1000 : 500">
                        <v-card-title :class="isDesktop ? 'mb-2' : 'text-center'">
                            <h1 class="mb-3 text-green-darken-3">Information</h1>
                            <div class="text-body-1">Please enter the required information</div>
                        </v-card-title>
                        <v-card-text>
                            <v-form @submit.prevent="submit()" ref="info">
                                <v-col class="text-center bg-green-lighten-4 mb-1 py-1">
                                    Identity Information
                                </v-col>
                                <v-text-field required class="mb-2" hide-details="auto" v-model="fname" label="First Name"
                                    :rules="rules.info"></v-text-field>
                                <v-text-field required class="mb-2" hide-details="auto" v-model="mname" label="Middle Name"
                                    :rules="rules.info"></v-text-field>
                                <v-text-field required class="mb-2" hide-details="auto" v-model="lname" label="Last Name"
                                    :rules="rules.info"></v-text-field>


                                <v-text-field :rules="rules.info" class="mb-2" hide-details="auto" v-model="formatted"
                                    label="Birthday" readonly @input="datePickerVisible = false"
                                    @click="showDatePicker"></v-text-field>

                                <v-text-field @input="phoneInput()" required class="mb-2" type="tel" hide-details="auto"
                                    v-model="phone" label="Phone Number" :rules="rules.info" maxlength="11"
                                    placeholder="09XXXXXXXXX"></v-text-field>
                                <br>
                                <v-col class="text-center bg-green-lighten-4 mb-1 py-1">
                                    Permanent Address
                                </v-col>
                                <v-col class="pa-0">
                                    <v-autocomplete :rules="rules.info" class="mb-2" hide-details="auto"
                                        v-model="app_address.province" label="Province" :items="app.province"
                                        item-title="name" item-value="item">
                                        <template v-slot:item="{ props, item }">
                                            <v-list-item @click="updateCity(item?.raw, 'app')" v-bind="props"
                                                :title="item?.raw?.name"></v-list-item>
                                        </template>
                                    </v-autocomplete>
                                </v-col>
                                <div :class="{ 'd-flex': isDesktop }">
                                    <v-col :class='isDesktop ? "pa-0 pe-1" : "pa-0"'>
                                        <v-autocomplete :rules="rules.info" class="mb-2" hide-details="auto"
                                            v-model="app_address.city" label="City/Municipality" :items="app.city"
                                            item-title="name" item-value="item">
                                            <template v-slot:item="{ props, item }">
                                                <v-list-item @click="updateBrgy(item?.raw, 'app')" v-bind="props"
                                                    :title="item?.raw?.name"></v-list-item>
                                            </template>
                                        </v-autocomplete>
                                    </v-col>
                                    <v-col class="pa-0 ps-1">
                                        <v-autocomplete :rules="rules.info" v-model="app_address.barangay" label="Barangay"
                                            :items="app.barangay" item-title="name" item-value="item">
                                            <template v-slot:item="{ props, item }">
                                                <v-list-item @click="setBrgy(item?.raw, 'app')" v-bind="props"
                                                    :title="item?.raw?.name"></v-list-item>
                                            </template>
                                        </v-autocomplete>
                                    </v-col>
                                </div>
                                <v-col>
                                    <v-col class="text-center bg-green-lighten-4 mb-1 py-1">Profile Picture</v-col>
                                    <v-file-input label="Select image" prepend-icon="mdi mdi-camera-account"
                                        v-model="profile" :rules="rules.file"
                                        accept="image/png, image/jpeg, image/bmp"></v-file-input>
                                </v-col>
                                <v-col>
                                    <div class="text-center bg-green-lighten-4 mb-1 py-1 align-center">Valid ID
                                        <v-btn @click="tip = !tip" density="compact" variant="plain"
                                            icon="mdi mdi-information-outline">
                                        </v-btn>
                                    </div>

                                    <v-tooltip v-model="tip" activator="parent" location="top">Accepted IDs:
                                        <div>- PhilSys ID</div>
                                        <div>- TIN ID</div>
                                        <div>- UMID</div>
                                        <div>- SSS</div>
                                        <div>- Voter's ID</div>
                                        <div>- PRC ID</div>
                                        <div>- Driver's License</div>
                                        <div>- Passport</div>
                                    </v-tooltip>
                                    <v-file-input prepend-icon="mdi mdi-camera-account" v-model="valid_id"
                                        :rules="rules.file" label="Select image"
                                        accept="image/png, image/jpeg, image/bmp"></v-file-input>
                                </v-col>

                                <v-btn block type="submit" color="success">Submit</v-btn>


                                <!-- Date Picker Overlay -->
                                <v-dialog v-model="datePickerVisible" persistent>
                                    <v-row justify="center" align="center">
                                        <span>
                                            <v-date-picker class="mb-5" color="green"
                                                v-model="selectedDate"></v-date-picker>

                                            <div class="text-right">
                                                <v-btn class="me-2" color="error" @click="cancelSelection">Cancel</v-btn>
                                                <v-btn color="primary" @click="confirmSelection">OK</v-btn>
                                            </div>

                                        </span>
                                    </v-row>
                                </v-dialog>
                            </v-form>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</template>

<script>
import axios from 'axios'
import router from '@/router'
import { storage } from '@/firebase';
import { getDownloadURL, ref, uploadBytes } from 'firebase/storage';

export default {
    data() {
        return {
            tip: false,
            isDesktop: false,
            selectedDate: null,
            formatted: null,
            datePickerVisible: false,
            originalDate: null,


            app: {
                barangay: [],
                city: [],
                province: [],
            },
            fname: '',
            mname: '',
            lname: '',
            bday: '',
            phone: '',
            app_address: {
                province: null,
                city: null,
                barangay: null
            },
            profile: null,
            valid_id: null,
            rules: {
                info: [
                    (v) => !!v || 'Required',
                ],
                file: [
                    (file) => !!file || 'Required',
                    (file) => this.checkSize(),
                    (file) => (file[0] ? /\.(jpg|jpeg|png)$/i.test(file[0].name) : true) || 'Invalid file format. Only JPG, JPEG, and PNG allowed.',
                ],
            },
            error: false,
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
        // this.loadSection();
        this.loadprovince();
    },
    methods: {
        async submit() {
            const { valid } = await this.$refs.info.validate()

            if (valid) {
                const prof = 'clients/' + this.fname.replace(/\s/g, '').toLowerCase() + '_' + this.lname.replace(/\s/g, '').toLowerCase() + '/profile'

                const val_id = 'clients/' + this.fname.replace(/\s/g, '').toLowerCase() + '_' + this.lname.replace(/\s/g, '').toLowerCase() + '/id'

                const profileRef = ref(storage, prof);
                uploadBytes(profileRef, this.profile[0]).then((snapshot) => {
                });

                const idRef = ref(storage, val_id);
                uploadBytes(idRef, this.valid_id[0]).then((snapshot) => {

                });


                const d = await axios.post('save_info', {
                    data: {
                        fname: this.fname,
                        mname: this.mname,
                        lname: this.lname,
                        birth: this.formatted,
                        barangay: this.app_address.barangay,
                        city: this.app_address.city,
                        province: this.app_address.province,
                        phone: this.phone,
                        profile: prof,
                        id_path: val_id,
                    },
                    token: sessionStorage.getItem('token')
                })
                this.$router.replace('/client')
            }
        },

        checkSize() {
            if (this.profile.length > 0) {
                console.log(this.profile[0]);
                if (this.profile[0].size > 2000000)
                    return 'Too large file. Maximum: 2MB'
                else {
                    return true
                }
            }

        },

        phoneInput() {
            this.phone = this.phone.replace(/\D/g, "");
        },
        showDatePicker() {
            this.originalDate = this.selectedDate; // Store the original date
            this.datePickerVisible = true;
        },
        cancelSelection() {
            this.selectedDate = this.originalDate; // Restore the original date
            this.datePickerVisible = false;
        },
        confirmSelection() {
            this.formatted = this.selectedDate.toLocaleDateString('en-CA', { year: 'numeric', month: '2-digit', day: '2-digit' });
            this.datePickerVisible = false;
        },
        async verify() {
            const d = await axios.post('verify', {
                otp: this.otp,
                token: sessionStorage.getItem('token')
            });
            if (d.data.verified)
                this.$router.replace('/client_info');
            else
                this.error = true;
        },

        //Address
        async loadprovince() {
            const d = await axios.get('https://psgc.gitlab.io/api/provinces/');
            this.app.province = d.data;

        },
        async updateCity(a, b) {
            console.log(a);
            if (b === 'app') {
                this.app_address.province = a;
                const d = await axios.get('https://psgc.gitlab.io/api/provinces/' + this.app_address.province.code + '/cities-municipalities');
                this.app.city = d.data;
            }
            else {
                this.land_address.province = a;
                const d = await axios.get('https://psgc.gitlab.io/api/provinces/' + this.land_address.province.code + '/cities-municipalities');
                this.land_address.province = a.name;

                this.land.city = d.data;
            }



        },
        async updateBrgy(a, b) {
            console.log(a);
            if (b === 'app') {
                this.app_address.city = a;
                const d = await axios.get('https://psgc.gitlab.io/api/cities-municipalities/' + this.app_address.city.code + '/barangays');
                this.app.barangay = d.data;
            }
            else {
                this.land_address.city = a;
                const d = await axios.get('https://psgc.gitlab.io/api/cities-municipalities/' + this.land_address.city.code + '/barangays');
                this.land.barangay = d.data;
            }
        },
        async setBrgy(a, b) {
            console.log(a);
            if (b === 'app') {
                this.app_address.barangay = a;
            }
            else {
                this.land_address.barangay = a;
            }
        },
        updateBreakpoint() {
            return document.documentElement.clientWidth > 800;
        },

        onResize() {
            this.isDesktop = this.updateBreakpoint();
        },
    }
}
</script>