/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);

// CONCATENATED MODULE: ./src/plugin.js
var plugin_plugin = function plugin(editor) {
  var offset = editor.settings.sticky_offset ? editor.settings.sticky_offset : 0;
  var stickyToolbar = editor.settings.sticky_toolbar_container ? editor.settings.sticky_toolbar_container : '.tox-toolbar';
  var stickyMenu = editor.settings.sticky_menubar_container ? editor.settings.sticky_menubar_container : '.tox-menubar';
  var stickyStatus = editor.settings.sticky_statusbar_container ? editor.settings.sticky_statusbar_container : '.tox-statusbar';
  var stickyParentClass = editor.settings.sticky_scrolling_container ? editor.settings.sticky_scrolling_container : null;
  var stickyParent = document.querySelector(stickyParentClass);
  editor.on('init', function () {
    setTimeout(function () {
      setSticky();
    }, 0);
  });
  window.addEventListener('resize', function () {
    setSticky();
  });

  if (stickyParent) {
    stickyParent.addEventListener('scroll', function () {
      setSticky();
    });
  }

  window.addEventListener('scroll', function () {
    setSticky();
  });

  function setSticky() {
    var container = editor.getContainer();
    var toolbars = container.querySelectorAll("".concat(stickyToolbar, ", ").concat(stickyMenu));
    var toolbarHeights = 0;
    toolbars.forEach(function (toolbar) {
      toolbarHeights += toolbar.offsetHeight;
    });

    if (!editor.inline && container && container.offsetParent) {
      var statusbar = '';

      if (editor.settings.statusbar !== false) {
        statusbar = container.querySelector(stickyStatus);
      }

      if (isSticky()) {
        container.style.paddingTop = "".concat(toolbarHeights, "px");

        if (isAtBottom()) {
          var nextToolbarHeight = 0;
          var toolbarsArray = [].slice.call(toolbars).reverse();
          toolbarsArray.forEach(function (toolbar) {
            toolbar.style.top = null;
            toolbar.style.width = '100%';
            toolbar.style.position = 'absolute';
            toolbar.style.bottom = statusbar ? "".concat(statusbar.offsetHeight + nextToolbarHeight, "px") : 0;
            toolbar.style.zIndex = 1;
            nextToolbarHeight = toolbar.offsetHeight;
          });
        } else {
          var prevToolbarHeight = 0;
          toolbars.forEach(function (toolbar) {
            toolbar.style.bottom = null;

            if (stickyParent) {
              var parentTop = stickyParent.getBoundingClientRect().top,
                  parentOffset = parentTop > 0 ? parentTop : 0;

              if (offset && parentTop <= offset) {
                toolbar.style.top = "".concat(offset + prevToolbarHeight, "px");
              } else {
                toolbar.style.top = "".concat(parentOffset + prevToolbarHeight, "px");
              }
            } else {
              toolbar.style.top = "".concat(offset + prevToolbarHeight, "px");
            }

            toolbar.style.position = 'fixed';
            toolbar.style.width = "".concat(container.clientWidth, "px");
            toolbar.style.zIndex = 1;
            prevToolbarHeight = toolbar.offsetHeight;
          });
        }
      } else {
        container.style.paddingTop = 0;
        toolbars.forEach(function (toolbar) {
          toolbar.style = null;
        });
      }
    }
  }

  function isSticky() {
    var editorPosition = editor.getContainer().getBoundingClientRect().top;

    if (!stickyParent && editorPosition < offset) {
      return true;
    } else if (stickyParent) {
      var parentTop = stickyParent.getBoundingClientRect().top,
          relativeTop = editorPosition - parentTop;

      if (relativeTop < 0 || parentTop < (offset || 0)) {
        return true;
      }
    }

    return false;
  }

  function isAtBottom() {
    var container = editor.getContainer();
    var editorPosition = container.getBoundingClientRect().top,
        statusbar = container.querySelector(stickyStatus),
        toolbars = container.querySelectorAll("".concat(stickyToolbar, ", ").concat(stickyMenu));
    var statusbarHeight = statusbar ? statusbar.offsetHeight : 0;
    var toolbarHeights = 0;
    toolbars.forEach(function (toolbar) {
      toolbarHeights += toolbar.offsetHeight;
    });
    var stickyHeight = -(container.offsetHeight - toolbarHeights - statusbarHeight);

    if (editorPosition < stickyHeight + offset) {
      return true;
    }

    return false;
  }
};

/* harmony default export */ var src_plugin = (plugin_plugin);
// CONCATENATED MODULE: ./src/index.js

tinymce.PluginManager.add('stickytoolbar', src_plugin);

/***/ })
/******/ ]);