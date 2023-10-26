import axios from "axios";

function followingShop(shopId, userId, type) {
    axios.post(`/api/shop/follow`, {
        shop_id: shopId,
        user_id: userId,
        type: type,
    })
        .then((res) => {
            if (res.data.msg === "ok") {
               return res.data.status;
            } else {
                return 'error';
            }
        })
        .catch((err) => {
            console.log(err);
            return 'error';
        });
}

export default followingShop;
