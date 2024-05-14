<template>
    <div class="flex flex-col mb-8">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-5 text-left text-sm font-medium text-gray-500">
                                Submission Date
                            </th>
                            <th scope="col" class="px-6 py-5 text-left text-sm font-medium text-gray-500">
                                File Downloads
                            </th>
                            <th scope="col" class="px-6 py-5 text-left text-sm font-medium text-gray-500">
                                Bid Status
                            </th>

                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Withdraw Bid</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-for="(bid, index) in bids" :key="index">
                            <tr
                                :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-50'">
                                <td v-if="bid.status !== 'L' "
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                    {{ getFormattedTime(bid.submission_date)}}
                                </td>
                                <td v-else class="px-6 py-4 whitespace-nowrap text-sm text-red-500 font-medium">
                                    {{ getFormattedTime(bid.submission_date)}}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm cursor-pointer text-gray-500 flex gap-2 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                    </svg>
                                    <a v-text="bid.label" @click="downloadItem(bid)"
                                       class="font-medium text-indigo-600 hover:text-indigo-500"></a>
                                </td>
                                <td v-if="bid.is_withdraw === 0"
                                    class="px-6 py-4 whitespace-nowrap text-xs text-white font-medium">
                                    <span class="bg-indigo-600 py-2 px-4 rounded-full">Active Bid</span>
                                </td>
                                <td v-else class="px-6 py-4 whitespace-nowrap text-xs text-gray-600 font-medium">
                                    <span class="bg-gray-200 py-2 px-4 rounded-full">Withdrawn</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" @click="open(bid.id)"
                                       class="bg-white border border-gray-100 hover:bg-indigo-600 text-gray-700 hover:text-white px-3 py-2 rounded-md text-sm">Withdraw
                                        Bid</a>
                                </td>
                            </tr>
                            <tr v-if="bid.attachments">
                                <td colspan="4">
                                     <Filelist :files="bid.attachments"/>
                                </td>
                            </tr>

                        </template>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <Teleport to="body">
        <!-- use the modal component, pass in the prop -->
        <modal :show="showModal" @close="close">
            <template #header>
                <div>
                    <h3 style="display: inline">WidthDraw Bid</h3>
                    <button type="button" style="float: right" class="me-auto bg-warning btn-block btn-danger"
                            @click="close">x
                    </button>

                </div>


            </template>
            <template #body>
                <p>Do you really want to withdraw this project bid ?</p>
            </template>
            <template #footer>
                <div>
                    <button @click="widthDraw" :disabled="processing"
                            class=" bg-white border flex border-gray-100 bg-indigo-600 text-gray-700 text-white px-3 py-2 rounded-md text-sm">
                        <Loader :processing="processing"></Loader>
                        {{ processing ? 'Processing...' : "Submit" }}
                    </button>

                </div>


            </template>
        </modal>
    </Teleport>
</template>

<script>


import Modal from "./Modal";
import {useProjectBidStore} from "../store/ProjectBid";
import {useProjectStore} from "../store/project";
import Filelist from "./Filelist";

export default {
    components: {
        Modal,
        Filelist
    },
    props: ['bids'],
    setup() {
        const store = useProjectBidStore();
        const projectStore = useProjectStore();
        return {
            store,
            projectStore
        }
    },
    data() {
        return {
            showModal: false,
            bidId: 0,
            processing: false
        }
    },
    methods: {
        close() {
            this.showModal = false;
        },
        async widthDraw() {
            let fromData = new FormData();
            fromData.append('project_bid_id', this.bidId);
            this.processing = true;
            await this.store.withDraw(fromData).then(result => {
                if (result) {
                    this.removeBid();
                }
            }).finally(() => {
                this.processing = false;
            });
            this.close();
        },
        open(bidId) {
            this.bidId = bidId;
            this.showModal = true
        },
        removeBid() {
            this.projectStore.removeBid();
        }
    }
}
</script>
