!function(e){function t(t){for(var n,a,c=t[0],u=t[1],l=t[2],g=0,d=[];g<c.length;g++)a=c[g],Object.prototype.hasOwnProperty.call(i,a)&&i[a]&&d.push(i[a][0]),i[a]=0;for(n in u)Object.prototype.hasOwnProperty.call(u,n)&&(e[n]=u[n]);for(s&&s(t);d.length;)d.shift()();return o.push.apply(o,l||[]),r()}function r(){for(var e,t=0;t<o.length;t++){for(var r=o[t],n=!0,a=1;a<r.length;a++){var c=r[a];0!==i[c]&&(n=!1)}n&&(o.splice(t--,1),e=__webpack_require__(__webpack_require__.s=r[0]))}return e}var n={},i={25:0},o=[];function __webpack_require__(t){if(n[t])return n[t].exports;var r=n[t]={i:t,l:!1,exports:{}};return e[t].call(r.exports,r,r.exports,__webpack_require__),r.l=!0,r.exports}__webpack_require__.m=e,__webpack_require__.c=n,__webpack_require__.d=function(e,t,r){__webpack_require__.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},__webpack_require__.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},__webpack_require__.t=function(e,t){if(1&t&&(e=__webpack_require__(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(__webpack_require__.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)__webpack_require__.d(r,n,function(t){return e[t]}.bind(null,n));return r},__webpack_require__.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return __webpack_require__.d(t,"a",t),t},__webpack_require__.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},__webpack_require__.p="";var a=window.__googlesitekit_webpackJsonp=window.__googlesitekit_webpackJsonp||[],c=a.push.bind(a);a.push=t,a=a.slice();for(var u=0;u<a.length;u++)t(a[u]);var s=c;o.push([622,0]),r()}({1:function(e,t,r){"use strict";(function(e){r.d(t,"d",(function(){return a})),r.d(t,"a",(function(){return c})),r.d(t,"e",(function(){return s})),r.d(t,"f",(function(){return l})),r.d(t,"g",(function(){return d})),r.d(t,"h",(function(){return f})),r.d(t,"b",(function(){return v})),r.d(t,"i",(function(){return y})),r.d(t,"j",(function(){return m})),r.d(t,"k",(function(){return k})),r.d(t,"c",(function(){return E})),r.d(t,"l",(function(){return P})),r.d(t,"m",(function(){return I})),r.d(t,"n",(function(){return T})),r.d(t,"o",(function(){return x})),r.d(t,"p",(function(){return N})),r.d(t,"q",(function(){return C})),r.d(t,"r",(function(){return q})),r.d(t,"s",(function(){return F}));var n=r(96);void 0===e.googlesitekit&&(e.googlesitekit={});var i=e.googlesitekit._element||n,o=i.Children,a=i.cloneElement,c=i.Component,u=i.concatChildren,s=i.createContext,l=i.createElement,g=i.createInterpolateElement,d=i.createPortal,f=i.createRef,p=i.findDOMNode,b=i.forwardRef,v=i.Fragment,h=i.isEmptyElement,y=i.isValidElement,m=i.lazy,_=i.memo,O=i.Platform,w=i.RawHTML,k=i.render,j=i.renderToString,S=i.StrictMode,E=i.Suspense,A=i.switchChildrenNodeName,D=i.unmountComponentAtNode,P=i.useCallback,I=i.useContext,R=i.useDebugValue,T=i.useEffect,W=i.useImperativeHandle,x=i.useLayoutEffect,N=i.useMemo,C=i.useReducer,q=i.useRef,F=i.useState;void 0===e.googlesitekit._element&&(e.googlesitekit._element={Children:o,cloneElement:a,Component:c,concatChildren:u,createContext:s,createElement:l,createInterpolateElement:g,createPortal:d,createRef:f,findDOMNode:p,forwardRef:b,Fragment:v,isEmptyElement:h,isValidElement:y,lazy:m,memo:_,Platform:O,RawHTML:w,render:k,renderToString:j,StrictMode:S,Suspense:E,switchChildrenNodeName:A,unmountComponentAtNode:D,useCallback:P,useContext:I,useDebugValue:R,useEffect:T,useImperativeHandle:W,useLayoutEffect:x,useMemo:N,useReducer:C,useRef:q,useState:F})}).call(this,r(15))},11:function(e,t){e.exports=googlesitekit.data},159:function(e,t,r){"use strict";function n(e,t){return e.sort((function(e,r){return e[t]>r[t]?1:e[t]<r[t]?-1:0}))}r.d(t,"a",(function(){return n}))},16:function(e,t,r){"use strict";(function(e){r.d(t,"a",(function(){return o})),r.d(t,"b",(function(){return a})),r.d(t,"f",(function(){return c})),r.d(t,"g",(function(){return u})),r.d(t,"e",(function(){return s})),r.d(t,"d",(function(){return f})),r.d(t,"c",(function(){return p}));var n=r(92);void 0===e.googlesitekit&&(e.googlesitekit={});var i=e.googlesitekit._hooks||n,o=i.addAction,a=i.addFilter,c=i.removeAction,u=i.removeFilter,s=i.hasAction,l=i.hasFilter,g=i.removeAllActions,d=i.removeAllFilters,f=i.doAction,p=i.applyFilters,b=i.currentAction,v=i.currentFilter,h=i.doingAction,y=i.doingFilter,m=i.didAction,_=i.didFilter,O=i.actions,w=i.filters;void 0===e.googlesitekit._hooks&&(e.googlesitekit._hooks={addAction:o,addFilter:a,removeAction:c,removeFilter:u,hasAction:s,hasFilter:l,removeAllActions:g,removeAllFilters:d,doAction:f,applyFilters:p,currentAction:b,currentFilter:v,doingAction:h,doingFilter:y,didAction:m,didFilter:_,actions:O,filters:w})}).call(this,r(15))},210:function(e,t,r){"use strict";r.d(t,"a",(function(){return n})),r.d(t,"d",(function(){return i})),r.d(t,"c",(function(){return o})),r.d(t,"e",(function(){return a})),r.d(t,"b",(function(){return c})),r.d(t,"g",(function(){return u})),r.d(t,"f",(function(){return s})),r.d(t,"i",(function(){return l})),r.d(t,"h",(function(){return g}));var n="dashboardAllTraffic",i="dashboardSearchFunnel",o="dashboardPopularity",a="dashboardSpeed",c="dashboardEarnings",u="pageDashboardSearchFunnel",s="pageDashboardAllTraffic",l="pageDashboardTopQueries",g="pageDashboardSpeed"},23:function(e,t,r){"use strict";(function(e){r.d(t,"a",(function(){return a})),r.d(t,"b",(function(){return c}));var n=r(81),i=r.n(n),o=r(1),a=function(e){return function(t){return function FilteredComponent(r){return Object(o.f)(o.b,{},"",Object(o.f)(t,r),e)}}},c=function(t,r){return function(n){return function InnerComponent(o){return e.createElement(t,i()({},o,r,{OriginalComponent:n}))}}}}).call(this,r(12))},235:function(e,t,r){"use strict";var n=r(11),i=r.n(n),o=r(248),a=r(58);r.d(t,"a",(function(){return a.a}));var c=r(249),u=i.a.combineStores(i.a.commonStore,o.a,c.a);i.a.registerStore(a.a,u)},247:function(e,t,r){"use strict";(function(e){r(1);var n=r(18),i=r.n(n),o=r(2),a=function Widget(t){var r=t.children,n=t.className,o=t.slug;return e.createElement("div",{className:i()("googlesitekit-widget","googlesitekit-widget--".concat(o),n)},r)};a.defaultProps={children:void 0},a.propTypes={children:o.node,slug:o.string.isRequired},t.a=a}).call(this,r(12))},248:function(e,t,r){"use strict";(function(e){var n=r(10),i=r.n(n),o=r(19),a=r.n(o),c=r(58),u=r(159);function s(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function l(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?s(Object(r),!0).forEach((function(t){i()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):s(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}var g=Object.keys(c.b).map((function(e){return"WIDGET_AREA_STYLES.".concat(e)})).join(", "),d={assignWidgetArea:function(e,t){return{payload:{slug:e,contextSlugs:"string"==typeof t?[t]:t},type:"ASSIGN_WIDGET_AREA"}},registerWidgetArea:function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},r=t.priority,n=void 0===r?10:r,i=t.style,o=void 0===i?c.b.BOXES:i,u=t.title,s=t.subtitle,l=t.icon;return a()(e,"slug is required."),a()(u,"settings.title is required."),a()(s,"settings.subtitle is required."),a()(Object.values(c.b).includes(o),"settings.style must be one of: ".concat(g,".")),{payload:{slug:e,settings:{priority:n,style:o,title:u,subtitle:s,icon:l}},type:"REGISTER_WIDGET_AREA"}}},f={isWidgetAreaRegistered:function(e,t){return void 0!==e.areas[t]},getWidgetAreas:function(e,t){a()(t,"contextSlug is required.");var r=e.areas,n=e.contextAssignments;return Object(u.a)(Object.values(r).filter((function(e){return n[t]&&n[t].includes(e.slug)})),"priority")},getWidgetArea:function(e,t){return a()(t,"slug is required."),e.areas[t]||null}};t.a={INITIAL_STATE:{areas:{},contextAssignments:{}},actions:d,controls:{},reducer:function(t,r){var n=r.type,o=r.payload;switch(n){case"ASSIGN_WIDGET_AREA":var a=o.slug,c=o.contextSlugs,u=t.contextAssignments;return c.forEach((function(e){void 0===u[e]&&(u[e]=[]),u[e].includes(a)||u[e].push(a)})),l(l({},t),{},{contextAssignments:u});case"REGISTER_WIDGET_AREA":var s=o.slug,g=o.settings;return void 0!==t.areas[s]?(e.console.warn('Could not register widget area with slug "'.concat(s,'". Widget area "').concat(s,'" is already registered.')),l({},t)):l(l({},t),{},{areas:l(l({},t.areas),{},i()({},s,l(l({},g),{},{slug:s})))});default:return l({},t)}},resolvers:{},selectors:f}}).call(this,r(15))},249:function(e,t,r){"use strict";(function(e){var n=r(10),i=r.n(n),o=r(4),a=r.n(o),c=r(19),u=r.n(c),s=r(346),l=r(11),g=r.n(l),d=r(58),f=r(159),p=r(32);function b(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function v(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?b(Object(r),!0).forEach((function(t){i()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):b(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}var h=g.a.commonActions,y=g.a.createRegistrySelector,m={},_=Object.keys(d.c).map((function(e){return"WIDGET_WIDTHS.".concat(e)})).join(", "),O={areaAssignments:{},registryKey:void 0,widgets:{}},w={assignWidget:function(e,t){return{payload:{slug:e,areaSlugs:"string"==typeof t?[t]:t},type:"ASSIGN_WIDGET"}},registerWidget:a.a.mark((function e(t){var r,n,i,o,c,l,g,f,b,v,y=arguments;return a.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return r=y.length>1&&void 0!==y[1]?y[1]:{},n=r.component,i=r.priority,o=void 0===i?10:i,c=r.width,l=void 0===c?d.c.QUARTER:c,g=r.wrapWidget,f=void 0===g||g,u()(n,"component is required to register a widget."),u()(Object.values(d.c).includes(l),"Widget width should be one of: ".concat(_,', but "').concat(l,'" was provided.')),e.next=5,h.getRegistry();case 5:return b=e.sent,e.next=8,b.select(p.c).getRegistryKey();case 8:if(void 0!==(v=e.sent)){e.next=13;break}return v=Object(s.a)(),e.next=13,b.dispatch(p.c).setRegistryKey(v);case 13:return void 0===m[v]&&(m[v]={}),void 0===m[v][t]&&(m[v][t]=n),e.next=17,{payload:{slug:t,settings:{priority:o,width:l,wrapWidget:f}},type:"REGISTER_WIDGET"};case 17:return e.abrupt("return",{});case 18:case"end":return e.stop()}}),e)}))},k={isWidgetRegistered:function(e,t){return void 0!==e.widgets[t]},getWidgets:y((function(e){return function(t,r){u()(r,"widgetAreaSlug is required.");var n=t.areaAssignments,i=t.widgets,o=e(p.c).getRegistryKey();return Object(f.a)(Object.values(i).filter((function(e){return n[r]&&n[r].includes(e.slug)})).map((function(e){var t=v({},e);return m[o]&&(t.component=m[o][e.slug]),t})),"priority")}})),getWidget:y((function(e){return function(t,r){u()(r,"slug is required to get a widget.");var n=t.widgets,i=e(p.c).getRegistryKey(),o=n[r];return o&&m[i]&&(o.component=m[i][o.slug]),o||null}}))};t.a={INITIAL_STATE:O,actions:w,controls:{},reducer:function(t,r){var n=r.type,o=r.payload;switch(n){case"ASSIGN_WIDGET":var a=o.slug,c=o.areaSlugs,u=t.areaAssignments;return c.forEach((function(e){void 0===u[e]&&(u[e]=[]),u[e].includes(a)||u[e].push(a)})),v(v({},t),{},{areaAssignments:u});case"REGISTER_WIDGET":var s=o.slug,l=o.settings;return void 0!==t.widgets[s]?(e.console.warn('Could not register widget with slug "'.concat(s,'". Widget "').concat(s,'" is already registered.')),v({},t)):v(v({},t),{},{widgets:v(v({},t.widgets),{},i()({},s,v(v({},l),{},{slug:s})))});default:return v({},t)}},resolvers:{},selectors:k}}).call(this,r(15))},285:function(e,t,r){"use strict";r.d(t,"b",(function(){return u}));r(1);var n=r(11),i=r(247),o=r(58),a=(r(235),r(0)),c=r(210);function u(e){e.registerWidgetArea(c.a,{title:Object(a.__)("All Traffic","google-site-kit"),subtitle:Object(a.__)("How people found your site.","google-site-kit"),style:o.b.COMPOSITE,priority:1},"dashboard"),e.registerWidgetArea(c.d,{title:Object(a.__)("Search Funnel","google-site-kit"),subtitle:Object(a.__)("How your site appeared in Search results and how many visitors you got from Search.","google-site-kit"),style:o.b.COMPOSITE,priority:2},"dashboard"),e.registerWidgetArea(c.c,{title:Object(a.__)("Popularity","google-site-kit"),subtitle:Object(a.__)("Your most popular pages and how people found them from Search.","google-site-kit"),style:o.b.BOXES,priority:3},"dashboard"),e.registerWidgetArea(c.e,{title:Object(a.__)("Page Speed and Experience","google-site-kit"),subtitle:Object(a.__)("How fast your home page loads, how quickly people can interact with your content, and how stable your content is.","google-site-kit"),style:o.b.BOXES,priority:4},"dashboard"),e.registerWidgetArea(c.b,{title:Object(a.__)("Earnings","google-site-kit"),subtitle:Object(a.__)("How much you’re earning from your content through AdSense.","google-site-kit"),style:o.b.BOXES,priority:5},"dashboard"),e.registerWidgetArea(c.g,{title:Object(a.__)("Search Funnel","google-site-kit"),subtitle:Object(a.__)("How your site appeared in Search results and how many visitors you got from Search.","google-site-kit"),style:o.b.COMPOSITE,priority:1},"pageDashboard"),e.registerWidgetArea(c.f,{title:Object(a.__)("All Traffic","google-site-kit"),subtitle:Object(a.__)("How people found your page.","google-site-kit"),style:o.b.COMPOSITE,priority:2},"pageDashboard"),e.registerWidgetArea(c.i,{title:Object(a.__)("Top Queries","google-site-kit"),subtitle:Object(a.__)("What people searched for to find your page.","google-site-kit"),style:o.b.BOXES,priority:3},"pageDashboard"),e.registerWidgetArea(c.h,{title:Object(a.__)("Page Speed and Experience","google-site-kit"),subtitle:Object(a.__)("How fast your page loads, how quickly people can interact with your content, and how stable your content is.","google-site-kit"),style:o.b.BOXES,priority:4},"pageDashboard")}var s={components:{Widget:i.a},WIDGET_AREA_STYLES:o.b,WIDGET_WIDTHS:o.c,registerWidgetArea:function(e,t,r){Object(n.dispatch)(o.a).registerWidgetArea(e,t),r&&s.assignWidgetArea(e,r)},registerWidget:function(e,t,r){Object(n.dispatch)(o.a).registerWidget(e,t),r&&s.assignWidget(e,r)},assignWidgetArea:function(e,t){Object(n.dispatch)(o.a).assignWidgetArea(e,t)},assignWidget:function(e,t){Object(n.dispatch)(o.a).assignWidget(e,t)},isWidgetAreaRegistered:function(e){return Object(n.select)(o.a).isWidgetAreaRegistered(e)},isWidgetRegistered:function(e){return Object(n.select)(o.a).isWidgetRegistered(e)}};t.a=s},32:function(e,t,r){"use strict";r.d(t,"c",(function(){return n})),r.d(t,"a",(function(){return i})),r.d(t,"b",(function(){return o}));var n="core/site",i="primary",o="secondary"},34:function(e,t,r){"use strict";(function(e,n){r(1);var i=r(2),o=r.n(i),a=r(18),c=r.n(a),u=function SvgIcon(t){var r=t.id,i=t.className,o=t.height,a=t.width,u="".concat(e._googlesitekitLegacyData.admin.assetsRoot,"svg/svg.svg");return n.createElement("svg",{className:c()("svg",i),height:o,width:a},n.createElement("use",{xlinkHref:"".concat(u,"#").concat(r)}))};u.propTypes={id:o.a.string.isRequired,className:o.a.string,height:o.a.string,width:o.a.string},u.defaultProps={className:"",height:20,width:20},t.a=u}).call(this,r(15),r(12))},35:function(e,t,r){"use strict";r.d(t,"a",(function(){return n})),r.d(t,"b",(function(){return i}));var n="_googlesitekitDataLayer",i="data-googlesitekit-gtag"},40:function(e,t,r){"use strict";(function(e){r.d(t,"a",(function(){return l}));var n,i=r(6),o=r.n(i),a=r(7),c=r.n(a),u=function(t){var r=e[t];if(!r)return!1;try{var n="__storage_test__";return r.setItem(n,n),r.removeItem(n),!0}catch(e){return e instanceof DOMException&&(22===e.code||1014===e.code||"QuotaExceededError"===e.name||"NS_ERROR_DOM_QUOTA_REACHED"===e.name)&&0!==r.length}},s=function(){function NullStorage(){o()(this,NullStorage)}return c()(NullStorage,[{key:"key",value:function(){return null}},{key:"getItem",value:function(){return null}},{key:"setItem",value:function(){}},{key:"removeItem",value:function(){}},{key:"clear",value:function(){}},{key:"length",get:function(){return 0}}]),NullStorage}(),l=function(){return n||(n=u("sessionStorage")?e.sessionStorage:u("localStorage")?e.localStorage:new s),n}}).call(this,r(15))},5:function(e,t,r){"use strict";(function(e,n){r.d(t,"s",(function(){return P})),r.d(t,"q",(function(){return I})),r.d(t,"n",(function(){return T})),r.d(t,"r",(function(){return W})),r.d(t,"h",(function(){return x})),r.d(t,"c",(function(){return N})),r.d(t,"f",(function(){return C})),r.d(t,"j",(function(){return q})),r.d(t,"l",(function(){return F})),r.d(t,"m",(function(){return L})),r.d(t,"x",(function(){return M})),r.d(t,"b",(function(){return G})),r.d(t,"u",(function(){return H})),r.d(t,"e",(function(){return U})),r.d(t,"p",(function(){return B})),r.d(t,"i",(function(){return K}));var i=r(4),o=r.n(i),a=r(14),c=r.n(a),u=r(10),s=r.n(u),l=r(44),g=r.n(l),d=r(33),f=r.n(d),p=(r(1),r(13)),b=r(16),v=r(0),h=r(45),y=r(142),m=r(34);r.d(t,"a",(function(){return m.a}));var _=r(50);r.d(t,"w",(function(){return _.c}));var O=r(23),w=r(54);r.d(t,"t",(function(){return w.a}));var k=r(56);r.d(t,"v",(function(){return k.a}));var j=r(55);r.d(t,"d",(function(){return j.b})),r.d(t,"k",(function(){return j.c}));r(40);var S=r(60);function E(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function A(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?E(Object(r),!0).forEach((function(t){s()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):E(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}r.d(t,"o",(function(){return S.a})),r.d(t,"g",(function(){return O.b}));var D=function(e){return 1e6<=e?Math.round(e/1e5)/10:1e4<=e?Math.round(e/1e3):1e3<=e?Math.round(e/100)/10:e},P=function(e){var t=arguments.length>1&&void 0!==arguments[1]&&arguments[1];if(e=Object(p.isFinite)(e)?e:Number(e),Object(p.isFinite)(e)||(console.warn("Invalid number",e,f()(e)),e=0),t)return I(e,{style:"currency",currency:t});var r={minimumFractionDigits:1,maximumFractionDigits:1};return 1e6<=e?Object(v.sprintf)(Object(v.__)("%sM","google-site-kit"),I(D(e),e%10==0?{}:r)):1e4<=e?Object(v.sprintf)(Object(v.__)("%sK","google-site-kit"),I(D(e))):1e3<=e?Object(v.sprintf)(Object(v.__)("%sK","google-site-kit"),I(D(e),e%10==0?{}:r)):e.toString()},I=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},r=t.locale,n=void 0===r?R():r,i=g()(t,["locale"]);return new Intl.NumberFormat(n,i).format(e)},R=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:e,r=Object(p.get)(t,["_googlesitekitLegacyData","locale","","lang"]);if(r){var n=r.match(/^(\w{2})?(_)?(\w{2})/);if(n&&n[0])return n[0].replace(/_/g,"-")}return t.navigator.language},T=function(e){switch(e){case"minute":return 60;case"hour":return 3600;case"day":return 86400;case"week":return 604800;case"month":return 2592e3;case"year":return 31536e3}},W=function(e){if(e=parseInt(e,10),isNaN(e)||0===e)return"0.0s";var t={};return t.hours=Math.floor(e/60/60),t.minutes=Math.floor(e/60%60),t.seconds=Math.floor(e%60),((t.hours?t.hours+"h ":"")+(t.minutes?t.minutes+"m ":"")+(t.seconds?t.seconds+"s ":"")).trim()},x=function(e,t){var r=1e3*T("day"),n=e.getTime(),i=t.getTime();return Math.round(Math.abs(n-i)/r)},N=function(e,t){if("0"===e||0===e||isNaN(e))return"";var r=((t-e)/e*100).toFixed(1);return isNaN(r)||"Infinity"===r?"":r},C=function(e,t){return Object(p.map)(e,(function(e,r){return[e[0],e[t]||(0===r?"":0)]}))},q=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:e._googlesitekitLegacyData,r=t.modules;return r?Object.keys(r).reduce((function(e,t){return"object"!==f()(r[t])||void 0===r[t].slug||void 0===r[t].name||r[t].slug!==t?e:A(A({},e),{},s()({},t,r[t]))}),{}):{}},F=function(t,r){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:e._googlesitekitLegacyData,i=n.admin,o=i.connectURL,a=i.adminRoot,c=n.setup.needReauthenticate,u=q(n)[t].screenID,s="pagespeed-insights"===t?{notification:"authentication_success",reAuth:void 0}:{},l=Object(h.a)(a,A({page:t&&r&&u?u:"googlesitekit-dashboard",slug:t,reAuth:r},s));if(!c)return l;var g=encodeURIComponent(Object(y.a)(l));return l=a+"?"+g,Object(h.a)(o,{redirect:l,status:r})},L=function(t,r){var n=e._googlesitekitLegacyData.admin.adminRoot;return t||(t="googlesitekit-dashboard"),r=A({page:t},r),Object(h.a)(n,r)},M=function(e){try{return JSON.parse(e)&&!!e}catch(e){return!1}},G=function(){var e=c()(o.a.mark((function e(t,r,n){var i,a,c,u,s=arguments;return o.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return i=s.length>3&&void 0!==s[3]?s[3]:_.c,a=s.length>4&&void 0!==s[4]?s[4]:q,e.next=4,t.setModuleActive(r,n);case 4:return c=e.sent,(u=a())[r]&&(u[r].active=n),e.next=9,i("".concat(r,"_setup"),n?"module_activate":"module_deactivate",r);case 9:return e.abrupt("return",c);case 10:case"end":return e.stop()}}),e)})));return function(t,r,n){return e.apply(this,arguments)}}(),H=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};Object(b.b)("googlesitekit.ErrorNotification","googlesitekit.ErrorNotification",Object(O.b)(e,t),1)},U=function(e){if(!e)return"";var t=e.replace(/&#(\d+);/g,(function(e,t){return String.fromCharCode(t)})).replace(/(\\)/g,"");return Object(p.unescape)(t)};function B(t,r){var i=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"33",o=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"33",a=arguments.length>4&&void 0!==arguments[4]?arguments[4]:"";if(e._googlesitekitLegacyData){var c=n.createElement(m.a,{id:t,width:i,height:o,className:a});return r?c=n.createElement(m.a,{id:"".concat(t,"-disabled"),width:i,height:o,className:a}):"pagespeed-insights"===t&&(c=n.createElement("img",{src:e._googlesitekitLegacyData.admin.assetsRoot+"images/icon-pagespeed.png",width:i,alt:"",className:a})),c}}function K(t){var r=arguments.length>1&&void 0!==arguments[1]?arguments[1]:e._googlesitekitBaseData,n=r.blogPrefix,i=r.isNetworkMode;return i?t:n+t}}).call(this,r(15),r(12))},50:function(e,t,r){"use strict";(function(e){r.d(t,"a",(function(){return g})),r.d(t,"b",(function(){return f})),r.d(t,"c",(function(){return d}));var n=r(66),i=e._googlesitekitBaseData||{},o=i.isFirstAdmin,a=i.trackingAllowed,c={isFirstAdmin:o,trackingEnabled:i.trackingEnabled,trackingID:i.trackingID,referenceSiteURL:i.referenceSiteURL,userIDHash:i.userIDHash},u=Object(n.a)(c),s=u.enableTracking,l=u.disableTracking,g=u.isTrackingEnabled,d=u.trackEvent;function f(e){e?s():l()}!0===a&&f(g())}).call(this,r(15))},52:function(e,t,r){"use strict";r.d(t,"a",(function(){return i}));var n=r(35);function i(e){return function(){e[n.a]=e[n.a]||[],e[n.a].push(arguments)}}},54:function(e,t,r){"use strict";r.d(t,"a",(function(){return i}));var n=r(76),i=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};return{__html:n.a.sanitize(e,t)}}},55:function(e,t,r){"use strict";(function(e){r.d(t,"a",(function(){return u})),r.d(t,"b",(function(){return s})),r.d(t,"c",(function(){return g}));var n=r(38),i=r.n(n),o=r(0);function a(e,t){var r;if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(r=function(e,t){if(!e)return;if("string"==typeof e)return c(e,t);var r=Object.prototype.toString.call(e).slice(8,-1);"Object"===r&&e.constructor&&(r=e.constructor.name);if("Map"===r||"Set"===r)return Array.from(e);if("Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r))return c(e,t)}(e))||t&&e&&"number"==typeof e.length){r&&(e=r);var n=0,i=function(){};return{s:i,n:function(){return n>=e.length?{done:!0}:{done:!1,value:e[n++]}},e:function(e){throw e},f:i}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var o,a=!0,u=!1;return{s:function(){r=e[Symbol.iterator]()},n:function(){var e=r.next();return a=e.done,e},e:function(e){u=!0,o=e},f:function(){try{a||null==r.return||r.return()}finally{if(u)throw o}}}}function c(e,t){(null==t||t>e.length)&&(t=e.length);for(var r=0,n=new Array(t);r<t;r++)n[r]=e[r];return n}var u=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:0,t=null,r=null,n=document.querySelector("#toplevel_page_googlesitekit-dashboard .googlesitekit-notifications-counter"),i=document.querySelector("#wp-admin-bar-google-site-kit .googlesitekit-notifications-counter");if(n&&i)return!1;if(t=document.querySelector("#toplevel_page_googlesitekit-dashboard .wp-menu-name"),r=document.querySelector("#wp-admin-bar-google-site-kit .ab-item"),null===t&&null===r)return!1;var a=document.createElement("span");a.setAttribute("class","googlesitekit-notifications-counter update-plugins count-".concat(e));var c=document.createElement("span");c.setAttribute("class","plugin-count"),c.setAttribute("aria-hidden","true"),c.textContent=e;var u=document.createElement("span");return u.setAttribute("class","screen-reader-text"),u.textContent=Object(o.sprintf)(Object(o._n)("%d notification","%d notifications",e,"google-site-kit"),e),a.appendChild(c),a.appendChild(u),t&&null===n&&t.appendChild(a),r&&null===i&&r.appendChild(a),a},s=function(){e.localStorage&&e.localStorage.clear(),e.sessionStorage&&e.sessionStorage.clear()},l=function(e){for(var t=location.search.substr(1).split("&"),r={},n=0;n<t.length;n++)r[t[n].split("=")[0]]=decodeURIComponent(t[n].split("=")[1]);return e?r.hasOwnProperty(e)?decodeURIComponent(r[e].replace(/\+/g," ")):"":r},g=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:location,r=new URL(t.href);if(e)return r.searchParams&&r.searchParams.get?r.searchParams.get(e):l(e);var n,o={},c=a(r.searchParams.entries());try{for(c.s();!(n=c.n()).done;){var u=i()(n.value,2),s=u[0],g=u[1];o[s]=g}}catch(e){c.e(e)}finally{c.f()}return o}}).call(this,r(15))},56:function(e,t,r){"use strict";r.d(t,"a",(function(){return c}));var n=r(33),i=r.n(n),o=r(102),a=r.n(o),c=function(e){return a()(JSON.stringify(function e(t){var r={};return Object.keys(t).sort().forEach((function(n){var o=t[n];o&&"object"===i()(o)&&!Array.isArray(o)&&(o=e(o)),r[n]=o})),r}(e)))}},58:function(e,t,r){"use strict";r.d(t,"b",(function(){return n})),r.d(t,"c",(function(){return i})),r.d(t,"a",(function(){return o}));var n={BOXES:"boxes",COMPOSITE:"composite"},i={QUARTER:"quarter",HALF:"half",FULL:"full"},o="core/widgets"},60:function(e,t,r){"use strict";(function(e){r.d(t,"a",(function(){return c})),r.d(t,"b",(function(){return u}));var n=r(44),i=r.n(n),o=r(13),a=r(0);function c(){Object(a.setLocaleData)(e._googlesitekitLegacyData.locale,"google-site-kit")}var u=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},r=t.locale,n=void 0===r?s():r,o=i()(t,["locale"]);return new Intl.NumberFormat(n,o).format(e)},s=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:e,r=Object(o.get)(t,["_googlesitekitLegacyData","locale","","lang"]);if(r){var n=r.match(/^(\w{2})?(_)?(\w{2})/);if(n&&n[0])return n[0].replace(/_/g,"-")}return t.navigator.language}}).call(this,r(15))},622:function(e,t,r){"use strict";r.r(t),function(e){var n=r(148),i=r(285),o=r(5);void 0===e.googlesitekit&&(e.googlesitekit={}),void 0===e.googlesitekit.widgets&&(e.googlesitekit.widgets=i.a),Object(n.a)((function(){Object(o.o)(),Object(i.b)(i.a)})),t.default=i.a}.call(this,r(15))},66:function(e,t,r){"use strict";(function(e){r.d(t,"a",(function(){return l}));var n=r(10),i=r.n(n),o=r(67),a=r(68);function c(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function u(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?c(Object(r),!0).forEach((function(t){i()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):c(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}var s={isFirstAdmin:!1,trackingEnabled:!1,trackingID:"",referenceSiteURL:"",userIDHash:""};function l(t){var r=arguments.length>1&&void 0!==arguments[1]?arguments[1]:e,n=u(u({},s),t);return n.referenceSiteURL&&(n.referenceSiteURL=n.referenceSiteURL.toString().replace(/\/+$/,"")),{enableTracking:Object(o.a)(n,r),disableTracking:function(){n.trackingEnabled=!1},isTrackingEnabled:function(){return!!n.trackingEnabled},trackEvent:Object(a.a)(n,r)}}}).call(this,r(15))},67:function(e,t,r){"use strict";(function(e){r.d(t,"a",(function(){return o}));var n=r(52),i=r(35);function o(t,r){var o=Object(n.a)(r);return function(){t.trackingEnabled=!0;var r=e.document;if(!r.querySelector("script[".concat(i.b,"]"))){var n=r.createElement("script");n.setAttribute(i.b,""),n.async=!0,n.src="https://www.googletagmanager.com/gtag/js?id=".concat(t.trackingID,"&l=").concat(i.a),r.head.appendChild(n),o("js",new Date),o("config",t.trackingID)}}}}).call(this,r(15))},68:function(e,t,r){"use strict";(function(e){r.d(t,"a",(function(){return d}));var n=r(4),i=r.n(n),o=r(10),a=r.n(o),c=r(14),u=r.n(c),s=r(52);function l(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function g(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?l(Object(r),!0).forEach((function(t){a()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):l(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function d(t,r){var n=Object(s.a)(r);return function(){var r=u()(i.a.mark((function r(o,a){var c,u,s,l,d,f,p,b,v=arguments;return i.a.wrap((function(r){for(;;)switch(r.prev=r.next){case 0:if(c=v.length>2&&void 0!==v[2]?v[2]:"",u=v.length>3&&void 0!==v[3]?v[3]:"",s=t.isFirstAdmin,l=t.referenceSiteURL,d=t.trackingEnabled,f=t.trackingID,p=t.userIDHash,d){r.next=5;break}return r.abrupt("return");case 5:return b={send_to:f,event_category:o,event_label:c,event_value:u,dimension1:l,dimension2:s?"true":"false",dimension3:p},r.abrupt("return",new Promise((function(t){var r=setTimeout((function(){e.console.warn('Tracking event "'.concat(a,'" (category "').concat(o,'") took too long to fire.')),t()}),1e3);n("event",a,g(g({},b),{},{event_callback:function(){clearTimeout(r),t()}}))})));case 7:case"end":return r.stop()}}),r)})));return function(e,t){return r.apply(this,arguments)}}()}}).call(this,r(15))},76:function(e,t,r){"use strict";(function(e){r.d(t,"a",(function(){return i}));var n=r(101),i=r.n(n)()(e)}).call(this,r(15))}});