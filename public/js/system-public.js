"use strict";
jQuery(document).ready(function (e) {
	var loader_html	= '<div class="rewrite-site-wrap"><div class="gym-loader"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';

});

/*
 * @get absolute path
 * @return{}
 */
function getAbsolutePath() {
    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
}