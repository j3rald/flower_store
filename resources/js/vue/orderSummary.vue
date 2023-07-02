<template>
    <div class="summaryContainer">
        <h1 class="summaryTitle">Ordered Summary</h1>
        <div class="summaryBody">
            <div class="table-title">
                <h4>Order ID</h4>
                <h4>Product Name</h4>
                <h4>Qty.</h4>
                <h4>Price</h4>
                <h4>Action</h4>
            </div>

            <div
                v-for="(product, index) in products"
                :key="index"
                class="table-data-wrapper"
            >
                <h2>
                    {{ product.id }}
                </h2>
                <h2>
                    {{ product.name }}
                </h2>

                <h2>
                    {{ product.quantity }}
                </h2>

                <h2>₱{{ Number(product.price).toFixed(2) }}</h2>
                <button @click="cancelOrder(product.id)">
                    Cancel
                    <font-awesome-icon icon="trash" class="trash" />
                </button>
            </div>
        </div>

        <div class="totalAmount">
            <h3>Total Amount :</h3>
            <h4>₱{{ this.totalAmount }}</h4>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: ["products", "totalAmountOrdered"],
    data() {
        return {
            totalAmount: Number(this.totalAmountOrdered).toFixed(2),
        };
    },
    methods: {
        cancelOrder(orderId) {
            axios
                .delete("api/order/" + orderId)
                .then((response) => {
                    if (response.status === 200) {
                        this.$emit("reloadList");
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style scoped>
.summaryContainer {
    margin: 10px 50px;
}

.summaryTitle {
    font-size: 20px;
    text-decoration: underline;
    font-weight: 600;
    margin-bottom: 10px;
}

.table-title {
    display: flex;
    justify-content: center;
    width: 100%;
    background: #ffddcc;
}

.table-title > h4 {
    border: 0.5px solid #bfbfbf;
    padding: 5px 20px;
    width: 100%;
    font-weight: bold;
}

.table-data-wrapper {
    display: flex;
    justify-content: center;
    width: 100%;
}

h2 {
    border: 0.5px solid #bfbfbf;
    padding: 5px 20px;
    width: 100%;
}

button {
    border: 0.5px solid #bfbfbf;
    padding: 5px 20px;
    width: 100%;
    background: transparent;
}

button:hover {
    cursor: pointer;
    color: #990000;
}

.trash {
    font-size: 13px;
    color: #cc0000;
}

.dummyTrash {
    font-size: 20px;
    color: transparent;
}

.totalAmount {
    display: flex;
    margin-top: 10px;
    border: 0.5px solid #bfbfbf;
    padding: 5px 20px;
}

h3 {
    margin-right: 10px;
    font-weight: bold;
}
</style>
