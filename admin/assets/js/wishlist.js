var tomikupButton = (function(){
  var tomikup_domain = 'https://www.tomikup.cz';
  //var tomikup_domain = 'https://tomikup-test.azurewebsites.net';
  var tomikup_shown = false;

  return {
    shown: tomikup_shown,
    removeElement: function(node) {
      node.parentNode.removeChild(node);
    },
    getElementsByClass: function(className, parent) {
      parent || (parent = document);
      var descendants = parent.getElementsByTagName('*'), i = -1, e, result = [];
      while(e = descendants[++i]) {
        ((' ' + (e['class'] || e.className) + ' ').indexOf(' ' + className + ' ') > -1) && result.push(e);
      }
      return result;
    },
    addEvent: function(obj, type, fn) {
      if(obj.addEventListener) {
        obj.addEventListener(type, fn, false);
        this.eventCache.add(obj, type, fn);
      } else if (obj.attachEvent) {
        obj["e" + type + fn] = fn;
        obj[type + fn] = function() {
          obj["e" + type + fn](window.event);
        }
        obj.attachEvent("on" + type, obj[type + fn]);
        this.eventCache.add(obj, type, fn);
      } else {
        obj["on" + type] = obj["e" + type + fn];
      }
    },
    eventCache: (function() {
      var listEvents = [];
      return {
        listEvents: listEvents,
        add: function (node, sEventname, fHandler) {
          listEvents.push(arguments);
        },
        flush: function() {
          var i, item;
          for(i = listEvents.length - 1; i >= 0; i--) {
            item = listEvents[i];
            if(items[0].removeEventListener) {
              item[0].removeEventListener(item[1], item[2], item[3]);
            }
            if(item[1].substring(0, 2) != "on") {
              item[1] = "on" + item[1];
            }
            if(item[0].detachEvent) {
              item[0].detachEvent(item[1], item[2]);
            }
            item[0][item[1]] = null;
          }
        }
      }
    }()),
    create: function(query, rndId) {
      var link = tomikup_domain + "/templates/buttoncore.html" + query;
      var iframe = document.createElement('iframe');
      iframe.frameBorder = 0;
      iframe.width = 0;
      iframe.height = 0;
      iframe.id = "tomikup-btn-frm-" + rndId;
      iframe.setAttribute("src", link);
      return iframe;
    },
    injectDialog: function(query) {
      if (this.shown) return;
      var link = tomikup_domain + "/api/addtowishlist" + query;
      var iframe = document.createElement('iframe');
      iframe.frameBorder = 0;
      iframe.width = "100%";
      iframe.height = "100%";
      iframe.id = "randomid";
      iframe.setAttribute("src", link);
      var div = document.createElement("div");
      div.appendChild(iframe);
      div.className = "tomikup-dialog";
      document.getElementsByTagName('body')[0].appendChild(div);
      this.shown = true;
      div.style.overflow ="auto";
      div.style.webkitOverflowScrolling = "touch";
    },
    createTooltip: function(button) {
      var tooltip = document.createElement("div"), tooltipText = document.createElement("span"), tooltipArrow = document.createElement("div");
      var languageCodes = { cs: ['cs', 'cs-cz'], sk: ['sk', 'sk-sk'] };
      var texts = {
        cs: ['Wishlist a hlídač dostupnosti i slev'],
        sk: ['Wishlist a strážca dostupnosti aj zliav'],
        en: ['Wishlist with availability & price watchdog']
      };

      tooltip.classList.add("tomikup-tooltip");
      tooltipText.classList.add("tomikup-tooltipText");
      tooltipArrow.classList.add("tomikup-tooltipArrow");

      var text, lang = navigator.language.toLowerCase();
      if(languageCodes.cs.indexOf(lang) !== -1) text = texts.cs;
      else if(languageCodes.sk.indexOf(lang) !== -1) text = texts.sk;
      else text = texts.en;
      tooltipText.innerText = text;

      button.addEventListener("mouseenter", function(e) {
        tooltip.classList.remove("tt-left", "tt-bottom", "tt-right");
        var className = "tt-left";
        if(!button.classList.contains("tomikup-fixed")) {
          var boundingRect = button.getBoundingClientRect();
          if(window.innerHeight - boundingRect.bottom > 50) className =  "tt-bottom";
          else className = "tt-top";
        }
        tooltip.classList.add(className);
      });

      tooltip.appendChild(tooltipText);
      tooltip.appendChild(tooltipArrow);
      button.appendChild(tooltip);
    }
  }
}());

function getRandomInt(min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

var cssId = 'tomikup_cssclasses';
if (!document.getElementById(cssId)) {
  var style = document.createElement("style");
  document.head.appendChild(style);
  style.sheet.insertRule(".tomikup-dialog {background:rgba(44,108,128,.76);position:fixed;top:0;left:0;margin:0;width:100%;height:100%;z-index:2147483647}");
  style.sheet.insertRule(".tomikup-dialog > iframe {margin:0;float:left}");
  style.sheet.insertRule(".tomikup-button {position:relative}");
  style.sheet.insertRule(".tomikup-button > iframe {margin:0!important}");
  style.sheet.insertRule(".tomikup-fixed {position:fixed!important;right:0px;top:50%;transform:translateY(-50%);z-index:1234}");
  style.sheet.insertRule(".tomikup-fixed > iframe {margin:0}");
  style.sheet.insertRule(".tomikup-tooltip {position:absolute;background:#000;border-radius:4px;text-align:center;padding:4px 8px;width:146px;z-index:1235;opacity:.8;display:none;min-height:32px;box-sizing:border-box}");
  style.sheet.insertRule(".tomikup-tooltipText {color:#FFF;font-size:12px}");
  style.sheet.insertRule(".tomikup-tooltipArrow {position:absolute;background:#000;width:16px;height:16px;border-radius:4px;transform:rotate(45deg);z-index:-1}");
  style.sheet.insertRule(".tt-bottom.tomikup-tooltip {left:50%;top:100%;transform:translate(-50%,10px)}");
  style.sheet.insertRule(".tt-bottom .tomikup-tooltipArrow {top:0;left:50%;margin-top:-6px;margin-left:-8px}");
  style.sheet.insertRule(".tt-top.tomikup-tooltip {left:50%;bottom:100%;transform:translate(-50%,-10px)}");
  style.sheet.insertRule(".tt-top .tomikup-tooltipArrow {bottom:0;left:50%;margin-bottom:-6px;margin-left:-8px}");
  style.sheet.insertRule(".tt-left.tomikup-tooltip {right:100%;top:50%;transform:translate(-10px,-50%)}");
  style.sheet.insertRule(".tt-left .tomikup-tooltipArrow {top:50%;right:0;margin-right:-6px;margin-top:-8px}");
  style.sheet.insertRule(".tomikup-button:hover .tomikup-tooltip {display:block}");
}

tomikupButton.addEvent(window, 'load', function() {
  var buttons = tomikupButton.getElementsByClass('tomikup-button');
  var images = '';
  for(var i = 0; i < document.images.length; i++) {
    if(document.images[i].naturalWidth > 120 && document.images[i].src.indexOf('recapt') === -1) {
      images += document.images[i].src + ';';
    }
    if(i > 5) break;
  }
  tomikupButton.addEvent(window, "message", function(d) {
    if(d.data === "tomikup-close-iframe") {
      var element = tomikupButton.getElementsByClass("tomikup-dialog");
      tomikupButton.removeElement(element[0]);
      tomikupButton.shown = false;
    }
    for(var b = 0; b < buttons.length; b++) {
      var button = buttons[b];
      try {
        var obj = JSON.parse(d.data);
        var btnRndId = button.getAttribute("data-tomikup-rnd-id");
        if(obj.id === "tomikup-show-iframe-" + btnRndId) {
          var title = button.getAttribute('data-title') != null ? button.getAttribute('data-title') : document.title;
          var url = button.getAttribute('data-url') != null ? button.getAttribute('data-url') : window.location.href;
          var imageUrl = button.getAttribute('data-imageurl');
          var language = button.getAttribute('data-language') != null ? button.getAttribute('data-language') : document.documentElement.getAttribute('lang') ? document.documentElement.getAttribute('lang') : 'cs-cz';
          var howItWorks = obj.helpUrl && obj.helpUrl.length ? obj.helpUrl : button.getAttribute("data-how-it-works");
          var query = '?name=' + encodeURIComponent(title) + '&url=' + encodeURIComponent(url) + '&imageUrl=' + encodeURIComponent(imageUrl) + "&ai=" + encodeURIComponent(images) + "&language=" + encodeURIComponent(language) + '&howItWorks=' + encodeURIComponent(howItWorks);
          tomikupButton.injectDialog(query);
        }
        if (obj.id == 'tomikup-size-' + btnRndId) {
          var iframe = document.getElementById('tomikup-btn-frm-' + btnRndId);
          button.style.width = iframe.style.width = obj.width + 'px';
          button.style.height = iframe.style.height = obj.height + 'px';
        }
      } catch (e) {}
    }
  });
  for(var b = 0; b < buttons.length; b++) {
    var button = buttons[b];
    var json, ico, text, textSize, textWeight, textColor, textFont, textDecoration, textDecorationHover, textColorHover, fixed, language, howItWorks;
    json = button.getAttribute('data-json');
    if(!json) {
      ico = button.getAttribute('data-ico');
      text = button.getAttribute('data-text');
      textSize = button.getAttribute('data-text-size');
      textWeight = button.getAttribute('data-text-weight');
      textColor = button.getAttribute('data-text-color');
      textFont = button.getAttribute('data-text-font');
      textDecoration = button.getAttribute('data-text-decoration');
      textDecorationHover = button.getAttribute('data-text-decoration-hover');
      textColorHover = button.getAttribute('data-text-color-hover');
      fixed = button.classList.contains("tomikup-fixxed") || button.classList.contains("tomikup-fixed");
      language = button.getAttribute('data-language');
      howItWorks = button.getAttribute("data-how-it-works");
    }
    var rndId = getRandomInt(1000, 9999);
    var query = '?rndId=' + rndId;
    query += "&name=" + new Date()/1;
    if(json) {
      query += "&json=" + encodeURIComponent(json);
    } else {
      query += '&fixed=' + encodeURIComponent(fixed);
      if(ico)
        query += '&ico=' + encodeURIComponent(ico);
      if(text)
        query += '&text=' + encodeURIComponent(text);
      if(language)
        query += '&language=' + encodeURIComponent(language);
      if (textColor !== null)
        query += '&textColor=' + encodeURIComponent(textColor);
      if (textWeight !== null)
        query += '&textWeight=' + encodeURIComponent(textWeight);
      if (textFont !== null)
        query += '&textFont=' + encodeURIComponent(textFont);
      if (textSize !== null)
        query += '&textSize=' + encodeURIComponent(textSize);
      if (textDecoration !== null)
        query += '&textDecoration=' + encodeURIComponent(textDecoration);
      if (textDecorationHover !== null)
        query += '&textDecorationHover=' + encodeURIComponent(textDecorationHover);
      if (textColorHover !== null)
        query += '&textColorHover=' + encodeURIComponent(textColorHover);
    }
    if (howItWorks !== null)
      query += '&howItWorks=' + encodeURIComponent(howItWorks);
    var iframe = tomikupButton.create(query, rndId);
    iframe.addEventListener("load", function() {
      setTimeout(function() {
        var parent = iframe.parentNode;
        var height = parent.getBoundingClientRect().height;
        if (height % 2 !== 0)
        parent.style.height = (height + 1) + "px";
      }, 200);
    });
    button.appendChild(iframe);
    button.setAttribute('data-tomikup-rnd-id', rndId);
    tomikupButton.createTooltip(button);
  }
});

window.addEventListener("load", function() {
  const fixedButtonsNodeList = document.querySelectorAll(".tomikup-fixxed");
  const fixedButtons = Array.prototype.slice.call(fixedButtonsNodeList);
  fixedButtons && fixedButtons.length && fixedButtons.forEach(function(button) {
    button.classList.remove("tomikup-fixxed");
    button.classList.add("tomikup-fixed");
  });
});