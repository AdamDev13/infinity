<script setup>
import ButtonRepo from '@/components/ButtonRepo.vue'
import MainHeader from '@/components/MainHeader.vue'
import Sidebar from '@/components/Sidebar.vue'
import Searchbar from '@/components/Searchbar.vue'
import MobileNav from '@/components/MobileNav.vue'
import ProjectHeader from '@/components/ProjectHeader.vue'
import ProjectList from '@/components/ProjectList.vue'
import SavedProjects from '@/components/SavedProjects.vue'
import RecentProjects from '@/components/RecentProjects.vue'
</script>

<template>

<div class="h-screen flex overflow-hidden bg-white">


  <MobileNav />
  <Sidebar />

  <div class="flex flex-col w-0 flex-1 overflow-hidden">

  <Searchbar />

    <main class="flex-1 relative overflow-y-auto focus:outline-none">
      <div class="py-6">

        <MainHeader />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">

          <div class="lg:grid lg:grid-cols-12 gap-12 mt-5">
            <div class="col-span-8">
              <div class="grid md:grid-cols-2 gap-2">

              <router-link to="/projects" class="text-white w-full flex px-6 py-6 gap-4 text-sm font-medium rounded-md transition-all duration-200 border border-gray-20 bg-indigo-600 hover:bg-indigo-500 shadow-md hover:shadow-lg">
                 <div>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-I 9 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                   </svg>
                </div>
                <div>
                  <h3 class="text-lg font-bold text-white">View All Projects</h3>
                  <p class="mt-3">Click here to view all projects, and upload a bid submission.</p>
                </div>
              </router-link>

              <router-link to="/favorited-projects" class="text-white w-full flex px-6 py-6 gap-4 text-sm font-medium rounded-md transition-all duration-200 border border-gray-20 bg-indigo-600 hover:bg-indigo-500 shadow-md hover:shadow-lg">
                 <div>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-I 9 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
                <div>
                  <h3 class="text-lg font-bold text-white">Favorited Projects</h3>
                  <p class="mt-3">We have your back. Search all your past viewed projects here.</p>
                </div>
              </router-link>



              <router-link to="/recent-projects" class="text-white w-full flex px-6 py-6 gap-4 text-sm font-medium rounded-md transition-all duration-200 border border-gray-20 bg-indigo-600 hover:bg-indigo-500 shadow-md hover:shadow-lg">
                 <div>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-I 9 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div>
                  <h3 class="text-lg font-bold text-white">Recently Viewed</h3>
                  <p class="mt-3">Stay organized, and view all projects you've favored here.</p>
                </div>
              </router-link>

              <router-link to="/bid-submissions" class="text-white w-full flex px-6 py-6 gap-4 text-sm font-medium rounded-md transition-all duration-200 border border-gray-20 bg-indigo-600 hover:bg-indigo-500 shadow-md hover:shadow-lg">
                 <div>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-I 9 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>

                </div>
                <div>
                  <h3 class="text-lg font-bold text-white">Bid Submissions</h3>
                  <p class="mt-3">View all of your bid submission history, withdraw and upload a new bid.</p>
                </div>
              </router-link>

              </div>
            </div>
            <div class="col-span-4">
              <h3 class="font-bold text-lg mb-1 text-gray-900">
                <div class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>
                <span>Need Help?</span>
                </div>
              </h3>
              <p class="text-gray-500 mb-4">Watch our getting started tutorial.</p>
              <div class="aspect-w-16 aspect-h-9">
                  <iframe src="https://player.vimeo.com/video/751833716?h=fae7008c1b&amp;badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" width="1920" height="1080" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen title="Infinity Bid Submission Overview"></iframe>
<!--                <iframe src="https://www.youtube.com/embed/r9jwGansp1E" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->
              </div>
            </div>
          </div>

          <div class="py-4 mt-8">
              <div class="grid pb-2">
                  <ProjectList />
              </div>
            <div class="grid md:grid-cols-2 gap-6">
              <SavedProjects />
              <RecentProjects />

            </div>

          </div>
          <!-- /End replace -->
        </div>
      </div>
    </main>
  </div>
</div>

</template>
<script>
export default {
    name:"dashboard",
    data(){
        return {
            user:this.$store.state.auth.user
        }
    },


}
</script>

