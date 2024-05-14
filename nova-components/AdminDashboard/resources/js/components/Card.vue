<template>
  <div class="flex justify-center items-centers">
    <div class="w-full max-w-xl">
      <heading class="flex mb-3">Welcome Back!</heading>
      <p class="text-90 leading-tight mb-8">
        
      </p>

      <card>
        <table class="w-full" cellpadding="0" cellspacing="0">
          <tr>
            <td class="align-top w-1/2 border-r border-b border-50">
              <a :href="projects" class="no-underline dim flex p-6">
                <div class="flex justify-center w-11 flex-no-shrink mr-6">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="40"
                    height="40"
                    viewBox="0 0 40 40"
                  >
                    <path
                      fill="var(--primary)"
                      d="M31.51 25.86l7.32 7.31c1.0110617 1.0110616 1.4059262 2.4847161 1.035852 3.865852-.3700742 1.3811359-1.4488641 2.4599258-2.83 2.83-1.3811359.3700742-2.8547904-.0247903-3.865852-1.035852l-7.31-7.32c-7.3497931 4.4833975-16.89094893 2.7645226-22.21403734-4.0019419-5.3230884-6.7664645-4.74742381-16.4441086 1.34028151-22.53181393C11.0739495-1.11146115 20.7515936-1.68712574 27.5180581 3.63596266 34.2845226 8.95905107 36.0033975 18.5002069 31.52 25.85l-.01.01zm-3.99 4.5l7.07 7.05c.7935206.6795536 1.9763883.6338645 2.7151264-.1048736.7387381-.7387381.7844272-1.9216058.1048736-2.7151264l-7.06-7.07c-.8293081 1.0508547-1.7791453 2.0006919-2.83 2.83v.01zM17 32c8.2842712 0 15-6.7157288 15-15 0-8.28427125-6.7157288-15-15-15C8.71572875 2 2 8.71572875 2 17c0 8.2842712 6.71572875 15 15 15zm0-2C9.82029825 30 4 24.1797017 4 17S9.82029825 4 17 4c7.1797017 0 13 5.8202983 13 13s-5.8202983 13-13 13zm0-2c6.0751322 0 11-4.9248678 11-11S23.0751322 6 17 6 6 10.9248678 6 17s4.9248678 11 11 11z"
                    />
                  </svg>
                </div>

                <div>
                  <heading :level="3" class="mb-3">Search Projects</heading>
                  <p class="text-90 leading-normal">
                    Click here to search through all projects.
                  </p>
                </div>
              </a>
            </td>

            <td class="align-top w-1/2 border-b border-50">
              <a :href="projectAdd" class="no-underline dim flex p-6">
                <div class="flex justify-center w-11 flex-no-shrink mr-6">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="-2 0 26 26" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4v16m8-8H4" />
                    </svg>
                </div>

                <div>
                  <heading :level="3" class="mb-3">Add Project</heading>
                  <p class="text-90 leading-normal">
                    Click here to add a new project.
                  </p>
                </div>
              </a>
            </td>
          </tr>

          <tr>
            <td class="align-top w-1/2 border-r border-b border-50">
              <a :href="clients" class="no-underline dim flex p-6">
                <div class="flex justify-center w-11 flex-no-shrink mr-6">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="-2 0 26 26" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>

                <div>
                  <heading :level="3" class="mb-3">View All Clients</heading>
                  <p class="text-90 leading-normal">
                    Click here to view all clients.
                  </p>
                </div>
              </a>
            </td>
            <td class="align-top w-1/2 border-b border-50">
              <a :href="clientAdd" class="no-underline dim flex p-6">
                <div class="flex justify-center w-11 flex-no-shrink mr-6">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="-2 0 26 26" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>

                <div>
                  <heading :level="3" class="mb-3">Add New Client</heading>
                  <p class="text-90 leading-normal">
                    Click here to add a new client.
                  </p>
                </div>
              </a>
            </td>
          </tr>

          <tr>
            <td class="align-top w-1/2 border-r border-b border-50">
              <a :href="vendors" class="no-underline dim flex p-6">
                <div class="flex justify-center w-11 flex-no-shrink mr-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="-2 0 26 26" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>

                <div>
                  <heading :level="3" class="mb-3">View All Vendors</heading>
                  <p class="text-90 leading-normal">
                    Click here to view all vendors.
                  </p>
                </div>
              </a>
            </td>
            
            <td class="align-top w-1/2 border-b border-50">
              <a :href="vendorAdd" class="no-underline dim flex p-6">
                <div class="flex justify-center w-11 flex-no-shrink mr-6">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="-2 0 26 26" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>

                <div>
                  <heading :level="3" class="mb-3">Add New Vendor</heading>
                  <p class="text-90 leading-normal">
                    Click here to add a new vendor.
                  </p>
                </div>
              </a>
            </td>
          </tr>
        </table>
      </card>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SuperAdminDashboard',

  props: [
    "card"
  ],

  mounted() {
  //
  },
  
  methods: {
    link(path) {
      return `/users/resources/${path}`
    },
  },

  computed: {
    projects() {
      return this.link('projects')
    },
    projectAdd() {
      return this.link('projects/new')
    },
    clients() {
      return this.link('clients')
    },
    clientAdd() {
      return this.link('clients/new')
    },
    vendors() {
      return this.link('vendors')
    },
    vendorAdd() {
      return this.link('vendors/new')
    },
  },
}
</script>
