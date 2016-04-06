---
title: Canvas fingerprinting demo
template: blog
---

# Canvas fingerprinting demo

<style>
    #canvas-fingerprint-visible canvas {
        width:100%;
    }
</style>

<div id="canvas-fingerprint-results">
    <p>
        Your fingerprint, based on the image below, is: <span id="canvas-fingerprint-text"></span>
    </p>
    <div id="canvas-fingerprint-visible"></div>
</div>

<script src="sha.js"></script>
<script src="canvasFP.js"></script>
