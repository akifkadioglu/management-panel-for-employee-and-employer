<template>
  <div class="page-container">
    <md-app-content>
      <div class="row" style="margin-top: 20px">
        <div class="col-sm-3">
          <div>
            <div class="ortalama">
              Saatlik Ücret
              <button @click="changePrice(-0.25)" class="work">-</button>
              {{ inhour }}
              <button @click="changePrice(0.25)" class="work">+</button>
            </div>
            <md-field>
              <label>Başlangıç Tarihi</label>
              <md-input type="date" v-model="get.startDate"></md-input>
            </md-field>
            <md-field>
              <label>Bitiş Tarihi</label>
              <md-input type="date" v-model="get.finishDate"></md-input>
            </md-field>
            <md-button class="ortalama" @click="getDaysAllValues"
              >Getir</md-button
            >
          </div>
          <hr />
          <div>
            <md-field>
              <label>Uygulamaya Mesaj Gönder</label>
              <md-input type="text" v-model="message"></md-input>
            </md-field>
            <md-button class="ortalama" @click="sendMessage"
              >Mesaj Gönder</md-button
            >
          </div>
          <div class="navbar">
            <span class="doluClass">{{ messages }}</span>
            <div v-if="messages != ''" class="button-borders">
              <button class="primary-button" @click="deleteMessage">
                <md-icon class="text-white">remove_circle_outline</md-icon>
              </button>
            </div>
          </div>

          <hr v-if="messages != ''" />

          <div>
            <md-field>
              <label>Not eklemek ister misiniz?</label>
              <md-input type="text" v-model="note"></md-input>
            </md-field>
            <md-button class="ortalama" @click="sendNote">Notu Ekle</md-button>
          </div>
          <hr v-if="notes.length > 0" />
          <div>
            <div>
              <div class="navbar" v-for="(not, i) in notes" :key="i">
                <span class="doluClass">{{ not.text }}</span>
                <md-tooltip md-direction="right">{{
                  not.created_at | moment("dddd, MMMM Do YYYY h:m")
                }}</md-tooltip>

                <div class="button-borders">
                  <button class="primary-button" @click="deleteNote(not.id, i)">
                    <md-icon class="text-white">remove_circle_outline</md-icon>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-9">
          <div class="ortalama" style="width: 700px">
            <form
              class="ortalama mb-5"
              v-if="showDownloadButton"
              :action="
                this.$store.state.baseUrl +
                '/exportTheUser?from=' +
                get.startDate +
                ' 00:00:00' +
                '&to=' +
                get.finishDate +
                ' 23:59:59'
              "
              method="post"
            >
              <button class="download-button" type="submit">
                <div class="docs">
                  <svg
                    class="css-i6dzq1"
                    stroke-linejoin="round"
                    stroke-linecap="round"
                    fill="none"
                    stroke-width="2"
                    stroke="currentColor"
                    height="20"
                    width="20"
                    viewBox="0 0 24 24"
                  >
                    <path
                      d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
                    ></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line y2="13" x2="8" y1="13" x1="16"></line>
                    <line y2="17" x2="8" y1="17" x1="16"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                  </svg>
                  Verileri İndir
                </div>
                <div class="download">
                  <svg
                    class="css-i6dzq1"
                    stroke-linejoin="round"
                    stroke-linecap="round"
                    fill="none"
                    stroke-width="2"
                    stroke="currentColor"
                    height="24"
                    width="24"
                    viewBox="0 0 24 24"
                  >
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line y2="3" x2="12" y1="15" x1="12"></line>
                  </svg>
                </div>
              </button>
            </form>
            <form
              class="ortalama mb-5"
              v-if="showDownloadButton == false"
              :action="this.$store.state.baseUrl + '/exportTheUser'"
              method="post"
            >
              <button class="download-button" type="submit">
                <div class="docs">
                  <svg
                    class="css-i6dzq1"
                    stroke-linejoin="round"
                    stroke-linecap="round"
                    fill="none"
                    stroke-width="2"
                    stroke="currentColor"
                    height="20"
                    width="20"
                    viewBox="0 0 24 24"
                  >
                    <path
                      d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
                    ></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line y2="13" x2="8" y1="13" x1="16"></line>
                    <line y2="17" x2="8" y1="17" x1="16"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                  </svg>
                  Verileri İndir
                </div>
                <div class="download">
                  <svg
                    class="css-i6dzq1"
                    stroke-linejoin="round"
                    stroke-linecap="round"
                    fill="none"
                    stroke-width="2"
                    stroke="currentColor"
                    height="24"
                    width="24"
                    viewBox="0 0 24 24"
                  >
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line y2="3" x2="12" y1="15" x1="12"></line>
                  </svg>
                </div>
              </button>
            </form>
            <div class="md-title ortalama">
              {{ header }} - {{ workPrices }} ₺
            </div>
            <apexchart
              v-if="weekChart"
              type="pie"
              :options="monochrome.chartOptions"
              :series="monochrome.series"
            ></apexchart>
            <apexchart
              v-if="weekChart"
              type="line"
              :options="line.options"
              :series="line.series"
            ></apexchart>
            <div class="ortalama" style="width: 50%"></div>
            <div v-if="weekChart">
              <md-table>
                <md-table-row>
                  <md-table-head>Kişi</md-table-head>
                  <md-table-head>Haftalık Kaç Saat Çalıştı</md-table-head>
                </md-table-row>
                <md-table-row v-for="(work, i) in works" :key="i">
                  <md-table-cell>{{ i }}</md-table-cell>
                  <md-table-cell
                    >{{ Math.floor(work / 60) }}:{{ work % 60 }}</md-table-cell
                  >
                </md-table-row>
              </md-table>
            </div>
            <div v-if="weekChart == false">
              <md-table>
                <md-table-row>
                  <md-table-head>id</md-table-head>
                  <md-table-head>Ücret</md-table-head>
                  <md-table-head>Kişi</md-table-head>
                  <md-table-head>Başlangıç Saati</md-table-head>
                  <md-table-head>Bitiş Saati</md-table-head>
                  <md-table-head>Gün</md-table-head>
                </md-table-row>

                <md-table-row v-for="(work, i) in works" :key="i">
                  <md-table-cell>{{ work.id }}</md-table-cell>
                  <md-table-cell>{{ work.price }}</md-table-cell>
                  <md-table-cell>
                    <router-link :to="'/pastane/personel/' + work.user.id">
                      {{ work.user.name }}
                    </router-link>
                  </md-table-cell>

                  <md-table-cell>{{ work.start }}</md-table-cell>
                  <md-table-cell>{{ work.finish }}</md-table-cell>
                  <md-table-cell>{{
                    work.created_at | moment("dddd, MMMM Do YYYY")
                  }}</md-table-cell>
                </md-table-row>
              </md-table>
            </div>
          </div>
        </div>
      </div>
    </md-app-content>
  </div>
</template>

<script>
export default {
  name: "Reveal",
  data() {
    return {
      inhour: 5,
      notes: [],
      messages: "",
      menuVisible: false,
      details: [],
      weekChart: true,
      worksHour: 0,
      workPrices: 0,
      get: {
        startDate: 0,
        finishDate: 0,
      },
      showDownloadButton: false,
      note: "",
      message: "",
      header: "Haftalık Veriler",
      works: [],
      monochrome: {
        series: [],
        chartOptions: {
          labels: [],

          legend: {
            show: false,
          },
        },
      },
      line: {
        options: {
          xaxis: {
            categories: [],
          },
        },
        series: [
          {
            data: [],
          },
        ],
      },
    };
  },

  methods: {
    deleteMessage() {
      this.axios
        .get(this.$store.state.baseUrl + "/deleteMessage")
        .then(() => {
          this.messages = "";
        })
        .catch((err) => {
          console.log(err);
        });
    },
    sendMessage() {
      this.axios
        .post(this.$store.state.baseUrl + "/sendMessage", {
          message: this.message,
        })
        .then((result) => {
          this.messages = result.data.message;

          this.message = "";
        })
        .catch((err) => {
          console.log(err);
        });
    },
    changePrice(value) {
      this.axios
        .post(this.$store.state.baseUrl + "/changePrice", { value: value })
        .then(() => {
          this.inhour += value;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    sendNote() {
      this.axios
        .post(this.$store.state.baseUrl + "/sendNote", { note: this.note })
        .then((result) => {
          this.notes.push(result.data);
          this.note = "";
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getDaysAllValues() {
      this.axios
        .post(this.$store.state.baseUrl + "/getDaysAllValues", {
          startDate: this.get.startDate + " 00:00:00",
          finishDate: this.get.finishDate + " 23:59:59",
        })
        .then((result) => {
          this.works = result.data.works;
          this.worksHour = result.data.minute;
          this.header = this.get.startDate + " | " + this.get.finishDate;
          this.weekChart = false;
          this.showDownloadButton = true;
        })
        .catch((err) => {
          console.log(err);
        });

      this.axios
        .post(this.$store.state.baseUrl + "/getDaysAllValuesForPrice", {
          startDate: this.get.startDate + " 00:00:00",
          finishDate: this.get.finishDate + " 23:59:59",
        })
        .then((result) => {
          this.workPrices = result.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    deleteNote(id, index) {
      this.axios
        .post(this.$store.state.baseUrl + "/deleteNote", { id: id })
        .then(() => {
          this.notes.splice(index, 1);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getDetails() {
      var parsedobj = JSON.parse(JSON.stringify(this.details));
      var result = Object.keys(parsedobj).map((key) => [
        String(key),
        parsedobj[key],
      ]);

      var series = Array();
      var labels = Array();
      result.map((k) => series.push(k[1]));
      result.map((k) => labels.push(k[0]));
      this.monochrome.series = series;

      var minute = 0;
      for (let index = 0; index < this.monochrome.series.length; index++) {
        minute += this.monochrome.series[index];
      }
      this.worksHour = minute;

      this.monochrome.chartOptions = {
        labels: labels,
      };
      this.line.series = [
        {
          name: "Çalışılan dakika",

          data: series,
        },
      ];
      this.line.options = {
        xaxis: {
          categories: labels,
        },
      };
    },
  },
  mounted() {
    this.axios
      .get(this.$store.state.baseUrl + "/getPrice")
      .then((result) => {
        this.inhour = result.data;
      })
      .catch((err) => {
        console.log(err);
      });
    this.axios
      .get(this.$store.state.baseUrl + "/getWeekAllWorksForPrice")
      .then((result) => {
        this.workPrices = result.data;
      })
      .catch((err) => {
        console.log(err);
      });
    this.axios
      .get(this.$store.state.baseUrl + "/getNotes")
      .then((result) => {
        this.notes = result.data;
      })
      .catch((err) => {
        console.log(err);
      });
    this.axios
      .get(this.$store.state.baseUrl + "/getMessage")
      .then((result) => {
        this.messages = result.data;
      })
      .catch((err) => {
        console.log(err);
      });
    this.axios
      .get(this.$store.state.baseUrl + "/getWeekAllWorks")
      .then((result) => {
        this.details = result.data;
        this.works = result.data;
        this.getDetails();
      })
      .catch((err) => {
        console.log(err);
      });
  },
};
</script>
<style scoped>
.doluClass {
  width: 70%;
  word-break: break-word;
  display: inline-block;
}
.ortalama {
  margin: 0 auto 0 auto;
  display: table;
}
/* From cssbuttons.io by @faizanullah1999 */
.primary-button {
  font-family: "Ropa Sans", sans-serif;
  /* font-family: 'Valorant', sans-serif; */
  color: white;
  cursor: pointer;
  font-size: 13px;
  font-weight: bold;
  letter-spacing: 0.05rem;
  border: 1px solid #0e1822;
  padding: 1px 15px;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 531.28 200'%3E%3Cdefs%3E%3Cstyle%3E .shape %7B fill: %23FF4655 /* fill: %230E1822; */ %7D %3C/style%3E%3C/defs%3E%3Cg id='Layer_2' data-name='Layer 2'%3E%3Cg id='Layer_1-2' data-name='Layer 1'%3E%3Cpolygon class='shape' points='415.81 200 0 200 115.47 0 531.28 0 415.81 200' /%3E%3C/g%3E%3C/g%3E%3C/svg%3E%0A");
  background-color: #0e1822;
  background-size: 200%;
  background-position: 200%;
  background-repeat: no-repeat;
  transition: 0.3s ease-in-out;
  transition-property: background-position, border, color;
  position: relative;
  z-index: 1;
}

.primary-button:hover {
  border: 1px solid #ff4655;
  color: white;
  background-position: 40%;
}

.primary-button:before {
  content: "";
  position: absolute;
  background-color: #0e1822;
  width: 0.2rem;
  height: 0.2rem;
  top: -1px;
  left: -1px;
  transition: background-color 0.15s ease-in-out;
}

.primary-button:hover:before {
  background-color: white;
}

.primary-button:hover:after {
  background-color: white;
}

.primary-button:after {
  content: "";
  position: absolute;
  background-color: #ff4655;
  width: 0.3rem;
  height: 0.3rem;
  bottom: -1px;
  right: -1px;
  transition: background-color 0.15s ease-in-out;
}

.button-borders {
  position: relative;
  width: fit-content;
  height: fit-content;
}

.button-borders:before {
  content: "";
  position: absolute;
  width: calc(100% + 0.5em);
  height: 50%;
  left: -0.3em;
  top: -0.3em;
  border: 1px solid #0e1822;
  border-bottom: 0px;
  /* opacity: 0.3; */
}

.button-borders:after {
  content: "";
  position: absolute;
  width: calc(100% + 0.5em);
  height: 50%;
  left: -0.3em;
  bottom: -0.3em;
  border: 1px solid #0e1822;
  border-top: 0px;
  /* opacity: 0.3; */
  z-index: 0;
}

.shape {
  fill: #0e1822;
}
/* From cssbuttons.io by @Botwe-Felix5820 */
button.work {
  border: none;
  border-radius: 10em;
  background: #016dd9;
  font-size: 17px;
  color: #ffffff;
  font-family: inherit;
  font-weight: 500;
}

button.work:hover {
  animation: shake3856 0.3s linear infinite both;
}

@keyframes shake3856 {
  0% {
    -webkit-transform: translate(0);
    transform: translate(0);
  }

  20% {
    -webkit-transform: translate(-2px, 2px);
    transform: translate(-2px, 2px);
  }

  40% {
    -webkit-transform: translate(-2px, -2px);
    transform: translate(-2px, -2px);
  }

  60% {
    -webkit-transform: translate(2px, 2px);
    transform: translate(2px, 2px);
  }

  80% {
    -webkit-transform: translate(2px, -2px);
    transform: translate(2px, -2px);
  }

  100% {
    -webkit-transform: translate(0);
    transform: translate(0);
  }
}
.download-button {
  position: relative;
  border-width: 0;
  color: white;
  font-size: 15px;
  font-weight: 600;
  border-radius: 4px;
  z-index: 1;
}

.download-button .docs {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
  min-height: 40px;
  padding: 0 10px;
  border-radius: 4px;
  z-index: 1;
  background-color: #242a35;
  border: solid 1px #e8e8e82d;
  transition: all 0.5s cubic-bezier(0.77, 0, 0.175, 1);
}

.download-button:hover {
  box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px,
    rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px,
    rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
}

.download {
  position: absolute;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  max-width: 90%;
  margin: 0 auto;
  z-index: -1;
  border-radius: 4px;
  transform: translateY(0%);
  background-color: #01e056;
  border: solid 1px #01e0572d;
  transition: all 0.5s cubic-bezier(0.77, 0, 0.175, 1);
}

.download-button:hover .download {
  transform: translateY(100%);
}

.download svg polyline,
.download svg line {
  animation: docs 1s infinite;
}

@keyframes docs {
  0% {
    transform: translateY(0%);
  }

  50% {
    transform: translateY(-15%);
  }

  100% {
    transform: translateY(0%);
  }
}
</style>
