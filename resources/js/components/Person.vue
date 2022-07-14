<template>
    <div class="container">
        <form method="POST">
            <input type="hidden" :value="csrf" name="_token">
            <div class="row">

                <div class="col-12 mb-3">
                    <label for="avatar">Фото</label>
                    <input type="file" id="avatar" name="avatar" class="form-control">
                </div>
                <div class="col-4 mb-3">
                    <label for="name">Имя</label>
                    <input type="text" class="form-control" v-model="form.name" required>
                </div>
                <div class="col-4 mb-3">
                    <label for="surname">Фамилия</label>
                    <input type="text" class="form-control" v-model="form.surname" required>
                </div>
                <div class="col-4"></div>
                <div class="col-4 mb-3">
                    <label for="country">Страна</label>
                    <select id="country" class="form-control" v-model="form.country_id" required>
                        <option value="">Выберите страну</option>
                        <option v-for="country in countries" :id="country.id" :value="country.id">{{ country.title_ru }}</option>
                    </select>
                </div>
                <div class="col-4">
                    <label for="city">Город</label>
                    <input id="city" v-model="form.city" class="form-control" required>
                </div>
                <div class="col-4">
                    <label for="address">Адрес</label>
                    <input id="address" v-model="form.address" class="form-control" required>
                </div>
                <div class="col-4 mb-3">
                    <label>Направление</label>
                    <select class="form-control" v-model="form.category_id" @change="changeCategory" required>
                        <option value="" disabled selected>Выберите направление</option>
                        <option v-for="category in this.$parent.professions" :id="category.id" :value="category.id">{{ category.title_ru }}</option>
                    </select>
                </div>
                <div class="col-8"></div>
                <div class="col-4" v-if="form.category_id">
                    <label>Профессия 1</label>
                    <select v-model="form.profession_1" class="form-control">
                        <option value="" selected>Выберите профессию</option>
                        <option v-for="profession in professions" :id="profession.id" :value="profession.id">{{ profession.title_ru }}</option>
                    </select>
                </div>
                <div class="col-4" v-if="form.category_id">
                    <label>Профессия 2</label>
                    <select v-model="form.profession_2" class="form-control">
                        <option value="" selected>Выберите профессию</option>
                        <option v-for="profession in professions" :id="profession.id" :value="profession.id">{{ profession.title_ru }}</option>
                    </select>
                </div>
                <div class="col-4 mb-3" v-if="form.category_id">
                    <label>Профессия 3</label>
                    <select v-model="form.profession_3" class="form-control">
                        <option value="" selected>Выберите профессию</option>
                        <option v-for="profession in professions" :id="profession.id" :value="profession.id">{{ profession.title_ru }}</option>
                    </select>
                </div>

                <div class="col-4 mb-3">
                    <label>Язык</label>
                    <select v-model="form.lang_1" class="form-control" ref="lang_1" @change="selectLang">
                        <option value="" selected>Выберите язык</option>
                        <option v-for="lang in this.$parent.langs" :id="lang.key" :value="lang.id">{{ lang.title_ru }}</option>
                    </select>
                </div>
                <div class="col-4 mb-3">
                    <label>Второй язык</label>
                    <select v-model="form.lang_2" class="form-control" ref="lang_2" @change="selectLang">
                        <option value="" selected>Выберите язык</option>
                        <option v-for="lang in this.$parent.langs" :id="lang.key" :value="lang.id">{{ lang.title_ru }}</option>
                    </select>
                </div>
                <div class="col-4 mb-3">
                    <label>Третий язык</label>
                    <select v-model="form.lang_3" class="form-control" ref="lang_3" @change="selectLang">
                        <option value="" selected>Выберите язык</option>
                        <option v-for="lang in this.$parent.langs" :id="lang.key" :value="lang.id">{{ lang.title_ru }}</option>
                    </select>
                </div>

                <div class="col-12 mb-3" v-if="desc_1">
                    <label>{{ l_desc_1 }}</label>
                    <textarea class="form-control" ref="desc_1" v-model="form.descriptions[0].value"></textarea>
                </div>

                <div class="col-12 mb-3" v-if="desc_2">
                    <label>{{ l_desc_2 }}</label>
                    <textarea class="form-control" ref="desc_2" v-model="form.descriptions[1].value"></textarea>
                </div>

                <div class="col-12 mb-3" v-if="desc_3">
                    <label>{{ l_desc_3 }}</label>
                    <textarea class="form-control" ref="desc_3" v-model="form.descriptions[2].value"></textarea>
                </div>


            </div>
        </form>

    </div>
</template>

<script>
export default {
    name: "Person",
    props: {
        countries: {
            type: Array
        }
    },
    data() {
        return {
            csrf: document.head.querySelector('meta[name="csrf-token"]').content,
            form: {
                role: this.$parent.role,
                country_id: '',
                category_id: '',
                profession_1: '',
                profession_2: '',
                profession_3: '',
                lang_1: '',
                lang_2: '',
                lang_3: '',
                descriptions: [
                    {
                        lang: '',
                        value: ''
                    },
                    {
                        lang: '',
                        value: ''
                    },
                    {
                        lang: '',
                        value: ''
                    },
                ]
            },
            l_desc_1: 'Описание',
            l_desc_2: 'Описание',
            l_desc_3: 'Описание',
            desc_1: false,
            desc_2: false,
            desc_3: false,
            professions: [],
            selectedLangs: [],
        }
    },

    methods: {
        changeCategory(){
            this.professions = this.$parent.subcategories.filter(item => this.form.category_id == item.category_id)
            this.form.profession_1 = ''
            this.form.profession_2 = ''
            this.form.profession_3 = ''
        },
        selectLang(){
            this.selectedLangs = []
            if (this.$refs.lang_1.value){
                let lang_item = this.$refs.lang_1.selectedOptions[0].id
                let check = this.selectedLangs.filter(lang => lang == lang_item)
                if (check.length === 0) {
                    this.selectedLangs.push(lang_item)
                }
                this.desc_1 = true
                this.l_desc_1 = 'Описание (' + lang_item + ')'
                this.form.descriptions[0].lang = lang_item
            }
            else {
                this.desc_1 = false
                this.l_desc_1 = 'Описание'
                this.form.descriptions[0] = {}
            }
            if (this.$refs.lang_2.value){
                let lang_item = this.$refs.lang_2.selectedOptions[0].id
                let check = this.selectedLangs.filter(lang => lang == lang_item)
                if (check.length === 0) {
                    this.selectedLangs.push(lang_item)
                }
                this.desc_2 = true
                this.l_desc_2 = 'Описание (' + lang_item + ')'
            }
            else {
                this.desc_2 = false
                this.l_desc_2 = 'Описание'
            }
            if (this.$refs.lang_3.value){
                let lang_item = this.$refs.lang_3.selectedOptions[0].id
                let check = this.selectedLangs.filter(lang => lang == lang_item)
                if (check.length === 0) {
                    this.selectedLangs.push(lang_item)
                }
                this.desc_3 = true
                this.l_desc_3 = 'Описание (' + lang_item + ')'
            }
            else {
                this.desc_3 = false
                this.l_desc_3 = 'Описание'
            }


        }
    }
}
</script>

<style scoped>

</style>
