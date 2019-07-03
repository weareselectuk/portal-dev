function get_browser(){
    var nVer = navigator.appVersion;
    var nAgt = navigator.userAgent;
    var browserName  = navigator.appName;
    var fullVersion  = ''+parseFloat(navigator.appVersion);
    var majorVersion = parseInt(navigator.appVersion,10);
    var nameOffset,verOffset,ix;
    var response = [];

    /*In Opera, the true version is after "Opera" or after "Version"*/
    if ((verOffset=nAgt.indexOf("Opera"))!=-1) {
        browserName = "Opera";
        fullVersion = nAgt.substring(verOffset+6);
        if ((verOffset=nAgt.indexOf("Version"))!=-1)
            fullVersion = nAgt.substring(verOffset+8);
    }
    /*In MSIE, the true version is after "MSIE" in userAgent*/
    else if ((verOffset=nAgt.indexOf("MSIE"))!=-1) {
        browserName = "Microsoft Internet Explorer";
        fullVersion = nAgt.substring(verOffset+5);
    }
    /*In Chrome, the true version is after "Chrome"*/
    else if ((verOffset=nAgt.indexOf("Chrome"))!=-1) {
        browserName = "Chrome";
        fullVersion = nAgt.substring(verOffset+7);
    }
    /*In Safari, the true version is after "Safari" or after "Version"*/
    else if ((verOffset=nAgt.indexOf("Safari"))!=-1) {
        browserName = "Safari";
        fullVersion = nAgt.substring(verOffset+7);
        if ((verOffset=nAgt.indexOf("Version"))!=-1)
            fullVersion = nAgt.substring(verOffset+8);
    }
    /*In Firefox, the true version is after "Firefox"*/
    else if ((verOffset=nAgt.indexOf("Firefox"))!=-1) {
        browserName = "Firefox";
        fullVersion = nAgt.substring(verOffset+8);
    }
    /*In most other browsers, "name/version" is at the end of userAgent*/
    else if ( (nameOffset=nAgt.lastIndexOf(' ')+1) <
        (verOffset=nAgt.lastIndexOf('/')) )
    {
        browserName = nAgt.substring(nameOffset,verOffset);
        fullVersion = nAgt.substring(verOffset+1);
        if (browserName.toLowerCase()==browserName.toUpperCase()) {
            browserName = navigator.appName;
        }
    }
    /*trim the fullVersion string at semicolon/space if present*/
    if ((ix=fullVersion.indexOf(";"))!=-1)
        fullVersion=fullVersion.substring(0,ix);
    if ((ix=fullVersion.indexOf(" "))!=-1)
        fullVersion=fullVersion.substring(0,ix);

    majorVersion = parseInt(''+fullVersion,10);
    if (isNaN(majorVersion)) {
        fullVersion  = ''+parseFloat(navigator.appVersion);
        majorVersion = parseInt(navigator.appVersion,10);
    }

    /*document.write(''
     +'Browser name  = '+browserName+'<br>'
     +'Full version  = '+fullVersion+'<br>'
     +'Major version = '+majorVersion+'<br>'
     +'navigator.appName = '+navigator.appName+'<br>'
     +'navigator.userAgent = '+navigator.userAgent+'<br>'
    );*/

    browser = browserName+' '+fullVersion;

    /*jQuery('#wpfbsysinfo_browser').html(browser);
    device_type = 'Desktop';
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        device_type = 'Mobile';
    }
    jQuery('#wpfbsysinfo_device').html(device_type);
    response['name']=browserName;*/

    var wpf_tmp_browser_name = get_browser_name();
    if(wpf_tmp_browser_name!=''){
        response['name']=wpf_tmp_browser_name;
    }
    else{
        response['name']=browserName;
    }
    response['version']=fullVersion;
    response['OS']='';

    return response;
}

function get_browser_name() {
    var response = '';

    /*Opera 8.0+*/
    var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
    if (isOpera){
        response='Opera';
    }

    /*Firefox 1.0+*/
    var isFirefox = typeof InstallTrigger !== 'undefined';
    if(isFirefox){
        response='Firefox';
    }

    /*Safari 3.0+ "[object HTMLElementConstructor]"*/
    var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));
    if(isSafari){
        response='Safari';
    }

    /*Internet Explorer 6-11*/
    var isIE = /*@cc_on!@*/false || !!document.documentMode;
    if(isIE){
        response='Internet Explorer';
    }

    /*Edge 20+*/
    var isEdge = !isIE && !!window.StyleMedia;
    if(isEdge){
        response='Edge';
    }

    /*Chrome 1 - 71*/
    var isChrome = !!window.chrome && (!!window.chrome.webstore || !!window.chrome.runtime);
    if(isChrome){
        response='Chrome';
    }

    return response;
}