<template>
  <div style="margin-top: 40px">
    <div class="ortalama">
      <md-card class="card ortala">
        <md-card-header>
          <div class="md-title">Personel Ekle</div>
        </md-card-header>

        <md-card-content>
          <md-field>
            <label>İsim</label>
            <md-input v-model="name"></md-input>
          </md-field>
          <md-field>
            <label>Telefon</label>
            <md-input type="tel" v-model="phone"></md-input>
          </md-field>
          <select
            class="form-control"
            required
            v-model="gender"
            name="movie"
            id="movie"
          >
            <option value="">Bir Değer Seçiniz</option>
            <option value="erkek">Erkek</option>
            <option value="kadın">Kadın</option>
          </select>
          <span class="text-danger">{{ errors }}</span>
        </md-card-content>

        <md-card-actions>
          <md-button @click="createUser">Kaydet</md-button>
        </md-card-actions>
      </md-card>
    </div>
    <div class="ortalama" style="margin-top: 40px; width: 30%">
      <div id="people">
        <md-table>
          <md-table-row>
            <md-table-head md-numeric>id</md-table-head>
            <md-table-head>İsim</md-table-head>
            <md-table-head>Telefon</md-table-head>
            <md-table-head>Cinsiyet</md-table-head>
            <md-table-head>Aksiyon</md-table-head>
          </md-table-row>

          <md-table-row v-for="(user, i) in filteredList" :key="i">
            <md-table-cell>{{ user.id }}</md-table-cell>
            <md-table-cell>{{ user.name }}</md-table-cell>
            <md-table-cell>{{ user.phone }}</md-table-cell>
            <md-table-cell>{{ user.gender }}</md-table-cell>
            <md-table-cell>
              <router-link :to="'/pastane/personel/' + user.id">
                <button>
                  <span></span>
                  <span></span>
                  <span></span>
                  <span></span>
                  <span style="padding-top: 7px">Git</span>
                </button>
              </router-link>
            </md-table-cell>
          </md-table-row>
        </md-table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      phone: "",
      gender: "",
      name: "",
      errors: "",
      users: [],
    };
  },
  mounted() {
    this.axios.get(this.$store.state.baseUrl + "/users").then((res) => {
      this.users = res.data;
    });
  },
  computed: {
    filteredList() {
      return this.users.filter((filter) => {
        return filter.name.toLowerCase().includes(this.name.toLowerCase());
      });
    },
  },
  methods: {
    createUser() {
      this.axios
        .post(this.$store.state.baseUrl + "/createUser", {
          name: this.name,
          phone: this.phone,
          gender: this.gender,
        })
        .then((response) => {
          this.users.push(response.data);
        })
        .catch((e) => {
          this.errors = e.response.data.message;
        });
    },
  },
};
</script>

<style scoped>
.VuePagination__count {
  display: none;
}
.ortalama {
  margin: 0 auto 0 auto;
  display: table;
}
.md-title {
  text-align: center;
}
.card {
  width: 500px;
}
.ortala {
  margin: 0 auto;
}
.cerceve {
  width: 500px;
  height: 100vh;
}
/* From cssbuttons.io by @namecho */
/* From cssbuttons.io by @adamgiebl */
button {
  transform-style: preserve-3d;
  position: relative;
  list-style: none;
  width: 100px;
  height: 32px;
  border: none;
  background: transparent;
  font-family: inherit;
}

button:before {
  content: "";
  position: absolute;
  bottom: -10px;
  left: -5px;
  width: 100%;
  height: 10px;
  background: #2a2a2a;
  transform: skewX(-41deg);
}

button:after {
  content: "";
  position: absolute;
  top: 5px;
  left: -9px;
  width: 9px;
  height: 100%;
  background: #2a2a2a;
  transform: skewY(-49deg);
}

button span {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: #2a2a2a;
  color: #fff;
  font-size: 25px;
  transition: 1.1s ease-out;
}

button:hover span {
  z-index: 1000;
  transition: 0.3s;
  color: #fff;
}

button:hover span:nth-child(5) {
  transform: translate(40px, -40px);
  opacity: 1;
}

button:hover span:nth-child(4) {
  transform: translate(30px, -30px);
  opacity: 0.8;
}

button:hover span:nth-child(3) {
  transform: translate(20px, -20px);
  opacity: 0.6;
}

button:hover span:nth-child(2) {
  transform: translate(10px, -10px);
  opacity: 0.4;
}

button:hover span:nth-child(1) {
  transform: translate(0px, 0px);
  opacity: 0.2;
}

button:active span:nth-child(5) {
  transform: translate(20px, -20px);
  opacity: 1;
}

button:active span:nth-child(4) {
  transform: translate(15px, -15px);
}

button:active span:nth-child(3) {
  transform: translate(10px, -10px);
}

button:active span:nth-child(2) {
  transform: translate(5px, -5px);
}

button:active span:nth-child(1) {
  transform: translate(0px, 0px);
}

button:nth-child(1):hover span {
  background: #52e19f;
}
</style>
