import {defineStore} from 'pinia'
import axios from "axios"

export const useProjectStore = defineStore("project", {
    state: () => ({
        project:{},
        route:"project"
    }),
    getters: {
        getProject(state){
            return state.project;
        },
        getCategory(state){
            return state.project.category
        },
        getRfpfile(state){
            return state.project.projectrfpfile;
        },
        getAddendum(state){
            return state.project.projectaddendum;
        }
    },
    actions: {
        async fetchProject(id) {
            try {
                const body = await axios.get(this.route + "/" + id);
                this.project = body.data.data;
            }
            catch (error) {

                console.log(error)
            }
        },
        setProject(data){
            this.project = data;
        },
        removeBid(){
            this.project.bids.pop();
        },
        addBid(bid){
            this.project.bids.push(bid);
        }
    },
})
