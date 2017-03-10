export default class HomeMaps
{
    constructor(app) {
        this.app = app;
        this.window = app.window;
        this.jQuery = app.jQuery;
    }

    stickPositionsToMap(positions) {
        var self = this;

        for (var i = 0; i < positions.length; i ++) {
            var garage = positions[i];
            var tmpPos = {lat: garage.lat , lng: garage.lng};

            var garageDetail = document.createElement('div');
            var detailId = 'detailGarage' + garage.id;
            garageDetail.setAttribute('id', detailId);

            var avatar = document.createElement('img');
            avatar.setAttribute('src', './' + garage.avatar);
            avatar.setAttribute('width', '30px');
            avatar.setAttribute('height', '40px');

            var content = document.createElement('div');
            content.style.float = 'right';
            content.style.padding = '2px';

            var title = document.createElement('a');
            title.setAttribute('href', 'javascript:void(0);');
            title.innerHTML = garage.name;

            var shortDescription = document.createElement('p');
            shortDescription.innerHTML = garage.short_description;

            content.appendChild(title);
            content.appendChild(shortDescription);

            garageDetail.appendChild(avatar);
            garageDetail.appendChild(content);

            var infowindow = new google.maps.InfoWindow({
                content: garageDetail,
                maxWidth: 1000
            });

            var image = {};
            if (garage.type === 1) {
                image = {
                    url: 'http://maps.google.com/mapfiles/kml/pal4/icon15.png'
                };
            } else if (garage.type === 2) {
                image = {
                    url: 'http://maps.google.com/mapfiles/ms/micons/motorcycling.png'
                };
            } else {
                image = {
                    url: 'http://maps.google.com/mapfiles/ms/micons/cycling.png'
                };
            }

            var marker = new google.maps.Marker({
                position: tmpPos,
                animation: google.maps.Animation.DROP
            });

            marker.setIcon(image);

            self.markers.push(marker);
            self.infoWindows.push(infowindow);

            google.maps.event.addListener(marker, 'mouseover', (function(marker, garageDetail, infowindow) {
                return function() {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                    infowindow.setContent(garageDetail);
                    infowindow.open(self.map, marker);
                };
            })(marker, garageDetail, infowindow));

            google.maps.event.addListener(marker, 'mouseout', (function(marker, garageDetail, infowindow) {
                return function() {
                    marker.setAnimation(null);
                    infowindow.close();
                };
            })(marker, garageDetail, infowindow));

            google.maps.event.addListener(marker,'click', (function(marker, garageDetail, infowindow) {
                return function() {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                    infowindow.open(self.map,marker);
                    google.maps.event.clearListeners(marker, 'mouseout');
                };
            })(marker, garageDetail, infowindow));


            google.maps.event.addListener(infowindow, 'closeclick', (function(marker, garageDetail, infowindow) {
                return function() {
                    marker.setAnimation(null);
                    infowindow.close();

                    google.maps.event.addListener(marker, 'mouseout', (function(marker, garageDetail, infowindow) {
                        return function() {
                            marker.setAnimation(null);
                            infowindow.close();
                        };
                    })(marker, garageDetail, infowindow));
                };
            })(marker, garageDetail, infowindow));

            google.maps.event.addListener(self.map, 'click', (function(marker, garageDetail, infowindow) {
                return function() {
                    marker.setAnimation(null);
                    infowindow.close();

                    google.maps.event.addListener(marker, 'mouseout', function() {
                        marker.setAnimation(null);
                        infowindow.close();
                    });
                };
            })(marker, garageDetail, infowindow));

            marker.setMap(self.map);
        }
    }

    removeAllMarkers() {
        var self = this;
        var markers = self.markers;
        markers.forEach(function (marker) {
            self.removeMarker(marker);
        });

        self.markers = [];
    };

    removeMarker(marker) {
        marker.setMap(null);
    }

    loadBy(options) {
        const $ = this.jQuery;
        var self = this;
        $.ajax({
            url: laroute.action('App\Http\Controllers\Home\GarageController@getGarages'),
            type: 'GET',
            data: {'options' : options, 'curPos' : self.curPos},
            success: function(response) {
                var status = response.status;
                if (status == -1) {
                    var errors = response.data;
                    errors.forEach(function (error) {
                        alert(error.message);
                    });
                } else {
                    var garages = response.data;
                    if (typeof(self.map) == 'undefined') {
                        self.initMaps('homeMap', self.curPos, 18, garages);
                    } else {
                        self.removeAllMarkers();
                        self.stickPositionsToMap(garages);
                    }
                }
            }
        });
    }

    initMaps(divMapId, curPos, zoom, positions) {
        var self = this;
        const $ = self.jQuery;

        self.markers = [];
        self.infoWindows = [];
        self.curPos = curPos;

        self.map = new google.maps.Map(document.getElementById(divMapId), {
            center: curPos,
            zoom: zoom
        });

        var slider = document.createElement('div');
        slider.style.zIndex = 5;
        slider.style.opacity = '0.5';
        slider.style.filter = 'alpha(opacity=100)';
        slider.style.color = 'rgb(25,25,25)';
        slider.style.padding = '15px';
        slider.setAttribute('id', 'slider');
        slider.innerHTML = '<input id="radiusSlider" type="number" data-slider-min="1" data-slider-max="5" data-slider-step="1" data-slider-value="1" data-slider-orientation="vertical"/>';

        self.map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(slider);
        
        slider.addEventListener('mouseover', function () {
            slider.style.opacity = '1.0';
        });
        slider.addEventListener('mouseout', function () {
            slider.style.opacity = '0.5';
        });

        $('document').ready(function () {
            var radiusSlider = $(slider).children('input');

            radiusSlider.slider({
                formatter: function(value) {
                    return value + ' km';
                },
                tooltip_position: 'left',
                reversed : true,
                tooltip: 'always',
                focus: true
            });

            radiusSlider.on('change', function (e) {
                homeMaps.loadBy({'radius' : e.target.value});
            });
        });

        self.map.controls[google.maps.ControlPosition.RIGHT_TOP].push(slider);

        if (typeof(positions) != 'undefined') {
            self.stickPositionsToMap(positions);
        }

        var curMaker = self.addMarker(curPos);
        curMaker.setTitle('Your are here !');
    }

    addMarker(pos) {
        var self = this;
        var marker = new google.maps.Marker({
            position: pos,
            map: self.map
        });

        return marker;
    }

    init() {
        const $ = this.jQuery;
        var self = this;
        var tmpCurPos = {lat: 21.0072956, lng: 105.80135659999999};

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var curPos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                self.curPos = curPos;
                self.loadBy({'radius' : 1});
            }, () => {
                self.initMaps('homeMap', tmpCurPos, 18);
                var infoWindow = new google.maps.InfoWindow({map: self.map});
                infoWindow.setPosition(tmpCurPos);
                self.handleLocationError(true, infoWindow, tmpCurPos);
            });
        } else {
            // Browser doesn't support Geolocation
            self.initMaps('homeMap', tmpCurPos, 18);
            var infoWindow = new google.maps.InfoWindow({map: self.map});
            infoWindow.setPosition(tmpCurPos);
            self.handleLocationError(false, infoWindow, tmpCurPos);
        }
    }

    handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
    }
}
