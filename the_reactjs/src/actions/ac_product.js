import fnAxios from "axios"

const AcProduct = {
    
    load : () => {
        console.log("ACTIONCREATORS.fnAcLoadProducts")

        return fnDispatch => {
            console.log("ACTIONCREATORS.fnAcLoadProducts.fnDispatch",fnDispatch)
            let oPromise = fnAxios.get("http://json.theframework.es/index.php?getfile=demoproducts.json")
                    .then(oResponse => {
                        console.log("ACTIONCREATORS.fnAxios.then oResponse:",oResponse)
                        let oAction = {
                            type: "REPLACE_PRODUCTS",
                            arProducts: oResponse.data
                        }                    
                        fnDispatch(oAction)
                    })//then
            console.log("oPromise",oPromise)
            return oPromise
        }//return 
    }//load
   
}//AcProduct

export {AcProduct}