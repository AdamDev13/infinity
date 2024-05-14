<script setup>
import ButtonRepo from '@/components/ButtonRepo.vue'
import MainHeader from '@/components/MainHeader.vue'
import Sidebar from '@/components/Sidebar.vue'
import Searchbar from '@/components/Searchbar.vue'
import MobileNav from '@/components/MobileNav.vue'
import RecentHeader from '@/components/RecentHeader.vue'
import HistoryList from '@/components/HistoryList.vue'
import {useRecentlyViewedStore} from "@/store/RecentlyViewed";
import {computed} from "vue";

const store = useRecentlyViewedStore();
const fetchViews = async () =>{
    await store.fetchViews();
}

const setViews = (data) =>{
    store.setViews(data);
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


</script>
<template>
    <div class="h-screen flex overflow-hidden bg-white">
        <MobileNav />
        <Sidebar />
        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            <Searchbar />
            <main class="flex-1 relative overflow-y-auto focus:outline-none">
                <div class="py-6">
                    <RecentHeader />
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        <div class="py-4 mt-5">
                            <div class="flex flex-col">
                                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                        <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">

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
                                                <tbody>
                                                <tr v-for="(view, projectIdx) in views.data" :key="view.project.number" :class="projectIdx % 2 === 0 ? 'bg-white' : 'bg-gray-50'">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        <router-link :to="{path:'/view-project/'+view.project.id} ">{{ view.project.name }}</router-link>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        <span class="text-gray-600">{{ view.project.category.name }}</span>
                                                    </td>
                                                    <td v-if="view.project.isLate === true" class="px-6 py-4 whitespace-nowrap text-sm text-red-500 font-medium">
                                                        {{ view.project.deadline_date }}
                                                    </td>
                                                    <td v-else class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                                        {{ view.project.deadline_date }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        <router-link :to="{path:'/view-project/'+view.project.id} " >{{ view.project.project_number }}</router-link>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <router-link :to="{path:'/view-project/'+view.project.id} " class="bg-gray-100 hover:bg-indigo-600 text-gray-700 hover:text-white px-3 py-2 rounded-md text-sm">View Project</router-link>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <Pagination :data="views" :meta="meta" :route="route"  @updateParentData="updateProject" />

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--              <HistoryList :projects="projects" :meta="projects.meta" :route="route" @updateProject="updateProject" />-->
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>
</template>
<script>


export default {
    methods: {
        updateProject(data){
            this.store.setViews(data);
        }
    },

}
</script>

