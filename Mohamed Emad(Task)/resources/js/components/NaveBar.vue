<template>
    <header class="header_section">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg custom_nav-container ">

                <a class="navbar-brand" href="index.html"><img width="81" src="/assets/images/logo.svg" alt="#" /></a>

                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class=""> </span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="dropdown">
                        <button class="btn btn-outline-danger dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-expanded="false">
                            <div> <i class="fa fa-car" aria-hidden="true" style="padding: 15%;"></i> Car Parts <i
                                    style="padding: 15%;" class="fa fa-caret-down"></i></div>

                        </button>


                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#"> <i class="fa fa-truck" aria-hidden="true"
                                    style="padding-right: 10%;padding-left: 10%;"></i>
                                Truck parts
                            </a>
                        </div>
                    </div>


                    <div class="container ">
                        <div class="input-group">
                            <input type="text" class=" form-control search-input"
                                placeholder="Enter The part number or name" aria-label="Enter the part number or name"
                                aria-describedby="basic-addon2">

                            <div class="input-group-append">
                                <button class="btn btn-default test " type="submit" id="basic-addon2">search</button>
                            </div>
                        </div>
                    </div>


                    <ul class="navbar-nav">

                        <li class="nav-item">
                            <img :src="'/site/images/my_account_web.svg'">

                            <p>Account</p>

                        </li>
                        <li class="nav-item">
                            <img :src="'/site/images/cart_web.svg'">
                            <p>Cart</p>

                        </li>
                        <li class="nav-item">
                            <img :src="'/site/images/wishlist_web.svg'">
                            <p>Wishlist</p>

                        </li>
                        <li class="nav-item">
                            <img :src="'/site/images/add_vehicles_web.svg'">
                            <p> Vehicles</p>

                        </li>

                    </ul>

               
                </div>

            </nav>
            
            <ul class="nav">

                <li class="nav-item border-right">
                    <a class="nav-link active" aria-current="page" href="#"><img class="icons" :src="'/assets/images/icons/Vector.png'" >
                            All Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><img class="icons" :src="'/assets/images/icons/tyres.png'" >
                            Tyres
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#"><img class="icons" :src="'/assets/images/icons/tools.png'" >
                            Tools
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#"><img class="icons" :src="'/assets/images/icons/accessories.png'" >
                            Car Accessories 
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#"><img class="icons" :src="'/assets/images/icons/oil.png'" >
                            Engine Oil
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#"><img class="icons" :src="'/assets/images/icons/filters.png'" >
                            Filters
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#"><img class="icons" :src="'/assets/images/icons/brake.png'" >
                            Brakes 
                    </a>
                </li>

            </ul>
        </div>
    </header>
</template>

<style>

</style>