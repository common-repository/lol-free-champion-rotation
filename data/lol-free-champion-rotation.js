/*
Author: https://alurosu.com/lol-free-champion-rotation-example/
*/
jQuery(document).ready(function(){
    console.log('lol-free-champion-rotation: loaded!');
    jQuery.getJSON("https://alurosu.com/wordpress/plugin/lol-free-champion-rotation/?callback=?", function(result){
        jQuery(".sf-lol-champions").html('');
        result.forEach((item, i) => {
            if (item)
                jQuery(".sf-lol-champions").append('<img src="https://ddragon.leagueoflegends.com/cdn/'+item['version']+'/img/champion/'+item['image']['full']+'" alt="'+item['id']+'" title="'+item['name']+', '+item['title']+'">');
        });
    });
});
