---
title: JS Sandpile Model
template: blog
---

<h1>JS Sandpile Model</h1>
<p>See <a href="http://en.wikipedia.org/wiki/Abelian_sandpile_model">http://en.wikipedia.org/wiki/Abelian_sandpile_model</a>.</p>
<canvas id="sandpile"  height="640" width="640" style="max-width:100%;"><img src="static.png" alt="sandpile static display" /></canvas>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="sandpile-model.js"></script>
<script src="sandpile-display.js"></script>

<script>
    $(function () {
        //set up model and display
        var model = new sandpileModel();
        var display = new sandpileDisplay(document.getElementById('sandpile'), model);
        display.options.left = 0;
        display.options.top = 0;
        display.options.width = model.options.width;
        display.options.height = model.options.height;
        model.options.heightComparison = "default";
        model.options.distributionMethod = "random";
        model.options.neighborsMethod = "square";
        model.options.toppleHeight = 4;
        model.reset();
        model.play();
        //drop a bunch of grains to get it started
        for (i = 0; i < 2500; i++) {
            model.dropGrain();
        }
        //drop more grains
        setInterval(function () {
            model.dropGrain();
        }, 100);
    })
</script>
