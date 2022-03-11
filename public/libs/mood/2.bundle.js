(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[2],{

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

/***/ }),

/***/ "./src/views/result.js":
/*!*****************************!*\
  !*** ./src/views/result.js ***!
  \*****************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var opensheetmusicdisplay__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! opensheetmusicdisplay */ \"./node_modules/opensheetmusicdisplay/build/opensheetmusicdisplay.min.js\");\n/* harmony import */ var opensheetmusicdisplay__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(opensheetmusicdisplay__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var osmd_audio_player__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! osmd-audio-player */ \"./node_modules/osmd-audio-player/dist/index.js\");\n/* harmony import */ var _base_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./base.js */ \"./src/views/base.js\");\n\n\n\n\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (class extends _base_js__WEBPACK_IMPORTED_MODULE_2__[\"default\"] {\n\n\tsetup() {\n\t\t// attach musicXML sheet and AudioPlayer\n\t\tconst osmd = new opensheetmusicdisplay__WEBPACK_IMPORTED_MODULE_0__[\"OpenSheetMusicDisplay\"](this.view.querySelector(\"#sheet\"))\n\t\tthis.player = new osmd_audio_player__WEBPACK_IMPORTED_MODULE_1__[\"default\"]()\n\t\tthis.data.text()\n\t\t\t.then(xml => {\n\t\t\t\tthis.musicxml = xml\n\t\t\t\tosmd.load(this.musicxml)\n\t\t\t})\n\t\t\t.then(() => osmd.render())\n\t\t\t.then(() => this.player.loadScore(osmd))\n\t\t// bind buttons\n\t\tthis.view.querySelector(\"#play-btn\").addEventListener(\"click\", (e) => this.playScore(e))\n\t\tthis.view.querySelector(\"#dw-btn\").addEventListener(\"click\", () => this.downloadScore())\n\t\tthis.view.querySelector(\"#reset-btn\").addEventListener(\"click\", () => this.dropScore())\n\t}\n\n\tplayScore(e) {\n\t\tif (this.player.state === \"STOPPED\" || this.player.state === \"PAUSED\") {\n\t\t\tthis.player.play()\n\t\t\te.target.textContent = \"Stop\"\n\t\t} else {\n\t\t\tthis.player.stop()\n\t\t\te.target.textContent = \"Play\"\n\t\t}\n\t}\n\n\tdownloadScore() {\n\t\t// create blob object\n\t\tlet url = URL.createObjectURL(new Blob([this.musicxml], {type: \"application/vnd.recordare.musicxml\"}))\n\t\t// create fake anchor to download the blob\n\t\tlet anchor = document.createElement(\"a\")\n\t\tanchor.setAttribute(\"href\", url)\n\t\tanchor.setAttribute(\"download\", \"generated-score.musicxml\")\n\t\tanchor.click()\n\t}\n\n\tdropScore() {\n\t\tthis.player.stop()\n\t\tdelete this.player\n\t\tthis.navigator.goto(\"request\")\n\t}\n\n});\n\n\n//# sourceURL=webpack:///./src/views/result.js?");

/***/ })

}]);