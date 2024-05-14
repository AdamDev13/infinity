
<template>
  <div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">


          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-5 text-left text-sm font-medium text-gray-500">
                  Company Name
                </th>
                <th scope="col" class="px-6 py-5 text-left text-sm font-medium text-gray-500">
                  Full Name
                </th>
                <th scope="col" class="px-6 py-5 text-left text-sm font-medium text-gray-500">
                  Last Viewed
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(user, userIdx) in user" :key="user.number" :class="userIdx % 2 === 0 ? 'bg-white' : 'bg-gray-50'">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  <a href="#">{{ user.company }}</a>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ user.name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ user.time }}
                </td>
              </tr>
            </tbody>
          </table>

          <nav class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6" aria-label="Pagination">
            <div class="hidden sm:block">
              <p class="text-xs text-gray-700">
                Showing
                {{ ' ' }}
                <span class="font-medium">1</span>
                {{ ' ' }}
                to
                {{ ' ' }}
                <span class="font-medium">50</span>
                {{ ' ' }}
                of
                {{ ' ' }}
                <span class="font-medium">72</span>
                {{ ' ' }}
                results
              </p>
            </div>
            <div class="flex-1 flex justify-between sm:justify-end">
              <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Previous
              </a>
              <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Next
              </a>
            </div>
          </nav>

        </div>
      </div>
    </div>
  </div>
</template>

<script>

const user = [
  { company: 'Geist Studio', name: 'Nick Campbell', time: '08/26/2021 at 7:16pm' },
  { company: 'Comcast Bakersfield', name: 'Matt Lewis', time: '08/24/2021 at 3:03pm' },
  { company: 'Ugly Duck Marketing', name: 'Kevin Harrer', time: '07/24/2021 at 3:44am' },
  { company: 'Bissel Vaccuums', name: 'Morgan Hagen', time: '08/10/2021 at 6:12pm' },
  { company: 'Hydroflask', name: 'John Snow', time: '04/18/2021 at 7:15pm' },
]

export default {
  setup() {
    return {
      user,
    }
  },
}
</script>