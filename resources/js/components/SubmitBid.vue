<template>
    <div class="flex flex-col mb-12">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">

                    <div
                        class="px-4 py-6 sm:px-6 flex justify-between items-center bg-gray-50 border-b border-gray-200">
                        <div>
                            <h3 class="text-xl md:text-2xl leading-6 font-semibold text-gray-900 tracking-tight mt-1">
                                Submit Bid
                            </h3>
                        </div>
                    </div>


                    <div class="min-w-full p-6">
                        <form class="space-y-8 divide-y divide-gray-200" @submit.prevent="onSubmit"
                              enctype="multipart/form-data">
                            <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
                                <div>
                                    <div class="pb-5">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900">Bid Information</h3>
                                    </div>

                                    <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                                        <div
                                            class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                            <label for="cover-photo"
                                                   class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                File Upload </label>
                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <DragAndDrop  @handleFileUpload="handleDragAndDropFileUpload"/>
                                                <span class="text-danger-dark" v-for="error in v$.file.$errors"
                                                      :key="error.$uid"> {{ error.$message }} </span>
                                            </div>



                                        </div>

                                    </div>
                                </div>

                                <div class="pt-8 space-y-6 sm:pt-10 sm:space-y-5">
                                    <div class="pb-5">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900">Price</h3>
                                    </div>

                                    <div class="space-y-6 sm:space-y-5">

                                        <div v-if="!this.category1">
                                            <div
                                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                                <label for="base-price"
                                                       class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                    Base Price </label>
                                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                    <input v-model="formData.base_price" min="1" step=".01"
                                                           type="number"
                                                           name="base-price"
                                                           id="base-price" autocomplete="given-name"
                                                           class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                                                    <span class="text-danger-dark"
                                                          v-for="error in v$.base_price.$errors"
                                                          :key="error.$uid"> {{ error.$message }} </span>
                                                </div>
                                            </div>

                                            <div
                                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                                <label for="contingency"
                                                       class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                    Contingency Fee </label>
                                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                    <input v-model="formData.contingency_fee" min="0" step=".01"
                                                           type="number"
                                                           name="contingency" id="contingency"
                                                           autocomplete="contingency"
                                                           class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                                                    <span class="text-danger-dark"
                                                          v-for="error in v$.contingency_fee.$errors"
                                                          :key="error.$uid"> {{ error.$message }} </span>
                                                </div>
                                            </div>

                                        </div>
                                        <div v-else>
                                            <div
                                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                                <label for="base-price"
                                                       class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                    Monthly Cost </label>
                                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                    <input v-model="formData.monthly_cost" min="1" step=".01"
                                                           type="number"
                                                           name="monthly_cost"
                                                           id="monthly_cost" autocomplete="given-name"
                                                           class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                                                    <span class="text-danger-dark"
                                                          v-for="error in v$.monthly_cost.$errors"
                                                          :key="error.$uid"> {{ error.$message }} </span>
                                                </div>
                                            </div>

                                            <div
                                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                                <label for="base-price"
                                                       class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                    Term of Contract (Month) </label>
                                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                    <input v-model="formData.term_of_contract_month" min="0"
                                                           type="number"
                                                           name="base-term_of_contract_month"
                                                           id="term_of_contract_month" autocomplete="given-name"
                                                           class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                                                    <span class="text-danger-dark"
                                                          v-for="error in v$.term_of_contract_month.$errors"
                                                          :key="error.$uid"> {{ error.$message }} </span>
                                                </div>
                                            </div>

                                            <div
                                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                                <label for="base-price"
                                                       class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                    Monthly Tax Cost </label>
                                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                    <input v-model="formData.monthly_tax_cost" min="0" step=".01"
                                                           type="number"
                                                           name="monthly_tax_cost"
                                                           id="monthly_tax_cost" autocomplete="given-name"
                                                           class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                                                    <span class="text-danger-dark"
                                                          v-for="error in v$.monthly_tax_cost.$errors"
                                                          :key="error.$uid"> {{ error.$message }} </span>
                                                </div>
                                            </div>

                                            <div
                                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                                <label for="base-price"
                                                       class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                    Non Recurring Cost
                                                    <small>Installation, Construction, special construction, other
                                                        non-recurring costs</small>
                                                </label>
                                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                    <input v-model="formData.non_recurring_cost" min="0" step=".01"
                                                           type="number"
                                                           name="non_recurring_cost"
                                                           id="non_recurring_cost" autocomplete="given-name"
                                                           class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                                                    <span class="text-danger-dark"
                                                          v-for="error in v$.non_recurring_cost.$errors"
                                                          :key="error.$uid"> {{ error.$message }} </span>
                                                </div>
                                            </div>

                                        </div>


                                        <div
                                            class="sm:grid sm:grid-cols-3 sm:gap-4 items-center sm:border-t sm:border-gray-200 sm:pt-5">
                                            <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                Total </label>
                                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                <span
                                                    class="text-bs font-semibold text-gray-700">{{
                                                        this.total()
                                                    }}</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="pt-5">
                                <div class="flex justify-end">
                                    <button type="submit" :disabled="processing"
                                            class="ml-3 inline-flex  justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <Loader :processing="processing" ></Loader>
                                        {{processing ? 'Processing...':"Submit Bid"}}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {useProjectBidStore} from "../store/ProjectBid";
import {defineComponent, reactive, ref} from "vue";
import useVuelidate from "@vuelidate/core";
import moment from "moment-timezone";
import {required, numeric, decimal, helpers, requiredIf, requiredUnless} from "@vuelidate/validators";
import {useProjectStore} from "../store/project";
import DragAndDrop from '@/components/DragAndDrop';
import DragAndDropFull from '@/components/DragAndDropFull';

export default {
    components: {
        DragAndDrop
    },
    props: ['project_id', 'category1'],
    setup(props) {
        const myVueDropzone = ref(null);
        // const form = ref<HTMLFormElement>();
        const store = useProjectBidStore();
        const projectStore = useProjectStore();
        const amountRule = helpers.regex(/^\d*(\.\d{0,2})?$/);

        let data = {
            project_id: "",
            file: null,
            base_price: "",
            contingency_fee: "",
            term_of_contract_month: "",
            monthly_cost: "",
            monthly_tax_cost: "",
            non_recurring_cost: "",
        };

        const formData = reactive(data);

        const rules = {
            project_id: {required},
            base_price: {
                requiredIf: requiredUnless(props.category1),
                amountRule
            },
            contingency_fee: {
                requiredIf: requiredUnless(props.category1),
                amountRule
            },
            term_of_contract_month: {
                requiredIf: requiredIf(props.category1),
                amountRule,
                numeric
            },
            monthly_cost: {
                requiredIf: requiredIf(props.category1),
                amountRule
            },
            monthly_tax_cost: {
                requiredIf: requiredIf(props.category1),
                amountRule
            },
            non_recurring_cost: {
                requiredIf: requiredIf(props.category1),
                amountRule
            },
            file: {required},
        }
        const v$ = useVuelidate(rules, formData);

        return {
            store,
            formData,
            v$,
            projectStore,
            myVueDropzone
        }
    },
    data() {
        return {
            base_price: 0,
            contingency_fee: 0,
            file: null,
            url: "https://httpbin.org/post",
            processing:false
        }
    },
    methods: {
        total() {

            let total = 0;
            if (!this.category1) {
                let basePrice = 0.00;
                let contingencyFee = 0.00;
                if (this.formData.base_price) {
                    basePrice = parseFloat(this.formData.base_price)
                }

                if (this.formData.contingency_fee) {
                    contingencyFee = parseFloat(this.formData.contingency_fee)
                }

                total = basePrice + contingencyFee;
            } else {
                total = this.calculateTotalForCategory1()
            }
            return "$" + total.toFixed(2);
        },
        calculateTotalForCategory1() {
            let monthly_cost = 0.00;
            let monthly_tax_cost = 0.00;
            let non_recurring_cost = 0;
            let term_of_contract_month = 0;
            if (this.formData.term_of_contract_month) {
                term_of_contract_month = parseFloat(this.formData.term_of_contract_month)
            }
            if (this.formData.monthly_cost) {
                monthly_cost = parseFloat(this.formData.monthly_cost)
            }
            if (this.formData.monthly_tax_cost) {
                monthly_tax_cost = parseFloat(this.formData.monthly_tax_cost)
            }
            if (this.formData.non_recurring_cost) {
                non_recurring_cost = parseInt(this.formData.non_recurring_cost)
            }

            return ((monthly_cost + monthly_tax_cost) * term_of_contract_month)  + non_recurring_cost;
        },
        async onSubmit() {
            this.formData.project_id = this.project_id;
            const validated = await this.v$.$validate();
            if (validated) {
                this.processing = true;
                const data = this.getFormData(this.formData);
                data.set('file', this.formData.file);
                for (var i = 0; i < this.formData.files.length; i++ ){
                    let file = this.formData.files[i].file;
                    data.append('attachments[' + i + ']', file);
                }
                // data.set('files', this.formData.files);

                let timezone = moment.tz.guess();
                console.log(timezone.toString());
                console.log(Intl.DateTimeFormat().resolvedOptions().timeZone);
                data.set('project_id', this.formData.project_id);
                data.set('category1', this.category1);
                data.set('timezone',timezone);
                // data.append('base_price', this.formData.base_price);
                // data.append('contingency_fee', this.formData.contingency_fee);
                await this.store.storeBids(data).then(data => {
                    if (data) {
                        this.projectStore.addBid(data);
                    }
                }).finally(()=>{
                    this.processing = false;
                });
            }
        },
        getFormData(object) {
            const formData = new FormData();
            Object.keys(object).forEach(key => formData.append(key, object[key]));
            return formData;
        },
        handleDragAndDropFileUpload(files) {
            if (files instanceof Array && files.length > 0) {
                let selectedFile = files[0];
                this.formData.files = files;
                this.formData.file = selectedFile.file;
            } else {
                this.formData.file = null;
                this.formData.files = null;

            }
        }

    }
}
</script>
