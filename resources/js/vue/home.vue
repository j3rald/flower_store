<template>
    <div class="mainContainer">
        <div class="header">
            <div class="homeTitle">
                <h4>Flower Store</h4>
                <img
                    src="images/flower_store_logo.png"
                    alt="flower_store_logo"
                    width="80"
                    height="80"
                />
            </div>

            <div class="btnWrapper">
                <button
                    type="btn"
                    :class="[
                        this.isShowProductList ? 'active' : '',
                        'btnProduct',
                    ]"
                    @click="getProductList"
                >
                    Products
                </button>
                <button
                    type="btn"
                    :class="[this.isShowOrderList ? 'active' : '', 'btnOrder']"
                    @click="orderList"
                >
                    Orders
                </button>
                <button
                    type="btn"
                    :class="[
                        this.isShowDisabledList ? 'active' : '',
                        'btnDisable',
                    ]"
                    @click="disabledList"
                >
                    Disabled List
                </button>
            </div>

            <div class="logoutWrapper">
                <h6>Hello, {{ user.name }}</h6>
                <button type="btn" class="logout" @click="logout">
                    Logout
                </button>
            </div>
        </div>

        <div class="addProduct">
            <button type="button" @click="showModal = true">
                Add Product
                <font-awesome-icon icon="plus-square" class="plusIcon" />
            </button>
        </div>

        <div>
            <modal
                v-if="showModal"
                @close="
                    showModal = false;
                    getProductList();
                "
                :productInfo="null"
            />
        </div>

        <!-- Product List -->
        <div v-if="isShowProductList">
            <div :class="[success.msg ? 'showMsg' : 'hideMsg', 'msgWrapper']">
                <div :class="[success.msg ? 'showMsg' : 'hideMsg', 'orderMsg']">
                    <div>
                        <h3>{{ success.msg }}</h3>
                    </div>
                    <div>
                        <font-awesome-icon
                            icon="window-close"
                            class="closeIcon"
                            @click="displayMsg()"
                        />
                    </div>
                </div>
            </div>

            <h1 class="listTitle">Product List</h1>
            <hr />
            <product-list
                :products="products"
                v-on:reloadList="getProductList()"
                v-on:displayMsg="displayMsg()"
            />
        </div>

        <!-- Order List -->
        <div v-if="isShowOrderList">
            <h1 class="listTitle">Order List</h1>
            <hr />
            <product-list :products="products" />
            <hr />

            <order-summary
                :products="products"
                :totalAmountOrdered="this.product.totalAmount"
                v-on:reloadList="orderList()"
            />
        </div>

        <!-- Disabled List -->
        <div v-if="isShowDisabledList">
            <h1 class="listTitle">Disabled List</h1>
            <hr />
            <product-list
                :products="products"
                v-on:reloadList="disabledList()"
            />
        </div>
    </div>
</template>

<script>
import axios from "axios";
import modal from "./modal.vue";
import productList from "./productList.vue";
import orderSummary from "./orderSummary.vue";

export default {
    components: {
        productList,
        orderSummary,
        modal,
    },
    data: function () {
        const userInfo = JSON.parse(localStorage.getItem("user"));
        return {
            user: {
                name: userInfo.user.first_name,
            },
            product: {
                totalAmount: 0,
            },
            showModal: false,
            products: [],
            isShowProductList: true,
            isShowOrderList: false,
            isShowDisabledList: false,
            success: {
                msg: "",
            },
        };
    },
    methods: {
        getProductList() {
            axios
                .get("api/products")
                .then((response) => {
                    this.products = response.data;
                    this.isShowProductList = true;
                    this.isShowOrderList = false;
                    this.isShowDisabledList = false;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        orderList() {
            axios
                .get("api/orders")
                .then((response) => {
                    this.products = response.data;
                    console.log(response.data);
                    let totalPriceOrdered = 0;
                    for (let i = 0; i < response.data.length; i++) {
                        totalPriceOrdered =
                            totalPriceOrdered + response.data[i].price;
                    }

                    this.product.totalAmount = totalPriceOrdered;
                    this.isShowOrderList = true;
                    this.isShowProductList = false;
                    this.isShowDisabledList = false;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        disabledList() {
            axios
                .get("api/disabledProducts")
                .then((response) => {
                    this.products = response.data;
                    this.isShowDisabledList = true;
                    this.isShowProductList = false;
                    this.isShowOrderList = false;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        displayMsg() {
            if (this.success.msg) {
                this.success.msg = "";
            } else {
                this.success.msg = "Order success!";
            }
        },
        logout() {
            localStorage.clear();
            window.location.replace("/");
        },
    },
    created() {
        this.getProductList();
    },
};
</script>

<style scope>
.mainContainer {
    margin-bottom: 80px;
}

.header {
    display: flex;
    justify-content: space-between;
    background-color: #ffccb3;
    width: 100%;
    padding: 10px 30px;
    box-shadow: 1px 1px 10px 1px black;
}

.homeTitle {
    font-size: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 190px;
    color: #ffffff;
    text-shadow: 1px 1px 3px black;
}

h6 {
    font-size: 13px;
    font-weight: bold;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}
.logoutWrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
}

.logout {
    border: none;
    background: transparent;
    text-decoration: underline;
    color: #0073e6;
}

.logout:hover {
    cursor: pointer;
}

.addProduct {
    float: right;
    padding: 20px;
}

.addProduct > button {
    border: none;
    padding: 10px;
    outline: none;
    background: #4dff88;
    font-size: 14px;
    border-radius: 5px;
    font-weight: 500;
}

.addProduct > button:hover {
    background: #00ff55;
    cursor: pointer;
}

.btnProduct {
    background: transparent;
    border: none;
    padding: 10px 10px;
    margin: 0 5px;
    color: #662200;
}

.btnOrder {
    background: transparent;
    border: none;
    padding: 10px 10px;
    margin: 0 5px;
    color: #662200;
}

.btnDisable {
    background: transparent;
    border: none;
    padding: 10px 0px;
    width: 80px;
    color: #662200;
}

.btnProduct:hover {
    cursor: pointer;
    color: #e64d00;
    border-bottom: 3px solid #e64d00;
}

.btnOrder:hover {
    cursor: pointer;
    color: #e64d00;
    border-bottom: 3px solid #e64d00;
}

.btnDisable:hover {
    cursor: pointer;
    color: #e64d00;
    border-bottom: 3px solid #e64d00;
}

.active {
    color: #e64d00;
    border-bottom: 3px solid #e64d00;
}

.listTitle {
    margin-top: 100px;
    padding: 0 50px;
    font-size: 35px;
}

hr {
    margin: 10px 50px;
    background: #e64d00;
}

.msgWrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    padding: 0 50px;
}
.orderMsg {
    display: flex !important;
    justify-content: space-between;
    align-items: center;
    margin-top: 100px;
    background: #00b33c;
    color: #ffffff;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 15px;
    font-weight: bold;
    letter-spacing: 1px;
    width: 100%;
}
.showMsg {
    display: block;
}

.hideMsg {
    display: none;
}

.closeIcon {
    font-size: 20px;
}

.closeIcon:hover {
    cursor: pointer;
    color: #ff6666;
}
</style>
