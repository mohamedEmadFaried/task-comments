
<template>
    <!-- product section -->

    <section class="product_section layout_padding">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-3 col-xs-3 col-md-3">

                    <div class="heading_container heading_center">
                        <h5>
                            <span>Select Your Car To Search For Parts</span>
                        </h5>
                    </div>
                    <form>
                        <div class="col-md-12 paddingDiv">
                            <label>VIN Number</label>
                            <input class="form-control borderColor">
                        </div>

                        <div class="col-md-12 paddingDiv">
                            <label>Maker</label>
                            <select v-model="mades" class="form-control borderColor " >
                                <option>Select Maker</option>
                                <option v-for="made in mades">{{made.name}}</option>
                            </select>
                        </div>
                        <div class="col-md-12 paddingDiv">
                            <label>Model</label>
                            <select class="form-control borderColor">
                                <option>Select Model</option>
                                <option v-for="model in models">{{model.name}}</option>

                            </select>
                        </div>
                        <div class="col-md-12 paddingDiv">
                            <label>Engine</label>
                            <select class="form-control borderColor">
                                <option>Select Engine</option>
                                <option v-for="engine in engines">{{engine.name}}</option>

                            </select>

                        </div>
                        <button class="buttonChange" type="button">Search</button>

                    </form>
                    <div class="offer">
                        <div class="heading_container heading_center">
                            <h5>
                                <span>Best Offer</span>
                            </h5>
                        </div>
                        <div class="row">
                            <div class="col-xs-2">

                                <img class="imageSize"
                                    src="https://cdn.autodoc.de/uploads/custom-catalog/atd/categories/200x200/10106.png"
                                    alt="">
                            </div>
                            <div class="col-xs-2">

                                <img class="imageSize"
                                    src="https://cdn.autodoc.de/uploads/custom-catalog/atd/categories/200x200/10106.png"
                                    alt="">
                            </div>
                            <div class="col-xs-2">

                                <img class="imageSize"
                                    src="https://cdn.autodoc.de/uploads/custom-catalog/atd/categories/200x200/10106.png"
                                    alt="">
                            </div>
                            <div class="col-xs-2">

                                <img class="imageSize"
                                    src="https://cdn.autodoc.de/uploads/custom-catalog/atd/categories/200x200/10106.png"
                                    alt="">
                            </div>
                        </div>
                    </div>


                </div>

                <div class="col-sm-9 col-xs-9 col-md-9">
                    <div class="row">
                        <div class="col text-left">
                            <h5>
                                <span>Recently Added </span>
                            </h5>
                        </div>
                        <div class="col text-right">
                            <div class="viewAll">
                                <a href="" style="text-align: center;">
                                    View All
                                    <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div  class="row"  >
                        <div  class="col-sm-6 col-md-4 col-lg-3" v-for="recent in recent_products " > 
                            <div  class="box" >

                                <div class="img-box">
                                    <img :src="'storage'+'/'+ recent.image" alt="" >
                                </div>
                                <div class="box-edit">

                                    <div class="detail-box">

                                        <h6>
                                            {{recent.name_en}}
                                        </h6>

                                    </div>
                                    <div class="detail-box">

                                        <p>
                                            Serial number : <span>{{recent.serial_number}}</span>
                                        </p>

                                    </div>
                                    <div v-if="recent.discount == 0" class="detail-box">

                                        <p>SR {{recent.price}}</p>
                                        
                                    </div>

                                    <div v-else class="detail-box">

                                        <p><s>SR {{recent.price}}</s></p>
                                        <p class="changeP">
                                            {{recent.discount}}% off 
                                        </p>

                                    </div>
                                    <a href="" class="option1">
                                        Add To Cart
                                        <i class="fa fa-shopping-cart fa-1x" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

</template>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.min.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>

<script>
    
module.exports={
    
    data()
    {
        return {
            recent_products: [], 
            mades: [], 
            models: [], 
            engines: [],
        }
    },
        

    methods:
    {
            
        loadRecentProducts() 
        {
            const url = '/api/recentlyAdded?page_size=8'
            axios.get(url)
                .then( res => {
                this.recent_products = res.data.data.data
                console.log(this.recent_products)

                })
                .catch(err => console.log(err)); 
                         
        },

        loadCarMades() 
        {
            const url = '/api/car/mades'
            axios.get(url)
                .then( res => {
                this.mades = res.data.data
                console.log(this.mades)

                })
                .catch(err => console.log(err)); 
                         
        },

        loadCarModel() 
        {
            const url = '/api/car/model'
            axios.get(url)
                .then( res => {
                this.models = res.data.data
                console.log(this.models)

                })
                .catch(err => console.log(err)); 
                         
        },

        loadCarEngine() 
        {
            const url = '/api/car/model'
            axios.get(url)
                .then( res => {
                this.engines = res.data.data
                console.log(this.engines)

                })
                .catch(err => console.log(err)); 
                         
        },

    },

    mounted() 
    {
        this.loadRecentProducts();
        this.loadCarMades();
        this.loadCarModel();
        this.loadCarEngine();

        $('#maker').select2();
                
    },
        
}

    
</script>
