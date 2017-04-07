import CenterControl from './../../CenterControl';

const STICK_TO_MAP_OPTIONS = {
    'currentPosition' : 1,
    'add' : 2,
    'update' : 3
};

export default class PartnerMaps
{
    constructor(app) {
        this.jQuery = app.jQuery;
        this.window = app.window;
        this.garage = {};
        this.map = {};
        this.curPos = {};
    }

    initMaps(divMapId, curPos, zoom, garage) {
        var self = this;
        const $ = self.jQuery;

        self.markers = [];
        self.infoWindows = [];
        self.curPos = curPos;

        self.map = new google.maps.Map(document.getElementById(divMapId), {
            center: curPos,
            zoom: zoom
        });

        var centerControlDiv = document.createElement('div');
        var centerControl = new CenterControl(centerControlDiv, self.map, curPos, self);
        centerControl.init();

        centerControlDiv.index = 1;
        self.map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);

        var searchBox = document.createElement('div');
        searchBox.style.zIndex = 5;
        searchBox.style.opacity = '0.5';
        searchBox.style.filter = 'alpha(opacity=100)';
        searchBox.style.color = 'rgb(25,25,25)';
        searchBox.style.fontFamily = 'Roboto,Arial,sans-serif';
        searchBox.style.fontSize = '16px';
        searchBox.style.lineHeight = '38px';
        searchBox.style.paddingLeft = '5px';
        searchBox.style.paddingRight = '5px';
        searchBox.innerHTML = '<input id="searchInput" name="searchKeyword" style="margin:5px;" placeholder="Tìm kiếm..."><a class="btn btn-primary" id="searchBtn"><i class="fa fa-search" style="font-size:24px"></i></a>';
        // searchUI.appendChild(searchBox);
        // var searchBox = new google.maps.places.SearchBox(searchBox);
        self.map.controls[google.maps.ControlPosition.TOP_RIGHT].push(searchBox);
        //
        searchBox.addEventListener('mouseover', function () {
            searchBox.style.opacity = '0.8';
        });
        //
        searchBox.addEventListener('mouseout', function () {
            searchBox.style.opacity = '0.5';
        });

        google.maps.event.addListener(self.map, "rightclick", function(event) {
            var lat = event.latLng.lat();
            var lng = event.latLng.lng();
            // populate yor box/field with lat, lng
            self.stickPositionToMap({lat: lat, lng: lng}, self.garage.markerUrl);
            // self.updateLocation(lat, lng);
        });

        var searchBtn = $(searchBox).find('#searchBtn');
        $(searchBtn).click(function () {
            self.searchByKeyword();
        });

        self.stickPositionToMap({lat: curPos.lat, lng: curPos.lng, address: 'Your are here !'}, null, STICK_TO_MAP_OPTIONS.add);

        if (garage.lat !== null && garage.lng !== null) {
            self.stickPositionToMap(
                [{'lat' : garage.lat, 'lng' : garage.lng, 'address' : garage.address}],
                garage.markerUrl,
                STICK_TO_MAP_OPTIONS.currentPosition
            );
        }
    }

    centerControlCallback() {
        this.assignCurrentLocation();
    }

    assignCurrentLocation() {
        var self = this;
        self.stickPositionToMap({lat: self.curPos.lat, lng: self.curPos.lng}, null, STICK_TO_MAP_OPTIONS.update);
    }

    createInfoWindow(garage) {
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

        garageDetail.appendChild(avatar);
        garageDetail.appendChild(content);

        self.garageDetailHtml = garageDetail;

        var infowindow = new google.maps.InfoWindow({
            content: garageDetail,
            pixelOffset: new google.maps.Size(0, -20),
            maxWidth: 1000
        });

        return infowindow;
    }


    init() {
        const $ = this.jQuery;
        var self = this;
        var divMapId = 'partnerGarageMaps';
        var mapDiv = $('#' + divMapId);
        self.garage = mapDiv.data('garage');

        var markerUrl = '';
        if (self.garage.type === 1) {
            markerUrl = 'http://maps.google.com/mapfiles/kml/pal4/icon15.png';
        } else if (self.garage.type === 2) {
            markerUrl = 'http://maps.google.com/mapfiles/ms/micons/motorcycling.png';
        } else {
            markerUrl = 'http://maps.google.com/mapfiles/ms/micons/cycling.png';
        }

        self.garage.markerUrl = markerUrl;
        self.infoWindow = self.createInfoWindow(self.garage);

        var tmpCurPos = {lat: 21.0072956, lng: 105.80135659999999};

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var curPos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                self.curPos = curPos;
                self.initMaps(divMapId, self.curPos, 12, self.garage);
            }, () => {
                self.curPos = tmpCurPos;
                self.initMaps(divMapId, self.curPos, 12, self.garage);

                var infoWindow = new google.maps.InfoWindow({map: self.map});
                infoWindow.setPosition(tmpCurPos);
                self.handleLocationError(true, infoWindow, tmpCurPos);
            });
        } else {
            // Browser doesn't support Geolocation
            self.initMaps(divMapId, tmpCurPos, 18, self.garage);
            var infoWindow = new google.maps.InfoWindow({map: self.map});
            infoWindow.setPosition(tmpCurPos);
            self.handleLocationError(false, infoWindow, tmpCurPos);
        }
    }

    handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            '<label class="alert-danger">Default location was enabled !</label><p class="alert-warning">because of the Geolocation service failed.</p>' :
            'Error: Your browser doesn\'t support geolocation.');
    }

    updateLocation(lat, lng, option) {
        const $ = this.jQuery;
        var self = this;

        var cnf = confirm('Confirm this location ?');
        if (cnf) {
            $.ajax({
                url : laroute.action('App\Http\Controllers\Partner\GarageController@updateLocation'),
                method : 'POST',
                data : {'id' : self.garage.id, 'lat' : lat, 'lng' : lng},
                success : function (response) {
                    var status = response.status;
                    if (status == -1) {
                        var errors = response.data;
                        errors.forEach(function (error) {
                            alert(error.message);
                        });
                    } else {
                        self.garage.lat = lat;
                        self.garage.lng = lng;

                        self.stickPositionToMap(
                            {lat: self.garage.lat, lng: self.garage.lng, address: self.garage.address},
                            self.garage.markerUrl, option
                        );

                        var infowindow = self.infoWindow;
                        infowindow.setPosition({lat: self.garage.lat, lng: self.garage.lng});
                        infowindow.open(self.map);
                    }
                }
            });
        }
    }

    stickPositionsToMap(positions, iconUrl, option) {
        var self = this;

        for (var i = 0; i < positions.length; i ++) {
            var tmpPos = {lat: positions[i].lat, lng: positions[i].lng, address: positions[i].address};
            self.stickPositionToMap(tmpPos, iconUrl, option);
        }
    }

    stickPositionToMap(tmpPos, iconUrl, option) {
        var self = this;
        if (option === STICK_TO_MAP_OPTIONS.currentPosition) {
            self.stickPositionToMap({lat: self.garage.lat, lng: self.garage.lng, address: self.garage.address}, iconUrl);

            var infowindow = self.infoWindow;
            infowindow.setPosition({lat: self.garage.lat, lng: self.garage.lng});
            infowindow.open(self.map);

            return;
        }

        if (option === STICK_TO_MAP_OPTIONS.update) {
            return;
        }

        var markerTitle = tmpPos.address;
        var marker = new google.maps.Marker({
            title: markerTitle,
            position: tmpPos,
            animation: google.maps.Animation.DROP
        });

        var image = {};
        if (iconUrl !== undefined && iconUrl !== null) {
            image = {
                url: iconUrl
            };
            marker.setIcon(image);
        }
        self.markers.push(marker);

        google.maps.event.addListener(marker, 'click', (function(marker, option, self) {
            return function() {
                var markerLocation = {lat: marker.getPosition().lat(), lng: marker.getPosition().lng()};
                if (markerLocation.lat === self.garage.lat && markerLocation.lng === self.garage.lng) {
                    return ;
                } else {
                    self.updateLocation(markerLocation.lat, markerLocation.lng, STICK_TO_MAP_OPTIONS.update);
                }
            };
        })(marker, option, self));

        google.maps.event.addListener(marker, 'mouseover', (function(marker) {
            return function() {
                marker.setAnimation(google.maps.Animation.BOUNCE);
            };
        })(marker));

        google.maps.event.addListener(marker, 'mouseout', (function(marker) {
            return function() {
                marker.setAnimation(null);
            };
        })(marker));

        marker.setMap(self.map);
    }

    searchByKeyword() {
        const $ = this.jQuery;
        var self = this;
        var searchKey = $('#searchInput').val();
        delete $.ajaxSettings.headers["X-CSRF-TOKEN"];
        $.ajax({
            url: "https://maps.googleapis.com/maps/api/geocode/json?address=" + searchKey,
            method: "GET",
            success: function (data) {
                if (data.results.length == 0) {
                    alert("No data !");
                    return null;
                }
                var results = data.results;

                var searchResults = [];
                for (var i = 0; i < results.length; i ++) {
                    var lat = data.results[i].geometry.location.lat;
                    var lng = data.results[i].geometry.location.lng;
                    var address = data.results[i].formatted_address;
                    searchResults[i] = {lat: lat, lng: lng, address: address};
                }

                self.map.setCenter(searchResults[0]);
                self.stickPositionsToMap(searchResults, 'http://maps.google.com/mapfiles/ms/micons/grn-pushpin.png');
            }
        });

        $.ajaxSettings.headers["X-CSRF-TOKEN"] = $('meta[name="csrf-token"]').attr('content');
    }
}
