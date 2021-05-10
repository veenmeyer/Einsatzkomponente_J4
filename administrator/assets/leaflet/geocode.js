if (typeof console == "undefined") {
	this.console = { log: function (msg) { /* do nothing since it would otherwise break IE */} };
}


L.Control.OSMGeocoder = L.Control.extend({
	options: {
		collapsed: true,
		position: 'topright',
		text: 'Suche',
		placeholder: '',
		bounds: null, // L.LatLngBounds
		email: null, // String
		callback: function (results) {
							console.log(results);

			if (results.length == 0) {
				console.log("ERROR: didn't find a result");
				document.getElementById("jform_address").style.color = "red";
				document.getElementById("jform_address").style.border = "solid red 2px";
				return;
			}
			this._map.setView([results[0].lat,results[0].lon]);
			document.getElementById("jform_gmap_report_latitude").value=results[0].lat;
			document.getElementById("jform_gmap_report_longitude").value=results[0].lon;
			document.getElementById("jform_address").style.color = "green";
            document.getElementById("jform_address").style.border = "solid green 2px";

            var marker = new L.marker([results[0].lat,results[0].lon],{draggable:'true',icon: blueIcon}).bindPopup().addTo(map);


		}
	},

	_callbackId: 0,

	initialize: function (options) {
		L.Util.setOptions(this, options);
	},

	onAdd: function (map) {
		this._map = map;

			container = this._container = L.DomUtil.create('div');

		
 L.DomEvent.addListener(Geocode, 'click', L.DomEvent.stopPropagation)
            .addListener(Geocode, 'click', this._geocode, this);
			


		return container;
	},


	_geocode : function (event) {
		L.DomEvent.preventDefault(event);
		var q = document.getElementById("jform_address").value;
		

		//and now Nominatim
		//http://wiki.openstreetmap.org/wiki/Nominatim
		console.log(this._callbackId);
		window[("_l_osmgeocoder_"+this._callbackId)] = L.Util.bind(this.options.callback, this);


		/* Set up params to send to Nominatim */
		var params = {
			// Defaults
			q: document.getElementById("jform_address").value,
			json_callback : ("_l_osmgeocoder_"+this._callbackId++),
			format: 'json'
		};

		if (this.options.bounds && this.options.bounds != null) {
			if( this.options.bounds instanceof L.LatLngBounds ) {
				params.viewbox = this.options.bounds.toBBoxString();
				params.bounded = 1;
			}
			else {
				console.log('bounds must be of type L.LatLngBounds');
				return;
			}
		}


		var protocol = location.protocol;
		if (protocol == "file:") protocol = "https:";
		var url = protocol + "//nominatim.openstreetmap.org/search" + L.Util.getParamString(params),
		script = document.createElement("script");
		script.type = "text/javascript";
		script.src = url;
		script.id = this._callbackId;
		document.getElementsByTagName("head")[0].appendChild(script);
	}

});
