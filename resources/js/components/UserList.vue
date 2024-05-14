
<template>
  <div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">

          <div class="flex py-4 px-4 gap-4 bg-gray-50 border-b border-gray-200">

            <div class="w-full">
              <label for="first-name" class="block text-xs font-medium mb-2 text-gray-600 sm:mt-px">
                First Name
              </label>
              <div class="mt-1 sm:mt-0 sm:col-span-2">
                <input type="text" class="block focus:ring-blue-500 focus:border-blue-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
              </div>
            </div>

            <div class="w-full">
              <label for="last-name" class="block text-xs font-medium mb-2 text-gray-600 sm:mt-px">
                Last Name
              </label>
              <div class="mt-1 sm:mt-0 sm:col-span-2">
                <input type="text" class="block focus:ring-blue-500 focus:border-blue-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
              </div>
            </div>

            <div class="w-full">
              <label for="email-address" class="block text-xs font-medium mb-2 text-gray-600 sm:mt-px">
                Email Address
              </label>
              <div class="mt-1 sm:mt-0 sm:col-span-2">
                <input type="text" class="block focus:ring-blue-500 focus:border-blue-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
              </div>
            </div>

          </div>


          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-5 text-left text-sm font-medium text-gray-500">
                  Name
                </th>
                <th scope="col" class="px-6 py-5 text-left text-sm font-medium text-gray-500">
                  Email
                </th>
                <th scope="col" class="px-6 py-5 text-left text-sm font-medium text-gray-500">
                  Role
                </th>
                <th scope="col" class="relative px-6 py-3">
                  <span class="sr-only">Edit</span>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(user, userIdx) in user" :key="user.number" :class="userIdx % 2 === 0 ? 'bg-white' : 'bg-gray-50'">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  <a href="#">{{ user.name }}</a>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ user.email }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ user.role }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <router-link to="/edit-user" class="text-gray-500 hover:text-gray-900">Edit</router-link>
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
  { name: 'Matt Lewis', email: 'matt@ugduck.com', role: 'Admin' },
  { name: 'Morgan Hagen', email: 'morganglorys@gmail.com', role: 'Editor' },
  { name: 'Kevin Harrer', email: 'kevin@ugduck.com', role: 'Editor' },
  { name: 'Elliott Smith', email: 'elliott@google.com', role: 'Editor' },
  { name: 'Chili Nelseon', email: 'chili@ugduck.com', role: 'Admin' },
  { name: 'Nick Vegas', email: 'nickv7@gmail.com', role: 'Editor' },
  { name: 'Mac Miller', email: 'mostdope@gmail.com', role: 'Editor' },
  { name: 'Sarah Smith', email: 'srh@google.com', role: 'Editor' },
  { name: 'Tyler Lewis', email: 'tylewis@ugduck.com', role: 'Admin' },
  { name: 'John Smith', email: 'johnsmith@gmail.com', role: 'Editor' },
]

export default {
  setup() {
    return {
      user,
    }
  },
}
</script>