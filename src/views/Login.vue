<template>
    <v-app>
        <v-container class="fill-height" fluid>
            <v-alert color="red" text="Password input incorrect. Please try again" v-if="alertVisible" dismissible
                transition="fade-transition"
                style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%);"></v-alert>

            <v-row justify="space-between" align="center">
                <v-col>
                    <v-img :height="isDesktop ? 300 : 50" src="/dar.svg"></v-img>
                    <br>
                    <h2 :class="isDesktop ? 'text-center' : 'text-center text-h6'">Department of Agrarian Reform</h2>
                    <h4 :class="isDesktop ? 'text-center' : 'text-center text-subtitle-1'">Provincial Office - Oriental
                        Mindoro</h4>
                </v-col>
                <v-col>
                    <v-card elevation="12" class="mx-auto px-6 py-8" max-width="500">
                        <v-window v-model="tab">
                            <v-window-item value="1">
                                <v-card-title class="text-center d-flex justify-space-between">
                                    <h1>Sign In</h1>
                                    <div><v-btn append-icon="mdi mdi-chevron-right" variant="outlined"
                                            @click="tab = '2'">Sign Up</v-btn></div>
                                </v-card-title>
                                <br>
                                <v-card-text>
                                    <v-form @submit.prevent="login" ref="login">
                                        <v-text-field required :rules="signin_rules.email" hide-details="auto"
                                            v-model="email" class="mb-2" label="Email"></v-text-field>

                                        <v-text-field :rules="signin_rules.password" hide-details="auto" v-model="password"
                                            label="Password" placeholder="Enter your password"></v-text-field>

                                        <br>

                                        <v-btn block class="mb-2" color="success" size="large" type="submit"
                                            variant="elevated">
                                            Sign In
                                        </v-btn>
                                        <div class="text-center">
                                            Forgot password? <v-btn :ripple="false" class="pa-0" color="primary"
                                                variant="text">Reset</v-btn>
                                        </div>
                                    </v-form>
                                </v-card-text>
                            </v-window-item>
                            <v-window-item value="2">
                                <v-card-title class="text-center  d-flex justify-space-between">
                                    <div><v-btn prepend-icon="mdi mdi-chevron-left" variant="outlined"
                                            @click="tab = '1'">Sign In</v-btn></div>
                                    <h1>Sign Up</h1>
                                </v-card-title>
                                <br>
                                <v-card-text>
                                    <v-form @submit.prevent="signup" ref="signup">
                                        <v-text-field required class="mb-2" :rules="signup_rules.email" hide-details="auto"
                                            v-model="email" label="Email" placeholder="Enter your email"></v-text-field>

                                        <v-text-field class="mb-2" :rules="signup_rules.password" v-model="password"
                                            label="Password" hide-details="auto" placeholder="Create password">
                                            <template v-slot:append-inner>
                                                <v-btn @click="tip = !tip" variant="plain"
                                                    icon="mdi mdi-information-outline">

                                                </v-btn><v-tooltip v-model="tip" activator="parent" location="top">Password
                                                    must have:
                                                    <div>- Uppercase character (A-Z)</div>
                                                    <div>- Lowercase character (a-z)</div>
                                                    <div>- Special character (@,_,!,$)</div>
                                                    <div>- Number (1-9)</div>
                                                    <div>- At least 8 characters</div>
                                                </v-tooltip>

                                            </template>
                                        </v-text-field>

                                        <v-text-field class="mb-2" :rules="signup_rules.confirmpassword"
                                            v-model="confirmpassword" label="Confirm Password" hide-details="auto"
                                            placeholder="Confirm password"></v-text-field>

                                        <br>

                                        <v-btn block class="mb-2" color="success" size="large" type="submit"
                                            variant="elevated">
                                            Sign Up
                                        </v-btn>
                                    </v-form>
                                </v-card-text>
                            </v-window-item>
                        </v-window>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</template>

<script>
import axios from 'axios'
import router from '@/router'

export default {
    data() {
        return {
            alertVisible: false,
            tip: false,
            isDesktop: false,
            tab: '1',
            email: '',
            password: '',
            confirmpassword: '',
            signin_rules: {
                email: [
                    v => v != '' || 'Required',
                    v => /.+@.+\..+/.test(v) || 'Email must be valid',
                    v => this.existEmail(v) || 'Email is not registered',
                ],
                password: [
                    v => v != '' || 'Required',
                ],
            },
            signup_rules: {
                email: [
                    v => !!v || 'Required',
                    v => /.+@.+\..+/.test(v) || 'Email must be valid',
                    v => this.checkEmail(v) || 'Email already registered',
                ],
                password: [
                    v => !!v || 'Required',
                    v => /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$_!%*?&])[A-Za-z\d$@$_!%*?&]+$/.test(v) || 'Minimum requirements not met',
                    v => v.length >= 8 || 'Must at least 8 characters'
                ],
                confirmpassword: [
                    v => !!v || 'Required',
                    v => v === this.password || 'Passwords do not match',
                ]
            }
        }
    },
    methods: {
        async signup() {
            const { valid } = await this.$refs.signup.validate()

            if (valid) {
                const d = await axios.post('signup', {
                    email: this.email,
                    password: this.password
                });
                console.log(d);
                sessionStorage.setItem('token', d.data.token);
                this.email = '';
                this.password = '';
                this.confirmpassword = '';
                this.$router.push('/verify_email');
            } else {
                console.log('Incomplete');
            }
        },
        async login() {
            const { valid } = await this.$refs.login.validate();

            if (valid) {
                const d = await axios.post('login', {
                    email: this.email,
                    password: this.password
                })
                if (d.data.message === 'accept') {
                    sessionStorage.setItem('token', d.data.token);
                    this.email = '';
                    this.password = '';
                    if (d.data.phase === 'account') {
                        if (d.data.section === '1')
                            this.$router.replace('/verify_email');
                        else if (d.data.section === '2')
                            this.$router.replace('/client_info');
                        else if (d.data.section === '3')
                            this.$router.replace('/client');
                    }
                }
                else {
                    this.alertVisible = true;
                    setTimeout(() => {
                        this.alertVisible = false;
                    }, 6000);
                }
            } else {
                console.log('Incomplete');
            }

        },
        async existEmail(v) {
            const d = await axios.post('existEmail', {
                email: v,
            });
            if (d.data.message === 'true')
                return true;
            else
                return 'Email is not registered';
        },
        async checkEmail(v) {
            const d = await axios.post('checkEmail', {
                email: v,
            });
            console.log(d);
            if (d.data.message === 'true')
                return true;
            else
                return 'Email already registered';
        },
        updateBreakpoint() {
            return document.documentElement.clientWidth > 800;
        },

        onResize() {
            this.isDesktop = this.updateBreakpoint();
            console.log("Tab width:", document.documentElement.clientWidth, this.updateBreakpoint());
        },
    },
    mounted() {
        this.isDesktop = this.updateBreakpoint();
        window.addEventListener('resize', this.onResize);
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.onResize);
    },

};
</script>

<style>
.mdi-close-box {
    color: red;
}

.mdi-checkbox-marked-circle {
    color: rgb(0, 161, 0);
}
</style>