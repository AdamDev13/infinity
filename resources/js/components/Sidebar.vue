<template>
  <!-- Static sidebar for desktop -->
  <div class="hidden md:flex md:flex-shrink-0 sidebar">
    <div class="flex flex-col w-64">
      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <div class="flex-1 flex flex-col min-h-0 border-r border-gray-100">
        <div class="flex items-center h-16 flex-shrink-0 px-4 bg-white border-b border-gray-100">
          <svg xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
          </svg>
          <div class="text-center w-full block">
            <img class="h-8 w-auto mx-auto" src="https://www.infinitycomm.com/wp-content/uploads/2022/08/infinity.jpg" />
          </div>
        </div>
        <div class="flex-1 flex flex-col overflow-y-auto p">

          <nav class="flex-1 px-2 py-4 bg-gray-50 space-y-1" aria-label="Sidebar">
            <router-link v-for="item in navigation" :key="item.name" :to="item.href" :class="[item.currentRoute ? 'bg-indigo-600 text-white' : 'text-gray-500 hover:bg-gray-200 hover:text-gray-800', 'group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200']" :aria-current="item.current ? 'page' : undefined">
              <component :is="item.icon" :class="[item.currentRoute ? 'text-gray-100' : 'text-gray-600 group-hover:text-indigo-600', 'flex-shrink-0 -ml-1 mr-3 h-6 w-6']" aria-hidden="true" />
              <span class="truncate">
                {{ item.name }}
              </span>
            </router-link>

            <button onclick="dropdownNav()" class="text-gray-500 w-full hover:bg-gray-200 hover:text-gray-800 group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-600 group-hover:text-indigo-600 flex-shrink-0 -ml-1 mr-3 h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg><span class="truncate">Settings</span></button>

            <div id="nav-child" class="bg-white p-2 rounded-lg w-full mt-2 hidden">
              <ul class="grid gap-2">
                <li>
                  <router-link to="/profile" class="text-gray-600 w-full hover:bg-gray-100 hover:text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200">
                    Your Profile
                  </router-link>
                  </li>
                  <li>
                  <router-link to="/reset-password" class="text-gray-600 w-full hover:bg-gray-100 hover:text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200">
                    Reset Password
                  </router-link>
                  </li>
              </ul>
            </div>


          </nav>

        </div>
      </div>
    </div>
  </div>

</template>

<style>
.sidebar .router-link-active, .sidebar .router-link-active:hover, .sidebar .router-link-active svg, .sidebar .router-link-active:hover svg {
  color: white !important;
  background: #5046e5;
}
</style>


<script>
import { LoginIcon, TicketIcon, ChartBarIcon, FolderIcon, HomeIcon, InboxIcon, UsersIcon, CogIcon, IdentificationIcon, ChatIcon, BookmarkAltIcon, ClockIcon, SearchIcon, BriefcaseIcon, FilterIcon } from '@heroicons/vue/outline'

const navigation = [
  { name: 'Dashboard', href: '/', icon: HomeIcon, currentRoute: false },
  { name: 'Projects', href: '/projects', icon: TicketIcon, currentRoute: false },
  { name: 'Recently Viewed', href: '/recent-projects', icon: ClockIcon, currentRoute: false },
  { name: 'Favorited Projects', href: '/favorited-projects', icon: BookmarkAltIcon, currentRoute: false },
  { name: 'Bid Submissions', href: '/bid-submissions', icon: BriefcaseIcon, currentRoute: false },
  { name: 'Project Questions', href: '/project-questions', icon: ChatIcon, currentRoute: false },
  { name: 'Search Prefrences', href: '/search-prefrences', icon: FilterIcon, currentRoute: false },
  // { name: 'Clients', href: '/clients', icon: IdentificationIcon, currentRoute: false },
  // { name: 'Settings', href: '/profile', icon: CogIcon, currentRoute: false },
]

export default {
  setup() {
    return {
      navigation,
    }
  },
}
</script>
