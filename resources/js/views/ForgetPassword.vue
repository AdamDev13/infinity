<template>
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="text-center text-3xl font-extrabold text-gray-900">
                Forgot Password
            </h2>
                        <p class="mt-2 text-center text-sm text-gray-600">
                            Or
                            {{ ' ' }}
                            <a href="/login" class="font-medium text-blue-600 hover:text-blue-500">
                                sign in
                            </a>
                        </p>
        </div>

        <div v-if="!isEmailSent" class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form class="space-y-6" @submit.prevent="onSubmit" method="POST">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email address
                        </label>
                        <div class="mt-1">
                            <input id="email" v-model="auth.email"  type="email"

                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"/>
                            <span class="text-danger-dark " v-for="error in v$.email.$errors"
                                  :key="error.$uid"> {{ error.$message }} </span>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">

                            {{ processing ? "Please wait" : "Submit" }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
        <div v-else class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <p>An email containing a reset password link has been sent. Please click on the link to set a new password.</p>
            </div>
        </div>
    </div>
</template>
<script>
import {reactive} from "vue";
import {maxLength, minLength, required, email} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";

export default {
    name: "ForgotPassword",
    setup() {
        const auth = reactive({
            email: ""
        });
        const rules = {
            email: {
                required,
                email
            }
        };
        const v$ = useVuelidate(rules, auth);
        return {
            auth,
            rules,
            v$
        };
    },
    data() {
        return {
            processing: false,
            isEmailSent:false
        }
    },
    methods: {
        async onSubmit() {
            const validated = await this.v$.$validate();
            if (validated) {
                this.processing = true;
                let self = this;
                await axios.get('/sanctum/csrf-cookie')
                await axios.post('/forgot-password', this.auth).then(({data}) => {
                    self.isEmailSent = true;
                }).catch(({response}) => {
                    self.isEmailSent = false;
                    console.log(response);
                }).finally(() => {
                    this.processing = false

                })

            }
        },
    }
}
</script>
