hs.graphicsDir = 'highslide/graphics/';

hs.fadeInOut = true;
hs.align = 'center';
hs.headingEval = 'this.thumb.title';
hs.captionEval = 'this.thumb.alt';
hs.blockRightClick = true;
hs.align = 'center';
hs.dimmingOpacity = 0.8;
hs.showCredits = true;


// Add the slideshow controller
hs.addSlideshow({
	//slideshowGroup: 'group1',
	interval: 5000,
	repeat: false,
	useControls: true,
	fixedControls: 'fit',
	overlayOptions: {
		className: 'large-dark',
		opacity: 0.6,
		position: 'bottom center',
		offsetX: 0,
		offsetY: -15,
		hideOnMouseOut: true
	}
});

// Optional: a crossfade transition looks good with the slideshow
hs.transitions = ['expand', 'crossfade'];


// German language strings
hs.lang = {
	cssDirection: 'ltr',
	loadingText: 'Lade...',
	loadingTitle: 'Klick zum Abbrechen',
	focusTitle: 'Klick um nach vorn zu bringen',
	fullExpandTitle: 'Zur Originalgröße erweitern',
	creditsText: '',
    creditsHref : '',
	creditsTitle: '',
	previousText: 'Voriges',
	nextText: 'Nächstes',
	moveText: 'Verschieben',
	closeText: 'Schließen',
	closeTitle: 'Schließen (Esc)',
	resizeTitle: 'Größe wiederherstellen',
	playText: 'Abspielen',
	playTitle: 'Slideshow abspielen (Leertaste)',
	pauseText: 'Pause',
	pauseTitle: 'Pausiere Slideshow (Leertaste)',
	previousTitle: 'Voriges (Pfeiltaste links)',
	nextTitle: 'Nächstes (Pfeiltaste rechts)',
	moveTitle: 'Verschieben',
	fullExpandText: 'Vollbild',
	number: 'Bild %1 von %2',
	restoreTitle: 'Klick um das Bild zu schließen, klick und ziehe um zu verschieben. Benutze Pfeiltasten für vor und zurück.'
};

// gallery config object
var config1 = {
	//slideshowGroup: 'group1',
	numberPosition: 'caption',
	transitions: ['expand', 'crossfade']
};
