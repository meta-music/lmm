(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[3],{

/***/ "./node_modules/dom-element-loader/index.js!./src/views/request.html":
/*!******************************************************************!*\
  !*** ./node_modules/dom-element-loader!./src/views/request.html ***!
  \******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony default export */ __webpack_exports__[\"default\"] = ((function(){\n\t\tconst domParser = document.createElement('div')\n\t\tdomParser.innerHTML = \"<div class=\\\"view request-view\\\">\\n\\n\\t<div class=\\\"row intro\\\">\\n\\t\\t<span class=\\\"description\\\">Today I feel...</span>\\n\\t</div>\\n\\n\\t<div class=\\\"row mood-picker\\\" id=\\\"mood-picker\\\">\\n\\t\\t<span class=\\\"mood happy-mood\\\">Happy</span>\\n\\t\\t<span class=\\\"mood peace-mood\\\">Peaceful</span>\\n\\t\\t<span class=\\\"mood upset-mood\\\">Upset</span>\\n\\t\\t<span class=\\\"mood sad-mood\\\">Sad</span>\\n\\t\\t<!-- canvas will be attached here -->\\n\\t</div>\\n\\n\\t<div class=\\\"row actions has-icons\\\">\\n\\t\\t<button class=\\\"btn btn-go\\\" id=\\\"create\\\">Impress me</button>\\n\\t\\t<span class=\\\"error-msg\\\">Network problem, retry in some minutes</span>\\n\\t\\t<img src=\\\"./assets/star.png\\\" class=\\\"star-img\\\">\\n\\t</div>\\n\\n</div>\\n\" \n\t\treturn domParser.firstChild\n\t})());\n\n//# sourceURL=webpack:///./src/views/request.html?./node_modules/dom-element-loader");

/***/ }),

/***/ "./node_modules/dom-element-loader/index.js!./src/views/result.html":
/*!*****************************************************************!*\
  !*** ./node_modules/dom-element-loader!./src/views/result.html ***!
  \*****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony default export */ __webpack_exports__[\"default\"] = ((function(){\n\t\tconst domParser = document.createElement('div')\n\t\tdomParser.innerHTML = \"<div class=\\\"view result-view\\\">\\n\\n\\t<div class=\\\"row intro\\\">\\n\\t\\t<!--<span class=\\\"description\\\">Your generated music piece</span>-->\\n\\t</div>\\n\\n\\t<div class=\\\"row sheet has-icons\\\">\\n\\t\\t<img src=\\\"./assets/fish.png\\\" class=\\\"fish-img\\\">\\n\\t\\t<!-- sheet will be inserted here -->\\n\\t\\t<div id=\\\"sheet\\\"></div>\\n\\t</div>\\n\\n\\t<div class=\\\"row actions\\\">\\n\\t\\t<button class=\\\"btn btn-play\\\" id=\\\"play-btn\\\">Play</button>\\n\\t\\t<button class=\\\"btn btn-dw\\\" id=\\\"dw-btn\\\">Download</button>\\n\\t\\t<button class=\\\"btn btn-reset\\\" id=\\\"reset-btn\\\">Restart</button>\\n\\t</div>\\n\\n</div>\\n\" \n\t\treturn domParser.firstChild\n\t})());\n\n//# sourceURL=webpack:///./src/views/result.html?./node_modules/dom-element-loader");

/***/ }),

/***/ "./src/views sync recursive ./node_modules/dom-element-loader/index.js!./ ^\\.\\/.*\\.html$":
/*!*************************************************************************!*\
  !*** ./src/views sync ./node_modules/dom-element-loader ^\.\/.*\.html$ ***!
  \*************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("var map = {\n\t\"./request.html\": \"./node_modules/dom-element-loader/index.js!./src/views/request.html\",\n\t\"./result.html\": \"./node_modules/dom-element-loader/index.js!./src/views/result.html\"\n};\n\n\nfunction webpackContext(req) {\n\tvar id = webpackContextResolve(req);\n\treturn __webpack_require__(id);\n}\nfunction webpackContextResolve(req) {\n\tif(!__webpack_require__.o(map, req)) {\n\t\tvar e = new Error(\"Cannot find module '\" + req + \"'\");\n\t\te.code = 'MODULE_NOT_FOUND';\n\t\tthrow e;\n\t}\n\treturn map[req];\n}\nwebpackContext.keys = function webpackContextKeys() {\n\treturn Object.keys(map);\n};\nwebpackContext.resolve = webpackContextResolve;\nmodule.exports = webpackContext;\nwebpackContext.id = \"./src/views sync recursive ./node_modules/dom-element-loader/index.js!./ ^\\\\.\\\\/.*\\\\.html$\";\n\n//# sourceURL=webpack:///./src/views_sync_./node_modules/dom-element-loader_^\\.\\/.*\\.html$?");

/***/ }),

/***/ "./src/views/base.js":
/*!***************************!*\
  !*** ./src/views/base.js ***!
  \***************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony default export */ __webpack_exports__[\"default\"] = (class {\n\tconstructor(nav, data, viewName) {\n\t\tthis.navigator = nav\n\t\tthis.data = data\n\t\tthis.view = __webpack_require__(\"./src/views sync recursive ./node_modules/dom-element-loader/index.js!./ ^\\\\.\\\\/.*\\\\.html$\")(`./${viewName}.html`).default.cloneNode(true)\n\t}\n\n\tsetup() {\n\t\t// this method gets called after the .view gets added to the DOM\n\t}\n});\n\n\n//# sourceURL=webpack:///./src/views/base.js?");

/***/ })

}]);