import { createStore, applyMiddleware, combineReducers } from "redux"
import fnThunk from "redux-thunk"

console.log("STORE")
console.log("STORE.fnThunk",fnThunk);
console.log("STORE.createStore",createStore)

const fnStoreProducts = (arState=[],oAction)=>{
    console.log("STORE.fnStoreProducts.oAction.type",oAction.type)
    console.log("STORE.fnStoreProducts.arState",arState)

    if(oAction.type === "REPLACE_PRODUCTS")
    {
        let oStateNew = oAction.arProducts
        return oStateNew
    }
    return arState;
}//fnStoreProducts

const fnStoreCart = (arState=[],oAction)=>{
    console.log("STORE.fnStoreCart.oAction.type",oAction.type)
    console.log("STORE.fnStoreCart.arState",arState)

    if(oAction.type === "ADD_TO_CART")
    {        
        return arState.concat(oAction.product)
    }
    else if(oAction.type === "REMOVE_FROM_CART")
    {
        return arState.filter(oProduct => oProduct.id !== oAction.product.id)
    }
    return arState;
}//fnStoreCart

const fnLogger = oStore => fnNext => oAction => {
    console.log("STORE.fnLogger dispatching oAction: ",oAction)
    console.log("STORE.fnLogger fnNext: ",fnNext)
    let oResult = fnNext(oAction)
    console.log("STORE.fnLogger oStore.getstate() next state: ",oStore.getState())
    console.log("STORE.fnLogger oResult: ",oResult)
    return oResult
}//fnLogger

const fnCombined = combineReducers({arCart:fnStoreCart,arProducts:fnStoreProducts})
console.log("STORE.fnCombined",fnCombined)

const fnMiddleWare = applyMiddleware(fnLogger,fnThunk)
console.log("STORE.fnMiddleWare",fnMiddleWare)

const oStore = createStore(fnCombined,fnMiddleWare)
console.log("STORE.oStore",oStore)
export default oStore
