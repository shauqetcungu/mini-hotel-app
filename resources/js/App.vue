<template>
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="z-index: 2;">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">

                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link btn" @click.prevent="logout">
                        <i class="fas fa-power-off"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a :href="base_url" target="_blank" class="brand-link text-center">
                <span class="brand-text font-weight-light text-center">Hotel mini app</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ path: '/admin/' }">
                                <i class="fas fa-home nav-icon"></i>
                                <p>Home</p>
                            </router-link>
                        </li>
                    </ul>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ path: '/admin/hotel' }">
                                <i class="fas fa-hotel nav-icon"></i>
                                <p>Hotels</p>
                            </router-link>
                        </li>
                    </ul>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ path: '/admin/location' }">
                                <i class="fas fa-map-marker nav-icon"></i>
                                <p>Locations</p>
                            </router-link>
                        </li>
                    </ul>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ path: '/admin/book' }">
                                <i class="fas fa-check nav-icon"></i>
                                <p>Book Hotel</p>
                            </router-link>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">
                                {{ pageName }}
                            </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">
                                    <router-link to="/admin">Admin</router-link>
                                </li>
                                <li class="breadcrumb-item active">
                                    {{ pageName }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section id="content" class="content">
                <div class="container-fluid">
                    <div class="row">
                        <router-view @loadBreadcrumbLink="showBreadcrumbLink" :authUser="user"></router-view>
                    </div>
                </div>
            </section>
        </div>
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
</template>

<script>
    import { EventBus } from './libraries/event-bus.js';

    export default {
        data() {
            return {
                user: {},
                year: "",
                breadcrumbUrl: "",
                pageName: "",
                base_url: ""
            };
        },
        methods: {
            loadAdminInfo() {
                axios.get(`${window.base_url}/admin/admin-info`)
                    .then(response => {
                        if(response.data[0] === "success") {
                            this.user = response.data[1][0];
                            EventBus.$emit("authUser", this.user);
                        }
                    }).catch(() => {
                        Swal.fire("Error!", "Error", "warning");
                    });
            },
            logout() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Logout!',
                    text: "Are you sure you want to logout?",
                    showCancelButton: true,
                    cancelButtonColor: '#5a6268',
                    confirmButtonColor: '#0069d9',
                    cancelButtonText: 'Cancel',
                    confirmButtonText: 'Logout'
                }).then((result) => {
                    if (result.value) {
                        axios.post(`${window.base_url}/logout`).then(response => location.href = "/");
                    }
                })
            },
            showBreadcrumbLink(data) {
               this.breadCrumbUrl = data.url;
               this.pageName = data.pageName;
            },
        },
        watch: {
           user(newValue, oldValue) {
              this.user = newValue;
           }
        },
        mounted() {
           this.loadAdminInfo();
        },
        created() {
            this.base_url = window.base_url;
        }
    }
</script>

 <style lang="scss">
     .nav-item .router-link-exact-active.router-link-active {
         background-color: rgba(255,255,255,0.1);
         color: #f5fafe;
     }
 </style>
