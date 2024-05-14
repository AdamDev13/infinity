<template>
  <form class="space-y-8 divide-y divide-gray-200">
    <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">

      <div class="space-y-6 sm:space-y-5">
        <div>
          <p class="mt-1 max-w-2xl text-sm text-gray-500 leading-7">
            <span class="font-bold text-lg text-gray-800 pt-1 block mt-2 mb-2">Ugly Duck Marketing</span>
            4000 W. Main Street, Unit 5<br />
            Bakersfield, CA 93301<br />
            <span class="font-semibold text-gray-700 mr-1">Phone Number:</span> (661) 555-5555<br />
            <span class="font-semibold text-gray-700 mr-1">CRM ID:</span>989135<br /><br />
          </p>
        </div>
        <div class="space-y-6 sm:space-y-5">

          <!-- Project Number -->
          <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
            <label for="project-number" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
              Project Number
            </label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <input type="text" name="project-number" id="project-number" autocomplete="given-name" class="w-full block max-w-lg block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md" />
            </div>
          </div>

          <!-- Project Name -->
          <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
            <label for="project-name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
              Project Name
            </label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <input type="text" name="project-name" id="project-name" autocomplete="given-name" class="w-full block max-w-lg block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md" />
            </div>
          </div>

          <!-- Project Category -->
          <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
            <label for="cat" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
              Project Cateogry
            </label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <select id="cat" name="cat" autocomplete="cat" class="max-w-lg block focus:ring-blue-500 focus:border-blue-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                <option>Select Category</option>
                <option>Category One</option>
                <option>Category Two</option>
                <option>Category Three</option>
                <option>Category Four</option>
              </select>
            </div>
          </div>

          <div class="py-12 pb-4">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
              Location &amp; Deadline
            </h3>
          </div>

          <!--Deadline Date -->
          <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
            <label for="deadline-date" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
              Deadline Date
            </label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <input type="date" name="deadline-date" id="deadline-date" class="w-full block max-w-lg block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md" />
            </div>
          </div>

          <!--Deadline Date -->
          <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
            <label for="deadline-time" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
              Deadline Time
            </label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <input type="time" name="deadline-time" id="deadline-time" value="17:00" class="w-full block max-w-lg block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md" />
            </div>
          </div>

          <!-- Project Timezone -->
          <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pt-5">
            <label for="cat" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
              Location Timezone
            </label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <select id="cat" name="cat" autocomplete="cat" class="max-w-lg block focus:ring-blue-500 focus:border-blue-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                <option>Select Category</option>
                <option>Time One</option>
                <option>Time Two</option>
                <option>Time Three</option>
                <option>Time Four</option>
              </select>
            </div>
          </div>
          
          <!-- Project Category -->
          <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
            <label for="deadline" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
              Display Past Deadline
            </label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <select id="deadline" name="deadline" autocomplete="deadline" class="max-w-lg block focus:ring-blue-500 focus:border-blue-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                <option>Select Deadline</option>
                <option>30 Days</option>
                <option>60 Days</option>
                <option>90 Days</option>
              </select>
            </div>
          </div>

          <!-- Walkthrough Location -->
          <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
            <label for="walk-location" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
              Walkthrough?
            </label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <div class="flex items-center mb-3">
                <input id="push-everything" name="push-notifications" type="radio" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" />
                <label for="push-everything" class="ml-3 block text-sm font-medium text-gray-700">
                  Yes
                </label>
              </div>
            </div>
          </div>

          <div class="py-12 pb-4">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
              Files
            </h3>
          </div>


          <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
              <label for="username" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                RFP Files
              </label>

              <div class="mt-1 sm:mt-0 sm:col-span-2">
                <div class="max-w-lg flex rounded-md shadow-sm">
                  <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                    https://
                  </span>
                  <input type="text" name="username" id="username" autocomplete="username" class="flex-1 block w-full focus:ring-blue-500 focus:border-blue-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300" />
                </div>

                <div class="max-w-lg flex rounded-md shadow-sm mt-4">
                  <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                    https://
                  </span>
                  <input type="text" name="username" id="username" autocomplete="username" class="flex-1 block w-full focus:ring-blue-500 focus:border-blue-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300" />
                </div>

                <div class="max-w-lg flex rounded-md shadow-sm mt-4">
                  <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                    https://
                  </span>
                  <input type="text" name="username" id="username" autocomplete="username" class="flex-1 block w-full focus:ring-blue-500 focus:border-blue-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300" />
                </div>
                
                <div class="max-w-lg flex rounded-md shadow-sm mt-4">
                  <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                    https://
                  </span>
                  <input type="text" name="username" id="username" autocomplete="username" class="flex-1 block w-full focus:ring-blue-500 focus:border-blue-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300" />
                </div>

                <div class="max-w-lg flex rounded-md shadow-sm mt-4">
                  <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                    https://
                  </span>
                  <input type="text" name="username" id="username" autocomplete="username" class="flex-1 block w-full focus:ring-blue-500 focus:border-blue-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300" />
                </div>

              </div>
              
            </div>
          </div>



          <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
              <label for="username" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                Addendums Uploads
              </label>

              <div class="mt-1 sm:mt-0 sm:col-span-2">
                <div class="max-w-lg flex rounded-md shadow-sm">
                  <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                    https://
                  </span>
                  <input type="text" name="username" id="username" autocomplete="username" class="flex-1 block w-full focus:ring-blue-500 focus:border-blue-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300" />
                </div>

                <div class="max-w-lg flex rounded-md shadow-sm mt-4">
                  <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                    https://
                  </span>
                  <input type="text" name="username" id="username" autocomplete="username" class="flex-1 block w-full focus:ring-blue-500 focus:border-blue-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300" />
                </div>

                <div class="max-w-lg flex rounded-md shadow-sm mt-4">
                  <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                    https://
                  </span>
                  <input type="text" name="username" id="username" autocomplete="username" class="flex-1 block w-full focus:ring-blue-500 focus:border-blue-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300" />
                </div>
                
                <div class="max-w-lg flex rounded-md shadow-sm mt-4">
                  <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                    https://
                  </span>
                  <input type="text" name="username" id="username" autocomplete="username" class="flex-1 block w-full focus:ring-blue-500 focus:border-blue-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300" />
                </div>

                <div class="max-w-lg flex rounded-md shadow-sm mt-4">
                  <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                    https://
                  </span>
                  <input type="text" name="username" id="username" autocomplete="username" class="flex-1 block w-full focus:ring-blue-500 focus:border-blue-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300" />
                </div>

              </div>
              
            </div>
          </div>

          <!--Deadline Date -->
          <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
            <label for="deadline-date" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
              Schedule Project For Public View
            </label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
              <input type="date" name="deadline-date" id="deadline-date" class="w-full block max-w-lg block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md" />
            </div>
          </div>


        </div>
      </div>
    </div>

    <div class="pt-5">
      <div class="flex justify-end items-center">
        <span class="text-sm text-gray-500 mr-4">Last Updated 08/24/2021 at 6:05pm</span>
        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 border-1 border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          Save Project
        </button>
        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          Save &amp; Email
        </button>
      </div>
    </div>
  </form>
</template>
