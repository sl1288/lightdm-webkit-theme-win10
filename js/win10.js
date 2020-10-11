/**
 * Created by Sebastian on 19.03.2017.
 */
function setLayer2(body,layer) {
    body.className = "layer2";
    setTimeout(function() {
        layer.style.webkitAnimationDelay = 0;
        layer.style.webkitAnimationName  = 'avatar_in';
        layer.style.animationDelay = 0;
        layer.style.animationName  = 'avatar_in';
    }, 1);
    clearInterval(clockLoop);
}

var body = document.getElementById("body");
var layer1= document.getElementById("layer1");
body.onclick = function () {
    setLayer2(body,layer1);
};

body.onkeydown = function () {
    if (body.className != "layer2") {
        setLayer2(body,layer1);
    }
};
var weekday = new Array(7);
weekday[0] = "Sonntag";
weekday[1] = "Montag";
weekday[2] = "Dienstag";
weekday[3] = "Mittwoch";
weekday[4] = "Donnerstag";
weekday[5] = "Freitag";
weekday[6] = "Samstag";

var month = new Array(12);
month[0] = "Januar";
month[1] = "Februar";
month[2] = "März";
month[3] = "April";
month[4] = "Mai";
month[5] = "Juni";
month[6] = "Juli";
month[7] = "August";
month[8] = "September";
month[9] = "Oktober";
month[10] = "November";
month[11] = "Dezember";

var clockLoop = setInterval(clockDo,1000);
function clockDo() {
    var d = new Date();
    var h = d.getHours();
    var m = d.getMinutes();
    if (h < 10) {
        h = "0" + h;
    }
    if (m < 10) {
        m = "0" + m;
    }



    var n = month[d.getMonth()];
    document.getElementById("date-weekday").innerHTML = weekday[d.getDay()];
    document.getElementById("date-month").innerHTML = month[d.getMonth()];
    document.getElementById("date-day").innerHTML = d.getDate();

    document.getElementById("clock-left").innerHTML = h;
    document.getElementById("clock-right").innerHTML = m;
}
clockDo();
