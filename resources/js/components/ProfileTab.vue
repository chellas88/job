<template>
    <div>
        <div class="alert alert-success" v-show="success">{{ translate.data_saved_success }}</div>
        <input type="text" :value="userCategory['title_' + locale]" class="form-control" disabled>


        <select class="my-2" v-model="currentLanguage">
            <option v-for="lang in userLanguages" :id="lang.id" :value="lang.key">{{ lang['title_' + locale] }}</option>
        </select>
        <div v-for="lang in userLanguages" v-show="(currentLanguage == lang.key) ? true : false">
            <ckeditor :editor="editor" :config="editorConfig" v-model="form.descriptions[lang.key]"></ckeditor>
        </div>
        <button @click="save" class="btn btn-secondary my-3">{{ translate.save }}</button>
        <!--        <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>-->
    </div>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

export default {
    props: {
        userServices: {
            type: Array
        },
        userCategory: {
            type: Object
        },
        locale: {
            type: String
        },
        services: {
            type: Array
        },
        translate: {
            type: Object
        },
        userLanguages: {
            type: Array
        },
        userInfo: {
            type: Object
        }

    },
    data() {
        return {
            editor: ClassicEditor,
            // editorData: '<p>Content of the editor.</p>',
            editorConfig: {
                // height: '600px',
                // autoGrow_onStartup : true
            },
            form: {
                descriptions: {}
            },
            sa: Array,
            currentLanguage: '',
            success: false
        }
    },
    mounted() {
        // this.currentLanguage = userLanguages[0]['key']

        this.userLanguages.forEach(item => {
            this.form.descriptions[item.key] = this.userInfo['description_' + item.key]
        })
        this.currentLanguage = this.$props.userLanguages[0]['key']
    },
    methods: {
         async save(){
             let data = {}
             for (let item in this.form.descriptions){
                 data[`description_${item}`] = this.form.descriptions[item]
             }
             await axios.post('/en/saveDescriptions', data)
                .then(response => {
                    if (response.data){
                        this.success = true
                        let th = this
                        setTimeout(function(){
                            th.success = false
                        }, 3000)
                    }
                })
                .catch(err => {
                    console.log(err)
                })
        }
    }
}
</script>

<style scoped>

</style>
