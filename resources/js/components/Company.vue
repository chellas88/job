<template>
    <div class="container">
        <form enctype="multipart/form-data" method="post" action="/en/admin/user">
            <input type="hidden" :value="csrf" name="_token">
            <input type="hidden" :value="this.$parent.role" name="role">
            <div class="row">

                <div class="col-12 mb-3">
                    <label for="avatar">Логотип компании</label>
                    <input type="file" ref="avatar" id="avatar" name="avatar" class="form-control" accept="image/*" @change="loadFile">
                </div>
                <div class="col-4 mb-3">
                    <label>Название компании</label>
                    <input type="text" class="form-control" v-model="form.name" name="name" required>
                </div>
                <div class="col-8"></div>
                <div class="col-4 mb-3">
                    <label for="country">Страна</label>
                    <select id="country" class="form-control" v-model="form.country_id" name="country_id" required>
                        <option value="">Выберите страну</option>
                        <option v-for="country in countries" :id="country.id" :value="country.id">{{ country.title_ru }}</option>
                    </select>
                </div>
                <div class="col-4">
                    <label for="city">Город</label>
                    <input id="city" v-model="form.city" class="form-control" name="city">
                </div>
                <div class="col-4">
                    <label for="address">Адрес</label>
                    <input id="address" v-model="form.address" class="form-control" name="address">
                </div>
                <div class="col-4 mb-3">
                    <label>Направление</label>
                    <select class="form-control" v-model="form.category_id" @change="changeCategory" name="category_id" required>
                        <option value="" selected>Выберите направление</option>
                        <option v-for="category in this.$parent.services" :id="category.id" :value="category.id">{{ category.title_ru }}</option>
                    </select>
                </div>
                <div class="col-8"></div>
                <div class="col-4" v-if="form.category_id">
                    <label>Услуга 1</label>
                    <select v-model="form.profession_1" class="form-control" name="profession_1">
                        <option value="" selected>Выберите услугу</option>
                        <option v-for="profession in professions" :id="profession.id" :value="profession.id">{{ profession.title_ru }}</option>
                    </select>
                </div>
                <div class="col-4" v-if="form.category_id">
                    <label>Услуга 2</label>
                    <select v-model="form.profession_2" class="form-control" name="profession_2">
                        <option value="" selected>Выберите услугу</option>
                        <option v-for="profession in professions" :id="profession.id" :value="profession.id">{{ profession.title_ru }}</option>
                    </select>
                </div>
                <div class="col-4 mb-3" v-if="form.category_id">
                    <label>Услуга 3</label>
                    <select v-model="form.profession_3" class="form-control" name="profession_3">
                        <option value="" selected>Выберите услугу</option>
                        <option v-for="profession in professions" :id="profession.id" :value="profession.id">{{ profession.title_ru }}</option>
                    </select>
                </div>

                <div class="col-4 mb-5">
                    <label>Язык</label>
                    <select v-model="form.lang_1" class="form-control" ref="lang_1" @change="selectLang" name="lang_1">
                        <option value="" selected>Выберите язык</option>
                        <option v-for="lang in this.$parent.langs" :id="lang.key" :value="lang.id">{{ lang.title_ru }}</option>
                    </select>
                </div>
                <div class="col-4 mb-3">
                    <label>Второй язык</label>
                    <select v-model="form.lang_2" class="form-control" ref="lang_2" @change="selectLang" name="lang_2">
                        <option value="" selected>Выберите язык</option>
                        <option v-for="lang in this.$parent.langs" :id="lang.key" :value="lang.id">{{ lang.title_ru }}</option>
                    </select>
                </div>
                <div class="col-4 mb-3">
                    <label>Третий язык</label>
                    <select v-model="form.lang_3" class="form-control" ref="lang_3" @change="selectLang" name="lang_3">
                        <option value="" selected>Выберите язык</option>
                        <option v-for="lang in this.$parent.langs" :id="lang.key" :value="lang.id">{{ lang.title_ru }}</option>
                    </select>
                </div>

                <div class="col-12 mb-3" v-if="desc_1">
                    <label>{{ l_desc_1 }}</label>
                    <textarea class="form-control" ref="desc_1" v-model="form.descriptions[0].value" :name="'description_' + form.descriptions[0].lang"></textarea>
                </div>

                <div class="col-12 mb-3" v-if="desc_2">
                    <label>{{ l_desc_2 }}</label>
                    <textarea class="form-control" ref="desc_2" v-model="form.descriptions[1].value" :name="'description_' + form.descriptions[1].lang"></textarea>
                </div>

                <div class="col-12 mb-3" v-if="desc_3">
                    <label>{{ l_desc_3 }}</label>
                    <textarea class="form-control" ref="desc_3" v-model="form.descriptions[2].value" :name="'description_' + form.descriptions[2].lang"></textarea>
                </div>
                <hr>
                <h5 class="my-3">Контакты</h5>
                <div class="col-2 mb-3">
                    <label>Телефон</label>
                    <input type="text" v-model="form.phone" class="form-control" name="phone">
                </div>
                <div class="col-2 mb-3">
                    <label>Whatsapp</label>
                    <input type="text" v-model="form.whatsapp" class="form-control" name="whatsapp">
                </div>
                <div class="col-2 mb-3">
                    <label>Viber</label>
                    <input type="text" v-model="form.viber" class="form-control" name="viber">
                </div>
                <div class="col-2 mb-3">
                    <label>Telegram</label>
                    <input type="text" v-model="form.telegram" class="form-control" name="telegram">
                </div>
                <div class="col-2 mb-3">
                    <label>Skype</label>
                    <input type="text" v-model="form.skype" class="form-control" name="skype">
                </div>
                <div class="col-2 mb-3">
                    <label>Email</label>
                    <input type="email" v-model="form.email" class="form-control" name="email" required>
                </div>
                <h5 class="my-3">Социальные сети</h5>
                <div class="col-4 mb-3">
                    <label>Facebook</label>
                    <input type="text" v-model="form.facebook" class="form-control" name="facebook">
                </div>
                <div class="col-4 mb-3">
                    <label>Instagram</label>
                    <input type="text" v-model="form.instagram" class="form-control" name="instagram">
                </div>
                <div class="col-4 mb-3">
                    <label>Youtube</label>
                    <input type="text" v-model="form.youtube" class="form-control" name="youtube">
                </div>

                <div class="col-12 mb-3">
                    <label>Теги (через запятую)</label>
                    <input type="text" v-model="form.tags" class="form-control" name="tags">
                </div>

                <input type="submit" value="Сохранить" class="btn btn-primary my-3">
            </div>
        </form>

    </div>
</template>

<script>
export default {
    name: "Company",
    props: {
        countries: {
            type: Array
        },
        old: {
            type: Object
        }
    },
    data() {
        return {
            csrf: document.head.querySelector('meta[name="csrf-token"]').content,
            form: {
                role: (this.old.role) ? this.old.role : this.$parent.role,
                name: (this.old.name) ? this.old.name : '',
                country_id: (this.old.country_id) ? this.old.country_id : '',
                city: (this.old.city) ? this.old.city : '',
                address: (this.old.address) ? this.old.address : '',
                category_id: (this.old.category_id) ? this.old.category_id : '',
                profession_1: (this.old.profession_1) ? this.old.profession_1 : '',
                profession_2: (this.old.profession_2) ? this.old.profession_2 : '',
                profession_3: (this.old.profession_3) ? this.old.profession_3 : '',
                lang_1: (this.old.lang_1) ? this.old.lang_1 : '',
                lang_2: (this.old.lang_2) ? this.old.lang_2 : '',
                lang_3: (this.old.lang_3) ? this.old.lang_3 : '',
                email: (this.old.email) ? this.old.email : '',
                descriptions: [
                    {},
                    {},
                    {},
                ],
                avatar: ''
            },
            l_desc_1: 'Описание',
            l_desc_2: 'Описание',
            l_desc_3: 'Описание',
            desc_1: false,
            desc_2: false,
            desc_3: false,
            professions: [],
            selectedLangs: [],
            file: ''
        }
    },
    mounted() {
        if (this.$refs.lang_1.value){
            this.desc_1 = true
        }
        if (this.$refs.lang_2.value){
            this.desc_2 = true
        }
        if (this.$refs.lang_3.value){
            this.desc_3 = true
        }
    },
    methods: {
        changeCategory(){
            this.professions = this.$parent.subcategories.filter(item => this.form.category_id == item.category_id)
            this.form.profession_1 = ''
            this.form.profession_2 = ''
            this.form.profession_3 = ''
        },
        loadFile(){
            this.form.avatar = this.$refs.avatar.files[0]
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
                this.form.descriptions[1].lang = lang_item
            }
            else {
                this.desc_2 = false
                this.l_desc_2 = 'Описание'
                this.form.descriptions[1] = {}
            }
            if (this.$refs.lang_3.value){
                let lang_item = this.$refs.lang_3.selectedOptions[0].id
                let check = this.selectedLangs.filter(lang => lang == lang_item)
                if (check.length === 0) {
                    this.selectedLangs.push(lang_item)
                }
                this.desc_3 = true
                this.l_desc_3 = 'Описание (' + lang_item + ')'
                this.form.descriptions[2].lang = lang_item
            }
            else {
                this.desc_3 = false
                this.l_desc_3 = 'Описание'
                this.form.descriptions[2] = {}
            }


        },
        async createUser(){
            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
            await axios.post('/en/admin/user', this.form, config)
                .then(response => {
                    console.log(response)
                })
        },
    }
}
</script>

<style scoped>

</style>
