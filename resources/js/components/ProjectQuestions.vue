<template>
    <div class="flex flex-col mb-12">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">

                    <div
                        class="px-4 py-6 sm:px-6 flex justify-between items-center bg-gray-50 border-b border-gray-200">
                        <div>
                            <h3 class="text-xl md:text-2xl leading-6 font-semibold text-gray-900 tracking-tight mt-1">
                                Project Questions
                            </h3>
                        </div>
                    </div>


                    <div class="min-w-full divide-y divide-gray-200">


                        <div v-for="(q, index) in questions" :key="index"
                             :class="index % 2 === 0 ? 'bg-white py-2 px-8' : 'bg-gray-50 py-2 px-8'">
                            <div class="pt-6 pb-8 md:grid md:grid-cols-12 md:gap-8">

                                <div class="text-base font-medium text-gray-900 md:col-span-5">
                                    <span class="block text-xs text-gray-500 font-semibold mb-2">Question</span>
                                    <div v-html="q.question"></div>
                                    <span class="text-xs mt-2 block font-medium text-gray-400">{{
                                            getFormattedTime(q.created_at)
                                        }}</span>
                                </div>
                                <div v-if="!q.is_answer" class="mt-2 md:mt-0 md:col-span-5">
                                    <p class="text-xs text-gray-600 font-semibold bg-gray-100 py-2 px-4 rounded-full inline-block">
                                        Awaiting Answer</p>
                                </div>
                                <div v-else class="mt-2 md:mt-0 md:col-span-5">
                                    <p class="text-sm text-gray-700">
                                        <span class="block text-xs text-gray-500 font-semibold mb-2">Answer</span>
                                    <div v-html="q.answer"></div>
                                    <span class="text-xs mt-2 block font-medium text-gray-400">{{
                                            getFormattedTime(q.updated_at)
                                        }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="p-6  bg-indigo-600 border-t border-indigo-700">

                        <h3 class="text-xl md:text-xl leading-6 font-semibold text-white tracking-tight mt-2 mb-4 border-b border-indigo-700 pb-4">
                            Ask A Question
                        </h3>

                        <div class="flex gap-4">

                            <div class="w-full">
                                <label for="question" class="block text-xs font-medium mb-2 text-white sm:mt-px">
                                    Question
                                </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text" v-model="question" id="question" name="question"
                                           autocomplete="question"
                                           class="block focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                </div>
                            </div>

                            <div class="w-auto mt-6">
                                <a href="#" @click="submit"
                                   class="whitespace-nowrap ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    <Loader :processing="processing" ></Loader>
                                     {{processing ? "Processing...":'Add Question'}} </a>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {questions : Array, processing: Boolean},
    data() {
        return {
            question: "",
            processing: false
        }
    },
    methods: {
        submit() {
            if (this.question !== "") {
                this.$emit('submit', this.question);
                this.question = "";
            }
        }
    }
}
</script>
