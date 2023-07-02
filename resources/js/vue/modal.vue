<template>
    <div class="modal is-active">
        <div class="modal-background"></div>
        <div class="modal-content">
            <div class="box">
                <div :class="[error.msg ? 'showMsg' : 'hideMsg', 'errorMsg']">
                    <h3>{{ error.msg }}</h3>
                </div>

                <div
                    :class="[success.msg ? 'showMsg' : 'hideMsg', 'successMsg']"
                >
                    <h3>{{ success.msg }}</h3>
                </div>

                <div class="modalHeader">
                    <h1>Add Product</h1>
                </div>

                <div>
                    <form
                        @submit.prevent="onSubmit"
                        class="addProductForm"
                        enctype="multipart/form-data"
                    >
                        <label for="image">Image(.png, .jpg, .jpeg)</label>
                        <input
                            type="file"
                            name="image"
                            id="image"
                            class="imageFile"
                            v-on:change="onChange"
                            accept=".png, .jpg, .jpeg"
                        />
                        <input
                            name="name"
                            type="text"
                            v-model="product.id"
                            class="productId"
                        />

                        <label for="name">Name</label>
                        <input name="name" type="text" v-model="product.name" />

                        <label for="description">Description</label>

                        <textarea
                            name="description"
                            v-model="product.description"
                            cols="85"
                            rows="5"
                        ></textarea>

                        <label for="quantity">Quantity</label>
                        <input
                            name="quantity"
                            type="number"
                            min="0"
                            v-model="product.quantity"
                        />

                        <label for="price">Price</label>
                        <input
                            name="price"
                            type="number"
                            min="0"
                            step="0.50"
                            v-model="product.price"
                        />
                        <button>Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <button
            class="modal-close is-large"
            aria-label="close"
            @click="$emit('close')"
        ></button>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: ["productInfo"],
    data: function () {
        return {
            product: {
                id: null,
                name: "",
                description: "",
                quantity: 0,
                price: 0,
            },
            image: null,
            error: {
                msg: "",
            },

            success: {
                msg: "",
            },
        };
    },
    methods: {
        onChange(e) {
            this.image = e.target.files[0];
        },
        onSubmit() {
            if (this.product.id === null) {
                try {
                    const ifImageEmpty =
                        document.getElementById("image").files.length;
                    console.log(ifImageEmpty);
                    if (
                        this.product.name === "" ||
                        this.product.description === "" ||
                        this.product.quantity === 0 ||
                        this.product.price === 0 ||
                        ifImageEmpty === 0
                    ) {
                        throw Error("All fields required!");
                    } else {
                        // Store Product
                        const config = {
                            headers: {
                                "content-type": "multipart/form-data",
                            },
                        };
                        let file = new FormData();
                        file.append("img", this.image);
                        axios
                            .post("api/product/add", {
                                product: this.product,
                            })
                            .then((productRes) => {
                                if (productRes.status === 201) {
                                    this.product.name = "";
                                    this.product.description = "";
                                    this.product.quantity = 0;
                                    this.product.price = 0;
                                    this.product.id = productRes.data.id;

                                    this.success.msg = "Successfully saved!";

                                    // upload file
                                    axios
                                        .post("api/file/upload", file, config)
                                        .then(function (uploadRes) {
                                            if (uploadRes.status === 200) {
                                                console.log(
                                                    "upload image success!"
                                                );
                                                // store file
                                                axios
                                                    .post("api/file/store", {
                                                        uploaded: {
                                                            file_name:
                                                                uploadRes.data
                                                                    .fileName,
                                                            productId:
                                                                productRes.data
                                                                    .id,
                                                        },
                                                    })
                                                    .then(function (response) {
                                                        console.log(
                                                            "store image success!"
                                                        );
                                                    })
                                                    .catch(function (err) {
                                                        console.log(err);
                                                    });
                                            }
                                        })
                                        .catch(function (err) {
                                            console.log(err);
                                        });
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    }
                } catch (error) {
                    return (this.error.msg = error.message);
                }
            } else {
                // Edit Product
                console.log(this.product.id);
                try {
                    axios
                        .put("api/product/update/" + this.product.id, {
                            product: this.product,
                        })
                        .then((res) => {
                            if (res.status === 200) {
                                this.product.name = "";
                                this.product.description = "";
                                this.product.quantity = 0;
                                this.product.price = 0;

                                this.success.msg = "Successfully updated!";
                            }
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                } catch (error) {
                    return (this.error.msg = error.message);
                }
            }
        },
    },
    created() {
        if (this.productInfo) {
            this.product.id = this.productInfo.id;
            this.product.name = this.productInfo.name;
            this.product.description = this.productInfo.description;
            this.product.quantity = this.productInfo.quantity;
            this.product.price = this.productInfo.price;
        }
    },
};
</script>

<style scoped>
.productId {
    display: none;
}

.box {
    padding: 30px;
}

h1 {
    font-size: 20px;
    font-weight: bold;
}

.modalHeader {
    padding: 15px 0;
}
.addProductForm > input {
    width: 100%;
    padding: 10px 20px;
    margin-bottom: 15px;
    border: none;
    background: #e6e6e6;
    outline: none;
    border-radius: 5px;
}

textarea {
    resize: none;
    padding: 10px 20px;
    margin: 5px 0;
    border: none;
    background: #e6e6e6;
    outline: none;
    border-radius: 5px;
}

.addProductForm > button {
    width: 100%;
    margin-top: 20px;
    border: none;
    outline: none;
    padding: 10px;
    background: #4dff88;
    font-size: 14px;
    border-radius: 5px;
    font-weight: 500;
}

.addProductForm > button:hover {
    background: #00e64d;
    cursor: pointer;
}

.imageFile {
    margin-top: 5px;
}

.errorMsg {
    background: #ff8080;
    color: #ffffff;
    padding: 10px;
    border-radius: 5px;
    font-size: 15px;
    font-weight: bold;
    text-align: center;
    letter-spacing: 1px;
}

.msgWrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    padding: 0 50px;
}

.successMsg {
    background: #00b33c;
    color: #ffffff;
    padding: 10px;
    border-radius: 5px;
    font-size: 15px;
    font-weight: bold;
    text-align: center;
    letter-spacing: 1px;
}
.showMsg {
    display: block;
}

.hideMsg {
    display: none;
}
</style>
