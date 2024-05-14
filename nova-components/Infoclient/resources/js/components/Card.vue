<template>
    <card class="flex flex-col items-center justify-center">
        <div class="px-3 py-3">
            <h1 class="text-center text-3xl text-80 font-light">Info Client - Cool Man!</h1>
            <h2>Client: {{this.card.currentClient}}</h2>
        </div>
    </card>
</template>

<script>
export default {
    props: [
        'card',

        // The following props are only available on resource detail cards...
        // 'resource',
        // 'resourceId',
        // 'resourceName',
    ],

    mounted() {
//        console.log(this);
        console.log(this.card.currentClient);
    },
}

</script>
