//<prj>/the_reactjs/src/components/ProductList.js
import React from "react";
import { Button, Glyphicon } from "react-bootstrap";
import { AcCart } from "../actions/ac_cart"
import { AcProduct } from "../actions/ac_product"
import { connect } from "react-redux"

console.log("PRDUCTLIST")

const oStyles = {
    products: {
        display: 'flex',
        alignItems: 'stretch',
        flexWrap: 'wrap'
    },
    product: {
        width: '220px',
        marginLeft: 10,
        marginRight: 10
    }
}//oStyles

//get_products,get_dispatchers
const view_productlist = ({ arProducts, fnAddToCart }) => {
    console.log("PRODUCTLIST.view_productlist.render()")
    console.log("PRODUCTLIST.view_productlist: arProducts",arProducts)
    console.log("PRODUCTLIST.view_productlist: fnAddToCart",fnAddToCart)
    
    return (
        <div style={oStyles.products}>
            {arProducts.map(oProduct =>
                <div className="thumbnail" style={oStyles.product} key={oProduct.id}>
                    <img src={oProduct.image} alt={oProduct.name} />
                    <div className="caption">
                        <h4>{oProduct.name}</h4>
                        <p>
                            <Button bsStyle="primary" onClick={() => fnAddToCart(oProduct)} role="button" disabled={oProduct.inventory <= 0}>
                                ${oProduct.price} <Glyphicon glyph="shopping-cart" />
                            </Button>
                        </p>
                    </div>
                </div>)
            }
        </div>
    )//render
}//view_productlist

const get_products = (oState)=>{
    console.log("PRODUCTLIST.get_products return oStateNew con arProducts")
    let oStateNew = {
        arProducts : oState.arProducts
    }
    return oStateNew
}//get_products

const get_dispatchers = fnDispatch => {
    console.log("PRODUCTLIST.get_dispatchers devuelve oDispatch")
    let oDispatch = {
        fnLoadProducts : arProducts => {
            console.log("PRODUCTLIST.get_dispatchers.oDispatch.fnLoadProducts")
            let oAction = AcProduct.load(arProducts)
            fnDispatch(oAction)
        },
        fnAddToCart : oProduct => {
            console.log("PRODUCTLIST.get_dispatchers.oDispatch.fnAddToCart")
            let oAction = AcCart.add(oProduct)
            fnDispatch(oAction)
        }
    }
    return oDispatch
}//get_dispatchers

export default connect(get_products,get_dispatchers)(view_productlist);