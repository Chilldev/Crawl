$(document).ready(function() {
    $('.tabs .tab-links a').on('click', function(e){
        var currentAttrValue = jQuery(this).attr('href');
 
        $('.tabs ' + currentAttrValue).show().siblings().hide();
 
        $(this).parent('li').addClass('active').siblings().removeClass('active');
 
        e.preventDefault();
    });

    url_param();
});

function url_param(){
    var PageURL = window.location.search.substring(1);
    var URLVariables = PageURL.split('&');
    for (var i = 0; i < URLVariables.length; i++) 
    {
        var ParameterName = URLVariables[i].split('=');
        if (ParameterName[0] == 'tab') 
        {
            tab = ParameterName[1];
            $('#tab1').removeClass('active');
            $('#atab1').removeClass('active');
            $('#' + tab).addClass('active');
            $('#a' + tab).addClass('active');
        }
    }
}
