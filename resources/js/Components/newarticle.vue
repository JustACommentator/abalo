<template>
    <div class="container col-md-4 col-md-offset-4">
        <label class="text-uppercase mb-4" size="20px">new article</label>
        <div v-if="this.error">
            <label class="alert alert-danger" > {{ this.data }}</label>
        </div>
        <div v-else-if="! this.error && this.data.length > 0">
            <label class="alert alert-success"> {{ this.data }}</label>
        </div>
        <div>
            <label class="form-label" for="name"> Name <br>
                <input class="form-control" v-model="this.name" name="name" id="name">
            </label>
        </div>
        <div>
            <label class="form-label" for="preis"> Price <br>
                <input class="form-control" v-model="this.price" name="preis" id="preis">
            </label>
        </div>
        <div>
            <label class="form-label" for="beschreibung"> Description <br>
                <input class="form-control" v-model="this.description" name="beschreibung" id="beschreibung">
            </label>
        </div>
        <button class="btn btn-secondary" id="submit" v-on:click="this.submitForm()">Save</button>
    </div>
</template>

<script>
export default {
    name: "newarticle",
    data(){
        return {
            name: '',
            price: '',
            description: '',
            data: '',
            error : false
        }
    },
    methods :{
        async submitForm (){
            let formData = new FormData();
            formData.append('name', this.name)
            formData.append('preis', this.price)
            formData.append('beschreibung', this.description)

            const { data } = await axios.post('/api/articles', formData)
            console.log(data)
            if('error' in data){
                this.error = true
                this.data = data['error']
            } else {
                this.data = data['article']
            }
        }
    }
}
</script>

<style scoped>

</style>
