import {defineStore} from 'pinia'

export const useRecentlyViewedStore = defineStore("recentlyViewed", {
    state: () => ({
        views:{
            data:[],
            links:{},
            meta:{}
        },
        route:"project/viewed"
    }),
    getters: {
        getViews(state){
            return state.views
        }
    },
    actions: {
        async fetchViews() {
            try {
                const body = await axios.get(this.route);
                this.views = body.data
            }
            catch (error) {
                console.log(error)
            }
        },
        setViews(data){
            this.views = data;
        },
    },
})
