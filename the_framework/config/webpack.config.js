console.log("webpack.config.js 1.0.0")

const isDebug = process.env.NODE_ENV !== "production"
const oWebpack = require("webpack")

module.exports = {
  context: __dirname,
  devtool: isDebug ? "inline-sourcemap" : null,
  //punto de entrada de la app.
  entry: "./the_application/src/index.js", //el index a transpilar

  //con el objeto module y el array de loaders se indica que trasnformaciones se desea que haga
  //https://youtu.be/2M5L_uz6GO0?t=296 (explicacion module)
  module:{
      loaders:[
          {
              test:/\.jsx?$/,//indica que ficheros debe tener en cuenta
              exclude:/(node_modules|bower_components)/,
              loader: 'babel-loader',
              query:{
                  presets:["react","es2015","stage-0"],
                  plugins:["react-html-attrs","transform-class-properties","transform-decorators-legacy"],
              }
          }
      ]
  },
  output: {
    path: __dirname + "./the_public/js/react/",//carpeta donde se guardara lo compilado
    filename: "bundle.js",//el js minificado final a pasar aproduccion
    public: "/build/", //directorio publico desde donde se podra vincular https://youtu.be/2M5L_uz6GO0?t=227
  },
  //resolve: indica los archivos que webpack debe tener en cuenta
/*  resolve:{
      extensions: ["",".js"]//indica que haga caso a los archivos .js
  },*/

  //como se ha configurado el paquete webpack-dev-server podemos configurar el servidor mediante
  //este objeto
/*  devServer:{
      host: "0.0.0.0",
      port: 8080,
      inline: true //indica que nos cree un servidor de desarrollo basado en node y express??
  },*/
  plugins: debug ? [] : [
    new oWebpack.optimize.DedupePlugin(),
    new oWebpack.optimize.OccurenceOrderPlugin(),
    new oWebpack.optimize.UglifyJsPlugin({ mangle: false, sourceMap: false }),
  ],
}//module.exports