<template>
    <div class="modal fade" id="create-and-edit-modal" tabindex="-1" role="dialog" aria-labelledby="create-and-edit-modal-label" aria-hidden="true" ref="createAndEditModalRef">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="editmode" class="modal-title" id="create-and-edit-modal-label">Add new</h5>
                    <h5 v-show="!editmode" class="modal-title" id="create-and-edit-modal-label">Edit hotel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ? updateHotel() : storeHotel()">
                    <div class="modal-body">
                        <div class="form-group mx-2 mt-2">
                            <label for="name">Name *</label>
                            <input id="name"
                                   class="form-control"
                                   type="text"
                                   name="name"
                                   placeholder="Name"
                                   :class="{ 'border border-danger': hotelErrors.nameErrorPresent }"
                                   v-model="hotelsForm.name">
                            <small class="text-danger" v-if="hotelErrors.nameErrorPresent">
                                {{ hotelErrors.name }}
                            </small>
                        </div>
                        <div class="form-group mx-2 mt-2">
                            <label for="rating">Rating *</label>
                            <input id="rating"
                                   class="form-control"
                                   type="text"
                                   name="rating"
                                   placeholder="Rating"
                                   :class="{ 'border border-danger': hotelErrors.ratingErrorPresent }"
                                   v-model="hotelsForm.rating">
                            <small class="text-danger" v-if="hotelErrors.ratingErrorPresent">
                                {{ hotelErrors.rating }}
                            </small>
                        </div>
                        <div class="form-group mx-2 mt-2">
                            <label for="category">Category *</label>
                            <input id="category"
                                   class="form-control"
                                   type="text"
                                   name="category"
                                   placeholder="Category"
                                   :class="{ 'border border-danger': hotelErrors.categoryErrorPresent }"
                                   v-model="hotelsForm.category">
                            <small class="text-danger" v-if="hotelErrors.categoryErrorPresent">
                                {{ hotelErrors.category }}
                            </small>
                        </div>
                        <div class="form-group mx-2 mt-2">
                            <label for="location_id">Location *</label>
                            <select id="location_id"
                                    class="form-control"
                                    name="location_id"
                                    :class="{ 'border border-danger': hotelErrors.locationIdErrorPresent }"
                                    v-model="hotelsForm.location_id">
                                <option value="">Choose a location</option>
                                <option :value="location.id" v-for="location in locations" :key="location.id">
                                    {{ location.address + ', ' + location.city + ', ' + location.country }}
                                </option>
                            </select>
                            <small class="text-danger" v-if="hotelErrors.locationIdErrorPresent">
                                {{ hotelErrors.locationId }}
                            </small>
                        </div>
                        <div class="form-group mx-2 mt-2">
                            <label class="d-block" for="image">Image *</label>
                            <img v-show="editmode || loadPhoto != ''"
                                 class="rounded"
                                 :src="loadPhoto != '' ? loadPhoto : hotelsForm.image"
                                 alt="Fotografija"
                                 width="100">
                            <div class="input-group mt-2" :class="{ 'border border-danger': hotelErrors.imageErrorPresent }" style="border-radius: 0.25rem;">
                                <div class="custom-file">
                                    <input id="image"
                                           class="custom-file-input"
                                           :class="{ 'border border-danger': hotelsForm.imageErrorPresent }"
                                           name="image"
                                           type="file"
                                           @change="loadPhotoFile">
                                    <label class="custom-file-label" for="image">Add Image</label>
                                </div>
                            </div>
                            <small class="text-danger" v-if="hotelErrors.imageErrorPresent">
                                {{ hotelErrors.image }}
                            </small>
                        </div>
                        <div class="form-group mx-2 mt-2">
                            <label for="reputation">Reputation *</label>
                            <input id="reputation"
                                   class="form-control"
                                   type="text"
                                   name="reputation"
                                   placeholder="Reputation"
                                   :class="{ 'border border-danger': hotelErrors.reputationErrorPresent }"
                                   v-model="hotelsForm.reputation">
                            <small class="text-danger" v-if="hotelErrors.reputationErrorPresent">
                                {{ hotelErrors.reputation }}
                            </small>
                        </div>
                        <div class="form-group mx-2 mt-2">
                            <label for="price">Price *</label>
                            <input id="price"
                                   class="form-control"
                                   type="text"
                                   name="price"
                                   placeholder="Price"
                                   :class="{ 'border border-danger': hotelErrors.priceErrorPresent }"
                                   v-model="hotelsForm.price">
                            <small class="text-danger" v-if="hotelErrors.priceErrorPresent">
                                {{ hotelErrors.price }}
                            </small>
                        </div>
                        <div class="form-group mx-2 mt-2">
                            <label for="availability">Availability *</label>
                            <input id="availability"
                                   class="form-control"
                                   type="text"
                                   name="availability"
                                   placeholder="Availability"
                                   :class="{ 'border border-danger': hotelErrors.availabilityErrorPresent }"
                                   v-model="hotelsForm.availability">
                            <small class="text-danger" v-if="hotelErrors.availabilityErrorPresent">
                                {{ hotelErrors.availability }}
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button id="updateHotelsButton"
                                class="btn btn-primary"
                                type="submit"
                                v-show="editmode"
                                @click="storeUpdateDisabled = true">
                            Save
                            <span class="spinner-border-sm"
                                  role="status"
                                  aria-hidden="true"
                                  :class="{ 'spinner-border': storeUpdateDisabled }"></span>
                        </button>
                        <button id="storeHotel"
                                class="btn btn-primary"
                                type="submit"
                                v-show="!editmode"
                                @click="storeUpdateDisabled = true">
                            Add
                            <span class="spinner-border-sm"
                                  role="status"
                                  aria-hidden="true"
                                  :class="{ 'spinner-border': storeUpdateDisabled }"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import { EventBus } from '../../libraries/event-bus.js';
    import { swalSuccess } from '../../libraries/my-libs.js';
    export default {
        data() {
            return {
                storeUpdateDisabled: false,
                editmode: true,
                locations: [],
                loadPhoto: "",
                hotelsForm: {
                    id: "",
                    name: "",
                    rating: "",
                    category: "",
                    reputation: "",
                    price: "",
                    location_id: "",
                    image: "",
                    photo_file: "",
                    availability: ""
                },
                hotelErrors: {
                    name: "",
                    nameErrorPresent: false,
                    rating: "",
                    ratingErrorPresent: false,
                    category: "",
                    categoryErrorPresent: false,
                    reputation: "",
                    reputationErrorPresent: false,
                    price: "",
                    priceErrorPresent: false,
                    locationId: "",
                    locationIdErrorPresent: false,
                    image: "",
                    imageErrorPresent: false,
                    availability: "",
                    availabilityErrorPresent: false
                }
            };
        },
        methods: {
            createHotel() {
                this.editmode = false;
                this.resetHotelErrors();
                this.resetHotelForm();
                $('#create-and-edit-modal').modal('show');
            },
            storeHotel() {
                this.resetHotelErrors();
                const formData = new FormData();
                formData.append("id", this.hotelsForm.id);
                formData.append("name", this.hotelsForm.name);
                formData.append("rating", this.hotelsForm.rating);
                formData.append("category", this.hotelsForm.category);
                formData.append("reputation", this.hotelsForm.reputation);
                formData.append("price", this.hotelsForm.price);
                formData.append("location_id", this.hotelsForm.location_id);
                formData.append("availability", this.hotelsForm.availability);
                if(this.checkIfNotEmpty(this.hotelsForm.photo_file)) {
                    formData.append("image", this.hotelsForm.photo_file, this.hotelsForm.photo_file.name);
                }for (var pair of formData.entries()) {
                    console.log(pair[0]+ ', ' + pair[1]);
                }

                const config = { headers: { 'content-type': 'multipart/form-data' } };
                axios.post(`${window.base_url}/admin/hotels`, formData, config)
                    .then((response) => {
                        this.storeUpdateDisabled = false;
                        if(response.data[0] == "success") {
                            $("#create-and-edit-modal").modal("hide");
                            EventBus.$emit('load-hotels');
                            swalSuccess("Success.");
                        }
                    }).catch(error => {
                        console.log(error)
                    console.log(error.response)
                    this.storeUpdateDisabled = false;
                    if (error.response.status === 422) {
                        this.checkForValidationErrors(error.response.data.errors);
                    }
                });
            },
            checkIfNotEmpty(value){
                return value !== null && value !== undefined && value !== "";
            },
            editHotel(hotel) {
                this.editmode = true;
                this.resetHotelForm();
                this.resetHotelErrors();
                this.fillHotelsForm(hotel);
                $('#create-and-edit-modal').modal("show");
            },
            updateHotel() {
                this.resetHotelErrors();
                const formData = new FormData();
                formData.append("id", this.hotelsForm.id);
                formData.append("name", this.hotelsForm.name);
                formData.append("rating", this.hotelsForm.rating);
                formData.append("category", this.hotelsForm.category);
                formData.append("reputation", this.hotelsForm.reputation);
                formData.append("price", this.hotelsForm.price);
                formData.append("location_id", this.hotelsForm.location_id);
                formData.append("availability", this.hotelsForm.availability);
                if(this.checkIfNotEmpty(this.hotelsForm.photo_file)) {
                    formData.append("image", this.hotelsForm.photo_file, this.hotelsForm.photo_file.name);
                }
                formData.append("_method", "PATCH");

                const config = { headers: { "content-type": "multipart/form-data" } };
                axios.post(`${window.base_url}/admin/hotels/${this.hotelsForm.id}`, formData, config)
                    .then(response => {
                        this.storeUpdateDisabled = false;
                        if(response.data[0] === "success") {
                            $("#create-and-edit-modal").modal("hide");
                            swalSuccess("Success.");
                            EventBus.$emit('load-hotels');
                        }
                    }).catch(error => {
                    this.storeUpdateDisabled = false;
                    if (error.response.status === 422) {
                        this.checkForValidationErrors(error.response.data.errors);
                    }
                });
            },
            fillHotelsForm(hotel) {
                this.hotelsForm.id = hotel.id;
                this.hotelsForm.name = hotel.name;
                this.hotelsForm.rating = hotel.rating;
                this.hotelsForm.category = hotel.category;
                this.hotelsForm.reputation = hotel.reputation;
                this.hotelsForm.price = hotel.price;
                this.hotelsForm.location_id = hotel.location_id;
                this.hotelsForm.image = hotel.image;
                this.hotelsForm.availability = hotel.availability;
            },
            resetHotelForm() {
                this.hotelsForm.id = "";
                this.hotelsForm.name = "";
                this.hotelsForm.rating = "";
                this.hotelsForm.category = "";
                this.hotelsForm.reputation = "";
                this.hotelsForm.price = "";
                this.hotelsForm.location_id = "";
                this.hotelsForm.image = "";
                this.hotelsForm.photo_file = "";
                this.loadPhoto = "";
                this.hotelsForm.availability = "";
            },
            resetHotelErrors() {
                this.hotelErrors.name = "";
                this.hotelErrors.nameErrorPresent = false;
                this.hotelErrors.rating = "";
                this.hotelErrors.ratingErrorPresent = false;
                this.hotelErrors.category = "";
                this.hotelErrors.categoryErrorPresent = false;
                this.hotelErrors.reputation = "";
                this.hotelErrors.reputationErrorPresent = false;
                this.hotelErrors.price = "";
                this.hotelErrors.priceErrorPresent = false;
                this.hotelErrors.locationId = "";
                this.hotelErrors.locationIdErrorPresent = false;
                this.hotelErrors.image = "";
                this.hotelErrors.imageErrorPresent = false;
                this.hotelErrors.availability = "";
                this.hotelErrors.availabilityErrorPresent = false;
            },
            checkForValidationErrors(errors) {
                if(errors.hasOwnProperty("name")) {
                    this.hotelErrors.name = errors["name"][0];
                    this.hotelErrors.nameErrorPresent = true;
                }
                if(errors.hasOwnProperty("rating")) {
                    this.hotelErrors.rating = errors["rating"][0];
                    this.hotelErrors.ratingErrorPresent = true;
                }
                if(errors.hasOwnProperty("category")) {
                    this.hotelErrors.category = errors["category"][0];
                    this.hotelErrors.categoryErrorPresent = true;
                }
                if(errors.hasOwnProperty("reputation")) {
                    this.hotelErrors.reputation = errors["reputation"][0];
                    this.hotelErrors.reputationErrorPresent = true;
                }
                if(errors.hasOwnProperty("price")) {
                    this.hotelErrors.price = errors["price"][0];
                    this.hotelErrors.priceErrorPresent = true;
                }
                if(errors.hasOwnProperty("location_id")) {
                    this.hotelErrors.locationId = errors["location_id"][0];
                    this.hotelErrors.locationIdErrorPresent = true;
                }
                if(errors.hasOwnProperty("image")) {
                    this.hotelErrors.image = errors["image"][0];
                    this.hotelErrors.imageErrorPresent = true;
                }
                if(errors.hasOwnProperty("availability")) {
                    this.hotelErrors.availability = errors["availability"][0];
                    this.hotelErrors.availabilityErrorPresent = true;
                }
            },
            loadLocations() {
                axios.get(`${window.base_url}/admin/all-locations`).then(response => {
                    if(response.data[0] === "success") {
                        this.locations = response.data[1];
                    }
                });
            },
            loadPhotoFile(e) {
                let photoInput = e.target;
                if(photoInput.files && photoInput.files[0]) {
                    this.hotelsForm.photo_file = photoInput.files[0];
                    const reader = new FileReader();
                    reader.onload = e => {
                        this.loadPhoto = e.target.result;
                    };
                    reader.readAsDataURL(photoInput.files[0]);
                }
                photoInput.value = '';
            },
        },
        mounted() {
            this.loadLocations();
            EventBus.$on('open-create-modal', () => this.createHotel());
            EventBus.$on('open-edit-modal', hotel => this.editHotel(hotel));
            $(this.$refs.createAndEditModalRef).on("hidden.bs.modal", this.clearData);
        }
    }
</script>

<style scoped>
    .modal-body .invalid-tab {
        color: #dc3545;
        background-color: #F8D3D7;
    }
</style>
