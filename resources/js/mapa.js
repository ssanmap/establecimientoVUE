import { OpenStreetMapProvider} from 'leaflet-geosearch';
const provider = new OpenStreetMapProvider();

document.addEventListener('DOMContentLoaded', () => {

    if (document.querySelector('#mapa')) {
        const lat = -33.5657029;
        const lng = -70.708615;

        const mapa = L.map('mapa').setView([lat, lng], 16);
        // eliminar pines previos
        let markers = new L.featureGroup().addTo(mapa);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mapa);

        let marker;

        // agregar el pin
        marker = new L.marker([lat, lng],{
            draggable:true,
            autoPan: true
        }).addTo(mapa);

        markers.addLayer(marker);
        // geocode service
        // const geocodeService = L.esri.Geocoding.geocodeService();
        const geocodeService = L.esri.Geocoding.geocodeService({
            apiKey : 'AAPK41cf31d1f7e04739ba7270fc868778e6-16ttdbZkC2I0xRIACTE2a_p6ITwCD10CWDtZg_ol6vZUd97oB-KzanWEAJSvkpr'
        });
        // buscador de direcciones
        const buscador = document.querySelector('#formbuscador');
        buscador.addEventListener('blur', buscarDireccion);


        reubicarPin(marker);
        function reubicarPin(marker){
            marker.on('moveend', function(e){
                marker = e.target;
                const posicion = marker.getLatLng();
                // console.log(posicion);

                mapa.panTo( new L.LatLng( posicion.lat, posicion.lng));

                // reverse geocoding

                geocodeService.reverse().latlng(posicion, 16).run(function(error, resultado){
                    console.log(error);
                    console.log(resultado)
                    marker.bindPopup(resultado.address.LongLabel);
                    marker.openPopup();

                    llenarInputs(resultado);

                })
            });
        }

        function llenarInputs(resultado){
           document.querySelector('#direccion').value = resultado.address.Address || 'ee';
           document.querySelector('#comuna').value = resultado.address.City || 'ii';
           document.querySelector('#lat').value = resultado.latlng.lat || '';
           document.querySelector('#lng').value = resultado.latlng.lng || '';
        }
        function buscarDireccion(e){
            // console.log(provider);
            if (e.target.value.length > 1) {
                provider.search({query: e.target.value + ' Santiago CHL'})
                .then(resultado =>{
                    if (resultado ) {
                        // limpiar pines previos
                        markers.clearLayers();

                        geocodeService.reverse().latlng(resultado[0].bounds[0], 16).run(function(error, resultado){
                            console.log(error);
                            // console.log(resultado)
                            // llenar los input
                            llenarInputs(resultado);
                            // centrar el mapa
                            mapa.setView(resultado.latlng)
                            // agregar el pin
                            marker = new L.marker(resultado.latlng,{
                                draggable:true,
                                autoPan: true
                            }).addTo(mapa);
                            // asignar el contenedor de markers del nuevo pin
                            markers.addLayer(maker);
                            // mover el pin
                            reubicarPin(marker);


                        })
                    }
                })
                .catch( error => {
                    console.log(error)
                })
            }

        }

    }



});
