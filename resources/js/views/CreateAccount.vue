<template>
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="text-center text-3xl font-extrabold text-gray-900">
                Create an account
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Or
                {{ ' ' }}
                <a href="/login" class="font-medium text-blue-600 hover:text-blue-500">
                    sign in
                </a>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-3xl">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form class="space-y-6 md:space-y-0 gap-8 md:grid md:grid-cols-6" @submit.prevent="onSubmit">

                    <div class="col-span-6">
                        <label for="company" class="block text-sm font-medium text-gray-700">
                            Company Name
                        </label>
                        <div class="mt-1">
                            <input id="company" v-model="formData.company_name" name="company_name" type="test"
                                   autocomplete="company"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"/>
                            <span class="text-danger-dark " v-for="error in v$.company_name.$errors"
                                  :key="error.$uid"> {{ error.$message }} </span>
                        </div>
                    </div>

                    <div class="col-span-3">
                        <label for="firstname" class="block text-sm font-medium text-gray-700">
                            First Name
                        </label>
                        <div class="mt-1">
                            <input id="firstname" name="firstname" v-model="formData.first_name" type="test"
                                   autocomplete="firstname"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"/>
                            <span class="text-danger-dark " v-for="error in v$.first_name.$errors"
                                  :key="error.$uid"> {{ error.$message }} </span>
                        </div>
                    </div>

                    <div class="col-span-3">
                        <label for="lastname" class="block text-sm font-medium text-gray-700">
                            Last Name
                        </label>
                        <div class="mt-1">
                            <input id="lastname" name="lastname" v-model="formData.last_name" type="text"
                                   autocomplete="lastname"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"/>
                            <span class="text-danger-dark " v-for="error in v$.last_name.$errors"
                                  :key="error.$uid"> {{ error.$message }} </span>
                        </div>
                    </div>

                    <!-- Address -->

                    <div class="col-span-6">
                        <label for="street-address" class="block text-sm font-medium text-gray-700">
                            Address
                        </label>
                        <div class="mt-1">
                            <input type="text" name="street-address" v-model="formData.address" id="street-address"
                                   autocomplete="street-address"
                                   class="block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md"/>
                            <span class="text-danger-dark " v-for="error in v$.address.$errors"
                                  :key="error.$uid"> {{ error.$message }} </span>
                        </div>
                    </div>

                    <!-- Address Two -->

                    <div class="col-span-6">
                        <label for="street-address-two" class="block text-sm font-medium text-gray-700">
                            Address Continued
                        </label>
                        <div class="mt-1">
                            <input type="text" name="street-address-two" v-model="formData.address_continued"
                                   id="street-address-two" autocomplete="street-address-two"
                                   class="block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md"/>
                            <!--              <span class="text-danger-dark " v-for="error in v$.address_continued.$errors"-->
                            <!--                      :key="error.$uid"> {{ error.$message }} </span>-->
                        </div>
                    </div>

                    <!-- City -->

                    <div class="col-span-2">
                        <label for="city" class="block text-sm font-medium text-gray-700">
                            City
                        </label>
                        <div class="mt-1">
                            <input type="text" name="city" id="city" v-model="formData.city"
                                   class="w-full block max-w-lg block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md"/>
                            <span class="text-danger-dark " v-for="error in v$.city.$errors"
                                  :key="error.$uid"> {{ error.$message }} </span>
                        </div>
                    </div>

                    <!-- State -->

                    <div class="col-span-2">
                        <label for="country" class="block text-sm font-medium text-gray-700">
                            State
                        </label>
                        <div class="mt-1">
                            <select id="country" name="state" v-model="formData.state" autocomplete="state"
                                    class="max-w-lg block focus:ring-blue-500 focus:border-blue-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="">Select State</option>
                                <option
                                    v-for="(state, id) in states"
                                    :value="id"
                                    :key="id">
                                    {{ state }}
                                </option>
                            </select>
                            <span class="text-danger-dark " v-for="error in v$.state.$errors"
                                  :key="error.$uid"> {{ error.$message }} </span>
                        </div>
                    </div>

                    <!-- Zip -->

                    <div class="col-span-2">
                        <label for="zip" class="block text-sm font-medium text-gray-700">
                            ZIP / Postal
                        </label>
                        <div class="mt-1">
                            <input type="text" name="zip" id="zip" v-model="formData.postal" autocomplete="postal-code"
                                   class="w-full block max-w-lg block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md"/>
                            <span class="text-danger-dark " v-for="error in v$.postal.$errors"
                                  :key="error.$uid"> {{ error.$message }} </span>
                        </div>
                    </div>

                    <div class="col-span-6">
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email address
                        </label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" v-model="formData.email" autocomplete="email"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"/>
                            <span class="text-danger-dark " v-for="error in v$.email.$errors"
                                  :key="error.$uid"> {{ error.$message }} </span>
                        </div>
                    </div>

                    <div class="col-span-6">
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Password
                        </label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" v-model="formData.password"
                                   autocomplete="current-password"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"/>
                            <span class="text-danger-dark block " v-for="error in v$.password.$errors"
                                  :key="error.$uid"> {{ error.$message }} </span>
                            <span class="text-danger-dark block " v-if="formData.password && v$.password.containsUppercase.$invalid">Password contains atleast One Uppercase</span>
                            <span class="text-danger-dark block " v-if="formData.password && v$.password.containsLowercase.$invalid">Password contains atleast One Lowercase</span>
                            <span class="text-danger-dark block " v-if="formData.password && v$.password.containsNumber.$invalid">Password contains One Number</span>
                            <span class="text-danger-dark block " v-if="formData.password && v$.password.containsSpecial.$invalid">Password contains atleast One Special Charter</span>
                            <span class="text-danger-dark block " v-if="formData.password && !v$.password.minLength">Password must be minimum 9 characters</span>
                            <span class="text-danger-dark block " v-if="formData.password && !v$.password.maxLength">Password must be maximum 19 characters</span>
                        </div>
                    </div>

                    <div class="col-span-6">
                        <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ processing ? "Please wait" : "Create Account" }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</template>
<script>

import {mapActions} from 'vuex'
import {reactive} from "vue";
import {maxLength, minLength, required,email} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import axios from "axios";

export default {
    name: "createAccount",
    setup() {
        const formData = reactive({
            company_name: "",
            first_name: "",
            last_name: "",
            address: "",
            address_continued: "",
            city: "",
            state: "",
            postal: "",
            email: "",
            password: "",
        });

        const rules = {
            password: {
                required,
                containsUppercase: function(value) {
                    return /[A-Z]/.test(value)
                },
                containsLowercase: function(value) {
                    return /[a-z]/.test(value)
                },
                containsNumber: function(value) {
                    return /[0-9]/.test(value)
                },
                containsSpecial: function(value) {
                    return /[#?!@$%^&*-]/.test(value)
                },
                minLength: minLength(9),
                maxLength: maxLength(19),
            },
            company_name: {required},
            first_name: {required},
            last_name: {required},
            address: {required},
            city: {required},
            state: {required},
            postal: {required},
            email: {required,email}
        }

        const v$ = useVuelidate(rules, formData);

        return {
            v$,
            formData,
            rules
        }
    },
    data() {
        return {
            company_name: "",
            first_name: "",
            last_name: "",
            address: "",
            address_continued: "",
            city: "",
            state: "",
            postal: "",
            email: "",
            password: "",
            processing: false,
            states:this.$store.state.states
        }
    },
    created() {
      this.getStates();
    },
    methods: {
        ...mapActions({
            signIn: 'auth/login',
        }),
        async onSubmit() {
            const validated = await this.v$.$validate();
            if (validated) {
                this.processing = true
                await axios.get('/sanctum/csrf-cookie')
                await axios.post('register', this.formData).then(({data}) => {
                    this.$axios.defaults.headers.common['Authorization'] = `${data.token_type} ${data.access_token}`
                    this.signIn()
                }).catch(({response: {data}}) => {

                }).finally(() => {
                    this.processing = false
                })
            }
        },
        async getStates(){
            await axios.get('states').then(({data})=>{
              this.states = data;
            }).catch((response)=>{
                console.log(response)
            })
        }
    },
    computed:{

    }


}

</script>
