var innerHeight = window.innerHeight;
var modIndexStr = '<div id="mod-index" class="mod-index">';
for (var i = 0; i < arrIndex.length; i++) {
    modIndexStr += '<a href="#' + arrIndex[i] + '" class="mod-index__item">' + arrIndex[i].toUpperCase() + '</a>'
}
modIndexStr += '</div>';
document.body.innerHTML += modIndexStr;

function hasClass(ele, cls) {
    return ele.className.match(new RegExp('(\\s|^)' + cls + '(\\s|$)'));
}
function addClass(ele, cls) {
    if (!this.hasClass(ele, cls)) ele.className += " " + cls;
}

function removeClass(ele, cls) {
    if (hasClass(ele, cls)) {
        var reg = new RegExp('(\\s|^)' + cls + '(\\s|$)');
        ele.className = ele.className.replace(reg, ' ');
    }
}
var modIndex = document.getElementById("mod-index");
onscroll = function () {
    var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
    if (scrollTop > 350) {
        addClass(modIndex, "mod-index_fixed");
    } else {
        removeClass(modIndex, "mod-index_fixed");
    }
};


function addGlobalStyle(id, css) {
    var nodeId = document.getElementById(id);
    if (nodeId) {
        nodeId.parentNode.removeChild(nodeId);
    }
    var head, style;
    head = document.getElementsByTagName('head')[0];
    if (!head) {
        return;
    }
    style = document.createElement('style');
    style.type = 'text/css';
    style.id = id;
    var hasID = document.getElementById(id);
    if (hasID) {
        hasID.innerHTML = css;
    } else {
        head.appendChild(style);
        try {
            style.innerHTML = css;
        } catch (e) {
            alert(e);
        }
    }
}
function fillWithIndex() {
    var indexItemHeight = innerHeight / arrIndex.length;
    addGlobalStyle("indexItem", ".mod-index__item{height:" + indexItemHeight + "px;line-height:" + indexItemHeight + "px}");
}
fillWithIndex();
window.onorientationchange = function () {
    location.reload(true);
};

/* 页面太高无法用scrollTop Uncaught RangeError: Maximum call stack size exceeded
 function touchStart(event) {
 //    event.preventDefault();
 if (!event.touches.length) return;
 var touch = event.touches[0];
 var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
 var location=(touch.pageY - scrollTop) / clientHeight * (document.body.clientHeight - 368) + 368;
 console.log(location);
 }

 modIndex.addEventListener("touchstart", touchStart, false);

 function touchMove(event) {
 event.preventDefault();
 if (!event.touches.length) return;
 var touch = event.touches[0];
 }

 modIndex.addEventListener("touchmove", touchMove, false);*/

window.onload = function () {
    document.addEventListener("WeixinJSBridgeReady", onWeixinReady, false);
};
function onWeixinReady() {
    WeixinJSBridge.invoke('getNetworkType', {},
        function (e) {
            var isWifi = e.err_msg.indexOf("wifi") >= 0;
            if (!isWifi) {
                document.getElementById("wifi").className = "mod-wifi mod-wifi_off";
            }
        });
}