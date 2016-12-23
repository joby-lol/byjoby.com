---
page_title: JS Sandpile Model
template: blog
---

#JS Sandpile Model

These models work by dropping "grains" on random spots on the grid. They stack up, and once a spot has 4 grains it "collapses" and distributes its 4 grains to its cardinal neighbors.

One very interesting property of this particular model is that it will always wind up the same given a certain starting state, regardless of what order you simulate the individual spots in. As long as you hit all of them until all of them have been hit without anything happening, the result will be the same no matter how you go about deciding how to order your simulation steps.

See http://en.wikipedia.org/wiki/Abelian_sandpile_model

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
