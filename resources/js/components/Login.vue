<template>
  <v-app >

  <v-img


      height="auto"
      src="./assets/bg.jpg"
    >

<v-row>
   <v-col  class="   mx-auto col-md-4 offset-md-4 my-auto mt-15 ">
    <v-card
        elevation="3"
           class=" mx-auto my-auto"
        >
 <v-img
      class="white--text align-end"
      height="150px"
      src="./assets/logo.jpg"
    ></v-img>

<v-card-title>
    Masukan Detail Login
</v-card-title>

  <v-card-text>
         <v-text-field
            v-model="SignIn.email"
            label="Email"
            :rules="[rules.required,rules.emailMatch]"
            :error-messages="errors.email"
            placeholder="Email"
            outlined
          ></v-text-field>

   <v-text-field
            v-model="SignIn.password"
            :error-messages="errors.password"
            :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
            :rules="[rules.required, rules.min]"
            :type="show2 ? 'text' : 'password'"
            name="input-10-2"
            label="Password"
            outlined
            hint="At least 8 characters"
            class="input-group--focused"
            @click:append="show2 = !show2"
          ></v-text-field>
<v-divider></v-divider>
  <v-card-actions  justify="end">
        <v-row>
            <v-col  class="text-justify" >


       <v-btn @click="ProsesSignIn()" block  color="primary white--text">
        Masuk <v-icon>mdi-login-variant</v-icon>
      </v-btn>

            </v-col>
        </v-row>
    </v-card-actions>
  </v-card-text>
    </v-card>
   </v-col>
</v-row>
  </v-img>
  </v-app>
</template>

<script>
  export default {
    data () {
      return {
        errors :[],
        SignIn :{
            email :'',
            password:''
        },
        show2: false,
        rules: {
          required: value => !!value || 'Required.',
          min: v => v.length >= 8 || 'Min 8 characters',
          emailMatch:    v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'

       },
      }
    },
    methods:{
        ProsesSignIn(){
            this.$root.$emit('PesanLoading','Proses Login');
           axios.post('/api/SignIn',this.SignIn).then((res) =>{
                   if(res.data.status == true){
                            this.$cookies.set('name', res.data.data.name,60 * 60 * 1);
                            this.$cookies.set('email', res.data.data.email,60 * 60 * 1);
                            this.$cookies.set('level_user', res.data.data.level_user,60 * 60 * 1);
                            this.$cookies.set("token",res.data.data.access_token,60 * 60 * 1);
                            this.$router.replace("/Dashboard");
                        }
                     this.$root.$emit('PesanResponse',res.data.message,"primary");
                     }).catch((error) =>{
                       this.errors = error.response.data.errors;
                       this.$root.$emit('PesanResponse',error.response.data.message,"red");
                    });

        }
    }
  }
</script>
