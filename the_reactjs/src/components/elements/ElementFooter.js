//<prj>/the_reactjs/src/components/ElementFooter.js
import React from "react";
import { connect } from "react-redux"

const view_footer = (props) => {
    return (
        <footer className="footer">
            <div className="container">
                <span>{props.content}</span>
                <ul className="list-inline">
                    <li className="list-inline-item">
                        <a rel="nofollow"  className="btn btn-block" href="/"> 
                            <span className="fa fa-home"></span>
                        </a>
                    </li>
                    <li className="list-inline-item">
                        <a rel="nofollow" className="btn btn-block btn-social btn-github" href="https://github.com/eacevedof/prj_phpscheduler"> 
                            <span className="fa fa-github"></span>
                        </a>
                    </li>
                    <li className="list-inline-item">
                        <a rel="nofollow"  href="https://twitter.com/eacevedof" className="btn btn-block btn-social btn-twitter"> 
                            <span className="fa fa-twitter"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </footer>
    )//return jsx
    
}//view_footer

export default connect()(view_footer);