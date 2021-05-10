//--------------------------------------------------------------------------------------------------
//	$Id: OpenLayers_Map_minZoom_maxZoom_Patch.js,v 1.4 2013/02/25 07:53:40 wolf Exp wolf $
//--------------------------------------------------------------------------------------------------
//
//	class:	OpenLayers.Map
//	fields:	minZoom, maxZoom
//	methods: moveTo, getNumZoomLevels
//
//--------------------------------------------------------------------------------
//
//	The Problem:
//
//	Map zoom needs to be restricted to a certain range.
//
//--------------------------------------------------------------------------------
//
//	The solution (not really):
//
//	The method Map.moveTo is patched to limit its parameter "zoom" to the
//	range defined by the Map fields "minZoom" and "maxZoom".
//
//--------------------------------------------------------------------------------
//
//	BEWARE!
//
//	The OpenLayers zoom/pan logic is based on the assumption, that zero is
//	allways a safe value for zoom. THIS PATCH SUBVERTS THIS ASSUMPTION!
//
//	There may be side effects.
//
//--------------------------------------------------------------------------------
//	http://www.netzwolf.info/kartografie/openlayers/restrictedzoom.htm
//--------------------------------------------------------------------------------

(function () {
	OpenLayers.Map.prototype.minZoom = null;
	OpenLayers.Map.prototype.maxZoom = null;

	var moveTo = OpenLayers.Map.prototype.moveTo;

	OpenLayers.Map.prototype.moveTo = function (lonlat, zoom, options) {

		if (this.minZoom && zoom<this.minZoom) {
			zoom  = this.minZoom;
			center= this.getCenter();
			if (center) { lonlat=center; }
		}
		if (this.maxZoom && zoom>this.maxZoom) {
			zoom = this.maxZoom;
			center= this.getCenter();
			if (center) { lonlat=center; }
		}

		return moveTo.apply (this, [lonlat, zoom, options]);
	};

	var getNumZoomLevels = OpenLayers.Map.prototype.getNumZoomLevels;

	OpenLayers.Map.prototype.getNumZoomLevels = function () {

		var num = getNumZoomLevels.apply (this, arguments);
		if (this.maxZoom && num>this.maxZoom+1) { num = this.maxZoom+1; }
		return num;
	};
})();

//--------------------------------------------------------------------------------------------------
//	$Id: OpenLayers_Map_minZoom_maxZoom_Patch.js,v 1.4 2013/02/25 07:53:40 wolf Exp wolf $
//--------------------------------------------------------------------------------------------------
