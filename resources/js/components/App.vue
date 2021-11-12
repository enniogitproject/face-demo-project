<template>
  <div class="container" >
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">FaceProject</a>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <router-link to="/" class="nav-item nav-link">User List</router-link>
          </li>     
          <li class="nav-item">
            <router-link to="/create" class="nav-item nav-link">Create User</router-link>
          </li>
        </ul>
      </div>
    </nav>
    <div class="m-2">
      <router-view> </router-view>
    </div>
      
  </div>
</template>
 
<script>
export default {};
</script>