---
page_title: Canvas fingerprinting demo
---

# Canvas fingerprinting demo

I built this thing as a quick test to see how easy it is to fingerprint a browser by rendering a bunch of text onto a `canvas` tag and hashing the results. My methods were far from rigorous, but it does do the thing and it does work.

It just renders a variety of characters in a variety of colors, in a variety of fonts. That way you're hashing from something that samples a wide variety of kerning/hinting quirks, as well as a sampling of what fonts the user has installed. It's fairly legit, for how easy it was to make.

If I were an advertiser and this were my job you'd be in serious trouble. I would know *everything* about your computer. Browsers are leaky as hell.

Your fingerprint, based on the image below, is: <span id="canvas-fingerprint-text"></span>

<div id="canvas-fingerprint-visible"></div>

<script src="sha.js"></script>
<script src="canvasFP.js"></script>
