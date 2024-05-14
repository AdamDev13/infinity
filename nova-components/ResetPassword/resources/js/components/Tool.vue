<template>
    <loading-view :loading="loading">
        <heading class="mb-3">{{__("Reset Password")}}</heading>
        <p style="margin-bottom:5px; color:rgba(255,0,0,.7)">*New password must include 8 characters, including 1 number &amp; 1 special character.</p>

        <card class="overflow-hidden">
            <form @submit.prevent="saveProfile">
                <!-- Validation Errors -->
                <validation-errors :errors="validationErrors"/>

                <!-- Fields -->
                <div v-for="field in fields">
                    <component
                        :is="'form-' + field.component"
                        :errors="validationErrors"
                        :resource-name="resourceName"
                        :field="field"
                        :via-resource="viaResource"
                        :via-resource-id="viaResourceId"
                        :via-relationship="viaRelationship"
                    />
                </div>

                <!-- Create Button -->
                <div class="bg-30 flex px-8 py-4">
                    <button dusk="create-and-add-another-button" class="ml-auto btn btn-default btn-primary mr-3">
                        {{__('Reset Password')}}
                    </button>
                </div>
            </form>
        </card>
    </loading-view>
</template>

<script>
    import { Errors, Minimum } from 'laravel-nova'

    export default {

        data: () => ({
            loading: true,
            fields: [],
            validationErrors: new Errors(),
        }),

        created() {
            this.getFields()
        },

        methods: {
            /**
             * Get the available fields for the resource.
             */
            async getFields() {
                this.fields = []
                const { data: fields } = await Nova.request().get(
                    '/nova-vendor/ugduck/reset-password'
                )
                this.fields = fields
                this.loading = false
            },

            /**
             * Saves the user's profile
             */
            async saveProfile() {
                try {
                    this.loading = true
                    const response = await this.createRequest()
                    this.loading = false
                    this.$toasted.show(
//                        this.__('Your profile has been saved@!'),
                        this.__(response.data.message),
                        { type: 'success' }
                    ).goAway(2500);
                    // Reset the form by refetching the fields
                    this.getFields()
                } catch (error) {
                    this.loading = false
                    if (error.response.status == 422) {
                        this.$toasted.show(
                            this.__(error.response.data.message),
                            { type: 'error' }
                        ).goAway(2500)
/*
                        for (const key in error.response.data) {
                        console.log(`${key}: ${error.response.data[key]}`);
                        alert(key);
                            errorMsg += error.response.data[key] ;
                        }

                        console.log(error.response.data);
                        error.response.data.forEach(function(element) {
                            console.log(element);
                        });
*/
                    }
                }
            },
            
            /**
             * Send a create request to update the user's profile data
             */
            createRequest() {
                return Nova.request().post(
                    '/nova-vendor/ugduck/reset-password',
                    this.createResourceFormData()
                )
            },

            /**
             * Create the form data for creating the resource.
             */
            createResourceFormData() {
                return _.tap(new FormData(), formData => {
                    _.each(this.fields, field => {
                        field.fill(formData)
                    })
                })
            },
        },
    }
</script>
