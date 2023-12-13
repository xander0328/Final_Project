<template>
    <v-app>
        <v-container class="fill-height" fluid>
            <v-row justify="space-between" align="center">
                <v-col>
                    <v-card elevation="12" class="mx-auto px-6 py-8" max-width="500">
                        <v-card-title class="text-center">
                            <h1 class="mb-3">Verify Email</h1>
                            <div class="text-body-1">Check OTP (One-time Pin) sent to your email</div>
                        </v-card-title>
                        <br>
                        <v-card-text>
                            <v-form @submit.prevent="verify()" ref="otp">

                                <v-otp-input @click="removeError()" :error="error" v-model='otp' length="4"></v-otp-input>
                                <div class="text-center text-red-darken-2" v-if="require">Input OTP sent to your email</div>
                                    <div class="text-center text-red-darken-2" v-if="incorrect">OTP Incorrect</div>
                                <br><br>

                                <v-btn block class="mb-2" color="success" size="large" type="submit" variant="elevated">
                                    Submit
                                </v-btn>

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
export default {
    data() {
        return {
            otp: '',
            error: false,
            require: false,
            incorrect: false,
        }
    },
    methods: {
        async verify() {
            const valid = await this.$refs.otp.validate();

            if (valid) {
                const d = await axios.post('verify', {
                    otp: this.otp,
                    token: sessionStorage.getItem('token')
                });
                if (d.data.verified === 'true')
                    this.$router.replace('/client_info');
                else if (d.data.verified === 'none') {
                    this.require = true;
                    this.error = true;
                }
                else {
                    this.incorrect = true;
                    this.error = true;
                }
            }

        },
        removeError() {
            this.incorrect = false;
            this.require = false;
            this.error = false
        }
    }
}
</script>