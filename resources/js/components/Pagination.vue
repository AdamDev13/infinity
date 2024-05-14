<template>
    <nav class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6"
         aria-label="Pagination">

        <div class="hidden sm:block">
            <p class="text-xs text-gray-700">
                Showing
                {{ ' ' }}
                <span class="font-medium">{{ meta.from }}</span>
                {{ ' ' }}
                to
                {{ ' ' }}
                <span class="font-medium">{{ meta.to }}</span>
                {{ ' ' }}
                of
                {{ ' ' }}
                <span class="font-medium">{{ meta.total }}</span>
                {{ ' ' }}
                results
            </p>
        </div>
        <div class="flex-1 flex justify-between sm:justify-end">
            <LaravelVuePagination :data="data"  @pagination-change-page="getResults" :limit="-1" class="flex-1 flex justify-between sm:justify-end">
                <template #prev-nav>
                    <a href="#"
                       class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Previous
                    </a>
                    <!--                                    <span>&lt; Previous</span>-->
                </template>
                <template #next-nav>
                    <a href="#"
                       class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Next
                    </a>
                </template>
            </LaravelVuePagination>
        </div>
    </nav>
</template>
<script>
import LaravelVuePagination from 'laravel-vue-pagination';
export default {
    components: {
        'LaravelVuePagination': LaravelVuePagination
    },
    props:['route','data','meta'],
    methods: {
        // Our method to GET results from a Laravel endpoint
        getResults(page = 1) {

            let url = "";
            if (this.route.includes("?")){
                url = this.route+"&page="+page;
            }else {
                url = this.route+"?page="+page;
            }

            axios.get(url)
                .then(response => {
                    this.$emit('updateParentData',response.data);
                });
        }
    }
}
</script>
