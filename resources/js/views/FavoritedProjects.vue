<script setup>
import ButtonRepo from '@/components/ButtonRepo.vue'
import MainHeader from '@/components/MainHeader.vue'
import Sidebar from '@/components/Sidebar.vue'
import Searchbar from '@/components/Searchbar.vue'
import MobileNav from '@/components/MobileNav.vue'
import FavoritedHeader from '@/components/FavoritedHeader.vue'
import HistoryList from '@/components/HistoryList.vue'
import {useFavoriteStore} from "../store/favorite";
const store = useFavoriteStore();
</script>


<template>

<div class="h-screen flex overflow-hidden bg-white">

  <MobileNav />
  <Sidebar />

  <div class="flex flex-col w-0 flex-1 overflow-hidden">

  <Searchbar />

    <main class="flex-1 relative overflow-y-auto focus:outline-none">
      <div class="py-6">

        <FavoritedHeader />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
          <div class="py-4 mt-5">
            <HistoryList :projects="projects" :meta="projects.meta" :route="route" @updateProject="updateProject" />
          </div>
        </div>

      </div>
    </main>
  </div>
</div>

</template>
<script>


export default {
    components: {HistoryList},
    created() {
        this.store.fetchProject();
    },
    mounted() {

    },
    computed:{
        meta(){
            return this.projects.meta;
        },
        getProjects(){
            return this.store.getProjects();
        },
        projects(){
            return this.store.projects;
        },
        route(){
            return this.store.route;
        }
    },
    methods: {
        updateProject(data){
            this.store.setProject(data);
            // this.projects = data;
        }
    },

}
</script>
