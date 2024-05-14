import {defineStore} from 'pinia'
import axios from "axios"

export const useProjectQuestionStore = defineStore("ProjectQuestion", {
    state: () => ({
        questions: [],
        route: "project/question",
        questionFormData:{
            project_id:0,
            question:""
        }
    }),
    getters: {
        getQuestions(state) {
            return state.questions
        }
    },
    actions: {
        async fetchQuestion() {
            try {
                const data = await axios.get(this.route);
                this.questions = data.data
            } catch (error) {

                console.log(error)
            }
        },
        async fetchProjectQuestion(ProjectId) {
            try {
                const data = await axios.get(this.route+"/"+ProjectId);
                this.questions = data.data
            } catch (error) {

                console.log(error)
            }
        },
        async submitQuestion() {
            try {
                 await axios.post(this.route,this.questionFormData).then((response) => {
                     this.questions.data = [...this.questions.data,response.data.data];
                });
            } catch (error) {

                console.log(error)
            }
        }
        ,
        setQuestion(data) {
            this.questions = data;
        },
        setQuestionFormData(question,project_id){
            this.questionFormData.question = question;
            this.questionFormData.project_id = project_id;
        }
    },
})
