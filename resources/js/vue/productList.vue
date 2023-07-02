<template>
    <div>
        <div class="col col-md-2 productContainer">
            <div
                v-for="(product, index) in products"
                :key="index"
                v-if="products.length > 0 ? true : false"
            >
                <product-item
                    :product="product"
                    v-on:list-reload="$emit('reloadList')"
                    v-on:show-msg="$emit('displayMsg')"
                />
            </div>
        </div>
        <div class="msgWrapper" v-if="products.length === 0 ? true : false">
            <h1>No products!</h1>
        </div>
    </div>
</template>

<script>
import productItem from "./productItem.vue";

export default {
    props: ["products"],
    components: {
        productItem,
    },
};
</script>

<style scoped>
.productContainer {
    padding: 20px 0;
    display: grid;
    grid-template-columns: auto auto auto auto;
    justify-content: center;
    align-items: center;
    gap: 50px;
    width: 100%;
}

.msgWrapper {
    text-align: center;
}

.msgWrapper > h1 {
    font-size: 25px;
    padding: 50px 0;
}

@media screen and (max-width: 1000px) {
    .productContainer {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        justify-content: center;
        align-items: center;
        gap: 50px;
        width: 100%;
    }
}

@media screen and (max-width: 865px) {
    .productContainer {
        display: grid;
        grid-template-columns: auto auto;
        justify-content: center;
        align-items: center;
        gap: 50px;
        width: 100%;
    }
}

@media screen and (max-width: 571px) {
    .productContainer {
        display: grid;
        grid-template-columns: auto;
        justify-content: center;
        align-items: center;
        gap: 50px;
        width: 100%;
    }
}
</style>
