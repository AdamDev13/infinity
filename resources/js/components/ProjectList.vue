<template>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">

                    <div class="flex py-4 px-4 gap-4 bg-gray-50 border-b border-gray-200" :disabled="processing">

                        <div class="w-full">
                            <label for="search" class="block text-xs font-medium mb-2 text-gray-600 sm:mt-px">
                                Search Projects
                            </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <input type="text" v-model.lazy="parameter.search" placeholder="Project number or name"
                                       class="block focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                            </div>
                        </div>

                        <div class="w-full">
                            <label for="cat" class="block text-xs font-medium mb-2 text-gray-600 sm:mt-px">
                                Category
                            </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <select id="cat" v-model="parameter.category_id" name="category" autocomplete="category"
                                        class="block focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value="">All Categories</option>
                                    <option
                                        v-for="(category, id) in filters.categories"
                                        :value="id"
                                        :key="id">
                                        {{ category }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="w-full">
                            <label for="state" class="block text-xs font-medium mb-2 text-gray-600 sm:mt-px">
                                State
                            </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <select id="state" v-model="parameter.state" name="state" autocomplete="state"
                                        class="block focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value="">All States</option>
                                    <option
                                        v-for="(state, id) in filters.states"
                                        :value="id"
                                        :key="id">
                                        {{ state }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="w-full">
                            <label for="county" class="block text-xs font-medium mb-2 text-gray-600 sm:mt-px">
                                County
                            </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <select id="county" v-model="parameter.county" :disabled="filters.county.length < 1"
                                        name="county" autocomplete="county"
                                        :class="[filters.county.length < 1? 'bg-gray-100':'', 'block focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md']">
                                    <option value="">All Counties</option>
                                    <option
                                        v-for="(county, id) in filters.county"
                                        :value="id"
                                        :key="id">
                                        {{ county }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="w-full">
                            <label for="date" class="block text-xs font-medium mb-2 text-gray-600 sm:mt-px">
                                Due In Date
                            </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <select id="date" name="date" v-model="parameter.dueby" autocomplete="date"
                                        class="block focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value="">All Projects</option>
                                    <option
                                        v-for="(value,name) in filters.dueBy"
                                        :value="value"
                                        :key="value">
                                        {{ name }}
                                    </option>
                                </select>
                            </div>
                        </div>

                    </div>


                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-5 text-left text-sm font-medium text-gray-500">
                                Project Name
                            </th>
                            <th scope="col" class="px-6 py-5 text-left text-sm font-medium text-gray-500">
                                Category
                            </th>
                            <th scope="col" class="px-6 py-5 text-left text-sm font-medium text-gray-500">
                                Deadline Date
                            </th>
                            <th scope="col" class="px-6 py-5 text-left text-sm font-medium text-gray-500">
                                Project Number
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">View</span>
                            </th>
                        </tr>
                        </thead>
                        <ShimmerTableLoader :processing="processing" :rows="5" :cols="5" ></ShimmerTableLoader>
                        <tbody v-show="!processing">
                        <tr v-for="(project, projectIdx) in projects.data" :key="project.project_number"
                            :class="projectIdx % 2 === 0 ? 'bg-white' : 'bg-gray-50'">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <router-link :to="{path:'/view-project/'+project.id} ">{{ project.name }}</router-link>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="text-gray-600">{{ project.category.name }}</span>
                            </td>
                            <td v-if="project.isLate === true"
                                class="px-6 py-4 whitespace-nowrap text-sm text-red-500 font-medium">
                                {{ project.deadline_date }}
                            </td>
                            <td v-else class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                {{ project.deadline_date }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <router-link :to="{path:'/view-project/'+project.id} ">{{
                                        project.project_number
                                    }}
                                </router-link>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <router-link :to="{path:'/view-project/'+project.id} "
                                             class="bg-gray-100 hover:bg-indigo-600 text-gray-700 hover:text-white px-3 py-2 rounded-md text-sm">
                                    View Project
                                </router-link>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <Pagination :data="projects" :meta="projects.meta" :route="route"
                                @updateParentData="updateProject"/>

                </div>
            </div>
        </div>
    </div>
</template>

<script>

import ShimmerTableLoader from "./ShimmerTableLoader";
export default {
    components: {ShimmerTableLoader},
    data() {
        return {
            projects: {
                data: [],
                links: {},
                meta: {}
            },
            filters: {
                dueBy: {},
                states: {},
                county: {},
                categories: {},
            },
            route: '',
            parameter: {
                search: "",
                category_id: "",
                state: "",
                county: "",
                dueby: "",
            },
            processing: false
        }
    },
    created() {

    },
    mounted() {
        this.route = "project";

        this.getProjects();

    },
    methods: {
        updateProject(data) {
            this.projects = data.projects;
        },
        getProjects() {
            this.processing = true;
            this.$axios.get(this.route).then((response) => {
                this.projects = response.data.projects;
                this.filters = response.data.filters;
            }).catch(({response: {data}}) => {

            }).finally(() => {
                this.processing = false;
            });
            ;
        },
        filterProjects() {
            const entries = Object.entries(this.parameter);
            const query = new URLSearchParams(entries.filter(([key, val]) => val !== '' && val !== null)).toString();
            this.route = "project?" + query;
            this.processing = true;
            this.$axios.get(this.route).then((response) => {
                this.projects = response.data.projects;
                this.filters = response.data.filters;
            }).catch(({response: {data}}) => {

            }).finally(() => {
                this.processing = false;
            });
            ;
        }
    },
    computed: {
        meta() {
            return this.projects.meta;
        },
    },
    watch: {
        'parameter.state': function (val, oldVal) {
            if (this.parameter.county !== "") {
                this.parameter.county = "";
            } else {
                this.filterProjects();
            }
        },
        'parameter.county': function (val, oldVal) {
            this.filterProjects();
        },
        'parameter.dueby': function (val, oldVal) {
            this.filterProjects();
        },
        'parameter.category_id': function (val, oldVal) {
            this.filterProjects();
        },
        'parameter.search': function (val, oldVal) {
            this.filterProjects();
        },
    }
}
</script>
