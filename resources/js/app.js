require('./bootstrap');

require('alpinejs');

import { createApp } from 'vue'
import App from '@/App.vue'
import router from "@/routes"
import axios from 'axios'
import Vuex from 'vuex'
import store from './store'
import Pagination from '@/components/Pagination';
import Loader from '@/components/Loader';
import ShimmerTableLoader from '@/components/ShimmerTableLoader';
import { createPinia } from "pinia";
import moment from "moment-timezone";
import VueTelInput from 'vue-tel-input';
import 'vue-tel-input/dist/vue-tel-input.css';

const globalOptions = {
    mode: 'national',
    onlyCountries:['US'],
    // validCharactersOnly:true,
    defaultCountry:'US',
    inputOptions:{
        maxlength:10,
    },
    wrapperClasses:"block max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"
};

const app = createApp(App)

app.directive('mask', {
    created(el, binding) {
        var mask = binding.value,
            first = mask.indexOf('_'),
            fieldsL = mask.replace(/[^_]/gm, '').length,
            clean = mask.replace(/[^0-9_]/gm, ''),
            indexes = []

        for(var i = 0; i < clean.length; i++){
            if(!isNaN(clean[i])){
                indexes.push(i)
            }
        }

        el.value = mask
        el.clean = mask.replace(/[^0-9]/gm, '')

        function maskIt(event, start){
            var value = el.value,
                filtred = value.replace(/[^0-9]/gm, ''),
                result = ''

            if(value.length < first){
                value = mask + value
                filtred = value.replace(/[^0-9]/gm, '')
            }

            for(var i = 0; i < filtred.length; i++){
                if(indexes.indexOf(i) == -1){
                    result += filtred[i]
                }
            }

            value = ''
            var cursor = 0

            for(var i = 0; i < mask.length; i++){
                if(mask[i] == '_' && result){
                    value += result[0]
                    result = result.slice(1)
                    cursor = i + 1

                }else{
                    value += mask[i]
                }
            }

            if(cursor < first){
                cursor = first
            }

            el.value = value

            el.clean = el.value.replace(/[^0-9]/gm, '')

            el.setSelectionRange(cursor,cursor)
        }

        el.addEventListener('focus', function(event){
            event.preventDefault()
            var start = el.selectionStart
            maskIt(event, start)

        })

        el.addEventListener('click', function(event){
            event.preventDefault()
            var start = el.value.indexOf('_')

            if(start == -1){
                start = el.value.length
            }

            el.setSelectionRange(start,start)

        })

        el.addEventListener('paste', function(event){
            var start = el.selectionStart

            if(start < first){
                el.value = '_' + el.value
            }
        })

        // el.addEventListener('change', function(event){
        //     var start = el.selectionStart
        //
        //     if(start < first){
        //         el.value = '_' + el.value
        //     }
        // })

        el.addEventListener('input', function(event){
            var start = el.selectionStart
            maskIt(event, start)
        })

    },
    updated(el,binding,vnode,prevVnode){
        var mask = binding.value,
            first = mask.indexOf('_'),
            fieldsL = mask.replace(/[^_]/gm, '').length,
            clean = mask.replace(/[^0-9_]/gm, ''),
            indexes = [];
        var start = el.selectionStart
        function maskIt(event, start){
            var value = el.value,
                filtred = value.replace(/[^0-9]/gm, ''),
                result = ''

            if(value.length < first){
                value = mask + value
                filtred = value.replace(/[^0-9]/gm, '')
            }

            for(var i = 0; i < filtred.length; i++){
                if(indexes.indexOf(i) == -1){
                    result += filtred[i]
                }
            }

            value = ''
            var cursor = 0

            for(var i = 0; i < mask.length; i++){
                if(mask[i] == '_' && result){
                    value += result[0]
                    result = result.slice(1)
                    cursor = i + 1

                }else{
                    value += mask[i]
                }
            }

            if(cursor < first){
                cursor = first
            }

            el.value = value

            el.clean = el.value.replace(/[^0-9]/gm, '')

            el.setSelectionRange(cursor,cursor)
        }

        maskIt(event, start)

    }
});

app.use(VueTelInput, globalOptions)
app.config.globalProperties.$axios = axios;

app.component('Pagination',Pagination);
app.component('Loader',Loader);
app.component('ShimmerTableLoader',ShimmerTableLoader);
app.use(router);
app.use(store);
app.use(Vuex);
app.use(createPinia());

app.mixin({
    methods:{
        async downloadItem ({ url, label }) {
            this.$axios.get(url, { responseType: 'blob' })
                .then(response => {
                    const blob = new Blob([response.data], { type: response.headers["content-type"] })
                    const link = document.createElement('a')
                    link.href = URL.createObjectURL(blob)
                    link.download = label
                    link.click()
                    URL.revokeObjectURL(link.href)
                }).catch(console.error)
        },
        getFormattedTime(value,timeZone =null){
            if (timeZone !== null){
                return moment(value).tz(timeZone).format("MMMM Do YYYY, h:mm:ss A z");
            }
            return moment(value).tz(moment.tz.guess()).format("MMMM Do YYYY, h:mm:ss A z")
        }
    },
    directives:{

    }
})
app.mount('#app')
