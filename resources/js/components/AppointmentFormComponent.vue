<template>
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <form class="mt-3">
                    <h1 class="text-center">Appointment Form</h1>
                    <div class="row">
                        <div class="col-md-12">
                            <ul>
                                <li class="errors" v-for="error in errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3 form-group">
                                <label for="appointmentName" class="form-label">Full Name:</label>
                                <input type="text" class="form-control" v-model="appointmentName" id="appointmentName"
                                       placeholder="Example: John Doe">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <label for="appointmentEmail" class="form-label">Email address:</label>
                                <input type="text" class="form-control" v-model="appointmentEmail" id="appointmentEmail"
                                       placeholder="Example: john@doe.com">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <label for="appointmentPhone" class="form-label">Phone:</label>
                                <input type="text" class="form-control" v-mask="'+9#-###-###-##-##'"
                                       v-model="appointmentPhone" id="appointmentPhone"
                                       placeholder="Example:+90-555-555-55-55">
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-left: 10px;">
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <input id="appointmentNotificationSms" type="radio" class="form-check-input" v-bind:value="0" v-model="notification_types">
                                <label class="form-check-label" for="appointmentNotificationSms">Sms</label>
                            </div>
                        </div>
                        <div class="col-md-6" style="padding-left:20px;">
                            <div class="mb-3 form-group">
                                <input id="appointmentNotificationEmail" type="radio" class="form-check-input" v-bind:value="1" v-model="notification_types">
                                <label for="appointmentNotificationEmail" class="form-check-label">Email</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="appointmentNote" class="form-label">Appointment Note:</label>
                                <textarea cols="30" rows="5" v-model="appointmentNote" class="form-control"
                                          id="appointmentNote"
                                          placeholder="Please write note...(Not Required)"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="appointmentDate" class="form-label">Date:</label>
                        <input type="date" class="form-control" @change="selectDate" v-model="appointmentDate"
                               id="appointmentDate">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="appointmentWorkingTime"> Appointment Time: </label>
                        <ul class="select-time-ul">
                            <li v-for="item in workingHours" class="select-time">
                                <input v-if="item.isActive" id="appointmentWorkingTime" type="radio" v-model="appointmentWorkingTime"
                                       v-bind:value="item.id">
                                <span>{{ item.hours }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" v-on:click="store" class="btn btn-success">Make an Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            errors: [],
            notification_types: null,
            appointmentWorkingTime: 0,
            appointmentName: null,
            appointmentEmail: null,
            appointmentPhone: null,
            appointmentDate: new Date().toISOString().slice(0, 10),
            appointmentNote: null,
            workingHours: []
        }
    },
    name: "AppointmentFormComponent",
    methods: {
        store: function () {
            if (this.appointmentName &&
                this.appointmentEmail &&
                this.validEmail(this.appointmentEmail) &&
                this.appointmentPhone &&
                this.appointmentWorkingTime !== 0 &&
                this.notification_types ) {
                axios.post(`http://hospital.test/api/appointment`,{
                    appointmentName: this.appointmentName,
                    appointmentEmail: this.appointmentEmail,
                    appointmentPhone: this.appointmentPhone,
                    appointmentDate: this.appointmentDate,
                    appointmentNote: this.appointmentNote,
                    appointmentWorkingTime: this.appointmentWorkingTime,
                    notification_types: this.notification_types
                }).then(response=>{
                    console.log(response);
                });
            }

            this.errors = [];

            if (!this.appointmentName) {
                this.errors.push('Please fill the Full Name area');
            }
            if (!this.appointmentEmail) {
                this.errors.push('Please fill the Email area');
            }
            if (!this.appointmentPhone) {
                this.errors.push('Please fill the Phone area');
            }
            if (!this.appointmentWorkingTime) {
                this.errors.push('Please select a Appointment Time');
            }
            if (!this.validEmail(this.appointmentEmail)) {
                this.errors.push('Please enter valid email');
            }
            if (!this.notification_types)
            {
                this.errors.push('Please select a notification type');
            }
        },

        selectDate: function () {
            axios.get(`http://hospital.test/api/working-hours/${this.appointmentDate}`)
                .then((response) => {
                    this.workingHours = response.data;
                });
        },

        validEmail: function (email) {
            const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
    },
    mounted() {
        axios.get('http://hospital.test/api/working-hours')
            .then((response) => {
                this.workingHours = response.data;
            });
    }
}
</script>

<style scoped>

</style>
