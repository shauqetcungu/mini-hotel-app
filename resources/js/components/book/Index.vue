<template>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Book hotel</h3>
            </div>

            <div class="card-body">
                <div v-if="pageIsLoading">
                    <div class="text-center">
                        <spinner />
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 text-center mb-4" v-for="hotel in hotels" :key="hotel.id">
                        <img :src="hotel.image" :alt="hotel.name" class="img-responsive w-100">
                        <h5>{{ hotel.name }}</h5>
                        <h3>
                            <i class="fa fa-frown text-danger" v-if="hotel.reputation <= 500"></i>
                            <i class="fa fa-meh text-warning" v-else-if="hotel.reputation > 500 && hotel.reputation < 800"></i>
                            <i class="fa fa-smile text-success" v-else></i>
                        </h3>
                        <h5 class="text-center">Available rooms: {{ hotel.availability }}</h5>
                        <button class="btn btn-sm btn-success" @click="bookHotel(hotel.id)" v-if="hotel.availability > 0">
                            Book hotel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Spinner from "../Spinner";
    import { EventBus } from '../../libraries/event-bus.js';
    import {swalSuccess} from "../../libraries/my-libs";
    export default {
        components: { Spinner },
        data() {
            return {
                pageIsLoading: true,
                hotels: [],
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
            bookHotel(id) {
                axios.post(`${window.base_url}/admin/hotels/${id}/book`)
                    .then(response => {
                        if(response.data[0] === "success") {
                            swalSuccess("Hotel booked.");
                            this.loadHotels();
                        }
                    }).catch(error => {
                    Swal.fire("Error!", "There was an error", "warning");
                });
            },
        },
        mounted() {
            this.loadHotels();
            this.$emit('loadBreadcrumbLink', {url: '/book', pageName: 'Book hotel'});
            EventBus.$on('load-hotels', () => this.loadHotels());
        }
    }
</script>
