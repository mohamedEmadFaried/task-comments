<template>
    <!-- category section -->
    <section class="product_section layout_padding">
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-md-6" style="text-align: left;">
                    <h5>
                        <span>Top Product</span>
                    </h5>
                </div>

                <div class="col-md-6" style="text-align: right;">
                    <div class="viewAll">
                        <a href="">
                            View All <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

            </div>
            
            <div class="row">    
                <div class="col-sm-6 col-md-2 col-lg-2" v-for="top in Top_products " >
                    <div class="box">
                             
                        <div class="img-box">

                            <img :src="'storage'+'/'+ top.image" alt="" >

                        </div>

                        <div class="box-edit">
                            <div class="detail-box">
                                
                                <h6>
                                    {{top.name}}
                                </h6>

                            </div>

                            <div class="detail-box">

                                <p>
                                    Serial number : <span>{{top.serial_number}}</span>
                                </p>

                            </div>

                            <div v-if="top.discount == 0" class="detail-box">

                                <p>SR {{top.price}}</p>

                            </div>

                            <div v-else class="detail-box">

                                <p><s>SR {{top.price}}</s></p>
                                <p class="changeP">
                                    {{top.discount}}% off 
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
    </section>

    <!-- end product section -->
</template>

<script>    
export default {
    data()
    {
            return {
                Top_products: [],   
            }
    },
        

        methods:
        {
            
            loadTopProducts() 
            {
                const url = '/api/product/mostSeller?page_size=12'
                axios.get(url)
                    .then( res => {
                        this.Top_products = res.data.data.data
                        console.log(this.Top_products)

                    })
                    .catch(err => console.log(err)); 
                
                
            },

        },

        mounted() {
            this.loadTopProducts();
                
        },
        
    }   
</script>
