
<template>
  <div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">

          <div class="min-w-full divide-y divide-gray-200">

              <div v-for="(q, questionId) in questions.data" :key="q.id" :class="questionId % 2 === 0 ? 'bg-white py-2 px-8' : 'bg-gray-50 py-2 px-8'">
                <dl>
                  <div class="pt-4 text-sm mb-4 border-b border-gray-200 pb-4 flex items-center justify-between">
                    <div>
                      <span class="block text-xs text-gray-500 font-semibold">Project Name</span>
                      <span class="text-sm text-gray-700 mt-1 font-semibold block">{{q.project.name}}</span>
                    </div>
                    <div>
                      <router-link :to="{path:'/view-project/'+q.project.id} " class="bg-white hover:bg-indigo-600 text-gray-700 hover:text-white px-4 py-3 rounded-md text-sm font-semibold border border-gray-200">View Project</router-link>
                    </div>
                  </div>
                  <div class="pt-6 pb-8 md:grid md:grid-cols-12 md:gap-8">

                    <div class="text-base font-medium text-gray-900 md:col-span-5">
                      <span   class="block text-xs text-gray-500 font-semibold mb-2">Question</span>
                       <div v-html="q.question" >

                       </div>
                      <span class="text-xs mt-2 block font-medium text-gray-400">{{q.created_at}}</span>
                      </div>
                    <div v-if="!q.is_answer" class="mt-2 md:mt-0 md:col-span-5">
                      <p class="text-xs text-gray-600 font-semibold bg-gray-100 py-2 px-4 rounded-full inline-block">Awaiting Answer</p>
                    </div>
                     <div v-else class="mt-2 md:mt-0 md:col-span-5">
                      <p class="text-sm text-gray-700">
                         <span class="block text-xs text-gray-500 font-semibold mb-2">Answer</span>
                           <div v-html="q.answer" >
                           </div>
                          <span class="text-xs mt-2 block font-medium text-gray-400">{{q.updated_at}}</span></p>
                    </div>
                  </div>
                </dl>
              </div>

          </div>
            <Pagination :data="questions" :meta="questions.meta" :route="route"  @updateParentData="updateQuestion" />


        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    data() {
        return {
            questions:{
                data:[],
                links:{},
                meta:{}
            },
            route:{type:String}
        }
    },
    created() {
        this.route = 'project/question';
        this.$axios.get(this.route).then((response) => {
            this.questions = response.data;
        }).catch(({response:{data}})=>{

        });
    },
    computed:{
        meta(){
            return this.questions.meta;
        }
    },
    methods: {
        updateQuestion(data){
            this.questions = data;
        }
    },

}
</script>
