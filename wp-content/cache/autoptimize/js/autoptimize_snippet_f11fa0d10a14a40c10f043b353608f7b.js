(function($){$(document).ready(function($){if(ryviu_app.active_reviews_tab==1){$('.ryviu_reviews_tab_tab > a').trigger('click');}
if(ryviu_app.position_display==1){$(document).on('click','.product-widget__ryviu',function(){$('html, body').animate({scrollTop:$(".ryviu_reviews_tab_tab").offset().top},500)
$('.ryviu_reviews_tab_tab > a').trigger('click');});}});})(jQuery);