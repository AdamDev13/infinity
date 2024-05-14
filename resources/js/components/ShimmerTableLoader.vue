<template>
    <tbody v-show="processing" class=" animate-pulse">
    <tr class="h-2.5"  v-for="row in rows" :key="row">
        <td  v-for="col in cols" :key="col" class="py-3 bg-gray-200 rounded-full dark:bg-gray-700 w-32"></td>
    </tr>

    </tbody>
</template>


<script>
export default {
    name: 'ShimmerTableLoader',
    props: {
        processing: Boolean,
        cols:Number,
        rows:Number,
    }
}
</script>
