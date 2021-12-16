<template>
  <v-data-table
    :headers="headers"
    :items="databarang"
    sort-by="calories"
     item-key="id_permintaan"
      :single-expand="singleExpand"
    :expanded.sync="expanded"
    show-expand
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat class="primary white--text">
        <v-toolbar-title color="primary"
          >Daftar Permintaan Barang</v-toolbar-title
        >
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-spacer></v-spacer>
        <v-dialog
          v-model="dialog"
          transition="dialog-top-transition"
          max-width="1200px"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="white "
              dark
              class="mb-2 text-capitalize primary--text"
              v-bind="attrs"
              v-on="on"
              @click="getBarang()"
            >
              Buat Permintaan Barang
              <v-icon>mdi-plus</v-icon>
            </v-btn>
          </template>
          <v-card>
            <v-card-title class="primary">
              <span class="text-h6 white--text">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container class="mt-5 amber lighten-5">
                <v-row>
                  <v-col class="col-md-6">
                    <v-text-field
                      v-model="karyawans.id_nik"
                      @change="CariNik()"
                      :rules="[rules.required]"
                      label="Nik Peminta"
                      dense
                      placeholder="Nik Peminta"
                      outlined
                    >
                    </v-text-field>
                  </v-col>
                  <v-col class="col-md-6">
                    <v-text-field
                      v-model="karyawans.nama"
                      label="Nama"
                      dense
                      disabled
                      placeholder="Nama"
                      outlined
                    >
                    </v-text-field>
                  </v-col>
                  <v-col class="col-md-6">
                    <v-text-field
                      v-model="karyawans.department"
                      label="Departement"
                      dense
                      disabled
                      placeholder="Departement"
                      outlined
                    >
                    </v-text-field>
                  </v-col>
                  <v-col class="col-md-6">
                    <v-dialog
                      ref="dialog"
                      v-model="modal"
                      :return-value.sync="karyawans.tgl_permintaan"
                      persistent
                      width="290px"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          v-model="karyawans.tgl_permintaan"
                          label="Tanggal Permintaan"
                          readonly
                          dense
                          outlined
                          v-bind="attrs"
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-date-picker v-model="karyawans.tgl_permintaan" scrollable>
                        <v-spacer></v-spacer>
                        <v-btn text color="primary" @click="modal = false">
                          Cancel
                        </v-btn>
                        <v-btn
                          text
                          color="primary"
                          @click="$refs.dialog.save(karyawans.tgl_permintaan)"
                        >
                          OK
                        </v-btn>
                      </v-date-picker>
                    </v-dialog>
                  </v-col>
                </v-row>
                <div class="divider"></div>
                <v-row>
                  <v-col>
                    <v-simple-table>
                      <template v-slot:default>
                        <thead class="primary">
                          <tr>
                            <th class="text-left white--text" width="5">#</th>
                            <th class="text-left white--text" width="400">
                              Barang
                            </th>
                            <th class="text-left white--text" width="100">
                              Lokasi
                            </th>
                            <th class="text-left white--text" width="100">
                              Tersedia
                            </th>
                            <th class="text-left white--text" width="5">
                              Quantity
                            </th>
                            <th class="text-left white--text" width="10">
                              Satuan
                            </th>
                            <th class="text-left white--text" width="120">
                              Keterangan
                            </th>
                            <th class="text-left white--text" width="70">
                              Status
                            </th>
                            <th class="text-left white--text" width="10">
                              Aksi
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr
                            class="p-2"
                            v-for="(item, index) in record"
                            :key="index"
                          >
                            <td>{{ index + 1 }}</td>
                            <td class="pr-1 pl-1">
                              <v-autocomplete
                                dense
                                hide-details
                                clearable
                                v-model="record[index]"
                                :items="states"
                                return-object

                                item-text="nama_barang"
                                solo
                              ></v-autocomplete>
                            </td>
                            <td class="pt-1 pb-1 pr-1 pl-1">
                              <v-text-field
                                v-model="record[index].lokasi"
                                hide-details
                                solo
                                dense
                                label="Lokasi"
                                placeholder="Lokasi"
                                disabled
                              ></v-text-field>
                            </td>
                            <td class="pt-1 pb-1 pr-1 pl-1">
                              <v-text-field
                                v-model="record[index].ketersediaan"
                                hide-details
                                solo
                                dense
                                label="Ketersediaan"
                                placeholder="Ketersediaan"
                                disabled
                              ></v-text-field>
                            </td>
                            <td class="pt-1 pb-1 pr-1 pl-1">
                              <v-text-field
                                v-model="record[index].qty"
                                hide-details
                                 type="number"
                                solo
                                dense
                                label="Qty"
                                placeholder="Qty"
                              ></v-text-field>
                            </td>
                            <td class="pt-1 pb-1 pr-1 pl-1">
                              <v-text-field
                                v-model="record[index].satuan"
                                hide-details
                                solo
                                dense
                                label="Satuan"
                                placeholder="Satuan"
                                disabled
                              ></v-text-field>
                            </td>
                            <td class="pt-1 pb-1 pr-1 pl-1">
                              <v-text-field
                                v-model="record[index].keterangan"
                                hide-details
                                solo
                                dense
                                label="Keterangan"
                                placeholder="Keterangan"
                              ></v-text-field>
                            </td>
                            <td class="pt-1 pb-1 pr-1 pl-1">
                              <v-avatar
                               v-show="record[index].status"
                                color="orange"
                                rounded
                                class="white--text"
                                size="26px"
                                width="100"
                              >
                                {{ record[index].status }}</v-avatar
                              >
                            </td>
                            <td class="pt-1 pb-1 pr-1 pl-1">
                              <v-btn
                                small
                                v-show="index > 0"
                                @click="deleteRecord(index)"
                                class="red"
                                ><v-icon>mdi-close</v-icon></v-btn
                              >
                            </td>
                          </tr>
                          <tr>
                            <td colspan="9" class="text-right">
                              <v-btn
                                @click="TambahRecord()"
                                class="primary text-right text-capitalize"
                                >Tambah <v-icon>mdi-plus</v-icon></v-btn
                              >
                            </td>
                          </tr>
                        </tbody>
                      </template>
                    </v-simple-table>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="red"    @click="close"> Cancel </v-btn>
              <v-btn color="primary "   @click="ProsesPermintaan()"> Proses Permintaan </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="text-h5"
              >Are you sure you want to delete this item?</v-card-title
            >
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete"
                >Cancel</v-btn
              >
              <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                >OK</v-btn
              >
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:expanded-item="{ headers, item }">
      <td :colspan="headers.length">
         <v-simple-table>
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-left">
            Nama barang
          </th>
          <th class="text-left">
            Qty
          </th>
          <th class="text-left">
          Satuan
          </th>
          <th class="text-left">
            Keterangan
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="i in item.daftarpermintaan"
          :key="i.id_daftar_permintaan"
        >
          <td>{{ i.nama_barang }}</td>
          <td>{{ i.qty }}</td>
          <td>{{ i.satuan }}</td>
          <td>{{ i.keterangan }}</td>
        </tr>
      </tbody>
    </template>
  </v-simple-table>

      </td>
    </template>
    <template>
      <v-icon small class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
      <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
    </template>
    <template v-slot:no-data>
      <v-btn color="primary" @click="initialize"> Reset </v-btn>
    </template>
  </v-data-table>
</template>

<script>
export default {
  data: () => ({
      expanded: [],
        singleExpand: false,
       rules: {
          required: value => !!value || 'Required.',
        },
    states: [],
     errors :[],
    karyawans: {
      id_nik: "",
      nama: "",
      tgl_permintaan :new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
      .toISOString()
      .substr(0, 10),
      department: "",
    },
    modal: false,
    dialog: false,
    dialogDelete: false,
    headers: [
      {
        text: "ID",
        align: "start",
        sortable: false,
        value: "id_permintaan",
      },
      { text: "Id Nik", value: "id_nik" },
      { text: "Nama", value: "nama" },
      { text: "Tanggal Permintaan", value: "tgl_permintaan" },
      { text: "Jumlah Item", value: "jumlah_item" },
      { text: "Jumlah Qty", value: "jumlah_qty" },
    ],
    databarang: [],
    editedIndex: -1,
    editedItem: {
      name: "",
      calories: 0,
      fat: 0,
      carbs: 0,
      protein: 0,
    },
    record: [
      {
        id_barang: "",
        keterangan: "",
        ketersediaan: "",
        lokasi: "",
        nama_barang: "",
        qty: "",
        satuan: "",
        status: "",
      },
    ],
    model: null,
    defaultItem: {
      name: "",
      calories: 0,
      fat: 0,
      carbs: 0,
      protein: 0,
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1
        ? "Tambah Permintaan Barang"
        : "Edit Permintaan Barang";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  created() {
    this.initialize();
  },

  methods: {

     ProsesPermintaan(){
           this.$root.$emit("PesanLoading", "Proses Permintaan");
      axios
        .post(
          "/api/auth/ProsesPermintaan",
           {karyawan : this.karyawans,pesanan :this.record},
          {
            headers: {
              Authorization: "Bearer " + this.$cookies.get("token"),
            },
          }
        )
        .then((res) => {
          if (res.data.status == true) {
            this.karyawans = res.data.data;
             this.close();
                this.record = [{}];
                this.karyawans = [{}];
                 this.initialize();
          }
          this.$root.$emit("PesanResponse", res.data.message, "primary");
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          this.$root.$emit("PesanResponse", error.response.data.message, "red");
        });
     },

    getBarang() {
      this.$root.$emit("PesanLoading", "Mengambil Data Barang");
      axios
        .get("/api/auth/getBarang", {
          headers: {
            Authorization: "Bearer " + this.$cookies.get("token"),
          },
        })
        .then((res) => {
          if (res.data.status == true) {
            this.states = res.data.data;
          }
          this.$root.$emit("PesanResponse", res.data.message, "primary");
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          this.$root.$emit("PesanResponse", error.response.data.message, "red");
        });
    },
    deleteRecord(index) {
      if (index > 0) {
        this.record.splice(index, 1);
      }
    },

    TambahRecord() {
      this.record.push({
        id_barang: "",
        keterangan: "",
        ketersediaan: "",
        lokasi: "",
        nama_barang: "",
        qty: "",
        satuan: "",
        status: "",
      });
    },
    CariNik() {
      this.$root.$emit("PesanLoading", "Mencari Nik Peminta");
      axios
        .post(
          "/api/auth/SearchNik",
          { id_nik: this.karyawans.id_nik },
          {
            headers: {
              Authorization: "Bearer " + this.$cookies.get("token"),
            },
          }
        )
        .then((res) => {
          if (res.data.status == true) {
            this.karyawans = res.data.data;
          }else{
              this.karyawans.id_nik = null ;
          }
          this.$root.$emit("PesanResponse", res.data.message, "primary");
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          this.$root.$emit("PesanResponse", error.response.data.message, "red");
        });
    },
    initialize() {


        this.$root.$emit("PesanLoading", "Mengambil data permintaan");
      axios
        .get(
          "/api/auth/DataPermintaan",
          {
            headers: {
              Authorization: "Bearer " + this.$cookies.get("token"),
            },
          }
        )
        .then((res) => {
          if (res.data.status == true) {
            this.databarang = res.data.data;
          }
          this.$root.$emit("PesanResponse", res.data.message, "primary");
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          this.$root.$emit("PesanResponse", error.response.data.message, "red");
        });
    },

    editItem(item) {
      this.editedIndex = this.databarang.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.databarang.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      this.databarang.splice(this.editedIndex, 1);
      this.closeDelete();
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.databarang[this.editedIndex], this.editedItem);
      } else {
        this.databarang.push(this.editedItem);
      }
      this.close();
    },
  },
};
</script>
