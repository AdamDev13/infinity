<template>
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="text-center text-3xl font-extrabold text-gray-900">
                Reset Password
            </h2>
            <!--            <p class="mt-2 text-center text-sm text-gray-600">-->
            <!--                Or-->
            <!--                {{ ' ' }}-->
            <!--                <a href="/create-account" class="font-medium text-blue-600 hover:text-blue-500">-->
            <!--                    create an account-->
            <!--                </a>-->
            <!--            </p>-->
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form class="space-y-6" @submit.prevent="onSubmit" method="POST">
<!--                    <div>-->
<!--                        <label for="email" class="block text-sm font-medium text-gray-700">-->
<!--                            Email address-->
<!--                        </label>-->
<!--                        <div class="mt-1">-->
<!--                            <input id="email" v-model="auth.email" type="email"-->

<!--                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"/>-->
<!--                            <span class="text-danger-dark " v-for="error in v$.email.$errors"-->
<!--                                  :key="error.$uid"> {{ error.$message }} </span>-->
<!--                        </div>-->
<!--                    </div>-->

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            New Password
                        </label>
                        <div class="mt-1">
                            <input id="password" v-model="auth.password" type="password"

                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"/>
                            <span class="text-danger-dark block" v-for="error in v$.password.$errors"
                                  :key="error.$uid"> {{ error.$message }} </span>
                            <span class="text-danger-dark block "
                                  v-if="auth.password && v$.password.containsUppercase.$invalid">Password contains atleast One Uppercase</span>
                            <span class="text-danger-dark block "
                                  v-if="auth.password && v$.password.containsLowercase.$invalid">Password contains atleast One Lowercase</span>
                            <span class="text-danger-dark block "
                                  v-if="auth.password && v$.password.containsNumber.$invalid">Password contains One Number</span>
                            <span class="text-danger-dark block "
                                  v-if="auth.password && v$.password.containsSpecial.$invalid">Password contains atleast One Special Charter</span>
                            <span class="text-danger-dark block " v-if="auth.password && !v$.password.minLength">Password must be minimum 9 characters</span>
                            <span class="text-danger-dark block " v-if="auth.password && !v$.password.maxLength">Password must be maximum 19 characters</span>
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Confirm Password
                        </label>
                        <div class="mt-1">
                            <input id="password" v-model="auth.password_confirmation" type="password"

                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"/>
                            <span class="text-danger-dark block" v-for="error in v$.password_confirmation.$errors"
                                  :key="error.$uid"> {{ error.$message }} </span>
                            <span class="text-danger-dark block "
                                  v-if="auth.password && v$.password_confirmation.sameAsPassword.$invalid">Confirm Password and Password should be same</span>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">

                            {{ processing ? "Please wait" : "Reset Password" }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</template>
<script>
import {reactive} from "vue";
import {maxLength, minLength, required, email, sameAs} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import {useRoute} from 'vue-router'


export default {
    name: "ForgotPassword",
    setup() {
        const route = useRoute();

        const auth = reactive({
            token: route.params.token,
            email: route.params.email,
            password: "",
            password_confirmation: "",

        });
        const rules = {
            email: {
                required,
                email
            },
            password: {
                required,
                containsUppercase: function (value) {
                    return /[A-Z]/.test(value)
                },
                containsLowercase: function (value) {
                    return /[a-z]/.test(value)
                },
                containsNumber: function (value) {
                    return /[0-9]/.test(value)
                },
                containsSpecial: function (value) {
                    return /[#?!@$%^&*-]/.test(value)
                },
                minLength: minLength(9),
                maxLength: maxLength(19),
            },
            password_confirmation: {
                required,
                sameAsPassword: function (value) {
                    return value.toString() === this.auth.password;
                }
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
            processing: false
        }
    }
    ,
    methods: {
        async onSubmit() {
            const validated = await this.v$.$validate();
            if (validated) {
                this.processing = true
                await axios.post('/reset/password', this.auth).then(({data}) => {
                    this.$router.push({name: 'login'})
                }).catch(({response: {data}}) => {
                    console.error(data);
                }).finally(() => {
                    this.processing = false
                })

            }
        }
        ,
    }
}
</script>
