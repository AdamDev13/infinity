<template>
    <form class="space-y-8 divide-y divide-gray-200" @submit.prevent="onSubmit">
        <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">

            <div class="space-y-6 sm:space-y-5">
                <div class="space-y-6 sm:space-y-5">

                    <!-- Current Password -->

                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="password" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Current Password
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2" >
                            <input v-model="formData.current_password" type="password" name="password" id="password"
                                   class="w-full block max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"/>
                            <span class="text-danger-dark " v-for="error in v$.current_password.$errors"
                                  :key="error.$uid"> {{ error.$message }} </span>
                        </div>
                    </div>

                    <!-- New Password -->

                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="password" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            New Password
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <input v-model="formData.password" type="password" name="password" id="password"
                                   class="w-full block max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"/>
                            <span class="text-danger-dark " v-for="error in v$.password.$errors"
                                  :key="error.$uid"> {{ error.$message }} </span>
                            <span class="text-danger-dark block "
                                  v-if="formData.password && v$.password.containsUppercase.$invalid">Password contains atleast One Uppercase</span>
                            <span class="text-danger-dark block "
                                  v-if="formData.password && v$.password.containsLowercase.$invalid">Password contains atleast One Lowercase</span>
                            <span class="text-danger-dark block "
                                  v-if="formData.password && v$.password.containsNumber.$invalid">Password contains One Number</span>
                            <span class="text-danger-dark block "
                                  v-if="formData.password && v$.password.containsSpecial.$invalid">Password contains atleast One Special Charter</span>
                            <span class="text-danger-dark block " v-if="formData.password && !v$.password.minLength">Password must be minimum 9 characters</span>
                            <span class="text-danger-dark block " v-if="formData.password && !v$.password.maxLength">Password must be maximum 19 characters</span>
                        </div>
                    </div>

                    <!-- Confirm Password -->

                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="confirm" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Confirm Password
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <input v-model="formData.confirmPassword"  type="password" name="confirm" id="confirm"
                                   class="w-full block max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"/>
                            <span class="text-danger-dark " v-for="error in v$.confirmPassword.$errors"
                                  :key="error.$uid"> {{ error.$message }} </span>
                            <span class="text-danger-dark block "
                                  v-if="formData.password && v$.confirmPassword.sameAsPassword.$invalid">Confirm Password and Password should be same</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <button type="submit"
                        class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update Password
                </button>
            </div>
        </div>
    </form>
</template>
<script>
import useVuelidate from '@vuelidate/core'
import {required, email, minLength, sameAs, maxLength} from '@vuelidate/validators'
import {useProfileStore} from "../store/profile";
import {reactive} from "vue";

export default {
    setup() {
        const store = useProfileStore();
        const formData = reactive({
            current_password: "",
            password: "",
            confirmPassword: "",
        });

        const rules = {
            current_password: {required},
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
                minLength: minLength(8),
                maxLength: maxLength(19),
            },
            confirmPassword: {
                required,
                sameAsPassword: function (value) {
                    return value.toString() === this.formData.password;
                }
            }
        }
        const v$ = useVuelidate(rules, formData);

        return {
            store,
            v$,
            formData,
            rules
        }
    },
    data() {
        return {
            current_password: "",
            password: "",
            confirmPassword: "",
        }
    },
    methods: {
        async onSubmit() {
             const validated = await this.v$.$validate();
             if (validated){
                await this.store.resetPassword(this.formData);
             }
        }
    }
}

</script>
