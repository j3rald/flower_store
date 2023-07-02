<template>
    <div class="cardContainer">
        <div class="cardBody">
            <div class="cardHeader">
                <div :class="[error.msg ? 'showMsg' : 'hideMsg', 'errorMsg']">
                    <h3>{{ error.msg }}</h3>
                </div>
                <h2 class="cardTitle">Flower Store</h2>
                <img
                    src="images/flower_store_logo.png"
                    alt="flower_store_logo"
                    width="250"
                    height="250"
                />
                <hr class="hr" />
                <div class="inputWrapper">
                    <div class="email">
                        <font-awesome-icon
                            icon="envelope"
                            class="envelopeIcon"
                        />
                        <input
                            type="text"
                            v-model="user.email"
                            placeholder="Email"
                        />
                    </div>

                    <div class="password">
                        <font-awesome-icon icon="lock" class="lockIcon" />
                        <input
                            type="password"
                            v-model="user.password"
                            placeholder="Password"
                        />
                    </div>

                    <button
                        type="button"
                        :class="[
                            user.email || user.password ? 'active' : 'inactive',
                            'login',
                        ]"
                        @click="submit"
                    >
                        <font-awesome-icon icon="arrow-circle-right" /> Login
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";

export default {
    data: function () {
        return {
            user: {
                email: "",
                password: "",
            },
            error: {
                msg: "",
            },
        };
    },
    methods: {
        submit() {
            try {
                if (this.user.email === "" || this.user.password === "") {
                    throw Error("Please input your email or password");
                } else {
                    axios
                        .get("api/users")
                        .then((response) => {
                            if (response.status === 200) {
                                for (let i = 0; i < response.data.length; i++) {
                                    if (
                                        response.data[i].email_address ===
                                            this.user.email &&
                                        response.data[i].password ===
                                            this.user.password
                                    ) {
                                        const token = Math.random()
                                            .toString(36)
                                            .slice(2);
                                        localStorage.setItem(
                                            "user",
                                            JSON.stringify({
                                                user: response.data[i],
                                                accessToken: token,
                                            })
                                        );

                                        // window.location.replace("/dashboard");
                                        break;
                                    } else {
                                        throw Error(
                                            "Incorrect email or password!"
                                        );
                                    }
                                }
                            }

                            window.location.replace("/home");
                        })
                        .catch((error) => {
                            return (this.error.msg = error.message);
                        });
                    this.$emit("submit", this.user.email, this.user.password);
                }
            } catch (error) {
                return (this.error.msg = error.message);
            }
        },
    },
};
</script>

<style scoped>
.cardContainer {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.cardHeader {
    text-align: center;
}
.cardBody {
    background: #ffddcc;
    width: 500px;
    padding: 20px 50px;
    box-shadow: 0.5px 0.5px 10px 0.5px black;
    border-radius: 5px;
}

.cardTitle {
    font-size: 35px;
    padding: 20px;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
}

.email {
    display: flex;
    justify-content: center;
    align-items: center;
}

.password {
    display: flex;
    justify-content: center;
    align-items: center;
}

.envelopeIcon {
    font-size: 35px;
    margin-right: 10px;
}

.lockIcon {
    font-size: 35px;
    margin-right: 15px;
}

input[type="text"] {
    width: 100%;
    margin: 5px 0;
    padding: 8px 10px;
    border: none;
    outline: none;
    background-color: #d9d9d9;
}

input[type="password"] {
    width: 100%;
    margin: 5px 0;
    padding: 8px 10px;
    border: none;
    outline: none;
    background-color: #d9d9d9;
}

.login {
    border: none;
    font-size: 18px;
    margin: 20px 0;
    width: 100%;
    padding: 8px;
    background: #8c8c8c;
    border-radius: 5px;
    outline: none;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
}

.login:hover {
    cursor: pointer;
    background: #ff6699;
}

.active {
    background: #ff80aa;
    color: #333333;
}

.inactive:hover {
    background: #8c8c8c;
    cursor: auto;
    pointer-events: none;
}

.inactive {
    color: #666666;
}
.errorMsg {
    background: #ff8080;
    color: #ffff;
    padding: 10px;
    border-radius: 5px;
    font-size: 15px;
    font-weight: bold;
    letter-spacing: 1px;
}
.showMsg {
    display: block;
}

.hideMsg {
    display: none;
}

.hr {
    margin: 20px 0;
}
</style>
