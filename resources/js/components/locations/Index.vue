<template>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Locations table</h3>
                <div class="float-right">
                    <form class="form-inline ml-3">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar"
                                   type="search"
                                   placeholder="Search"
                                   aria-label="Search"
                                   v-model="searchKeyword"
                                   @keyup="searchLocations" >
                            <div class="input-group-append">
                                <button class="search-button btn btn-navbar border border-muted" @click.prevent="">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body">
                <button class="btn btn-sm btn-primary mb-2 float-right" @click="openCreateModal">
                    Add new <i class="fas fa-plus-circle"></i>
                </button>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="text-center">City</th>
                        <th class="text-center">State</th>
                        <th class="text-center">Country</th>
                        <th class="text-center">Zip code</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">Edit</th>
                        <th class="text-center">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="pageIsLoading">
                        <td class="text-center" colspan="9">
                            <spinner />
                        </td>
                    </tr>
                    <tr v-for="location in locations" :key="location.id">
                        <td class="text-center">{{ location.city }}</td>
                        <td class="text-center">{{ location.state }}</td>
                        <td class="text-center">{{ location.country }}</td>
                        <td class="text-center">{{ location.zip_code }}</td>
                        <td class="text-center">{{ location.address }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-info" @click="openEditModal(location)">
                                Edit
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-danger" @click="deleteLocation(location.id)">
                                Delete <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                <pagination v-show="searchMode" class="mt-2" align="right" show-disabled :data="locationsPagination" :limit="1" @pagination-change-page="loadSearched">
                    <span slot="prev-nav">Previous</span>
                    <span slot="next-nav">Next</span>
                </pagination>
                <pagination v-show="!searchMode" class="mt-2" align="right" show-disabled :data="locationsPagination" :limit="1" @pagination-change-page="loadLocations">
                    <span slot="prev-nav">Previous</span>
                    <span slot="next-nav">Next</span>
                </pagination>
            </div>
        </div>
        <create-and-edit :locations="locations" />
    </div>
</template>

<script>
    import CreateAndEdit from "./CreateAndEdit.vue";
    import Spinner from "../Spinner";
    import { EventBus } from '../../libraries/event-bus.js';
    import {swalSuccess} from "../../libraries/my-libs";
    export default {
        components: { CreateAndEdit, Spinner },
        data() {
            return {
                pageIsLoading: true,
                searchMode: false,
                searchKeyword: "",
                locations: [],
                locationsPagination: {},
            };
        },
        methods: {
            loadLocations(page = 1) {
                axios.get(`${window.base_url}/admin/locations?page=${page}`).then(response => {
                    if(response.data[0] === "success") {
                        this.locationsPagination = response.data[1];
                        this.locations = response.data[1].data;
                        this.pageIsLoading = false;
                    }
                });
            },
            loadSearched(page = 1) {
                axios.get(`${window.base_url}/admin/locations/${this.searchKeyword}/search?page=${page}`).then(response => {
                    if(response.data[0] === "success") {
                        this.locationsPagination = response.data[1];
                        this.locations = response.data[1].data;
                    }
                });
            },
            searchLocations() {
                if(!(this.searchKeyword === "")) {
                    this.searchMode = true;
                    axios.get(`${window.base_url}/admin/locations/${this.searchKeyword}/search`).then(response => {
                            if(response.data[0] === "success") {
                                this.locationsPagination = response.data[1];
                                this.locations = response.data[1].data;
                            }
                        });
                }
                else {
                    this.searchMode = false;
                    this.loadLocations();
                }
            },
            openCreateModal() {
                EventBus.$emit('open-create-modal');
            },
            openEditModal(location) {
                EventBus.$emit('open-edit-modal', location);
            },
            deleteLocation(id) {
                Swal.fire({
                    icon: "warning",
                    title: "Delete!",
                    text: "Are you sure you want to delete the location?",
                    showCancelButton: true,
                    cancelButtonColor: "#3085d6",
                    confirmButtonColor: "#c82333",
                    cancelButtonText: "Cancel",
                    confirmButtonText: "Delete"
                }).then((result) => {
                    if(result.value) {
                        axios.delete(`${window.base_url}/admin/locations/${id}`)
                            .then(response => {
                                if(response.data[0] === "success") {
                                    swalSuccess("Location deleted.");
                                    this.loadLocations();
                                }
                            }).catch(error => {
                                console.log(error)
                            Swal.fire("Error!", "There was an error", "warning");
                        });
                    }
                })
            },
        },
        mounted() {
            this.loadLocations();
            this.$emit('loadBreadcrumbLink', {url: '/location', pageName: 'Locations'});
            EventBus.$on('load-locations', () => this.loadLocations());
        }
    }
</script>
