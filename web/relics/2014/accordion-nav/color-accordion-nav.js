/*!
    Colorful Accordion Navigation
    http://experimental.byjoby.com/2014/accordion-nav/
    ---
    You may use Colorful Accordion Navigation under the terms
    of the MIT license. Basically that means you are free to use and modify
    Colorful Accordion Navigation as long as this header is left 
    intact. Copyright 2014, Joby Elliott
*/
$(function(){
    $('.color-accordion-nav').each(function(){
        var $nav = $(this);
        $nav.find('.current').addClass('hover');
        $nav.addClass('js-enabled');
        //change border color to current link's color
        $nav.css('border-color',$nav.find('a.current').css('background-color'));
        //hover intent to toggle hover classes
        $nav.find('> ul a').hoverIntent({
            over:function(){
                //handlerIn
                $nav.find('> ul a').removeClass('hover');
                $(this).addClass('hover');
            },
            interval:50
        });
        //hover intent to return to current page after mouse leaves header
        $nav.hoverIntent({
            out:function(){
                $nav.find('a').removeClass('hover');
                $nav.find('a.current').addClass('hover');
            },
            timeout:1000
        });
        //sideways scrolling on touch events
        var isTouchDevice = function () {
            try{
                document.createEvent("TouchEvent");
                return true;
            }catch(e){
                return false;
            }
        }
        if (isTouchDevice()) {
            $nav.css('overflow','hidden');
            var nav = this;
            var scrollStartPos = 0;
            nav.addEventListener("touchstart",function(event){
                scrollStartPos = this.scrollLeft+event.touches[0].pageX;
                //event.preventDefault();
            });
            nav.addEventListener("touchmove",function(event){
                this.scrollLeft = scrollStartPos-event.touches[0].pageX;
                event.preventDefault();
            });
        }
    });
});