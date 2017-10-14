import React from "react";
import ReactDOM from "react-dom";
import { Router, Route, browserHistory } from "react-router" 
import Root from './components/Root'
import oStore from "./store/store";
import { AcProduct } from "./actions/ac_product"
import "./index.css";


const get_promise = AcProduct.load()
oStore.dispatch(get_promise)

ReactDOM.render(
    <Root store={oStore} />,
    document.getElementById("root")
);
