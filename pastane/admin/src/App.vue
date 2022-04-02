<template>
  <div class="page-container">
    <md-app md-mode="reveal">
      <md-app-toolbar class="md-primary">
        
        <button class="menu" @click="menuVisible = !menuVisible">
          <md-icon>menu</md-icon>
          <span></span>
        </button>
        <span class="md-title">Çamlıca Pastane</span>
      </md-app-toolbar>

      <md-app-drawer :md-active.sync="menuVisible">
        <md-list>
          <md-list-item>
            <router-link to="/pastane/">
              <button>
                Ana Sayfa
                <span></span>
              </button>
            </router-link>
          </md-list-item>

          <md-list-item>
            <router-link :to="{name:'AllUsers'}">
              <button>
                Personeller
                <span></span>
              </button>
            </router-link>
          </md-list-item>
        </md-list>
      </md-app-drawer>

      <md-app-content>
        <div id="app">
          <router-view />
        </div>
      </md-app-content>
    </md-app>
  </div>
</template>

<style scoped>
/* From cssbuttons.io by @adamgiebl */
button {
  text-decoration: none;
  border: none;
  display: block;
  position: relative;
  padding: 0.7em 15px;
  font-size: 18px;
  background: transparent;
  cursor: pointer;
  user-select: none;
  overflow: hidden;
  color: royalblue;
  z-index: 1;
  font-family: inherit;
  font-weight: 500;
}
button.menu{
    padding: 10px 10px;
    border-radius: 100;

}
button span {
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background: transparent;
  z-index: -1;
  border: 4px solid royalblue;
}

button span::before {
  content: "";
  display: block;
  position: absolute;
  width: 8%;
  height: 500%;
  background: var(--lightgray);
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%) rotate(-60deg);
  transition: all 0.3s;
}

button:hover span::before {
  transform: translate(-50%, -50%) rotate(-90deg);
  width: 100%;
  background: royalblue;
}

button:hover {
  color: white;
}

button:active span::before {
  background: #2751cd;
}
.md-app {
  height: 100vh;
  border: 1px solid rgba(#000, 0.12);
}

.md-drawer {
  width: 230px;
  max-width: calc(100vw - 125px);
}
</style>

<script>
export default {
  name: "Reveal",
  data: () => ({
    menuVisible: false,
  }),
};
</script>
