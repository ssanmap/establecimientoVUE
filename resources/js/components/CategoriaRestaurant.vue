<template>
    <div class="container my-5">
        <h1>Restaurants</h1>
        <div class="row">
            <div class="col-md-4" v-for="r in this.restaurants" v-bind:key="r.id">
                <div class="card">
                    <img :src="`storage/${r.imagen_principal}`" class="card-img-top" alt="card">
                    <div class="card-body">
                        <h3 class="card-title text-primary font-weight-bold">
                            {{r.nombre}}
                        </h3>
                        <p class="card-text">{{r.direccion}}</p>
                        <p class="card-text">
                            <span class="font-weight-bold"> Horario :</span>
                            {{r.apertura}} -- {{r.cierre}}
                        </p>
                        <a href="" class="btn btn-primary d-block">Ver Lugar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name:'CategoriaRestaurant',
        mounted() {
            axios.get('/api/categorias/restaurant')
            .then( resp => {
                this.$store.commit("agregarRes", resp.data)
            })
        },
        data() {
            return {

            }
        },
        computed: {
             restaurants(){
                return this.$store.state.restaurants;
            }
        },
    }
</script>


