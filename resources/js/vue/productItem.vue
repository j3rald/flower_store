<template>
    <div>
        <div class="productCard">
            <div class="productHeader">
                <img
                    :src="'uploads/' + product.file_name"
                    alt=""
                    class="image"
                />
                <h1>{{ product.name }}</h1>
                <p>{{ product.description }}</p>

                <div class="productInfo">
                    <h5>price: ₱{{ item.price }}</h5>
                    <h6>Qty: {{ product.quantity }}</h6>
                </div>
                <hr />

                <div class="iconWrapper">
                    <font-awesome-icon
                        icon="cart-plus"
                        class="cart"
                        @click="order"
                    />

                    <font-awesome-icon
                        icon="pencil-square"
                        class="edit"
                        @click="showModal = true"
                    />

                    <font-awesome-icon
                        icon="trash"
                        class="trash"
                        @click="deleteProduct"
                    />

                    <font-awesome-icon
                        v-if="this.product.status === 1 ? true : false"
                        icon="ban"
                        class="disable"
                        @click="toggleProduct"
                    />

                    <font-awesome-icon
                        v-if="this.product.status == 0 ? true : false"
                        icon="toggle-on"
                        class="enable"
                        @click="toggleProduct"
                    />
                </div>
            </div>
        </div>

        <div>
            <modal
                v-if="showModal"
                @close="
                    showModal = false;
                    reload();
                "
                :productInfo="this.product"
            />
        </div>
    </div>
</template>

<script>
import axios from "axios";
import modal from "./modal.vue";

export default {
    props: ["product"],
    components: { modal },
    data: function () {
        return {
            item: {
                price: Number(this.product.price).toFixed(2),
            },
            showModal: false,
        };
    },
    methods: {
        order() {
            const userInfo = JSON.parse(localStorage.getItem("user"));
            // console.log(userInfo.user.id);

            // console.log("order");
            // console.log(`id: ${this.product.id} name: ${this.product.name}`);

            axios
                .post("api/order/store", {
                    order: {
                        userId: userInfo.user.id,
                        productId: this.product.id,
                        price: this.product.price,
                    },
                })
                .then((res) => {
                    if (res.status === 201) {
                        console.log("order success!");
                        this.$emit("show-msg");
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        toggleProduct() {
            axios
                .put("api/product/disable/" + this.product.id)
                .then((res) => {
                    if (res.status === 200) {
                        console.log("disable success!");
                        this.$emit("list-reload");
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        deleteProduct() {
            axios
                .delete("api/product/delete/" + this.product.id)
                .then((res) => {
                    if (res.status === 200) {
                        console.log(res.data);
                        console.log("delete success!");
                        this.$emit("list-reload");
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        reload() {
            this.$emit("list-reload");
        },
    },
};
</script>

<style scoped>
.productCard {
    background: #f2f2f2;
    width: 250px;
    height: 400px;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 1px 1px 10px black;
}

.productCard:hover {
    transform: scale(1.1);
    transition: 600ms;
}

hr {
    background-color: #d9d9d9;
    margin: 20px 0;
}

.image {
    width: 100%;
    height: 200px;
    border: 0.5px solid #d9d9d9;
    border-radius: 5px;
    margin-bottom: 10px;
}

h1 {
    font-weight: bold;
}

h5 {
    margin-top: 10px;
    font-size: 13px;
}

.productInfo {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

h6 {
    font-weight: normal;
    margin-top: 10px;
}

p {
    font-size: 13px;
    font-style: italic;
}

.iconWrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.iconWrapper .cart {
    font-size: 20px;
    color: #0088cc;
}

.iconWrapper .edit {
    font-size: 20px;
    color: #009933;
}

.iconWrapper .trash {
    font-size: 18px;
    color: #cc0000;
}

.iconWrapper .disable {
    font-size: 20px;
    color: #b30000;
}

.iconWrapper .cart:hover {
    cursor: pointer;
    color: #005580;
}

.iconWrapper .edit:hover {
    cursor: pointer;
    color: #006622;
}

.iconWrapper .trash:hover {
    cursor: pointer;
    color: #990000;
}

.iconWrapper .disable:hover {
    cursor: pointer;
    color: #800000;
}

.iconWrapper .enable {
    font-size: 20px;
    color: #0088cc;
}

.iconWrapper .enable:hover {
    cursor: pointer;
    color: #005580;
}
</style>
