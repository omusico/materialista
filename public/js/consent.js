var consentIsSet = "unknown";
var cookieBanner = "#cookieBanner";
var consentString = "cookieConsent=";

// Sets a cookie granting/denying consent, and displays some text on console/banner
function setCookie(consent) {
    $(cookieBanner).hide(); //hide instead of .fadeOut(5000);
    var d = new Date();
    var exdays = 30*12; //  1 year
    d.setTime(d.getTime()+(exdays*24*60*60*1000));
    var expires = "expires="+d.toGMTString();
    document.cookie = consentString + consent + "; " + expires + ";path=/";
    consentIsSet = consent;
}

function denyConsent() {
    setCookie("false");
}

function grantConsent() {
    if (consentIsSet == "true") return; // Don't grant twice
    setCookie("true");
    //initAnalytics();
}

function initAnalytics() {
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-61042823-1', 'auto');
    ga('send', 'pageview');

    initAnalyticsEvents();
}

function initAnalyticsEvents() {
    $('#register-link').click(function(){
        ga('send', 'event', 'attempts', 'registration','');
    });
    $('#register-submit-button').click(function(){
        ga('send', 'event', 'actions', 'registration','submit');
    });
    $('#register-cancel-button').click(function(){
        ga('send', 'event', 'actions', 'registration','cancel');
    });
}

// main routine
// First, check if cookie is present
var cookies = document.cookie.split(";");
for (var i = 0; i < cookies.length; i++) {
    var c = cookies[i].trim();
    if (c.indexOf(consentString) == 0) {
        consentIsSet = c.substring(consentString.length, c.length);
    }
}

if (consentIsSet == "unknown") {
    $(cookieBanner).fadeIn();
    //For now, consent is only granted when click on any link (unless it is the privacy terms link)
    $("a:not(.noconsent)").click(grantConsent);
    $(".denyConsent").click(denyConsent);
    //Allow cookies re-enabling
    $(".allowConsent").click(grantConsent);
} else if (consentIsSet == "true") {
    initAnalytics();
}
