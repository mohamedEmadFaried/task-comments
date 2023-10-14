<template>
    <!-- category section -->
<section class="product_section layout_padding">
    <div class="container-fluid">
        <div class="row">
                <div class="col-md-4">
                    <div class="box big-box">

                        <div class="heading_container heading_center">
                            <h5>
                                <span>Car Parts</span>
                            </h5>
                        </div>
                    
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6" v-for="car in 4" :key="car">
                                <div class="box">

                                    <div class="img-box">
                                        <img :src="'storage'+'/'+ car_parts[car].image" alt="">
                                    </div>
                                    
                                    <div class="title-box">
                                        <h6>
                                            {{ car_parts[car].name_en }}
                                        </h6>
                                     </div>

                               </div>
                            </div>
                        </div>
                        
                        <br>

                        <div  style="text-align: center;">
                            <div class="viewAll">
                                <a href="">
                                    View All <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box big-box">
                        
                        <div class="heading_container heading_center">
                            <h5>
                                <span>Truck Parts</span>
                            </h5>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6" v-for="truck in 4" :key="truck">
                                <div class="box">
                                    <div class="img-box">
                                        <img :src="'storage'+'/'+ truck_parts[truck].image" alt="">
                                    </div>
                                    
                                    <div class="title-box">
                                        <h6>
                                            {{truck_parts[truck].name_en}}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <br>

                        <div  style="text-align: center;">
                            <div class="viewAll">
                                <a href="">
                                    View All <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box big-box">
                        <div class="heading_container heading_center">
                            <h5>
                                <span>car accessories</span>
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6" v-for="acc in 4" :key="acc">
                                <div class="box">

                                    <div class="img-box">
                                        <img :src="'storage'+'/'+ accessories[acc].image" alt="">
                                    </div>
                                    
                                    <div class="title-box">
                                        <h6>
                                            {{accessories[acc].name_en}}
                                        </h6>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <br>

                        <div  style="text-align: center;">
                            <div class="viewAll">
                                <a href="" >
                                    View All <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>
</section>
    <!-- end product section -->
</template>

<script>
module.exports={
    data()
    {
        return {
            car_parts: [], 
            truck_parts: [],
            accessories: [],   
  
        }
    },
        

    methods:
    {
            
        loadCarParts() 
        {
            const url = '/api/subcategories/1'
            axios.get(url)
                .then( res => {
                    this.car_parts = res.data.data

            })
            .catch(err => console.log(err)); 
                
                
        },
        loadTruckParts() 
        {
            const url = '/api/subcategories/2'
            axios.get(url)
                .then( res => {
                    this.truck_parts = res.data.data

            })
            .catch(err => console.log(err)); 
                
                
        },
        loadAccessories() 
        {
            const url = '/api/subcategories/33'
            axios.get(url)
                .then( res => {
                    this.accessories = res.data.data

            })
            .catch(err => console.log(err)); 
                
                
        },

    },
    
    mounted() {
        this.loadCarParts();
        this.loadTruckParts();
        this.loadAccessories();
        
    },
        
    }    
</script>