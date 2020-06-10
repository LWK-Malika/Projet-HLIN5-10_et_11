var map = new ol.Map({
    target: 'map',
    layers: [new ol.layer.Tile({source: new ol.source.OSM()})],
    view: new ol.View({
        center: ol.proj.fromLonLat([3.876716,43.6111]),
        zoom: 14 // max 11 pour vue satellitaire (sat)
    })

});

// var marker = document.getElementById('markerProto');
// map.addOverlay(new ol.Overlay({

//     position: ol.proj.fromLonLat([3.882610,43.613861]),
// 	element: marker
// }));


// var popup = document.getElementById('popupProto');
// map.addOverlay(new ol.Overlay({

// 	offset: [0, -100],
// 	position: ol.proj.fromLonLat([3.87667,43.6141]),
// 	element: popup
// }));


function start(tableau_coord_long , tableau_coord_lat , tableau_nom){

    for (let i = 0; i < tableau_coord_long.length; i++) {
    
 
        let image = $("#markerProto").clone();
                        image.attr("id", "marker"+tableau_nom[i]);
        $("body").append(image);

        let marker2 = document.getElementById('marker'+tableau_nom[i]);
                        
						map.addOverlay(new ol.Overlay({
                            offset: [0, 0],
							position: ol.proj.fromLonLat([tableau_coord_long[i],tableau_coord_lat[i]]),
							element: marker2
        }));
        
        let popup = $("#popupProto").clone();
                        popup.attr("id", "popup"+tableau_nom[i]);
						popup.append("<p>"+tableau_nom[i]+"</p>");;
                        $("body").append(popup);
        
		var popup2 = document.getElementById('popup'+tableau_nom[i]);
		map.addOverlay(new ol.Overlay({

			offset: [0, -100],
			position: ol.proj.fromLonLat([tableau_coord_long[i],tableau_coord_lat[i]]),
			element: popup2
		}));
        
        
    }
    // $('#points_interet').accordion({collapsible: true, heightStyle: 'content'});
}

function switchMarker() { $('body').on("click","img", function() {
    let valeur = $(this).attr('id');
    console.log(valeur);

    valeur = valeur.substring(6,valeur.length);
    console.log(valeur);
    console.log(document.getElementById("popup"+valeur).style.display);
    if (document.getElementById("popup"+valeur).style.display=="none") { document.getElementById("popup"+valeur).style.display="block"; }
    else if (document.getElementById("popup"+valeur).style.display=="block"){ document.getElementById("popup"+valeur).style.display="none";}
      })


};