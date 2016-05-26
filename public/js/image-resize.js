var big = 0;
function resize(id) {
  if (big == 0) {
    document.getElementById(id).style.height = "initial";
    big = 1;
  }
  else {
    document.getElementById(id).style.height = "150px";
    big = 0;
  }
}
