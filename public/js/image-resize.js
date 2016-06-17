var resized = [];
function resize(id) {
  if (resized.indexOf(id) == -1) {
    var re = /(.*)(src=.*)(thumb_)(.*)/gmi;
    var image = document.getElementById(id).outerHTML;
    var image = image.replace(re, '$1$2$4');
    document.getElementById(id).outerHTML = image;
    resized.push(id);
  }
  else {
    var re = /(.*)(src=.*)(\/res\/)(.*)/gmi;
    var image = document.getElementById(id).outerHTML;
    var image = image.replace(re, '$1$2$3thumb_$4');
    document.getElementById(id).outerHTML = image;
    resized.splice(resized.indexOf(id), 1);
  }
}
