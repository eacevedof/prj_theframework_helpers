const AcCart = {
    
    add : oProduct => {
        //aqui se podría llamar a un servidor remoto
        console.log("ACCART.add return oAction+oProduct")
        let oAction = {
            type: "ADD_TO_CART",
            product: oProduct
        }
        return oAction
    },//add
    
    remove : oProduct => {
        console.log("ACTIONCREATORS.fnAcRemoveFromCart return oAction+oProduct")
        let oAction = {
            type: "REMOVE_FROM_CART",
            product: oProduct
        }    
        return oAction
    },//remove
}//AcCart

export {AcCart}