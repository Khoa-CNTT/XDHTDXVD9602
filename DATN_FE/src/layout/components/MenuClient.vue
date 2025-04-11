<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
            <router-link to="/" class="navbar-brand p-0">
                <h1 class="text-primary"><img src="../../assets/assets_rocker/images/logo-icon-cl.png" alt="">ForYou</h1>
            </router-link>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0 pe-4">
                <router-link to="/" exact-active-class="active" class="nav-item nav-link" exact>Home</router-link>
                <router-link to="/about" exact-active-class="active" class="nav-item nav-link">About</router-link>
                <router-link to="/menu" exact-active-class="active" class="nav-item nav-link">Menu</router-link>
                <router-link to="/news" exact-active-class="active" class="nav-item nav-link">News</router-link>
            </div>
        </div>
    </nav>
</template>
<script>
export default {

}
</script>
<style></style>