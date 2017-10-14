//<prj>/the_reactjs/src/components/ShoppingCart.js
import React from "react";
import { Panel, Table, Button, Glyphicon } from "react-bootstrap"
import {AcCart} from "../actions/ac_cart"
import {connect} from "react-redux"

console.log("SHOPPINGCART")

const oStyles = {
    footer: {
        fontWeight: 'bold'
    }
}//oStyles

const view_shoppingcart = ({arCart,fnRemoveFromCart})=>{
    console.log("SHOPPINGCART.view_shoppingcart")
    return (
        <Panel header="Shopping Cart">
            <Table fill>
                <tbody>
                  {arCart.map(oProduct =>
                    <tr key={oProduct.id}>
                        <td>{oProduct.name}</td>
                        <td className="text-right">${oProduct.price}</td>
                        <td className="text-right">
                            <Button bsSize="xsmall" bsStyle="danger" onClick={() => fnRemoveFromCart(oProduct)}>
                                <Glyphicon glyph="trash" />
                            </Button>
                        </td>
                    </tr>
                  )}
                </tbody>
                <tfoot>
                    <tr>
                        <td colSpan="4" style={oStyles.footer}>
                          Total: ${arCart.reduce((fSum,oProduct) => fSum + oProduct.price, 0)}
                        </td>
                    </tr>
                </tfoot>
            </Table>
        </Panel>
    )//return
    
}//view_shoppingcart


const get_cartlist = oState => {
    console.log("SHOPPINGCART.get_cartlist return oStateNew con arCart")
    let oStateNew = {
        arCart: oState.arCart
    } 
    return oStateNew 
}//get_cartlist

const get_dispatchers = fnDispatch => {
    console.log("SHOPPINGCART.get_dispatchers return oDispatch")
    let oDispatch = {
        fnRemoveFromCart : oProduct => {
            console.log("SHOPPINGCART.get_dispatchers.oDispatch.fnRemoveFromCart")
            let oAction = AcCart.remove(oProduct)
            fnDispatch(oAction)
        }//removeFromCart 
    }//oDispatch
    return oDispatch 
}//get_dispatchers

export default connect(get_cartlist,get_dispatchers)(view_shoppingcart);