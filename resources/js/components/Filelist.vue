<script setup>
import {PaperClipIcon} from '@heroicons/vue/solid'

</script>
<script>
import {PaperClipIcon} from "@heroicons/vue/solid";

export default {
    props:['files'],
    components: {
        PaperClipIcon,
    }

}
</script>
<template>
    <ul role="list" class="border border-gray-200 rounded-md divide-y divide-gray-200">
    <li v-for="(file, index) in files" :key="index" class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
        <div class="w-0 flex-1 flex items-center">
            <PaperClipIcon class="flex-shrink-0 h-5 w-5 text-gray-400" aria-hidden="true"/>
            <span class="ml-2 flex-1 w-0 truncate">
                    {{ file.label }}
                  </span>
        </div>
        <div class="ml-4 flex-shrink-0">
            <a :href="file.url" target="_blank" class="font-medium text-gray-500 hover:text-indigo-500 mr-4">
                View
            </a>
            <a @click="downloadItem(file)" class="font-medium text-indigo-600 cursor-pointer hover:text-indigo-500">
                Download
            </a>
        </div>
    </li>
    </ul>
</template>

