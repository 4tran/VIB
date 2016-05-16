# JSIB

## General information
~~JavaScript imageboard, or JSIB for short, is an attempt to create an imageboard software that is based on javascript rather than PHP, python, perl etc.~~

~~I'd like to achieve this using as little third-party code code as possible. By that, I mean that this will be using, as much as I can manage it, vanilla javascript.~~

~~I don't intend to use any libraries like jQuery, or any non-standard server software such as node.js.~~

~~If it happens that vanilla javascript isn't suffice for a task, or is ludicrously complex, I may decide to start using a library.~~

As it turns out, I may have been a little bit ambitious starting this without doing any real research. Well, I did a little research, and it seems a near impossibility to create a secure site in javascript that interacts with any form of file or database on the server. So, I'm switching to PHP for the backend, not because javascript couldn't be the backend (I mean, take a look at stuff like node.js,) but rather that PHP is just so much simpler to use as a server language. That said, my earlier writing is also somewhat true. I do want to use vanilla javascript where applicable, and I want to use as few pieces of third-party code as possible, because the goal of this is still to create something simple that helps me learn new things.

## License 
Please see the [LICENSE.md](https://github.com/4tran/JSIB/blob/master/LICENSE.md) included in the root of this repository. For a summary, please see [the following site](http://choosealicense.com/licenses/agpl-3.0/).

## Contributing
Before contributing, please read through the general information section. The general idea of this repo is to use as little third-party code as possible to complete any given task.

The following types of code are allowed in this repo:
  * PHP (I'll be using 7.0, but I probably won't be using many new fancy features, so backwards compatibility is likely (although it should be noted that I haven't done much research on the differences between 7.0 and earlier versions))
  * Vanilla JavaScript (ES5 for now, ES6 maybe in the future)
  * HTML (5)
  * CSS (no SASS/SCSS, or anything of that sort)
  * SQL (MySQL and MariaDB should both work, but I'll be testing in MariaDB)

Other things that I haven't thought to put on this list might be okay. If you want to contribute, but don't know if what you want to do follows the guidelines, create an issue with your proposal and I'll try to reply as soon as possible.
