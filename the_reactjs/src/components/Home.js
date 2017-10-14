//<prj>/the_reactjs/src/components/ElementFooter.js
import React from "react";
import { Navbar, Grid, Row, Col } from "react-bootstrap";
import ProductList from "./ProductList";
import ShoppingCart from "./ShoppingCart";
import ElementFooter from "./elements/ElementFooter";
import { connect } from "react-redux"

const view_home = (props) => {
    return (
          <div className="container-fluid">
                <Navbar inverse staticTop>
                    <Navbar.Header>
                        <Navbar.Brand>
                            <a href="/">Ecommerce</a>
                        </Navbar.Brand>
                    </Navbar.Header>
                </Navbar>

                <Grid>
                    <Row>
                        <Col sm={8}>
                            <ProductList />
                        </Col>
                        <Col sm={4}>
                            <ShoppingCart />
                        </Col>
                    </Row>
                </Grid>
                <ElementFooter/>
            </div>
    )//return jsx
    
}//view_home

export default connect()(view_home);