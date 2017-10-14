//=================================================
//                REDUX-THUNK.JS
//=================================================
//<editor-fold defaultstate="collapsed" desc="REDUX-THUNK.JS">
//C:\xampp\htdocs\prj_reactjs\node_modules\redux-thunk\src\index.js
function createThunkMiddleware(extraArgument) 
{
    return ({ fnDispatch, fnGetState }) => fnNext => mxAction => {
        if(typeof mxAction === 'function')
            return mxAction(fnDispatch, fnGetState, extraArgument);
        return fnNext(mxAction);
    }//fn 
    
}//createThunkMiddleware

const thunk = createThunkMiddleware();
thunk.withExtraArgument = createThunkMiddleware;

export default thunk;
//</editor-fold>
//=================================================
//                AXIOS.JS
//=================================================
//<editor-fold defaultstate="collapsed" desc="AXIOS.JS">
//C:\xampp\htdocs\prj_phpscheduler\the_reactjs\node_modules\axios\lib\axios.js
'use strict';

var oUtils = require('./utils');
var fnBind = require('./helpers/bind');
var ClassAxios = require('./core/Axios');
var arDefaults = require('./defaults');

/**
 * Create an instance of Axios
 *
 * @param {Object} defaultConfig The default config for the instance
 * @return {ClassAxios} A new instance of Axios
 */
function createInstance(defaultConfig) {
  var oContext = new ClassAxios(defaultConfig);
  var oAxiosInstance = fnBind(ClassAxios.prototype.request, oContext);

  // Copy axios.prototype to instance
  oUtils.extend(oAxiosInstance, ClassAxios.prototype, oContext);

  // Copy context to instance
  oUtils.extend(oAxiosInstance, oContext);

  return oAxiosInstance;
}

// Create the default instance to be exported
var oAxios = createInstance(arDefaults);

// Expose Axios class to allow class inheritance
oAxios.Axios = ClassAxios;

// Factory for creating new instances
oAxios.create = function create(oInstanceConfig) {
  return createInstance(oUtils.merge(arDefaults, oInstanceConfig));
};

// Expose Cancel & CancelToken
oAxios.Cancel = require('./cancel/Cancel');
oAxios.CancelToken = require('./cancel/CancelToken');
oAxios.isCancel = require('./cancel/isCancel');

// Expose all/spread
oAxios.all = function all(arPromises) {
  return Promise.all(arPromises);
};
oAxios.spread = require('./helpers/spread');

module.exports = oAxios;

// Allow use of default import syntax in TypeScript
module.exports.default = oAxios;
//</editor-fold>
//=================================================
//               REDUX.JS (MIDDLEWARE)
//=================================================
//<editor-fold defaultstate="collapsed" desc="REDUX.JS MIDDLEWARE">
//C:\xampp\htdocs\prj_reactjs\node_modules\redux\src\applyMiddleware.js
import compose from './compose'
/**
 * Creates a store enhancer that applies middleware to the dispatch method
 * of the Redux store. This is handy for a variety of tasks, such as expressing
 * asynchronous actions in a concise manner, or logging every action payload.
 *
 * See `redux-thunk` package as an example of the Redux middleware.
 *
 * Because middleware is potentially asynchronous, this should be the first
 * store enhancer in the composition chain.
 *
 * Note that each middleware will be given the `dispatch` and `getState` functions
 * as named arguments.
 *
 * @param {...Function} fnMiddlewares The middleware chain to be applied.
 * @returns {Function} A store enhancer applying the middleware.
 */
export default function applyMiddleware(...fnMiddlewares) {
  return (fnCreateStore) => (fnReducer, oPreloadedState, fnEnhancer) => {
    const oStore = fnCreateStore(fnReducer, oPreloadedState, fnEnhancer)
    let fnDispatch = oStore.dispatch
    let arChain = []

    const oMiddlewareAPI = {
      getState: oStore.getState,
      dispatch: (oAction) => fnDispatch(oAction)
    }
    arChain = fnMiddlewares.map(fnMiddleW => fnMiddleW(oMiddlewareAPI))
    fnDispatch = compose(...arChain)(oStore.dispatch)

    return {
      ...oStore,
      fnDispatch
    }
  }//
}//applyMiddleware
//</editor-fold>
//=================================================
//               REDUX.JS (CREATESTORE)
//=================================================
//<editor-fold defaultstate="collapsed" desc="REDUX.JS CREATESTORE">
//C:\xampp\htdocs\prj_reactjs\node_modules\redux\src\createStore.js
/**
 * Creates a Redux store that holds the state tree.
 * The only way to change the data in the store is to call `dispatch()` on it.
 *
 * There should only be a single store in your app. To specify how different
 * parts of the state tree respond to actions, you may combine several reducers
 * into a single reducer function by using `combineReducers`.
 *
 * @param {Function} fnReducer A function that returns the next state tree, given
 * the current state tree and the action to handle.
 *
 * @param {any} [oPreloadedState] The initial state. You may optionally specify it
 * to hydrate the state from the server in universal apps, or to restore a
 * previously serialized user session.
 * If you use `combineReducers` to produce the root reducer function, this must be
 * an object with the same shape as `combineReducers` keys.
 *
 * @param {Function} [fnEnhancer] The store enhancer. You may optionally specify it
 * to enhance the store with third-party capabilities such as middleware,
 * time travel, persistence, etc. The only store enhancer that ships with Redux
 * is `applyMiddleware()`.
 *
 * @returns {Store} A Redux store that lets you read the state, dispatch actions
 * and subscribe to changes.
 */
export default function createStore(fnReducer, oPreloadedState, fnEnhancer) {
  if (typeof oPreloadedState === 'function' && typeof fnEnhancer === 'undefined') {
    fnEnhancer = oPreloadedState
    oPreloadedState = undefined
  }

  if (typeof fnEnhancer !== 'undefined') {
    if (typeof fnEnhancer !== 'function') {
      throw new Error('Expected the enhancer to be a function.')
    }
    
    //recursividad?
    return fnEnhancer(createStore)(fnReducer, oPreloadedState)
  }

  if (typeof fnReducer !== 'function') {
    throw new Error('Expected the reducer to be a function.')
  }

  let fnCurrentReducer = fnReducer
  let oCurrentState = oPreloadedState
  let arCurrentListeners = []
  let arNextListeners = arCurrentListeners
  let isDispatching = false

  function ensureCanMutateNextListeners() {
    if (arNextListeners === arCurrentListeners) {
      arNextListeners = arCurrentListeners.slice()
    }
  }//ensureCanMutateNextListeners

  /**
   * Reads the state tree managed by the store.
   *
   * @returns {any} The current state tree of your application.
   */
  function getState() {
    return oCurrentState
  }//getState

  /**
   * Adds a change listener. It will be called any time an action is dispatched,
   * and some part of the state tree may potentially have changed. You may then
   * call `getState()` to read the current state tree inside the callback.
   *
   * You may call `dispatch()` from a change listener, with the following
   * caveats:
   *
   * 1. The subscriptions are snapshotted just before every `dispatch()` call.
   * If you subscribe or unsubscribe while the listeners are being invoked, this
   * will not have any effect on the `dispatch()` that is currently in progress.
   * However, the next `dispatch()` call, whether nested or not, will use a more
   * recent snapshot of the subscription list.
   *
   * 2. The listener should not expect to see all state changes, as the state
   * might have been updated multiple times during a nested `dispatch()` before
   * the listener is called. It is, however, guaranteed that all subscribers
   * registered before the `dispatch()` started will be called with the latest
   * state by the time it exits.
   *
   * @param {Function} fnListener A callback to be invoked on every dispatch.
   * @returns {Function} A function to remove this change listener.
   */
  function subscribe(fnListener) {
    if (typeof fnListener !== 'function') {
      throw new Error('Expected listener to be a function.')
    }

    let isSubscribed = true

    ensureCanMutateNextListeners()
    arNextListeners.push(fnListener)

    return function fn_unsubscribe() {
      if (!isSubscribed) {
        return
      }

      isSubscribed = false

      ensureCanMutateNextListeners()
      const index = arNextListeners.indexOf(fnListener)
      arNextListeners.splice(index, 1)
    }//fn_unsubscribe
    
  }//subscribe

  /**
   * Dispatches an action. It is the only way to trigger a state change.
   *
   * The `reducer` function, used to create the store, will be called with the
   * current state tree and the given `action`. Its return value will
   * be considered the **next** state of the tree, and the change listeners
   * will be notified.
   *
   * The base implementation only supports plain object actions. If you want to
   * dispatch a Promise, an Observable, a thunk, or something else, you need to
   * wrap your store creating function into the corresponding middleware. For
   * example, see the documentation for the `redux-thunk` package. Even the
   * middleware will eventually dispatch plain object actions using this method.
   *
   * @param {Object} oArgAction A plain object representing “what changed”. It is
   * a good idea to keep actions serializable so you can record and replay user
   * sessions, or use the time travelling `redux-devtools`. An action must have
   * a `type` property which may not be `undefined`. It is a good idea to use
   * string constants for action types.
   *
   * @returns {Object} For convenience, the same action object you dispatched.
   *
   * Note that, if you use a custom middleware, it may wrap `dispatch()` to
   * return something else (for example, a Promise you can await).
   */
  function dispatch(oArgAction) {
    if (!isPlainObject(oArgAction)) {
      throw new Error(
        'Actions must be plain objects. ' +
        'Use custom middleware for async actions.'
      )
    }

    if (typeof oArgAction.type === 'undefined') {
      throw new Error(
        'Actions may not have an undefined "type" property. ' +
        'Have you misspelled a constant?'
      )
    }

    if (isDispatching) {
      throw new Error('Reducers may not dispatch actions.')
    }

    try {
      isDispatching = true
      oCurrentState = fnCurrentReducer(oCurrentState, oArgAction)
    } finally {
      isDispatching = false
    }

    const arListeners = arCurrentListeners = arNextListeners
    for (let i = 0; i < arListeners.length; i++) {
      const listener = arListeners[i]
      listener()
    }

    return oArgAction
  }//function dispatch

  /**
   * Replaces the reducer currently used by the store to calculate the state.
   *
   * You might need this if your app implements code splitting and you want to
   * load some of the reducers dynamically. You might also need this if you
   * implement a hot reloading mechanism for Redux.
   *
   * @param {Function} fnNextReducer The reducer for the store to use instead.
   * @returns {void}
   */
  function replaceReducer(fnNextReducer) {
    if (typeof fnNextReducer !== 'function') {
      throw new Error('Expected the nextReducer to be a function.')
    }

    fnCurrentReducer = fnNextReducer
    dispatch({ type: ActionTypes.INIT })
    
  }//replaceReducer

  /**
   * Interoperability point for observable/reactive libraries.
   * @returns {observable} A minimal observable of state changes.
   * For more information, see the observable proposal:
   * https://github.com/tc39/proposal-observable
   */
  function observable() {
    const fnOuterSubscribe = subscribe
    return {
      /**
       * The minimal observable subscription method.
       * @param {Object} oObserver Any object that can be used as an observer.
       * The observer object should have a `next` method.
       * @returns {subscription} An object with an `unsubscribe` method that can
       * be used to unsubscribe the observable from the store, and prevent further
       * emission of values from the observable.
       */
      subscribe(oObserver) {
        if (typeof oObserver !== 'object') {
          throw new TypeError('Expected the observer to be an object.')
        }

        function observeState() {
          if (oObserver.next) {
            oObserver.next(getState())
          }
        }//observeState

        observeState()
        const fnUnsubscribe = fnOuterSubscribe(observeState)
        return { fnUnsubscribe }
      },//.subscribe

      [$$observable]() {
        return this
      }//[$$observable]
      
    }//return
  }//function observable

  // When a store is created, an "INIT" action is dispatched so that every
  // reducer returns their initial state. This effectively populates
  // the initial state tree.
  dispatch({ type: ActionTypes.INIT })

  return {
    dispatch,
    subscribe,
    getState,
    replaceReducer,
    [$$observable]: observable
  }//return
  
}//export default function createStore
//</editor-fold>
//=================================================
//               REDUX.JS (COMBINEREDUCERS)
//=================================================
//<editor-fold defaultstate="collapsed" desc="REDUX.JS COMBINEREDUCERS">
//C:\xampp\htdocs\prj_reactjs\node_modules\redux\src\combineReducers.js
import { ActionTypes } from './createStore'
import isPlainObject from 'lodash/isPlainObject'
import warning from './utils/warning'

function getUndefinedStateErrorMessage(sKey, oAction) {
  const sActionType = oAction && oAction.type
  const sActionName = (sActionType && `"${sActionType.toString()}"`) || 'an action'

  return (
    `Given action ${sActionName}, reducer "${sKey}" returned undefined. ` +
    `To ignore an action, you must explicitly return the previous state. ` +
    `If you want this reducer to hold no value, you can return null instead of undefined.`
  )
}//getUndefinedStateErrorMessage

function getUnexpectedStateShapeWarningMessage(oState, oReducers, oAction, oUnexpectedKeyCache) {
  const arReducerKeys = Object.keys(oReducers)
  const sArgumentName = oAction && oAction.type === ActionTypes.INIT ?
    'preloadedState argument passed to createStore' :
    'previous state received by the reducer'

  if (arReducerKeys.length === 0) {
    return (
      'Store does not have a valid reducer. Make sure the argument passed ' +
      'to combineReducers is an object whose values are reducers.'
    )
  }

  if (!isPlainObject(oState)) {
    return (
      `The ${sArgumentName} has unexpected type of "` +
      ({}).toString.call(oState).match(/\s([a-z|A-Z]+)/)[1] +
      `". Expected argument to be an object with the following ` +
      `keys: "${arReducerKeys.join('", "')}"`
    )
  }

  const arUnexpectedKeys = Object.keys(oState).filter(sKey =>
    !oReducers.hasOwnProperty(sKey) &&
    !oUnexpectedKeyCache[sKey]
  )

  arUnexpectedKeys.forEach(key => {
    oUnexpectedKeyCache[key] = true
  })

  if (arUnexpectedKeys.length > 0) {
    return (
      `Unexpected ${arUnexpectedKeys.length > 1 ? 'keys' : 'key'} ` +
      `"${arUnexpectedKeys.join('", "')}" found in ${sArgumentName}. ` +
      `Expected to find one of the known reducer keys instead: ` +
      `"${arReducerKeys.join('", "')}". Unexpected keys will be ignored.`
    )
  }
}//getUnexpectedStateShapeWarningMessage

function assertReducerShape(oReducers) {
  Object.keys(oReducers).forEach(sKey => {
    const fnReduce = oReducers[sKey]
    const oInitialState = fnReduce(undefined, { type: ActionTypes.INIT })

    if (typeof oInitialState === 'undefined') {
      throw new Error(
        `Reducer "${sKey}" returned undefined during initialization. ` +
        `If the state passed to the reducer is undefined, you must ` +
        `explicitly return the initial state. The initial state may ` +
        `not be undefined. If you don't want to set a value for this reducer, ` +
        `you can use null instead of undefined.`
      )
    }

    const type = '@@redux/PROBE_UNKNOWN_ACTION_' + Math.random().toString(36).substring(7).split('').join('.')
    if (typeof fnReduce(undefined, { type }) === 'undefined') {
      throw new Error(
        `Reducer "${sKey}" returned undefined when probed with a random type. ` +
        `Don't try to handle ${ActionTypes.INIT} or other actions in "redux/*" ` +
        `namespace. They are considered private. Instead, you must return the ` +
        `current state for any unknown actions, unless it is undefined, ` +
        `in which case you must return the initial state, regardless of the ` +
        `action type. The initial state may not be undefined, but can be null.`
      )
    }
  })//foreach
}//assertReducerShape

/**
 * Turns an object whose values are different reducer functions, into a single
 * reducer function. It will call every child reducer, and gather their results
 * into a single state object, whose keys correspond to the keys of the passed
 * reducer functions.
 *
 * @param {Object} reducers An object whose values correspond to different
 * reducer functions that need to be combined into one. One handy way to obtain
 * it is to use ES6 `import * as reducers` syntax. The reducers may never return
 * undefined for any action. Instead, they should return their initial state
 * if the state passed to them was undefined, and the current state for any
 * unrecognized action.
 *
 * @returns {Function} A reducer function that invokes every reducer inside the
 * passed object, and builds a state object with the same shape.
 */
export default function combineReducers(oReducers) {
  //oReducers: {arCart:fnStoreCart,arProducts:fnStoreProducts}
  const arReducerKeys = Object.keys(oReducers)
  const oFinalReducers = {}
  for (let i = 0; i < arReducerKeys.length; i++) {
    const sKey = arReducerKeys[i]

    if (process.env.NODE_ENV !== 'production') {
      if (typeof oReducers[sKey] === 'undefined') {
        warning(`No reducer provided for key "${sKey}"`)
      }
    }

    if (typeof oReducers[sKey] === 'function') {
      oFinalReducers[sKey] = oReducers[sKey]
    }
  }
  const arFinalReducerKeys = Object.keys(oFinalReducers)

  let oUnexpectedKeyCache
  if (process.env.NODE_ENV !== 'production') {
    oUnexpectedKeyCache = {}
  }

  let shapeAssertionError
  try {
    //comprueba que la funcion reductora devuelva valores correctos  
    assertReducerShape(oFinalReducers)
  } catch (e) {
    shapeAssertionError = e
  }

  return function combination(oArgState = {}, oArgAction) {
      //usa como constantes oFinalReducers,arFinalReducerKeys
      //si hay un error  detectado por assert
    if (shapeAssertionError) {
      throw shapeAssertionError
    }

    if (process.env.NODE_ENV !== 'production') {
      const warningMessage = getUnexpectedStateShapeWarningMessage(oArgState
                                ,oFinalReducers,oArgAction,oUnexpectedKeyCache)
      if (warningMessage) {
        warning(warningMessage)
      }
    }

    let hasStateChanged = false
    const oNextState = {}
    for (let i = 0; i < arFinalReducerKeys.length; i++) {
      const sKey = arFinalReducerKeys[i]
      const fnReducer = oFinalReducers[sKey]
      //recupera el estado actual (el que se le pasa)
      const oPreviousStateForKey = oArgState[sKey]
      //se calcula el nuevo estadon llamando al reducer
      const oNextStateForKey = fnReducer(oPreviousStateForKey, oArgAction)
      if (typeof oNextStateForKey === 'undefined') {
        const errorMessage = getUndefinedStateErrorMessage(sKey, oArgAction)
        throw new Error(errorMessage)
      }
      oNextState[sKey] = oNextStateForKey
      hasStateChanged = hasStateChanged || oNextStateForKey !== oPreviousStateForKey
    }//for(arFinalReducers)
    return hasStateChanged ? oNextState : oArgState
  }//combination
}//function combineReducers
//</editor-fold>
//=================================================
//               STORE.JS
//=================================================
//<editor-fold defaultstate="collapsed" desc="STORE.JS">
//C:\xampp\htdocs\prj_reactjs\src\store.js
//store.js 1.0.2 video 7: https://youtu.be/G_dbuk9B2pQ?list=PLxyfMWnjW2kuyePV1Gzn5W_gr3BGIZq8G&t=40
//se importa el gestor de estado y acciones "createStore"
//https://github.com/makeitrealcamp/redux-example/blob/react-redux/src/store.js
//http://redux.js.org/docs/api/applyMiddleware.html
import { createStore, applyMiddleware, combineReducers } from "redux"
//redux-thunk hackea el action para poder retornar una función para que pueda ser 
//ejecutada directamente, esta función podra hacer llamadas asincronas. Ya no devolvera una cadena de texto
//https://youtu.be/dRlD0YqU6w4?t=417 importa redux-thunk
import fnThunk from "redux-thunk"
//El store matiene el acceso al estado de forma centralizada
//Permite el acceso al estado a traves de getState()
//Registra los suscriptores a través de subscribe(fn)
//Permite que el estado sea actualizado a través del método dispatch(fn)
console.log("load 1: store.js")
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
    //console.log("fnLogger.oStore: ",oStore," | fnLogger.fnNext: ",fnNext," | fnLogger.oAction: ",oAction)
    console.log("STORE.fnLogger dispatching oAction: ",oAction)
    console.log("STORE.fnLogger fnNext: ",fnNext)
    let oResult = fnNext(oAction)
    console.log("STORE.fnLogger oStore.getstate() next state: ",oStore.getState())
    console.log("STORE.fnLogger oResult: ",oResult)
    return oResult
}//fnLogger

//exporta un objeto oStore. La función reductora estara a la escucha de los cambios de estado para actualizarlos.
//se inicializa con un estado inicial vacio arCart:[]
//fnCombined es una funcion que recibe un array de variables de estado y sus funciones
//para ser jecutadas una a una en el momento que es llamda. Recibe como parametros el estado actual
//y la accion. Devuelve un booleano indicando si ha cambiado el estado, comprobando el estado actual y el 
//producido por la llamada a cada funcion reductora
const fnCombined = combineReducers({arCart:fnStoreCart,arProducts:fnStoreProducts})
console.log("STORE.fnCombined",fnCombined)

//function applyMiddleware(...middlewares) 
const fnMiddleWare = applyMiddleware(fnLogger,fnThunk)
console.log("STORE.fnMiddleWare",fnMiddleWare)

//function createStore(reducer, preloadedState, enhancer)
const oStore = createStore(fnCombined,fnMiddleWare)
//oStore: {dispatch: ƒ, subscribe: ƒ, getState: ƒ, replaceReducer: ƒ, Symbol(observable): ƒ}
console.log("STORE.oStore",oStore)
export default oStore
//=================================================
//               ACTIONCREATORS.JS
//=================================================
//C:\xampp\htdocs\prj_reactjs\src\actionCreators.js
//actionCreators.js 
//funciones que se le pasan al store
//son funciones que devuelve un "Action"
import fnAxios from "axios"

console.log("load 2: actionCreators.js")
console.log("ACTIONCREATORS.fnAxios: ",fnAxios)

const fnAcAddToCart = oProduct => {
    //aqui se podría llamar a un servidor remoto
    console.log("ACTIONCREATORS.fnAcAddToCart return oAction+oProduct")
    let oAction = {
        type: "ADD_TO_CART",
        product: oProduct
    }
    return oAction
}//fnAcAddToCart

const fnAcRemoveFromCart = oProduct => {
    console.log("ACTIONCREATORS.fnAcRemoveFromCart return oAction+oProduct")
    let oAction = {
        type: "REMOVE_FROM_CART",
        product: oProduct
    }    
    return oAction
}//acRemoveFromCart

//https://youtu.be/dRlD0YqU6w4?t=517 configuracion de esta funcion
const fnAcLoadProducts = ()=>{
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
    }//return fnDispatch

}//fnAcLoadProducts

//publico estas dos funciones
export {fnAcAddToCart, fnAcRemoveFromCart, fnAcLoadProducts}
//</editor-fold>
//=================================================
//               SHOPPINGCART.JS
//=================================================
//<editor-fold defaultstate="collapsed" desc="SHOPPINGCART.JS">
//C:\xampp\htdocs\prj_reactjs\src\components\ShoppingCart.js
import React from 'react'; //Nos sobra Component al convertir a función la clase
import { Panel, Table, Button, Glyphicon } from 'react-bootstrap';
import {fnAcRemoveFromCart} from "../actionCreators"
//react-redux: crea por nosotros un componente contenedor "<Provider>" (en index.js) que envuelve nuestro componente y le pasa 
//todo por propiedades (estado y metodos que necesitemos)
//nos ayuda a crear componentes funcionales (en vez de clases).  Es decir como vistas puras
//https://youtu.be/dAm3jicYvR8?t=225 Indica lo que sobra despues de usar react-redux
//https://youtu.be/dAm3jicYvR8?t=407 cambiar clases a funciones
import {connect} from "react-redux"

console.log("load 4: ShoppingCart.js")

const oStyles = {
    footer: {
        fontWeight: 'bold'
    }
}//oStyles

//Este archivo ahora se convierte en un componente presentacional.
//no tiene lógica
//destructurar un argumento. el objeto props lo partimos en objetos
//{arCart,fnRemoveFromCart} = obj.arCart,obj.fnRemoveFromCart
const fnRenderShoppingCart = ({arCart,fnRemoveFromCart})=>{

    console.log("SHOPPINGCART.fnRenderShoppingCart")
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
    
}//fnRenderShoppingCart

//con esto evitamos tener el constuctor y el store
const fnMapStateToProps = oState => {
    console.log("SHOPPINGCART.fnMapStateToProps return oStateNew con arCart")
    let oStateNew = {
        arCart: oState.arCart
    } 
    return oStateNew 
}//fnMapStateToProps

//fnDispatch: store.fndispatch
const fnMapDispatchToProps = fnDispatch => {
    console.log("SHOPPINGCART.fnMapDispatchToProps return oDispatch")
    //hay q devolver un objeto con los metodos que vamos a utilizar en el componente
    //presentacional, estos objetos estaran disponibles en la capa de presentación a traves 
    //de props
    let oDispatch = {
        fnRemoveFromCart : oProduct => {
            console.log("SHOPPINGCART.fnMapDispatchToProps.oDispatch.fnRemoveFromCart")
            //fnAcRemoveFromCart: ActionCreator
            let oAction = fnAcRemoveFromCart(oProduct)
            fnDispatch(oAction)
        }//removeFromCart 
    }//oDispatch
    return oDispatch 
}//fnMapDispatchToProps

//connect el pasa el estado y las funciones a <Provider>
//fnMapStateToProps(oState);fnMapDispatchToProps(fn)
//fnRenderShoppingCart({arCart,fnRemoveFromCart})
//connect crea dos listeners para los cambios de fnRenderShoppingCart.
export default connect(fnMapStateToProps,fnMapDispatchToProps)(fnRenderShoppingCart);
//</editor-fold>
//=================================================
//               PRODUCTLIST.JS
//=================================================   
//<editor-fold defaultstate="collapsed" desc="PRODUCTLIST.JS">
//C:\xampp\htdocs\prj_reactjs\src\components\ProductList.js
import React from 'react';
import { Button, Glyphicon } from 'react-bootstrap';
//se necesita el store para actualizar el estado a partir de la accion recibida 
//import oStore from "../store"
//devuelve la accion a ejecutar
import { fnAcAddToCart, fnAcLoadProducts } from "../actionCreators"
import { connect } from "react-redux"

console.log("load 3: ProductList.js")

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

const fnProductList = ({ arProducts, fnAddToCart }) => {
    console.log("PRODUCTLIST.fnProductList.render()")
    console.log("PRODUCTLIST.fnProductList: arProducts",arProducts)
    console.log("PRODUCTLIST.fnProductList: fnAddToCart",fnAddToCart)
    
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
}//fnProductList

const fnMapStateToProps = (oState)=>{
    console.log("PRODUCTLIST.fnMapStateToProps return oStateNew con arProducts")
    let oStateNew = {
        arProducts : oState.arProducts
    }
    return oStateNew
}

const fnMapDispatchToProps = fnDispatch => {
    console.log("PRODUCTLIST.fnMapDispatchToProps devuelve oDispatch")
    let oDispatch = {
        fnLoadProducts : arProducts => {
            console.log("PRODUCTLIST.fnMapDispatchToProps.oDispatch.fnLoadProducts")
            let oAction = fnAcLoadProducts(arProducts)
            fnDispatch(oAction)
        },
        fnAddToCart : oProduct => {
            console.log("PRODUCTLIST.fnMapDispatchToProps.oDispatch.fnAddToCart")
            let oAction = fnAcAddToCart(oProduct)
            fnDispatch(oAction)
        }
    }
    return oDispatch
}

export default connect(fnMapStateToProps,fnMapDispatchToProps)(fnProductList);
//</editor-fold>
//=================================================
//               APP.JS
//=================================================  
//<editor-fold defaultstate="collapsed" desc="APP.JS">
//C:\xampp\htdocs\prj_reactjs\src\App.js
import React, { Component } from 'react';
import { Navbar, Grid, Row, Col } from 'react-bootstrap';
import ProductList from './components/ProductList';
import ShoppingCart from './components/ShoppingCart';
import './App.css';

console.log("load 5: App.js")

class App extends Component {
    render() {
        console.log("APP.App.render")
        return (
            <div>
                <Navbar inverse staticTop>
                    <Navbar.Header>
                        <Navbar.Brand>
                            <a href="#">Ecommerce</a>
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
            </div>
        ) //return
    }//render
}//App

export default App;
//</editor-fold>
//=================================================
//               INDEX.JS
//=================================================  
//<editor-fold defaultstate="collapsed" desc="INDEX.JS">
//C:\xampp\htdocs\prj_reactjs\src\index.js
import React from 'react';
import ReactDOM from 'react-dom';
import App from './App';
import './index.css';
//store tiene 3 metodos subscribe(fn),dispatch(oAction),getState(), el store es un observador??
import oStore from "./store";
import {Provider} from "react-redux"
import {fnAcLoadProducts} from "./actionCreators"

console.log("INDEX.Rreact: ",React)
console.log("INDEX.ReactDOM: ",ReactDOM)
console.log("INDEX.App: ",App)
console.log("INDEX.oStore: ",oStore)
console.log("INDEX.Provider: ",Provider)
console.log("INDEX.fnAcLoadProducts: ",fnAcLoadProducts)

const fnProdDispatch = fnAcLoadProducts()
//fnProdDispatch: fnDispatch => {..}
console.log("INDEX.fnProdDispatch: ",fnProdDispatch)
oStore.dispatch(fnProdDispatch)

ReactDOM.render(
    <Provider store={oStore}>
        <App />
    </Provider>,
    document.getElementById("root")
);
console.log("end index.js render")
//</editor-fold>
//=================================================
//               INDEX.HTML
//================================================= 
//<editor-fold defaultstate="collapsed" desc="REDUX.JS CREATESTORE">
//C:\xampp\htdocs\prj_reactjs\public\index.html
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="%PUBLIC_URL%/favicon.ico">
    <!--
      Notice the use of %PUBLIC_URL% in the tag above.
      It will be replaced with the URL of the `public` folder during the build.
      Only files inside the `public` folder can be referenced from the HTML.
      Unlike "/favicon.ico" or "favicon.ico", "%PUBLIC_URL%/favicon.ico" will
      work correctly both with client-side routing and a non-root public URL.
      Learn how to configure a non-root public URL by running `npm run build`.
    -->
    <title>React App</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </head>
  <body>
    <div id="root"></div>
    <!--
      This HTML file is a template.
      If you open it directly in the browser, you will see an empty page.
      You can add webfonts, meta tags, or analytics to this file.
      The build step will place the bundled scripts into the <body> tag.
      To begin the development, run `npm start`.
      To create a production bundle, use `npm run build`.
    -->
  </body>
</html>
//</editor-fold>