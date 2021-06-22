<template>
    <div class="container my-5">
        <h1>Hotel</h1>
        <div class="row">
            <div class="col-md-4" v-for="h in this.hoteles" v-bind:key="h.id">
                <div class="card">
                    <img :src="`storage/${h.imagen_principal}`" class="card-img-top" alt="card">
                    <div class="card-body">
                        <h3 class="card-title text-primary font-weight-bold">
                            {{h.nombre}}
                        </h3>
                        <p class="card-text">{{h.direccion}}</p>
                        <p class="card-text">
                            <span class="font-weight-bold"> Horario :</span>
                            {{h.apertura}} -- {{h.cierre}}
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
        name:'CategoriaHotel',
        mounted() {
            axios.get('/api/categorias/hotel')
            .then( resp => {
               this.$store.commit("agregarHoteles", resp.data)
            })
        },
        data() {
            return {

            }
        },
        computed: {
              hoteles(){
                return this.$store.state.hoteles;
            }
        },
    }
</script>


