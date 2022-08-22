<template>
    <div class="container-fluid alert">
        <a class="nav-link dropdown-toggle d-inline mb-5" href="#" id="navbarDarkDropdownMenuLink"
           role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ translate.add_language }}
        </a>

        <ul class="dropdown-menu dropdown-menu-dark"
            aria-labelledby="navbarDarkDropdownMenuLink" id="lang-menu">
            <li v-for="lang in languages" :id="lang.id" class="dropdown-item p-0">
                <a @click="addLang(lang.id)"
                   class="d-block p-2 text-white text-decoration-none">{{ lang['title_' + locale] }}</a>
            </li>

        </ul>

        <div v-for="myLang in mylangs" :id="myLang.id" class="d-inline lang-list">
            <span>{{ myLang['title_' + locale] }}<i @click="removeLang(myLang.id)">X</i></span>
        </div>
    </div>
</template>

<script>
export default {
    name: "Languages",
    props: {
        languages: {
            type: Array
        },
        myLanguages: {
            type: Array
        },
        locale: {
            type: String
        },
        translate: {
            type: Object
        }

    },
    data() {
        return {
            mylangs : []
        }
    },
    beforeMount() {
        this.mylangs = this.myLanguages
    },
    methods: {
        async addLang(lang_id) {
            let data = {
                id : lang_id
            }
            await axios.post('/' + this.locale + '/languser', data)
                .then(response => {
                    console.log(response)
                    this.mylangs = response.data
                })
        },

        async removeLang(lang_id) {
            let data = {
                _method: 'delete',
            }
            await axios.post('/' + this.locale + '/languser/' + lang_id, data)
                .then(response => {
                    this.mylangs = response.data
                    console.log(response)
                })
        }
    }
}
</script>

<style scoped>

</style>
