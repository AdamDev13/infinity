<template>
  <div class="relative z-10 flex-shrink-0 flex h-16 bg-white border-b border-gray-100 max-w-7xl mx-auto w-full">
      <button type="button" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 md:hidden">
        <span class="sr-only">Open sidebar</span>
        <!-- Heroicon name: outline/menu-alt-2 -->
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
        </svg>
      </button>
      <div class="flex-1 px-8 flex justify-between">
        <div class="flex-1 flex">
          <form class="w-full flex md:ml-0 hidden" action="#" method="GET">
            <label for="search-field" class="sr-only">Search Projects</label>
            <div class="relative w-full text-gray-400 focus-within:text-gray-600">
              <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                <!-- Heroicon name: solid/search -->
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
              </div>
              <input id="search-field" class="block w-full h-full pl-8 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-0 focus:border-transparent sm:text-sm" placeholder="Search Projects" type="search" name="search">
            </div>
          </form>
        </div>

        <div class="ml-4 flex items-center md:ml-6">

          <!-- Profile dropdown -->
          <div class="ml-3 relative">
            <div>
              <button onclick="openNav()" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                <span class="sr-only">Open user menu</span>
                <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center text-center"><span class="w-full text-white font-bold text-sm block">M</span></div>
                <span class="font-semibold text-gray-500 px-2 text-sm">{{user.first_name}} {{user.last_name}}</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
              </button>
            </div>

            <!-- Dropdown -->
            <div id="user-menu" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
              <!-- Active: "bg-gray-100", Not Active: "" -->
              <router-link to="/profile" class="block px-4 py-2 text-sm text-gray-700 font-semibold" role="menuitem" tabindex="-1">Your Profile</router-link>
              <router-link to="/reset-password" class="block px-4 py-2 text-sm text-gray-700 font-semibold" role="menuitem" tabindex="-1">Reset Password</router-link>
              <a  href="#" class="block px-4 py-2 text-sm text-gray-700 font-semibold" role="menuitem" @Click="logout" tabindex="-1">Sign out</a>
            </div>

          </div>
        </div>
      </div>
    </div>
</template>
<script>
import {mapActions} from 'vuex';
export default {
    data(){
        return {
            user:null
        }
    },
    created() {
        if (this.$store.state.auth){
            this.user = this.$store.state.auth.user;
        }
    },
    methods: {
        ...mapActions({
            signOut:"auth/logout"
        }),
        async logout(){
            await axios.post('logout').then(({data})=>{
                this.signOut()
                this.$router.push({name:"login"})
                // this.$router.go();
            })
        }
    },
}
</script>


