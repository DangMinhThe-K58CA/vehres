export default class CenterControl
{
    constructor(controlDiv, map, curPos, instance) {
        this.controlDiv = controlDiv;
        this.map = map;
        this.curPos = curPos;
        this.instance = instance;
        // Set CSS for the control border.

    }

    init() {
        var self = this;
        var controlUI = document.createElement('div');

        controlUI.style.backgroundColor = '#e6ffff';
        controlUI.style.float = 'left';
        controlUI.style.opacity = '0.5';
        controlUI.style.filter = 'alpha(opacity=100)';
        controlUI.style.border = '2px solid #fff';
        controlUI.style.borderRadius = '3px';
        controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
        controlUI.style.cursor = 'pointer';
        controlUI.style.marginBottom = '22px';
        controlUI.style.textAlign = 'center';
        controlUI.title = 'Focus on current location !';
        self.controlDiv.appendChild(controlUI);
        //
        var controlText = document.createElement('div');
        controlText.style.zIndex = 5;
        controlText.style.color = 'rgb(25,25,25)';
        controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
        controlText.style.fontSize = '16px';
        controlText.style.lineHeight = '38px';
        controlText.style.paddingTop = '10px';
        controlText.style.paddingLeft = '10px';
        controlText.style.paddingRight = '10px';
        controlText.innerHTML = '<i class="fa fa-crosshairs" style="color:blue;font-size:30px"></i>';
        controlUI.appendChild(controlText);

        // Setup the click event listeners: simply set the map to Chicago.
        controlUI.addEventListener('mouseover', function () {
            controlUI.style.opacity = '1';
        });
        //
        controlUI.addEventListener('mouseout', function () {
            controlUI.style.opacity = '0.4';
        });
        //
        controlUI.addEventListener('click', function() {
            self.map.setCenter(self.curPos);
            self.instance.centerControlCallback();
        });
    }
}
