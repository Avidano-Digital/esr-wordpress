jQuery(function ($) {


    // Initialize the map 
    
    var map = L.map('map-affiliates', {
        center: [0, 0],
        zoom: 1,
        minZoom: 1,
        maxZoom: 8,
        zoomSnap: 0.25,
        zoomDelta: 0.5,
        scrollWheelZoom: false,
        zoomControl: false,
        attributionControl: false,
    });

    L.tileLayer.provider('Stamen.Watercolor').addTo(map);

    // Create custom pin
    var Icon = L.Icon.extend({
        options: {
            iconSize: [40, 40]
        }
    });

    var myPath = path.templateUrl;
    
    var officeIcon = new Icon({ iconUrl: myPath + '/images/map-flag.svg'} );
    var affiliateIcon = new Icon({ iconUrl: myPath + '/images/map-flag-affiliate.svg'} ); 
    var chapterIcon = new Icon({ iconUrl: myPath + '/images/map-flag-chapter.svg'} ); 
    var partnerIcon = new Icon({ iconUrl: myPath + '/images/map-flag-partner.svg'} );    

    // Custom popup options 
    var markerOptions = {
        riseOnHover: true, 
        icon: Icon,
    };

    // Custom popup options 
    var popupOptions = {
        maxWidth: 300,
        className: 'rounded-0',
        closeButton: false
    };

    L.control.zoom({
        position:'bottomleft',
        zoomInText: '<span class="fas fa-plus"></span>',
        zoomOutText: '<span class="fas fa-minus"></span>'
    }).addTo(map);

    var affiliates = [
    {
        'type': 'Feature',
        'properties': {
            'name': 'Namibia',
            'popupContent': '<p><a href="#namibia"><strong>Namibia</strong></a></p><p>Headquarters</p><p class="location">Otjiwarongo, Namibia</p>',
            icon : officeIcon
        },
        'geometry': {
            'type': 'Point',
            'coordinates': [16.6645, -20.4545]
        }
    }, 
    {
        'type': 'Feature',
        'properties': {
            'name': 'Australia',
            'popupContent': '<p><a href="#australia"><strong>Australia</strong></a></p><p>Subsidiary</p><p class="location">Epping, Victoria</p>',
            icon : affiliateIcon
        },
        'geometry': {
            'type': 'Point',
            'coordinates': [145.014066, -37.623426]
        }
    },
    {
        'type': 'Feature',
        'properties': {
            'name': 'Belgium',
            'popupContent': 
            '<p><a href="#belgium"><strong>Belgium</strong></a></p><p>Subsidiary</p><p class="location">Brussels, Belgium</p>',
            icon : affiliateIcon
        },
        'geometry': {
            'type': 'Point',
            'coordinates': [4.3517, 50.8503]
        }
    },
    {
        'type': 'Feature',
        'properties': {
            'name': 'USA Office',
            'popupContent': 
            '<p><a href="#usa"><strong>CCF USA</strong></a></p><p>USA Office</p><p class="location">Alexandria, Virginia</p>' +
            '<hr class="my-2">' +
            '<p class="d-block"><strong>Washington, D.C.</strong></a><p>Chapter</p>',
            icon : affiliateIcon
        },
        'geometry': {
            'type': 'Point',
            'coordinates': [-77.059325, 38.818947]
        }
    },
    {
        'type': 'Feature',
        'properties': {
            'name': 'Canada',
            'popupContent': '<p><a href="#canada"><strong>Canada</strong></a></p><p>Subsidiary</p><p class="location">London, Ontario</p>',
            icon : affiliateIcon
        },
        'geometry': {
            'type': 'Point',
            'coordinates': [-81.241149, 42.998759]
        }
    },
    {
        'type': 'Feature',
        'properties': {
            'name': 'Italy',
            'popupContent': '<p><a href="#italy"><strong>Italy</strong></a></p><p>Subsidiary</p><p class="location">Biella, Italy</p>',
            icon : affiliateIcon
        },
        'geometry': {
            'type': 'Point',
            'coordinates': [8.0583, 45.5628]
        }
    },
    {
        'type': 'Feature',
        'properties': {
            'name': 'Japan',
            'popupContent': '<p><a href="#japan"><strong>Japan</strong></a></p><p>Subsidiary</p><p class="location">Tokyo, Japan</p>',
            icon : affiliateIcon
        },
        'geometry': {
            'type': 'Point',
            'coordinates': [139.691706, 35.689487]
        }
    },
    {
        'type': 'Feature',
        'properties': {
            'name': 'UK',
            'popupContent': '<p><a href="#uk"><strong>UK</strong></a></p><p>Subsidiary</p><p class="location">Toddington, Bedfordshire</p>',
            icon : affiliateIcon
        },
        'geometry': {
            'type': 'Point',
            'coordinates': [-0.533812, 51.940125]
        }
    },
    {
        'type': 'Feature',
        'properties': {
            'name': 'California (Northern)',
            'popupContent': '<p class="d-block"><strong>California (Northern)</strong></p><p>Chapter</p>',
            icon : chapterIcon
        },
        'geometry': {
            'type': 'Point',
            'coordinates': [-122.431297, 37.7749]
        }
    },
    {
        'type': 'Feature',
        'properties': {
            'name': 'California (Southern)',
            'popupContent': '<p class="d-block"><strong>California (Southern)</strong></p><p>Chapter</p>',
            icon : chapterIcon
        },
        'geometry': {
            'type': 'Point',
            'coordinates': [-116.3745, 33.7222]
        }
    },
    {
        'type': 'Feature',
        'properties': {
            'name': 'Indiana',
            'popupContent': '<p class="d-block"><strong>Indiana</strong></p><p>Chapter</p>',
            icon : chapterIcon
        },
        'geometry': {
            'type': 'Point',
            'coordinates': [-86.134902, 40.267194]
        }
    },
    {
        'type': 'Feature',
        'properties': {
            'name': 'New York',
            'popupContent': '<p class="d-block"><strong>New York</a></strong><p>Chapter</p>',
            icon : chapterIcon
        },
        'geometry': {
            'type': 'Point',
            'coordinates': [-74.217933, 40.7128]
        }
    },
    {
        'type': 'Feature',
        'properties': {
            'name': 'AGA Artenschutz',
            'popupContent': '<p><a href="#germany"><strong>AGA Artenschutz</strong></a></p><p>Partner Organization</p><p class="location">Korntal-Münchingen, Germany</p>',
            icon : partnerIcon
        },
        'geometry': {
            'type': 'Point',
            'coordinates': [9.090028, 48.853635]
        }
    },
    {
        'type': 'Feature',
        'properties': {
            'name': 'AMIFELINS',
            'popupContent': '<p><a href="#france"><strong>AMIFELINS</strong></a></p><p>Partner Organization</p><p class="location">Puteaux, France</p>',
            icon : partnerIcon
        },
        'geometry': {
            'type': 'Point',
            'coordinates': [2.2396, 48.8847]
        }
    },
    {
        'type': 'Feature',
        'properties': {
            'name': 'Stichting SPOTS',
            'popupContent': '<p><a href="#the-netherlands"><strong>Stichting SPOTS</strong></a></p><p>Partner Organization</p><p class="location">Etten-Leur, Netherlands</p>',
            icon : partnerIcon
        },
        'geometry': {
            'type': 'Point',
            'coordinates': [9.090028, 51.561076]
        }
    }

    ];

    var addedGeoJSON = L.geoJSON(affiliates, {

        pointToLayer: function(geoJsonPoint, latlng) {
            return L.marker(latlng, markerOptions);
        },

        onEachFeature: function (feature, layer) {

            if (feature.properties && feature.properties.popupContent) {
                layer.bindPopup(feature.properties.popupContent, popupOptions);
            }

            if (feature.properties && feature.properties.icon) {
                layer.setIcon(feature.properties.icon);
            }

        }
        
    }).addTo(map);
    
    // Set zoom and Fit to bounds

    function setMapZoom() {

        var pad = 0;
        var bounds = addedGeoJSON.getBounds();
        var mapWidth = $('#map-affiliates').width();

        if (mapWidth > 400) {
            map.options.minZoom = 1.25;
        }

        if (mapWidth > 600) {
            pad = 30;
            map.options.minZoom = 1.5;
        }

        if(mapWidth > 800){
            map.options.minZoom = 2;
        }

        if(mapWidth > 1000){
            pad = 60;
            map.options.minZoom = 2.25;
        }

        if(mapWidth > 1200){
            map.options.minZoom = 2.5;
        }

        if(mapWidth > 1400){
            map.options.minZoom = 2.75;
        }

        if(mapWidth > 1600){
            map.options.minZoom = 3;
        }

        map.fitBounds(bounds, { padding: [pad, pad] });
    }

    setMapZoom();

    map.on('resize', function () {
        setMapZoom();
    });    

    // var rect = L.rectangle(addedGeoJSON.getBounds(), {color: 'blue', weight: 1}).on('click', function (e) {
    //     console.info(e);
    // }).addTo(map);
    
    // Smooth Scroll

    map.on('popupopen', function () {

        $('.leaflet-popup-content a[href*=\\#]').click(function () {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') ||
                location.hostname === this.hostname) {

                var target = $(this.hash);
                var margin = 20;
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top - margin
                    }, 1000);
                    return false;
                }
            }
        });

    });

});
