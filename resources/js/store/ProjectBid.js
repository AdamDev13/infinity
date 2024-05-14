import {defineStore} from 'pinia'
import axios from "axios"

export const useProjectBidStore = defineStore("projectBids", {
    state: () => ({
        bids: [],
        route: "bid-submissions"
    }),
    getters: {
        getBids(state) {
            return state.bids
        }
    },
    actions: {
        async fetchBids() {
            try {
                const body = await axios.get(this.route);
                this.bids = body.data
            } catch (error) {

                console.log(error)
            }
        },
        async storeBids(formData) {
            const config = {
                headers: {
                    "content-type": "multipart/form-data; boundary=<calculated when request is sent>"
                }
            };

            return await axios.post(this.route, formData, config).then(response => {
                if (response.status) {
                    return response.data.bid;
                }
            });
        },
        async withDraw(formData) {
            try {
                return await axios.post(this.route + '/withdraw', formData).then(response => {
                    if (response.status === 200) {
                        return response.data.status;
                    }
                });
            } catch (error) {
                console.log(error)
            }
        },

        setBids(data) {
            this.bids = data;
        },
    },
})
