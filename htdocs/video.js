/*! Video.js v4.7.1 Copyright 2014 Brightcove, Inc. https://github.com/videojs/video.js/blob/master/LICENSE */

(function() {
    var b = void 0, f = !0, k = null, l = !1;
    function m() {
        return function() {
        }
    }
    function p(a) {
        return function() {
            return this[a]
        }
    }
    function r(a) {
        return function() {
            return a
        }
    }
    var s;
    document.createElement("video");
    document.createElement("audio");
    document.createElement("track");
    function t(a, c, d) {
        if ("string" === typeof a) {
            0 === a.indexOf("#") && (a = a.slice(1));
            if (t.Ca[a])
                return t.Ca[a];
            a = t.w(a)
        }
        if (!a || !a.nodeName)
            throw new TypeError("The element or ID supplied is not valid. (videojs)");
        return a.player || new t.Player(a, c, d)
    }
    var videojs = window.videojs = t;
    t.Wb = "4.7";
    t.Tc = "https:" == document.location.protocol ? "https://" : "http://";
    t.options = {techOrder: ["html5", "flash"], html5: {}, flash: {}, width: 300, height: 150, defaultVolume: 0, playbackRates: [], children: {mediaLoader: {}, posterImage: {}, textTrackDisplay: {}, loadingSpinner: {}, bigPlayButton: {}, controlBar: {}, errorDisplay: {}}, language: document.getElementsByTagName("html")[0].getAttribute("lang") || navigator.Wa && navigator.Wa[0] || navigator.te || navigator.language || "en", languages: {}, notSupportedMessage: "No compatible source was found for this video."};
    "GENERATED_CDN_VSN" !== t.Wb && (videojs.options.flash.swf = t.Tc + "vjs.zencdn.net/" + t.Wb + "/video-js.swf");
    t.Ca = {};
    "function" === typeof define && define.amd ? define([], function() {
        return videojs
    }) : "object" === typeof exports && "object" === typeof module && (module.exports = videojs);
    t.ra = t.CoreObject = m();
    t.ra.extend = function(a) {
        var c, d;
        a = a || {};
        c = a.init || a.j || this.prototype.init || this.prototype.j || m();
        d = function() {
            c.apply(this, arguments)
        };
        d.prototype = t.h.create(this.prototype);
        d.prototype.constructor = d;
        d.extend = t.ra.extend;
        d.create = t.ra.create;
        for (var e in a)
            a.hasOwnProperty(e) && (d.prototype[e] = a[e]);
        return d
    };
    t.ra.create = function() {
        var a = t.h.create(this.prototype);
        this.apply(a, arguments);
        return a
    };
    t.d = function(a, c, d) {
        if (t.h.isArray(c))
            return u(t.d, a, c, d);
        var e = t.getData(a);
        e.F || (e.F = {});
        e.F[c] || (e.F[c] = []);
        d.z || (d.z = t.z++);
        e.F[c].push(d);
        e.Y || (e.disabled = l, e.Y = function(c) {
            if (!e.disabled) {
                c = t.rc(c);
                var d = e.F[c.type];
                if (d)
                    for (var d = d.slice(0), j = 0, n = d.length; j < n && !c.yc(); j++)
                        d[j].call(a, c)
            }
        });
        1 == e.F[c].length && (a.addEventListener ? a.addEventListener(c, e.Y, l) : a.attachEvent && a.attachEvent("on" + c, e.Y))
    };
    t.p = function(a, c, d) {
        if (t.uc(a)) {
            var e = t.getData(a);
            if (e.F) {
                if (t.h.isArray(c))
                    return u(t.p, a, c, d);
                if (c) {
                    var g = e.F[c];
                    if (g) {
                        if (d) {
                            if (d.z)
                                for (e = 0; e < g.length; e++)
                                    g[e].z === d.z && g.splice(e--, 1)
                        } else
                            e.F[c] = [];
                        t.lc(a, c)
                    }
                } else
                    for (g in e.F)
                        c = g, e.F[c] = [], t.lc(a, c)
            }
        }
    };
    t.lc = function(a, c) {
        var d = t.getData(a);
        0 === d.F[c].length && (delete d.F[c], a.removeEventListener ? a.removeEventListener(c, d.Y, l) : a.detachEvent && a.detachEvent("on" + c, d.Y));
        t.Ib(d.F) && (delete d.F, delete d.Y, delete d.disabled);
        t.Ib(d) && t.Fc(a)
    };
    t.rc = function(a) {
        function c() {
            return f
        }
        function d() {
            return l
        }
        if (!a || !a.Jb) {
            var e = a || window.event;
            a = {};
            for (var g in e)
                "layerX" !== g && ("layerY" !== g && "keyboardEvent.keyLocation" !== g) && ("returnValue" == g && e.preventDefault || (a[g] = e[g]));
            a.target || (a.target = a.srcElement || document);
            a.relatedTarget = a.fromElement === a.target ? a.toElement : a.fromElement;
            a.preventDefault = function() {
                e.preventDefault && e.preventDefault();
                a.returnValue = l;
                a.yd = c;
                a.defaultPrevented = f
            };
            a.yd = d;
            a.defaultPrevented = l;
            a.stopPropagation = function() {
                e.stopPropagation &&
                        e.stopPropagation();
                a.cancelBubble = f;
                a.Jb = c
            };
            a.Jb = d;
            a.stopImmediatePropagation = function() {
                e.stopImmediatePropagation && e.stopImmediatePropagation();
                a.yc = c;
                a.stopPropagation()
            };
            a.yc = d;
            if (a.clientX != k) {
                g = document.documentElement;
                var h = document.body;
                a.pageX = a.clientX + (g && g.scrollLeft || h && h.scrollLeft || 0) - (g && g.clientLeft || h && h.clientLeft || 0);
                a.pageY = a.clientY + (g && g.scrollTop || h && h.scrollTop || 0) - (g && g.clientTop || h && h.clientTop || 0)
            }
            a.which = a.charCode || a.keyCode;
            a.button != k && (a.button = a.button & 1 ? 0 : a.button &
                    4 ? 1 : a.button & 2 ? 2 : 0)
        }
        return a
    };
    t.l = function(a, c) {
        var d = t.uc(a) ? t.getData(a) : {}, e = a.parentNode || a.ownerDocument;
        "string" === typeof c && (c = {type: c, target: a});
        c = t.rc(c);
        d.Y && d.Y.call(a, c);
        if (e && !c.Jb() && c.bubbles !== l)
            t.l(e, c);
        else if (!e && !c.defaultPrevented && (d = t.getData(c.target), c.target[c.type])) {
            d.disabled = f;
            if ("function" === typeof c.target[c.type])
                c.target[c.type]();
            d.disabled = l
        }
        return!c.defaultPrevented
    };
    t.V = function(a, c, d) {
        function e() {
            t.p(a, c, e);
            d.apply(this, arguments)
        }
        if (t.h.isArray(c))
            return u(t.V, a, c, d);
        e.z = d.z = d.z || t.z++;
        t.d(a, c, e)
    };
    function u(a, c, d, e) {
        t.jc.forEach(d, function(d) {
            a(c, d, e)
        })
    }
    var w = Object.prototype.hasOwnProperty;
    t.e = function(a, c) {
        var d;
        c = c || {};
        d = document.createElement(a || "div");
        t.h.Z(c, function(a, c) {
            -1 !== a.indexOf("aria-") || "role" == a ? d.setAttribute(a, c) : d[a] = c
        });
        return d
    };
    t.ba = function(a) {
        return a.charAt(0).toUpperCase() + a.slice(1)
    };
    t.h = {};
    t.h.create = Object.create || function(a) {
        function c() {
        }
        c.prototype = a;
        return new c
    };
    t.h.Z = function(a, c, d) {
        for (var e in a)
            w.call(a, e) && c.call(d || this, e, a[e])
    };
    t.h.A = function(a, c) {
        if (!c)
            return a;
        for (var d in c)
            w.call(c, d) && (a[d] = c[d]);
        return a
    };
    t.h.md = function(a, c) {
        var d, e, g;
        a = t.h.copy(a);
        for (d in c)
            w.call(c, d) && (e = a[d], g = c[d], a[d] = t.h.Ua(e) && t.h.Ua(g) ? t.h.md(e, g) : c[d]);
        return a
    };
    t.h.copy = function(a) {
        return t.h.A({}, a)
    };
    t.h.Ua = function(a) {
        return!!a && "object" === typeof a && "[object Object]" === a.toString() && a.constructor === Object
    };
    t.h.isArray = Array.isArray || function(a) {
        return"[object Array]" === Object.prototype.toString.call(a)
    };
    t.bind = function(a, c, d) {
        function e() {
            return c.apply(a, arguments)
        }
        c.z || (c.z = t.z++);
        e.z = d ? d + "_" + c.z : c.z;
        return e
    };
    t.va = {};
    t.z = 1;
    t.expando = "vdata" + (new Date).getTime();
    t.getData = function(a) {
        var c = a[t.expando];
        c || (c = a[t.expando] = t.z++, t.va[c] = {});
        return t.va[c]
    };
    t.uc = function(a) {
        a = a[t.expando];
        return!(!a || t.Ib(t.va[a]))
    };
    t.Fc = function(a) {
        var c = a[t.expando];
        if (c) {
            delete t.va[c];
            try {
                delete a[t.expando]
            } catch (d) {
                a.removeAttribute ? a.removeAttribute(t.expando) : a[t.expando] = k
            }
        }
    };
    t.Ib = function(a) {
        for (var c in a)
            if (a[c] !== k)
                return l;
        return f
    };
    t.n = function(a, c) {
        -1 == (" " + a.className + " ").indexOf(" " + c + " ") && (a.className = "" === a.className ? c : a.className + " " + c)
    };
    t.q = function(a, c) {
        var d, e;
        if (-1 != a.className.indexOf(c)) {
            d = a.className.split(" ");
            for (e = d.length - 1; 0 <= e; e--)
                d[e] === c && d.splice(e, 1);
            a.className = d.join(" ")
        }
    };
    t.B = t.e("video");
    t.M = navigator.userAgent;
    t.Zc = /iPhone/i.test(t.M);
    t.Yc = /iPad/i.test(t.M);
    t.$c = /iPod/i.test(t.M);
    t.Xc = t.Zc || t.Yc || t.$c;
    var aa = t, x;
    var y = t.M.match(/OS (\d+)_/i);
    x = y && y[1] ? y[1] : b;
    aa.ke = x;
    t.Vc = /Android/i.test(t.M);
    var ba = t, z;
    var A = t.M.match(/Android (\d+)(?:\.(\d+))?(?:\.(\d+))*/i), B, C;
    A ? (B = A[1] && parseFloat(A[1]), C = A[2] && parseFloat(A[2]), z = B && C ? parseFloat(A[1] + "." + A[2]) : B ? B : k) : z = k;
    ba.Vb = z;
    t.ad = t.Vc && /webkit/i.test(t.M) && 2.3 > t.Vb;
    t.Wc = /Firefox/i.test(t.M);
    t.le = /Chrome/i.test(t.M);
    t.fc = !!("ontouchstart"in window || window.Uc && document instanceof window.Uc);
    t.Hc = function(a, c) {
        t.h.Z(c, function(c, e) {
            e === k || "undefined" === typeof e || e === l ? a.removeAttribute(c) : a.setAttribute(c, e === f ? "" : e)
        })
    };
    t.Aa = function(a) {
        var c, d, e, g;
        c = {};
        if (a && a.attributes && 0 < a.attributes.length) {
            d = a.attributes;
            for (var h = d.length - 1; 0 <= h; h--) {
                e = d[h].name;
                g = d[h].value;
                if ("boolean" === typeof a[e] || -1 !== ",autoplay,controls,loop,muted,default,".indexOf("," + e + ","))
                    g = g !== k ? f : l;
                c[e] = g
            }
        }
        return c
    };
    t.ne = function(a, c) {
        var d = "";
        document.defaultView && document.defaultView.getComputedStyle ? d = document.defaultView.getComputedStyle(a, "").getPropertyValue(c) : a.currentStyle && (d = a["client" + c.substr(0, 1).toUpperCase() + c.substr(1)] + "px");
        return d
    };
    t.Hb = function(a, c) {
        c.firstChild ? c.insertBefore(a, c.firstChild) : c.appendChild(a)
    };
    t.Qa = {};
    t.w = function(a) {
        0 === a.indexOf("#") && (a = a.slice(1));
        return document.getElementById(a)
    };
    t.za = function(a, c) {
        c = c || a;
        var d = Math.floor(a % 60), e = Math.floor(a / 60 % 60), g = Math.floor(a / 3600), h = Math.floor(c / 60 % 60), j = Math.floor(c / 3600);
        if (isNaN(a) || Infinity === a)
            g = e = d = "-";
        g = 0 < g || 0 < j ? g + ":" : "";
        return g + (((g || 10 <= h) && 10 > e ? "0" + e : e) + ":") + (10 > d ? "0" + d : d)
    };
    t.gd = function() {
        document.body.focus();
        document.onselectstart = r(l)
    };
    t.ge = function() {
        document.onselectstart = r(f)
    };
    t.trim = function(a) {
        return(a + "").replace(/^\s+|\s+$/g, "")
    };
    t.round = function(a, c) {
        c || (c = 0);
        return Math.round(a * Math.pow(10, c)) / Math.pow(10, c)
    };
    t.Ab = function(a, c) {
        return{length: 1, start: function() {
                return a
            }, end: function() {
                return c
            }}
    };
    t.get = function(a, c, d, e) {
        var g, h, j, n;
        d = d || m();
        "undefined" === typeof XMLHttpRequest && (window.XMLHttpRequest = function() {
            try {
                return new window.ActiveXObject("Msxml2.XMLHTTP.6.0")
            } catch (a) {
            }
            try {
                return new window.ActiveXObject("Msxml2.XMLHTTP.3.0")
            } catch (c) {
            }
            try {
                return new window.ActiveXObject("Msxml2.XMLHTTP")
            } catch (d) {
            }
            throw Error("This browser does not support XMLHttpRequest.");
        });
        h = new XMLHttpRequest;
        j = t.Sd(a);
        n = window.location;
        j.protocol + j.host !== n.protocol + n.host && window.XDomainRequest && !("withCredentials"in
                h) ? (h = new window.XDomainRequest, h.onload = function() {
            c(h.responseText)
        }, h.onerror = d, h.onprogress = m(), h.ontimeout = d) : (g = "file:" == j.protocol || "file:" == n.protocol, h.onreadystatechange = function() {
            4 === h.readyState && (200 === h.status || g && 0 === h.status ? c(h.responseText) : d(h.responseText))
        });
        try {
            h.open("GET", a, f), e && (h.withCredentials = f)
        } catch (q) {
            d(q);
            return
        }
        try {
            h.send()
        } catch (v) {
            d(v)
        }
    };
    t.Xd = function(a) {
        try {
            var c = window.localStorage || l;
            c && (c.volume = a)
        } catch (d) {
            22 == d.code || 1014 == d.code ? t.log("LocalStorage Full (VideoJS)", d) : 18 == d.code ? t.log("LocalStorage not allowed (VideoJS)", d) : t.log("LocalStorage Error (VideoJS)", d)
        }
    };
    t.tc = function(a) {
        a.match(/^https?:\/\//) || (a = t.e("div", {innerHTML: '<a href="' + a + '">x</a>'}).firstChild.href);
        return a
    };
    t.Sd = function(a) {
        var c, d, e, g;
        g = "protocol hostname port pathname search hash host".split(" ");
        d = t.e("a", {href: a});
        if (e = "" === d.host && "file:" !== d.protocol)
            c = t.e("div"), c.innerHTML = '<a href="' + a + '"></a>', d = c.firstChild, c.setAttribute("style", "display:none; position:absolute;"), document.body.appendChild(c);
        a = {};
        for (var h = 0; h < g.length; h++)
            a[g[h]] = d[g[h]];
        e && document.body.removeChild(c);
        return a
    };
    function D() {
    }
    var E = window.console || {log: D, warn: D, error: D};
    function F(a, c) {
        var d = Array.prototype.slice.call(c);
        a ? d.unshift(a.toUpperCase() + ":") : a = "log";
        t.log.history.push(d);
        d.unshift("VIDEOJS:");
        if (E[a].apply)
            E[a].apply(E, d);
        else
            E[a](d.join(" "))
    }
    t.log = function() {
        F(k, arguments)
    };
    t.log.history = [];
    t.log.error = function() {
        F("error", arguments)
    };
    t.log.warn = function() {
        F("warn", arguments)
    };
    t.ud = function(a) {
        var c, d;
        a.getBoundingClientRect && a.parentNode && (c = a.getBoundingClientRect());
        if (!c)
            return{left: 0, top: 0};
        a = document.documentElement;
        d = document.body;
        return{left: t.round(c.left + (window.pageXOffset || d.scrollLeft) - (a.clientLeft || d.clientLeft || 0)), top: t.round(c.top + (window.pageYOffset || d.scrollTop) - (a.clientTop || d.clientTop || 0))}
    };
    t.jc = {};
    t.jc.forEach = function(a, c, d) {
        if (t.h.isArray(a) && c instanceof Function)
            for (var e = 0, g = a.length; e < g; ++e)
                c.call(d || t, a[e], e, a);
        return a
    };
    t.qa = {};
    t.qa.Nb = function(a, c) {
        var d, e, g;
        a = t.h.copy(a);
        for (d in c)
            c.hasOwnProperty(d) && (e = a[d], g = c[d], a[d] = t.h.Ua(e) && t.h.Ua(g) ? t.qa.Nb(e, g) : c[d]);
        return a
    };
    t.a = t.ra.extend({j: function(a, c, d) {
            this.c = a;
            this.k = t.h.copy(this.k);
            c = this.options(c);
            this.U = c.id || (c.el && c.el.id ? c.el.id : a.id() + "_component_" + t.z++);
            this.Fd = c.name || k;
            this.b = c.el || this.e();
            this.N = [];
            this.Ra = {};
            this.Sa = {};
            this.wc();
            this.J(d);
            if (c.Gc !== l) {
                var e, g;
                e = t.bind(this.m(), this.m().reportUserActivity);
                this.d("touchstart", function() {
                    e();
                    clearInterval(g);
                    g = setInterval(e, 250)
                });
                a = function() {
                    e();
                    clearInterval(g)
                };
                this.d("touchmove", e);
                this.d("touchend", a);
                this.d("touchcancel", a)
            }
        }});
    s = t.a.prototype;
    s.dispose = function() {
        this.l({type: "dispose", bubbles: l});
        if (this.N)
            for (var a = this.N.length - 1; 0 <= a; a--)
                this.N[a].dispose && this.N[a].dispose();
        this.Sa = this.Ra = this.N = k;
        this.p();
        this.b.parentNode && this.b.parentNode.removeChild(this.b);
        t.Fc(this.b);
        this.b = k
    };
    s.c = f;
    s.m = p("c");
    s.options = function(a) {
        return a === b ? this.k : this.k = t.qa.Nb(this.k, a)
    };
    s.e = function(a, c) {
        return t.e(a, c)
    };
    s.s = function(a) {
        var c = this.c.language(), d = this.c.Wa();
        return d && d[c] && d[c][a] ? d[c][a] : a
    };
    s.w = p("b");
    s.ja = function() {
        return this.v || this.b
    };
    s.id = p("U");
    s.name = p("Fd");
    s.children = p("N");
    s.wd = function(a) {
        return this.Ra[a]
    };
    s.ka = function(a) {
        return this.Sa[a]
    };
    s.R = function(a, c) {
        var d, e;
        "string" === typeof a ? (e = a, c = c || {}, d = c.componentClass || t.ba(e), c.name = e, d = new window.videojs[d](this.c || this, c)) : d = a;
        this.N.push(d);
        "function" === typeof d.id && (this.Ra[d.id()] = d);
        (e = e || d.name && d.name()) && (this.Sa[e] = d);
        "function" === typeof d.el && d.el() && this.ja().appendChild(d.el());
        return d
    };
    s.removeChild = function(a) {
        "string" === typeof a && (a = this.ka(a));
        if (a && this.N) {
            for (var c = l, d = this.N.length - 1; 0 <= d; d--)
                if (this.N[d] === a) {
                    c = f;
                    this.N.splice(d, 1);
                    break
                }
            c && (this.Ra[a.id] = k, this.Sa[a.name] = k, (c = a.w()) && c.parentNode === this.ja() && this.ja().removeChild(a.w()))
        }
    };
    s.wc = function() {
        var a, c, d, e;
        a = this;
        if (c = this.options().children)
            if (t.h.isArray(c))
                for (var g = 0; g < c.length; g++)
                    d = c[g], "string" == typeof d ? (e = d, d = {}) : e = d.name, a[e] = a.R(e, d);
            else
                t.h.Z(c, function(c, d) {
                    d !== l && (a[c] = a.R(c, d))
                })
    };
    s.T = r("");
    s.d = function(a, c) {
        t.d(this.b, a, t.bind(this, c));
        return this
    };
    s.p = function(a, c) {
        t.p(this.b, a, c);
        return this
    };
    s.V = function(a, c) {
        t.V(this.b, a, t.bind(this, c));
        return this
    };
    s.l = function(a) {
        t.l(this.b, a);
        return this
    };
    s.J = function(a) {
        a && (this.la ? a.call(this) : (this.cb === b && (this.cb = []), this.cb.push(a)));
        return this
    };
    s.Ha = function() {
        this.la = f;
        var a = this.cb;
        if (a && 0 < a.length) {
            for (var c = 0, d = a.length; c < d; c++)
                a[c].call(this);
            this.cb = [];
            this.l("ready")
        }
    };
    s.n = function(a) {
        t.n(this.b, a);
        return this
    };
    s.q = function(a) {
        t.q(this.b, a);
        return this
    };
    s.show = function() {
        this.b.style.display = "block";
        return this
    };
    s.X = function() {
        this.b.style.display = "none";
        return this
    };
    function G(a) {
        a.q("vjs-lock-showing")
    }
    s.disable = function() {
        this.X();
        this.show = m()
    };
    s.width = function(a, c) {
        return H(this, "width", a, c)
    };
    s.height = function(a, c) {
        return H(this, "height", a, c)
    };
    s.pd = function(a, c) {
        return this.width(a, f).height(c)
    };
    function H(a, c, d, e) {
        if (d !== b)
            return a.b.style[c] = -1 !== ("" + d).indexOf("%") || -1 !== ("" + d).indexOf("px") ? d : "auto" === d ? "" : d + "px", e || a.l("resize"), a;
        if (!a.b)
            return 0;
        d = a.b.style[c];
        e = d.indexOf("px");
        return-1 !== e ? parseInt(d.slice(0, e), 10) : parseInt(a.b["offset" + t.ba(c)], 10)
    }
    function I(a) {
        var c, d, e, g, h, j, n, q;
        c = 0;
        d = k;
        a.d("touchstart", function(a) {
            1 === a.touches.length && (d = a.touches[0], c = (new Date).getTime(), g = f)
        });
        a.d("touchmove", function(a) {
            1 < a.touches.length ? g = l : d && (j = a.touches[0].pageX - d.pageX, n = a.touches[0].pageY - d.pageY, q = Math.sqrt(j * j + n * n), 22 < q && (g = l))
        });
        h = function() {
            g = l
        };
        a.d("touchleave", h);
        a.d("touchcancel", h);
        a.d("touchend", function(a) {
            d = k;
            g === f && (e = (new Date).getTime() - c, 250 > e && (a.preventDefault(), this.l("tap")))
        })
    }
    t.t = t.a.extend({j: function(a, c) {
            t.a.call(this, a, c);
            I(this);
            this.d("tap", this.r);
            this.d("click", this.r);
            this.d("focus", this.Za);
            this.d("blur", this.Ya)
        }});
    s = t.t.prototype;
    s.e = function(a, c) {
        var d;
        c = t.h.A({className: this.T(), role: "button", "aria-live": "polite", tabIndex: 0}, c);
        d = t.a.prototype.e.call(this, a, c);
        c.innerHTML || (this.v = t.e("div", {className: "vjs-control-content"}), this.yb = t.e("span", {className: "vjs-control-text", innerHTML: this.s(this.ua) || "Need Text"}), this.v.appendChild(this.yb), d.appendChild(this.v));
        return d
    };
    s.T = function() {
        return"vjs-control " + t.a.prototype.T.call(this)
    };
    s.r = m();
    s.Za = function() {
        t.d(document, "keyup", t.bind(this, this.ea))
    };
    s.ea = function(a) {
        if (32 == a.which || 13 == a.which)
            a.preventDefault(), this.r()
    };
    s.Ya = function() {
        t.p(document, "keyup", t.bind(this, this.ea))
    };
    t.Q = t.a.extend({j: function(a, c) {
            t.a.call(this, a, c);
            this.fd = this.ka(this.k.barName);
            this.handle = this.ka(this.k.handleName);
            this.d("mousedown", this.$a);
            this.d("touchstart", this.$a);
            this.d("focus", this.Za);
            this.d("blur", this.Ya);
            this.d("click", this.r);
            this.c.d("controlsvisible", t.bind(this, this.update));
            a.d(this.Cc, t.bind(this, this.update));
            this.S = {};
            this.S.move = t.bind(this, this.ab);
            this.S.end = t.bind(this, this.Ob)
        }});
    s = t.Q.prototype;
    s.e = function(a, c) {
        c = c || {};
        c.className += " vjs-slider";
        c = t.h.A({role: "slider", "aria-valuenow": 0, "aria-valuemin": 0, "aria-valuemax": 100, tabIndex: 0}, c);
        return t.a.prototype.e.call(this, a, c)
    };
    s.$a = function(a) {
        a.preventDefault();
        t.gd();
        this.n("vjs-sliding");
        t.d(document, "mousemove", this.S.move);
        t.d(document, "mouseup", this.S.end);
        t.d(document, "touchmove", this.S.move);
        t.d(document, "touchend", this.S.end);
        this.ab(a)
    };
    s.ab = m();
    s.Ob = function() {
        t.ge();
        this.q("vjs-sliding");
        t.p(document, "mousemove", this.S.move, l);
        t.p(document, "mouseup", this.S.end, l);
        t.p(document, "touchmove", this.S.move, l);
        t.p(document, "touchend", this.S.end, l);
        this.update()
    };
    s.update = function() {
        if (this.b) {
            var a, c = this.Gb(), d = this.handle, e = this.fd;
            isNaN(c) && (c = 0);
            a = c;
            if (d) {
                a = this.b.offsetWidth;
                var g = d.w().offsetWidth;
                a = g ? g / a : 0;
                c *= 1 - a;
                a = c + a / 2;
                d.w().style.left = t.round(100 * c, 2) + "%"
            }
            e && (e.w().style.width = t.round(100 * a, 2) + "%")
        }
    };
    function J(a, c) {
        var d, e, g, h;
        d = a.b;
        e = t.ud(d);
        h = g = d.offsetWidth;
        d = a.handle;
        if (a.options().vertical)
            return h = e.top, e = c.changedTouches ? c.changedTouches[0].pageY : c.pageY, d && (d = d.w().offsetHeight, h += d / 2, g -= d), Math.max(0, Math.min(1, (h - e + g) / g));
        g = e.left;
        e = c.changedTouches ? c.changedTouches[0].pageX : c.pageX;
        d && (d = d.w().offsetWidth, g += d / 2, h -= d);
        return Math.max(0, Math.min(1, (e - g) / h))
    }
    s.Za = function() {
        t.d(document, "keyup", t.bind(this, this.ea))
    };
    s.ea = function(a) {
        if (37 == a.which || 40 == a.which)
            a.preventDefault(), this.Kc();
        else if (38 == a.which || 39 == a.which)
            a.preventDefault(), this.Lc()
    };
    s.Ya = function() {
        t.p(document, "keyup", t.bind(this, this.ea))
    };
    s.r = function(a) {
        a.stopImmediatePropagation();
        a.preventDefault()
    };
    t.$ = t.a.extend();
    t.$.prototype.defaultValue = 0;
    t.$.prototype.e = function(a, c) {
        c = c || {};
        c.className += " vjs-slider-handle";
        c = t.h.A({innerHTML: '<span class="vjs-control-text">' + this.defaultValue + "</span>"}, c);
        return t.a.prototype.e.call(this, "div", c)
    };
    t.ha = t.a.extend();
    function ca(a, c) {
        a.R(c);
        c.d("click", t.bind(a, function() {
            G(this)
        }))
    }
    t.ha.prototype.e = function() {
        var a = this.options().mc || "ul";
        this.v = t.e(a, {className: "vjs-menu-content"});
        a = t.a.prototype.e.call(this, "div", {append: this.v, className: "vjs-menu"});
        a.appendChild(this.v);
        t.d(a, "click", function(a) {
            a.preventDefault();
            a.stopImmediatePropagation()
        });
        return a
    };
    t.I = t.t.extend({j: function(a, c) {
            t.t.call(this, a, c);
            this.selected(c.selected)
        }});
    t.I.prototype.e = function(a, c) {
        return t.t.prototype.e.call(this, "li", t.h.A({className: "vjs-menu-item", innerHTML: this.k.label}, c))
    };
    t.I.prototype.r = function() {
        this.selected(f)
    };
    t.I.prototype.selected = function(a) {
        a ? (this.n("vjs-selected"), this.b.setAttribute("aria-selected", f)) : (this.q("vjs-selected"), this.b.setAttribute("aria-selected", l))
    };
    t.L = t.t.extend({j: function(a, c) {
            t.t.call(this, a, c);
            this.Ba = this.xa();
            this.R(this.Ba);
            this.O && 0 === this.O.length && this.X();
            this.d("keyup", this.ea);
            this.b.setAttribute("aria-haspopup", f);
            this.b.setAttribute("role", "button")
        }});
    s = t.L.prototype;
    s.ta = l;
    s.xa = function() {
        var a = new t.ha(this.c);
        this.options().title && a.ja().appendChild(t.e("li", {className: "vjs-menu-title", innerHTML: t.ba(this.options().title), de: -1}));
        if (this.O = this.createItems())
            for (var c = 0; c < this.O.length; c++)
                ca(a, this.O[c]);
        return a
    };
    s.wa = m();
    s.T = function() {
        return this.className + " vjs-menu-button " + t.t.prototype.T.call(this)
    };
    s.Za = m();
    s.Ya = m();
    s.r = function() {
        this.V("mouseout", t.bind(this, function() {
            G(this.Ba);
            this.b.blur()
        }));
        this.ta ? K(this) : L(this)
    };
    s.ea = function(a) {
        a.preventDefault();
        32 == a.which || 13 == a.which ? this.ta ? K(this) : L(this) : 27 == a.which && this.ta && K(this)
    };
    function L(a) {
        a.ta = f;
        a.Ba.n("vjs-lock-showing");
        a.b.setAttribute("aria-pressed", f);
        a.O && 0 < a.O.length && a.O[0].w().focus()
    }
    function K(a) {
        a.ta = l;
        G(a.Ba);
        a.b.setAttribute("aria-pressed", l)
    }
    t.G = function(a) {
        "number" === typeof a ? this.code = a : "string" === typeof a ? this.message = a : "object" === typeof a && t.h.A(this, a);
        this.message || (this.message = t.G.nd[this.code] || "")
    };
    t.G.prototype.code = 0;
    t.G.prototype.message = "";
    t.G.prototype.status = k;
    t.G.Ta = "MEDIA_ERR_CUSTOM MEDIA_ERR_ABORTED MEDIA_ERR_NETWORK MEDIA_ERR_DECODE MEDIA_ERR_SRC_NOT_SUPPORTED MEDIA_ERR_ENCRYPTED".split(" ");
    t.G.nd = {1: "You aborted the video playback", 2: "A network error caused the video download to fail part-way.", 3: "The video playback was aborted due to a corruption problem or because the video used features your browser did not support.", 4: "The video could not be loaded, either because the server or network failed or because the format is not supported.", 5: "The video is encrypted and we do not have the keys to decrypt it."};
    for (var M = 0; M < t.G.Ta.length; M++)
        t.G[t.G.Ta[M]] = M, t.G.prototype[t.G.Ta[M]] = M;
    var N, O, P, Q;
    N = ["requestFullscreen exitFullscreen fullscreenElement fullscreenEnabled fullscreenchange fullscreenerror".split(" "), "webkitRequestFullscreen webkitExitFullscreen webkitFullscreenElement webkitFullscreenEnabled webkitfullscreenchange webkitfullscreenerror".split(" "), "webkitRequestFullScreen webkitCancelFullScreen webkitCurrentFullScreenElement webkitCancelFullScreen webkitfullscreenchange webkitfullscreenerror".split(" "), "mozRequestFullScreen mozCancelFullScreen mozFullScreenElement mozFullScreenEnabled mozfullscreenchange mozfullscreenerror".split(" "), "msRequestFullscreen msExitFullscreen msFullscreenElement msFullscreenEnabled MSFullscreenChange MSFullscreenError".split(" ")];
    O = N[0];
    for (Q = 0; Q < N.length; Q++)
        if (N[Q][1]in document) {
            P = N[Q];
            break
        }
    if (P) {
        t.Qa.Fb = {};
        for (Q = 0; Q < P.length; Q++)
            t.Qa.Fb[O[Q]] = P[Q]
    }
    t.Player = t.a.extend({j: function(a, c, d) {
            this.P = a;
            a.id = a.id || "vjs_video_" + t.z++;
            this.ee = a && t.Aa(a);
            c = t.h.A(da(a), c);
            this.Va = c.language || t.options.language;
            this.Dd = c.languages || t.options.languages;
            this.C = {};
            this.Dc = c.poster;
            this.zb = c.controls;
            a.controls = l;
            c.Gc = l;
            t.a.call(this, this, c, d);
            this.controls() ? this.n("vjs-controls-enabled") : this.n("vjs-controls-disabled");
            t.Ca[this.U] = this;
            c.plugins && t.h.Z(c.plugins, function(a, c) {
                this[a](c)
            }, this);
            var e, g, h, j, n, q;
            e = t.bind(this, this.reportUserActivity);
            this.d("mousedown",
                    function() {
                        e();
                        clearInterval(g);
                        g = setInterval(e, 250)
                    });
            this.d("mousemove", function(a) {
                if (a.screenX != n || a.screenY != q)
                    n = a.screenX, q = a.screenY, e()
            });
            this.d("mouseup", function() {
                e();
                clearInterval(g)
            });
            this.d("keydown", e);
            this.d("keyup", e);
            h = setInterval(t.bind(this, function() {
                this.pa && (this.pa = l, this.userActive(f), clearTimeout(j), j = setTimeout(t.bind(this, function() {
                    this.pa || this.userActive(l)
                }), 2E3))
            }), 250);
            this.d("dispose", function() {
                clearInterval(h);
                clearTimeout(j)
            })
        }});
    s = t.Player.prototype;
    s.language = function(a) {
        if (a === b)
            return this.Va;
        this.Va = a;
        return this
    };
    s.Wa = p("Dd");
    s.k = t.options;
    s.dispose = function() {
        this.l("dispose");
        this.p("dispose");
        t.Ca[this.U] = k;
        this.P && this.P.player && (this.P.player = k);
        this.b && this.b.player && (this.b.player = k);
        clearInterval(this.bb);
        this.Ea();
        this.i && this.i.dispose();
        t.a.prototype.dispose.call(this)
    };
    function da(a) {
        var c = {sources: [], tracks: []};
        t.h.A(c, t.Aa(a));
        if (a.hasChildNodes()) {
            var d, e, g, h;
            a = a.childNodes;
            g = 0;
            for (h = a.length; g < h; g++)
                d = a[g], e = d.nodeName.toLowerCase(), "source" === e ? c.sources.push(t.Aa(d)) : "track" === e && c.tracks.push(t.Aa(d))
        }
        return c
    }
    s.e = function() {
        var a = this.b = t.a.prototype.e.call(this, "div"), c = this.P, d;
        c.removeAttribute("width");
        c.removeAttribute("height");
        if (c.hasChildNodes()) {
            var e, g, h, j, n;
            e = c.childNodes;
            g = e.length;
            for (n = []; g--; )
                h = e[g], j = h.nodeName.toLowerCase(), "track" === j && n.push(h);
            for (e = 0; e < n.length; e++)
                c.removeChild(n[e])
        }
        d = t.Aa(c);
        t.h.Z(d, function(c) {
            a.setAttribute(c, d[c])
        });
        c.id += "_html5_api";
        c.className = "vjs-tech";
        c.player = a.player = this;
        this.n("vjs-paused");
        this.width(this.k.width, f);
        this.height(this.k.height, f);
        c.parentNode &&
                c.parentNode.insertBefore(a, c);
        t.Hb(c, a);
        this.b = a;
        this.d("loadstart", this.Kd);
        this.d("waiting", this.Qd);
        this.d(["canplay", "canplaythrough", "playing", "ended"], this.Pd);
        this.d("seeking", this.Nd);
        this.d("seeked", this.Md);
        this.d("ended", this.Gd);
        this.d("play", this.Qb);
        this.d("firstplay", this.Id);
        this.d("pause", this.Pb);
        this.d("progress", this.Ld);
        this.d("durationchange", this.Ac);
        this.d("fullscreenchange", this.Jd);
        return a
    };
    function R(a, c, d) {
        a.i && (a.la = l, a.Lb && (a.Lb = l, clearInterval(a.bb)), a.Mb && S(a), a.i.dispose(), a.i = l);
        "Html5" !== c && a.P && (t.g.Cb(a.P), a.P = k);
        a.fb = c;
        a.la = l;
        var e = t.h.A({source: d, parentEl: a.b}, a.k[c.toLowerCase()]);
        d && (a.oc = d.type, d.src == a.C.src && 0 < a.C.currentTime && (e.startTime = a.C.currentTime), a.C.src = d.src);
        a.i = new window.videojs[c](a, e);
        a.i.J(function() {
            this.c.Ha();
            if (!this.o.progressEvents) {
                var a = this.c;
                a.Lb = f;
                a.bb = setInterval(t.bind(a, function() {
                    var a = this.bufferedPercent();
                    this.C.bufferedPercent !=
                            a && this.l("progress");
                    this.C.bufferedPercent = a;
                    1 == a && clearInterval(this.bb)
                }), 500);
                a.i && a.i.V("progress", function() {
                    this.o.progressEvents = f;
                    var a = this.c;
                    a.Lb = l;
                    clearInterval(a.bb)
                })
            }
            this.o.timeupdateEvents || (a = this.c, a.Mb = f, a.d("play", a.Oc), a.d("pause", a.Ea), a.i && a.i.V("timeupdate", function() {
                this.o.timeupdateEvents = f;
                S(this.c)
            }))
        })
    }
    function S(a) {
        a.Mb = l;
        a.Ea();
        a.p("play", a.Oc);
        a.p("pause", a.Ea)
    }
    s.Oc = function() {
        this.nc && this.Ea();
        this.nc = setInterval(t.bind(this, function() {
            this.l("timeupdate")
        }), 250)
    };
    s.Ea = function() {
        clearInterval(this.nc);
        this.l("timeupdate")
    };
    s.Kd = function() {
        this.error(k);
        this.paused() ? (ea(this, l), this.V("play", function() {
            ea(this, f)
        })) : this.l("firstplay")
    };
    s.vc = l;
    function ea(a, c) {
        c !== b && a.vc !== c && ((a.vc = c) ? (a.n("vjs-has-started"), a.l("firstplay")) : a.q("vjs-has-started"))
    }
    s.Qb = function() {
        this.q("vjs-paused");
        this.n("vjs-playing")
    };
    s.Qd = function() {
        this.n("vjs-waiting")
    };
    s.Pd = function() {
        this.q("vjs-waiting")
    };
    s.Nd = function() {
        this.n("vjs-seeking")
    };
    s.Md = function() {
        this.q("vjs-seeking")
    };
    s.Id = function() {
        this.k.starttime && this.currentTime(this.k.starttime);
        this.n("vjs-has-started")
    };
    s.Pb = function() {
        this.q("vjs-playing");
        this.n("vjs-paused")
    };
    s.Ld = function() {
        1 == this.bufferedPercent() && this.l("loadedalldata")
    };
    s.Gd = function() {
        this.k.loop && (this.currentTime(0), this.play())
    };
    s.Ac = function() {
        var a = T(this, "duration");
        a && (0 > a && (a = Infinity), this.duration(a), Infinity === a ? this.n("vjs-live") : this.q("vjs-live"))
    };
    s.Jd = function() {
        this.isFullscreen() ? this.n("vjs-fullscreen") : this.q("vjs-fullscreen")
    };
    function U(a, c, d) {
        if (a.i && !a.i.la)
            a.i.J(function() {
                this[c](d)
            });
        else
            try {
                a.i[c](d)
            } catch (e) {
                throw t.log(e), e;
            }
    }
    function T(a, c) {
        if (a.i && a.i.la)
            try {
                return a.i[c]()
            } catch (d) {
                throw a.i[c] === b ? t.log("Video.js: " + c + " method not defined for " + a.fb + " playback technology.", d) : "TypeError" == d.name ? (t.log("Video.js: " + c + " unavailable on " + a.fb + " playback technology element.", d), a.i.la = l) : t.log(d), d;
            }
    }
    s.play = function() {
        U(this, "play");
        return this
    };
    s.pause = function() {
        U(this, "pause");
        return this
    };
    s.paused = function() {
        return T(this, "paused") === l ? l : f
    };
    s.currentTime = function(a) {
        return a !== b ? (U(this, "setCurrentTime", a), this.Mb && this.l("timeupdate"), this) : this.C.currentTime = T(this, "currentTime") || 0
    };
    s.duration = function(a) {
        if (a !== b)
            return this.C.duration = parseFloat(a), this;
        this.C.duration === b && this.Ac();
        return this.C.duration || 0
    };
    s.remainingTime = function() {
        return this.duration() - this.currentTime()
    };
    s.buffered = function() {
        var a = T(this, "buffered");
        if (!a || !a.length)
            a = t.Ab(0, 0);
        return a
    };
    s.bufferedPercent = function() {
        var a = this.duration(), c = this.buffered(), d = 0, e, g;
        if (!a)
            return 0;
        for (var h = 0; h < c.length; h++)
            e = c.start(h), g = c.end(h), g > a && (g = a), d += g - e;
        return d / a
    };
    s.volume = function(a) {
        if (a !== b)
            return a = Math.max(0, Math.min(1, parseFloat(a))), this.C.volume = a, U(this, "setVolume", a), t.Xd(a), this;
        a = parseFloat(T(this, "volume"));
        return isNaN(a) ? 1 : a
    };
    s.muted = function(a) {
        return a !== b ? (U(this, "setMuted", a), this) : T(this, "muted") || l
    };
    s.Fa = function() {
        return T(this, "supportsFullScreen") || l
    };
    s.xc = l;
    s.isFullscreen = function(a) {
        return a !== b ? (this.xc = !!a, this) : this.xc
    };
    s.isFullScreen = function(a) {
        t.log.warn('player.isFullScreen() has been deprecated, use player.isFullscreen() with a lowercase "s")');
        return this.isFullscreen(a)
    };
    s.requestFullscreen = function() {
        var a = t.Qa.Fb;
        this.isFullscreen(f);
        a ? (t.d(document, a.fullscreenchange, t.bind(this, function(c) {
            this.isFullscreen(document[a.fullscreenElement]);
            this.isFullscreen() === l && t.p(document, a.fullscreenchange, arguments.callee);
            this.l("fullscreenchange")
        })), this.b[a.requestFullscreen]()) : this.i.Fa() ? U(this, "enterFullScreen") : (this.qc(), this.l("fullscreenchange"));
        return this
    };
    s.exitFullscreen = function() {
        var a = t.Qa.Fb;
        this.isFullscreen(l);
        if (a)
            document[a.exitFullscreen]();
        else
            this.i.Fa() ? U(this, "exitFullScreen") : (this.Db(), this.l("fullscreenchange"));
        return this
    };
    s.qc = function() {
        this.zd = f;
        this.qd = document.documentElement.style.overflow;
        t.d(document, "keydown", t.bind(this, this.sc));
        document.documentElement.style.overflow = "hidden";
        t.n(document.body, "vjs-full-window");
        this.l("enterFullWindow")
    };
    s.sc = function(a) {
        27 === a.keyCode && (this.isFullscreen() === f ? this.exitFullscreen() : this.Db())
    };
    s.Db = function() {
        this.zd = l;
        t.p(document, "keydown", this.sc);
        document.documentElement.style.overflow = this.qd;
        t.q(document.body, "vjs-full-window");
        this.l("exitFullWindow")
    };
    s.src = function(a) {
        if (a === b)
            return T(this, "src");
        t.h.isArray(a) ? fa(this, a) : "string" === typeof a ? this.src({src: a}) : a instanceof Object && (a.type && !window.videojs[this.fb].canPlaySource(a) ? fa(this, [a]) : (this.C.src = a.src, this.oc = a.type || "", this.J(function() {
            U(this, "src", a.src);
            "auto" == this.k.preload && this.load();
            this.k.autoplay && this.play()
        })));
        return this
    };
    function fa(a, c) {
        var d;
        a:{
            d = 0;
            for (var e = a.k.techOrder; d < e.length; d++) {
                var g = t.ba(e[d]), h = window.videojs[g];
                if (h) {
                    if (h.isSupported())
                        for (var j = 0, n = c; j < n.length; j++) {
                            var q = n[j];
                            if (h.canPlaySource(q)) {
                                d = {source: q, i: g};
                                break a
                            }
                        }
                } else
                    t.log.error('The "' + g + '" tech is undefined. Skipped browser support check for that tech.')
            }
            d = l
        }
        d ? d.i === a.fb ? a.src(d.source) : R(a, d.i, d.source) : (a.error({code: 4, message: a.options().notSupportedMessage}), a.Ha())
    }
    s.load = function() {
        U(this, "load");
        return this
    };
    s.currentSrc = function() {
        return T(this, "currentSrc") || this.C.src || ""
    };
    s.ld = function() {
        return this.oc || ""
    };
    s.Da = function(a) {
        return a !== b ? (U(this, "setPreload", a), this.k.preload = a, this) : T(this, "preload")
    };
    s.autoplay = function(a) {
        return a !== b ? (U(this, "setAutoplay", a), this.k.autoplay = a, this) : T(this, "autoplay")
    };
    s.loop = function(a) {
        return a !== b ? (U(this, "setLoop", a), this.k.loop = a, this) : T(this, "loop")
    };
    s.poster = function(a) {
        if (a === b)
            return this.Dc;
        this.Dc = a;
        U(this, "setPoster", a);
        this.l("posterchange")
    };
    s.controls = function(a) {
        return a !== b ? (a = !!a, this.zb !== a && ((this.zb = a) ? (this.q("vjs-controls-disabled"), this.n("vjs-controls-enabled"), this.l("controlsenabled")) : (this.q("vjs-controls-enabled"), this.n("vjs-controls-disabled"), this.l("controlsdisabled"))), this) : this.zb
    };
    t.Player.prototype.Ub;
    s = t.Player.prototype;
    s.usingNativeControls = function(a) {
        return a !== b ? (a = !!a, this.Ub !== a && ((this.Ub = a) ? (this.n("vjs-using-native-controls"), this.l("usingnativecontrols")) : (this.q("vjs-using-native-controls"), this.l("usingcustomcontrols"))), this) : this.Ub
    };
    s.da = k;
    s.error = function(a) {
        if (a === b)
            return this.da;
        if (a === k)
            return this.da = a, this.q("vjs-error"), this;
        this.da = a instanceof t.G ? a : new t.G(a);
        this.l("error");
        this.n("vjs-error");
        t.log.error("(CODE:" + this.da.code + " " + t.G.Ta[this.da.code] + ")", this.da.message, this.da);
        return this
    };
    s.ended = function() {
        return T(this, "ended")
    };
    s.seeking = function() {
        return T(this, "seeking")
    };
    s.pa = f;
    s.reportUserActivity = function() {
        this.pa = f
    };
    s.Tb = f;
    s.userActive = function(a) {
        return a !== b ? (a = !!a, a !== this.Tb && ((this.Tb = a) ? (this.pa = f, this.q("vjs-user-inactive"), this.n("vjs-user-active"), this.l("useractive")) : (this.pa = l, this.i && this.i.V("mousemove", function(a) {
            a.stopPropagation();
            a.preventDefault()
        }), this.q("vjs-user-active"), this.n("vjs-user-inactive"), this.l("userinactive"))), this) : this.Tb
    };
    s.playbackRate = function(a) {
        return a !== b ? (U(this, "setPlaybackRate", a), this) : this.i && this.i.o && this.i.o.playbackRate ? T(this, "playbackRate") : 1
    };
    t.Ka = t.a.extend();
    t.Ka.prototype.k = {oe: "play", children: {playToggle: {}, currentTimeDisplay: {}, timeDivider: {}, durationDisplay: {}, remainingTimeDisplay: {}, liveDisplay: {}, progressControl: {}, fullscreenToggle: {}, volumeControl: {}, muteToggle: {}, playbackRateMenuButton: {}}};
    t.Ka.prototype.e = function() {
        return t.e("div", {className: "vjs-control-bar"})
    };
    t.Zb = t.a.extend({j: function(a, c) {
            t.a.call(this, a, c)
        }});
    t.Zb.prototype.e = function() {
        var a = t.a.prototype.e.call(this, "div", {className: "vjs-live-controls vjs-control"});
        this.v = t.e("div", {className: "vjs-live-display", innerHTML: '<span class="vjs-control-text">' + this.s("Stream Type") + "</span>" + this.s("LIVE"), "aria-live": "off"});
        a.appendChild(this.v);
        return a
    };
    t.bc = t.t.extend({j: function(a, c) {
            t.t.call(this, a, c);
            a.d("play", t.bind(this, this.Qb));
            a.d("pause", t.bind(this, this.Pb))
        }});
    s = t.bc.prototype;
    s.ua = "Play";
    s.T = function() {
        return"vjs-play-control " + t.t.prototype.T.call(this)
    };
    s.r = function() {
        this.c.paused() ? this.c.play() : this.c.pause()
    };
    s.Qb = function() {
        t.q(this.b, "vjs-paused");
        t.n(this.b, "vjs-playing");
        this.b.children[0].children[0].innerHTML = this.s("Pause")
    };
    s.Pb = function() {
        t.q(this.b, "vjs-playing");
        t.n(this.b, "vjs-paused");
        this.b.children[0].children[0].innerHTML = this.s("Play")
    };
    t.ib = t.a.extend({j: function(a, c) {
            t.a.call(this, a, c);
            a.d("timeupdate", t.bind(this, this.ga))
        }});
    t.ib.prototype.e = function() {
        var a = t.a.prototype.e.call(this, "div", {className: "vjs-current-time vjs-time-controls vjs-control"});
        this.v = t.e("div", {className: "vjs-current-time-display", innerHTML: '<span class="vjs-control-text">Current Time </span>0:00', "aria-live": "off"});
        a.appendChild(this.v);
        return a
    };
    t.ib.prototype.ga = function() {
        var a = this.c.eb ? this.c.C.currentTime : this.c.currentTime();
        this.v.innerHTML = '<span class="vjs-control-text">' + this.s("Current Time") + "</span> " + t.za(a, this.c.duration())
    };
    t.jb = t.a.extend({j: function(a, c) {
            t.a.call(this, a, c);
            a.d("timeupdate", t.bind(this, this.ga))
        }});
    t.jb.prototype.e = function() {
        var a = t.a.prototype.e.call(this, "div", {className: "vjs-duration vjs-time-controls vjs-control"});
        this.v = t.e("div", {className: "vjs-duration-display", innerHTML: '<span class="vjs-control-text">' + this.s("Duration Time") + "</span> 0:00", "aria-live": "off"});
        a.appendChild(this.v);
        return a
    };
    t.jb.prototype.ga = function() {
        var a = this.c.duration();
        a && (this.v.innerHTML = '<span class="vjs-control-text">' + this.s("Duration Time") + "</span> " + t.za(a))
    };
    t.hc = t.a.extend({j: function(a, c) {
            t.a.call(this, a, c)
        }});
    t.hc.prototype.e = function() {
        return t.a.prototype.e.call(this, "div", {className: "vjs-time-divider", innerHTML: "<div><span>/</span></div>"})
    };
    t.qb = t.a.extend({j: function(a, c) {
            t.a.call(this, a, c);
            a.d("timeupdate", t.bind(this, this.ga))
        }});
    t.qb.prototype.e = function() {
        var a = t.a.prototype.e.call(this, "div", {className: "vjs-remaining-time vjs-time-controls vjs-control"});
        this.v = t.e("div", {className: "vjs-remaining-time-display", innerHTML: '<span class="vjs-control-text">' + this.s("Remaining Time") + "</span> -0:00", "aria-live": "off"});
        a.appendChild(this.v);
        return a
    };
    t.qb.prototype.ga = function() {
        this.c.duration() && (this.v.innerHTML = '<span class="vjs-control-text">' + this.s("Remaining Time") + "</span> -" + t.za(this.c.remainingTime()))
    };
    t.La = t.t.extend({j: function(a, c) {
            t.t.call(this, a, c)
        }});
    t.La.prototype.ua = "Fullscreen";
    t.La.prototype.T = function() {
        return"vjs-fullscreen-control " + t.t.prototype.T.call(this)
    };
    t.La.prototype.r = function() {
        this.c.isFullscreen() ? (this.c.exitFullscreen(), this.yb.innerHTML = this.s("Fullscreen")) : (this.c.requestFullscreen(), this.yb.innerHTML = this.s("Non-Fullscreen"))
    };
    t.pb = t.a.extend({j: function(a, c) {
            t.a.call(this, a, c)
        }});
    t.pb.prototype.k = {children: {seekBar: {}}};
    t.pb.prototype.e = function() {
        return t.a.prototype.e.call(this, "div", {className: "vjs-progress-control vjs-control"})
    };
    t.dc = t.Q.extend({j: function(a, c) {
            t.Q.call(this, a, c);
            a.d("timeupdate", t.bind(this, this.oa));
            a.J(t.bind(this, this.oa))
        }});
    s = t.dc.prototype;
    s.k = {children: {loadProgressBar: {}, playProgressBar: {}, seekHandle: {}}, barName: "playProgressBar", handleName: "seekHandle"};
    s.Cc = "timeupdate";
    s.e = function() {
        return t.Q.prototype.e.call(this, "div", {className: "vjs-progress-holder", "aria-label": "video progress bar"})
    };
    s.oa = function() {
        var a = this.c.eb ? this.c.C.currentTime : this.c.currentTime();
        this.b.setAttribute("aria-valuenow", t.round(100 * this.Gb(), 2));
        this.b.setAttribute("aria-valuetext", t.za(a, this.c.duration()))
    };
    s.Gb = function() {
        return this.c.currentTime() / this.c.duration()
    };
    s.$a = function(a) {
        t.Q.prototype.$a.call(this, a);
        this.c.eb = f;
        this.ie = !this.c.paused();
        this.c.pause()
    };
    s.ab = function(a) {
        a = J(this, a) * this.c.duration();
        a == this.c.duration() && (a -= 0.1);
        this.c.currentTime(a)
    };
    s.Ob = function(a) {
        t.Q.prototype.Ob.call(this, a);
        this.c.eb = l;
        this.ie && this.c.play()
    };
    s.Lc = function() {
        this.c.currentTime(this.c.currentTime() + 5)
    };
    s.Kc = function() {
        this.c.currentTime(this.c.currentTime() - 5)
    };
    t.mb = t.a.extend({j: function(a, c) {
            t.a.call(this, a, c);
            a.d("progress", t.bind(this, this.update))
        }});
    t.mb.prototype.e = function() {
        return t.a.prototype.e.call(this, "div", {className: "vjs-load-progress", innerHTML: '<span class="vjs-control-text"><span>' + this.s("Loaded") + "</span>: 0%</span>"})
    };
    t.mb.prototype.update = function() {
        var a, c, d, e, g = this.c.buffered();
        a = this.c.duration();
        var h, j = this.c;
        h = j.buffered();
        j = j.duration();
        h = h.end(h.length - 1);
        h > j && (h = j);
        j = this.b.children;
        this.b.style.width = 100 * (h / a || 0) + "%";
        for (a = 0; a < g.length; a++)
            c = g.start(a), d = g.end(a), (e = j[a]) || (e = this.b.appendChild(t.e())), e.style.left = 100 * (c / h || 0) + "%", e.style.width = 100 * ((d - c) / h || 0) + "%";
        for (a = j.length; a > g.length; a--)
            this.b.removeChild(j[a - 1])
    };
    t.ac = t.a.extend({j: function(a, c) {
            t.a.call(this, a, c)
        }});
    t.ac.prototype.e = function() {
        return t.a.prototype.e.call(this, "div", {className: "vjs-play-progress", innerHTML: '<span class="vjs-control-text"><span>' + this.s("Progress") + "</span>: 0%</span>"})
    };
    t.Na = t.$.extend({j: function(a, c) {
            t.$.call(this, a, c);
            a.d("timeupdate", t.bind(this, this.ga))
        }});
    t.Na.prototype.defaultValue = "00:00";
    t.Na.prototype.e = function() {
        return t.$.prototype.e.call(this, "div", {className: "vjs-seek-handle", "aria-live": "off"})
    };
    t.Na.prototype.ga = function() {
        var a = this.c.eb ? this.c.C.currentTime : this.c.currentTime();
        this.b.innerHTML = '<span class="vjs-control-text">' + t.za(a, this.c.duration()) + "</span>"
    };
    t.sb = t.a.extend({j: function(a, c) {
            t.a.call(this, a, c);
            a.i && (a.i.o && a.i.o.volumeControl === l) && this.n("vjs-hidden");
            a.d("loadstart", t.bind(this, function() {
                a.i.o && a.i.o.volumeControl === l ? this.n("vjs-hidden") : this.q("vjs-hidden")
            }))
        }});
    t.sb.prototype.k = {children: {volumeBar: {}}};
    t.sb.prototype.e = function() {
        return t.a.prototype.e.call(this, "div", {className: "vjs-volume-control vjs-control"})
    };
    t.rb = t.Q.extend({j: function(a, c) {
            t.Q.call(this, a, c);
            a.d("volumechange", t.bind(this, this.oa));
            a.J(t.bind(this, this.oa))
        }});
    s = t.rb.prototype;
    s.oa = function() {
        this.b.setAttribute("aria-valuenow", t.round(100 * this.c.volume(), 2));
        this.b.setAttribute("aria-valuetext", t.round(100 * this.c.volume(), 2) + "%")
    };
    s.k = {children: {volumeLevel: {}, volumeHandle: {}}, barName: "volumeLevel", handleName: "volumeHandle"};
    s.Cc = "volumechange";
    s.e = function() {
        return t.Q.prototype.e.call(this, "div", {className: "vjs-volume-bar", "aria-label": "volume level"})
    };
    s.ab = function(a) {
        this.c.muted() && this.c.muted(l);
        this.c.volume(J(this, a))
    };
    s.Gb = function() {
        return this.c.muted() ? 0 : this.c.volume()
    };
    s.Lc = function() {
        this.c.volume(this.c.volume() + 0.1)
    };
    s.Kc = function() {
        this.c.volume(this.c.volume() - 0.1)
    };
    t.ic = t.a.extend({j: function(a, c) {
            t.a.call(this, a, c)
        }});
    t.ic.prototype.e = function() {
        return t.a.prototype.e.call(this, "div", {className: "vjs-volume-level", innerHTML: '<span class="vjs-control-text"></span>'})
    };
    t.tb = t.$.extend();
    t.tb.prototype.defaultValue = "00:00";
    t.tb.prototype.e = function() {
        return t.$.prototype.e.call(this, "div", {className: "vjs-volume-handle"})
    };
    t.ia = t.t.extend({j: function(a, c) {
            t.t.call(this, a, c);
            a.d("volumechange", t.bind(this, this.update));
            a.i && (a.i.o && a.i.o.volumeControl === l) && this.n("vjs-hidden");
            a.d("loadstart", t.bind(this, function() {
                a.i.o && a.i.o.volumeControl === l ? this.n("vjs-hidden") : this.q("vjs-hidden")
            }))
        }});
    t.ia.prototype.e = function() {
        return t.t.prototype.e.call(this, "div", {className: "vjs-mute-control vjs-control", innerHTML: '<div><span class="vjs-control-text">' + this.s("Mute") + "</span></div>"})
    };
    t.ia.prototype.r = function() {
        this.c.muted(this.c.muted() ? l : f)
    };
    t.ia.prototype.update = function() {
        var a = this.c.volume(), c = 3;
        0 === a || this.c.muted() ? c = 0 : 0.33 > a ? c = 1 : 0.67 > a && (c = 2);
        this.c.muted() ? this.b.children[0].children[0].innerHTML != this.s("Unmute") && (this.b.children[0].children[0].innerHTML = this.s("Unmute")) : this.b.children[0].children[0].innerHTML != this.s("Mute") && (this.b.children[0].children[0].innerHTML = this.s("Mute"));
        for (a = 0; 4 > a; a++)
            t.q(this.b, "vjs-vol-" + a);
        t.n(this.b, "vjs-vol-" + c)
    };
    t.sa = t.L.extend({j: function(a, c) {
            t.L.call(this, a, c);
            a.d("volumechange", t.bind(this, this.update));
            a.i && (a.i.o && a.i.o.Rc === l) && this.n("vjs-hidden");
            a.d("loadstart", t.bind(this, function() {
                a.i.o && a.i.o.Rc === l ? this.n("vjs-hidden") : this.q("vjs-hidden")
            }));
            this.n("vjs-menu-button")
        }});
    t.sa.prototype.xa = function() {
        var a = new t.ha(this.c, {mc: "div"}), c = new t.rb(this.c, t.h.A({vertical: f}, this.k.ue));
        a.R(c);
        return a
    };
    t.sa.prototype.r = function() {
        t.ia.prototype.r.call(this);
        t.L.prototype.r.call(this)
    };
    t.sa.prototype.e = function() {
        return t.t.prototype.e.call(this, "div", {className: "vjs-volume-menu-button vjs-menu-button vjs-control", innerHTML: '<div><span class="vjs-control-text">' + this.s("Mute") + "</span></div>"})
    };
    t.sa.prototype.update = t.ia.prototype.update;
    t.cc = t.L.extend({j: function(a, c) {
            t.L.call(this, a, c);
            this.Qc();
            this.Pc();
            a.d("loadstart", t.bind(this, this.Qc));
            a.d("ratechange", t.bind(this, this.Pc))
        }});
    s = t.cc.prototype;
    s.e = function() {
        var a = t.a.prototype.e.call(this, "div", {className: "vjs-playback-rate vjs-menu-button vjs-control", innerHTML: '<div class="vjs-control-content"><span class="vjs-control-text">' + this.s("Playback Rate") + "</span></div>"});
        this.zc = t.e("div", {className: "vjs-playback-rate-value", innerHTML: 1});
        a.appendChild(this.zc);
        return a
    };
    s.xa = function() {
        var a = new t.ha(this.m()), c = this.m().options().playbackRates;
        if (c)
            for (var d = c.length - 1; 0 <= d; d--)
                a.R(new t.ob(this.m(), {rate: c[d] + "x"}));
        return a
    };
    s.oa = function() {
        this.w().setAttribute("aria-valuenow", this.m().playbackRate())
    };
    s.r = function() {
        for (var a = this.m().playbackRate(), c = this.m().options().playbackRates, d = c[0], e = 0; e < c.length; e++)
            if (c[e] > a) {
                d = c[e];
                break
            }
        this.m().playbackRate(d)
    };
    function ga(a) {
        return a.m().i && a.m().i.o.playbackRate && a.m().options().playbackRates && 0 < a.m().options().playbackRates.length
    }
    s.Qc = function() {
        ga(this) ? this.q("vjs-hidden") : this.n("vjs-hidden")
    };
    s.Pc = function() {
        ga(this) && (this.zc.innerHTML = this.m().playbackRate() + "x")
    };
    t.ob = t.I.extend({mc: "button", j: function(a, c) {
            var d = this.label = c.rate, e = this.Ec = parseFloat(d, 10);
            c.label = d;
            c.selected = 1 === e;
            t.I.call(this, a, c);
            this.m().d("ratechange", t.bind(this, this.update))
        }});
    t.ob.prototype.r = function() {
        t.I.prototype.r.call(this);
        this.m().playbackRate(this.Ec)
    };
    t.ob.prototype.update = function() {
        this.selected(this.m().playbackRate() == this.Ec)
    };
    t.Ma = t.t.extend({j: function(a, c) {
            t.t.call(this, a, c);
            a.poster() && this.src(a.poster());
            (!a.poster() || !a.controls()) && this.X();
            a.d("posterchange", t.bind(this, function() {
                this.src(a.poster())
            }));
            a.d("play", t.bind(this, this.X))
        }});
    var ha = "backgroundSize"in t.B.style;
    t.Ma.prototype.e = function() {
        var a = t.e("div", {className: "vjs-poster", tabIndex: -1});
        ha || a.appendChild(t.e("img"));
        return a
    };
    t.Ma.prototype.src = function(a) {
        var c = this.w();
        a !== b && (ha ? c.style.backgroundImage = 'url("' + a + '")' : c.firstChild.src = a)
    };
    t.Ma.prototype.r = function() {
        this.m().controls() && this.c.play()
    };
    t.$b = t.a.extend({j: function(a, c) {
            t.a.call(this, a, c)
        }});
    t.$b.prototype.e = function() {
        return t.a.prototype.e.call(this, "div", {className: "vjs-loading-spinner"})
    };
    t.gb = t.t.extend();
    t.gb.prototype.e = function() {
        return t.t.prototype.e.call(this, "div", {className: "vjs-big-play-button", innerHTML: '<span aria-hidden="true"></span>', "aria-label": "play video"})
    };
    t.gb.prototype.r = function() {
        this.c.play()
    };
    t.kb = t.a.extend({j: function(a, c) {
            t.a.call(this, a, c);
            this.update();
            a.d("error", t.bind(this, this.update))
        }});
    t.kb.prototype.e = function() {
        var a = t.a.prototype.e.call(this, "div", {className: "vjs-error-display"});
        this.v = t.e("div");
        a.appendChild(this.v);
        return a
    };
    t.kb.prototype.update = function() {
        this.m().error() && (this.v.innerHTML = this.s(this.m().error().message))
    };
    t.u = t.a.extend({j: function(a, c, d) {
            c = c || {};
            c.Gc = l;
            t.a.call(this, a, c, d);
            var e, g;
            g = this;
            e = this.m();
            a = function() {
                if (e.controls() && !e.usingNativeControls()) {
                    var a;
                    g.d("mousedown", g.r);
                    g.d("touchstart", function() {
                        a = this.c.userActive()
                    });
                    g.d("touchmove", function() {
                        a && this.m().reportUserActivity()
                    });
                    g.d("touchend", function(a) {
                        a.preventDefault()
                    });
                    I(g);
                    g.d("tap", g.Od)
                }
            };
            c = t.bind(g, g.Ud);
            this.J(a);
            e.d("controlsenabled", a);
            e.d("controlsdisabled", c);
            this.J(function() {
                this.networkState && 0 < this.networkState() &&
                        this.m().l("loadstart")
            })
        }});
    s = t.u.prototype;
    s.Ud = function() {
        this.p("tap");
        this.p("touchstart");
        this.p("touchmove");
        this.p("touchleave");
        this.p("touchcancel");
        this.p("touchend");
        this.p("click");
        this.p("mousedown")
    };
    s.r = function(a) {
        0 === a.button && this.m().controls() && (this.m().paused() ? this.m().play() : this.m().pause())
    };
    s.Od = function() {
        this.m().userActive(!this.m().userActive())
    };
    s.Ic = m();
    s.o = {volumeControl: f, fullscreenResize: l, playbackRate: l, progressEvents: l, timeupdateEvents: l};
    t.media = {};
    t.g = t.u.extend({j: function(a, c, d) {
            this.o.volumeControl = t.g.jd();
            this.o.playbackRate = t.g.hd();
            this.o.movingMediaElementInDOM = !t.Xc;
            this.o.fullscreenResize = f;
            t.u.call(this, a, c, d);
            for (d = t.g.lb.length - 1; 0 <= d; d--)
                t.d(this.b, t.g.lb[d], t.bind(this, this.sd));
            if ((c = c.source) && this.b.currentSrc !== c.src)
                this.b.src = c.src;
            if (t.fc && a.options().nativeControlsForTouch !== l) {
                var e, g, h, j;
                e = this;
                g = this.m();
                c = g.controls();
                e.b.controls = !!c;
                h = function() {
                    e.b.controls = f
                };
                j = function() {
                    e.b.controls = l
                };
                g.d("controlsenabled",
                        h);
                g.d("controlsdisabled", j);
                c = function() {
                    g.p("controlsenabled", h);
                    g.p("controlsdisabled", j)
                };
                e.d("dispose", c);
                g.d("usingcustomcontrols", c);
                g.usingNativeControls(f)
            }
            a.J(function() {
                this.P && (this.k.autoplay && this.paused()) && (delete this.P.poster, this.play())
            });
            this.Ha()
        }});
    s = t.g.prototype;
    s.dispose = function() {
        t.g.Cb(this.b);
        t.u.prototype.dispose.call(this)
    };
    s.e = function() {
        var a = this.c, c = a.P, d;
        if (!c || this.o.movingMediaElementInDOM === l)
            c ? (d = c.cloneNode(l), t.g.Cb(c), c = d, a.P = k) : (c = t.e("video"), t.Hc(c, t.h.A(a.ee || {}, {id: a.id() + "_html5_api", "class": "vjs-tech"}))), c.player = a, t.Hb(c, a.w());
        d = ["autoplay", "preload", "loop", "muted"];
        for (var e = d.length - 1; 0 <= e; e--) {
            var g = d[e], h = {};
            "undefined" !== typeof a.k[g] && (h[g] = a.k[g]);
            t.Hc(c, h)
        }
        return c
    };
    s.sd = function(a) {
        "error" == a.type ? this.m().error(this.error().code) : (a.bubbles = l, this.m().l(a))
    };
    s.play = function() {
        this.b.play()
    };
    s.pause = function() {
        this.b.pause()
    };
    s.paused = function() {
        return this.b.paused
    };
    s.currentTime = function() {
        return this.b.currentTime
    };
    s.Wd = function(a) {
        try {
            this.b.currentTime = a
        } catch (c) {
            t.log(c, "Video is not ready. (Video.js)")
        }
    };
    s.duration = function() {
        return this.b.duration || 0
    };
    s.buffered = function() {
        return this.b.buffered
    };
    s.volume = function() {
        return this.b.volume
    };
    s.be = function(a) {
        this.b.volume = a
    };
    s.muted = function() {
        return this.b.muted
    };
    s.Zd = function(a) {
        this.b.muted = a
    };
    s.width = function() {
        return this.b.offsetWidth
    };
    s.height = function() {
        return this.b.offsetHeight
    };
    s.Fa = function() {
        return"function" == typeof this.b.webkitEnterFullScreen && (/Android/.test(t.M) || !/Chrome|Mac OS X 10.5/.test(t.M)) ? f : l
    };
    s.pc = function() {
        var a = this.b;
        a.paused && a.networkState <= a.je ? (this.b.play(), setTimeout(function() {
            a.pause();
            a.webkitEnterFullScreen()
        }, 0)) : a.webkitEnterFullScreen()
    };
    s.td = function() {
        this.b.webkitExitFullScreen()
    };
    s.src = function(a) {
        this.b.src = a
    };
    s.load = function() {
        this.b.load()
    };
    s.currentSrc = function() {
        return this.b.currentSrc
    };
    s.poster = function() {
        return this.b.poster
    };
    s.Ic = function(a) {
        this.b.poster = a
    };
    s.Da = function() {
        return this.b.Da
    };
    s.ae = function(a) {
        this.b.Da = a
    };
    s.autoplay = function() {
        return this.b.autoplay
    };
    s.Vd = function(a) {
        this.b.autoplay = a
    };
    s.controls = function() {
        return this.b.controls
    };
    s.loop = function() {
        return this.b.loop
    };
    s.Yd = function(a) {
        this.b.loop = a
    };
    s.error = function() {
        return this.b.error
    };
    s.seeking = function() {
        return this.b.seeking
    };
    s.ended = function() {
        return this.b.ended
    };
    s.playbackRate = function() {
        return this.b.playbackRate
    };
    s.$d = function(a) {
        this.b.playbackRate = a
    };
    s.networkState = function() {
        return this.b.networkState
    };
    t.g.isSupported = function() {
        try {
            t.B.volume = 0.5
        } catch (a) {
            return l
        }
        return!!t.B.canPlayType
    };
    t.g.wb = function(a) {
        try {
            return!!t.B.canPlayType(a.type)
        } catch (c) {
            return""
        }
    };
    t.g.jd = function() {
        var a = t.B.volume;
        t.B.volume = a / 2 + 0.1;
        return a !== t.B.volume
    };
    t.g.hd = function() {
        var a = t.B.playbackRate;
        t.B.playbackRate = a / 2 + 0.1;
        return a !== t.B.playbackRate
    };
    var V, ia = /^application\/(?:x-|vnd\.apple\.)mpegurl/i, ja = /^video\/mp4/i;
    t.g.Bc = function() {
        4 <= t.Vb && (V || (V = t.B.constructor.prototype.canPlayType), t.B.constructor.prototype.canPlayType = function(a) {
            return a && ia.test(a) ? "maybe" : V.call(this, a)
        });
        t.ad && (V || (V = t.B.constructor.prototype.canPlayType), t.B.constructor.prototype.canPlayType = function(a) {
            return a && ja.test(a) ? "maybe" : V.call(this, a)
        })
    };
    t.g.he = function() {
        var a = t.B.constructor.prototype.canPlayType;
        t.B.constructor.prototype.canPlayType = V;
        V = k;
        return a
    };
    t.g.Bc();
    t.g.lb = "loadstart suspend abort error emptied stalled loadedmetadata loadeddata canplay canplaythrough playing waiting seeking seeked ended durationchange timeupdate progress play pause ratechange volumechange".split(" ");
    t.g.Cb = function(a) {
        if (a) {
            a.player = k;
            for (a.parentNode && a.parentNode.removeChild(a); a.hasChildNodes(); )
                a.removeChild(a.firstChild);
            a.removeAttribute("src");
            if ("function" === typeof a.load)
                try {
                    a.load()
                } catch (c) {
                }
        }
    };
    t.f = t.u.extend({j: function(a, c, d) {
            t.u.call(this, a, c, d);
            var e = c.source;
            d = c.parentEl;
            var g = this.b = t.e("div", {id: a.id() + "_temp_flash"}), h = a.id() + "_flash_api", j = a.k, j = t.h.A({readyFunction: "videojs.Flash.onReady", eventProxyFunction: "videojs.Flash.onEvent", errorEventProxyFunction: "videojs.Flash.onError", autoplay: j.autoplay, preload: j.Da, loop: j.loop, muted: j.muted}, c.flashVars), n = t.h.A({wmode: "opaque", bgcolor: "#000000"}, c.params), h = t.h.A({id: h, name: h, "class": "vjs-tech"}, c.attributes);
            e && (e.type && t.f.Bd(e.type) ?
                    (e = t.f.Mc(e.src), j.rtmpConnection = encodeURIComponent(e.xb), j.rtmpStream = encodeURIComponent(e.Sb)) : j.src = encodeURIComponent(t.tc(e.src)));
            t.Hb(g, d);
            c.startTime && this.J(function() {
                this.load();
                this.play();
                this.currentTime(c.startTime)
            });
            t.Wc && this.J(function() {
                t.d(this.w(), "mousemove", t.bind(this, function() {
                    this.m().l({type: "mousemove", bubbles: l})
                }))
            });
            a.d("stageclick", a.reportUserActivity);
            this.b = t.f.rd(c.swf, g, j, n, h)
        }});
    t.f.prototype.dispose = function() {
        t.u.prototype.dispose.call(this)
    };
    t.f.prototype.play = function() {
        this.b.vjs_play()
    };
    t.f.prototype.pause = function() {
        this.b.vjs_pause()
    };
    t.f.prototype.src = function(a) {
        if (a === b)
            return this.currentSrc();
        t.f.Ad(a) ? (a = t.f.Mc(a), this.qe(a.xb), this.re(a.Sb)) : (a = t.tc(a), this.b.vjs_src(a));
        if (this.c.autoplay()) {
            var c = this;
            setTimeout(function() {
                c.play()
            }, 0)
        }
    };
    t.f.prototype.setCurrentTime = function(a) {
        this.Ed = a;
        this.b.vjs_setProperty("currentTime", a)
    };
    t.f.prototype.currentTime = function() {
        return this.seeking() ? this.Ed || 0 : this.b.vjs_getProperty("currentTime")
    };
    t.f.prototype.currentSrc = function() {
        var a = this.b.vjs_getProperty("currentSrc");
        if (a == k) {
            var c = this.rtmpConnection(), d = this.rtmpStream();
            c && d && (a = t.f.ce(c, d))
        }
        return a
    };
    t.f.prototype.load = function() {
        this.b.vjs_load()
    };
    t.f.prototype.poster = function() {
        this.b.vjs_getProperty("poster")
    };
    t.f.prototype.setPoster = m();
    t.f.prototype.buffered = function() {
        return t.Ab(0, this.b.vjs_getProperty("buffered"))
    };
    t.f.prototype.Fa = r(l);
    t.f.prototype.pc = r(l);
    function ka() {
        var a = W[X], c = a.charAt(0).toUpperCase() + a.slice(1);
        la["set" + c] = function(c) {
            return this.b.vjs_setProperty(a, c)
        }
    }
    function ma(a) {
        la[a] = function() {
            return this.b.vjs_getProperty(a)
        }
    }
    var la = t.f.prototype, W = "rtmpConnection rtmpStream preload defaultPlaybackRate playbackRate autoplay loop mediaGroup controller controls volume muted defaultMuted".split(" "), na = "error networkState readyState seeking initialTime duration startOffsetTime paused played seekable ended videoTracks audioTracks videoWidth videoHeight textTracks".split(" "), X;
    for (X = 0; X < W.length; X++)
        ma(W[X]), ka();
    for (X = 0; X < na.length; X++)
        ma(na[X]);
    t.f.isSupported = function() {
        return 10 <= t.f.version()[0]
    };
    t.f.wb = function(a) {
        if (!a.type)
            return"";
        a = a.type.replace(/;.*/, "").toLowerCase();
        if (a in t.f.vd || a in t.f.Nc)
            return"maybe"
    };
    t.f.vd = {"video/flv": "FLV", "video/x-flv": "FLV", "video/mp4": "MP4", "video/m4v": "MP4"};
    t.f.Nc = {"rtmp/mp4": "MP4", "rtmp/flv": "FLV"};
    t.f.onReady = function(a) {
        var c;
        if (c = (a = t.w(a)) && a.parentNode && a.parentNode.player)
            a.player = c, t.f.checkReady(c.i)
    };
    t.f.checkReady = function(a) {
        a.w() && (a.w().vjs_getProperty ? a.Ha() : setTimeout(function() {
            t.f.checkReady(a)
        }, 50))
    };
    t.f.onEvent = function(a, c) {
        t.w(a).player.l(c)
    };
    t.f.onError = function(a, c) {
        var d = t.w(a).player, e = "FLASH: " + c;
        "srcnotfound" == c ? d.error({code: 4, message: e}) : d.error(e)
    };
    t.f.version = function() {
        var a = "0,0,0";
        try {
            a = (new window.ActiveXObject("ShockwaveFlash.ShockwaveFlash")).GetVariable("$version").replace(/\D+/g, ",").match(/^,?(.+),?$/)[1]
        } catch (c) {
            try {
                navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin && (a = (navigator.plugins["Shockwave Flash 2.0"] || navigator.plugins["Shockwave Flash"]).description.replace(/\D+/g, ",").match(/^,?(.+),?$/)[1])
            } catch (d) {
            }
        }
        return a.split(",")
    };
    t.f.rd = function(a, c, d, e, g) {
        a = t.f.xd(a, d, e, g);
        a = t.e("div", {innerHTML: a}).childNodes[0];
        d = c.parentNode;
        c.parentNode.replaceChild(a, c);
        var h = d.childNodes[0];
        setTimeout(function() {
            h.style.display = "block"
        }, 1E3);
        return a
    };
    t.f.xd = function(a, c, d, e) {
        var g = "", h = "", j = "";
        c && t.h.Z(c, function(a, c) {
            g += a + "=" + c + "&amp;"
        });
        d = t.h.A({movie: a, flashvars: g, allowScriptAccess: "always", allowNetworking: "all"}, d);
        t.h.Z(d, function(a, c) {
            h += '<param name="' + a + '" value="' + c + '" />'
        });
        e = t.h.A({data: a, width: "100%", height: "100%"}, e);
        t.h.Z(e, function(a, c) {
            j += a + '="' + c + '" '
        });
        return'<object type="application/x-shockwave-flash"' + j + ">" + h + "</object>"
    };
    t.f.ce = function(a, c) {
        return a + "&" + c
    };
    t.f.Mc = function(a) {
        var c = {xb: "", Sb: ""};
        if (!a)
            return c;
        var d = a.indexOf("&"), e;
        -1 !== d ? e = d + 1 : (d = e = a.lastIndexOf("/") + 1, 0 === d && (d = e = a.length));
        c.xb = a.substring(0, d);
        c.Sb = a.substring(e, a.length);
        return c
    };
    t.f.Bd = function(a) {
        return a in t.f.Nc
    };
    t.f.cd = /^rtmp[set]?:\/\//i;
    t.f.Ad = function(a) {
        return t.f.cd.test(a)
    };
    t.bd = t.a.extend({j: function(a, c, d) {
            t.a.call(this, a, c, d);
            if (!a.k.sources || 0 === a.k.sources.length) {
                c = 0;
                for (d = a.k.techOrder; c < d.length; c++) {
                    var e = t.ba(d[c]), g = window.videojs[e];
                    if (g && g.isSupported()) {
                        R(a, e);
                        break
                    }
                }
            } else
                a.src(a.k.sources)
        }});
    t.Player.prototype.textTracks = function() {
        return this.Ga = this.Ga || []
    };
    function oa(a, c, d, e, g) {
        var h = a.Ga = a.Ga || [];
        g = g || {};
        g.kind = c;
        g.label = d;
        g.language = e;
        c = t.ba(c || "subtitles");
        var j = new window.videojs[c + "Track"](a, g);
        h.push(j);
        j.Bb() && a.J(function() {
            setTimeout(function() {
                Y(j.m(), j.id())
            }, 0)
        })
    }
    function Y(a, c, d) {
        for (var e = a.Ga, g = 0, h = e.length, j, n; g < h; g++)
            j = e[g], j.id() === c ? (j.show(), n = j) : d && (j.K() == d && 0 < j.mode()) && j.disable();
        (c = n ? n.K() : d ? d : l) && a.l(c + "trackchange")
    }
    t.D = t.a.extend({j: function(a, c) {
            t.a.call(this, a, c);
            this.U = c.id || "vjs_" + c.kind + "_" + c.language + "_" + t.z++;
            this.Jc = c.src;
            this.od = c["default"] || c.dflt;
            this.fe = c.title;
            this.Va = c.srclang;
            this.Cd = c.label;
            this.ca = [];
            this.ub = [];
            this.ma = this.na = 0;
            this.c.d("fullscreenchange", t.bind(this, this.ed))
        }});
    s = t.D.prototype;
    s.K = p("H");
    s.src = p("Jc");
    s.Bb = p("od");
    s.title = p("fe");
    s.language = p("Va");
    s.label = p("Cd");
    s.kd = p("ca");
    s.dd = p("ub");
    s.readyState = p("na");
    s.mode = p("ma");
    s.ed = function() {
        this.b.style.fontSize = this.c.isFullScreen() ? 140 * (screen.width / this.c.width()) + "%" : ""
    };
    s.e = function() {
        return t.a.prototype.e.call(this, "div", {className: "vjs-" + this.H + " vjs-text-track"})
    };
    s.show = function() {
        pa(this);
        this.ma = 2;
        t.a.prototype.show.call(this)
    };
    s.X = function() {
        pa(this);
        this.ma = 1;
        t.a.prototype.X.call(this)
    };
    s.disable = function() {
        2 == this.ma && this.X();
        this.c.p("timeupdate", t.bind(this, this.update, this.U));
        this.c.p("ended", t.bind(this, this.reset, this.U));
        this.reset();
        this.c.ka("textTrackDisplay").removeChild(this);
        this.ma = 0
    };
    function pa(a) {
        0 === a.na && a.load();
        0 === a.ma && (a.c.d("timeupdate", t.bind(a, a.update, a.U)), a.c.d("ended", t.bind(a, a.reset, a.U)), ("captions" === a.H || "subtitles" === a.H) && a.c.ka("textTrackDisplay").R(a))
    }
    s.load = function() {
        0 === this.na && (this.na = 1, t.get(this.Jc, t.bind(this, this.Rd), t.bind(this, this.Hd)))
    };
    s.Hd = function(a) {
        this.error = a;
        this.na = 3;
        this.l("error")
    };
    s.Rd = function(a) {
        var c, d;
        a = a.split("\n");
        for (var e = "", g = 1, h = a.length; g < h; g++)
            if (e = t.trim(a[g])) {
                -1 == e.indexOf("--\x3e") ? (c = e, e = t.trim(a[++g])) : c = this.ca.length;
                c = {id: c, index: this.ca.length};
                d = e.split(/[\t ]+/);
                c.startTime = qa(d[0]);
                c.ya = qa(d[2]);
                for (d = []; a[++g] && (e = t.trim(a[g])); )
                    d.push(e);
                c.text = d.join("<br/>");
                this.ca.push(c)
            }
        this.na = 2;
        this.l("loaded")
    };
    function qa(a) {
        var c = a.split(":");
        a = 0;
        var d, e, g;
        3 == c.length ? (d = c[0], e = c[1], c = c[2]) : (d = 0, e = c[0], c = c[1]);
        c = c.split(/\s+/);
        c = c.splice(0, 1)[0];
        c = c.split(/\.|,/);
        g = parseFloat(c[1]);
        c = c[0];
        a += 3600 * parseFloat(d);
        a += 60 * parseFloat(e);
        a += parseFloat(c);
        g && (a += g / 1E3);
        return a
    }
    s.update = function() {
        if (0 < this.ca.length) {
            var a = this.c.options().trackTimeOffset || 0, a = this.c.currentTime() + a;
            if (this.Rb === b || a < this.Rb || this.Xa <= a) {
                var c = this.ca, d = this.c.duration(), e = 0, g = l, h = [], j, n, q, v;
                a >= this.Xa || this.Xa === b ? v = this.Eb !== b ? this.Eb : 0 : (g = f, v = this.Kb !== b ? this.Kb : c.length - 1);
                for (; ; ) {
                    q = c[v];
                    if (q.ya <= a)
                        e = Math.max(e, q.ya), q.Pa && (q.Pa = l);
                    else if (a < q.startTime) {
                        if (d = Math.min(d, q.startTime), q.Pa && (q.Pa = l), !g)
                            break
                    } else
                        g ? (h.splice(0, 0, q), n === b && (n = v), j = v) : (h.push(q), j === b && (j = v), n = v), d = Math.min(d,
                                q.ya), e = Math.max(e, q.startTime), q.Pa = f;
                    if (g)
                        if (0 === v)
                            break;
                        else
                            v--;
                    else if (v === c.length - 1)
                        break;
                    else
                        v++
                }
                this.ub = h;
                this.Xa = d;
                this.Rb = e;
                this.Eb = j;
                this.Kb = n;
                j = this.ub;
                n = "";
                a = 0;
                for (c = j.length; a < c; a++)
                    n += '<span class="vjs-tt-cue">' + j[a].text + "</span>";
                this.b.innerHTML = n;
                this.l("cuechange")
            }
        }
    };
    s.reset = function() {
        this.Xa = 0;
        this.Rb = this.c.duration();
        this.Kb = this.Eb = 0
    };
    t.Xb = t.D.extend();
    t.Xb.prototype.H = "captions";
    t.ec = t.D.extend();
    t.ec.prototype.H = "subtitles";
    t.Yb = t.D.extend();
    t.Yb.prototype.H = "chapters";
    t.gc = t.a.extend({j: function(a, c, d) {
            t.a.call(this, a, c, d);
            if (a.k.tracks && 0 < a.k.tracks.length) {
                c = this.c;
                a = a.k.tracks;
                for (var e = 0; e < a.length; e++)
                    d = a[e], oa(c, d.kind, d.label, d.language, d)
            }
        }});
    t.gc.prototype.e = function() {
        return t.a.prototype.e.call(this, "div", {className: "vjs-text-track-display"})
    };
    t.aa = t.I.extend({j: function(a, c) {
            var d = this.fa = c.track;
            c.label = d.label();
            c.selected = d.Bb();
            t.I.call(this, a, c);
            this.c.d(d.K() + "trackchange", t.bind(this, this.update))
        }});
    t.aa.prototype.r = function() {
        t.I.prototype.r.call(this);
        Y(this.c, this.fa.U, this.fa.K())
    };
    t.aa.prototype.update = function() {
        this.selected(2 == this.fa.mode())
    };
    t.nb = t.aa.extend({j: function(a, c) {
            c.track = {K: function() {
                    return c.kind
                }, m: a, label: function() {
                    return c.kind + " off"
                }, Bb: r(l), mode: r(l)};
            t.aa.call(this, a, c);
            this.selected(f)
        }});
    t.nb.prototype.r = function() {
        t.aa.prototype.r.call(this);
        Y(this.c, this.fa.U, this.fa.K())
    };
    t.nb.prototype.update = function() {
        for (var a = this.c.textTracks(), c = 0, d = a.length, e, g = f; c < d; c++)
            e = a[c], e.K() == this.fa.K() && 2 == e.mode() && (g = l);
        this.selected(g)
    };
    t.W = t.L.extend({j: function(a, c) {
            t.L.call(this, a, c);
            1 >= this.O.length && this.X()
        }});
    t.W.prototype.wa = function() {
        var a = [], c;
        a.push(new t.nb(this.c, {kind: this.H}));
        for (var d = 0; d < this.c.textTracks().length; d++)
            c = this.c.textTracks()[d], c.K() === this.H && a.push(new t.aa(this.c, {track: c}));
        return a
    };
    t.Ia = t.W.extend({j: function(a, c, d) {
            t.W.call(this, a, c, d);
            this.b.setAttribute("aria-label", "Captions Menu")
        }});
    t.Ia.prototype.H = "captions";
    t.Ia.prototype.ua = "Captions";
    t.Ia.prototype.className = "vjs-captions-button";
    t.Oa = t.W.extend({j: function(a, c, d) {
            t.W.call(this, a, c, d);
            this.b.setAttribute("aria-label", "Subtitles Menu")
        }});
    t.Oa.prototype.H = "subtitles";
    t.Oa.prototype.ua = "Subtitles";
    t.Oa.prototype.className = "vjs-subtitles-button";
    t.Ja = t.W.extend({j: function(a, c, d) {
            t.W.call(this, a, c, d);
            this.b.setAttribute("aria-label", "Chapters Menu")
        }});
    s = t.Ja.prototype;
    s.H = "chapters";
    s.ua = "Chapters";
    s.className = "vjs-chapters-button";
    s.wa = function() {
        for (var a = [], c, d = 0; d < this.c.textTracks().length; d++)
            c = this.c.textTracks()[d], c.K() === this.H && a.push(new t.aa(this.c, {track: c}));
        return a
    };
    s.xa = function() {
        for (var a = this.c.textTracks(), c = 0, d = a.length, e, g, h = this.O = []; c < d; c++)
            if (e = a[c], e.K() == this.H)
                if (0 === e.readyState())
                    e.load(), e.d("loaded", t.bind(this, this.xa));
                else {
                    g = e;
                    break
                }
        a = this.Ba;
        a === b && (a = new t.ha(this.c), a.ja().appendChild(t.e("li", {className: "vjs-menu-title", innerHTML: t.ba(this.H), de: -1})));
        if (g) {
            e = g.ca;
            for (var j, c = 0, d = e.length; c < d; c++)
                j = e[c], j = new t.hb(this.c, {track: g, cue: j}), h.push(j), a.R(j);
            this.R(a)
        }
        0 < this.O.length && this.show();
        return a
    };
    t.hb = t.I.extend({j: function(a, c) {
            var d = this.fa = c.track, e = this.cue = c.cue, g = a.currentTime();
            c.label = e.text;
            c.selected = e.startTime <= g && g < e.ya;
            t.I.call(this, a, c);
            d.d("cuechange", t.bind(this, this.update))
        }});
    t.hb.prototype.r = function() {
        t.I.prototype.r.call(this);
        this.c.currentTime(this.cue.startTime);
        this.update(this.cue.startTime)
    };
    t.hb.prototype.update = function() {
        var a = this.cue, c = this.c.currentTime();
        this.selected(a.startTime <= c && c < a.ya)
    };
    t.h.A(t.Ka.prototype.k.children, {subtitlesButton: {}, captionsButton: {}, chaptersButton: {}});
    if ("undefined" !== typeof window.JSON && "function" === window.JSON.parse)
        t.JSON = window.JSON;
    else {
        t.JSON = {};
        var Z = /[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g;
        t.JSON.parse = function(a, c) {
            function d(a, e) {
                var j, n, q = a[e];
                if (q && "object" === typeof q)
                    for (j in q)
                        Object.prototype.hasOwnProperty.call(q, j) && (n = d(q, j), n !== b ? q[j] = n : delete q[j]);
                return c.call(a, e, q)
            }
            var e;
            a = String(a);
            Z.lastIndex = 0;
            Z.test(a) && (a = a.replace(Z, function(a) {
                return"\\u" + ("0000" + a.charCodeAt(0).toString(16)).slice(-4)
            }));
            if (/^[\],:{}\s]*$/.test(a.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g, "@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, "]").replace(/(?:^|:|,)(?:\s*\[)+/g, "")))
                return e = eval("(" + a + ")"), "function" === typeof c ? d({"": e}, "") : e;
            throw new SyntaxError("JSON.parse(): invalid or malformed JSON data");
        }
    }
    t.kc = function() {
        var a, c, d = document.getElementsByTagName("video");
        if (d && 0 < d.length)
            for (var e = 0, g = d.length; e < g; e++)
                if ((c = d[e]) && c.getAttribute)
                    c.player === b && (a = c.getAttribute("data-setup"), a !== k && (a = t.JSON.parse(a || "{}"), videojs(c, a)));
                else {
                    t.vb();
                    break
                }
        else
            t.Sc || t.vb()
    };
    t.vb = function() {
        setTimeout(t.kc, 1)
    };
    "complete" === document.readyState ? t.Sc = f : t.V(window, "load", function() {
        t.Sc = f
    });
    t.vb();
    t.Td = function(a, c) {
        t.Player.prototype[a] = c
    };
    var ra = this;
    function $(a, c) {
        var d = a.split("."), e = ra;
        !(d[0]in e) && e.execScript && e.execScript("var " + d[0]);
        for (var g; d.length && (g = d.shift()); )
            !d.length && c !== b ? e[g] = c : e = e[g] ? e[g] : e[g] = {}
    }
    ;
    $("videojs", t);
    $("_V_", t);
    $("videojs.options", t.options);
    $("videojs.players", t.Ca);
    $("videojs.TOUCH_ENABLED", t.fc);
    $("videojs.cache", t.va);
    $("videojs.Component", t.a);
    t.a.prototype.player = t.a.prototype.m;
    t.a.prototype.options = t.a.prototype.options;
    t.a.prototype.init = t.a.prototype.j;
    t.a.prototype.dispose = t.a.prototype.dispose;
    t.a.prototype.createEl = t.a.prototype.e;
    t.a.prototype.contentEl = t.a.prototype.ja;
    t.a.prototype.el = t.a.prototype.w;
    t.a.prototype.addChild = t.a.prototype.R;
    t.a.prototype.getChild = t.a.prototype.ka;
    t.a.prototype.getChildById = t.a.prototype.wd;
    t.a.prototype.children = t.a.prototype.children;
    t.a.prototype.initChildren = t.a.prototype.wc;
    t.a.prototype.removeChild = t.a.prototype.removeChild;
    t.a.prototype.on = t.a.prototype.d;
    t.a.prototype.off = t.a.prototype.p;
    t.a.prototype.one = t.a.prototype.V;
    t.a.prototype.trigger = t.a.prototype.l;
    t.a.prototype.triggerReady = t.a.prototype.Ha;
    t.a.prototype.show = t.a.prototype.show;
    t.a.prototype.hide = t.a.prototype.X;
    t.a.prototype.width = t.a.prototype.width;
    t.a.prototype.height = t.a.prototype.height;
    t.a.prototype.dimensions = t.a.prototype.pd;
    t.a.prototype.ready = t.a.prototype.J;
    t.a.prototype.addClass = t.a.prototype.n;
    t.a.prototype.removeClass = t.a.prototype.q;
    t.a.prototype.buildCSSClass = t.a.prototype.T;
    t.a.prototype.localize = t.a.prototype.s;
    t.Player.prototype.ended = t.Player.prototype.ended;
    t.Player.prototype.enterFullWindow = t.Player.prototype.qc;
    t.Player.prototype.exitFullWindow = t.Player.prototype.Db;
    t.Player.prototype.preload = t.Player.prototype.Da;
    t.Player.prototype.remainingTime = t.Player.prototype.remainingTime;
    t.Player.prototype.supportsFullScreen = t.Player.prototype.Fa;
    t.Player.prototype.currentType = t.Player.prototype.ld;
    t.Player.prototype.language = t.Player.prototype.language;
    t.Player.prototype.languages = t.Player.prototype.Wa;
    $("videojs.MediaLoader", t.bd);
    $("videojs.TextTrackDisplay", t.gc);
    $("videojs.ControlBar", t.Ka);
    $("videojs.Button", t.t);
    $("videojs.PlayToggle", t.bc);
    $("videojs.FullscreenToggle", t.La);
    $("videojs.BigPlayButton", t.gb);
    $("videojs.LoadingSpinner", t.$b);
    $("videojs.CurrentTimeDisplay", t.ib);
    $("videojs.DurationDisplay", t.jb);
    $("videojs.TimeDivider", t.hc);
    $("videojs.RemainingTimeDisplay", t.qb);
    $("videojs.LiveDisplay", t.Zb);
    $("videojs.ErrorDisplay", t.kb);
    $("videojs.Slider", t.Q);
    $("videojs.ProgressControl", t.pb);
    $("videojs.SeekBar", t.dc);
    $("videojs.LoadProgressBar", t.mb);
    $("videojs.PlayProgressBar", t.ac);
    $("videojs.SeekHandle", t.Na);
    $("videojs.VolumeControl", t.sb);
    $("videojs.VolumeBar", t.rb);
    $("videojs.VolumeLevel", t.ic);
    $("videojs.VolumeMenuButton", t.sa);
    $("videojs.VolumeHandle", t.tb);
    $("videojs.MuteToggle", t.ia);
    $("videojs.PosterImage", t.Ma);
    $("videojs.Menu", t.ha);
    $("videojs.MenuItem", t.I);
    $("videojs.MenuButton", t.L);
    $("videojs.PlaybackRateMenuButton", t.cc);
    t.L.prototype.createItems = t.L.prototype.wa;
    t.W.prototype.createItems = t.W.prototype.wa;
    t.Ja.prototype.createItems = t.Ja.prototype.wa;
    $("videojs.SubtitlesButton", t.Oa);
    $("videojs.CaptionsButton", t.Ia);
    $("videojs.ChaptersButton", t.Ja);
    $("videojs.MediaTechController", t.u);
    t.u.prototype.features = t.u.prototype.o;
    t.u.prototype.o.volumeControl = t.u.prototype.o.Rc;
    t.u.prototype.o.fullscreenResize = t.u.prototype.o.me;
    t.u.prototype.o.progressEvents = t.u.prototype.o.pe;
    t.u.prototype.o.timeupdateEvents = t.u.prototype.o.se;
    t.u.prototype.setPoster = t.u.prototype.Ic;
    $("videojs.Html5", t.g);
    t.g.Events = t.g.lb;
    t.g.isSupported = t.g.isSupported;
    t.g.canPlaySource = t.g.wb;
    t.g.patchCanPlayType = t.g.Bc;
    t.g.unpatchCanPlayType = t.g.he;
    t.g.prototype.setCurrentTime = t.g.prototype.Wd;
    t.g.prototype.setVolume = t.g.prototype.be;
    t.g.prototype.setMuted = t.g.prototype.Zd;
    t.g.prototype.setPreload = t.g.prototype.ae;
    t.g.prototype.setAutoplay = t.g.prototype.Vd;
    t.g.prototype.setLoop = t.g.prototype.Yd;
    t.g.prototype.enterFullScreen = t.g.prototype.pc;
    t.g.prototype.exitFullScreen = t.g.prototype.td;
    t.g.prototype.playbackRate = t.g.prototype.playbackRate;
    t.g.prototype.setPlaybackRate = t.g.prototype.$d;
    $("videojs.Flash", t.f);
    t.f.isSupported = t.f.isSupported;
    t.f.canPlaySource = t.f.wb;
    t.f.onReady = t.f.onReady;
    $("videojs.TextTrack", t.D);
    t.D.prototype.label = t.D.prototype.label;
    t.D.prototype.kind = t.D.prototype.K;
    t.D.prototype.mode = t.D.prototype.mode;
    t.D.prototype.cues = t.D.prototype.kd;
    t.D.prototype.activeCues = t.D.prototype.dd;
    $("videojs.CaptionsTrack", t.Xb);
    $("videojs.SubtitlesTrack", t.ec);
    $("videojs.ChaptersTrack", t.Yb);
    $("videojs.autoSetup", t.kc);
    $("videojs.plugin", t.Td);
    $("videojs.createTimeRange", t.Ab);
    $("videojs.util", t.qa);
    t.qa.mergeOptions = t.qa.Nb;
})();
