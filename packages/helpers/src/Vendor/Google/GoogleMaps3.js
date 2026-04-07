/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.1.5
 * @name gmaps3
 * @file js_google_maps_3.js  
 * @uses helper_google_maps_3.php, jquery v1.7+
 * @date 29-08-2013 12:39 (SPAIN)
 * @observations
 * Javascript class for GoogleMaps3
 */
var bug = function(value,title)
{
    if(window.console != undefined)
    {    
        if(title!=null) console.debug(title);
        console.debug(value);
    }
};

var bugarray = function(value,title)
{
    if(window.console != undefined && value.length!=undefined)
    {    
        if(title==null || title==undefined) title=""; 
        for(var i=0; i<value.length; i++)
        { 
            console.debug(title+"["+i+"]");
            console.debug(value[i]);
        }
    }    
}

function sleep(iCentiSeccond) 
{
    var iEndTime = new Date().getTime() + (iCentiSeccond * 100);
    while (new Date().getTime() <= iEndTime) 
    {}
}
var gmaps3 =
{
    config : 
    {
        //Mapa
        sMapType : 'roadmap',
        fLatitude : 40.41694, //Coord de centrado
        fLongitude : -3.70361, //Puerta del sol (Madrid).
        iZoom : 6,
        //Rutas
        arRoutes : [], //[ [["sTitle, sContent, fLatitude, fLongitude"], [paradas], ["color_pines"],["color_trazado"]],  ]
        useMarkersNumbers : true,
        sMarkerColor: 'red', //TODO modificar este script y el codigo php para que esta sea por defecto
        //Lineas de distancia
        drawLines : false,
        //Lienzo
        sIdDivContainer : 'map_canvas', //Div contenedor
        iWidth : 800,
        iHeight: 600,
        sUnitWH : 'px',
        //Rutas:
        drawMarkers : true,//todo nuevo
        //drawRoutes : false, TODO nuevo
        drawTraces : true,
        sRouteMode: 'driving', // DRIVING, WALKING BICYCLING, 
        //sRouteColor: 'red', //TODO modificar este script y el codigo php para que esta sea por defecto
        fRouteAlpha : 0.6,  // de 0.0 a 1.0
        iRouteWidth : 4,
        iMaxWayPoints : 25
    },
    
    //Todos los puntos, Paradas y no paradas
    get_route_points: function(iRouteIndex)
    {
        var arRoutes = gmaps3.config.arRoutes;
        var arRoute = arRoutes[iRouteIndex];
        //Marcadores del trazado de la ruta i
        var arPoints = arRoute[0];//0 es el array de marcadorers
        return arPoints;
    },
    
    //stops. Solo Paradas
    get_route_markers: function(iRouteIndex)
    {
        var arRoute = gmaps3.config.arRoutes[iRouteIndex];
        var arPoints = arRoute[0];
        var arStopsIndexes = arRoute[1];//1 array de indices de paradas (marcadores)
        var arMarkers = [];
        for(var i=0; i<arPoints.length; i++)
        {
            for(var j=0; j<arStopsIndexes.length; j++)
            {
                if(i==arStopsIndexes[j])
                    arMarkers.push(arPoints[i]);
            }
        }
        return arMarkers;
    },
    
    get_point_title: function(arMarker)
    {
        var sTitle = arMarker[0];
        return sTitle;
    },
            
    get_point_content: function(arMarker)
    {
        var sContent = arMarker[1];;
        return sContent;
    },
            
    is_latlng_stop: function(iRouteIndex,iDotIndex)
    {
        var arRoute = gmaps3.config.arRoutes[iRouteIndex];
        var arStopsIndexes = arRoute[1];//1 array de indices de paradas (marcadores)
        if(gmaps3.in_array(arStopsIndexes,iDotIndex))
            return true;
        return false;        
    },
    
    in_array: function(arArray,sItem)
    {
        for(var i=0; i<arArray.length; i++)
            if(sItem==arArray[i])
                return true;
        return false;
    },
    
    //no paradas
    get_route_dots_nomarkers: function(iRouteIndex)
    {
        var arRoute = gmaps3.config.arRoutes[iRouteIndex];
        var arPoints = arRoute[0];
        var arStopsIndexes = arRoute[1];//1 array de indices de paradas (marcadores)
        var arCoordDots = [];
        for(var i=0; i<arPoints.length; i++)
        {
            if(!gmaps3.in_array(arStopsIndexes,i))
                arCoordDots.push(arPoints[i]);
        }
        return arCoordDots;
    },
            
    //Devuelve todas las paradas de todas las rutas. Necesario para ajustar el zoom
    get_all_routes_markers: function()
    {
        var arAllMarkers = [];//for()a.concat(b,d);
        var arTemp = [];
        for(var i=0; i<gmaps3.config.arRoutes.length;i++)
        {
            arTemp = gmaps3.get_route_markers(i);
            arAllMarkers = arAllMarkers.concat(arTemp);
        }
        return arAllMarkers;
    },
    
    get_route_pin_color: function(iRouteIndex)
    {
        var arRoutes = gmaps3.config.arRoutes;
        var arRoute = arRoutes[iRouteIndex];
        var sPinColor = arRoute[2];//2 es el color de los pines
        return sPinColor;
    },
    
    get_route_trace_color: function(iRouteIndex)
    {
        var arRoutes = gmaps3.config.arRoutes;
        var arRoute = arRoutes[iRouteIndex];
        var sTraceColor = arRoute[3];//3 es el color del trazado
        return sTraceColor;        
    },
    
    get_total_traces : function()
    {
        var iTotal = 0;
        var iTotalRoutes = gmaps3.config.arRoutes.length;
        var iSubroutes = 0;
        var arAllPoints = [];
        var arSubroutes = [];
        for(var iRoute=0; iRoute<iTotalRoutes; iRoute++)
        {
            arAllPoints = gmaps3.config.arRoutes[iRoute][0];
            if(gmaps3.is_overmaxlimit(arAllPoints))
            {
                arSubroutes = gmaps3.get_subroutes(arAllPoints);
                iSubroutes = arSubroutes.length;
                iTotal += iSubroutes;
            }
            else
            {
                iTotal ++;
            }
        }
        bug(iTotal,"total traces");
        return iTotal;
    },
            
    load_traces_and_color : function()
    {
        var iTotalRoutes = gmaps3.config.arRoutes.length;
        var arAllPoints = [];
        var arSubroutes = [];
        var sRouteColor = "";
        
        for(var iRoute=0; iRoute<iTotalRoutes; iRoute++)
        {
            arAllPoints = gmaps3.config.arRoutes[iRoute][0];
            bug("total points for route "+iRoute+" "+arAllPoints.length);
            sRouteColor = gmaps3.config.arRoutes[iRoute][3];
            if(gmaps3.is_overmaxlimit(arAllPoints))
            {
                arSubroutes = gmaps3.get_subroutes(arAllPoints);
                for(var i=0; i<arSubroutes.length; i++)
                {    
                    gmaps3.arAllTraces.push(arSubroutes[i]);
                    gmaps3.arAllColors.push(sRouteColor);
                }
            }
            else
            {
                gmaps3.arAllTraces.push(arAllPoints);
                gmaps3.arAllColors.push(sRouteColor);
            }
        }
    },
    
    //arMarkers: [sTitle, sContent, fLatitude, fLongitude],..[]
    draw_markers : function(arMarkers,sMarkerColor,useTitle)
    {
        var arTmpMarker;
        var oLatLng;
        var sTitle;
        var sContent;
        var iMarkerNumber;
        var iCoordZ; //Posibles problemas con esta coordenada
        
        var sMarkerColor = sMarkerColor || gmaps3.config.sMarkerColor;
        
        for(var i = 0; i<arMarkers.length; i++) 
        {
            arTmpMarker = arMarkers[i];
            sTitle = arTmpMarker[0];
            sContent = arTmpMarker[1];
            //Si la latitud y longitud son distintas de 0
            if(arTmpMarker[2]!=0 && arTmpMarker[3]!=0)
            {
                oLatLng = new google.maps.LatLng(arTmpMarker[2], arTmpMarker[3]);
                iMarkerNumber = i+1;
                //iCoordZ = (i+1)*10;
                iCoordZ = i+1;
                ////bug(iMarkerNumber,"iMarkerNumber:")
                
                if(useTitle)
                {
                    if(sTitle!="")
                        gmaps3.draw_marker(sTitle, sContent, oLatLng, iMarkerNumber, iCoordZ,sMarkerColor,useTitle);
                }
                else
                {
                    gmaps3.draw_marker(sTitle, sContent, oLatLng, iMarkerNumber, iCoordZ,sMarkerColor,useTitle);
                }
            }
        }
    },
    
    //https://developers.google.com/maps/documentation/javascript/overlays#Markers
    draw_marker : function(sTitle, sContent, oLatLng, iNumber, iCoordZ, sMarkerColor, useTitle)
    {
        ////bug(arguments,"arguments:");
        sMarkerColor = gmaps3.clean_color_param(sMarkerColor);
        
        var oStyleIcon = new StyledIcon
        (
            StyledIconTypes.BUBBLE,
            //StyledIconTypes.MARKER,
            {
                color:sMarkerColor,
                text:iCoordZ.toString() //Valor que se mostrar� dendro del pin
            }
        );
        
        //si es coordenada simple. No parada
        //alert(sText);
        if(useTitle!=null && useTitle!=undefined) oStyleIcon.text=sTitle;
        
        ////bug(oLatLng,"oLatLng:"); ok
        ////bug(oStyleIcon,"oStyleIcon:"); ok
        var oStyleMarker = new StyledMarker
        (
            {
                styleIcon:oStyleIcon, 
                position:oLatLng, 
                map: gmaps3.oMap,
                title: sTitle
            }
        );
    
        ////bug(oStyleMarker.styleIcon,"oStyleMarker.styleIcon"); ok
        ////bug(sContent,"content");
        ////bug(oStyleMarker,"oStyleMarker before event:");
        if(sContent!=null && jQuery.trim(sContent)!="")
        {
            var on_click = function()
            {
                if(gmaps3.oInfoWindow) gmaps3.oInfoWindow.close();
                gmaps3.oInfoWindow = new google.maps.InfoWindow({content: sContent});
                gmaps3.oInfoWindow.open(gmaps3.oMap,oStyleMarker);
            }
            ////bug(oStyleMarker,"oStyleMarker after:");
            google.maps.event.addDomListener(oStyleMarker,"click",on_click);
        }
    },
    
    //Pinta lineas rectas entre puntos
    draw_lines : function(arLatLong,sLineColor)
    {
        var arObjectsLl = [];
        var fLat = 0;
        var fLong = 0;
        var arTmpLatLong = [];
        var oTmpLatLng = null;
        for(var i = 0; i < arLatLong.length; i++) 
        {
            arTmpLatLong = arLatLong[i];
            fLat = arTmpLatLong[0];
            fLong = arTmpLatLong[1];
            
            oTmpLatLng = new google.maps.LatLng(fLat, fLong);
            arObjectsLl.push(oTmpLatLng);
        }
        ////bug(arObjectsLl,"arObjectsLi");
        var oPolyLine = new google.maps.Polyline
        (
            {
                path: arObjectsLl,
                strokeColor: gmaps3.clean_color_param(sLineColor),
                strokeOpacity: 1.0,
                strokeWeight: 2
            }
        );
        ////bug(oPolyLine,"polyline");
        oPolyLine.setMap(gmaps3.oMap);
    },
    
    is_all_traces_received: function()
    {
        //Si el n�mero de trazados recibidos es igual al total de rutas 
        //quiere decir que se han dibujado todas
        return (gmaps3.iTracesRendered == gmaps3.iTracesToBeRendered);
    },
            
    clean_color_param : function(sColor)
    {
        var hxColor = sColor.replace("#","");
        hxColor = "#"+hxColor;
        return hxColor;
    },
    
    build_waypoints: function(arLatLong)
    {
        ////bug(arLatLong,"ar latlong");
        ////bug(gmaps3.get_route_markers(gmaps3.iIndexCurrentRoute),"paradas");
        ////bug(gmaps3.get_route_dots_nomarkers(gmaps3.iIndexCurrentRoute),"no paradas");
        var arWaypoints = [];
        for(var i=0; i<arLatLong.length; i++)
            arWaypoints.push({location:arLatLong[i], stopover:true});
        ////bug(arWaypoints,"ar waypoints");
        return arWaypoints;
    },
    
    draw_traces: function()
    {
        //bug(gmaps3.arAllTraces,"all traces");
        //bug(gmaps3.arAllColors,"all Colors");
        var iTraceToRender = gmaps3.iTracesRendered;
        var arTrace = gmaps3.arAllTraces[iTraceToRender];
        var sColor = gmaps3.arAllColors[iTraceToRender];
        
        //bug("drawtraces: rendering "+iTraceToRender+" of "+gmaps3.iTracesToBeRendered);
        var arObjLatLong = gmaps3.extract_latlng_from_points(arTrace,true);        
        //bug(arObjLatLong,"Trace dots to render for trace:"+iTraceToRender);
        var iLast = arObjLatLong.length-1;
        var oLlOrigin = arObjLatLong[0];
        var oLlDestination = arObjLatLong[iLast];
        
        arObjLatLong.splice(iLast,1);
        arObjLatLong.splice(0,1);
        
        var sContent = sContent || '';
        var arWaypoints = gmaps3.build_waypoints(arObjLatLong);
        //bug(arWaypoints,"points to render: "+arWaypoints.length);
        
        var oDirRenderOption = 
        {
            map: gmaps3.oMap,
            //panel: directionsPanel,
            suppressInfoWindows: true,
            suppressMarkers: true,
            polylineOptions: 
            { 
                strokeColor: gmaps3.clean_color_param(sColor), 
                thickness: 100, 
                strokeOpacity: gmaps3.config.fRouteAlpha,
                strokeWeight: gmaps3.config.iRouteWidth
            }
        };
        ////bug(oDirRenderOption,"o dir render");
        var oDirectionsRenderer = new google.maps.DirectionsRenderer(oDirRenderOption);
        var oDirectionsService = new google.maps.DirectionsService();
        //Javascript allows us to access the constant
        // using square brackets and a string value as its
        // "property."
        var oDirectionsTravelMode = google.maps.DirectionsTravelMode[gmaps3.get_route_mode()];
        var oRequest = 
        { 
            origin: oLlOrigin, 
            destination: oLlDestination,
            travelMode : oDirectionsTravelMode,
            waypoints: arWaypoints
        };
        
        var on_response = function(oResponse, sStatus)
        {
            bug("trace rendering: "+gmaps3.iTracesRendered);
            //this es la ventana
            if(sStatus == google.maps.DirectionsStatus.OK)
            {
                oDirectionsRenderer.setDirections(oResponse);
                bug("Rendering status ok! for trace "+gmaps3.iTracesRendered);
            }
            else
            { 
                //MAX_WAYPOINTS_EXCEEDED indica que se proporcionaron demasiados hitos (waypoints) en la solicitud. 
                //El n�mero m�ximo de waypoints permitidos es 8, adem�s del origen y del destino. 
                //(los clientes de Google Maps Premier pueden realizar consultas que contengan 
                //23 hitos como m�ximo).
                bug("Rendering status falied!. Error: "+sStatus+" for "+gmaps3.iTracesRendered);
            }
            

            gmaps3.iTracesRendered++;
            if(gmaps3.iTracesRendered<gmaps3.iTracesToBeRendered)
                //Recursividad para evitar max_weypoints_exceeded
                gmaps3.draw_traces();
        };
        ////bug(oRequest,"peticion de trazado enviado");
        oDirectionsService.route(oRequest, on_response);
        oDirectionsRenderer.setMap(gmaps3.oMap);      
    },//gmaps3.draw_traces();        
            
    is_overmaxlimit:function(arPoints)
    {
        //https://groups.google.com/forum/#!topic/google-maps-api/6eLgSw4u_hs
        ////bug(arPoints.length,"points");
        return (arPoints.length>(gmaps3.config.iMaxWayPoints-2));
    },

    get_subroutes : function(arObjLatLong)
    {
        var arChunks = [];
        //var iSegments = 10; //segmentos de 10 puntos
        var iSegments = gmaps3.config.iMaxWayPoints; //segmentos de 25 puntos
        var iNumItems = arObjLatLong.length;
        var iLastIndex = iNumItems-1;
   
        var iAdded = 1;
        var arTemp = [];

        var i=0;
        while(i<=iLastIndex)
        {
            if(i<iLastIndex)
            { 
                if(iAdded<=iSegments)
                {    
                    arTemp.push(arObjLatLong[i]);
                    iAdded++;
                    i++;
                }
                //los a�adidos son mayores a los que permite el segmento
                else //>iSegments
                {
                    //se guarda en chunks
                    arChunks.push(arTemp);
                    arTemp = [];
                    iAdded = 1;
                    i--;//para q recupere el anterior
                }
            }
            else
            {
                arTemp.push(arObjLatLong[i]);
                arChunks.push(arTemp);
                i++;//incremento para salir
            }
        }
        
        return arChunks;
    },
            
    //DRIVING, WALKING BICYCLING, 
    get_route_mode : function(sType)
    {
        var sType = sType || gmaps3.config.sRouteMode;
        sType = sType.toUpperCase();
        return sType;        
    },
    
    get_maptype : function(sType)
    {
        var oMapTypeId = null;
        var sType = sType || gmaps3.config.sMapType;
        sType = sType.toLowerCase();
        if(sType=="roadmap")
        {
            oMapTypeId = google.maps.MapTypeId.ROADMAP;
        }
        else if(sType=="satelite")
        {
            oMapTypeId = google.maps.MapTypeId.SATELITE;
        }
        else if(sType=="hybrid")
        {
            oMapTypeId = google.maps.MapTypeId.HYBRID;
        }
        else //if(sType="terrain")
        {
            oMapTypeId = google.maps.MapTypeId.TERRAIN;
        }
        return oMapTypeId;
    },
    
    //Extrae las coordenadas de los marcadores ya sea como objetos de google
    //o un array de arrays
    extract_latlng_from_points : function(arPoints, asGoogleObj)
    {
        var arPoints = arPoints || [];//todo || gmaps3.config.arMarkers;
        var arLatLong = [];
        var arTemp = [];
        var fLatitude = 0;
        var fLongitude = 0;
        //Los marcadores es un array de arrays cuyas filas llevan como 
        //
        for(var i=0; i<arPoints.length; i++)
        {
            arTemp = arPoints[i];
            fLatitude = arTemp[2];
            fLongitude = arTemp[3];
            if(asGoogleObj==null) arTemp = [fLatitude,fLongitude];
            else arTemp = new google.maps.LatLng(fLatitude,fLongitude);
            arLatLong.push(arTemp);
        }
        return arLatLong;
    },
    
    //Comprueba si se ha de pintar trazados y si se han a�adido todos
    //los trazados al mapa.
    fit_in_screen : function()
    {
        var doFit = false;
        //Si se est�n dibujando trazdos se comprueba en cada llamada que se 
        //hayan recibido todas desde el servidor mediante ajax.
        if(gmaps3.config.drawTraces && gmaps3.is_all_traces_received())
        {
            clearInterval(gmaps3.iRouteInterval);
            doFit = true;
        }
        else if(!gmaps3.config.drawTraces)
            doFit = true;
        //else ; // drawTraces && !all_routes_received
        
        if(doFit)
        {
            //DE TODAS LAS RUTAS
            var arAllMarkers = gmaps3.get_all_routes_markers();
            ////bug(arAllMarkers,"todos los marcadores");
            var arLlObjects = gmaps3.extract_latlng_from_points(arAllMarkers,true);
            ////bug(arLlObjects,"llobjects");
            //Recuperamos los limites que se est�n visualizando
            var oLlBound = new google.maps.LatLngBounds();
            //Recorremos cada punto y lo pasamos por el metodo extend
            for(var i = 0; i < arLlObjects.length; i++) 
                oLlBound.extend(arLlObjects[i]);
            //Fit these bounds to the map
            gmaps3.oMap.fitBounds(oLlBound);            
        }

    },
    
    //=======================================================================
    oMap : null, //El objeto mapa
    //La ventana �nica
    oInfoWindow : null, 
    //El n�mero de trazados que se han a�adido al mapa
    iTracesRendered : 0, 
    //El n�mero total de trazados que se van a dibujar. Se toman en cuenta todas las rutas.
    iTracesToBeRendered : 0,
    //Acumulador. Guarda lo devuelto por route interval
    iRouteInterval : 0,
    //Ruta que se esta pintando
    iIndexCurrentRoute : 0,
    //Array de todas las rutas a pintar. ar[i] = [[puntos de ruta..]];
    arAllTraces : [],
    //Array del color que le correspone a cada ruta guardada en alltraces
    arAllColors : [],

    //Antes la llamaba initialize. Le he cambiado el nombre para demostrar
    //que no necesariamente tiene que ser asi.
    load_map: function()
    {
        gmaps3.load_traces_and_color();
        //bugarray(gmaps3.arAllTraces,"arAlltraces")
        //Cuento los trazados a dibujar
        gmaps3.iTracesToBeRendered = gmaps3.get_total_traces();
        bug("traces to be rendered "+gmaps3.iTracesToBeRendered);
        //el div donde se dibujara el mapa
        var eDivContainer = document.getElementById(gmaps3.config.sIdDivContainer);
        //objeto jquery del div contenedor. Es distinto del anterior ya que no puedo
        //utilizar este mismo dentro del constructor "Map". este objeto me sirve para configurar
        //sus estilos
        var oDivCanvas = jQuery(eDivContainer);
        
        //Array auxiliar donde se almacenar� la latitud y longitud de los marcadores
        //de una ruta
        var arTmpLatLong = [];
        
        if(gmaps3.config.sUnitWH=='px')
        {
            oDivCanvas.width(gmaps3.config.iWidth);
            oDivCanvas.height(gmaps3.config.iHeight);
        }
        else
        {
            var sCanvasSize = gmaps3.config.iWidth + gmaps3.config.sUnitWH;
            oDivCanvas.width(sCanvasSize);
            sCanvasSize = gmaps3.config.iHeight + gmaps3.config.sUnitWH;
            oDivCanvas.height(sCanvasSize);
        }
        oDivCanvas.css("margin","0");
        oDivCanvas.css("padding","0");
        
        //La zona a visualizar. Es un objeto latitud longitud el cual se utilizar� para centrar el mapa.
        var oLlCenter = new google.maps.LatLng(gmaps3.config.fLatitude, gmaps3.config.fLongitude);
        
        //====================
        //  EL OBJETO MAPA
        //====================
        var oConfig = 
        {
            center: oLlCenter,
            zoom: gmaps3.config.iZoom,
            mapTypeId : gmaps3.get_maptype()
        };
        
        gmaps3.oMap = new google.maps.Map(eDivContainer, oConfig);
        //=====================
        // FIN CREACION OBJETO MAPA
        //=====================
        var arAllPoints = []; var sRouteColor="red"; var sMarkerColor="red";
        //bug(gmaps3.arAllTraces,"all traces with color");
        if(gmaps3.config.drawTraces)
            //funcion recursiva por ajax. Se ejecuta despues de cada respuesta
            gmaps3.draw_traces();
        
        for(var iRoute=0; iRoute<gmaps3.config.arRoutes.length; iRoute++)
        {
            gmaps3.iIndexCurrentRoute = iRoute;
            //Todos los puntos que conforman la ruta
            sMarkerColor = gmaps3.config.arRoutes[iRoute][2];
            sRouteColor = gmaps3.config.arRoutes[iRoute][3];
            ////bug(sMarkerColor,"color marcador de ruta "+i+" "+sMarkerColor+" color trazado "+sRouteColor);
            arAllPoints = gmaps3.config.arRoutes[iRoute][0];

            //Pintado de lineas rectas (rojas) Polyline
            if(gmaps3.config.drawLines)
            {
                arTmpLatLong = gmaps3.extract_latlng_from_points(arAllPoints);
                ////bug(arTmpLatLong,"latlong");
                gmaps3.draw_lines(arTmpLatLong,sRouteColor);
            }

            //Pintado de chinchetas
            if(gmaps3.config.drawMarkers)
            {
                //Solo se pinta los marcadores. Las paradas
                var arMarkers = [];
                //coordenadas simples (no paradas)
                arMarkers = gmaps3.get_route_dots_nomarkers(iRoute);
                if(arMarkers.length!=undefined)
                {    
                    gmaps3.draw_markers(arMarkers,sMarkerColor,true);
                }
                
                arMarkers = gmaps3.get_route_markers(iRoute);
                gmaps3.draw_markers(arMarkers,sMarkerColor);                
            }
        }//fin for drawtraces 
        
        //Si no se van a pintar trazados se ajusta el zoom inmediatamente
        if(!gmaps3.config.drawTraces) 
            gmaps3.fit_in_screen();
        else
            //Cada segundo ejecuta la funcion fit_in_screen. Esta, comprueba que 
            //se hayan a�adido todos los trazados al mapa para ajustar el zoom
            gmaps3.iRouteInterval = setInterval(gmaps3.fit_in_screen,1000);       
    }//Fin load_map
};
