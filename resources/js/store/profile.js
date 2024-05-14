import {defineStore} from 'pinia'
import axios from "axios"

export const useProfileStore = defineStore("Profile", {

    state: () => ({
        user:{},
        states:{},
        county:{},
        route:"/profile"
    }),
    getters: {
        getProfile(state){
            return state.user
        }
    },
    actions: {
       async fetchProfile(){
           try {
               await axios.get(this.route).then((response) => {
                   this.user = response.data.user;
                   this.states = response.data.states;
                   this.county = response.data.country;
               });
           }catch (e){
               console.log(e.message);
           }
       },
        async UpdateProfile(data){
            data.phone_number = data.phone_number.replace(/[^0-9]/gm, '');
            if (data.fax_number !== null){
                data.fax_number = data.fax_number.replace(/[^0-9]/gm, '');
            }
            try {
                await axios.post(this.route,data).then((response) => {
                    this.user = response.data.user;
                });
            }catch (e){
                console.log(e.message);
            }
        },
        async resetPassword(data){
            try {
                await axios.post("/reset_password",data).then((response) => {

                });
            }catch (e){
                console.log(e.message);
            }
        }
    }
});
