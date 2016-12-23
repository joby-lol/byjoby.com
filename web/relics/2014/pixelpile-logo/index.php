<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/../core.php";
$PPC_Cool     = ["#003e53", "#006bb6", "#3dadc1", "#8bd470", "#bce362", "#eeffdc"];
$PPC_Warm     = ["#d13100", "#f14400", "#ff6100", "#ffba15", "#ffdd6c", "#ffffdf"];
$PPC_Grey     = ["#111", "#333", "#555", "#bbb", "#ccc", "#eee"];
$PPC_GreyCyan = ["#111", "#444", "#09c", "#0bd", "#ccc", "#eee"];
$PPC_GreyCool = ["#333", "#444", "#3dadc1", "#8bd470", "#eee", "#fafafa"];
$PPC          = $PPC_GreyCool;

byjoby\Templates\TwigPage::set(array(
    'page_title' => 'Pixel{pile} logo',
));

?>
<link rel="stylesheet" href="pixelpile-basic.css" />
<style>
    .pixelpile-background-accent, hr.pixelpile {
        background:<?=$PPC[3]?>;
    }
    .pixelpile-logotype {
        color:<?=$PPC[2]?>;
    }
    .pixelpile-logotype-pile {
        color:<?=$PPC[3]?>;
    }
    /*
        Color variations
    */
    .pixelpile-color-1 {
        background:<?=$PPC[5]?>;
        color:<?=$PPC[2]?>;
    }
    .pixelpile-color-2 {
        background:<?=$PPC[4]?>;
        color:<?=$PPC[1]?>;
    }
    .pixelpile-color-3 {
        background:<?=$PPC[3]?>;
        color:<?=$PPC[0]?>;
    }
    /*
        CSS logo blocks
    */
    .pixelpile-logo-block {
        background:<?=$PPC[0]?>;
    }
    .pixelpile-logo-block-c0 {
        background:<?=$PPC[5]?>;
    }
    .pixelpile-logo-block-c1 {
        background:<?=$PPC[4]?>;
    }
    .pixelpile-logo-block-c2 {
        background:<?=$PPC[3]?>;
    }
    .pixelpile-logo-block-c3 {
        background:<?=$PPC[2]?>;
    }
    .pixelpile-logo-block-c4 {
        background:<?=$PPC[1]?>;
    }
    .pixelpile-logo-block-c5 {
        background:<?=$PPC[0]?>;
    }
    /*
    Dark color variations
    */
    .pixelpile-dark.pixelpile-color-1 {
        background:<?=$PPC[0]?>;
        color:<?=$PPC[3]?>;
    }
    .pixelpile-dark.pixelpile-color-2 {
        background:<?=$PPC[1]?>;
        color:<?=$PPC[4]?>;
    }
    .pixelpile-dark.pixelpile-color-3 {
        background:<?=$PPC[2]?>;
        color:<?=$PPC[5]?>;
    }
    .pixelpile-dark .pixelpile-logotype {
        color:<?=$PPC[3]?>;
    }
    .pixelpile-dark .pixelpile-logotype-pile {
        color:<?=$PPC[2]?>;
    }
    .pixelpile-dark .pixelpile-logo-block-c0 {
        background:<?=$PPC[0]?>;
    }
    .pixelpile-dark .pixelpile-logo-block-c1 {
        background:<?=$PPC[1]?>;
    }
    .pixelpile-dark .pixelpile-logo-block-c2 {
        background:<?=$PPC[2]?>;
    }
    .pixelpile-dark .pixelpile-logo-block-c3 {
        background:<?=$PPC[3]?>;
    }
    .pixelpile-dark .pixelpile-logo-block-c4 {
        background:<?=$PPC[4]?>;
    }
    .pixelpile-dark .pixelpile-logo-block-c5 {
        background:<?=$PPC[5]?>;
    }
    /*
    logotype color variations for colors 2 and 3
    */
    .pixelpile-color-2 .pixelpile-logotype,
    .pixelpile-color-3 .pixelpile-logotype {
        color:<?=$PPC[0]?>
    }
    .pixelpile-color-2 .pixelpile-logotype-pile,
    .pixelpile-color-3 .pixelpile-logotype-pile {
        color:<?=$PPC[1]?>
    }
    .pixelpile-dark.pixelpile-color-2 .pixelpile-logotype,
    .pixelpile-dark.pixelpile-color-3 .pixelpile-logotype {
        color:<?=$PPC[5]?>
    }
    .pixelpile-dark.pixelpile-color-2 .pixelpile-logotype-pile,
    .pixelpile-dark.pixelpile-color-3 .pixelpile-logotype-pile {
        color:<?=$PPC[4]?>
    }
</style>

<h1>Pixel{pile} logo and branding</h1>
<p>Developed as a side project, for my aspirations of founding my own digital design shop.</p>
<h2>Logo and primary color schemes</h2>
<div class="pixelpile-color-1 pixelpile-dark" style="padding:20px;">
    <div class="pixelpile-lockup">
        <div class="pixelpile-logo"><img src="pixelpile-logo-dark.png" alt="" /></div>
        <div class="pixelpile-logotype">
            <div class="pixelpile-logotype-primary">Pixel{<span class="pixelpile-logotype-pile">pile</span>}</div>
            <div class="pixelpile-logotype-secondary">design &amp; development</div>
        </div>
    </div>
</div>
<div class="pixelpile-background-accent"></div>
<div class="pixelpile-color-1" style="padding:20px;">
    <div class="pixelpile-lockup" style="font-size:0.5em;">
        <div class="pixelpile-logo"><img src="pixelpile-logo.png" alt="" /></div>
        <div class="pixelpile-logotype">
            <div class="pixelpile-logotype-primary">Pixel{<span class="pixelpile-logotype-pile">pile</span>}</div>
            <div class="pixelpile-logotype-secondary">design &amp; development</div>
        </div>
    </div>
</div>

<h2>Horizontal logo and alternate color schemes</h2>
<div class="pixelpile-color-2" style="padding:20px 0;width:45%;display:inline-block;">
    <div class="pixelpile-lockup pixelpile-lockup-horizontal" style="font-size:0.25em;">
        <div class="pixelpile-logo"><img src="pixelpile-logo.png" alt="" /></div>
        <div class="pixelpile-logotype">
            <div class="pixelpile-logotype-primary">Pixel{<span class="pixelpile-logotype-pile">pile</span>}</div>
            <div class="pixelpile-logotype-secondary">design &amp; development</div>
        </div>
    </div>
</div>
<div class="pixelpile-color-2 pixelpile-dark" style="padding:20px 0;width:45%;display:inline-block;">
    <div class="pixelpile-lockup pixelpile-lockup-horizontal" style="font-size:0.25em;">
        <div class="pixelpile-logo"><img src="pixelpile-logo-dark.png" alt="" /></div>
        <div class="pixelpile-logotype">
            <div class="pixelpile-logotype-primary">Pixel{<span class="pixelpile-logotype-pile">pile</span>}</div>
            <div class="pixelpile-logotype-secondary">design &amp; development</div>
        </div>
    </div>
</div>
<div class="pixelpile-color-3" style="padding:20px 0;width:45%;display:inline-block;">
    <div class="pixelpile-lockup pixelpile-lockup-horizontal" style="font-size:0.25em;">
        <div class="pixelpile-logo"><img src="pixelpile-logo.png" alt="" /></div>
        <div class="pixelpile-logotype">
            <div class="pixelpile-logotype-primary">Pixel{<span class="pixelpile-logotype-pile">pile</span>}</div>
            <div class="pixelpile-logotype-secondary">design &amp; development</div>
        </div>
    </div>
</div>
<div class="pixelpile-color-3 pixelpile-dark" style="padding:20px 0;width:45%;display:inline-block;">
    <div class="pixelpile-lockup pixelpile-lockup-horizontal" style="font-size:0.25em;">
        <div class="pixelpile-logo"><img src="pixelpile-logo-dark.png" alt="" /></div>
        <div class="pixelpile-logotype">
            <div class="pixelpile-logotype-primary">Pixel{<span class="pixelpile-logotype-pile">pile</span>}</div>
            <div class="pixelpile-logotype-secondary">design &amp; development</div>
        </div>
    </div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="sandpile-model.js"></script>
<script>
$(function(){
    //replace images with markup
    $('.pixelpile-background-accent').each(function(){
        var $this = $(this).addClass('pixelpile-logo-block-1-1');
        var height = 1;
        var width = Math.floor($this.width()/36);
        for (i = 1;i <= width;i++) {
            $this.append('<div class="pixelpile-logo-block pixelpile-logo-block-'+(Math.ceil(i/4)%4+1)+'-'+(i%4+1)+'" />');
        }
    });
    $('.pixelpile-logo').html('<div class="pixelpile-logo-block pixelpile-logo-block-1-1 pixelpile-logo-block-c2"></div>'
                             +'<div class="pixelpile-logo-block pixelpile-logo-block-2-1 pixelpile-logo-block-c3"></div>'
                             +'<div class="pixelpile-logo-block pixelpile-logo-block-3-1 pixelpile-logo-block-c4"></div>'
                             +'<div class="pixelpile-logo-block pixelpile-logo-block-4-1 pixelpile-logo-block-c3"></div>'
                             +'<div class="pixelpile-logo-block pixelpile-logo-block-1-2 pixelpile-logo-block-c3"></div>'
                             +'<div class="pixelpile-logo-block pixelpile-logo-block-2-2 pixelpile-logo-block-c4"></div>'
                             +'<div class="pixelpile-logo-block pixelpile-logo-block-3-2 pixelpile-logo-block-c5"></div>'
                             +'<div class="pixelpile-logo-block pixelpile-logo-block-4-2 pixelpile-logo-block-c4"></div>'
                             +'<div class="pixelpile-logo-block pixelpile-logo-block-1-3 pixelpile-logo-block-c2"></div>'
                             +'<div class="pixelpile-logo-block pixelpile-logo-block-2-3 pixelpile-logo-block-c3"></div>'
                             +'<div class="pixelpile-logo-block pixelpile-logo-block-3-3 pixelpile-logo-block-c4"></div>'
                             +'<div class="pixelpile-logo-block pixelpile-logo-block-4-3 pixelpile-logo-block-c3"></div>'
                             +'<div class="pixelpile-logo-block pixelpile-logo-block-1-4 pixelpile-logo-block-c1"></div>'
                             +'<div class="pixelpile-logo-block pixelpile-logo-block-2-4 pixelpile-logo-block-c2"></div>'
                             +'<div class="pixelpile-logo-block pixelpile-logo-block-3-4 pixelpile-logo-block-c3"></div>'
                             +'<div class="pixelpile-logo-block pixelpile-logo-block-4-4 pixelpile-logo-block-c2"></div>');
    //set up model and display
    var model = new sandpileModel();
    model.options.height = 12;
    model.options.width = 12;
    model.options.updateRate = 250;
    model.options.toppleHeight = 5;
    model.options.distributionMethod = "random";
    model.reset();

    model.setPoint(4,4,2);
    model.setPoint(5,4,3);
    model.setPoint(6,4,4);
    model.setPoint(7,4,3);

    model.setPoint(4,5,3);
    model.setPoint(5,5,4);
    model.setPoint(6,5,5);
    model.setPoint(7,5,4);

    model.setPoint(4,6,2);
    model.setPoint(5,6,3);
    model.setPoint(6,6,4);
    model.setPoint(7,6,3);

    model.setPoint(4,7,1);
    model.setPoint(5,7,2);
    model.setPoint(6,7,3);
    model.setPoint(7,7,2);

    var ppSetColor = function(x,y,color) {
        color = (color>5)?5:color;
        $object = $('.pixelpile-logo-block-'+x+'-'+y);
        $object.removeClass('pixelpile-logo-block-c0').removeClass('pixelpile-logo-block-c1').removeClass('pixelpile-logo-block-c2').removeClass('pixelpile-logo-block-c3').removeClass('pixelpile-logo-block-c4').removeClass('pixelpile-logo-block-c5').addClass('pixelpile-logo-block-c'+color);
    }
    setTimeout(function(){
        model.play();
        setInterval(model.dropGrain,150);
    },3000);
    setInterval(function(){
        ppSetColor(1,1,model.getPoint(4,4));
        ppSetColor(2,1,model.getPoint(5,4));
        ppSetColor(3,1,model.getPoint(6,4));
        ppSetColor(4,1,model.getPoint(7,4));

        ppSetColor(1,2,model.getPoint(4,5));
        ppSetColor(2,2,model.getPoint(5,5));
        ppSetColor(3,2,model.getPoint(6,5));
        ppSetColor(4,2,model.getPoint(7,5));

        ppSetColor(1,3,model.getPoint(4,6));
        ppSetColor(2,3,model.getPoint(5,6));
        ppSetColor(3,3,model.getPoint(6,6));
        ppSetColor(4,3,model.getPoint(7,6));

        ppSetColor(1,4,model.getPoint(4,7));
        ppSetColor(2,4,model.getPoint(5,7));
        ppSetColor(3,4,model.getPoint(6,7));
        ppSetColor(4,4,model.getPoint(7,7));
    },50);

    var hoverTimer;
    $('.pixelpile-logo,.pixelpile-logo-lockup').hover(function(){
        hoverTimer = setInterval(model.dropGrain,25);
    },function(){
        clearInterval(hoverTimer);
    });
})
</script>

<?php echo byjoby\Templates\TwigManager::render('partials/branding-non-free.twig'); ?>
