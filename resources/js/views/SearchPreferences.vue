<script setup>
import ButtonRepo from '@/components/ButtonRepo.vue'
import MainHeader from '@/components/MainHeader.vue'
import Sidebar from '@/components/Sidebar.vue'
import Searchbar from '@/components/Searchbar.vue'
import MobileNav from '@/components/MobileNav.vue'
import PreferenceHeader from '@/components/PreferenceHeader.vue'
import ProjectList from '@/components/ProjectList.vue'
</script>


<template>

<div class="h-screen flex overflow-hidden bg-white">

  <MobileNav />
  <Sidebar />

  <div class="flex flex-col w-0 flex-1 overflow-hidden">

  <Searchbar />

    <main class="flex-1 relative overflow-y-auto focus:outline-none">
      <div class="py-6">

        <PreferenceHeader />
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
          <div class="py-4 mt-5 text-gray-600">
            Coming Soon
          </div>
        </div>

      </div>
    </main>
  </div>
</div>

</template>