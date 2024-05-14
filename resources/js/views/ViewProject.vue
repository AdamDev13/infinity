<script setup>
import ButtonRepo from '@/components/ButtonRepo.vue'
import MainHeader from '@/components/MainHeader.vue'
import Sidebar from '@/components/Sidebar.vue'
import Searchbar from '@/components/Searchbar.vue'
import MobileNav from '@/components/MobileNav.vue'
import ProjectHeader from '@/components/ProjectHeader.vue'
import UserList from '@/components/UserList.vue'
import ProjectDetails from '@/components/ProjectDetails.vue'
import {ArrowNarrowLeftIcon} from '@heroicons/vue/solid'
import QuestionList from '@/components/QuestionList.vue'
import ProjectQuestions from '@/components/ProjectQuestions.vue'
import SubmitBid from '@/components/SubmitBid.vue'
import SubmittedBid from '@/components/SubmittedBid.vue'
import {useProjectQuestionStore} from "@/store/ProjectQuestion";
import {useProjectStore} from "../store/project";
import {computed} from "vue";
import {useRoute} from "vue-router";

const questionStore = useProjectQuestionStore();
const projectStore = useProjectStore();
const route = useRoute();

const id = route.params.id;

const fetchProject = async (id) =>{
    await projectStore.fetchProject(id);
}

const fetchProjectQuestion = async (id) =>{
    await questionStore.fetchProjectQuestion(id);
}

fetchProject(id);
fetchProjectQuestion(id);

const questions = computed(function () {
    return questionStore.questions.data;
});

const apiUrl = computed(function () {
    return projectStore.route;
});

const project = computed(function () {
    return projectStore.project;
});

const category1 = computed(function () {
    return projectStore.project.category.name.includes("Category 1");
});
</script>


<template>

    <div class="h-screen flex overflow-hidden bg-white">

        <MobileNav/>
        <Sidebar/>

        <div class="flex flex-col w-0 flex-1 overflow-hidden">

            <Searchbar/>

            <main class="flex-1 relative overflow-y-auto focus:outline-none">
                <div class="py-6">

                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        <div class="mt-2 md:flex md:items-center md:justify-between">
                            <div class="flex-1 min-w-0 items-center">
                                <router-link to="/projects" class="text-xs mb-4 text-gray-500 font-semibold block"
                                             href="#">
                                    <ArrowNarrowLeftIcon class="mr-1 h-3 w-3 -mt-0.5 inline-block" aria-hidden="true"/>
                                    Back To Projects
                                </router-link>
                                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                                    Project Details
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        <ProjectDetails />
                        <div v-if="this.project.bids < 1">
                            <SubmitBid :project_id="this.project.id" :category1="this.category1"/>
                        </div>
                        <div v-else>
                            <SubmittedBid :bids="this.project.bids"/>
                        </div>
                        <ProjectQuestions :questions="questions" :processing="this.processing" :projectId="this.project.id" @submit="askQuestion"/>
                    </div>

                </div>
            </main>
        </div>
    </div>

</template>
<script>

import {useProjectStore} from "../store/project";
import {computed} from "vue";

export default {
    name: "ViewProject",
    components: {
        ProjectDetails,
        ProjectQuestions
    },
    // setup() {
    //     // const id = this.$route.params.id;
    //     //
    //     // const fetchProject = async (id) =>{
    //     //     await projectStore.fetchProject(id);
    //     // }
    //     //
    //     // const fetchProjectQuestion = async (id) =>{
    //     //     await questionStore.fetchProjectQuestion(id);
    //     // }
    //     //
    //     // fetchProject(id);
    //     // fetchProjectQuestion(id);
    //     //
    //     // const questions = computed(function () {
    //     //     return questionStore.questions.data;
    //     // });
    //     //
    //     // const route = computed(function () {
    //     //     return projectStore.route;
    //     // });
    //     //
    //     // const project = computed(function () {
    //     //     return projectStore.project;
    //     // });
    //     //
    //     // return {
    //     //     id,
    //     //     questions,
    //     //     route,
    //     //     project,
    //     //     fetchProject,
    //     //     fetchProjectQuestion
    //     // };
    // },
    data(){
        return{
            processing:false
        }
    },
    computed: {
        // questions() {
        //     return this.questionStore.questions.data;
        // },
        // route() {
        //     return this.projectStore.route;
        // },
        // project() {
        //     return this.projectStore.project;
        // },
        // category1(){
        //     return this.project.category.name.includes("Category 1");
        // }
    },
    created() {
        // let id = this.$route.params.id;
        // this.projectStore.fetchProject(id);
        // this.questionStore.fetchProjectQuestion(id);
    },
    methods: {
        async getProject(id) {
            await this.fetchProject(id);
        },
        askQuestion(question) {
            this.processing = true;
            this.questionStore.setQuestionFormData(question, this.project.id);
            return this.questionStore.submitQuestion().finally(() => {
                this.processing = false;
            });
        }


    }

}

</script>
