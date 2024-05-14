<template>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">

                    <div class="bg-gray-50 px-6 py-5 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Favorited Projects
                        </h3>
                        <div>
                            <router-link to="/favorited-projects"
                                         class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                View Favorited Projects
                            </router-link>
                        </div>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-5 text-left text-sm font-medium text-gray-500">
                                Project Name
                            </th>
                            <th scope="col" class="px-6 py-5 text-left text-sm font-medium text-gray-500">
                                Project Number
                            </th>
                            <th scope="col" class="px-6 py-5 text-left text-sm font-medium text-gray-500">
                                Deadline
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(project, projectIdx) in projects.data" :key="project.id"
                            :class="projectIdx % 2 === 0 ? 'bg-white' : 'bg-gray-50'">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <router-link :to="{path:'/view-project/'+project.id} " >{{ project.name }}</router-link>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <router-link :to="{path:'/view-project/'+project.id} " >{{ project.project_number }}</router-link>
                            </td>
                            <td v-if="project.isLate === true"
                                class="px-6 py-4 whitespace-nowrap text-sm text-red-500 font-medium">
                                {{ project.deadline_date }}
                            </td>
                            <td v-else class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                {{ project.deadline_date }}
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <Pagination :data="projects" :meta="projects.meta" :route="route"  @updateParentData="updateProject" />

                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            projects: {
                data:[],
                links:{},
                meta:{}
            },
            route:''
        }
    },
    created() {
        this.route = "project/favorite";
        this.$axios.get(this.route).then((response) => {
            this.projects = response.data;
        }).catch(({response: {data}}) => {

        });
    },
    methods: {
        updateProject(data){
            this.projects = data;
        }
    },
    computed:{
        meta(){
            return this.projects.meta;
        }
    }
}
</script>
