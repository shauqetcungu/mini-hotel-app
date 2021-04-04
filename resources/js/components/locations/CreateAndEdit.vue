<template>
    <div class="modal fade" id="create-and-edit-modal" tabindex="-1" role="dialog" aria-labelledby="create-and-edit-modal-label" aria-hidden="true" ref="createAndEditModalRef">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="editmode" class="modal-title" id="create-and-edit-modal-label">Add new</h5>
                    <h5 v-show="!editmode" class="modal-title" id="create-and-edit-modal-label">Edit location</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ? updateLocation() : storeLocation()">
                    <div class="modal-body">
                        <div class="form-group mx-2 mt-2">
                            <label for="city">City *</label>
                            <input id="city"
                                   class="form-control"
                                   type="text"
                                   name="city"
                                   placeholder="City"
                                   :class="{ 'border border-danger': locationErrors.cityErrorPresent }"
                                   v-model="locationsForm.city">
                            <small class="text-danger" v-if="locationErrors.cityErrorPresent">
                                {{ locationErrors.city }}
                            </small>
                        </div>
                        <div class="form-group mx-2 mt-2">
                            <label for="state">State *</label>
                            <input id="state"
                                   class="form-control"
                                   type="text"
                                   name="state"
                                   placeholder="State"
                                   :class="{ 'border border-danger': locationErrors.stateErrorPresent }"
                                   v-model="locationsForm.state">
                            <small class="text-danger" v-if="locationErrors.stateErrorPresent">
                                {{ locationErrors.state }}
                            </small>
                        </div>
                        <div class="form-group mx-2 mt-2">
                            <label for="country">Country *</label>
                            <input id="country"
                                   class="form-control"
                                   type="text"
                                   name="country"
                                   placeholder="Country"
                                   :class="{ 'border border-danger': locationErrors.countryErrorPresent }"
                                   v-model="locationsForm.country">
                            <small class="text-danger" v-if="locationErrors.countryErrorPresent">
                                {{ locationErrors.country }}
                            </small>
                        </div>
                        <div class="form-group mx-2 mt-2">
                            <label for="zipCode">Zip code *</label>
                            <input id="zipCode"
                                   class="form-control"
                                   type="text"
                                   name="zipCode"
                                   placeholder="Zip code"
                                   :class="{ 'border border-danger': locationErrors.zipCodeErrorPresent }"
                                   v-model="locationsForm.zipCode">
                            <small class="text-danger" v-if="locationErrors.zipCodeErrorPresent">
                                {{ locationErrors.zipCode }}
                            </small>
                        </div>
                        <div class="form-group mx-2 mt-2">
                            <label for="address">Address *</label>
                            <input id="address"
                                   class="form-control"
                                   type="text"
                                   name="address"
                                   placeholder="Address"
                                   :class="{ 'border border-danger': locationErrors.addressErrorPresent }"
                                   v-model="locationsForm.address">
                            <small class="text-danger" v-if="locationErrors.addressErrorPresent">
                                {{ locationErrors.address }}
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button id="updateLocationsButton"
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
                        <button id="storeLocation"
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
                cities: [],
                locationsForm: {
                    id: "",
                    city: "",
                    state: "",
                    country: "",
                    zipCode: "",
                    address: ""
                },
                locationErrors: {
                    city: "",
                    cityErrorPresent: false,
                    state: "",
                    stateErrorPresent: false,
                    country: "",
                    countryErrorPresent: false,
                    zipCode: "",
                    zipCodeErrorPresent: false,
                    address: "",
                    addressErrorPresent: false
                }
            };
        },
        methods: {
            createLocation() {
                this.editmode = false;
                this.resetLocationErrors();
                this.resetLocationForm();
                $('#create-and-edit-modal').modal('show');
            },
            storeLocation() {
                this.resetLocationErrors();
                const formData = new FormData();
                formData.append("id", this.locationsForm.id);
                formData.append("city", this.locationsForm.city);
                formData.append("state", this.locationsForm.state);
                formData.append("country", this.locationsForm.country);
                formData.append("zip_code", this.locationsForm.zipCode);
                formData.append("address", this.locationsForm.address);

                const config = { headers: { 'content-type': 'multipart/form-data' } };
                axios.post(`${window.base_url}/admin/locations`, formData, config)
                    .then((response) => {
                        this.storeUpdateDisabled = false;
                        if(response.data[0] == "success") {
                            $("#create-and-edit-modal").modal("hide");
                            EventBus.$emit('load-locations');
                            swalSuccess("Success.");
                        }
                    }).catch(error => {
                    this.storeUpdateDisabled = false;
                    if (error.response.status === 422) {
                        this.checkForValidationErrors(error.response.data.errors);
                    }
                });
            },
            editLocation(location) {
                this.editmode = true;
                this.resetLocationForm();
                this.resetLocationErrors();
                this.fillLocationsForm(location);
                $('#create-and-edit-modal').modal("show");
            },
            updateLocation() {
                this.resetLocationErrors();
                const formData = new FormData();
                formData.append("id", this.locationsForm.id);
                formData.append("city", this.locationsForm.city);
                formData.append("state", this.locationsForm.state);
                formData.append("country", this.locationsForm.country);
                formData.append("zip_code", this.locationsForm.zipCode);
                formData.append("address", this.locationsForm.address);
                formData.append("_method", "PATCH");

                const config = { headers: { "content-type": "multipart/form-data" } };
                axios.post(`${window.base_url}/admin/locations/${this.locationsForm.id}`, formData, config)
                    .then(response => {
                        this.storeUpdateDisabled = false;
                        if(response.data[0] === "success") {
                            $("#create-and-edit-modal").modal("hide");
                            swalSuccess("Success.");
                            EventBus.$emit('load-locations');
                        }
                    }).catch(error => {
                    this.storeUpdateDisabled = false;
                    if (error.response.status === 422) {
                        this.checkForValidationErrors(error.response.data.errors);
                    }
                });
            },
            fillLocationsForm(location) {
                this.locationsForm.id = location.id;
                this.locationsForm.city = location.city;
                this.locationsForm.state = location.state;
                this.locationsForm.country = location.country;
                this.locationsForm.zipCode = location.zip_code;
                this.locationsForm.address = location.address;
            },
            resetLocationForm() {
                this.locationsForm.id = "";
                this.locationsForm.city = "";
                this.locationsForm.state = "";
                this.locationsForm.country = "";
                this.locationsForm.zipCode = "";
                this.locationsForm.address = "";
            },
            resetLocationErrors() {
                this.locationErrors.city = "";
                this.locationErrors.cityErrorPresent = false;
                this.locationErrors.state = "";
                this.locationErrors.stateErrorPresent = false;
                this.locationErrors.country = "";
                this.locationErrors.countryErrorPresent = false;
                this.locationErrors.zipCode = "";
                this.locationErrors.zipCodeErrorPresent = false;
                this.locationErrors.address = "";
                this.locationErrors.addressErrorPresent = false;
            },
            checkForValidationErrors(errors) {
                if(errors.hasOwnProperty("city")) {
                    this.locationErrors.city = errors["city"][0];
                    this.locationErrors.cityErrorPresent = true;
                }
                if(errors.hasOwnProperty("state")) {
                    this.locationErrors.state = errors["state"][0];
                    this.locationErrors.stateErrorPresent = true;
                }
                if(errors.hasOwnProperty("country")) {
                    this.locationErrors.country = errors["country"][0];
                    this.locationErrors.countryErrorPresent = true;
                }
                if(errors.hasOwnProperty("zip_code")) {
                    this.locationErrors.zipCode = errors["zip_code"][0];
                    this.locationErrors.zipCodeErrorPresent = true;
                }
                if(errors.hasOwnProperty("address")) {
                    this.locationErrors.address = errors["address"][0];
                    this.locationErrors.addressErrorPresent = true;
                }
            },
        },
        mounted() {
            EventBus.$on('open-create-modal', () => this.createLocation());
            EventBus.$on('open-edit-modal', location => this.editLocation(location));
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
