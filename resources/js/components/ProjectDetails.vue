<script>
import Filelist from '@/components/Filelist.vue'
import {BookmarkIcon} from '@heroicons/vue/outline'
import moment from "moment"
import {useFavoriteStore} from "../store/favorite";
import {useProjectStore} from "../store/project";
import {computed} from "vue";


export default {
    setup() {
        const storeFavorite = useFavoriteStore();
        const projectStore = useProjectStore();


        const makeFavorite = async (id) => {
             await storeFavorite.favorite(id);
        }

        const makeUnFavorite = async (id) => {
            await storeFavorite.unfavorite(id);
        }

        const project = computed(function () {
            return projectStore.getProject;
        });

        const category = computed(function () {
            return projectStore.getCategory;
        });

        const user_belongs = computed(function () {
            return projectStore.getProject.user_belongs;
        });

        const rfpFiles = computed(function () {
            return projectStore.getRfpfile;
        });

        const AddendumFiles = computed(function () {
            return projectStore.getAddendum;
        });

        return {
            project,
            category,
            user_belongs,
            projectStore,
            storeFavorite,
            rfpFiles,
            AddendumFiles,
            makeFavorite,
            makeUnFavorite
        };
    },
    data() {
        return {
            processing:false
        };
    },
    components: {
        Filelist,
        BookmarkIcon
    },
    computed: {
    },
    methods: {
        favorite() {
            this.processing = true;
            this.makeFavorite(this.project.id).then(()=>{
                this.project.is_favorite = 1;
            }).finally(()=>{
                this.processing = false;
            });

        },
        unfavorite() {
            this.processing = true;
            this.makeUnFavorite(this.project.id).then(()=>{
                this.project.is_favorite = 0;
            }).finally(()=>{
                this.processing = false;
            });
        }
    }
}
</script>

<template>

    <div  v-if="this.project" class="bg-white shadow overflow-hidden sm:rounded-lg mb-8 mt-8 border border-gray-200">
        <div  class="px-4 py-6 sm:px-6 flex justify-between items-center bg-gray-50">
            <div>
                <div class="flex divide-x divide-gray-200">
                    <p class="mb-2 max-w-2xl text-xs text-gray-500 font-medium pr-3"><span
                        class="font-semibold text-gray-800 mr-1">Deadline</span>{{
                        getFormattedTime(project.deadline_datetime)
                        }}</p>
                    <p class="mb-2 max-w-2xl text-xs text-gray-500 font-medium pl-3"><span
                        class="font-semibold text-gray-800 mr-1">Project Number</span>{{ project.project_number }}</p>
                </div>
                <h3 class="text-xl md:text-2xl leading-6 font-semibold text-gray-900 tracking-tight mt-1">
                    {{ project.name }}
                </h3>
            </div>
            <div v-if="!project.is_favorite">
                <button type="button" @click="this.favorite()" :disabled="processing"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <BookmarkIcon class="-ml-1 mr-2 h-4 w-4" aria-hidden="true"/>
                    <Loader :processing="processing" class="text-indigo-600" ></Loader>
                    {{processing ? 'Processing...':"Favorite Project"}}
                </button>
            </div>
            <div v-else>
                <button type="button" @click="this.unfavorite()" :disabled="processing"
                        class="bg-indigo-600 text-white inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 hover:text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <BookmarkIcon class="-ml-1 mr-2 h-4 w-4" aria-hidden="true"/>
                    <Loader :processing="processing"  ></Loader>
                    {{processing ? 'Processing...':"UnFavorite Project"}}
                </button>
            </div>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500 mb-3">
                        Project Type
                    </dt>
                    <dd v-if="category" class="mt-1 text-sm text-gray-900">
                        {{ category.name }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500 mb-3">
                        Address
                    </dt>
                    <dd v-if="user_belongs" class="mt-1 text-sm text-gray-900">
                        {{ user_belongs.address }} <br>
                        {{ user_belongs.address_continued }} <br>
                        {{ user_belongs.city }}, {{ user_belongs.state }}, {{ user_belongs.postal }} <br>
                        {{ user_belongs.county }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500 mb-3">
                        Walkthrough?
                        <span v-if="project.walkthrough"
                              class="-mt-0.5 ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Yes
                        </span>
                        <span v-else
                              class="-mt-0.5 ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-danger-light text-danger-dark">
                            No
                        </span>
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        Please review RFP for walkthrough date/time/location
                    </dd>
                </div>
                <div v-if="rfpFiles && rfpFiles.length > 0 " class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500 mb-3">
                        RFP Files
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <Filelist :files="rfpFiles"/>

                    </dd>
                </div>

                <div v-if="AddendumFiles && AddendumFiles.length > 0" class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500 mb-3">
                        Addendum Files
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <Filelist :files="AddendumFiles"/>
                    </dd>
                </div>

            </dl>
            <dt class="text-xs text-gray-400 mt-6">
                Last Updated {{ getFormattedTime(project.updated_at) }} <span class="px-1 text-gray-300">|</span>
                Published {{ getFormattedTime(project.created_at) }}
            </dt>
        </div>
    </div>

</template>


