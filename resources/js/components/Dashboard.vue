<template>
  <v-app id="inspire">
    <v-app-bar color="white" app height="70">
      <v-text-field
        label="Pencarian"
        hide-details="auto"
      ></v-text-field>
      <v-btn icon>
        <v-icon>mdi-magnify</v-icon>
      </v-btn>
      <v-btn @click="LogOut()" icon>
        <v-icon>mdi-logout-variant</v-icon>
      </v-btn>

      <v-app-bar-nav-icon
        class="d-lg-none d-xl-flex"
        @click.stop="drawer = !drawer"
      ></v-app-bar-nav-icon>
    </v-app-bar>

    <v-navigation-drawer v-model="drawer" app>
      <v-sheet color="primary" class="pa-4">
        <v-avatar class="mb-4" color="grey darken-1" size="64"></v-avatar>

        <div class="white--text">{{this.$cookies.get("email")}}</div>
      </v-sheet>

      <v-divider></v-divider>

      <v-list>
        <router-link
          class="text-decoration-none"
          v-for="[icon, text, url] in links"
          :key="icon"
          :to="{ path: url }"
        >
          <v-list-item link>
            <v-list-item-icon>
              <v-icon>{{ icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>{{ text }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item></router-link
        >
      </v-list>
    </v-navigation-drawer>

    <v-main>
      <v-container class="py-8 px-6" fluid>
        <router-view></router-view>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {
  mounted() {},
  data: () => ({
    drawer: null,
    links: [
      ["mdi-tag-multiple", "Permintaan barang", "/Dashboard"],
      ["mdi-notebook", "Data Barang", "/Dashboard/data-barang"],
      ["mdi-account-tie", "Data Pegawai", "/Dashboard/data-karyawan"],
    ],
  }),
  methods: {
      LogOut(){

            this.$root.$emit('PesanLoading','Proses Logout');
           axios.post('/api/auth/SignOut',{},{
                    headers: {
                       'Authorization': 'Bearer '+this.$cookies.get('token'),
                    }
                 }).then((res) =>{
                   if(res.data.status == true){
                               this.$cookies.remove('name');
                               this.$cookies.remove('email');
                               this.$cookies.remove("token");
                               this.$router.replace("/");

                    }
                  this.$root.$emit('PesanResponse',res.data.message,"primary");
                  }).catch((error) =>{
                       this.errors = error.response.data.errors;
                       this.$root.$emit('PesanResponse',error.response.data.message,"red");
            });


        }
  },
};
</script>
