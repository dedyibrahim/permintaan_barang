<template>
<v-app>
 <v-snackbar
     :color="response"
      v-model="snackbar"
      persistent
    >
      {{ pesan_response }}

      <template v-slot:action="{ attrs }">
        <v-btn
          color="white"
          text
          v-bind="attrs"
          @click="snackbar = false"
        >
          Close
        </v-btn>
      </template>
    </v-snackbar>


       <v-dialog
      v-model="dialog"
      persistent
      width="300"
    >
      <v-card
        color="primary"
        dark
        class="pt-3"
      >

        <v-card-text >
            <p class="text-center">{{pesanloading}}, Harap Tunggu ...</p>
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
    <router-view></router-view>
</v-app>
</template>

<script>
export  default{
     mounted() {
        this.$root.$on('PesanLoading', (data) => {
            this.PesanLoading(data)
         });
        this.$root.$on('PesanResponse', (data,response) => {
            this.PesanResponse(data,response)
         });
          this.$root.$on('PilihPaket', (data) => {
            this.PilihPaket(data)
         });
    },
    data(){
        return{
            multiLine: true,
            snackbar: false,
            text: ' multi-line snackbar.',
            dialog :false,
            pesanloading : '',
            pesan_response :'',
            response :'',

        }
    },
    methods :{

        PesanLoading(data){
        this.pesanloading = data;
          if(!this.dialog){
          this.dialog =  true;
          }else{
          this.dialog =  false;
          }
        },

          PesanResponse(data,response){
          this.pesan_response = data;
          this.response  = response;
          if(!this.snackbar){
          this.snackbar =  true;
          }else{
          this.snackbar =  false;
          }
          this.dialog = false;
    }
 }

}

</script>
