<template>
    <div> 
        <div style="width: 100%; height: 100vh" id="mapContainer" ></div>
        <div class="request" style="" v-if="show">
            <h3>Make Request : {{name}}</h3>
            <small>{{coords.lat}} : {{coords.lng}}</small>
            <br/>
            <div class="form">
                <div class="col-12 from-group">
                    <label>Cell Number</label>
                    <input type="text" placeholder="Cell Number" v-model="cell" class="form-controller" />
                </div>
                <br/>
                <div class="col-12 from-group">
                    <label>Litre</label>
                    <input type="text" placeholder="Litre" v-model="litre" class="form-controller" />
                </div>
                <br/>
                <button class="btn" @click="sendRequest" >Submit</button>  
                <br/>
                <br/>
            </div>
        </div>
    </div>
</template>
<script>



    export default{
        created() {
            setTitle("Map Of Stations");
            window.openRequest = (name, coord) => {
                this.name = name;
                this.coords = coord;
                this.show = true;
            }
        },
        data() {
            return {
                show: false,
                map: null,
                cell: "",
                litre:"",
                coords: null,
                name: ""
            }
        },
        mounted() {
            this.$nextTick(() => {
                this.createMap()
                navigator.geolocation.getCurrentPosition(this.moveMapTo);

            })
        },
        methods: {
            async sendRequest() {

                var result = await this.post("api/requests.php?fun=make-request", {station_id: 1, cell: this.cell,litre: this.litre} )
                if (!result.error) {
                    return window.location.href = "/attendee"
                }

            },
            moveMapTo(position) {

            },
            createMap() {
                window.platform = new H.service.Platform({
                    'apikey': 'kntVxBYgOaX6PTv33Q9UJzOy3iakc93q_R419Ndv59c'
                });

                // Obtain the default map types from the platform object:
                var defaultLayers = platform.createDefaultLayers();


                // Instantiate (and display) a map object:
                this.map = new H.Map(
                        document.getElementById('mapContainer'),
                        defaultLayers.vector.normal.map,
                        {
                            zoom: 10,
                            pixelRatio: window.devicePixelRatio || 1,
                            center: {lat: -25.6343, lng: 28.3634}
                        });

                function createMarker(coords, name) {
                    var iconStaion = "<div class='marker' ><img src='/assets/img/station.png' /></div>";
                    var outerElement = document.createElement('div'),
                            innerElement = document.createElement('div');
                    innerElement.innerHTML = iconStaion
                    outerElement.appendChild(innerElement);

                    var domIcon = new H.map.DomIcon(outerElement, {
                        // the function is called every time marker enters the viewport
                        onAttach: (clonedElement, domIcon, domMarker) => {
                            clonedElement.addEventListener('click', () => {
                                console.log(name);
                                openRequest(name, coords)

                            });
                        },

                    });

                    return new H.map.DomMarker(coords, {icon: domIcon});
                }



                var stations = [

                    createMarker({lat: -25.6343, lng: 28.3634}, "Station 1"),
                    createMarker({lat: -25.7747, lng: 28.0201}, "Station 2"),
                    createMarker({lat: -25.6213, lng: 28.4746}, "Station 3"),
                    createMarker({lat: -25.6968, lng: 27.8251}, "Station 4")

                ]

                for (var i in stations) {
                    this.map.addObject(stations[i])
                }

                // Enable the event system on the map instance:
                var mapEvents = new H.mapevents.MapEvents(this.map);

                // Add event listeners:
                this.map.addEventListener('tap', (evt) => {
                    if (this.name != null) {
                        this.name = null;
                        this.show = false;
                    }
                    var coord = this.map.screenToGeo(evt.currentPointer.viewportX,
                            evt.currentPointer.viewportY);
                    console.log('Clicked at ' + coord.lat.toFixed(4) + " : " + coord.lng.toFixed(4))
                });

                // Instantiate the default behavior, providing the mapEvents object:
                var behavior = new H.mapevents.Behavior(mapEvents);

                window.addEventListener('resize', () => this.map.getViewPort().resize());


            }
        }
    }
</script>
<style>
    a{
        color : #00AFF9;
        transition: 150ms ease-in;
    }
    .request{
        position: fixed;
        width: 100%; 
        height: 65vh;
        bottom: 0;
        z-index: 999; 
        background: #fff;
        padding: 2em;
    }
    .marker{
        width: 40px;
        height: 40px;
        object-fit: scale-down;
        color: #fff;
        border-radius: 25%;
        transition: 250ms ease-in;
        &:hover{
            cursor: pointer;
            opacity: 0.6;
        }
    }
</style>