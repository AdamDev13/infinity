<!--<script setup>-->
<!--// import {useRecentlyViewedStore} from "@/store/RecentlyViewed";-->
<!--// const store = useRecentlyViewedStore();-->
<!--</script>-->
<script>

import {useRecentlyViewedStore} from "@/store/RecentlyViewed";
import {storeToRefs} from 'pinia';
import {reactive,computed} from "vue";
export default {
    setup(){
        const store = useRecentlyViewedStore();
        const fetchViews = async () =>{
            await store.fetchViews();
        }

        fetchViews();

        const views = computed(function () {
            return store.getViews;
        });

        const route = computed(function () {
            return store.route;
        });

        const meta = computed(function () {
            return store.views.meta;
        });
        return {
            store,
            fetchViews,
            route,
            views,
            meta
        }
    },
    created() {

    },
    methods: {
        updateProject(data){
            this.store.setViews(data);
        }
    },
}
</script>
<template>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">

                    <div class="bg-gray-50 px-6 py-5 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Recently Viewed
                        </h3>
                        <div>
                            <router-link to="/recent-projects"
                                         class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                View Recently Viewed Projects
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
                        <tr v-for="(view, projectIdx) in views.data" :key="view.project.project_number"
                            :class="projectIdx % 2 === 0 ? 'bg-white' : 'bg-gray-50'">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <router-link  :to="{path:'/view-project/'+view.project.id} " >{{ view.project.name }}</router-link>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <router-link :to="{path:'/view-project/'+view.project.id} " >{{ view.project.project_number }}</router-link>
                            </td>
                            <td v-if="view.project.isLate === true"
                                class="px-6 py-4 whitespace-nowrap text-sm text-red-500 font-medium">
                                {{ view.project.deadline_date }}
                            </td>
                            <td v-else class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                {{ view.project.deadline_date }}
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <Pagination :data="views" :meta="meta" :route="route"  @updateParentData="updateProject" />

                </div>
            </div>
        </div>
    </div>
</template>



