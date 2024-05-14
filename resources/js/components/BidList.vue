
<template>
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
                  File Downloads
                </th>
                <th scope="col" class="px-6 py-5 text-left text-sm font-medium text-gray-500">
                  Submission Date
                </th>
                <th scope="col" class="px-6 py-5 text-left text-sm font-medium text-gray-500">
                  Project Number
                </th>
                <th scope="col" class="px-6 py-5 text-left text-sm font-medium text-gray-500">
                  Bid Status
                </th>
                <th scope="col" class="relative px-6 py-3">
                  <span class="sr-only">Edit</span>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(bid, bidIds) in bids.data" :key="bid.project.project_number" :class="bidIds % 2 === 0 ? 'bg-white' : 'bg-gray-50'">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  <router-link :to="{path:'/view-project/'+bid.project.id} " >{{ bid.project.name }}</router-link>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm cursor-pointer text-gray-500 flex gap-2 items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                  </svg>
                  <a  v-text="bid.label" @click="downloadItem(bid)" class="font-medium text-indigo-600 hover:text-indigo-500"></a>
                </td>
                  <td v-if="bid.status !== 'L' "
                      class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                      {{ bid.submission_date }}
                  </td>
                  <td v-else class="px-6 py-4 whitespace-nowrap text-sm text-red-500 font-medium">
                      {{ bid.submission_date }}
                  </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <router-link :to="{path:'/view-project/'+bid.project.id} " >{{ bid.project.project_number }}</router-link>
                </td>
                <td v-if="bid.is_withdraw === 0" class="px-6 py-4 whitespace-nowrap text-xs text-white font-medium">
                  <span class="bg-indigo-600 py-2 px-4 rounded-full">Active Bid</span>
                </td>
                <td v-else class="px-6 py-4 whitespace-nowrap text-xs text-gray-600 font-medium">
                  <span class="bg-gray-200 py-2 px-4 rounded-full">Withdrawn</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <router-link :to="{path:'/view-project/'+bid.project.id} " class="bg-gray-100 hover:bg-indigo-600 text-gray-700 hover:text-white px-3 py-2 rounded-md text-sm">View Project</router-link>
                </td>
              </tr>
            </tbody>
          </table>

            <Pagination :data="bids" :meta="bids.meta" :route="route"  @updateParentData="updateBids" />

        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    data() {
        return {
            bids:{
                data:[],
                links:{},
                meta:{}
            },
            route:{type:String}
        }
    },
    created() {
        this.route = 'bid-submissions';
        this.$axios.get(this.route).then((response) => {
            this.bids = response.data;
        }).catch(({response:{data}})=>{

        });
    },
    computed:{
        meta(){
            return this.bids.meta;
        }
    },
    methods: {
        updateBids(data){
            this.bids = data;
        }
    },

}
</script>
