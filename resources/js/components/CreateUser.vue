<template>
    <div class="container">
        <div class="row my-3">
            <h4>Новый аккаунт</h4>
            <div class="col-5 mb-3">
                <label for="user_type">Тип аккаунта</label>
                <select id="user_type" name="role" required class="form-control" v-model="role">
                    <option value="">Выберите тип аккаунта</option>
                    <option value="person">Физ. лицо</option>
                    <option value="company">Компания</option>
                </select>
            </div>
            <hr>
            <div class="account-info" v-if="role">
                <person v-if="role == 'person'" :countries="countries" :old="old"></person>
                <company v-if="role == 'company'" :countries="countries" :old="old"></company>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CreateUser",
    props: {
        professions: {
            type: Array
        },
        services: {
            type: Array
        },
        countries: {
            type: Array
        },
        subcategories: {
            type: Array
        },
        langs: {
            type: Array
        },
        old: {}
    },
    data() {
        return {
            role: (this.old.role) ? this.old.role : '',
        }
    },

}
</script>

<style scoped>

</style>
