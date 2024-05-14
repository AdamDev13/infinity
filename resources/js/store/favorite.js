import {defineStore} from 'pinia'
// import axios from "axios"

export const useFavoriteStore = defineStore("favorite", {
    state: () => ({
        projects:[],
        route:"project/favorite"
    }),
    getters: {
        getProjects(state){
            return state.projects
        }
    },
    actions: {
        async fetchProject() {
            try {
                const data = await axios.get(this.route);
                this.projects = data.data
            }
            catch (error) {

                console.log(error)
            }
        },
        setProject(data){
            this.projects = data;
        },
        async favorite(ProjectId){
            try {
                const data = await axios.post('project/'+ProjectId+'/favorite');
            }
            catch (error) {

                console.log(error)
            }
        },
        async unfavorite(ProjectId){
            try {
                // TODO use baseurl
                const data = await axios.post('project/'+ProjectId+'/unfavorite');
                if (data.unfavorite){
                    this.projects.remove(p => p.id === ProjectId);
                }
            }
            catch (error) {

                console.log(error)
            }
        }


    },
})
