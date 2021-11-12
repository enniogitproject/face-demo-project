<template>
  <div>
    <h3 class="text-center">Create User</h3>

    <div v-if="errors" role="alert">
      <div v-for="(v, k) in errors" :key="k">
        <p
          v-for="error in v"
          :key="error"
          class="alert alert-danger"
          role="alert"
        >
          {{ error }}
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <form @submit.prevent="addUser">
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" v-model="user.name" />
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" v-model="user.email" />
          </div>
          <div class="form-group">
            <label>Password</label>
            <input
              type="password"
              class="form-control"
              v-model="user.password"
            />
          </div>
            <vue-recaptcha sitekey="6Lfr7SsdAAAAACChiW1ZpE45J9fRBHssTvKUzWye" 
            :loadRecaptchaScript="true"
            @verify="onCaptchaVerified"
            >
            </vue-recaptcha>

          <br>
          <button type="submit" class="btn btn-primary">Create</button>
        </form>
      </div>
    </div>
  </div>
</template>
 
<script>

import VueRecaptcha from 'vue-recaptcha';

export default {
  components: { "vue-recaptcha": VueRecaptcha },

  data() {
    return {
      user: {
          name: '',
          email: '',
          password: '',
          token: ''
      },
      errors: null,
      loadingPage: true,
    };
  },
  mounted() {
    this.loadingPage = false;
  },
  methods: {

    onCaptchaVerified(recaptchaToken) {
      this.user.token = recaptchaToken;
    },
    onCaptchaExpired() {
      //this.$refs.recaptcha.reset();
    },

    addUser() {

      this.loadingPage = true;
      this.axios
        .post("http://localhost:8000/api/users", this.user)
        .then((response) => this.$router.push({ name: "home" }),
            this.loadingPage = false,
            this.onCaptchaExpired(),
)
        .catch((e) => {
          this.errors = e.response.data.errors;
          this.loadingPage = false;
        })
        .finally(() => (this.loading = false));
    }
    
  },
};
</script>