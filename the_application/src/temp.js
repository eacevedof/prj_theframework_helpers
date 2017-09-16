//temp.js
const f = (...p)=>{
    //p es un array de arrays. 
    console.log("p:",p,"typeof p:",typeof p)
    //arguments es un objeto de objetos
    //console.log("arguments:",arguments,"typeof arguments:",typeof arguments)
}

f("a","b",1,2,3,["xx","yy","77"])

const ar1 = [1,3,4,5,6]
const ar2 = ["01","02","03"]
const oState = {a:"xx",b:"yy",c:"zz"}
const ar3 = [...ar1,...ar2]

console.log(ar3)

const reducer = (arState,oAction)=>{
    return {...arState,oCart:arState.cart}
}

const arSt = [2,3,4]
arSt.cart = ()=>1
console.log("reducer:",reducer(arSt,null)) 
//salida sin spread:
//reducer: { arState: [ 2, 3, 4, cart: [Function] ], oCart: [Function] }
//salida con spread:
//    return {...arState,oCart:arState.cart}
//            ^^^
