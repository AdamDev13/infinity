
<template>
  <div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">

         <div class="flex py-4 px-4 gap-4 bg-gray-50 border-b border-gray-200">

            <div class="w-full">
              <label for="search" class="block text-xs font-medium mb-2 text-gray-600 sm:mt-px">
                Search Name or CRM Number
              </label>
              <div class="mt-1 sm:mt-0 sm:col-span-2">
                <input type="text" class="block focus:ring-blue-500 focus:border-blue-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
              </div>
            </div>

          </div>
          <table class="min-w-full divide-y divide-gray-00">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-5 text-left text-sm font-medium text-gray-500">
                  Name
                </th>
                <th scope="col" class="px-6 py-5 text-left text-sm font-medium text-gray-500">
                  Address
                </th>
                <th scope="col" class="px-6 py-5 text-left text-sm font-medium text-gray-500">
                  CRM
                </th>
                <th scope="col" class="relative px-6 py-3">
                  <span class="sr-only">Add Project</span>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(client, clientIdx) in client" :key="client.number" :class="clientIdx % 2 === 0 ? 'bg-white' : 'bg-gray-50'">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  <router-link to="/edit-client">{{ client.name }}</router-link>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ client.address }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ client.crm }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <router-link to="/edit-client" class="text-gray-500 hover:text-gray-900 mr-4">Edit</router-link>
                  <router-link to="/add-project" class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-blue-600 hover:text-white">Add Project</router-link>
                </td >
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
                <span class="font-medium">3</span>
                {{ ' ' }}
                of
                {{ ' ' }}
                <span class="font-medium">3</span>
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

const client = [
  { name: 'Ugly Duck Marketing', address: '123 test drive', crm: 'test crm' },
    { name: 'Ugly Duck Marketing', address: '123 test drive', crm: 'test crm' },
      { name: 'Ugly Duck Marketing', address: '123 test drive', crm: 'test crm' },
        { name: 'Ugly Duck Marketing', address: '123 test drive', crm: 'test crm' },
          { name: 'Ugly Duck Marketing', address: '123 test drive', crm: 'test crm' },
]

export default {
  setup() {
    return {
      client,
    }
  },
}
</script>