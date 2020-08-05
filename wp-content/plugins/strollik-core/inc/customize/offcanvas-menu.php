<?php
$mode = get_theme_mod('osf_mobile_effect_menu', 3);
switch ($mode){
    case 1:
        return <<<CSS
.opal-menu-effect-1 .opal-menu-canvas {
    z-index: 102;
    visibility: visible;
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0);
}

.opal-menu-effect-1 .opal-canvas-open .opal-menu-canvas {
    visibility: visible;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
}
CSS;
    case 2:
        return <<<CSS
.opal-menu-effect-2 .opal-canvas-open #page {
    z-index: 101;
    -webkit-transform: translate3d(300px, 0, 0);
    transform: translate3d(300px, 0, 0);
}

.opal-menu-effect-2 .opal-canvas-open .opal-menu-canvas {
    visibility: visible;
    -webkit-transition: -webkit-transform 0.5s;
    transition: transform 0.5s;
}

.opal-menu-effect-2 .opal-canvas-open .opal-overlay {
    z-index: 101;
}
CSS;
    case 3:
        return <<<CSS
.opal-menu-effect-3 .opal-menu-canvas {
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0);
}

.opal-menu-effect-3 .opal-canvas-open #page {
    -webkit-transform: translate3d(300px, 0, 0);
    transform: translate3d(300px, 0, 0);
}

.opal-menu-effect-3 .opal-canvas-open .opal-menu-canvas {
    visibility: visible;
    -webkit-transition: -webkit-transform 0.5s;
    transition: transform 0.5s;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
}
CSS;
    case 4:
        return <<<CSS
.opal-menu-effect-4 .opal-menu-canvas {
    -webkit-transform: translate3d(-50%, 0, 0);
    transform: translate3d(-50%, 0, 0);
}

.opal-menu-effect-4 .opal-canvas-open #page {
    -webkit-transform: translate3d(300px, 0, 0);
    transform: translate3d(300px, 0, 0);
}

.opal-menu-effect-4 .opal-canvas-open .opal-menu-canvas {
    visibility: visible;
    -webkit-transition: -webkit-transform 0.5s;
    transition: transform 0.5s;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
}
CSS;
    case 5:
        return <<<CSS
.opal-menu-effect-5 .opal-menu-canvas {
    -webkit-transform: translate3d(50%, 0, 0);
    transform: translate3d(50%, 0, 0);
}

.opal-menu-effect-5 .opal-canvas-open #page {
    z-index: 101;
    -webkit-transform: translate3d(300px, 0, 0);
    transform: translate3d(300px, 0, 0);
}

.opal-menu-effect-5 .opal-canvas-open .opal-menu-canvas {
    visibility: visible;
    -webkit-transition: -webkit-transform 0.5s;
    transition: transform 0.5s;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
}
CSS;
    case 6:
        return <<<CSS
.opal-menu-effect-6 .opal-wrapper {
    -webkit-perspective: 1500px;
    perspective: 1500px;
}

.opal-menu-effect-6 #page {
    -webkit-transform-origin: 0% 50%;
    transform-origin: 0% 50%;
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
}

.opal-menu-effect-6 .opal-menu-canvas {
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0);
    -webkit-transform-origin: 100% 50%;
    transform-origin: 100% 50%;
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
}

.opal-menu-effect-6 .opal-canvas-open #page {
    -webkit-transform: translate3d(300px, 0, 0) rotateY(-0.5deg);
    transform: translate3d(300px, 0, 0) rotateY(-0.5deg);
}

.opal-menu-effect-6 .opal-canvas-open .opal-menu-canvas {
    visibility: visible;
    -webkit-transition: -webkit-transform 0.5s;
    transition: transform 0.5s;
    -webkit-transform: translate3d(0, 0, 0) rotateY(0deg);
    transform: translate3d(0, 0, 0) rotateY(0deg);
}
CSS;
    case 7:
        return <<<CSS
.opal-menu-effect-7 .opal-wrapper {
    -webkit-perspective: 1500px;
    perspective: 1500px;
    -webkit-perspective-origin: 0% 50%;
    perspective-origin: 0% 50%;
}

.opal-menu-effect-7 #page {
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
}

.opal-menu-effect-7 .opal-menu-canvas {
    -webkit-transform: translate3d(0, 0, 0) rotateY(-90deg);
    transform: translate3d(0, 0, 0) rotateY(-90deg);
    -webkit-transform-origin: 100% 50%;
    transform-origin: 100% 50%;
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
}

.opal-menu-effect-7 .opal-canvas-open #page {
    -webkit-transform: translate3d(300px, 0, 0);
    transform: translate3d(300px, 0, 0);
}

.opal-menu-effect-7 .opal-canvas-open .opal-menu-canvas {
    visibility: visible;
    -webkit-transition: -webkit-transform 0.5s;
    transition: transform 0.5s;
    -webkit-transform: translate3d(0, 0, 0) rotateY(0deg);
    transform: translate3d(0, 0, 0) rotateY(0deg);
}
CSS;
    case 8:
        return <<<CSS
.opal-menu-effect-8 .opal-wrapper {
    -webkit-perspective: 1500px;
    perspective: 1500px;
    -webkit-perspective-origin: 0% 50%;
    perspective-origin: 0% 50%;
}

.opal-menu-effect-8 #page {
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
}

.opal-menu-effect-8 .opal-menu-canvas {
    -webkit-transform: translate3d(-100%, 0, 0) rotateY(90deg);
    transform: translate3d(-100%, 0, 0) rotateY(90deg);
    -webkit-transform-origin: 100% 50%;
    transform-origin: 100% 50%;
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
}

.opal-menu-effect-8 .opal-canvas-open #page {
    -webkit-transform: translate3d(300px, 0, 0);
    transform: translate3d(300px, 0, 0);
}

.opal-menu-effect-8 .opal-canvas-open .opal-menu-canvas {
    visibility: visible;
    -webkit-transition: -webkit-transform 0.5s;
    transition: transform 0.5s;
    -webkit-transform: translate3d(0, 0, 0) rotateY(0deg);
    transform: translate3d(0, 0, 0) rotateY(0deg);
}
CSS;
    case 9:
        return <<<CSS
.opal-menu-effect-9 .opal-wrapper {
    -webkit-perspective: 1500px;
    perspective: 1500px;
}

.opal-menu-effect-9 #page {
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
}

.opal-menu-effect-9 .opal-menu-canvas {
    opacity: 1;
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0);
}

.opal-menu-effect-9 .opal-canvas-open #page {
    -webkit-transform: translate3d(0, 0, -300px);
    transform: translate3d(0, 0, -300px);
}

.opal-menu-effect-9 .opal-canvas-open .opal-menu-canvas {
    visibility: visible;
    -webkit-transition: -webkit-transform 0.5s;
    transition: transform 0.5s;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
}
CSS;
    case 10:
        return <<<CSS
.opal-menu-effect-10 .opal-wrapper {
    -webkit-perspective: 1500px;
    perspective: 1500px;
    -webkit-perspective-origin: 0% 50%;
    perspective-origin: 0% 50%;
}

.opal-menu-effect-10 #page {
    height: 100%;
    overflow: hidden;
    left: 0;
}

.opal-menu-effect-10 .opal-menu-canvas {
    z-index: 100;
    opacity: 1;
    -webkit-transform: translate3d(0, 0, -300px);
    transform: translate3d(0, 0, -300px);
}

.opal-menu-effect-10 .opal-canvas-open #page {
    -webkit-transform: translate3d(300px, 0, 0);
    transform: translate3d(300px, 0, 0);
}

.opal-menu-effect-10 .opal-canvas-open .opal-menu-canvas {
    visibility: visible;
    -webkit-transition: -webkit-transform 0.5s;
    transition: transform 0.5s;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
}
CSS;
    case 11:
        return <<<CSS
.opal-menu-effect-11 .opal-wrapper {
    -webkit-perspective: 1500px;
    perspective: 1500px;
}

.opal-menu-effect-11 #page {
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
}

.opal-menu-effect-11 .opal-menu-canvas {
    opacity: 1;
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0);
}

.opal-menu-effect-11 .opal-canvas-open #page {
    -webkit-transform: translate3d(100px, 0, -600px) rotateY(-20deg);
    transform: translate3d(100px, 0, -600px) rotateY(-20deg);
}

.opal-menu-effect-11 .opal-canvas-open .opal-menu-canvas {
    visibility: visible;
    -webkit-transition: -webkit-transform 0.5s;
    transition: transform 0.5s;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
}
CSS;
    case 12:
        return <<<CSS
.opal-menu-effect-12 .opal-wrapper {
    -webkit-perspective: 1500px;
    perspective: 1500px;
}

.opal-menu-effect-12 #page {
    -webkit-transform-origin: 100% 50%;
    transform-origin: 100% 50%;
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
}

.opal-menu-effect-12 .opal-menu-canvas {
    opacity: 1;
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0);
}

.opal-menu-effect-12 .opal-canvas-open #page {
    -webkit-transform: rotateY(-10deg);
    transform: rotateY(-10deg);
}

.opal-menu-effect-12 .opal-canvas-open .opal-menu-canvas {
    visibility: visible;
    -webkit-transition: -webkit-transform 0.5s;
    transition: transform 0.5s;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
}
CSS;
    case 13:
        return <<<CSS
.opal-menu-effect-13 .opal-wrapper {
    -webkit-perspective: 1500px;
    perspective: 1500px;
    -webkit-perspective-origin: 0% 50%;
    perspective-origin: 0% 50%;
}

.opal-menu-effect-13 #page {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
}

.opal-menu-effect-13 .opal-menu-canvas {
    z-index: 1;
    opacity: 1;
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0);
}

.opal-menu-effect-13 .opal-canvas-open .opal-menu-canvas {
    z-index: 100;
    visibility: visible;
    -webkit-transition-timing-function: ease-in-out;
    transition-timing-function: ease-in-out;
    -webkit-transition-property: -webkit-transform;
    transition-property: transform;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    -webkit-transition-speed: 0.2s;
    transition-speed: 0.2s;
}

.opal-menu-effect-13 .opal-canvas-open #page {
    -webkit-transform: translate3d(300px, 0, 0);
    transform: translate3d(300px, 0, 0);
}
CSS;
    case 14:
        return <<<CSS
.opal-menu-effect-14 .opal-wrapper {
    -webkit-perspective: 1500px;
    perspective: 1500px;
    -webkit-perspective-origin: 0% 50%;
    perspective-origin: 0% 50%;
}

.opal-menu-effect-14 #page {
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
}

.opal-menu-effect-14 .opal-menu-canvas {
    -webkit-transform: translate3d(0%, 0, 0) rotateY(90deg);
    transform: translate3d(0%, 0, 0) rotateY(90deg);
    -webkit-transform-origin: 0% 50%;
    transform-origin: 0% 50%;
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
}

.opal-menu-effect-14 .opal-canvas-open #page {
    -webkit-transform: translate3d(300px, 0, 0);
    transform: translate3d(300px, 0, 0);
}

.opal-menu-effect-14 .opal-canvas-open .opal-menu-canvas {
    visibility: visible;
    -webkit-transition-delay: 0.1s;
    transition-delay: 0.1s;
    -webkit-transition-timing-function: ease-in-out;
    transition-timing-function: ease-in-out;
    -webkit-transition-property: -webkit-transform;
    transition-property: transform;
    -webkit-transform: translate3d(0, 0, 0) rotateY(0deg);
    transform: translate3d(0, 0, 0) rotateY(0deg);
}
CSS;
}
return '';