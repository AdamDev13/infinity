<template>
    <div class="example-drag">
        <div class="upload">

            <div class="max-w-lg flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                <ul class="file-uploads-preview flex" v-if="files.length">
                    <li v-for="file in files" :key="file.id">
                        <div v-if="file.type.toString().includes('image')">
                            <img :src="file.url" alt="file.name" :alt="file.name">
                        </div>
                        <div v-else-if="/\.pdf$/i.test(file.name)">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/PDF_file_icon.svg/1667px-PDF_file_icon.svg.png" :alt="file.name">
                        </div>
                        <button class="remove-bottom-border" @click.prevent="remove(file)" type="button">x</button>
                        <!--                        <span>{{file.name}}</span> - -->
                        <!--                    <span>{{$formatSize(file.size)}}</span> - -->
                        <!--                        <span v-if="file.error">{{file.error}}</span>-->
                        <!--                        <span v-else-if="file.success">success</span>-->
                        <!--                        <span v-else-if="file.active">active</span>-->
                        <!--                        <span v-else></span>-->
                    </li>
                </ul>
                <div v-else class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400"
                         stroke="currentColor" fill="none" viewBox="0 0 48 48"
                         aria-hidden="true">
                        <path
                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                            stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                    <div class="flex text-sm text-gray-600">

                        <label for="file"
                               class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                            Select a file
                        </label>
                        <h4 class="pl-1">Or Drop files anywhere to upload</h4>
                        <!--                        <label for="file-upload"-->
                        <!--                               class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">-->
                        <!--                            <span @Click="open()">Upload a file</span>-->
                        <!--                            <input id="file-upload"-->
                        <!--                                   name="file-upload"-->
                        <!--                                   type="file" class="sr-only">-->
                        <!--                        </label>-->
                        <!--                        <p class="pl-1">or drag and drop</p>-->
                    </div>
                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                </div>
            </div>
            <!--            <ul v-else>-->
            <!--                <td colspan="7">-->
            <!--                    <div class="text-center p-5">-->
            <!--                        <h4>Drop files anywhere to upload<br/>or</h4>-->
            <!--                        <label for="file" class="btn btn-lg btn-primary">Select Files</label>-->
            <!--                    </div>-->
            <!--                </td>-->
            <!--            </ul>-->

            <div v-show="$refs.upload && $refs.upload.dropActive" class="drop-active">
                <h3>Drop files to upload</h3>
            </div>

            <div class="example-btn">
                <file-upload
                    class="btn btn-primary"
                    :multiple="multiple"
                    :drop="true"
                    :drop-directory="false"
                    v-model="this.files"
                    ref="upload"
                    @input-filter="inputFilter"
                >

                    <!--                    <i class="fa fa-plus"></i>-->
                    <!--                    Select files-->
                </file-upload>
                <!--                <button type="button" class="btn btn-success" v-if="!$refs.upload || !$refs.upload.active" @click.prevent="$refs.upload.active = true">-->
                <!--                    <i class="fa fa-arrow-up" aria-hidden="true"></i>-->
                <!--                    Start Upload-->
                <!--                </button>-->
                <!--                <button type="button" class="btn btn-danger"  v-else @click.prevent="$refs.upload.active = false">-->
                <!--                    <i class="fa fa-stop" aria-hidden="true"></i>-->
                <!--                    Stop Upload-->
                <!--                </button>-->
            </div>
            <p class="text-xs mt-2 block font-medium text-gray-400">File upload limited to 5 files and 99MB.  Please zip or combine files if you need to upload additional files. Excel file uploads with macros, please zip prior to uploading or data will be lost</p>
        </div>
    </div>
</template>
<script>
import FileUpload from 'vue-upload-component'

export default {
    components: {
        FileUpload,
    },
    props:{
        multiple:Boolean
    },
    data() {
        return {
            files: [],
            multiple:true
        }
    },
    watch: {
        files: {
            handler(val, oldVal) {
                this.$emit('handleFileUpload', val);
            },
            deep: true
        }
    },
    methods: {
        remove(file) {
            this.$refs.upload.remove(file)
        },
        inputFilter(newFile, oldFile, prevent) {
            if (newFile && !oldFile) {
                if (!/\.(gif|jpg|jpeg|png|webp)$/i.test(newFile.name)) {
                    // alert('Your choice is not a picture')
                    newFile.url = "https://upload.wikimedia.org/wikipedia/commons/thumb/8/87/PDF_file_icon.svg/1667px-PDF_file_icon.svg.png";
                }else {
                    newFile.url = ''
                    let URL = window.URL || window.webkitURL
                    if (URL && URL.createObjectURL) {
                        newFile.url = URL.createObjectURL(newFile.file)
                    }
                }
            }
            // if (newFile && (!oldFile || newFile.file !== oldFile.file)) {
            //     newFile.url = ''
            //     let URL = window.URL || window.webkitURL
            //     if (URL && URL.createObjectURL) {
            //         newFile.url = URL.createObjectURL(newFile.file)
            //     }
            // }
        }
    }
}
</script>
