(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[1],{

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

/***/ "./src/p5/components.ts":
/*!******************************!*\
  !*** ./src/p5/components.ts ***!
  \******************************/
/*! exports provided: setP5instance, UIElement, UIGroup, Direction, UIStack, UIFlexbox, Slider2D */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"setP5instance\", function() { return setP5instance; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"UIElement\", function() { return UIElement; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"UIGroup\", function() { return UIGroup; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"Direction\", function() { return Direction; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"UIStack\", function() { return UIStack; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"UIFlexbox\", function() { return UIFlexbox; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"Slider2D\", function() { return Slider2D; });\nlet p5; // to be defined by user module\nfunction setP5instance(p5i) {\n    p5 = p5i;\n}\n// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n// BASE CLASSES\nclass UIElement {\n    constructor() {\n        this.w = 0;\n        this.h = 0; // width and height\n        this.x = 0;\n        this.y = 0; // position\n    }\n    setSize(w, h) {\n        this.w = w;\n        this.h = h;\n        return this;\n    }\n    setPosition(x, y) {\n        this.x = x;\n        this.y = y;\n        return this;\n    }\n    isOver() {\n        return p5.mouseX > this.x && p5.mouseX < (this.x + this.w)\n            && p5.mouseY > this.y && p5.mouseY < (this.y + this.h);\n    }\n}\n//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n// GROUP\nclass UIGroup extends UIElement {\n    constructor() {\n        super();\n        this.elements = [];\n    }\n    draw() {\n        for (let e of this.elements)\n            e.draw();\n    }\n}\n// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n// STACK\nvar Direction;\n(function (Direction) {\n    Direction[Direction[\"HORIZONTAL\"] = 0] = \"HORIZONTAL\";\n    Direction[Direction[\"VERTICAL\"] = 1] = \"VERTICAL\";\n})(Direction || (Direction = {}));\nclass UIStack extends UIGroup {\n    constructor(m, s, d) {\n        super();\n        this.margin = m;\n        this.spacing = s;\n        this.dir = d;\n    }\n    get innerW() {\n        return this.w - 2 * this.margin;\n    }\n    get innerH() {\n        return this.h - 2 * this.margin;\n    }\n    layout() {\n        let curX = this.x + this.margin;\n        let curY = this.y + this.margin;\n        let maxX = 0, maxY = 0;\n        for (let el of this.elements) {\n            el.setPosition(curX, curY);\n            if (this.dir == Direction.HORIZONTAL) {\n                curX += el.w + this.spacing;\n                maxX = curX;\n                maxY = Math.max(maxY, curY + el.h);\n            }\n            else {\n                curY += el.h + this.spacing;\n                maxX = Math.max(maxX, curX + el.w);\n                maxY = curY;\n            }\n        }\n        // recommpute stack size\n        this.w = maxX + this.margin - this.x;\n        this.h = maxY + this.margin - this.y;\n    }\n}\n// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n// FLEXBOX\nclass UIFlexbox extends UIStack {\n    constructor(m, s, d) {\n        super(m, s, d);\n    }\n    layout() {\n        let elemH, elemW;\n        if (this.dir == Direction.HORIZONTAL) {\n            elemH = this.innerH;\n            elemW = (this.innerW + this.spacing) / this.elements.length - this.spacing;\n        }\n        else {\n            elemW = this.innerW;\n            elemH = (this.innerH + this.spacing) / this.elements.length - this.spacing;\n        }\n        for (let el of this.elements)\n            el.setSize(elemW, elemH);\n        super.layout();\n    }\n}\n// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n// SLIDERS\nclass Slider2D extends UIElement {\n    constructor(min_v, max_v, inertia, thumb_diameter) {\n        super();\n        this.thumb_d = 30; // diameter of circle\n        this.thumb_x = new SliderValue(min_v, max_v, inertia);\n        this.thumb_y = new SliderValue(min_v, max_v, inertia);\n        this.thumb_d = thumb_diameter;\n    }\n    setValue(new_vx, new_vy) {\n        let changed_x = this.thumb_x.setValue(new_vx);\n        let changed_y = this.thumb_y.setValue(new_vy);\n        if (this.onChange && (changed_x || changed_y))\n            this.onChange(this);\n    }\n    getValue() {\n        return [this.thumb_x.v, this.thumb_y.v];\n    }\n    update() {\n        if (this.isOver() && p5.mouseIsPressed) {\n            this.setValue(this.thumb_x.position2value(p5.mouseX, this.startX, this.endX), this.thumb_y.position2value(p5.mouseY, this.startY, this.endY));\n        }\n        this.thumb_x.update();\n        this.thumb_y.update();\n    }\n    draw() {\n        this.update();\n        p5.noStroke();\n        p5.fill(0);\n        // Rectangle\n        // @ts-ignore\n        p5.erase();\n        p5.rect(this.x, this.y, this.w, this.h);\n        // @ts-ignore\n        p5.noErase();\n        // Circle\n        let xpos = this.thumb_x.value2position(this.thumb_x.drawn_v, this.startX, this.endX);\n        let ypos = this.thumb_y.value2position(this.thumb_y.drawn_v, this.startY, this.endY);\n        p5.ellipseMode(p5.CENTER);\n        p5.ellipse(xpos, ypos, this.thumb_d, this.thumb_d);\n    }\n    get startX() {\n        // left\n        return this.x + this.thumb_d / 2;\n    }\n    get endX() {\n        // right\n        return this.x + this.w - this.thumb_d / 2;\n    }\n    get startY() {\n        // down\n        return this.y + this.h - this.thumb_d / 2;\n    }\n    get endY() {\n        // up\n        return this.y + this.thumb_d / 2;\n    }\n}\nclass SliderValue {\n    constructor(min_v, max_v, inertia) {\n        this.min_v = min_v;\n        this.max_v = max_v;\n        this.inertia = inertia;\n        this.value = this.drawn_value = (this.max_v - this.min_v) / 2;\n    }\n    get v() {\n        return this.value;\n    }\n    set v(new_v) {\n        this.setValue(new_v);\n    }\n    get drawn_v() {\n        return this.drawn_value;\n    }\n    setValue(new_v) {\n        new_v = this.constrain(new_v);\n        let old_v = this.value;\n        this.value = new_v;\n        return new_v != old_v;\n    }\n    update() {\n        this.drawn_value += (this.value - this.drawn_value) / this.inertia;\n    }\n    position2value(pos, start, end) {\n        let ratio = this.constrain((pos - start) / (end - start), 0, 1);\n        return (this.max_v - this.min_v) * ratio + this.min_v;\n    }\n    value2position(val, start, end) {\n        let ratio = (val - this.min_v) / (this.max_v - this.min_v);\n        return ratio * (end - start) + start;\n    }\n    constrain(val, min_v = this.min_v, max_v = this.max_v) {\n        return Math.min(Math.max(val, min_v), max_v);\n    }\n}\n\n\n//# sourceURL=webpack:///./src/p5/components.ts?");

/***/ }),

/***/ "./src/p5/mood_picker_sketch.js":
/*!**************************************!*\
  !*** ./src/p5/mood_picker_sketch.js ***!
  \**************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _components_ts__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components.ts */ \"./src/p5/components.ts\");\n\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (function(p5) {\n\tObject(_components_ts__WEBPACK_IMPORTED_MODULE_0__[\"setP5instance\"])(p5)\n\n\tlet slider\n\n\tp5.setup = () => {\n\t\tp5.createCanvas(300, 300)\n\t\tslider = new _components_ts__WEBPACK_IMPORTED_MODULE_0__[\"Slider2D\"](0, 1, 2, 20)\n\t\tslider.setPosition(0,0).setSize(300,300).setValue(0.5, 0.5)\n\t}\n\n\tp5.draw = () => {\n\t\tslider.draw()\n\t\tp5.stroke(0)\n\t\tp5.drawingContext.setLineDash([1, 4])\n\t\tp5.line(0, p5.height/2, p5.width, p5.height/2)\n\t\tp5.line(p5.width/2, 0, p5.width/2, p5.height)\n\t}\n\n\tp5.readValue = () => {\n\t\treturn slider.getValue()\n\t}\n\n});\n\n\n//# sourceURL=webpack:///./src/p5/mood_picker_sketch.js?");

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

/***/ "./src/views/request.js":
/*!******************************!*\
  !*** ./src/views/request.js ***!
  \******************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var p5__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! p5 */ \"./node_modules/p5/lib/p5.js\");\n/* harmony import */ var p5__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(p5__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _p5_mood_picker_sketch_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../p5/mood_picker_sketch.js */ \"./src/p5/mood_picker_sketch.js\");\n/* harmony import */ var _base_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./base.js */ \"./src/views/base.js\");\n\n\n\n\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (class extends _base_js__WEBPACK_IMPORTED_MODULE_2__[\"default\"] {\n\n\tsetup() {\n\t\t// attach mood-picker canvas\n\t\tthis.mood_picker = new p5__WEBPACK_IMPORTED_MODULE_0___default.a(_p5_mood_picker_sketch_js__WEBPACK_IMPORTED_MODULE_1__[\"default\"], this.view.querySelector(\"#mood-picker\"))\n\t\t// bind \"inspire me\" button\n\t\tthis.view.querySelector(\"#create\").addEventListener(\"click\", () => this.create_melody())\n\t}\n\n\tcreate_melody() {\n\t\t// update ui\n\t\tthis.show_error(false)\n\t\tthis.set_loading(true)\n\t\t// fetch\n\t\tlet [v, a] = this.mood_picker.readValue()\n\t\tthis.fetch_melody(v, a).then((response) => {\n\t\t\tthis.navigator.goto(\"result\", response)\n\t\t\t\t.then(() => this.mood_picker.remove())\n\t\t}).catch(e => {\n\t\t\t// update ui\n\t\t\tthis.set_loading(false)\n\t\t\tthis.show_error(true)\n\t\t})\n\t}\n\n\tshow_error(show) {\n\t\tthis.view.classList.toggle(\"error\", show)\n\t\tif (this.removeErrorClass)\n\t\t\tclearTimeout(this.removeErrorClass)\n\t\tif (show)\n\t\t\tthis.removeErrorClass = setTimeout(() => this.view.classList.remove(\"error\"), 2000)\n\t}\n\n\tset_loading(loading) {\n\t\tthis.view.classList.toggle(\"loading\", loading)\n\t\tthis.view.querySelector(\"#create\").disabled = loading\n\t}\n\n\tasync fetch_melody(v, a) {\n\t\ttry {\n\t\t\tlet response = await fetch(\"https://metamusic.toob.net.cn/meldy/\" + `?valence=${v}&arousal=${a}`)\n\t\t\tif (response.ok)\n\t\t\t\treturn response\n\t\t} catch (e) {\n\t\t\tthrow new Error(`Cannot reach back-end API (${\"https://metamusic.toob.net.cn/meldy/\"} → http status: ${response.status})`)\n\t\t}\n\t}\n});\n\n\n//# sourceURL=webpack:///./src/views/request.js?");

/***/ })

}]);