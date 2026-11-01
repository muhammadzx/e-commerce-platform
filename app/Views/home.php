<?php
require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/bootstrap.php';
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Plants, pots &amp; everyday growing | Nabta Botanical</title>
  <meta name="description"
    content="Buy and sell plants, ceramic pots, soil, tools, botanical decor and plant-care essentials at Nabta. A little nature, closer to home." />
  <meta name="robots" content="index,follow" />
  <meta name="theme-color" content="#051f20" />
  <link rel="icon" href="<?= htmlspecialchars(nabta_public_url('assets/img/favicon.svg'), ENT_QUOTES, 'UTF-8') ?>" type="image/svg+xml" />
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/style.css?v=10'), ENT_QUOTES, 'UTF-8') ?>" />
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/botanical.css?v=10'), ENT_QUOTES, 'UTF-8') ?>" />
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/layout-review.css?v=10'), ENT_QUOTES, 'UTF-8') ?>" />
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/bundlesLandingPage.css?v=11'), ENT_QUOTES, 'UTF-8') ?>" />
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/alive.css?v=12'), ENT_QUOTES, 'UTF-8') ?>" />
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/nabta-theme.css?v=18'), ENT_QUOTES, 'UTF-8') ?>" />
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/nabta-theme-copy.css?v=18'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/store-responsive.css?v=20261101'), ENT_QUOTES, 'UTF-8') ?>">
</head>

<body class="garden-home botanical-edition index-page">
  <?php require __DIR__ . "/layouts/header.php"; ?>
  <main id="main">
    <div class="container">
      <section class="promo-slider screen" aria-label="Seasonal promotions">
        <input class="slide-radio" type="radio" name="promotion" id="promo-0" checked
          aria-label="Promotion 1: Your everyday. A little wilder." /><input class="slide-radio" type="radio"
          name="promotion" id="promo-1" aria-label="Promotion 2: Small plant. Big difference." /><input
          class="slide-radio" type="radio" name="promotion" id="promo-2"
          aria-label="Promotion 3: Good roots. Better beginnings." /><svg width="0" height="0"
          style="position: absolute" aria-hidden="true">
          <defs>
            <linearGradient id="gA" x1="0" x2="1">
              <stop offset="0" stop-color="var(--leaf)" />
              <stop offset="1" stop-color="var(--leaf)" />
            </linearGradient>
            <linearGradient id="gB" x1="0" x2="1">
              <stop offset="0" stop-color="var(--leaf)" />
              <stop offset="1" stop-color="var(--sage)" />
            </linearGradient>
            <linearGradient id="gC" x1="0" x2="1">
              <stop offset="0" stop-color="var(--leaf)" />
              <stop offset="1" stop-color="var(--sage)" />
            </linearGradient>
            <g id="lfA">
              <path d="M0 0C20-9 62-11 100 0C62 11 20 9 0 0Z" fill="url(#gA)" />
              <path d="M4 0H90" stroke="var(--mint)" stroke-opacity=".45" stroke-width="1.2" />
            </g>
            <g id="lfB">
              <path d="M0 0C18-10 60-12 100 0C60 12 18 10 0 0Z" fill="url(#gB)" />
              <path d="M4 0H90" stroke="var(--mint)" stroke-opacity=".5" stroke-width="1.2" />
            </g>
            <g id="lfC">
              <path d="M0 0C20-8 58-9 100 0C58 9 20 8 0 0Z" fill="url(#gC)" />
              <path d="M4 0H90" stroke="var(--mint)" stroke-opacity=".55" stroke-width="1" />
            </g>
          </defs>
        </svg>
        <div class="alive" aria-hidden="true">
          <div class="alive-rays"></div>
          <svg class="fol fol-a" viewBox="0 0 640 520" aria-hidden="true">
            <g class="br" style="--t: 10s; --d: -1s">
              <path d="M-30 -20C190 0 330 70 420 250" fill="none" stroke="var(--leaf)" stroke-width="3"
                stroke-linecap="round" />
              <g transform="translate(16 -15) rotate(-31) scale(0.61)">
                <use class="fl" href="#lfC" style="--t: 3.6s; --d: -4.1s" />
              </g>
              <g transform="translate(16 -15) rotate(58) scale(0.56)">
                <use class="fl" href="#lfC" style="--t: 4.1s; --d: -0.4s" />
              </g>
              <g transform="translate(59 -8) rotate(-31) scale(0.61)">
                <use class="fl" href="#lfC" style="--t: 4.8s; --d: -4.1s" />
              </g>
              <g transform="translate(59 -8) rotate(50) scale(0.54)">
                <use class="fl" href="#lfC" style="--t: 5.2s; --d: -0.3s" />
              </g>
              <g transform="translate(101 0) rotate(-22) scale(0.62)">
                <use class="fl" href="#lfA" style="--t: 3.6s; --d: -4.3s" />
              </g>
              <g transform="translate(101 0) rotate(51) scale(0.56)">
                <use class="fl" href="#lfA" style="--t: 5.2s; --d: -2.8s" />
              </g>
              <g transform="translate(140 11) rotate(-20) scale(0.61)">
                <use class="fl" href="#lfC" style="--t: 5.4s; --d: -1.9s" />
              </g>
              <g transform="translate(140 11) rotate(53) scale(0.59)">
                <use class="fl" href="#lfA" style="--t: 5.4s; --d: -2.5s" />
              </g>
              <g transform="translate(176 23) rotate(-35) scale(0.55)">
                <use class="fl" href="#lfB" style="--t: 5.3s; --d: -2.3s" />
              </g>
              <g transform="translate(176 23) rotate(77) scale(0.51)">
                <use class="fl" href="#lfC" style="--t: 5.8s; --d: -0.4s" />
              </g>
              <g transform="translate(211 38) rotate(-23) scale(0.48)">
                <use class="fl" href="#lfB" style="--t: 5.7s; --d: -1.4s" />
              </g>
              <g transform="translate(211 38) rotate(63) scale(0.61)">
                <use class="fl" href="#lfB" style="--t: 4s; --d: -1.7s" />
              </g>
              <g transform="translate(244 55) rotate(-16) scale(0.57)">
                <use class="fl" href="#lfC" style="--t: 3.7s; --d: -2.8s" />
              </g>
              <g transform="translate(244 55) rotate(87) scale(0.55)">
                <use class="fl" href="#lfB" style="--t: 5.6s; --d: -3s" />
              </g>
              <g transform="translate(274 74) rotate(-12) scale(0.48)">
                <use class="fl" href="#lfA" style="--t: 6.3s; --d: -2.4s" />
              </g>
              <g transform="translate(274 74) rotate(71) scale(0.50)">
                <use class="fl" href="#lfC" style="--t: 4.4s; --d: -2.9s" />
              </g>
              <g transform="translate(303 97) rotate(-6) scale(0.47)">
                <use class="fl" href="#lfC" style="--t: 4.7s; --d: -3.3s" />
              </g>
              <g transform="translate(303 97) rotate(87) scale(0.37)">
                <use class="fl" href="#lfA" style="--t: 5.3s; --d: -2.5s" />
              </g>
              <g transform="translate(330 121) rotate(3) scale(0.37)">
                <use class="fl" href="#lfC" style="--t: 4.2s; --d: -2s" />
              </g>
              <g transform="translate(330 121) rotate(81) scale(0.47)">
                <use class="fl" href="#lfB" style="--t: 4.7s; --d: -1.4s" />
              </g>
              <g transform="translate(355 149) rotate(4) scale(0.34)">
                <use class="fl" href="#lfC" style="--t: 4.3s; --d: -2.1s" />
              </g>
              <g transform="translate(355 149) rotate(109) scale(0.37)">
                <use class="fl" href="#lfA" style="--t: 4s; --d: -0.9s" />
              </g>
              <g transform="translate(378 179) rotate(14) scale(0.33)">
                <use class="fl" href="#lfB" style="--t: 6s; --d: -0.9s" />
              </g>
              <g transform="translate(378 179) rotate(93) scale(0.33)">
                <use class="fl" href="#lfC" style="--t: 4.6s; --d: -2.8s" />
              </g>
              <g transform="translate(400 213) rotate(6) scale(0.39)">
                <use class="fl" href="#lfC" style="--t: 6.4s; --d: -3.3s" />
              </g>
              <g transform="translate(400 213) rotate(106) scale(0.36)">
                <use class="fl" href="#lfC" style="--t: 5.9s; --d: -2s" />
              </g>
              <g transform="translate(420 250) rotate(27) scale(0.30)">
                <use class="fl" href="#lfC" style="--t: 4.7s; --d: -1s" />
              </g>
              <g transform="translate(420 250) rotate(110) scale(0.36)">
                <use class="fl" href="#lfA" style="--t: 4.5s; --d: -0.3s" />
              </g>
              <g transform="translate(420 250) rotate(63) scale(0.21)">
                <use class="fl" href="#lfC" />
              </g>
            </g>
            <g class="br" style="--t: 8s; --d: -3s">
              <path d="M-20 -10C20 110 90 200 50 330" fill="none" stroke="var(--leaf)" stroke-width="3"
                stroke-linecap="round" />
              <g transform="translate(-7 25) rotate(31) scale(0.44)">
                <use class="fl" href="#lfA" style="--t: 6.3s; --d: -3.1s" />
              </g>
              <g transform="translate(-7 25) rotate(109) scale(0.45)">
                <use class="fl" href="#lfB" style="--t: 3.9s; --d: -1.3s" />
              </g>
              <g transform="translate(6 59) rotate(23) scale(0.48)">
                <use class="fl" href="#lfA" style="--t: 3.8s; --d: -2.4s" />
              </g>
              <g transform="translate(6 59) rotate(115) scale(0.59)">
                <use class="fl" href="#lfB" style="--t: 3.8s; --d: -0.5s" />
              </g>
              <g transform="translate(20 92) rotate(26) scale(0.45)">
                <use class="fl" href="#lfC" style="--t: 4s; --d: -0.1s" />
              </g>
              <g transform="translate(20 92) rotate(116) scale(0.55)">
                <use class="fl" href="#lfA" style="--t: 5.6s; --d: -4.6s" />
              </g>
              <g transform="translate(33 124) rotate(26) scale(0.48)">
                <use class="fl" href="#lfC" style="--t: 6.1s; --d: -3.5s" />
              </g>
              <g transform="translate(33 124) rotate(113) scale(0.40)">
                <use class="fl" href="#lfA" style="--t: 4.6s; --d: -1.1s" />
              </g>
              <g transform="translate(45 156) rotate(24) scale(0.42)">
                <use class="fl" href="#lfC" style="--t: 4.2s; --d: -4.1s" />
              </g>
              <g transform="translate(45 156) rotate(130) scale(0.48)">
                <use class="fl" href="#lfA" style="--t: 6s; --d: -3.7s" />
              </g>
              <g transform="translate(54 189) rotate(28) scale(0.34)">
                <use class="fl" href="#lfB" style="--t: 5.7s; --d: -4.9s" />
              </g>
              <g transform="translate(54 189) rotate(124) scale(0.42)">
                <use class="fl" href="#lfA" style="--t: 5.6s; --d: -4.8s" />
              </g>
              <g transform="translate(60 222) rotate(23) scale(0.34)">
                <use class="fl" href="#lfB" style="--t: 6.4s; --d: -1.8s" />
              </g>
              <g transform="translate(60 222) rotate(124) scale(0.31)">
                <use class="fl" href="#lfA" style="--t: 4.5s; --d: -2.4s" />
              </g>
              <g transform="translate(62 256) rotate(40) scale(0.37)">
                <use class="fl" href="#lfA" style="--t: 4.9s; --d: -3.3s" />
              </g>
              <g transform="translate(62 256) rotate(127) scale(0.35)">
                <use class="fl" href="#lfC" style="--t: 3.9s; --d: -1.9s" />
              </g>
              <g transform="translate(59 292) rotate(59) scale(0.31)">
                <use class="fl" href="#lfA" style="--t: 4.8s; --d: -3.2s" />
              </g>
              <g transform="translate(59 292) rotate(159) scale(0.24)">
                <use class="fl" href="#lfC" style="--t: 4.7s; --d: -2s" />
              </g>
              <g transform="translate(50 330) rotate(53) scale(0.30)">
                <use class="fl" href="#lfA" style="--t: 6.5s; --d: -0.1s" />
              </g>
              <g transform="translate(50 330) rotate(154) scale(0.26)">
                <use class="fl" href="#lfC" style="--t: 3.9s; --d: -4.1s" />
              </g>
              <g transform="translate(50 330) rotate(107) scale(0.17)">
                <use class="fl" href="#lfC" />
              </g>
            </g>
            <g class="br" style="--t: 12s; --d: -5s">
              <path d="M-20 -20C240 10 380 40 560 40" fill="none" stroke="var(--leaf)" stroke-width="3"
                stroke-linecap="round" />
              <g transform="translate(43 -13) rotate(-45) scale(0.57)">
                <use class="fl" href="#lfB" style="--t: 4s; --d: -2.7s" />
              </g>
              <g transform="translate(43 -13) rotate(63) scale(0.40)">
                <use class="fl" href="#lfC" style="--t: 5.4s; --d: -2.6s" />
              </g>
              <g transform="translate(101 -5) rotate(-39) scale(0.53)">
                <use class="fl" href="#lfA" style="--t: 6s; --d: -1.1s" />
              </g>
              <g transform="translate(101 -5) rotate(50) scale(0.42)">
                <use class="fl" href="#lfA" style="--t: 5.8s; --d: -1.6s" />
              </g>
              <g transform="translate(155 2) rotate(-50) scale(0.44)">
                <use class="fl" href="#lfA" style="--t: 6.2s; --d: -1.8s" />
              </g>
              <g transform="translate(155 2) rotate(58) scale(0.43)">
                <use class="fl" href="#lfC" style="--t: 4.8s; --d: -4.6s" />
              </g>
              <g transform="translate(206 9) rotate(-41) scale(0.41)">
                <use class="fl" href="#lfC" style="--t: 5s; --d: -4.4s" />
              </g>
              <g transform="translate(206 9) rotate(59) scale(0.46)">
                <use class="fl" href="#lfA" style="--t: 4s; --d: -2.4s" />
              </g>
              <g transform="translate(254 15) rotate(-42) scale(0.42)">
                <use class="fl" href="#lfB" style="--t: 5.5s; --d: -2.7s" />
              </g>
              <g transform="translate(254 15) rotate(63) scale(0.39)">
                <use class="fl" href="#lfC" style="--t: 3.7s; --d: -1s" />
              </g>
              <g transform="translate(300 21) rotate(-30) scale(0.31)">
                <use class="fl" href="#lfB" style="--t: 5.2s; --d: -3.8s" />
              </g>
              <g transform="translate(300 21) rotate(54) scale(0.42)">
                <use class="fl" href="#lfC" style="--t: 6.4s; --d: -3s" />
              </g>
              <g transform="translate(344 27) rotate(-35) scale(0.31)">
                <use class="fl" href="#lfC" style="--t: 5.1s; --d: -2.4s" />
              </g>
              <g transform="translate(344 27) rotate(60) scale(0.40)">
                <use class="fl" href="#lfB" style="--t: 6.3s; --d: -4.5s" />
              </g>
              <g transform="translate(387 31) rotate(-41) scale(0.29)">
                <use class="fl" href="#lfB" style="--t: 3.9s; --d: -2.2s" />
              </g>
              <g transform="translate(387 31) rotate(46) scale(0.27)">
                <use class="fl" href="#lfA" style="--t: 4.1s; --d: -1.5s" />
              </g>
              <g transform="translate(430 35) rotate(-51) scale(0.26)">
                <use class="fl" href="#lfC" style="--t: 5.4s; --d: -1.8s" />
              </g>
              <g transform="translate(430 35) rotate(42) scale(0.27)">
                <use class="fl" href="#lfB" style="--t: 4.2s; --d: -4.8s" />
              </g>
              <g transform="translate(473 38) rotate(-45) scale(0.26)">
                <use class="fl" href="#lfC" style="--t: 6s; --d: -0.8s" />
              </g>
              <g transform="translate(473 38) rotate(52) scale(0.27)">
                <use class="fl" href="#lfB" style="--t: 4.8s; --d: -1.8s" />
              </g>
              <g transform="translate(516 39) rotate(-43) scale(0.21)">
                <use class="fl" href="#lfB" style="--t: 5.2s; --d: -2.2s" />
              </g>
              <g transform="translate(516 39) rotate(45) scale(0.21)">
                <use class="fl" href="#lfC" style="--t: 4.4s; --d: -4.8s" />
              </g>
              <g transform="translate(560 40) rotate(-60) scale(0.20)">
                <use class="fl" href="#lfA" style="--t: 6.4s; --d: -0.5s" />
              </g>
              <g transform="translate(560 40) rotate(35) scale(0.21)">
                <use class="fl" href="#lfA" style="--t: 4.3s; --d: -0.6s" />
              </g>
              <g transform="translate(560 40) rotate(0) scale(0.16)">
                <use class="fl" href="#lfC" />
              </g>
            </g>
          </svg><svg class="fol fol-b" viewBox="0 0 560 480" aria-hidden="true">
            <g class="br" style="--t: 11s; --d: -2s">
              <path d="M-30 -20C170 10 300 90 380 290" fill="none" stroke="var(--leaf)" stroke-width="3"
                stroke-linecap="round" />
              <g transform="translate(15 -12) rotate(-48) scale(0.58)">
                <use class="fl" href="#lfB" style="--t: 4.7s; --d: -2.7s" />
              </g>
              <g transform="translate(15 -12) rotate(59) scale(0.60)">
                <use class="fl" href="#lfB" style="--t: 3.8s; --d: -0.3s" />
              </g>
              <g transform="translate(57 -2) rotate(-31) scale(0.61)">
                <use class="fl" href="#lfA" style="--t: 4.3s; --d: -0.1s" />
              </g>
              <g transform="translate(57 -2) rotate(56) scale(0.49)">
                <use class="fl" href="#lfC" style="--t: 6.1s; --d: -0.3s" />
              </g>
              <g transform="translate(98 10) rotate(-28) scale(0.62)">
                <use class="fl" href="#lfB" style="--t: 6.5s; --d: -2.1s" />
              </g>
              <g transform="translate(98 10) rotate(70) scale(0.63)">
                <use class="fl" href="#lfA" style="--t: 5.1s; --d: -1.2s" />
              </g>
              <g transform="translate(135 24) rotate(-16) scale(0.45)">
                <use class="fl" href="#lfA" style="--t: 4s; --d: -4.7s" />
              </g>
              <g transform="translate(135 24) rotate(72) scale(0.54)">
                <use class="fl" href="#lfA" style="--t: 4.4s; --d: -2.5s" />
              </g>
              <g transform="translate(171 41) rotate(-16) scale(0.44)">
                <use class="fl" href="#lfA" style="--t: 6.5s; --d: -0.2s" />
              </g>
              <g transform="translate(171 41) rotate(76) scale(0.41)">
                <use class="fl" href="#lfA" style="--t: 5s; --d: -1.2s" />
              </g>
              <g transform="translate(204 60) rotate(-19) scale(0.46)">
                <use class="fl" href="#lfC" style="--t: 4.8s; --d: -2.5s" />
              </g>
              <g transform="translate(204 60) rotate(78) scale(0.52)">
                <use class="fl" href="#lfC" style="--t: 4.4s; --d: -1.1s" />
              </g>
              <g transform="translate(235 83) rotate(-1) scale(0.40)">
                <use class="fl" href="#lfC" style="--t: 5.7s; --d: -0.7s" />
              </g>
              <g transform="translate(235 83) rotate(100) scale(0.52)">
                <use class="fl" href="#lfA" style="--t: 3.5s; --d: -3.1s" />
              </g>
              <g transform="translate(264 109) rotate(-2) scale(0.47)">
                <use class="fl" href="#lfA" style="--t: 3.8s; --d: -4.2s" />
              </g>
              <g transform="translate(264 109) rotate(97) scale(0.47)">
                <use class="fl" href="#lfB" style="--t: 5.3s; --d: -3.5s" />
              </g>
              <g transform="translate(291 137) rotate(10) scale(0.32)">
                <use class="fl" href="#lfB" style="--t: 4.8s; --d: -1.3s" />
              </g>
              <g transform="translate(291 137) rotate(111) scale(0.45)">
                <use class="fl" href="#lfC" style="--t: 4.5s; --d: -0.2s" />
              </g>
              <g transform="translate(316 170) rotate(15) scale(0.41)">
                <use class="fl" href="#lfA" style="--t: 3.5s; --d: -1.9s" />
              </g>
              <g transform="translate(316 170) rotate(103) scale(0.36)">
                <use class="fl" href="#lfA" style="--t: 4.2s; --d: -3.9s" />
              </g>
              <g transform="translate(339 206) rotate(3) scale(0.28)">
                <use class="fl" href="#lfA" style="--t: 4.7s; --d: -0.2s" />
              </g>
              <g transform="translate(339 206) rotate(102) scale(0.28)">
                <use class="fl" href="#lfA" style="--t: 3.8s; --d: -4.8s" />
              </g>
              <g transform="translate(361 246) rotate(26) scale(0.35)">
                <use class="fl" href="#lfC" style="--t: 5.9s; --d: -3s" />
              </g>
              <g transform="translate(361 246) rotate(118) scale(0.34)">
                <use class="fl" href="#lfB" style="--t: 3.9s; --d: -3.6s" />
              </g>
              <g transform="translate(380 290) rotate(33) scale(0.30)">
                <use class="fl" href="#lfC" style="--t: 6.2s; --d: -3.1s" />
              </g>
              <g transform="translate(380 290) rotate(125) scale(0.30)">
                <use class="fl" href="#lfA" style="--t: 6.2s; --d: -3.8s" />
              </g>
              <g transform="translate(380 290) rotate(68) scale(0.19)">
                <use class="fl" href="#lfC" />
              </g>
            </g>
            <g class="br" style="--t: 9s; --d: -6s">
              <path d="M-20 -10C50 100 110 190 80 330" fill="none" stroke="var(--leaf)" stroke-width="3"
                stroke-linecap="round" />
              <g transform="translate(3 26) rotate(1) scale(0.49)">
                <use class="fl" href="#lfA" style="--t: 6s; --d: -2.9s" />
              </g>
              <g transform="translate(3 26) rotate(111) scale(0.54)">
                <use class="fl" href="#lfC" style="--t: 5.4s; --d: -0.4s" />
              </g>
              <g transform="translate(24 61) rotate(8) scale(0.37)">
                <use class="fl" href="#lfA" style="--t: 4.6s; --d: -2.3s" />
              </g>
              <g transform="translate(24 61) rotate(94) scale(0.37)">
                <use class="fl" href="#lfC" style="--t: 5.5s; --d: -2.4s" />
              </g>
              <g transform="translate(44 96) rotate(6) scale(0.34)">
                <use class="fl" href="#lfC" style="--t: 6.3s; --d: -4.5s" />
              </g>
              <g transform="translate(44 96) rotate(111) scale(0.35)">
                <use class="fl" href="#lfC" style="--t: 5.7s; --d: -1.3s" />
              </g>
              <g transform="translate(60 131) rotate(25) scale(0.32)">
                <use class="fl" href="#lfC" style="--t: 5.8s; --d: -1.2s" />
              </g>
              <g transform="translate(60 131) rotate(114) scale(0.40)">
                <use class="fl" href="#lfB" style="--t: 3.7s; --d: -4.6s" />
              </g>
              <g transform="translate(74 167) rotate(37) scale(0.33)">
                <use class="fl" href="#lfC" style="--t: 5.4s; --d: -0.4s" />
              </g>
              <g transform="translate(74 167) rotate(114) scale(0.31)">
                <use class="fl" href="#lfC" style="--t: 5.6s; --d: -3.1s" />
              </g>
              <g transform="translate(83 204) rotate(32) scale(0.28)">
                <use class="fl" href="#lfB" style="--t: 4.3s; --d: -3.4s" />
              </g>
              <g transform="translate(83 204) rotate(132) scale(0.34)">
                <use class="fl" href="#lfB" style="--t: 5.6s; --d: -1.4s" />
              </g>
              <g transform="translate(88 243) rotate(32) scale(0.29)">
                <use class="fl" href="#lfC" style="--t: 4.1s; --d: -4.9s" />
              </g>
              <g transform="translate(88 243) rotate(122) scale(0.34)">
                <use class="fl" href="#lfB" style="--t: 3.7s; --d: -2.5s" />
              </g>
              <g transform="translate(87 285) rotate(33) scale(0.31)">
                <use class="fl" href="#lfB" style="--t: 4.1s; --d: -4.7s" />
              </g>
              <g transform="translate(87 285) rotate(145) scale(0.23)">
                <use class="fl" href="#lfA" style="--t: 5.7s; --d: -1.3s" />
              </g>
              <g transform="translate(80 330) rotate(51) scale(0.22)">
                <use class="fl" href="#lfC" style="--t: 5s; --d: -4.4s" />
              </g>
              <g transform="translate(80 330) rotate(143) scale(0.24)">
                <use class="fl" href="#lfB" style="--t: 4.7s; --d: -0.8s" />
              </g>
              <g transform="translate(80 330) rotate(102) scale(0.16)">
                <use class="fl" href="#lfC" />
              </g>
            </g>
          </svg><i class="p" style="--x: 6%; --s: 5px; --t: 26s; --d: -3s; --dx: 60px"></i><i class="p"
            style="--x: 14%; --s: 3px; --t: 30s; --d: -11s; --dx: -40px"></i><i class="p"
            style="--x: 22%; --s: 6px; --t: 34s; --d: -20s; --dx: 90px"></i><i class="p"
            style="--x: 31%; --s: 4px; --t: 24s; --d: -7s; --dx: 30px"></i><i class="p"
            style="--x: 40%; --s: 5px; --t: 38s; --d: -16s; --dx: -70px"></i><i class="p"
            style="--x: 48%; --s: 3px; --t: 28s; --d: -2s; --dx: 50px"></i><i class="p"
            style="--x: 57%; --s: 7px; --t: 32s; --d: -25s; --dx: -30px"></i><i class="p"
            style="--x: 66%; --s: 4px; --t: 36s; --d: -9s; --dx: 80px"></i><i class="p"
            style="--x: 74%; --s: 5px; --t: 29s; --d: -14s; --dx: -60px"></i><i class="p"
            style="--x: 83%; --s: 3px; --t: 33s; --d: -5s; --dx: 40px"></i><i class="p"
            style="--x: 91%; --s: 6px; --t: 27s; --d: -18s; --dx: -50px"></i><i class="p lf"
            style="--x: 12%; --s: 15px; --t: 44s; --d: -8s; --dx: 120px"></i><i class="p lf"
            style="--x: 52%; --s: 13px; --t: 50s; --d: -30s; --dx: -100px"></i><i class="p lf"
            style="--x: 80%; --s: 14px; --t: 46s; --d: -21s; --dx: 90px"></i>
        </div>
        <div class="promo-slide slide-0 hero">
          <div class="hero-copy">
            <div class="eyebrow">NABTA / A LIVING COLLECTION</div>
            <h1>
              <span class="w" style="--i: 1">Your</span>
              <span class="w" style="--i: 2">everyday.</span><br /><em><span class="w" style="--i: 3">A</span>
                <span class="w" style="--i: 4">little</span>
                <span class="w" style="--i: 5">wilder.</span></em>
            </h1>
            <p>
              From a single leaf to your own little jungle.<br />Plants,
              thoughtful objects, and everything that helps life grow.
            </p>
            <div class="cta-row">
              <a class="btn" href="index.php?page=products">Shop the collection
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M5 12h14m-6-6 6 6-6 6" />
                </svg></a><a class="link" href="index.php?page=products">Find your plant ↗</a>
            </div>
            <div class="hero-bottom">
              <span>PLANTS / OBJECTS / EVERYDAY CARE</span><span>01 / 03</span>
            </div>
          </div>
          <div class="hero-media">
            <img src="assets/img/garden-sky.jpg"
              alt="Sunlit nursery garden with terracotta pots, green foliage and open blue sky" width="1536"
              height="1024" fetchpriority="high" /><span class="hero-tag">NABTA / BOTANICAL LIVING</span>
            <div class="hero-caption">
              <div>
                <p>FIELD NOTES / 01</p>
                <h2>A corner worth growing.</h2>
              </div>
              <a class="icon-btn" href="index.php?page=products" aria-label="Explore this promotion"><svg class="icon"
                  viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M5 12h14m-6-6 6 6-6 6" />
                </svg></a>
            </div>
          </div>
        </div>
        <div class="promo-slide slide-1 hero">
          <div class="hero-copy">
            <div class="eyebrow">SEEDS, FLOWERS & GARDEN CARE</div>
            <h2 class="hero-heading">
              <span class="w" style="--i: 1">Bloom</span>
              <span class="w" style="--i: 2">brighter.</span><br><em><span class="w" style="--i: 3">Grow</span>
                <span class="w" style="--i: 4">naturally.</span></em>
            </h2>
            <p>
              Discover premium seeds, decorative trees, bouquets, and smart sprayers.
            </p>
            <div class="cta-row">
              <a class="btn" href="index.php?page=products">Shop plants & seeds
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M5 12h14m-6-6 6 6-6 6"></path>
                </svg></a><a class="link" href="index.php?page=products">Browse products ↗</a>
            </div>
            <div class="hero-bottom">
              <span>TREES / FLOWERS / SEEDS & SPRAYERS</span><span>02 / 03</span>
            </div>
          </div>
          <div class="hero-media">
            <img src="assets/img/services.jpg" alt="The Desk Garden — Nabta botanical collection" width="1536"
              height="1024" loading="lazy" /><span class="hero-tag">NABTA / BOTANICAL LIVING</span>
            <div class="hero-caption">
              <div>
                <p>THE DESK GARDEN</p>
                <h2>Last come</h2>
              </div>
              <a class="icon-btn" href="index.php?page=products" aria-label="Explore this promotion"><svg class="icon"
                  viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M5 12h14m-6-6 6 6-6 6" />
                </svg></a>
            </div>
          </div>
        </div>
        <div class="promo-slide slide-2 hero">
          <div class="hero-copy">
            <div class="eyebrow">FOR EVERY STAGE OF GROWING</div>
            <h2 class="hero-heading">
              <span class="w" style="--i: 1">Good</span>
              <span class="w" style="--i: 2">roots.</span><br /><em><span class="w" style="--i: 3">Better</span>
                <span class="w" style="--i: 4">beginnings.</span></em>
            </h2>
            <p>
              Potting mixes, practical tools, and plant-care essentials.<br />Everything
              for the next step in your growing journey.
            </p>
            <div class="cta-row">
              <a class="btn" href="index.php?page=products">Shop growing essentials
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M5 12h14m-6-6 6 6-6 6" />
                </svg></a><a class="link" href="index.php?page=products">Find your plant ↗</a>
            </div>
            <div class="hero-bottom">
              <span>PLANTS / OBJECTS / EVERYDAY CARE</span><span>03 / 03</span>
            </div>
          </div>
          <div class="hero-media">
            <img src="assets/img/editorial.jpg" alt="Growing Essentials — Nabta botanical collection" width="1536"
              height="1024" loading="lazy" /><span class="hero-tag">NABTA / BOTANICAL LIVING</span>
            <div class="hero-caption">
              <div>
                <p>GROWING ESSENTIALS</p>
                <h2>Start with the basics.</h2>
              </div>
              <a class="icon-btn" href="index.php?page=products" aria-label="Explore this promotion"><svg class="icon"
                  viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M5 12h14m-6-6 6 6-6 6" />
                </svg></a>
            </div>
          </div>
        </div>
        <div class="slider-controls" aria-label="Promotion navigation">
          <label for="promo-0"><span class="sr-only">Show promotion 1</span>01</label><label for="promo-1"><span
              class="sr-only">Show promotion 2</span>02</label><label for="promo-2"><span class="sr-only">Show promotion
              3</span>03</label>
        </div>
      </section>
      <section class="garden-paths screen" aria-labelledby="paths-title">
        <div class="section-top">
          <div>
            <div class="eyebrow">SHOP BY CATEGORY</div>
            <h2 id="paths-title">Follow your nature.</h2>
          </div>
          <p>Find the right place to begin.</p>
        </div>
        <div class="paths-grid">
          <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $category):
              $categoryId = (int) $category['cat_id'];
              $categoryName = (string) $category['name'];
              $categoryDescription = trim((string) ($category['description'] ?? ''));
              $categoryImage = $categoryImages[$categoryId] ?? 'plant.jpg';
              $categoryUrl = nabta_public_url('index.php?page=products&category=' . $categoryId);
            ?>
              <a class="path-card" href="<?= htmlspecialchars($categoryUrl, ENT_QUOTES, 'UTF-8') ?>" aria-label="Shop <?= htmlspecialchars($categoryName, ENT_QUOTES, 'UTF-8') ?>">
                <img src="<?= htmlspecialchars(nabta_public_url('assets/img/' . $categoryImage), ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($categoryName, ENT_QUOTES, 'UTF-8') ?>" loading="lazy" width="600" height="700" />
                <div class="category-card-copy">
                  <h3><?= htmlspecialchars($categoryName, ENT_QUOTES, 'UTF-8') ?></h3>
                  <p><?= htmlspecialchars($categoryDescription !== '' ? $categoryDescription : 'Explore this category.', ENT_QUOTES, 'UTF-8') ?></p>
                </div>
                <span class="path-arrow" aria-hidden="true">↗</span>
              </a>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="category-empty-state">No categories are available right now.</p>
          <?php endif; ?>
        </div>
      </section>
      <!-- Curated collection -->
      <section class="screen collection collection-refresh" id="collection" aria-labelledby="collection-title">
        <div class="section-top collection-section-top">
          <div>
            <div class="eyebrow">JUST ARRIVED / THE NABTA EDIT</div>
            <h2 id="collection-title">Fresh from the greenhouse.</h2>
            <p class="collection-intro">Thoughtful plant companions for a calmer, greener everyday.</p>
          </div>
          <a class="link collection-all-link" href="index.php?page=products">Shop all products
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M5 12h14m-6-6 6 6-6 6" />
            </svg>
          </a>
        </div>
        <div class="products-grid collection-products-grid">
          <?php if (!empty($featuredProducts)): ?>
            <?php foreach ($featuredProducts as $featuredProduct):
              $featuredId = (int) ($featuredProduct['pro_id'] ?? 0);
              $featuredName = (string) ($featuredProduct['name'] ?? 'Product');
              $featuredUrl = nabta_public_url('index.php?page=product&id=' . $featuredId);
              $featuredImage = trim((string) ($featuredProduct['image_url'] ?? ''));
              $featuredImageSrc = $featuredImage === '' ? '' : (preg_match('~^https?://|^/~i', $featuredImage) ? $featuredImage : nabta_public_url('assets/img/' . ltrim($featuredImage, '/')));
              $featuredCategory = trim((string) ($featuredProduct['category'] ?? 'Nabta favourite'));
            ?>
              <article class="product-card collection-product-card">
                <a class="product-visual collection-product-visual" href="<?= htmlspecialchars($featuredUrl, ENT_QUOTES, 'UTF-8') ?>" aria-label="View <?= htmlspecialchars($featuredName, ENT_QUOTES, 'UTF-8') ?>">
                  <?php if ($featuredImage !== ''): ?>
                    <img src="<?= htmlspecialchars($featuredImageSrc, ENT_QUOTES, 'UTF-8') ?>" width="900" height="1058" loading="lazy" alt="<?= htmlspecialchars($featuredName, ENT_QUOTES, 'UTF-8') ?>" />
                  <?php else: ?>
                    <span class="product-image-placeholder" aria-label="No product image available">Image coming soon</span>
                  <?php endif; ?>
                  <span class="product-tag"><?= htmlspecialchars($featuredCategory, ENT_QUOTES, 'UTF-8') ?></span>
                </a>
                <div class="product-info collection-product-info">
                  <div class="collection-product-copy">
                    <h3><a href="<?= htmlspecialchars($featuredUrl, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($featuredName, ENT_QUOTES, 'UTF-8') ?></a></h3>
                    <span class="price"><?= number_format((float) ($featuredProduct['price'] ?? 0), 2) ?> JOD</span>
                    <p><?= htmlspecialchars($featuredCategory, ENT_QUOTES, 'UTF-8') ?></p>
                  </div>
                  <a class="product-card-action" href="<?= htmlspecialchars($featuredUrl, ENT_QUOTES, 'UTF-8') ?>" aria-label="Explore <?= htmlspecialchars($featuredName, ENT_QUOTES, 'UTF-8') ?>">
                    <span>Explore product</span><span class="product-card-action-icon" aria-hidden="true"><svg class="icon" viewBox="0 0 24 24"><path d="M5 12h14m-6-6 6 6-6 6" /></svg></span>
                  </a>
                </div>
              </article>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="collection-empty-state">No products are available right now.</p>
          <?php endif; ?>
        </div>
        <div class="section-base collection-section-base">
          <span>PLANTS / POTS / SOIL / TOOLS / DECOR / CARE</span><span>THOUGHTFULLY BROUGHT TOGETHER</span>
        </div>
      </section>
      <?php require __DIR__ . "/layouts/collections-section.php"; ?>
      <section class="screen contact-section" id="contact-us">
        <div class="contact-intro">
          <span class="eyebrow">WE’RE HERE TO HELP YOU GROW</span>
          <h2>Let’s talk<br><em>green things.</em></h2>
          <p>Plant questions, order support, or a little advice for your growing space — send us a note. A real person
            from our team will get back to you.</p>
          <div class="contact-details">
            <a href="#contact-form"><span class="contact-icon">✉</span><span><small>GET IN TOUCH</small><strong>Send us a message</strong></span></a>
            <div><span class="contact-icon">⌁</span><span><small>ROOTED IN</small><strong>Amman, Jordan</strong></span>
            </div>
            <div><span class="contact-icon">◷</span><span><small>RESPONSE TIME</small><strong>Usually within 1–2
                  business days</strong></span></div>
          </div>
        </div>
        <div class="contact-form-card" id="contact-form">
          <div class="contact-form-heading"><span class="eyebrow">SEND A MESSAGE</span><span class="contact-sprout"
              aria-hidden="true">✳</span></div>
          <?php if (is_authenticated()): ?>
          <form class="contact-form" action="<?= htmlspecialchars(nabta_public_url('index.php?page=contact'), ENT_QUOTES, 'UTF-8') ?>" method="post">
            <?= csrf_field() ?>
            <div class="contact-fields"><label>Your name<input type="text" name="name"
                  placeholder="How should we call you?" autocomplete="name"
                  value="<?= e($_POST['name'] ?? ($_SESSION['full_name'] ?? '')) ?>" maxlength="100"
                  required></label><label>Email address<input type="email" name="email" placeholder="you@example.com"
                  autocomplete="email" value="<?= e($_POST['email'] ?? ($_SESSION['user_email'] ?? '')) ?>"
                  maxlength="150" required></label></div>
            <label>What can we help with?<select name="topic" required>
                <option value="" selected disabled>Choose a topic</option>
                <option>Plant care advice</option>
                <option>Order or delivery</option>
                <option>Product question</option>
                <option>Returns and exchanges</option>
                <option>Something else</option>
              </select></label>
            <label>Your message<textarea name="message" rows="4" minlength="5" maxlength="5000"
                placeholder="Tell us a little more…" required></textarea></label>
            <button class="btn btn-primary contact-submit" type="submit">Send your message <span
                aria-hidden="true">↗</span></button>
            <p class="contact-privacy">By sending this form, you agree that we may use your details to reply to your
              message.</p>
          </form>
          <?php else: ?>
            <p>Sign in to send a message to our team.</p>
            <a class="btn btn-primary" href="<?= htmlspecialchars(nabta_public_url('login.php'), ENT_QUOTES, 'UTF-8') ?>">Sign in to contact us</a>
          <?php endif; ?>
        </div>
      </section>
      <section class="screen faq-refresh" id="faq" aria-labelledby="faq-title">
        <div class="faq-layout">
          <aside class="faq-intro-card">
            <div class="faq-intro-top">
              <span class="eyebrow">A LITTLE HELP ALONG THE WAY</span>
              <span class="faq-spark" aria-hidden="true">✳</span>
            </div>
            <h2 id="faq-title">Growing questions.<br><em>Clear answers.</em></h2>
            <p>From choosing your first plant to keeping it thriving, find simple guidance for greener everyday living.
            </p>
            <a class="faq-assistant-link" href="index.php?page=products">Browse plants and growing essentials <span
                aria-hidden="true">↗</span></a>
            <div class="faq-intro-image">
              <img src="assets/img/plant.jpg" alt="A young green plant growing in soft natural light" width="1100"
                height="826" loading="lazy" />
              <div class="faq-image-caption">
                <span>START WITH THE LIGHT</span>
                <p>Good plant care begins with your space.</p>
              </div>
            </div>
          </aside>

          <div class="faq-content-card">
            <div class="faq-list-heading">
              <span>GOOD TO KNOW</span>
              <span>FIVE QUESTIONS</span>
            </div>
            <div class="faq-accordion">
              <details class="faq-item" open>
                <summary><span class="faq-number">01</span><span class="faq-question">What can I find at
                    Nabta?</span><span class="faq-chevron" aria-hidden="true">+</span></summary>
                <div class="faq-answer">
                  <p>Browse indoor plants, pots, soil and nutrition, garden tools, botanical decor, and plant-care
                    essentials. Each product page shares its own details to help you choose well.</p>
                </div>
              </details>
              <details class="faq-item">
                <summary><span class="faq-number">02</span><span class="faq-question">How do I choose a plant for my
                    space?</span><span class="faq-chevron" aria-hidden="true">+</span></summary>
                <div class="faq-answer">
                  <p>Start with the natural light in your room, the space you have, and how much time you can give your
                    plant. Our plant assistant can help you narrow down a good match.</p>
                </div>
              </details>
              <details class="faq-item">
                <summary><span class="faq-number">03</span><span class="faq-question">Can I sell my own plants or
                    supplies?</span><span class="faq-chevron" aria-hidden="true">+</span></summary>
                <div class="faq-answer">
                  <p>Yes. Use Sell with Nabta to prepare a listing with product details, photos, and a price. Listings
                    are reviewed before publication in the marketplace flow.</p>
                </div>
              </details>
              <details class="faq-item">
                <summary><span class="faq-number">04</span><span class="faq-question">What should I check before buying
                    a treatment?</span><span class="faq-chevron" aria-hidden="true">+</span></summary>
                <div class="faq-answer">
                  <p>Read the product label, intended use, and safety directions before use. Follow the seller’s
                    product-specific instructions and keep treatments away from children and pets where indicated.</p>
                </div>
              </details>
              <details class="faq-item">
                <summary><span class="faq-number">05</span><span class="faq-question">Where can I follow my
                    order?</span><span class="faq-chevron" aria-hidden="true">+</span></summary>
                <div class="faq-answer">
                  <p>Sign in to your Nabta account and open the orders area to review your order details and current
                    status.</p>
                </div>
              </details>
            </div>
            <div class="faq-bottom-note"><span class="faq-bottom-dot" aria-hidden="true"></span> Still curious? We're
              here to help your next thing grow.</div>
          </div>
        </div>
      </section>
    </div>
  </main>
  <?php require __DIR__ . "/layouts/footer.php"; ?>
  <script src="assets/js/nabta-theme.js" defer></script>
</body>

</html>