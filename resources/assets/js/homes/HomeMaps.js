import GarageDetail from './../homes/garage/GarageDetail';
import CenterControl from  './../CenterControl';

export default class HomeMaps
{
    constructor(app) {
        this.app = app;
        this.window = app.window;
        this.jQuery = app.jQuery;
        this.directionsService = new google.maps.DirectionsService();
        this.directionsDisplay = new google.maps.DirectionsRenderer();
        this.curInfoWindow = '';
        this.garageType = 2;
        this.radius = 1;
    }

    calculateRoute(self, start, end) {
        var $ = self.jQuery;
        if (self.curInfoWindow !== '') {
            self.curInfoWindow.close();
        }

        var startPoint = new google.maps.LatLng(start.lat, start.lng);
        var endPoint = new google.maps.LatLng(end.lat, end.lng);
        var request = {
            origin: startPoint,
            destination: endPoint,
            travelMode: google.maps.TravelMode.DRIVING,
            provideRouteAlternatives: true
        };

        self.directionsService.route(request, function(response, status) {
            if (status === google.maps.DirectionsStatus.OK) {
                var routes = response.routes;
                var selectRoute = document.createElement('div');
                // selectRoute.style.zIndex = 1000;
                var routeTmpLabel = document.createElement('label');
                routeTmpLabel.innerHTML = 'Select directory';
                selectRoute.appendChild(routeTmpLabel);

                for (var i = 0; i < routes.length; i ++) {
                    var route = routes[i];
                    var tmpA = document.createElement('a');
                    tmpA.setAttribute('href', 'javascript:void(0);');
                    tmpA.setAttribute('routeIndex', '' + i);
                    tmpA.innerHTML = 'Via: ' + route.summary;
                    var brTag = document.createElement('br');
                    selectRoute.appendChild(brTag);
                    selectRoute.appendChild(tmpA);

                    $(tmpA).on('click', function (event) {
                        var routeIndex = parseInt($(event.target).attr('routeIndex'));

                        self.directionsDisplay.setDirections(response);
                        self.directionsDisplay.setRouteIndex(routeIndex);
                        self.directionsDisplay.setMap(self.map);
                    });
                }

                self.curInfoWindow = new google.maps.InfoWindow({
                    content: selectRoute,
                    maxWidth: 1000,
                    optimized: false,
                    zIndex: 1000
                });

                self.curInfoWindow.open(homeMaps.map, self.curMarker);
            } else {
                alert("Directions Request from " + startPoint.toUrlValue(6) + " to " + endPoint.toUrlValue(6) + " failed: " + status);
            }
        });
    }

    w3_open() {
        document.getElementById("mySidebar").style.width = "25%";
        document.getElementById("mySidebar").style.display = "block";
    }

    w3_close() {
        document.getElementById("main").style.marginLeft = "0%";
        document.getElementById("mySidebar").style.display = "none";
    }

    showGarageDetail(self, id) {
        const $ = self.jQuery;

        $('#mySidebar').unbind('scroll');
        $('#mySidebar').find('*').off();

        $.ajax({
            url: laroute.action('App\Http\Controllers\Home\GarageController@getSpecificGarage'),
            method: 'GET',
            data: {'id' : id},
            success: function (response) {
                if (response.status == -1) {
                    var errors = response.data;
                    errors.forEach(function (error) {
                        alert(error.message);
                    });
                } else {
                    $('#mySidebarContent').html(response);
                    $('#mySidebarContent').css('overflow', 'hidden');
                    $('#closeDetailBtn').on('click', function () {
                        homeMaps.w3_close();
                        homeMaps.displayGaragesList(homeMaps.garages);
                    });
                    
                    self.w3_open();

                    var garageDetail = new GarageDetail(self.app, id);
                    garageDetail.init();
                }
            }
        });
    }
    
    stickPositionsToMap(positions) {
        var self = this;
        for (var i = 0; i < positions.length; i ++) {
            var garage = positions[i];
            var tmpPos = {lat: garage.lat , lng: garage.lng};

            var garageDetail = document.createElement('div');
            var detailId = 'detailGarage' + garage.id;
            garageDetail.setAttribute('id', detailId);

            // var avaDiv = document.createElement('div');
            var avatar = document.createElement('img');
            avatar.setAttribute('src', assetUrl + garage.avatar);
            avatar.setAttribute('width', '30px');
            avatar.setAttribute('height', '40px');

            var content = document.createElement('div');
            content.style.float = 'right';
            content.style.padding = '2px';

            var title = document.createElement('a');
            title.setAttribute('href', 'javascript:void(0);');
            title.innerHTML = garage.name;
            $(title).click(self.showGarageDetail.bind($, this, garage.id));

            var avgRatingField = document.createElement('label');
            var avgRating = garage.rating;
            var ratingContent = '';
            for (var star = 1; star <= 10; star ++) {
                if (star <= Math.floor(avgRating)) {
                    var tmpStar = '<i class="fa fa-star" style="font-size:15px;color:#eca33d"></i>';
                    ratingContent += tmpStar;
                    if (star == Math.floor(avgRating) && avgRating > Math.floor(avgRating)) {
                        star ++;
                        var tmpHalfStar = '<i class="fa fa-star-half-full" style="font-size:15px;color:#eca33d"></i>';
                        ratingContent += tmpHalfStar;
                    }
                } else {
                    var tmpOStar = '<i class="fa fa-star-o" style="font-size:15px;color:#eca33d"></i>';
                    ratingContent += tmpOStar;
                }
            }
            avgRatingField.innerHTML = ratingContent;

            var shortDescription = document.createElement('p');
            shortDescription.innerHTML = garage.short_description;

            var brTag = document.createElement('br');

            content.appendChild(title);
            content.appendChild(brTag);
            content.appendChild(avgRatingField);
            content.appendChild(shortDescription);

            var routeBtn = document.createElement('div');
            routeBtn.innerHTML = '<a id="routeFromCurPos" href="javascript:void(0);">Route to...</a>';
            garageDetail.appendChild(avatar);
            garageDetail.appendChild(content);
            garageDetail.appendChild(routeBtn);

            self.garageDetailHtml = garageDetail;

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
                animation: google.maps.Animation.DROP,
                customGarageId: garage.id
            });

            marker.setIcon(image);

            self.markers.push(marker);
            self.infoWindows.push(infowindow);

            $(routeBtn).click(self.calculateRoute.bind($, this, self.curPos, tmpPos));

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

            google.maps.event.addListener(marker, 'click', (function(marker, garageDetail, infowindow) {
                return function() {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                    infowindow.open(self.map, marker);
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

            if (positions.length === 1) {
                new google.maps.event.trigger( marker, 'click' );
            }
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

    displayGaragesList(garages) {
        var self = this;
        const $ = self.jQuery;

        $('#mySidebar').unbind('scroll');
        $('#mySidebar').find('*').off();

        $.ajax({
            url: laroute.action('App\Http\Controllers\Home\HomeController@getGaragesListView'),
            type: 'GET',
            success: function(response) {
                $('#mySidebarContent').html(response);
                $('#mySidebarContent').css('overflow', 'hidden');
                for (var i = 0; i < garages.length; i ++) {
                    var tmpGarage = garages[i];
                    var tmpRow = '<tr><td class="media garageInListChosenBtn" data-garage-id="' +
                            tmpGarage.id + '" ><a href="javascript:void(0);">' +
                            '<img class="media-photo img-circle" src="' + assetUrl + tmpGarage.avatar + '">' +
                            tmpGarage.name + '</a></td></tr>';
                    $('#garagesListField').append(tmpRow);
                }

                $('.garageInListChosenBtn').click(function (event) {
                    var garageId = $(event.currentTarget).data('garage-id');
                    for (var i = 0; i < homeMaps.markers.length; i ++) {
                        var tmpMarker = homeMaps.markers[i];
                        if (tmpMarker.customGarageId == garageId) {
                            new google.maps.event.trigger(tmpMarker, 'click');
                            homeMaps.map.panTo(tmpMarker.getPosition());
                        }
                    }
                });

                $('.media').click(function () {
                    $(this).closest('tr').toggleClass('selected');
                });

                $('#closeGaragesListBtn').click(function () {
                    homeMaps.w3_close();
                });
            }
        });


        // $('#closeDetailBtn').on('click', function () {
        //     homeMaps.w3_close();
        // });

        self.w3_open();
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
                    self.garages = garages;
                    if (typeof(self.map) == 'undefined') {
                        self.initMaps('homeMap', self.curPos, 15, garages);
                    } else {
                        self.removeAllMarkers();
                        self.stickPositionsToMap(garages);
                    }

                    self.displayGaragesList(garages);
                }
            }
        });
    }

    centerControlCallback() {
        return null;
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

        var viewGaragesList = document.createElement('div');
        viewGaragesList.title = 'View garages list';
        viewGaragesList.style.background = '#ffffff';
        viewGaragesList.style.zIndex = 5;
        viewGaragesList.style.opacity = '0.8';
        viewGaragesList.style.filter = 'alpha(opacity=100)';
        viewGaragesList.style.padding = '10px';
        viewGaragesList.innerHTML = '<a href="javascript:void(0);"><i class="fa fa-bars" style="color:#fb9c56;font-size:36px"></i></a>';

        $(viewGaragesList).click(function () {
            homeMaps.w3_open();
        });

        self.map.controls[google.maps.ControlPosition.LEFT_TOP].push(viewGaragesList);

        var centerControlDiv = document.createElement('div');
        var centerControl = new CenterControl(centerControlDiv, self.map, curPos, self);
        centerControl.init();

        centerControlDiv.index = 1;
        self.map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(centerControlDiv);

        var slider = document.createElement('div');
        slider.style.zIndex = 5;
        slider.style.opacity = '0.5';
        slider.style.filter = 'alpha(opacity=100)';
        slider.style.padding = '15px';
        slider.setAttribute('id', 'slider');
        slider.innerHTML = '<input id="radiusSlider" type="number" data-slider-min="1" data-slider-max="5" data-slider-step="1" data-slider-value="' + self.radius + '" data-slider-orientation="vertical"/>';


        var filterBox = document.createElement('div');
        filterBox.style.zIndex = 5;
        filterBox.style.opacity = '0.5';
        filterBox.style.filter = 'alpha(opacity=100)';
        filterBox.style.color = 'rgb(25,25,25)';
        filterBox.style.fontFamily = 'Roboto,Arial,sans-serif';
        filterBox.style.fontSize = '16px';
        filterBox.style.lineHeight = '38px';
        filterBox.style.paddingLeft = '5px';
        filterBox.style.paddingRight = '50px';
        filterBox.innerHTML = '<select id="selectType" style="color: white;background-color: rgba(0, 0, 0, 1)">' +
            '<option value="3">Bicycle</option>' +
            '<option value="2">Motor</option>' +
            '<option value="1">Car</option></select>';

        self.map.controls[google.maps.ControlPosition.TOP_RIGHT].push(filterBox);
        //
        filterBox.addEventListener('mouseover', function () {
            filterBox.style.opacity = '0.7';
        });
        //
        filterBox.addEventListener('mouseout', function () {
            filterBox.style.opacity = '0.5';
        });
        //
        $(filterBox).ready(function () {
            var selectBox = $(filterBox.firstChild);
            selectBox.val(self.garageType);
            selectBox.change(function (event) {
                var garageType = $(event.target).val();
                homeMaps.loadBy({'type' : garageType});
            });
        });


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

        var curMarker = new google.maps.Marker({
            position: curPos,
            map: self.map,
            optimized: false,
            zIndex: 1000
        });
        curMarker.setTitle('Your are here !');

        self.curMarker = curMarker;
    }

    init(divMapId, viewedGarage) {
        const $ = this.jQuery;
        var self = this;
        var tmpCurPos = {lat: 21.0072956, lng: 105.80135659999999};

        $.ajax({
            url: laroute.action('App\Http\Controllers\Home\GarageController@getInitParameters'),
            method: 'GET',
            success: function (response) {
                if (response.status == -1) {
                    var errors = response.data;
                    errors.forEach(function (error) {
                        alert(error.message);
                    });
                } else {
                    var data = response.data;
                    self.garageType = data.type;
                    self.radius = data.radius;

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            var curPos = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude
                            };
                            self.curPos = curPos;

                            if (viewedGarage !== null) {
                                self.viewSpecificGarage(divMapId, viewedGarage);
                            } else {
                                self.loadBy({'type' : self.garageType, 'radius' : self.radius});
                            }
                        }, () => {
                            self.curPos = tmpCurPos;
                            if (viewedGarage !== null) {
                                self.viewSpecificGarage(divMapId, viewedGarage);
                            } else {
                                self.initMaps(divMapId, self.curPos, 12);
                            }

                            var infoWindow = new google.maps.InfoWindow({map: self.map});
                            infoWindow.setPosition(tmpCurPos);
                            self.handleLocationError(true, infoWindow, tmpCurPos);
                        });
                    } else {
                        // Browser doesn't support Geolocation
                        self.initMaps(divMapId, tmpCurPos, 18);
                        var infoWindow = new google.maps.InfoWindow({map: self.map});
                        infoWindow.setPosition(tmpCurPos);
                        self.handleLocationError(false, infoWindow, tmpCurPos);
                    }

                }
            }
        });
    }

    viewSpecificGarage(divMapId, viewedGarage) {
        var self = this;
        var garage = viewedGarage[0];
        self.garages = viewedGarage;
        self.garageType = garage.type;
        self.initMaps(divMapId, self.curPos, 12, viewedGarage);
        self.showGarageDetail(self, garage.id);
        var tmpCenter = {lat: garage.lat, lng: garage.lng};
        self.map.setCenter(tmpCenter);
    }

    handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            '<label class="alert-danger">Default location was enabled !</label><p class="alert-warning">because of the Geolocation service failed.</p>' :
            'Error: Your browser doesn\'t support geolocation.');
    }
}
