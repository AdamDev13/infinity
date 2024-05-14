<template>
    <form class="space-y-8 divide-y divide-gray-200" @submit.prevent="onSubmit">

        <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
            <!--            <p-->
            <!--                v-for="error of v$.$errors"-->
            <!--                :key="error.$uid"-->
            <!--            >-->
            <!--                <strong>{{ error.$validator }}</strong>-->
            <!--                <small> on property</small>-->
            <!--                <strong>{{ error.$property }}</strong>-->
            <!--                <small> says:</small>-->
            <!--                <strong>{{ error.$message }}</strong>-->
            <!--            </p>-->
            <div class="space-y-6 sm:space-y-5">
                <div class="space-y-6 sm:space-y-5">

                    <!-- First Name -->

                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="company-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Company Name
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <input type="text" v-model="formData.company_name" name="company-name" id="company-name"
                                   class="w-full block max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"/>
                                                        <span class="text-danger-dark block" v-for="error in v$.company_name.$errors"
                                                              :key="error.$uid"> {{ error.$message }} </span>
                        </div>
                    </div>

                    <!-- First Name -->

                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="first-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            First Name
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <input type="text" v-model="formData.first_name" name="first-name" id="first-name"
                                   class="w-full block max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"/>
                            <span class="text-danger-dark block" v-for="error in v$.first_name.$errors"
                                  :key="error.$uid"> {{ error.$message }} </span>
                        </div>
                    </div>

                    <!-- Last Name -->

                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="last-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Last Name
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <input type="text" v-model="formData.last_name" name="last-name" id="last-name"
                                   class="w-full block max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"/>
                         <span class="text-danger-dark block" v-for="error in v$.last_name.$errors"
                                                              :key="error.$uid"> {{ error.$message }} </span>
                        </div>
                    </div>

                    <!-- Email Address -->

                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="email" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Email Address
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <input id="email" v-model="formData.email" name="email" type="email" autocomplete="email"
                                   class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"/>
                         <span class="text-danger-dark block" v-for="error in v$.email.$errors"
                                                              :key="error.$uid"> {{ error.$message }} </span>
                        </div>
                    </div>

                    <!-- Phone Number -->

                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="phone-number" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Phone Number
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2 block max-w-lg w-full">
<!--                            <vue-tel-input  v-mask="'(___) ___ ____'" v-model="formData.phone_number" placeholder="Enter a phone number" ></vue-tel-input>-->
                            <input type="text" ref="input"  key="phone-number" v-mask="'(___) ___ ____'" v-model="formData.phone_number" name="phone-number" id="phone-number"
                                   class="w-full block max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"/>
<!--                            <small class="block text-gray-400">format +1 ### ### #### or +1 #########</small>-->
                            <span class="text-danger-dark block" v-for="error in v$.phone_number.$errors"
                                                              :key="error.$uid"> {{ error.$message }} </span>
                        </div>
                    </div>

                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="phone-number" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Fax Number
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <input type="text" ref="input" key="fax-number" v-mask="'(___) ___ ____'" v-model="formData.fax_number" name="fax-number" id="fax-number"
                                   class="w-full block max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"/>
<!--                            <small class="block text-gray-400">format +1 ### ### #### or +1 #########</small>-->
                            <span class="text-danger-dark block" v-for="error in v$.fax_number.$errors"
                                  :key="error.$uid"> {{ error.$message }} </span>
                        </div>
                    </div>

                    <!-- Address -->

                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="street-address" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Address
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <input type="text" v-model="formData.address" name="street-address" id="street-address"
                                   autocomplete="street-address"

                                   class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"/>
                            <span class="text-danger-dark block" v-for="error in v$.address.$errors"
                                  :key="error.$uid"> {{ error.$message }} </span>
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="street-address" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Address Continued
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <input type="text" v-model="formData.address_continued" name="street-address"
                                   id="street-address2" autocomplete="street-address"

                                   class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"/>
                            <span class="text-danger-dark block" v-for="error in v$.address_continued.$errors"
                                  :key="error.$uid"> {{ error.$message }} </span>
                        </div>
                    </div>

                    <!-- City -->

                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="city" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            City
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <input type="text" v-model="formData.city" name="city" id="city"
                                   class="w-full block max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"/>
                         <span class="text-danger-dark block" v-for="error in v$.city.$errors"
                                                              :key="error.$uid"> {{ error.$message }} </span>
                        </div>
                    </div>

                    <!-- State -->

                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="country" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            State
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <select id="country" v-model="formData.state"  name="country" autocomplete="country"
                                    class="max-w-lg block focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="">Select State</option>
                                <option
                                    v-for="(state, id) in states"
                                    :value="id"
                                    :key="id">
                                    {{ state }}
                                </option>
                            </select>
                            <span class="text-danger-dark block" v-for="error in v$.state.$errors"
                                  :key="error.$uid"> {{ error.$message }} </span>
                        </div>
                    </div>


<!--                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">-->
<!--                        <label for="country" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">-->
<!--                            County-->
<!--                        </label>-->
<!--                        <div class="mt-1 sm:mt-0 sm:col-span-2">-->
<!--                            <select id="country" v-model="formData.county" name="country" autocomplete="country"-->
<!--                                    class="max-w-lg block focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md">-->
<!--                                <option value="">Select County</option>-->
<!--                                <option-->
<!--                                    v-for="(county, id) in counties"-->
<!--                                    :value="id"-->
<!--                                    :key="id">-->
<!--                                    {{ county }}-->
<!--                                </option>-->
<!--                            </select>-->
<!--                            <span class="text-danger-dark block" v-for="error in v$.county.$errors"-->
<!--                                  :key="error.$uid"> {{ error.$message }} </span>-->
<!--                        </div>-->
<!--                    </div>-->

                    <!-- Zip -->

                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="zip" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            ZIP / Postal
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <input v-model="formData.postal" type="text" name="zip" id="zip" autocomplete="postal-code"
                                   class="w-full block max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"/>
                         <span class="text-danger-dark block" v-for="error in v$.postal.$errors"
                                                              :key="error.$uid"> {{ error.$message }} </span>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <button type="submit"
                        class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Profile
                </button>
            </div>
        </div>
    </form>
</template>
<script>
import useVuelidate from '@vuelidate/core'
import {required, email, minLength, helpers, alphaNum, requiredIf} from '@vuelidate/validators'
import {useProfileStore} from "../store/profile";
import {reactive,computed} from "vue";
import axios from 'axios'
import { VueTelInput } from 'vue-tel-input';
import 'vue-tel-input/dist/vue-tel-input.css';

export default {
    components:{
        VueTelInput
    },
    setup() {
        const store = useProfileStore();
        let user = computed(function (){
            return store.user;
        });
        const formData = reactive(user);

        // const phoneNumber = helpers.regex(/^([0-9]{3}[.\-\s]?){2}[0-9]{4}$/);
        // const phoneNumber = helpers.regex(/^(\([0-9]{3}\) |[0-9]{3}-)[0-9]{3} |[0-9]{4}$/);


        const rules = {
            first_name: {
                required
            },
            last_name: {
                required
            },
            email: {
                required
                , email
            },
            company_name: {
                required
            },
            postal: {
                required
            },
            address: {
                required,
            },
            phone_number: {
                required,
                phoneNumber: helpers.withMessage('Phone Number format is incorrect correct format (###) ### ####', function (value){
                    value = value.replace(/[^0-9_]/gm, '');
                    return /^(\([0-9]{3}\) |[0-9]{3}-)[0-9]{3} |[0-9]{4}$/.test(value);
                })
            },
            fax_number: {
                phoneNumber: helpers.withMessage('Fax Number format is incorrect, its should match (###) ### ####', function (value){
                    if (value === null){
                        return true;
                    }else if (value.replace(/[^0-9]/gm, '') === ""){
                        return true;
                    }else {
                       value = value.replace(/[^0-9_]/gm, '');
                       return /^(\([0-9]{3}\) |[0-9]{3}-)[0-9]{3} |[0-9]{4}$/.test(value);
                    }

                })
            },
            state: {
                required
            },
            // county: {
            //     requiredIfFuction: requiredIf(function (value) {
            //         return this.formData.state !== "";
            //     })
            // },
            city: {
                required
            },
            address_continued: {
            },

        };
        const v$ = useVuelidate(rules, formData);
        return {
            v$,
            formData,
            store
        };
    },
    created() {
        this.store.fetchProfile();
    },
    data() {
        return {
          counties:[]
        };

    },
    computed: {
        user() {
            return this.store.user;
        },
        states() {
            return this.store.states;
        },
        county() {
            this.counties = this.store.county;
            // return this.store.county;
        },
        route() {
            return this.store.route;
        }
    },
    methods: {
        async onSubmit() {
            const validated = await this.v$.$validate();
            if (validated) {
                await this.store.UpdateProfile(this.formData);
            }
        },
        async getCounty(state){
            await axios.get('project/state/'+state+'/county').then((response) => {
                this.counties = response.data.counties;
            }).catch((e)=>{
                console.log(e.message);
            });
        },
        handleStateChange(event){
            let state = event.target.value;
            if (state !== "") {
                this.getCounty(state);
            } else {
                this.counties = [];
            }
            this.formData.county = "";
        },
        onUpdate(payload){

        }

    }

}

</script>
