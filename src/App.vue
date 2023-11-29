<template>
  <div id="app">
    <v-app>   

      <v-row class="bottom-right-banner" lines="one" justify="end" align="end" v-if="showBanner">
        <v-col>
          <v-banner v-if="deferredPrompt" class="bg-green-lighten-5 rounded-lg" elevated v-model="showBanner" icon="mdi mdi-download-circle" color="success" >
            <template v-slot:text>
              Install DAR App
            </template>

            <template v-slot:actions>
              <v-btn @click="dismiss">
                Dismiss
              </v-btn>

              <v-btn @click="install">
                Install
              </v-btn>
            </template>
          </v-banner>
        </v-col>
      </v-row>

      <router-view></router-view>
    </v-app>
  </div>
</template>

<script>
import Cookies from "js-cookie";

export default {
  name: "App",
  data() {
    return {
      deferredPrompt: null,
      showBanner: true,
    };
  },
  created() {
    window.addEventListener("beforeinstallprompt", e => {
      e.preventDefault();
      // Stash the event so it can be triggered later.
      this.deferredPrompt = e;
      if (Cookies.get("add-to-home-screen") === undefined) {
        this.deferredPrompt = e;
      }
    });
    window.addEventListener("appinstalled", () => {
      this.deferredPrompt = null;
    });
  },
  methods: {
    async dismiss() {
      Cookies.set("add-to-home-screen", null, { expires: 15 });
      this.deferredPrompt = null;
      this.deferredPrompt = null;
    },
    async install() {
      this.deferredPrompt.prompt();
    },
  }
};
</script>

<style scoped>
.bottom-right-banner {
  position: fixed;
  bottom: 0;
  right: 0;
  margin: 16px;
  z-index: 1000;
}
</style>