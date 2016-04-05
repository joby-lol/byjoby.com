'use strict';

var fs = require('fs');
var marked = require('marked');

var exports = module.exports = {};

marked.setOptions({
    renderer: new marked.Renderer(),
    gfm: true,
    tables: true,
    breaks: true,
    pedantic: false,
    sanitize: false,
    smartLists: true,
    smartypants: false
});

exports.build = function(src, dest, content, meta, options) {
    fs.writeFileSync(dest, marked(content));
};
