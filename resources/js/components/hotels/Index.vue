<template>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Hotels table</h3>
                <div class="float-right">
                    <form class="form-inline ml-3">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar"
                                   type="search"
                                   placeholder="Search"
                                   aria-label="Search"
                                   v-model="searchKeyword"
                                   @keyup="searchHotels" >
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
                        <th class="text-center">Name</th>
                        <th class="text-center">Rating</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Reputation</th>
                        <th class="text-center">Badge</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Availability</th>
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
                    <tr v-for="hotel in hotels" :key="hotel.id">
                        <td class="text-center">{{ hotel.name }}</td>
                        <td class="text-center">{{ hotel.rating }}</td>
                        <td class="text-center">{{ hotel.category }}</td>
                        <td class="text-center">{{ hotel.reputation }}
                        <td class="text-center h2">
                            <i class="fas fa-frown text-danger" v-if="hotel.reputation <= 500"></i>
                            <i class="fas fa-meh text-warning" v-else-if="hotel.reputation > 500 && hotel.reputation < 800"></i>
                            <i class="fas fa-smile text-success" v-else></i>
                        </td>
                        <td class="text-center">{{ hotel.price }}</td>
                        <td class="text-center">{{ hotel.availability }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-info" @click="openEditModal(hotel)">
                                Edit
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-danger" @click="deleteHotel(hotel.id)">
                                Delete <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                <pagination v-show="searchMode" class="mt-2" align="right" show-disabled :data="hotelsPagination" :limit="1" @pagination-change-page="loadSearched">
                    <span slot="prev-nav">Previous</span>
                    <span slot="next-nav">Next</span>
                </pagination>
                <pagination v-show="!searchMode" class="mt-2" align="right" show-disabled :data="hotelsPagination" :limit="1" @pagination-change-page="loadHotels">
                    <span slot="prev-nav">Previous</span>
                    <span slot="next-nav">Next</span>
                </pagination>
            </div>
        </div>
        <create-and-edit :hotels="hotels" />
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
                hotels: [],
                hotelsPagination: {},
            };
        },
        methods: {
            loadHotels(page = 1) {
                axios.get(`${window.base_url}/admin/hotels?page=${page}`).then(response => {
                    if(response.data[0] === "success") {
                        this.hotelsPagination = response.data[1];
                        this.hotels = response.data[1].data;
                        this.pageIsLoading = false;
                    }
                });
            },
            loadSearched(page = 1) {
                axios.get(`${window.base_url}/admin/hotels/${this.searchKeyword}/search?page=${page}`).then(response => {
                    if(response.data[0] === "success") {
                        this.hotelsPagination = response.data[1];
                        this.hotels = response.data[1].data;
                    }
                });
            },
            searchHotels() {
                if(!(this.searchKeyword === "")) {
                    this.searchMode = true;
                    axios.get(`${window.base_url}/admin/hotels/${this.searchKeyword}/search`).then(response => {
                            if(response.data[0] === "success") {
                                this.hotelsPagination = response.data[1];
                                this.hotels = response.data[1].data;
                            }
                        });
                }
                else {
                    this.searchMode = false;
                    this.loadHotels();
                }
            },
            openCreateModal() {
                EventBus.$emit('open-create-modal');
            },
            openEditModal(hotel) {
                EventBus.$emit('open-edit-modal', hotel);
            },
            deleteHotel(id) {
                Swal.fire({
                    icon: "warning",
                    title: "Delete!",
                    text: "Are you sure you want to delete the hotel?",
                    showCancelButton: true,
                    cancelButtonColor: "#3085d6",
                    confirmButtonColor: "#c82333",
                    cancelButtonText: "Cancel",
                    confirmButtonText: "Delete"
                }).then((result) => {
                    if(result.value) {
                        axios.delete(`${window.base_url}/admin/hotels/${id}`)
                            .then(response => {
                                if(response.data[0] === "success") {
                                    swalSuccess("Hotel deleted.");
                                    this.loadHotels();
                                }
                            }).catch(error => {
                            Swal.fire("Error!", "There was an error", "warning");
                        });
                    }
                })
            },
        },
        mounted() {
            this.loadHotels();
            this.$emit('loadBreadcrumbLink', {url: '/hotel', pageName: 'Hotels'});
            EventBus.$on('load-hotels', () => this.loadHotels());
        }
    }
</script>
