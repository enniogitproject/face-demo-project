<template>
  <div>
    <h3 class="text-center">Edit User</h3>

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
        <form @submit.prevent="updateUser">
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
          <button type="submit" class="btn btn-primary">Update</button>
        </form>
      </div>
    </div>
  </div>
</template>
 
<script>
export default {
  data() {
    return {
      user: {},
      errors: null,
    };
  },
  created() {
    this.axios
      .get(`http://localhost:8000/api/users/${this.$route.params.id}`)
      .then((res) => {
        this.user = res.data;
      });
  },
  methods: {
    updateUser() {
      this.axios
        .patch(
          `http://localhost:8000/api/users/${this.$route.params.id}`,
          this.user
        )
        .then((res) => {
          this.$router.push({ name: "home" });
        })
        .catch((e) => {
          this.errors = e.response.data.errors;
        })
    },
  },
};
</script>