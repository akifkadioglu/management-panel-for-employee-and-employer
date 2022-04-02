<template>
  <div style="margin-top: 40px; margin-left: 20px; margin-right: 20px">
    <div>
      <md-dialog :md-active.sync="showDialog">
        <md-dialog-title>{{ user.name }}</md-dialog-title>

        <md-tabs md-dynamic-height>
          <md-tab md-label="Güncelleme Ekranı">
            <md-field>
              <label>İsim</label>
              <md-input v-model="name"></md-input>
            </md-field>
            <md-field>
              <label>phone</label>
              <md-input type="tel" v-model="phone"></md-input>
            </md-field>
            <select v-model="gender" class="form-control">
              <option value="erkek">Erkek</option>
              <option value="kadın">Kadın</option>
            </select>
          </md-tab>
        </md-tabs>

        <md-dialog-actions>
          <md-button
            class="md-primary"
            @click="
              showDialog = false;
              name = '';
            "
          >
            Kapat
          </md-button>
          <md-button class="md-primary" @click="changeName"> Kaydet </md-button>
        </md-dialog-actions>
      </md-dialog>

      <md-dialog :md-active.sync="editWork">
        <md-dialog-title>
          {{ works[workindex].start }}
          -
          {{ works[workindex].finish }}
        </md-dialog-title>

        <md-tabs md-dynamic-height>
          <md-tab md-label="Saat Güncelleme Ekranı">
            <md-field>
              <label>Başlangıç Saati</label>
              <md-input type="time" v-model="work.start"></md-input>
            </md-field>
            <md-field>
              <label>Bitiş Saati</label>
              <md-input type="time" v-model="work.finish"></md-input>
            </md-field>
            <md-field>
              <label>Gün</label>
              <md-input type="date" v-model="work.date"></md-input>
            </md-field>
          </md-tab>
        </md-tabs>

        <md-dialog-actions>
          <md-button
            class="md-primary"
            @click="
              editWork = false;
              name = '';
            "
          >
            Kapat
          </md-button>
          <md-button
            class="md-primary"
            @click="editedWork(works[workindex].id)"
          >
            Kaydet
          </md-button>
        </md-dialog-actions>
      </md-dialog>
    </div>
    <div class="row">
      <div class="col-sm-3">
        <div class="md-title ortalama">{{ user.name }}</div>
        <div class="md-subtitle ortalama">
          {{ user.created_at | moment("dddd, MMMM Do YYYY h:m") }}
        </div>

        <div class="ortalama"></div>
        <div class="ortalama">
          <span
            >Bu Haftalık {{ week.toFixed(2) }} ₺ |
            {{ Math.floor(weekForMinute / 60) }}:{{ weekForMinute % 60 }}
            <md-icon>watch_later</md-icon></span
          >
        </div>
        <div class="ortalama">
          <span
            >Şimdiye Kadar {{ tillNow.toFixed(2) }} ₺ |
            {{ Math.floor(tillNowMinute / 60) }}:{{ tillNowMinute % 60
            }}<md-icon>watch_later</md-icon>
          </span>
        </div>
        <div class="ortalama">
          <md-button class="text-primary" @click="showDialog = true">
            Düzenle
          </md-button>
        </div>
        <hr />
        <div>
          <md-field>
            <label>Başlangıç Tarihi</label>
            <md-input type="date" v-model="get.startDate"></md-input>
          </md-field>
          <md-field>
            <label>Bitiş Tarihi</label>
            <md-input type="date" v-model="get.finishDate"></md-input>
          </md-field>
          <md-button class="ortalama" @click="getDaysValues">Getir</md-button>
        </div>
      </div>
      <div class="col-sm-9">
        <div class="ortalama" style="width: 700px" v-if="weekChart">
          <form
            class="ortalama"
            :action="this.$store.state.baseUrl + '/exportTheUser?id=' + id"
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

          <div class="md-title ortalama mt-5">Haftalık Veriler</div>
          <apexchart
            type="pie"
            :options="monochrome.chartOptions"
            :series="monochrome.series"
          ></apexchart>
          <apexchart
            type="line"
            :options="line.options"
            :series="line.series"
          ></apexchart>
        </div>
        <div
          class="ortalama"
          style="margin-top: 40px; margin-bottom: 100px; width: 50%"
        >
          <div class="md-title ortalama" v-if="showDownloadButton">
            <form
              class="ortalama"
              :action="
                this.$store.state.baseUrl +
                '/exportTheUser?id=' +
                id +
                '&from=' +
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
          </div>
          <div class="md-title ortalama mt-5">
            {{ workHours }}
            <span v-if="workPrices > 0"> | {{ workPrices.toFixed(2) }} ₺ </span>
          </div>

          <md-table>
            <md-table-row>
              <md-table-head>id</md-table-head>
              <md-table-head>Ücret</md-table-head>
              <md-table-head>Başlangıç Saati</md-table-head>
              <md-table-head>Bitiş Saati</md-table-head>
              <md-table-head>Gün</md-table-head>
              <md-table-head>Düzenle</md-table-head>
              <md-table-head>Sil</md-table-head>
            </md-table-row>

            <md-table-row v-for="(work, i) in works" :key="i">
              <md-table-cell v-if="works[0] != 0">{{ work.id }}</md-table-cell>
              <md-table-cell v-if="works[0] != 0">
                {{ work.price }}₺
              </md-table-cell>
              <md-table-cell v-if="works[0] != 0">
                {{ work.start }}
              </md-table-cell>
              <md-table-cell v-if="works[0] != 0">
                {{ work.finish }}
              </md-table-cell>
              <md-table-cell v-if="works[0] != 0">
                {{ work.created_at | moment("dddd, MMMM Do YYYY") }}
              </md-table-cell>
              <md-table-cell v-if="works[0] != 0">
                <md-button
                  @click="
                    editWork = true;
                    workindex = i;
                  "
                >
                  <md-icon class="text-primary">edit</md-icon>
                </md-button>
              </md-table-cell>
              <md-table-cell v-if="works[0] != 0">
                <md-button @click="deleteWork(work.id)">
                  <md-icon class="text-primary">delete</md-icon>
                </md-button>
              </md-table-cell>
            </md-table-row>
          </md-table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      id: this.$route.params.id,
      workHours: "Şimdiye Kadarki Olan Çalışma Saatleri",
      workPrices: 0,
      workMinutes: 0,
      gender: "",
      phone: "",
      user: {
        work: [0],
      },
      name: "",
      work: {
        start: 0,
        finish: 0,
        date: 0,
      },
      get: {
        startDate: Date(),
        finishDate: Date(),
      },
      works: [
        {
          start: 0,
          finish: 0,
        },
      ],
      editWork: false,
      showDialog: false,
      workindex: 0,
      weekForMinute: 0,
      week: 0,
      tillNow: 0,
      tillNowMinute: 0,
      details: [],
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
      weekChart: true,
      showDownloadButton: false,
    };
  },

  methods: {
    getDaysValues() {
      this.axios
        .post(this.$store.state.baseUrl + "/getDaysValues", {
          startDate: this.get.startDate + " 00:00:00",
          finishDate: this.get.finishDate + " 23:59:59",
          id: this.user.id,
        })
        .then((result) => {
          this.works = result.data.works;
          this.workHours = this.get.startDate + " | " + this.get.finishDate;
          this.weekChart = false;
          this.workMinutes = result.data.minute;
          this.showDownloadButton = true;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    deleteWork(id) {
      this.axios
        .post(this.$store.state.baseUrl + "/deleteWork", {
          id: id,
        })
        .then(() => {
          this.$router.go();
        })
        .catch((err) => {
          console.log(err);
        });
    },
    editedWork(id) {
      this.axios
        .post(this.$store.state.baseUrl + "/editedWork", {
          start: this.work.start,
          finish: this.work.finish,
          date: this.work.date,
          id: id,
        })
        .then(() => {
          this.$router.go();
        })
        .catch((err) => {
          console.log(err);
        });
      this.editWork = false;
    },
    getDetails() {
      var parsedobj = JSON.parse(JSON.stringify(this.details));
      var result = Object.keys(parsedobj).map((key) => [
        Number(key),
        parsedobj[key],
      ]);
      var series = Array();
      var labels = Array();

      result.map((k) => series.push(k[1]));
      result.map((k) => labels.push(String(k[0])));
      this.monochrome.series = series;
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
      var minute = 0;
      for (let index = 0; index < this.monochrome.series.length; index++) {
        minute += this.monochrome.series[index];
      }
      this.weekForMinute = minute;
    },
    changeName() {
      this.axios
        .post(this.$store.state.baseUrl + "/changeName", {
          name: this.name,
          gender: this.gender,
          phone: this.phone,
          id: this.user.id,
        })
        .then((result) => {
          this.user.name = result.data;
        })
        .catch((err) => {
          console.log(err);
        });
      this.showDialog = false;
      this.name = "";
      this.phone = "";
      this.gender = "";
    },
  },
  mounted() {
    this.axios
      .post(this.$store.state.baseUrl + "/getUser", { id: this.id })
      .then((result) => {
        this.user = result.data.user;
        this.works = result.data.work;
      })
      .catch((err) => {
        console.log(err);
      });

    this.axios
      .post(this.$store.state.baseUrl + "/getAllWorks", { id: this.id })
      .then((result) => {
        if (result.data != 0) {
          this.tillNowMinute = result.data;
        }
      })
      .catch((err) => {
        console.log(err);
      });
    this.axios
      .post(this.$store.state.baseUrl + "/getWeekWorks", { id: this.id })
      .then((result) => {
        if (result.data != []) {
          this.details = result.data;
          this.getDetails();
        }
      })
      .catch((err) => {
        console.log(err);
      });
    this.axios
      .post(this.$store.state.baseUrl + "/getWeekWorksForPrice", {
        id: this.id,
      })
      .then((result) => {
        if (result.data != []) {
          this.week = result.data;
        }
      })
      .catch((err) => {
        console.log(err);
      });
    this.axios
      .post(this.$store.state.baseUrl + "/getAllWorksForPrice", { id: this.id })
      .then((result) => {
        if (result.data != []) {
          this.tillNow = result.data;
        }
      })
      .catch((err) => {
        console.log(err);
      });
  },
};
</script>

<style scoped>
.ortalama {
  margin: 0 auto 0 auto;
  display: table;
}
/* From cssbuttons.io by @barisdogansutcu */
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
