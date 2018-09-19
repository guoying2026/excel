
$(document).ready(function(){
  //$('div.content div.panel').css('height', $(window).outerHeight() - $('div.header').height() - 16 + 'px');
  $("div.header div.navigation span.tag-switch-navigation a.tag-switch").on('click', function() {
    if($(this).hasClass('on') === false && $(this).attr('new-tab') != 'true')
      setUrlParam('mode', $(this).attr('data-switch'));
  });
  $('iframe#frame1').attr('width', $(window).outerWidth() - $('div.content div.panel#main-panel').outerWidth() + 'px');
})


$(window).resize(function(){
  //$('div.content div.panel').css('height', $(window).outerHeight() - $('div.header').height() - 16 + 'px');
  //$('iframe#frame1').attr('width', $(window).outerWidth() - $('div.content div.panel#main-panel').outerWidth() + 'px');
  //console.log($(window).outerWidth());
})


function getUrlParam(name)
{
  var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
  var r = window.location.search.substr(1).match(reg);
  if(r != null) return unescape(r[2]); return null;
}

function setUrlParam(name, value)
{
  // value = false, delete
  // value = null, reserve no-value key
  // value = '', reserve no-value key
  var search_string = window.location.search;
  var flag_own_property_change_ = false;
  var search_array_ = new Array();
  search_string = search_string.substr(1);
  if(search_string != '') {
    var search_array = search_string.split('&');
    for(var i_ = 0; i_ < search_array.length; i_++) {
      var array_ = search_array[i_].split('=');
      if(array_[0] != name) {
        search_array_.push({name: array_[0], value: array_[1]});
      } else {
        search_array_.push({name: array_[0], value: value});
        flag_own_property_change_ = true;
      }
    }
    for(var i_ = 0; i_ < search_array_.length; i_++) {
      console.log(search_array_[i_]);
    }
  }
  if(flag_own_property_change_ == false) {
    search_array_.push({name: name, value: value});
  }
  var search_string = "?";
  for(var i_ = 0, n_ = 0; i_ < search_array_.length; i_++) {
    switch(search_array_[i_].value) {
      case false:
        break;
      case "false":
        break;
      case null:
        if(n_ != 0)
          search_string = search_string + '&';
        search_string = search_string + search_array_[i_].name + '=' + search_array_[i_].value;
        n_++;
        break;
      case '':
        if(n_ != 0)
          search_string = search_string + '&';
        search_string = search_string + search_array_[i_].name + '=' + search_array_[i_].value;
        n_++
        break;
      default:
        if(n_ != 0)
          search_string = search_string + '&';
        search_string = search_string + search_array_[i_].name + '=' + search_array_[i_].value;
        n_++
        break;
    }
  }
  if(search_string != "?") {
    window.location.href = window.location.origin + window.location.pathname + search_string;
  } else {
    window.location.href = window.location.origin + window.location.pathname;
  }
}


function setUrlParamOld(name, value)
{
  var search_string = window.location.search;
  if(search_string != '') { // search string exists
    var search_string = search_string.substr(1);
    var search_array = search_string.split('&');
    var search_array_ = new Array();
    for(var i_ = 0; i_ < search_array.length; i_++) {
      var array_ = search_array[i_].split('=');
      search_array_[array_[0]] = search_array_[array_[1]];
    }
    search_array = search_array_;
    if(search_array.hasOwnProperty(name)) { // name exists in search string, index.html?name=previous_value -> index.html?name=value
      var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
      search_string = search_string.replace(reg, function(a,b,c,d,e,f){
        if(value != '') {
          return a.replace(c, value);
        } else {
          return '';
        }
      });
    } else { // name does not exist in search string, index.html?other_name=other_value -> index.html?other_name=other_value&name=value
      search_string = search_string + "&" + name + "=" + value;
    }
  } else { // search string does not exist, index.html -> index.html?name=value
    search_string = name + "=" + value;
  }
  search_string = '?' + search_string;
  window.location.href = window.location.origin + window.location.pathname + search_string;
}


