---
title: "Bringing the web back to basics"
---

# Bringing the web back to basics

I've got a new job doing mostly back-end PHP work. I'm also fixing up some front ends. After almost a year away though, I have some fresh perspective on the *precarious and teetering pile of shit* that we call web design here in the beginning of 2016.

Not to go all get-off-my-lawn on you, but does anybody remember how the internet was back in the old days? There was a time when pages had URLs, and links carried you off to a different page at a different URL. Before single-page apps, and Ajax-ing the goddamn transitions between pages. We had browsers, and pages, and HTML, and links, and we *fucking loved it.*

You could build a site with HTML, and maybe throw SSI or a few PHP includes in the mix if you were *really fancy.* Then you could leave that site on your free host for 20 years, and it would keep working! You weren't depending on a half-million lines of *mostly* secure, patch-hungry CMS code to serve your five-page site of cat pictures and misspelled homages to 1970s Ukranian cinema.


## Minification is pointless, even harmful

I'm old enough to rember a time when you could see a cool thing on a site, right click, view source, and just see how it worked. That was before everything was <strike>minified</strike> *broken and obfuscated*.

Pretty much every browser supports Gzip. So let's just all take the minification step out of our workflows. And while we're at it, why are we all using CSS preprocessors? It makes your whole workflow brittle and quickly-dated (what do you do in a couple years when your favorite preprocessor stops updating?). It makes it hard to debug, and when you run it through a minifier afterwards it makes it very hard for anyone else to see what you did there.

I feel like web designers need to stop jealously guarding our little piles of excessive complexity, and go back to being proud of them. Don't minify, leave your comments in, let anyone who is curious see what you did. Anybody who is good will figure it out anyway, so why not lower the barrier for novices as well?

In the age of Gzip, minification isn't really necessary any more. Once it's Gzipped, [the difference between minified and full-source Bootstrap](https://css-tricks.com/the-difference-between-minification-and-gzipping/), for example, is a measely 2Kb. On a more sane amount of CSS it will be utterly insignificant. In my experience Gzip also works *miracles* on Javascript files, so I just turn on Gzip and don't worry about minifying any more.


## Dependencies are also a problem

There was a time when we knew that depending on mountains of third-party libraries was a bad thing. We knew that in three months one of them was going to have an urgent security patch that broke its compatibility with a different one. Then what do you do? Now your whole site is broken until you grok two whole giant libraries -- each likely written by teams of people.

Your other options include: Not patching it and throwing security to the wind, or maybe getting fired. So keep your dependencies under control. Just because they wrote about a library in Smashing Magazine this week doesn't mean you have to immediately shoehorn it into your site.

I know that fooling around with complex stuff is like catnip for people like us, but try to contain yourself. You know what's like catnip for other people? *Reading things on websites that aren't broken.*

<figure>
	<img src="google.png">
	<figcaption>
		You would think the geniuses at Google could make one form with an amount of Javascript that would cost under $100 to print at FedEx. You would be wrong
	</figcaption>
</figure>

### Go home Javascript, you're drunk

Today I took a look at the source of the Google home page. You know, the site that renders a logo, 3 form elements, and maybe a dozen links.

It has **170Kb** of inlined, minified Javascript built right into the page. Then there are furthermore over 300Kb of linked scripts. It's ridiculous. What does it even do? Other than use machine learning to deduce my gender, sexual orientation, mother's maiden name, and how long it's been since I last ate a pita -- obviously.

Actually, Google's site isn't so bad on this front, by comparison. A lot of sites have much more Javascript bloat, and do much less with it.

Pinterest manages a whole 1.1 *megabytes* of Javascript, just to load up a grid of lightboxes.

Tumblr's home page uses 1.1 megabytes as well. They use it to display a sign-in form, a few marketing messages, and also to utterly break the concept of a scroll bar.


### Kitchen-sink libraries have also gotta go

Remember how Tumblr needs 1.1 megabytes of Javascript to display a sign-in form and 200 words of marketing copy? While doing that they use not just one, but *three* kitchen-sink Javascript libraries that each attempt to reinvent most of the wheels.

We really need to stop writing libraries that attempt to be whole programming languages of their own, but written on top of Javascript. *I'm looking at you, jQuery.* Here in 2016 Javascript engines alone are really quite good and consistent. Javascript has grown up into a pretty legit language, and we should be happy to use it.

Chaining is cool I guess, but passing object references around is how Javascript works. If you don't like that, use a different language.


## Build for the future and the past

Some people seem to think that cramming every library, and every shim, and every cutting-edge trick into a site is "designing for the future." It's not, it's just designing *around* the limitations of the now. Progressive enhancement with upcoming standards is fine.

In fact, if you use the standards of the future as enhancements, not key features of your design, something wonderful happens. As time passes your site works *better*. It's like you get to flip entropy on its head, and watch your site improve its experience as newer standards are implemented. It's a sensational feeling -- I suggest you try it.

If you had loaded it up with shims to make future standards you would instead probably have a site that takes [literally minutes to render](https://medium.com/hacker-daily/this-is-what-today-s-popular-websites-look-like-on-the-1st-generation-iphone-15ce122703a1#.7ar07ih9r) on [a smartphone some people still use](http://www.marketwatch.com/story/some-apple-fans-stick-with-original-2007-iphone-2013-09-10).


## Let's build a better web, together

The web was built on an open ethos. Lately it's been taken over by some nasty old-guard software engineering memes and business-school types. I think it's time we took it back.

[Open your sources](https://github.com/jobyone/byjoby.com), trim your dependencies, embrace the page-based nature of the web, stop building apps when you should be building sites.

<aside>

<h1>Further reading</h1>

<ul>
	<li><a href="http://idlewords.com/talks/website_obesity.htm">The Website Obesity Crisis</a></li>
	<li><a href="http://goldilocksapproach.com/article/">The Goldilocks Approach to Responsive Design</a></li>
	<li><a href="https://medium.com/hacker-daily/this-is-what-today-s-popular-websites-look-like-on-the-1st-generation-iphone-15ce122703a1#.7ar07ih9r">This is what today’s popular websites look like on the 1st generation iPhone</a></li>
</ul>

</aside>