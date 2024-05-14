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
              <tr v-for="(project, projectIdx) in projects.data" :key="project.number" :class="projectIdx % 2 === 0 ? 'bg-white' : 'bg-gray-50'">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  <router-link :to="{path:'/view-project/'+project.id} ">{{ project.name }}</router-link>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <span class="text-gray-600">{{ project.category.name }}</span>
                </td>
                <td v-if="project.isLate === true" class="px-6 py-4 whitespace-nowrap text-sm text-red-500 font-medium">
                  {{ project.deadline_date }}
                </td>
                <td v-else class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                  {{ project.deadline_date }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <router-link :to="{path:'/view-project/'+project.id} " >{{ project.project_number }}</router-link>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <router-link :to="{path:'/view-project/'+project.id} " class="bg-gray-100 hover:bg-indigo-600 text-gray-700 hover:text-white px-3 py-2 rounded-md text-sm">View Project</router-link>
                </td>
              </tr>
            </tbody>
          </table>

            <Pagination :data="projects" :meta="meta" :route="route"  @updateParentData="updateProject" />

        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
    props: ["projects","meta","route"],
    // data(){
    //     return {
    //         projects:{}
    //     }
    // },
    methods: {
        updateProject(data){
            this.$emit('updateProject',data);
        }
    },
    computed:{
        meta(){
            return this.projects.meta;
        }
    }
}
</script>
