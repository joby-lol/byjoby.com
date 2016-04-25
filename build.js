'use strict';

var fs = require('fs');
var merge = require('merge');
var twig = require('twig');
var yaml = require('js-yaml');
var yamlFront = require('yaml-front-matter');

var options = yaml.safeLoad(fs.readFileSync('options.yaml'));

var stats = {
    copied: 0,
    built: 0,
    notModified: 0,
    templated: 0
};
var templateQueue = [];
var metaCache = [];

/**
 * recursively build a given source directory into a destination directory
 * @param  {string} src  
 * @param  {string} dest 
 * @return {void}
 */
function buildDir(src, dest) {
    var subDirs = [];
    var files = [];
    var children = fs.readdirSync(src);
    if (!children) return;
    //make sure dest exists
    if (!fs.existsSync(dest)) {
        fs.mkdirSync(dest);
    }
    //locate children, processing directories first
    for (var i in children) {
        var srcFile = src + '/' + children[i];
        var srcStat = fs.statSync(srcFile);
        var destFile = dest + '/' + children[i];
        if (srcStat.isFile()) {
            files.push({
                src: srcFile,
                dest: destFile
            });
        }else if (srcStat.isDirectory()) {
            buildDir(srcFile,destFile);
        }
    }
    //process found files
    for (var i in files) {
        buildFile(files[i].src, files[i].dest);
    }
}

/**
 * Build a given file from a source to a destination. Also loads and caches
 * metadata, applies handlers, and destination name transformations
 * @param  {string} src  
 * @param  {string} dest 
 * @return {boolean} whether the file was successfully built
 */
function buildFile(src, dest) {
    var srcStat = fs.statSync(src);
    var destStat = false;
    for (var i in options.handlers) {
        var handler = options.handlers[i];
        var pattern = new RegExp(handler.pattern, 'i');
        if (pattern.test(src)) {
            // run destination transform
            if (handler.transform) {
                var search = new RegExp(handler.transform.search);
                var replace = handler.transform.replace;
                dest = dest.replace(search, replace);
            }
            // extract front matter
            var meta = yamlFront.loadFront(fs.readFileSync(src));
            var content = meta.__content;
            // merge meta with default meta and add stat stuff
            delete(meta.__content);
            meta = merge.recursive(true,options.meta,meta);
            meta.filemtime = srcStat.mtime;
            meta.filebtime = new Date();
            meta.url = options.baseUrl + dest.substring(options.buildDir.length);
            meta.url = meta.url.replace(new RegExp(options.indexPattern, 'i'), '');
            // cache metadata
            metaCache.push({
                src: src,
                dest: dest,
                meta: meta
            });
            // check if dest already exists and is newer
            // also verifies that template is not newer than existing destination file
            if (fs.existsSync(dest)) {
                destStat = fs.statSync(dest);
                var templateStat = fs.statSync('templates/'+meta.template+'.twig');
                if (destStat.mtime > srcStat.mtime && destStat.mtime > templateStat.mtime) {
                    meta.filebtime = destStat.mtime;
                    stats.notModified++;
                    return true;
                }
            }
            // if handler is 'copyhandler' then just copy the result over and be done
            if (handler.handler == 'copyhandler') {
                console.log('copy: ' + src + ' => ' +dest);
                fs.createReadStream(src).pipe(fs.createWriteStream(dest));
                stats.copied++;
                return true;
            }
            // run handler
            console.log(handler.handler + ': ' + src + ' => ' +dest);
            var handler = require('./scripts/'+handler.handler+'.js');
            handler.build(src, dest, content, meta, options);
            stats.built++;
            if (meta.template != 'none') {
                templateQueue.push({
                    dest: dest,
                    meta: meta
                });
            }
            return true;
        }
    }
    return false;
}

/**
 * Apply templates from templateQueue
 * Note that twig is run twice, to allow twig content inside other twig
 * content. This wouldn't be secure in a shared user input type thing,
 * but this isn't that sort of tool.
 * @param  {array} templateQueue
 * @param  {array} options       
 * @return {void}             
 */
function applyTemplates(templateQueue, options) {
    for (var i in templateQueue) {
        var page = templateQueue[i];
        var meta = merge(true, page.meta);
        meta.template_body = fs.readFileSync(page.dest).toString();
        var template = twig.twig({
            path: 'templates/' + page.meta.template + '.twig',
            async: false
        });
        var content = template.render(meta);
        var template = twig.twig({
            path: false,
            data: content,
            async: false
        });
        fs.writeFileSync(page.dest, template.render(meta));
        stats.templated++;
    }
}

buildDir(options.srcDir, options.buildDir);
applyTemplates(templateQueue, options);

console.log('Files copied: '+stats.copied);
console.log('Files built: '+stats.built);
console.log('Files templated: '+stats.templated);
console.log('Files not modified: '+stats.notModified);
