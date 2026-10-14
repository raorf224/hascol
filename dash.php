<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <title>Network overview</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@62..125,400..800&display=swap"
    rel="stylesheet">
  <style>
    :root {
      --bg: #ECF0F7;
      --glow1: rgba(47, 111, 235, .13);
      --glow2: rgba(138, 69, 214, .09);
      --panel: rgba(255, 255, 255, .88);
      --solid: #FFFFFF;
      --ink: #0F1B33;
      --muted: #5E6C86;
      --line: rgba(15, 27, 51, .10);
      --chip: rgba(15, 27, 51, .05);
      --track: rgba(15, 27, 51, .09);
      --blue: #2F6FEB;
      --green: #12A06E;
      --red: #E0424F;
      --violet: #8A45D6;
      --amber: #E39A0B;
      --sel: #F2A500;
      --pmg: #E8602F;
      --hsd: #2F5BB5;
      --hobc: #0FA596;
      --shadow: 0 1px 2px rgba(15, 27, 51, .05), 0 12px 32px rgba(15, 27, 51, .07);
      box-sizing: border-box;
      padding-top: env(safe-area-inset-top, 0px);
      padding-bottom: env(safe-area-inset-bottom, 0px);
    }

    @media (prefers-color-scheme: dark) {
      :root:not([data-theme="light"]) {
        --bg: #0A1020;
        --glow1: rgba(76, 141, 255, .20);
        --glow2: rgba(176, 124, 255, .14);
        --panel: rgba(255, 255, 255, .05);
        --solid: #141C30;
        --ink: #E8EEFA;
        --muted: #8E9CB8;
        --line: rgba(255, 255, 255, .09);
        --chip: rgba(255, 255, 255, .06);
        --track: rgba(255, 255, 255, .10);
        --blue: #5B9BFF;
        --green: #34D6A0;
        --red: #FF6B78;
        --violet: #B98CFF;
        --amber: #FFBE55;
        --sel: #FFC247;
        --pmg: #FF8450;
        --hsd: #6E9BF0;
        --hobc: #2FD0C0;
        --shadow: none;
      }
    }

    :root[data-theme="dark"] {
      --bg: #0A1020;
      --glow1: rgba(76, 141, 255, .20);
      --glow2: rgba(176, 124, 255, .14);
      --panel: rgba(255, 255, 255, .05);
      --solid: #141C30;
      --ink: #E8EEFA;
      --muted: #8E9CB8;
      --line: rgba(255, 255, 255, .09);
      --chip: rgba(255, 255, 255, .06);
      --track: rgba(255, 255, 255, .10);
      --blue: #5B9BFF;
      --green: #34D6A0;
      --red: #FF6B78;
      --violet: #B98CFF;
      --amber: #FFBE55;
      --sel: #FFC247;
      --pmg: #FF8450;
      --hsd: #6E9BF0;
      --hobc: #2FD0C0;
      --shadow: none;
    }

    html {
      scroll-padding-top: env(safe-area-inset-top, 0px);
      background: var(--bg)
    }

    *,
    *::before,
    *::after {
      box-sizing: inherit
    }

    body {
      margin: 0;
      min-height: 100%;
      color: var(--ink);
      font-family: 'Archivo', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
      font-variant-numeric: tabular-nums;
      -webkit-font-smoothing: antialiased;
      background: var(--bg);
      background-image: radial-gradient(1100px 520px at 8% -8%, var(--glow1), transparent 70%), radial-gradient(900px 480px at 100% 0%, var(--glow2), transparent 70%);
      background-repeat: no-repeat
    }

    button,
    input {
      font: inherit;
      color: inherit
    }

    svg text {
      font-family: inherit
    }

    :focus-visible {
      outline: 2px solid var(--sel);
      outline-offset: 2px
    }

    .wrap {
      max-width: 1520px;
      margin: 0 auto;
      padding: 22px 22px 48px
    }

    .head {
      display: flex;
      flex-wrap: wrap;
      gap: 14px 24px;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 16px
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 14px
    }

    .logo {
      width: 44px;
      height: 44px;
      border-radius: 14px;
      background: linear-gradient(135deg, var(--blue), var(--violet));
      display: grid;
      place-items: center;
      flex: none
    }

    h1 {
      margin: 0;
      font-size: 28px;
      font-weight: 800;
      font-stretch: 78%;
      letter-spacing: -.01em;
      line-height: 1.05
    }

    .sub {
      margin: 3px 0 0;
      color: var(--muted);
      font-size: 13.5px;
      display: flex;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap
    }

    .live {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-weight: 700;
      color: var(--green);
      font-size: 12px;
      background: var(--chip);
      padding: 3px 10px;
      border-radius: 999px
    }

    .live::before {
      content: "";
      width: 7px;
      height: 7px;
      border-radius: 50%;
      background: var(--green);
      animation: pulse 2s infinite
    }

    @keyframes pulse {
      0% {
        box-shadow: 0 0 0 0 color-mix(in srgb, var(--green) 55%, transparent)
      }

      70% {
        box-shadow: 0 0 0 8px transparent
      }

      100% {
        box-shadow: 0 0 0 0 transparent
      }
    }

    .tools {
      display: flex;
      gap: 10px;
      align-items: center;
      flex: 1 1 320px;
      justify-content: flex-end
    }

    .search {
      position: relative;
      width: min(380px, 100%)
    }

    .search input {
      width: 100%;
      border: 1px solid var(--line);
      background: var(--panel);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-radius: 14px;
      padding: 11px 14px;
      font-size: 14px
    }

    .search ul {
      position: absolute;
      z-index: 30;
      left: 0;
      right: 0;
      top: calc(100% + 6px);
      margin: 0;
      padding: 6px;
      list-style: none;
      background: var(--solid);
      border: 1px solid var(--line);
      border-radius: 14px;
      max-height: 340px;
      overflow: auto;
      box-shadow: 0 18px 40px rgba(0, 0, 0, .25)
    }

    .search li button {
      display: flex;
      justify-content: space-between;
      gap: 10px;
      width: 100%;
      text-align: left;
      border: 0;
      background: transparent;
      padding: 9px 10px;
      border-radius: 9px;
      cursor: pointer;
      font-size: 14px
    }

    .search li button:hover,
    .search li button:focus-visible {
      background: var(--chip)
    }

    .search li small {
      color: var(--muted);
      white-space: nowrap
    }

    .search .none {
      padding: 10px;
      color: var(--muted);
      font-size: 14px
    }

    .ibtn {
      width: 42px;
      height: 42px;
      border-radius: 14px;
      border: 1px solid var(--line);
      background: var(--panel);
      cursor: pointer;
      display: grid;
      place-items: center;
      flex: none;
      backdrop-filter: blur(12px)
    }

    .crumb {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 4px;
      font-size: 14px;
      margin-bottom: 10px
    }

    .crumb button {
      background: var(--panel);
      border: 1px solid var(--line);
      padding: 6px 13px;
      border-radius: 999px;
      cursor: pointer;
      font-weight: 600
    }

    .crumb button[aria-current="true"] {
      background: var(--ink);
      color: var(--solid);
      border-color: var(--ink);
      cursor: default
    }

    .crumb span {
      color: var(--muted)
    }

    .scope {
      display: flex;
      flex-wrap: wrap;
      gap: 8px 14px;
      align-items: center;
      margin: 0 0 16px;
      font-size: 14px;
      color: var(--muted)
    }

    .scope b {
      color: var(--ink)
    }

    .scope button {
      border: 1px solid var(--line);
      background: var(--panel);
      border-radius: 999px;
      padding: 4px 12px;
      cursor: pointer;
      font-size: 13px
    }

    .panel {
      background: var(--panel);
      border: 1px solid var(--line);
      border-radius: 22px;
      padding: 20px;
      box-shadow: var(--shadow);
      backdrop-filter: blur(14px);
      -webkit-backdrop-filter: blur(14px);
      min-width: 0
    }

    .panel h3 {
      margin: 0 0 4px;
      font-size: 16px;
      font-weight: 700;
      font-stretch: 88%
    }

    .panel .why {
      margin: 0 0 14px;
      font-size: 13px;
      color: var(--muted);
      line-height: 1.4
    }

    .cb {
      min-width: 0
    }

    .note {
      margin: 12px 0 0;
      font-size: 12.5px;
      color: var(--muted);
      line-height: 1.5
    }

    .note b {
      color: var(--ink)
    }

    .empty {
      color: var(--green);
      font-size: 14px;
      margin: 0;
      font-weight: 600
    }

    .d {
      display: inline-block;
      width: 8px;
      height: 8px;
      border-radius: 50%;
      margin-right: 5px;
      vertical-align: baseline
    }

    .leg {
      font-size: 12px;
      color: var(--muted);
      display: flex;
      flex-wrap: wrap;
      gap: 3px 12px;
      line-height: 1.35
    }

    .pill {
      display: inline-block;
      font-size: 12px;
      font-weight: 700;
      padding: 4px 10px;
      border-radius: 999px;
      background: var(--chip);
      margin: 0 6px 6px 0
    }

    .pill.bad {
      color: var(--red)
    }

    .pill.good {
      color: var(--green)
    }

    .top {
      display: grid;
      grid-template-columns: minmax(0, 1.05fr) minmax(0, 1fr);
      gap: 16px;
      align-items: start
    }

    .ch {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 10px 14px;
      flex-wrap: wrap;
      margin-bottom: 6px
    }

    .ch h3 {
      font-size: 17px;
      margin: 0
    }

    .togs {
      display: flex;
      gap: 8px;
      flex-wrap: wrap
    }

    .tog {
      display: inline-flex;
      border: 1px solid var(--line);
      border-radius: 999px;
      overflow: hidden;
      font-size: 13px;
      align-items: center;
      background: var(--chip)
    }

    .tog span {
      padding: 0 4px 0 12px;
      color: var(--muted)
    }

    .tog button {
      border: 0;
      background: transparent;
      padding: 6px 12px;
      cursor: pointer;
      font-weight: 600
    }

    .tog button[aria-pressed="true"] {
      background: var(--ink);
      color: var(--solid)
    }

    .mnote {
      margin: 0 0 12px;
      font-size: 13px;
      color: var(--muted)
    }

    .rows {
      max-height: 600px;
      overflow-y: auto;
      margin: 0 -6px;
      padding: 0 6px
    }

    .row {
      display: grid;
      grid-template-columns: minmax(120px, 200px) 1fr 84px 32px;
      gap: 12px;
      align-items: center;
      padding: 8px 10px;
      border-radius: 12px;
      cursor: pointer;
      user-select: none;
      -webkit-user-select: none;
      touch-action: manipulation
    }

    .row:hover {
      background: var(--chip)
    }

    .row.sel {
      background: var(--chip);
      box-shadow: inset 0 0 0 2px var(--sel)
    }

    .lbl {
      min-width: 0;
      display: flex;
      flex-direction: column;
      gap: 1px
    }

    .lbl b {
      font-size: 15px;
      font-weight: 700;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis
    }

    .lbl small {
      font-size: 12px;
      color: var(--muted);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis
    }

    .track {
      height: 24px;
      background: var(--track);
      border-radius: 12px;
      overflow: hidden
    }

    .track i {
      --tone: var(--blue);
      display: block;
      position: relative;
      height: 100%;
      width: 0;
      border-radius: 12px;
      overflow: hidden;
      background: linear-gradient(90deg, color-mix(in srgb, var(--tone) 55%, transparent), var(--tone));
      transition: width .6s cubic-bezier(.2, .8, .2, 1)
    }

    .track i.two {
      background: var(--amber)
    }

    .track i.two b {
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      background: var(--blue);
      border-radius: 12px
    }

    .row.sel .track i:not(.two) {
      --tone: var(--sel)
    }

    .row.sel .track i.two b {
      background: var(--sel)
    }

    .go .track i {
      width: var(--w)
    }

    .val {
      text-align: right;
      font-weight: 700;
      font-size: 15px;
      white-space: nowrap
    }

    .open {
      border: 0;
      background: transparent;
      color: var(--muted);
      font-size: 22px;
      line-height: 1;
      cursor: pointer;
      width: 32px;
      height: 32px;
      border-radius: 9px
    }

    .open:hover {
      background: var(--chip);
      color: var(--ink)
    }

    .tmwrap {
      position: relative;
      height: 500px
    }

    .tile {
      position: absolute;
      padding: 3px;
      cursor: pointer;
      user-select: none;
      -webkit-user-select: none;
      touch-action: manipulation;
      overflow: hidden
    }

    .ti {
      --tone: var(--blue);
      position: relative;
      width: 100%;
      height: 100%;
      border-radius: 14px;
      padding: 10px 12px;
      overflow: hidden;
      background: color-mix(in srgb, var(--tone) var(--p), var(--solid));
      border: 1px solid color-mix(in srgb, var(--tone) 35%, transparent);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      gap: 4px
    }

    .tile:hover .ti {
      border-color: var(--tone)
    }

    .tile.sel .ti {
      outline: 3px solid var(--sel);
      outline-offset: -3px
    }

    .ti b {
      font-size: 14px;
      font-weight: 700;
      line-height: 1.2;
      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical
    }

    .ti em {
      font-style: normal;
      font-size: 22px;
      font-weight: 800;
      font-stretch: 80%;
      line-height: 1
    }

    .ti small {
      font-size: 11.5px;
      color: var(--muted);
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
      display: block
    }

    .ti .open {
      position: absolute;
      right: 4px;
      top: 4px;
      width: 26px;
      height: 26px;
      font-size: 18px
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 12px
    }

    .card {
      text-align: left;
      background: var(--panel);
      border: 1px solid var(--line);
      border-radius: 18px;
      padding: 14px 16px;
      cursor: pointer;
      display: flex;
      flex-direction: column;
      gap: 6px;
      min-width: 0;
      box-shadow: var(--shadow);
      backdrop-filter: blur(14px);
      -webkit-backdrop-filter: blur(14px)
    }

    .card:hover {
      border-color: var(--muted)
    }

    .card.on {
      border-color: var(--blue);
      box-shadow: inset 0 0 0 1px var(--blue), var(--shadow)
    }

    .card.missing {
      cursor: not-allowed;
      opacity: .7;
      border-style: dashed
    }

    .card.missing:hover {
      border-color: var(--line)
    }

    .cl {
      font-size: 13px;
      color: var(--muted);
      font-weight: 600;
      line-height: 1.25;
      min-height: 2.5em
    }

    .cmain {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px
    }

    .cn {
      font-size: 33px;
      font-weight: 800;
      font-stretch: 78%;
      line-height: 1;
      letter-spacing: -.01em
    }

    .cn.api {
      color: var(--muted);
      font-size: 20px;
      font-weight: 700
    }

    .cviz {
      flex: none;
      display: grid;
      place-items: center
    }

    .card.al .cn {
      color: var(--red)
    }

    .card.dm .cn {
      color: var(--violet)
    }

    .card.zero .cn {
      color: var(--green)
    }

    .rhead {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: baseline;
      gap: 6px 16px;
      margin: 32px 0 6px
    }

    .rhead h2 {
      margin: 0;
      font-size: 24px;
      font-weight: 800;
      font-stretch: 78%
    }

    .rhead span {
      color: var(--muted);
      font-size: 14px
    }

    .report {
      display: grid;
      grid-template-columns: repeat(6, minmax(0, 1fr));
      gap: 16px
    }

    .grp {
      grid-column: 1/-1;
      margin: 14px 0 -2px;
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 13px;
      font-weight: 800;
      letter-spacing: .08em;
      text-transform: uppercase;
      color: var(--muted)
    }

    .grp::after {
      content: "";
      flex: 1;
      height: 1px;
      background: var(--line)
    }

    .s2 {
      grid-column: span 2
    }

    .s3 {
      grid-column: span 3
    }

    .s4 {
      grid-column: span 4
    }

    .tabs {
      display: inline-flex;
      border: 1px solid var(--line);
      border-radius: 999px;
      overflow: hidden;
      background: var(--chip);
      margin-bottom: 12px
    }

    .tabs button {
      border: 0;
      background: transparent;
      padding: 5px 12px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer
    }

    .tabs button[aria-pressed="true"] {
      background: var(--ink);
      color: var(--solid)
    }

    .rl {
      display: grid;
      gap: 4px
    }

    .rr {
      display: grid;
      grid-template-columns: 44px minmax(0, 1fr) auto;
      gap: 12px;
      align-items: center;
      padding: 7px 8px;
      border-radius: 12px
    }

    .rr[data-site],
    .rr[data-tm] {
      cursor: pointer
    }

    .rr[data-site]:hover,
    .rr[data-tm]:hover {
      background: var(--chip)
    }

    .rr .nm {
      min-width: 0
    }

    .rr .nm b {
      display: block;
      font-size: 14px;
      font-weight: 600;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis
    }

    .rr .nm small {
      display: block;
      color: var(--muted);
      font-size: 12px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis
    }

    .rr .v {
      text-align: right;
      font-weight: 700;
      font-size: 14px
    }

    .rr .v small {
      display: block;
      font-weight: 500;
      font-size: 11.5px;
      color: var(--muted)
    }

    .mixwrap {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 14px 20px;
      justify-content: center
    }

    .mixleg {
      display: grid;
      gap: 8px;
      font-size: 13px;
      min-width: 150px
    }

    .mixleg div {
      display: grid;
      grid-template-columns: auto 1fr;
      gap: 2px 8px;
      align-items: center
    }

    .mixleg small {
      grid-column: 2;
      color: var(--muted);
      font-size: 12px
    }

    svg {
      display: block;
      max-width: 100%
    }

    #tip {
      position: fixed;
      z-index: 60;
      pointer-events: none;
      background: var(--solid);
      color: var(--ink);
      border: 1px solid var(--line);
      border-radius: 12px;
      padding: 8px 11px;
      font-size: 12.5px;
      line-height: 1.5;
      box-shadow: 0 14px 34px rgba(0, 0, 0, .28);
      max-width: 280px
    }

    #tip b {
      font-weight: 700
    }

    .wk {
      fill: var(--chip)
    }

    .ax {
      fill: var(--muted);
      font-size: 11px
    }

    .gl {
      stroke: var(--line);
      stroke-width: 1
    }

    .api-need {
      display: grid;
      place-items: center;
      min-height: 200px;
      padding: 24px;
      text-align: center;
      border: 1.5px dashed var(--line);
      border-radius: 14px;
      background: var(--chip)
    }

    .api-need .t {
      font-weight: 800;
      font-size: 14px;
      color: var(--ink);
      margin: 10px 0 6px
    }

    .api-need .h {
      font-size: 12.5px;
      color: var(--muted);
      margin-bottom: 10px;
      max-width: 340px;
      line-height: 1.5
    }

    .api-need code {
      font-size: 11px;
      background: var(--solid);
      border: 1px solid var(--line);
      padding: 5px 10px;
      border-radius: 8px;
      color: var(--muted);
      display: inline-block;
      word-break: break-all;
      max-width: 100%;
      font-family: ui-monospace, Menlo, monospace
    }

    @media (max-width:1180px) {
      .top {
        grid-template-columns: 1fr
      }

      .report {
        grid-template-columns: repeat(2, minmax(0, 1fr))
      }

      .s2,
      .s3 {
        grid-column: span 1
      }

      .s4 {
        grid-column: span 2
      }
    }

    @media (max-width:640px) {
      .wrap {
        padding: 14px 12px 36px
      }

      h1 {
        font-size: 23px
      }

      .row {
        grid-template-columns: 100px 1fr 66px 28px;
        gap: 8px;
        padding: 8px 4px
      }

      .report {
        grid-template-columns: 1fr
      }

      .s2,
      .s3,
      .s4 {
        grid-column: span 1
      }

      .cn {
        font-size: 27px
      }

      .tmwrap {
        height: 420px
      }

      .panel {
        padding: 16px
      }
    }

    @media (prefers-reduced-motion:reduce) {
      .track i {
        transition: none
      }

      .live::before {
        animation: none
      }
    }
  </style>
</head>

<body>
  <div class="wrap">
    <header class="head">
      <div class="brand">
        <div class="logo" aria-hidden="true">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 20V8l6-4v16" />
            <path d="M10 12h4a2 2 0 0 1 2 2v3a2 2 0 0 0 4 0V9l-3-3" />
            <path d="M3 20h8" />
          </svg>
        </div>
        <div>
          <h1>Network overview</h1>
          <p class="sub"><span class="live" id="liveBadge">Loading…</span><span>1 to 14 October 2026.</span></p>
        </div>
      </div>
      <div class="tools">
        <div class="search">
          <input id="q" type="search" placeholder="Find a site, TM, city or region" autocomplete="off"
            aria-label="Find a site, territory manager, city or region">
          <ul id="res" hidden></ul>
        </div>
        <button class="ibtn" id="theme" aria-label="Switch between light and dark">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round">
            <circle cx="12" cy="12" r="9" />
            <path d="M12 3v18" />
            <path d="M12 3a9 9 0 0 1 0 18z" fill="currentColor" />
          </svg>
        </button>
      </div>
    </header>

    <nav class="crumb" id="crumb" aria-label="Where you are"></nav>
    <p class="scope" id="scope"></p>

    <div class="top">
      <section class="panel" aria-label="Drill-down chart">
        <div class="ch">
          <h3 id="ctitle"></h3>
          <div class="togs">
            <div class="tog" role="group" aria-label="Chart style">
              <button data-chart="bars" aria-pressed="true">Bars</button>
              <button data-chart="tree" aria-pressed="false">Treemap</button>
            </div>
            <div class="tog" role="group" aria-label="Open a region by"><span>Open region by</span>
              <button data-view="geo" aria-pressed="true">City</button>
              <button data-view="tm" aria-pressed="false">TM</button>
            </div>
          </div>
        </div>
        <p class="mnote" id="mnote"></p>
        <div id="stage"></div>
      </section>
      <section class="cards" id="cards" aria-label="Summary cards"></section>
    </div>

    <div class="rhead">
      <h2 id="rtitle">Report</h2>
      <span>kL = thousand litres, ML = million litres</span>
    </div>
    <div class="report" id="report"></div>
  </div>
  <div id="tip" hidden></div>

  <!-- ============================================================
     REAL DATA HYDRATION
     ============================================================ -->
  <script>
    window.REAL_DATA = {
      dealers: [], filters: null, recon: [], orders: [],
      tour: [], visitsRaw: [],
      meta: { dealers: false, filters: false, recon: false, orders: false, tour: false, visitsRaw: false }
    };

    (function () {
      const BASE = 'http://151.106.17.246:8080/hascolbridgeApis/get';
      const KEY = '03201232927';

      function qs(obj) {
        return Object.entries(obj)
          .filter(([, v]) => v !== undefined && v !== null && v !== '')
          .map(([k, v]) => k + '=' + encodeURIComponent(v))
          .join('&');
      }
      function fetchJSON(url) {
        return fetch(url, { mode: 'cors', credentials: 'omit' })
          .then(r => r.ok ? r.json() : Promise.reject(new Error('HTTP ' + r.status)))
          .catch(err => { console.warn('[hydrate] failed:', url.slice(0, 140), err.message); return null; });
      }

      window.READY = (async function hydrate() {
        const now = new Date();
        const y = now.getFullYear(), m = String(now.getMonth() + 1).padStart(2, '0');
        const from = `${y}-${m}-01`, to = `${y}-${m}-14`;
        const common = { key: KEY, pre: 'Admin', user_id: 1 };

        const dealers = await fetchJSON(`${BASE}/dealers.php?${qs(common)}`);
        if (Array.isArray(dealers) && dealers.length) {
          window.REAL_DATA.dealers = dealers;
          window.REAL_DATA.meta.dealers = true;
          console.log('[hydrate] dealers:', dealers.length);
        }

        const filters = await fetchJSON(`${BASE}/get_region_district_dealers.php?${qs(common)}`);
        if (Array.isArray(filters) && filters[0]) {
          window.REAL_DATA.filters = filters[0];
          window.REAL_DATA.meta.filters = true;
          console.log('[hydrate] filters loaded');
        }

        const tour = await fetchJSON(`${BASE}/inspection/get_tm_tour_data_testing.php?${qs({ ...common, months: `${y}-${m}` })}`);
        if (Array.isArray(tour) && tour.length) {
          window.REAL_DATA.tour = tour;
          window.REAL_DATA.meta.tour = true;
          console.log('[hydrate] tour rows:', tour.length);
        }

        const visits = await fetchJSON(`${BASE}/inspection/all_dealers_inspection.php?${qs({ ...common, from, to })}`);
        if (Array.isArray(visits) && visits.length) {
          window.REAL_DATA.visitsRaw = visits;
          window.REAL_DATA.meta.visitsRaw = true;
          console.log('[hydrate] visits:', visits.length);
        }

        const orders = await fetchJSON(`${BASE}/get_all_orders_shortage.php?${qs({ key: KEY, id: 1, rettype: 'RT' })}`);
        if (Array.isArray(orders) && orders.length) {
          window.REAL_DATA.orders = orders;
          window.REAL_DATA.meta.orders = true;
          console.log('[hydrate] orders:', orders.length);
        }

        // Reconciliation — region-wise loop
        const reconFrom = new Date(now.getTime() - 60 * 864e5).toISOString().slice(0, 10);
        const RECON_REGIONS = ['Karachi', 'Hyderabad', 'Sukkur', 'Multan', 'Lahore',
          'Islamabad', 'Faisalabad', 'Peshawar', 'Quetta', 'Rawalpindi', 'Balochistan'];
        function tmsForRegion(region) {
          try {
            const meta = window.REAL_DATA.filters;
            if (!meta || !meta.tm) return '';
            const list = typeof meta.tm === 'string' ? JSON.parse(meta.tm) : meta.tm;
            const matched = list.filter(t => (t.region || '') === region).map(t => t.id);
            return matched.length ? matched.join(',') : '';
          } catch (_) { return ''; }
        }
        const reconAll = [];
        for (const region of RECON_REGIONS) {
          const params = { key: KEY, dealer_id: '', from: reconFrom, to: to, products: '', region };
          const tmIds = tmsForRegion(region);
          if (tmIds) params.tm = tmIds;
          const r = await fetchJSON(`${BASE}/dumping/get_dealers_recons_product_wise_new2.php?${qs(params)}`);
          if (Array.isArray(r) && r.length) {
            reconAll.push(...r);
            console.log(`[hydrate] recon ${region}: ${r.length} rows`);
          } else {
            console.warn(`[hydrate] recon ${region}: no data`);
          }
        }
        if (!reconAll.length) {
          const fb = await fetchJSON(`${BASE}/dumping/get_dealers_recons_product_wise_new2.php?${qs({
            key: KEY, dealer_id: '', from: reconFrom, to: to, products: '',
            region: 'Islamabad',
            tm: '56,57,58,76,85,92,152,99,74,75,95,97,70,72,87,88,120,149,35,36,90,52,98,37,38,91,93,94'
          })}`);
          if (Array.isArray(fb) && fb.length) {
            reconAll.push(...fb);
            console.log(`[hydrate] recon fallback: ${fb.length} rows`);
          }
        }
        if (reconAll.length) {
          window.REAL_DATA.recon = reconAll;
          window.REAL_DATA.meta.recon = true;
          console.log(`[hydrate] recon total: ${reconAll.length} rows`);
        }

        const loaded = Object.entries(window.REAL_DATA.meta).filter(([, v]) => v).map(([k]) => k);
        console.log('[hydrate] loaded sources:', loaded.join(', ') || '(none)');
        updateSourceBadge();
        return window.REAL_DATA;
      })();

      function updateSourceBadge() {
        const b = document.getElementById('liveBadge');
        if (!b) return;
        const m = window.REAL_DATA.meta;
        const real = [m.dealers, m.recon, m.orders, m.tour, m.visitsRaw].filter(Boolean).length;
        b.textContent = real === 5 ? 'Live'
          : real === 0 ? 'Offline'
            : `Live · ${real}/5`;
      }
      window.updateSourceBadge = updateSourceBadge;
    })();
  </script>

  <script>
    /* =====================================================================
       STATE + HELPERS
       ===================================================================== */
    const $ = s => document.querySelector(s);
    const fmt = n => Math.round(n || 0).toLocaleString('en-US');
    const fmtL = k => Math.abs(k) >= 1000 ? (k / 1000).toFixed(1) + ' ML' : Math.round(k || 0) + ' kL';
    const fmtA = v => Math.abs(v) >= 1000 ? (+(v / 1000).toFixed(1)) + ' ML' : (+v.toFixed(v < 10 ? 1 : 0)) + ' kL';
    const pc = (a, b) => b ? Math.round(a / b * 100) : 0;
    const dot = (c, t) => `<span><span class="d" style="background:${c}"></span>${t}</span>`;
    const pv = k => `var(--${k.toLowerCase()})`;
    const leaks = s => (s.upl || 0) > .001 || (s.dmp || 0) > .001;
    const tmsOf = list => [...new Set(list.map(s => s.tm))];
    const status = s => !s.sale ? 'none' : (s.sale / (s.target || 1) < .5 ? 'low' : 'ok');
    const ST = { ok: ['Selling', 'var(--green)'], low: ['Low sales', 'var(--amber)'], none: ['No sales', 'var(--red)'] };
    let UID = 0;
    const bodyW = el => el.clientWidth || 600;

    const PK = ['PMG', 'HSD', 'HOBC'];
    const PN = { PMG: 'Petrol (PMG)', HSD: 'Diesel (HSD)', HOBC: 'Hi-Octane' };
    const PS = { PMG: 'Petrol', HSD: 'Diesel', HOBC: 'Hi-Octane' };
    const MONTHS = ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'];
    const DIM = [31, 30, 31, 31, 30, 14];
    const DAYS_LEFT = 17, ELAPSED = 14 / 31;
    const isSun = d => d === 4 || d === 11;

    /* Capability check — reflects which APIs actually loaded */
    function CAP() {
      const m = (window.REAL_DATA && window.REAL_DATA.meta) || {};
      return {
        dealers: !!m.dealers,
        fuelFlow: !!m.recon,       // sale / buy / uplift / dumping
        inspections: !!m.visitsRaw,   // visit detail
        tour: !!m.tour,        // TM tour pace
        orders: !!m.orders,      // delivery orders / shortage
        inventory: false,           // not built yet
        targets: false,           // not built yet
      };
    }

    /* Placeholder for missing APIs */
    function apiNeeded(title, endpoint, hint) {
      return `<div class="api-need">
    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <div class="t">${title}</div>
    <div class="h">${hint}</div>
    <code>${endpoint}</code>
  </div>`;
    }

    /* Smoothing + arc helpers */
    function smooth(pts) {
      if (pts.length < 3) return pts.map((p, i) => (i ? 'L' : 'M') + p[0].toFixed(1) + ' ' + p[1].toFixed(1)).join('');
      let d = `M${pts[0][0].toFixed(1)} ${pts[0][1].toFixed(1)}`;
      for (let i = 0; i < pts.length - 1; i++) {
        const p0 = pts[i - 1] || pts[i], p1 = pts[i], p2 = pts[i + 1], p3 = pts[i + 2] || p2, t = .18;
        d += `C${(p1[0] + (p2[0] - p0[0]) * t).toFixed(1)} ${(p1[1] + (p2[1] - p0[1]) * t).toFixed(1)} ${(p2[0] - (p3[0] - p1[0]) * t).toFixed(1)} ${(p2[1] - (p3[1] - p1[1]) * t).toFixed(1)} ${p2[0].toFixed(1)} ${p2[1].toFixed(1)}`;
      }
      return d;
    }
    function arcPath(cx, cy, r0, r1, a0, a1) {
      if (a1 - a0 >= Math.PI * 2 - 1e-4) a1 = a0 + Math.PI * 2 - 1e-4;
      const P = (r, a) => [(cx + r * Math.sin(a)).toFixed(2), (cy - r * Math.cos(a)).toFixed(2)];
      const L = a1 - a0 > Math.PI ? 1 : 0, A = P(r1, a0), B = P(r1, a1), C = P(r0, a1), D = P(r0, a0);
      return `M${A[0]} ${A[1]}A${r1} ${r1} 0 ${L} 1 ${B[0]} ${B[1]}L${C[0]} ${C[1]}A${r0} ${r0} 0 ${L} 0 ${D[0]} ${D[1]}Z`;
    }
    function ringSegs(cx, cy, r0, r1, parts, gap = .03) {
      const tot = parts.reduce((s, p) => s + p.v, 0);
      if (tot <= 0) return `<path d="${arcPath(cx, cy, r0, r1, 0, Math.PI * 2)}" fill="var(--track)"/>`;
      let a = 0;
      return parts.map(p => {
        if (p.v <= 0) return '';
        const sw = p.v / tot * Math.PI * 2, g = parts.filter(q => q.v > 0).length > 1 ? gap : 0;
        const d = arcPath(cx, cy, r0, r1, a + g / 2, Math.max(a + sw - g / 2, a + g / 2 + .001));
        a += sw;
        return `<path d="${d}" fill="${p.c}" data-tip="${p.tip || ''}"/>`;
      }).join('');
    }
    function ring(pct, color, size = 56, label) {
      const r = (size - 9) / 2, c = 2 * Math.PI * r, p = Math.max(0, Math.min(pct || 0, 100)) / 100;
      return `<svg width="${size}" height="${size}" viewBox="0 0 ${size} ${size}" role="img" aria-label="${Math.round(pct || 0)} percent">
    <circle cx="${size / 2}" cy="${size / 2}" r="${r}" fill="none" stroke="var(--track)" stroke-width="7"/>
    <circle cx="${size / 2}" cy="${size / 2}" r="${r}" fill="none" stroke="${color}" stroke-width="7" stroke-linecap="round" stroke-dasharray="${(c * p).toFixed(1)} ${c.toFixed(1)}" transform="rotate(-90 ${size / 2} ${size / 2})"/>
    <text x="${size / 2}" y="${size / 2 + 4}" text-anchor="middle" font-size="${size > 50 ? 13 : 11}" font-weight="800" fill="var(--ink)">${label !== undefined ? label : Math.round(pct || 0) + '%'}</text></svg>`;
    }
    function miniDonut(parts, size = 58) {
      const c = size / 2;
      return `<svg width="${size}" height="${size}" viewBox="0 0 ${size} ${size}">${ringSegs(c, c, size / 2 - 9, size / 2 - 1, parts, .06)}</svg>`;
    }
    function spark(v, color, w = 104, h = 46) {
      const id = 'sp' + (++UID);
      const max = Math.max(...v, 1e-9), n = v.length, pad = 3;
      const pts = v.map((y, i) => [pad + i * (w - 2 * pad) / Math.max(n - 1, 1), h - pad - (y / max) * (h - 2 * pad)]);
      const line = pts.map((p, i) => (i ? 'L' : 'M') + p[0].toFixed(1) + ' ' + p[1].toFixed(1)).join('');
      const area = line + `L${pts[n - 1][0].toFixed(1)} ${h}L${pts[0][0].toFixed(1)} ${h}Z`;
      const e = pts[n - 1];
      return `<svg width="${w}" height="${h}" viewBox="0 0 ${w} ${h}" aria-hidden="true"><defs><linearGradient id="${id}" x1="0" y1="0" x2="0" y2="1"><stop offset="0" style="stop-color:${color};stop-opacity:.38"/><stop offset="1" style="stop-color:${color};stop-opacity:0"/></linearGradient></defs>
    <path d="${area}" fill="url(#${id})"/><path d="${line}" fill="none" stroke="${color}" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"/><circle cx="${e[0]}" cy="${e[1]}" r="3.2" fill="${color}"/></svg>`;
    }
    function niceScale(v, n = 4) {
      if (v <= 0) return { max: n, step: 1 };
      const raw = v / n, p = Math.pow(10, Math.floor(Math.log10(raw))), f = raw / p;
      const s = (f <= 1 ? 1 : f <= 2 ? 2 : f <= 5 ? 5 : 10) * p;
      return { max: Math.ceil(v / s - 1e-9) * s, step: s };
    }

    /* Tooltip */
    const tip = $('#tip');
    function placeTip(x, y) {
      tip.hidden = false;
      const w = tip.offsetWidth, h = tip.offsetHeight;
      let nx = x + 14, ny = y + 14;
      if (nx + w > innerWidth - 8) nx = x - w - 14;
      if (ny + h > innerHeight - 8) ny = y - h - 14;
      tip.style.left = Math.max(8, nx) + 'px'; tip.style.top = Math.max(8, ny) + 'px';
    }
    function showTip(html, x, y) { tip.innerHTML = html; placeTip(x, y) }
    function hideTip() { tip.hidden = true }
    function onTip(e) {
      const t = e.target.closest && e.target.closest('[data-tip],[data-keep]');
      if (!t) { hideTip(); return }
      if (t.hasAttribute('data-keep')) return;
      if (!t.dataset.tip) { hideTip(); return }
      showTip(t.dataset.tip, e.clientX, e.clientY);
    }
    document.addEventListener('pointermove', onTip);
    document.addEventListener('pointerdown', onTip);
    document.addEventListener('scroll', hideTip, true);

    /* =====================================================================
       DATA STORES (populated in boot from real APIs only)
       ===================================================================== */
    const GEO = [];
    const SITES = [];
    const TMS = [];
    let NETWORK_HEALTH = [
      ['Visits vs plan', 0], ['Sales vs target', 0], ['Nozzles running', 0],
      ['Sites within agreement', 0], ['Tank stock healthy', 0]
    ];

    /* =====================================================================
       BUILDERS (from real API payloads)
       ===================================================================== */
    const REGION_FIX = {
      'M2': 'Karachi', 'Sukkur': 'Sindh Interior', 'Hyderabad': 'Sindh Interior',
      'Multan': 'South Punjab', 'Lahore': 'Central Punjab', 'Faisalabad': 'Central Punjab',
      'Islamabad': 'Capital and North', 'Rawalpindi': 'Capital and North',
      'Peshawar': 'Khyber Pakhtunkhwa', 'Quetta': 'Balochistan', 'Balochistan': 'Balochistan',
      'Karachi': 'Karachi'
    };
    const cleanRegion = r => REGION_FIX[r] || r || 'Unassigned';
    const cleanCity = d => (d.city && d.city.trim()) || (d.district && d.district.trim()) || 'Unknown';
    const cleanName = n => (n || '').replace(/\s+/g, ' ').trim();
    const cleanTM = n => cleanName(n) || 'Unassigned TM';

    function buildFromReal(dealers, filters) {
      const tmMap = new Map();
      if (filters && filters.tm) {
        try {
          const list = typeof filters.tm === 'string' ? JSON.parse(filters.tm) : filters.tm;
          list.forEach(t => tmMap.set(String(t.id), { id: String(t.id), name: cleanTM(t.name), sites: [] }));
        } catch (_) { }
      }
      const regionsMap = new Map();
      const sites = [];

      dealers.forEach(d => {
        const region = cleanRegion(d.region);
        const city = cleanCity(d);
        const tmName = cleanTM(d.tm_name);
        const tmId = String(d.tm || '');

        if (!regionsMap.has(region)) {
          regionsMap.set(region, { r: region, rm: cleanName(d.zm_name) || 'RM', c: new Map() });
        }
        const reg = regionsMap.get(region);
        if (!reg.c.has(city)) reg.c.set(city, []);
        reg.c.get(city).push(d);

        let tm = tmMap.get(tmId) || tmMap.get(tmName);
        if (!tm) { tm = { id: tmId || tmName, name: tmName, sites: [] }; tmMap.set(tmId || tmName, tm); }
        tm.region = region; tm.city = city;
        if (!tm.sites) tm.sites = [];

        const prods = PK.map(k => ({
          k, tanks: 0, tanksOn: 0, noz: 0,
          sale: 0, buy: 0, upl: 0, dmp: 0,
          fill: 0, low: 0, remark: ''
        }));

        const site = {
          id: String(d.id),
          sap_no: String(d.sap_no || ''),
          name: cleanName(d.name) || ('Site ' + d.id),
          city, region, tm,
          target: 0,
          prods,
          noz: 0, nozOn: 0,
          insp: [false, false, false, false, false, false],
          visitDay: 0,
          tanks: 0, tanksOn: 0,
          sale: 0, buy: 0, upl: 0, dmp: 0,
          dSale: new Array(13).fill(0), dBuy: new Array(13).fill(0),
          dUpl: new Array(13).fill(0), dDmp: new Array(13).fill(0),
          mSale: new Array(6).fill(0), mUpl: new Array(6).fill(0), mDmp: new Array(6).fill(0),
          hasFuel: false
        };
        sites.push(site);
        tm.sites.push(site);
      });

      const geo = [...regionsMap.values()].map(r => ({
        r: r.r, rm: r.rm,
        c: [...r.c.entries()].map(([city, list]) => [city, list.length])
      }));

      return { geo, tms: [...tmMap.values()].filter(t => t.sites && t.sites.length), sites };
    }

    function applyRecon(sites, recon) {
      const bySap = new Map();
      recon.forEach(r => {
        const sap = String(r.dealer_sap || '').trim();
        if (!sap) return;
        if (!bySap.has(sap)) bySap.set(sap, []);
        bySap.get(sap).push(r);
      });
      let matched = 0;
      sites.forEach(site => {
        const rows = bySap.get(site.sap_no);
        if (!rows) return;
        matched++;
        rows.forEach(r => {
          const rawKey = (r.product_name || '').toUpperCase().trim();
          const key = rawKey === 'HASRON' ? 'HOBC' : rawKey;
          const prod = site.prods.find(p => p.k === key);
          if (!prod) return;

          const days = Math.max(1, +r.no_os_days || 1);
          const scale = 13 / days;
          const sale = (+r.sales || 0) * scale / 1000;
          const buy = (+r.receipts || 0) * scale / 1000;
          const leak = Math.abs(+r.variance || 0) * scale / 1000;

          const uplift = (r.external_upliftment === true || r.external_upliftment === 'true') ? leak : 0;
          const dump = (r.external_dumping === true || r.external_dumping === 'true') ? leak : 0;

          prod.sale += sale;
          prod.buy += buy;
          prod.upl += uplift;
          prod.dmp += dump;
          prod.remark = r.remark || '';

          const W = 13.5;
          for (let d = 0; d < 13; d++) {
            const w = (d + 1 === 4 || d + 1 === 11) ? 0.75 : 1;
            site.dSale[d] += sale * w / W;
            site.dBuy[d] += buy * w / W;
            site.dUpl[d] += uplift * w / W;
            site.dDmp[d] += dump * w / W;
          }
        });
        site.sale = site.prods.reduce((a, p) => a + p.sale, 0);
        site.buy = site.prods.reduce((a, p) => a + p.buy, 0);
        site.upl = site.prods.reduce((a, p) => a + p.upl, 0);
        site.dmp = site.prods.reduce((a, p) => a + p.dmp, 0);
        site.mSale[5] = site.sale;
        site.mUpl[5] = site.upl;
        site.mDmp[5] = site.dmp;
        site.hasFuel = site.sale > 0 || site.buy > 0 || site.upl > 0 || site.dmp > 0;
      });
      console.log('[hydrate] recon matched', matched, 'sites');
    }

    function applyTour(tms, tour) {
      const byName = new Map();
      tour.filter(t => t.user_name !== 'Total').forEach(t => {
        byName.set(t.user_name.replace(/\s+/g, ' ').trim(), t);
      });
      tms.forEach(tm => {
        const row = byName.get(tm.name);
        if (!row) return;
        tm.tourPercentage = +row.tour_percentage || 0;
        tm.sumComplete = +row.sum_Complete || 0;
        tm.totalDealers = +row.total_dealers || 0;
      });
    }

    function applyInspections(sites, visits) {
      const byDealer = new Map();
      visits.forEach(v => {
        const id = String(v.dealer_id || v.id || '');
        if (!id) return;
        const vDate = v.time || v.task_create_time || v.visit_close_time || '';
        const cur = byDealer.get(id);
        if (!cur || vDate > cur.vDate) byDealer.set(id, { vDate, row: v });
      });
      sites.forEach(site => {
        const hit = byDealer.get(site.id) || byDealer.get(site.sap_no);
        if (!hit) return;
        const row = hit.row;
        site.insp = [
          row.sales_status === '1',
          row.measurement_status === '1',
          row.wet_stock_status === '1',
          row.dispensing_status === '1',
          row.stock_variations_status === '1',
          row.inspection === '1'
        ];
        const m = /(\d{4})-(\d{2})-(\d{2})/.exec(hit.vDate);
        if (m) site.visitDay = +m[3];
      });
    }

    /* Shortage lookup — orders.customer_id == dealers.sap_no */
    function buildShortageMap() {
      const map = new Map();
      (window.REAL_DATA?.orders || []).forEach(o => {
        const sap = String(o.customer_id || '').trim();
        if (!sap) return;
        let ord = 0, short = 0;
        try {
          JSON.parse(o.product_json).forEach(p => {
            ord += +p.quantity || 0;
            short += +p.quantity_less_L || 0;
          });
        } catch (_) { }
        const cur = map.get(sap) || { ordered: 0, short: 0, count: 0 };
        cur.ordered += ord; cur.short += short; cur.count++;
        map.set(sap, cur);
      });
      return map;
    }
    let SHORTAGE_MAP = new Map();

    function shortageForSites(list) {
      let ord = 0, short = 0, deliveries = 0;
      list.forEach(s => {
        const r = SHORTAGE_MAP.get(s.sap_no);
        if (r) { ord += r.ordered; short += r.short; deliveries += r.count; }
      });
      return { ordered: ord, short, deliveries, pct: ord ? short / ord * 100 : 0 };
    }

    /* =====================================================================
       AGGREGATION (unchanged logic, but only real values now)
       ===================================================================== */
    function agg(list) {
      const a = {
        sites: list.length, tanks: 0, tanksOn: 0, noz: 0, nozOn: 0, sale: 0, buy: 0, upl: 0, dmp: 0,
        low: 0, fillW: 0, down: 0, leak: 0, target: 0,
        insp: [0, 0, 0, 0, 0, 0], st: { ok: 0, low: 0, none: 0 }, p: {}, hasFuel: 0
      };
      PK.forEach(k => a.p[k] = { tanks: 0, tanksOn: 0, sale: 0, buy: 0, upl: 0, dmp: 0, fillW: 0, low: 0 });
      const tmSet = new Set();
      list.forEach(s => {
        tmSet.add(s.tm.name);
        a.noz += s.noz; a.nozOn += s.nozOn; a.target += s.target;
        if (s.nozOn === 0) a.down++;
        if (s.hasFuel) a.hasFuel++;
        s.insp.forEach((f, i) => { if (f) a.insp[i]++ });
        a.st[status(s)]++;
        if (leaks(s)) a.leak++;
        s.prods.forEach(p => {
          const q = a.p[p.k];
          if (!q) return;
          ['tanks', 'tanksOn', 'sale', 'buy', 'upl', 'dmp', 'low'].forEach(f => { q[f] += p[f]; a[f] += p[f] });
          q.fillW += p.fill * p.tanks; a.fillW += p.fill * p.tanks;
        });
      });
      a.tmCount = tmSet.size;
      return a;
    }
    function series(list) {
      const z = n => new Array(n).fill(0);
      const o = { dSale: z(13), dBuy: z(13), dUpl: z(13), dDmp: z(13), mSale: z(6), mUpl: z(6), mDmp: z(6), cum: z(13) };
      list.forEach(s => {
        for (let i = 0; i < 13; i++) { o.dSale[i] += s.dSale[i]; o.dBuy[i] += s.dBuy[i]; o.dUpl[i] += s.dUpl[i]; o.dDmp[i] += s.dDmp[i] }
        for (let m = 0; m < 6; m++) { o.mSale[m] += s.mSale[m]; o.mUpl[m] += s.mUpl[m]; o.mDmp[m] += s.mDmp[m] }
        if (s.visitDay) for (let i = s.visitDay - 1; i < 13; i++) o.cum[i]++;
      });
      return o;
    }
    function health(list) {
      const a = agg(list);
      return [
        ['Visits vs plan', a.sites ? Math.min(100, a.insp[5] / a.sites / ELAPSED * 100) : 0],
        ['Sales vs target', a.target ? Math.min(100, a.sale / a.target * 100) : 0],
        ['Nozzles running', a.noz ? a.nozOn / a.noz * 100 : 0],
        ['Sites within agreement', a.sites ? (a.sites - a.leak) / a.sites * 100 : 0],
        ['Tank stock healthy', a.tanksOn ? (1 - a.low / a.tanksOn) * 100 : 0]
      ];
    }

    /* =====================================================================
       STATE
       ===================================================================== */
    const S = { view: 'geo', chart: 'bars', region: null, group: null, sel: null, metric: 'sites', rank: 'leak' };
    let ROWS = [];
    const lvl = () => S.group ? 2 : S.region ? 1 : 0;

    const BASE = {
      sites: 'Sites',
      tm: 'Sites visited by TMs this month',
      sale: 'Sold to customers this month',
      buy: 'Bought from our company this month',
      uplift: 'Upliftment: bought from other companies',
      dmp: 'Dumping: sold to other pump owners',
      shortage: 'Delivery shortage',
      tank: 'Tanks installed',
      noz: 'Nozzles installed'
    };
    /* Public metric key aliases — keep both 'upl' and 'uplift' if needed */
    BASE.upl = BASE.uplift;

    const TONE = { sites: 'blue', tm: 'green', sale: 'green', buy: 'blue', upl: 'red', uplift: 'red', dmp: 'violet', shortage: 'red', tank: 'blue', noz: 'blue' };

    const METRIC_CAP = {
      sites: 'dealers', tm: 'dealers',
      sale: 'fuelFlow', buy: 'fuelFlow', upl: 'fuelFlow', uplift: 'fuelFlow', dmp: 'fuelFlow',
      shortage: 'orders',
      tank: 'inventory', noz: 'inventory'
    };

    function chartTitle() {
      const l = lvl(), m = S.metric;
      if (l === 2 && m === 'sites') return 'Visits in the last 6 months, by site';
      if (l === 2 && m === 'tm') return 'Visited by TM this month?';
      return `${BASE[m] || m}, by ${l === 0 ? 'region' : l === 1 ? (S.view === 'geo' ? 'city' : 'TM') : 'site'}`;
    }
    const MNOTE = {
      sites: '', tm: 'Shows the share of sites the TM has visited so far this month.',
      sale: '', buy: '',
      upl: 'Sites may buy only from our company. Anything here was bought elsewhere.',
      uplift: 'Sites may buy only from our company. Anything here was bought elsewhere.',
      dmp: 'Sites may sell only to customers. Anything here went to another pump owner.',
      shortage: 'Sum of litres that were ordered but not delivered, from the delivery-shortage API.',
      tank: 'Solid blue is running. Amber is stopped.',
      noz: 'Solid blue is running. Amber is stopped.'
    };

    function metric(m, list, l) {
      const a = agg(list);
      switch (m) {
        case 'sites': {
          if (l === 2) { const n6 = a.insp.reduce((x, y) => x + y, 0); return { v: n6, label: `${n6} of 6`, max: 6 }; }
          return { v: a.sites, label: fmt(a.sites) };
        }
        case 'tm': {
          if (l === 2) return { v: a.insp[5] * 100, label: a.insp[5] ? 'Visited' : 'Pending', max: 100 };
          return { v: pc(a.insp[5], a.sites), label: `${a.insp[5]} of ${a.sites}`, max: 100 };
        }
        case 'sale': return { v: a.sale, label: fmtL(a.sale) };
        case 'buy': return { v: a.buy, label: fmtL(a.buy) };
        case 'upl': case 'uplift': return { v: a.upl, label: fmtL(a.upl) };
        case 'dmp': return { v: a.dmp, label: fmtL(a.dmp) };
        case 'shortage': {
          const sh = shortageForSites(list);
          return { v: sh.short, label: fmtL(sh.short / 1000) };
        }
        case 'tank': return { v: a.tanks, label: `${a.tanksOn}/${a.tanks}`, part: a.tanksOn };
        case 'noz': return { v: a.noz, label: `${a.nozOn}/${a.noz}`, part: a.nozOn };
      }
      return { v: 0, label: '—' };
    }

    function rowsFor() {
      if (!S.region) {
        return GEO.map(g => ({
          key: g.r, label: g.r,
          sub: `RM ${g.rm} · ${S.view === 'geo' ? g.c.length + ' cities' : TMS.filter(t => t.region === g.r).length + ' TMs'}`,
          sites: SITES.filter(s => s.region === g.r)
        }));
      }
      if (!S.group) {
        if (S.view === 'geo') {
          const g = GEO.find(x => x.r === S.region);
          if (!g) return [];
          return g.c.map(([c]) => {
            const l = SITES.filter(s => s.city === c);
            return { key: c, label: c, sub: `${l.length} sites · ${new Set(l.map(s => s.tm.name)).size} TMs`, sites: l };
          });
        }
        return TMS.filter(t => t.region === S.region).map(t => ({
          key: t.name, label: t.name,
          sub: `${t.city} · ${t.sites.length} sites`,
          sites: t.sites
        }));
      }
      const base = S.view === 'geo' ? SITES.filter(s => s.city === S.group) : SITES.filter(s => s.tm.name === S.group);
      return base.map(s => {
        const st = ST[status(s)];
        return { key: s.id, label: s.name, sub: `<span class="d" style="background:${st[1]}"></span>${s.id} · ${st[0]}`, sites: [s] };
      });
    }
    function scope() {
      let base = SITES;
      if (S.region) base = base.filter(s => s.region === S.region);
      if (S.group) base = S.view === 'geo' ? base.filter(s => s.city === S.group) : base.filter(s => s.tm.name === S.group);
      if (S.sel) { const r = ROWS.find(r => r.key === S.sel); if (r) return r.sites; }
      return base;
    }
    function scopeName() {
      if (S.sel) { const r = ROWS.find(r => r.key === S.sel); if (r) return r.label; }
      return S.group || S.region || 'All regions';
    }

    /* =====================================================================
       HEADER / CRUMB / STAGE
       ===================================================================== */
    function renderCrumb() {
      const parts = [['All regions', 0]];
      if (S.region) parts.push([S.region, 1]);
      if (S.group) parts.push([S.group, 2]);
      const l = lvl();
      $('#crumb').innerHTML = parts.map((p, i) => {
        const cur = p[1] === l;
        return (i ? '<span aria-hidden="true">/</span>' : '') + `<button data-go="${p[1]}" ${cur ? 'aria-current="true"' : ''}>${p[0]}</button>`;
      }).join('');
      const list = scope();
      const g = S.region && GEO.find(x => x.r === S.region);
      const rmTxt = g ? ` · Regional manager: <b>${g.rm}</b>` : '';
      const clear = S.sel ? `<button id="clr">Clear filter</button>` : '';
      $('#scope').innerHTML = `<span>Cards and report are showing <b>${scopeName()}</b> (${list.length} ${list.length === 1 ? 'site' : 'sites'})${rmTxt}</span>${clear}`;
      document.querySelectorAll('[data-view]').forEach(b => b.setAttribute('aria-pressed', b.dataset.view === S.view));
      document.querySelectorAll('[data-chart]').forEach(b => b.setAttribute('aria-pressed', b.dataset.chart === S.chart));
    }

    function squarify(items, x, y, w, h) {
      const total = items.reduce((s, i) => s + i.v, 0);
      const out = [];
      if (total <= 0) return out;
      let nodes = items.map(i => ({ ...i, a: i.v * w * h / total }));
      const worst = (row, side) => { const s = row.reduce((a, b) => a + b.a, 0), mx = Math.max(...row.map(r => r.a)), mn = Math.min(...row.map(r => r.a)); return Math.max(side * side * mx / (s * s), s * s / (side * side * mn)); };
      while (nodes.length) {
        const side = Math.min(w, h);
        let row = [nodes[0]], i = 1;
        while (i < nodes.length && worst([...row, nodes[i]], side) <= worst(row, side)) { row.push(nodes[i]); i++; }
        const s = row.reduce((a, b) => a + b.a, 0);
        if (w >= h) { const cw = s / h; let cy = y; row.forEach(n => { const ch = n.a / cw; out.push({ ...n, x, y: cy, w: cw, h: ch }); cy += ch; }); x += cw; w -= cw; }
        else { const rh = s / w; let cx = x; row.forEach(n => { const cw2 = n.a / rh; out.push({ ...n, x: cx, y, w: cw2, h: rh }); cx += cw2; }); y += rh; h -= rh; }
        nodes = nodes.slice(row.length);
      }
      return out;
    }

    function renderStage() {
      const l = lvl();
      const cap = CAP();
      const capKey = METRIC_CAP[S.metric];

      // If metric's data source is missing, show placeholder
      if (capKey && !cap[capKey]) {
        const e = (window.REAL_DATA && window.REAL_DATA.meta) || {};
        let endpoint = '—', hint = 'Required API is not connected yet.';
        if (capKey === 'fuelFlow') { endpoint = 'get_dealers_recons_product_wise_new2.php'; hint = 'This metric needs fuel flow data (sales, purchases, upliftment, dumping) per site.'; }
        if (capKey === 'orders') { endpoint = 'get_all_orders_shortage.php'; hint = 'This metric needs delivery-shortage records per site.'; }
        if (capKey === 'inventory') { endpoint = '(inventory API — to be built)'; hint = 'Tanks and nozzles need an inventory API that lists installed and running equipment per site.'; }
        if (capKey === 'dealers') { endpoint = 'dealers.php'; hint = 'No dealer data available. Check the API.'; }
        $('#stage').innerHTML = apiNeeded(`Cannot show ${BASE[S.metric] || S.metric}`, endpoint, hint);
        $('#ctitle').textContent = chartTitle();
        $('#mnote').textContent = '';
        return;
      }

      const rows = rowsFor().map(r => ({ ...r, m: metric(S.metric, r.sites, l) })).sort((a, b) => b.m.v - a.m.v);
      ROWS = rows;
      const max = (rows[0] && rows[0].m.max) || Math.max(...rows.map(r => r.m.v), 1);
      const stage = $('#stage');
      const tone = `var(--${TONE[S.metric] || 'blue'})`;

      if (S.chart === 'tree') {
        stage.innerHTML = '<div class="tmwrap" id="tmw"></div>';
        const el = $('#tmw'), W = bodyW(el), H = el.clientHeight || 500;
        const items = rows.map(r => ({ r, v: Math.max(r.m.v, max * .04) }));
        const rects = squarify(items, 0, 0, W, H);
        el.innerHTML = rects.map(t => {
          const r = t.r, p = Math.round(22 + 58 * Math.min(r.m.v / max, 1));
          const big = t.w > 90 && t.h > 70;
          return `<div class="tile ${S.sel === r.key ? 'sel' : ''}" role="button" tabindex="0" data-key="${r.key}" aria-label="${r.label}, ${r.m.label}" style="left:${t.x.toFixed(1)}px;top:${t.y.toFixed(1)}px;width:${t.w.toFixed(1)}px;height:${t.h.toFixed(1)}px">
        <div class="ti" style="--tone:${tone};--p:${p}%"><b>${r.label}</b>${t.h > 46 ? `<em>${r.m.label}</em>` : ''}${big ? `<small>${r.sub.replace(/<[^>]+>/g, '')}</small>` : ''}
        ${l < 2 && t.w > 56 && t.h > 56 ? `<button class="open" data-open aria-label="Open ${r.label}" title="Open">&#8250;</button>` : ''}</div></div>`;
        }).join('');
      } else {
        stage.innerHTML = '<div class="rows" id="rws"></div>';
        const el = $('#rws');
        el.innerHTML = rows.map(r => {
          const w = max ? (r.m.v / max * 100).toFixed(1) : '0';
          const bar = r.m.part !== undefined
            ? `<i class="two" style="--w:${w}%"><b style="width:${r.m.v ? (r.m.part / r.m.v * 100).toFixed(1) : 0}%"></b></i>`
            : `<i style="--w:${w}%;--tone:${tone}"></i>`;
          return `<div class="row ${S.sel === r.key ? 'sel' : ''}" role="button" tabindex="0" data-key="${r.key}" aria-label="${r.label}, ${r.m.label}">
        <div class="lbl"><b>${r.label}</b><small>${r.sub}</small></div>
        <div class="track">${bar}</div>
        <div class="val">${r.m.label}</div>
        ${l < 2 ? `<button class="open" data-open aria-label="Open ${r.label}" title="Open">&#8250;</button>` : '<span></span>'}
      </div>`;
        }).join('');
        requestAnimationFrame(() => requestAnimationFrame(() => el.classList.add('go')));
      }
      $('#ctitle').textContent = chartTitle();
      $('#mnote').textContent = (l < 2 ? 'Tap to filter. Double-tap to open. ' : 'Tap to see only that site. ') + (MNOTE[S.metric] || '');
    }

    /* =====================================================================
       CARDS
       ===================================================================== */
    function card(id, label, big, viz, legend, cls = '') {
      return `<button class="card ${cls} ${S.metric === id ? 'on' : ''}" data-m="${id}" aria-pressed="${S.metric === id}">
    <span class="cl">${label}</span>
    <span class="cmain"><span class="cn">${big}</span><span class="cviz">${viz}</span></span>
    <span class="leg">${legend}</span></button>`;
    }
    function cardMissing(id, label, endpoint, hint) {
      return `<button class="card missing" data-m="${id}" aria-disabled="true" title="API not available yet">
    <span class="cl">${label}</span>
    <span class="cmain"><span class="cn api">API needed</span>
      <span class="cviz"><svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></span>
    </span>
    <span class="leg">${hint}<br><code style="font-size:10.5px;color:var(--muted)">${endpoint}</code></span></button>`;
    }

    function renderCards() {
      const list = scope();
      const a = agg(list);
      const ser = series(list);
      const cap = CAP();
      const IN = a.buy + a.upl, OUT = a.sale + a.dmp;
      const uplSites = list.filter(s => s.upl > .001).length;
      const dmpSites = list.filter(s => s.dmp > .001).length;
      const prodLeg = f => PK.filter(k => a.p[k].tanks > 0).map(k => dot(pv(k), `${PS[k]} ${pc(a.p[k][f], a[f])}%`)).join('');
      const visitedPct = a.sites ? a.insp[5] / a.sites * 100 : 0;
      const sh = shortageForSites(list);

      const out = [];

      // Sites
      out.push(card('sites', 'Sites', fmt(a.sites),
        miniDonut([{ v: a.st.ok, c: 'var(--green)' }, { v: a.st.low, c: 'var(--amber)' }, { v: a.st.none, c: 'var(--red)' }], 58),
        dot('var(--green)', `${a.st.ok} selling`) + dot('var(--amber)', `${a.st.low} low`) + dot('var(--red)', `${a.st.none} none`)));

      // TM card — needs dealers + tour
      if (cap.tour || cap.dealers) {
        out.push(card('tm', 'Territory managers (TMs)', fmt(a.tmCount),
          ring(visitedPct, 'var(--green)', 58),
          cap.inspections
            ? dot('var(--green)', `${a.insp[5]} of ${a.sites} sites visited`)
            : '<span style="color:var(--muted)">Visit API needed for pace</span>'));
      } else {
        out.push(cardMissing('tm', 'Territory managers (TMs)', 'dealers.php', 'Dealer list is not loaded.'));
      }

      // Fuel cards
      if (cap.fuelFlow) {
        out.push(card('sale', 'Sold to customers', fmtL(a.sale), spark(ser.dSale, 'var(--green)'),
          `<span>${fmtL(a.sale / 14)} per day on average</span>`));
        out.push(card('buy', 'Bought from our company', fmtL(a.buy), spark(ser.dBuy, 'var(--blue)'), prodLeg('buy') || '<span style="color:var(--muted)">No product detail</span>'));
      } else {
        out.push(cardMissing('sale', 'Sold to customers', 'get_dealers_recons_product_wise_new2.php', 'Needs reconciliation data per site.'));
        out.push(cardMissing('buy', 'Bought from our company', 'get_dealers_recons_product_wise_new2.php', 'Needs reconciliation data per site.'));
      }

      // Shortage card (orders)
      if (cap.orders && sh.deliveries) {
        out.push(card('shortage', 'Delivery shortage', fmtL(sh.short / 1000), '',
          dot('var(--red)', `${sh.pct.toFixed(2)}% of ordered volume`) +
          dot('var(--muted)', `${sh.deliveries} deliveries`),
          'al'));
      } else {
        out.push(cardMissing('shortage', 'Delivery shortage', 'get_all_orders_shortage.php', 'Needs delivery-shortage records.'));
      }

      // Upliftment / Dumping
      if (cap.fuelFlow) {
        out.push(card('upl', 'Upliftment: bought from other companies', fmtL(a.upl), spark(ser.dUpl, 'var(--red)'),
          dot('var(--red)', `${IN ? (a.upl / IN * 100).toFixed(1) : '0'}% of stock in`) + dot('var(--muted)', `${uplSites} sites`),
          'al' + (a.upl < .001 ? ' zero' : '')));
        out.push(card('dmp', 'Dumping: sold to other pump owners', fmtL(a.dmp), spark(ser.dDmp, 'var(--violet)'),
          dot('var(--violet)', `${OUT ? (a.dmp / OUT * 100).toFixed(1) : '0'}% of stock out`) + dot('var(--muted)', `${dmpSites} sites`),
          'dm' + (a.dmp < .001 ? ' zero' : '')));
      } else {
        out.push(cardMissing('upl', 'Upliftment: bought from other companies', 'get_dealers_recons_product_wise_new2.php', 'Needs reconciliation data.'));
        out.push(cardMissing('dmp', 'Dumping: sold to other pump owners', 'get_dealers_recons_product_wise_new2.php', 'Needs reconciliation data.'));
      }

      // Tanks / nozzles — always missing (no inventory API)
      out.push(cardMissing('tank', 'Tanks installed', '(inventory API)', 'Add an endpoint listing installed and running tanks per site.'));
      out.push(cardMissing('noz', 'Nozzles installed', '(inventory API)', 'Add an endpoint listing installed and running nozzles per site.'));

      $('#cards').innerHTML = out.join('');
    }

    /* =====================================================================
       REPORT CHARTS
       ===================================================================== */
    function chSankey(el, ctx) {
      if (!CAP().fuelFlow) {
        el.innerHTML = apiNeeded('Stock flow needs fuel data', 'get_dealers_recons_product_wise_new2.php',
          'This chart shows where product came from and where it went. It will render as soon as the reconciliation API is available.');
        return;
      }
      const a = ctx.a, W = bodyW(el), narrow = W < 560;
      const LM = narrow ? 98 : 160, RM = narrow ? 108 : 178, H = narrow ? 250 : 290, nw = 12, gap = 38;
      const IN = a.buy + a.upl, OUT = a.sale + a.dmp, M = Math.max(IN, OUT, 1e-6);
      const sc = (H - gap * 1.4) / M, mt = v => v > 0 ? Math.max(v * sc, 3) : 0;
      const hb = mt(a.buy), hu = mt(a.upl), hs = mt(a.sale), hd = mt(a.dmp);
      const midH = Math.max(hb + hu, hs + hd, 10), midY = (H - midH) / 2;
      const lt = hb + hu + (hb && hu ? gap : 0), ly = (H - lt) / 2;
      const rt = hs + hd + (hs && hd ? gap : 0), ry = (H - rt) / 2;
      const xL = LM, xR = W - RM - nw, xM = (xL + xR) / 2 - nw / 2;
      const ids = ['sa', 'sb', 'sc', 'sd'].map(x => x + (++UID));
      const grad = (id, c) => `<linearGradient id="${id}" x1="0" x2="1" y1="0" y2="0"><stop offset="0" style="stop-color:${c};stop-opacity:.55"/><stop offset="1" style="stop-color:${c};stop-opacity:.22"/></linearGradient>`;
      const rib = (x0, y0a, y0b, x1, y1a, y1b, fill, tipTxt) => {
        if (y0b - y0a <= 0) return '';
        const xm = (x0 + x1) / 2;
        return `<path d="M${x0} ${y0a}C${xm} ${y0a} ${xm} ${y1a} ${x1} ${y1a}L${x1} ${y1b}C${xm} ${y1b} ${xm} ${y0b} ${x0} ${y0b}Z" fill="${fill}" data-tip="${tipTxt}"/>`;
      };
      const yBuy = ly, yUpl = ly + hb + (hb && hu ? gap : 0), ySale = ry, yDmp = ry + hs + (hs && hd ? gap : 0);
      let r = '';
      r += rib(xL + nw, yBuy, yBuy + hb, xM, midY, midY + hb, `url(#${ids[0]})`, `<b>Our company to sites</b><br>${fmtL(a.buy)}`);
      r += rib(xL + nw, yUpl, yUpl + hu, xM, midY + hb, midY + hb + hu, `url(#${ids[1]})`, `<b>Other companies to sites</b><br>${fmtL(a.upl)} (upliftment)`);
      r += rib(xM + nw, midY, midY + hs, xR, ySale, ySale + hs, `url(#${ids[2]})`, `<b>Sites to customers</b><br>${fmtL(a.sale)}`);
      r += rib(xM + nw, midY + hs, midY + hs + hd, xR, yDmp, yDmp + hd, `url(#${ids[3]})`, `<b>Sites to other pump owners</b><br>${fmtL(a.dmp)} (dumping)`);
      const node = (x, y, h, c) => h > 0 ? `<rect x="${x}" y="${y}" width="${nw}" height="${h}" rx="4" fill="${c}"/>` : '';
      const lab = (x, y, anchor, t1, t2, c) => `<text x="${x}" y="${y - 2}" text-anchor="${anchor}" font-size="${narrow ? 11 : 12.5}" font-weight="700" fill="${c || 'var(--ink)'}">${t1}</text><text x="${x}" y="${y + 13}" text-anchor="${anchor}" font-size="${narrow ? 10.5 : 11.5}" fill="var(--muted)">${t2}</text>`;
      el.innerHTML = `<svg viewBox="0 0 ${W} ${H}" width="${W}" height="${H}" role="img" aria-label="Flow of product into and out of sites">
    <defs>${grad(ids[0], 'var(--blue)')}${grad(ids[1], 'var(--red)')}${grad(ids[2], 'var(--green)')}${grad(ids[3], 'var(--violet)')}</defs>
    ${r}
    ${node(xL, yBuy, hb, 'var(--blue)')}${node(xL, yUpl, hu, 'var(--red)')}
    <rect x="${xM}" y="${midY}" width="${nw}" height="${midH}" rx="4" fill="var(--muted)" opacity=".55"/>
    ${node(xR, ySale, hs, 'var(--green)')}${node(xR, yDmp, hd, 'var(--violet)')}
    ${hb ? lab(xL - 8, yBuy + hb / 2 + 3, 'end', 'Our company', `${fmtL(a.buy)} · ${IN ? Math.round(a.buy / IN * 100) : 0}%`) : ''}
    ${hu || a.upl === 0 ? lab(xL - 8, (hu ? yUpl + hu / 2 : ly + lt + 14) + 3, 'end', 'Other companies', `${fmtL(a.upl)} · ${IN ? (a.upl / IN * 100).toFixed(1) : 0}%`, 'var(--red)') : ''}
    ${hs ? lab(xR + nw + 8, ySale + hs / 2 + 3, 'start', 'Customers', `${fmtL(a.sale)} · ${OUT ? Math.round(a.sale / OUT * 100) : 0}%`) : ''}
    ${hd || a.dmp === 0 ? lab(xR + nw + 8, (hd ? yDmp + hd / 2 : ry + rt + 14) + 3, 'start', 'Other pump owners', `${fmtL(a.dmp)} · ${OUT ? (a.dmp / OUT * 100).toFixed(1) : 0}%`, 'var(--violet)') : ''}
    <text x="${xM + nw / 2}" y="${Math.max(midY - 8, 12)}" text-anchor="middle" font-size="11.5" font-weight="700" fill="var(--muted)">Site tanks</text>
  </svg>`;
    }

    function chRadar(el, ctx) {
      if (!CAP().fuelFlow && !CAP().inspections) {
        el.innerHTML = apiNeeded('Health radar needs data', 'recon + inspections API',
          'The radar needs fuel-flow and inspection data. Once loaded, each axis becomes available.');
        return;
      }
      const W = bodyW(el), size = Math.min(W, 380), H = size, cx = W / 2, cy = H / 2, Rr = size / 2 - 62;
      const me = ctx.h, net = NETWORK_HEALTH, n = 5;
      const ang = i => -Math.PI / 2 + i * 2 * Math.PI / n;
      const P = (i, v) => [cx + Rr * v / 100 * Math.cos(ang(i)), cy + Rr * v / 100 * Math.sin(ang(i))];
      const poly = vals => vals.map((v, i) => P(i, v).map(x => x.toFixed(1)).join(',')).join(' ');
      const rings = [25, 50, 75, 100].map(v => `<polygon points="${poly(new Array(n).fill(v))}" fill="none" class="gl"/>`).join('');
      const spokes = me.map((_, i) => { const p = P(i, 100); return `<line x1="${cx}" y1="${cy}" x2="${p[0].toFixed(1)}" y2="${p[1].toFixed(1)}" class="gl"/>` }).join('');
      const labels = me.map((m, i) => {
        const c = Math.cos(ang(i)), s = Math.sin(ang(i)), x = cx + (Rr + 16) * c, y = cy + (Rr + 16) * s;
        const anchor = Math.abs(c) < .2 ? 'middle' : c > 0 ? 'start' : 'end';
        return `<text x="${x.toFixed(1)}" y="${(y + (s > .5 ? 10 : s < -.5 ? -10 : 0)).toFixed(1)}" text-anchor="${anchor}" font-size="11.5" font-weight="700" fill="var(--ink)">${m[0]}</text>
            <text x="${x.toFixed(1)}" y="${(y + (s > .5 ? 24 : s < -.5 ? 4 : 14)).toFixed(1)}" text-anchor="${anchor}" font-size="11.5" fill="var(--muted)">${Math.round(m[1])}%</text>`;
      }).join('');
      const dots = me.map((m, i) => { const p = P(i, m[1]); return `<circle cx="${p[0].toFixed(1)}" cy="${p[1].toFixed(1)}" r="4.5" fill="var(--blue)" stroke="var(--solid)" stroke-width="2" data-tip="<b>${m[0]}</b><br>This view: ${Math.round(m[1])}%<br>Whole network: ${Math.round(net[i][1])}%"/>` }).join('');
      el.innerHTML = `<svg viewBox="0 0 ${W} ${H}" width="${W}" height="${H}" role="img" aria-label="Health radar">
    ${rings}${spokes}
    <polygon points="${poly(net.map(x => x[1]))}" fill="none" stroke="var(--muted)" stroke-width="1.6" stroke-dasharray="5 4"/>
    <polygon points="${poly(me.map(x => x[1]))}" fill="var(--blue)" fill-opacity=".22" stroke="var(--blue)" stroke-width="2.4" stroke-linejoin="round"/>
    ${dots}${labels}</svg>
    <div class="leg" style="justify-content:center;margin-top:6px">${dot('var(--blue)', 'This view')}${dot('var(--muted)', 'Whole network (dashed)')}</div>`;
    }

    function chDaily(el, ctx) {
      if (!CAP().fuelFlow) {
        el.innerHTML = apiNeeded('Daily flow needs fuel data', 'get_dealers_recons_product_wise_new2.php',
          'Day-by-day sales, purchases, upliftment and dumping. Will render when the reconciliation API is connected.');
        return;
      }
      const sr = ctx.sr, W = bodyW(el), L = 58, Rm = 14, T = 10, H1 = 170, gap = 34, H2 = 76, B = 26, H = T + H1 + gap + H2 + B;
      const pw = W - L - Rm, band = pw / 13, xc = i => L + band * (i + .5);
      const sc1 = niceScale(Math.max(...sr.dSale, ...sr.dBuy, 1), 4);
      const sc2 = niceScale(Math.max(...sr.dUpl, ...sr.dDmp, .5), 2);
      const y1 = v => T + H1 - v / sc1.max * H1;
      const y2 = v => T + H1 + gap + H2 - v / sc2.max * H2;
      const idG = 'dg' + (++UID), idB = 'db' + (++UID);
      let g = '';
      for (let v = 0; v <= sc1.max + 1e-9; v += sc1.step) g += `<line x1="${L}" x2="${W - Rm}" y1="${y1(v)}" y2="${y1(v)}" class="gl"/><text x="${L - 8}" y="${y1(v) + 4}" text-anchor="end" class="ax">${fmtA(v)}</text>`;
      for (let v = 0; v <= sc2.max + 1e-9; v += sc2.step) g += `<line x1="${L}" x2="${W - Rm}" y1="${y2(v)}" y2="${y2(v)}" class="gl"/><text x="${L - 8}" y="${y2(v) + 4}" text-anchor="end" class="ax">${fmtA(v)}</text>`;
      let sun = '';
      for (let i = 0; i < 13; i++) if (isSun(i + 1)) sun += `<rect x="${L + band * i}" y="${T}" width="${band}" height="${H1}" class="wk"/><rect x="${L + band * i}" y="${T + H1 + gap}" width="${band}" height="${H2}" class="wk"/>`;
      const step = W < 520 ? 2 : 1;
      let xl = '';
      for (let i = 0; i < 13; i += step) xl += `<text x="${xc(i)}" y="${H - 8}" text-anchor="middle" class="ax">${i === 0 ? '1 Oct' : i + 1}</text>`;
      const bw = Math.min(band * .5, 26);
      const cols = sr.dBuy.map((v, i) => v > 0 ? `<rect x="${xc(i) - bw / 2}" y="${y1(v)}" width="${bw}" height="${T + H1 - y1(v)}" rx="4" fill="url(#${idB})"/>` : '').join('');
      const pts = sr.dSale.map((v, i) => [xc(i), y1(v)]);
      const line = smooth(pts), area = line + `L${xc(12)} ${T + H1}L${xc(0)} ${T + H1}Z`;
      const bw2 = Math.min(band * .26, 12);
      const lo = sr.dUpl.map((v, i) => (v > 0 ? `<rect x="${xc(i) - bw2 - 1}" y="${y2(v)}" width="${bw2}" height="${T + H1 + gap + H2 - y2(v)}" rx="3" fill="var(--red)"/>` : '') + (sr.dDmp[i] > 0 ? `<rect x="${xc(i) + 1}" y="${y2(sr.dDmp[i])}" width="${bw2}" height="${T + H1 + gap + H2 - y2(sr.dDmp[i])}" rx="3" fill="var(--violet)"/>` : '')).join('');
      el.innerHTML = `<svg viewBox="0 0 ${W} ${H}" width="${W}" height="${H}" role="img" aria-label="Daily flows">
    <defs><linearGradient id="${idG}" x1="0" y1="0" x2="0" y2="1"><stop offset="0" style="stop-color:var(--green);stop-opacity:.35"/><stop offset="1" style="stop-color:var(--green);stop-opacity:0"/></linearGradient>
    <linearGradient id="${idB}" x1="0" y1="0" x2="0" y2="1"><stop offset="0" style="stop-color:var(--blue);stop-opacity:.75"/><stop offset="1" style="stop-color:var(--blue);stop-opacity:.25"/></linearGradient></defs>
    ${sun}${g}${cols}
    <path d="${area}" fill="url(#${idG})"/><path d="${line}" fill="none" stroke="var(--green)" stroke-width="2.6" stroke-linecap="round"/>
    ${lo}
    <text x="${L}" y="${T + H1 + gap - 10}" class="ax" font-weight="700" fill="var(--muted)">Outside the agreement, per day</text>
    ${xl}
    <line id="cx" x1="0" x2="0" y1="${T}" y2="${T + H1 + gap + H2}" stroke="var(--ink)" stroke-opacity=".35" stroke-dasharray="3 3" visibility="hidden"/>
    <rect id="ov" data-keep="1" x="${L}" y="${T}" width="${pw}" height="${H - T - B}" fill="transparent"/></svg>
    <div class="leg" style="margin-top:6px">${dot('var(--green)', 'Sold to customers (line)')}${dot('var(--blue)', 'Bought from our company (columns)')}${dot('var(--red)', 'Upliftment')}${dot('var(--violet)', 'Dumping')}${dot('var(--muted)', 'Shaded days are Sundays')}</div>
    <p class="note">Daily values are <b>approximated</b> from the period totals returned by the reconciliation API, since no day-by-day fuel API exists yet.</p>`;
      const ov = el.querySelector('#ov'), cx = el.querySelector('#cx');
      const move = e => {
        const r = ov.getBoundingClientRect(), i = Math.max(0, Math.min(12, Math.floor((e.clientX - r.left) / r.width * 13)));
        cx.setAttribute('x1', xc(i)); cx.setAttribute('x2', xc(i)); cx.setAttribute('visibility', 'visible');
        showTip(`<b>${i + 1} October${isSun(i + 1) ? ' (Sunday)' : ''}</b><br>${dot('var(--green)', 'Sold')} <b>${fmtL(sr.dSale[i])}</b><br>${dot('var(--blue)', 'Bought from us')} <b>${fmtL(sr.dBuy[i])}</b><br>${dot('var(--red)', 'Upliftment')} <b>${fmtL(sr.dUpl[i])}</b><br>${dot('var(--violet)', 'Dumping')} <b>${fmtL(sr.dDmp[i])}</b>`, e.clientX, e.clientY);
      };
      ov.addEventListener('pointermove', move); ov.addEventListener('pointerdown', move);
      ov.addEventListener('pointerleave', () => { cx.setAttribute('visibility', 'hidden'); hideTip(); });
    }

    function chMix(el, ctx) {
      if (!CAP().fuelFlow) {
        el.innerHTML = apiNeeded('Product mix needs fuel data', 'get_dealers_recons_product_wise_new2.php',
          'Shows how PMG, HSD and HOBC split on the way in and on the way out.');
        return;
      }
      const a = ctx.a, ks = PK.filter(k => a.p[k].sale > 0 || a.p[k].buy > 0);
      const size = Math.min(bodyW(el), 230), c = size / 2;
      const sold = ks.map(k => ({ v: a.p[k].sale, c: pv(k), tip: `<b>Sold: ${PS[k]}</b><br>${fmtL(a.p[k].sale)} (${pc(a.p[k].sale, a.sale)}%)` }));
      const bought = ks.map(k => ({ v: a.p[k].buy, c: pv(k), tip: `<b>Bought: ${PS[k]}</b><br>${fmtL(a.p[k].buy)} (${pc(a.p[k].buy, a.buy)}%)` }));
      el.innerHTML = `<div class="mixwrap"><svg width="${size}" height="${size}" viewBox="0 0 ${size} ${size}" role="img" aria-label="Product mix">
    ${ringSegs(c, c, c * .72, c - 2, sold)}${ringSegs(c, c, c * .42, c * .66, bought).replace(/<path /g, '<path opacity=".6" ')}
    <text x="${c}" y="${c - 2}" text-anchor="middle" font-size="${size > 200 ? 20 : 16}" font-weight="800" fill="var(--ink)">${fmtL(a.sale)}</text>
    <text x="${c}" y="${c + 15}" text-anchor="middle" font-size="11" fill="var(--muted)">sold</text></svg>
    <div class="mixleg">${ks.map(k => `<div><span class="d" style="background:${pv(k)};margin:0"></span><b>${PN[k]}</b><small>Sold ${pc(a.p[k].sale, a.sale)}% · Bought ${pc(a.p[k].buy, a.buy)}%</small></div>`).join('')}
    <div class="leg"><span>Outer ring: sold. Inner ring: bought.</span></div></div></div>`;
    }

    function chBubble(el, ctx) {
      if (!CAP().fuelFlow) {
        el.innerHTML = apiNeeded('Sales vs leakage needs fuel data', 'get_dealers_recons_product_wise_new2.php',
          'Each dot is one site: sales against the share that leaked outside the agreement.');
        return;
      }
      if (!CAP().targets) {
        el.innerHTML = apiNeeded('Sales vs target needs a target API', '(sales target API — to be built)',
          'Bubble chart compares each site\'s sales to its target. A per-site monthly target endpoint is required.');
        return;
      }
      // (kept for when targets API exists)
      const list = ctx.list.filter(s => s.sale > 0);
      el.innerHTML = `<p class="empty">Target API loaded — bubble will render once enabled.</p>`;
    }

    function chMonthly(el, ctx) {
      if (!CAP().fuelFlow) {
        el.innerHTML = apiNeeded('Monthly trend needs fuel data', 'get_dealers_recons_product_wise_new2.php (with 6 months of history)',
          'Average daily sales and leakage over the last six months.');
        return;
      }
      const sr = ctx.sr, W = bodyW(el), H = 240, L = 48, Rm = 44, T = 26, B = 30;
      const pw = W - L - Rm, ph = H - T - B, band = pw / 6;
      const avg = sr.mSale.map((v, m) => v / DIM[m]);
      const leak = sr.mSale.map((v, m) => v ? (sr.mUpl[m] + sr.mDmp[m]) / v * 100 : 0);
      const s1 = niceScale(Math.max(...avg, 1), 4), s2 = niceScale(Math.max(...leak, 1), 4);
      const yA = v => T + ph - v / s1.max * ph, yB = v => T + ph - v / s2.max * ph, xc = i => L + band * (i + .5);
      const idG = 'mg' + (++UID);
      let g = '';
      for (let v = 0; v <= s1.max + 1e-9; v += s1.step) g += `<line x1="${L}" x2="${W - Rm}" y1="${yA(v)}" y2="${yA(v)}" class="gl"/><text x="${L - 8}" y="${yA(v) + 4}" text-anchor="end" class="ax">${fmtA(v)}</text>`;
      for (let v = 0; v <= s2.max + 1e-9; v += s2.step) g += `<text x="${W - Rm + 8}" y="${yB(v) + 4}" class="ax" fill="var(--red)">${+v.toFixed(1)}%</text>`;
      const bw = Math.min(band * .55, 48);
      const bars = avg.map((v, i) => `<rect x="${xc(i) - bw / 2}" y="${yA(v)}" width="${bw}" height="${T + ph - yA(v)}" rx="7" fill="url(#${idG})" opacity="${i === 5 ? .6 : 1}"/>
    <text x="${xc(i)}" y="${H - 10}" text-anchor="middle" class="ax">${MONTHS[i]}${i === 5 ? ' (14 days)' : ''}</text>`).join('');
      const pts = leak.map((v, i) => [xc(i), yB(v)]);
      const dotsL = pts.map((p, i) => `<circle cx="${p[0]}" cy="${p[1]}" r="4.5" fill="var(--solid)" stroke="var(--red)" stroke-width="2.4"/><text x="${p[0]}" y="${p[1] - 10}" text-anchor="middle" font-size="11" font-weight="700" fill="var(--red)">${leak[i].toFixed(1)}%</text>`).join('');
      const hit = avg.map((v, i) => `<rect x="${L + band * i}" y="${T}" width="${band}" height="${ph}" fill="transparent" data-tip="<b>${MONTHS[i]}${i === 5 ? ' (1 to 14)' : ''}</b><br>Sold ${fmtA(v)} per day<br>Outside agreement ${leak[i].toFixed(1)}% of sales<br>Upliftment ${fmtL(sr.mUpl[i])} · Dumping ${fmtL(sr.mDmp[i])}"/>`).join('');
      el.innerHTML = `<svg viewBox="0 0 ${W} ${H}" width="${W}" height="${H}" role="img" aria-label="Monthly sales and leakage">
    <defs><linearGradient id="${idG}" x1="0" y1="0" x2="0" y2="1"><stop offset="0" style="stop-color:var(--green);stop-opacity:.9"/><stop offset="1" style="stop-color:var(--green);stop-opacity:.3"/></linearGradient></defs>
    ${g}${bars}<path d="${smooth(pts)}" fill="none" stroke="var(--red)" stroke-width="2.4" stroke-linecap="round"/>${dotsL}${hit}
    <text x="${L}" y="12" class="ax" font-weight="700">Average sold per day</text>
    <text x="${W - Rm + 8}" y="12" class="ax" font-weight="700" fill="var(--red)">Leakage</text></svg>
    <p class="note">Only the current month has real data. Older months will fill in once the API returns 6 months of history.</p>`;
    }

    function chPace(el, ctx) {
      if (!CAP().inspections) {
        el.innerHTML = apiNeeded('Visit pace needs inspection data', 'all_dealers_inspection.php',
          'Tracks how many sites have been visited so far this month against the even-pace plan.');
        return;
      }
      const sr = ctx.sr, n = ctx.a.sites, W = bodyW(el), H = 230, L = 40, Rm = 18, T = 16, B = 28;
      const pw = W - L - Rm, ph = H - T - B;
      const X = d => L + d / 31 * pw, Y = v => T + ph - v / 100 * ph;
      const act = sr.cum.map(v => n ? v / n * 100 : 0), a13 = act[12], rate = a13 / 14;
      const fin = Math.min(100, rate * 31), idG = 'pg' + (++UID);
      const pts = [[X(0), Y(0)], ...act.map((v, i) => [X(i + 1), Y(v)])];
      const line = pts.map((p, i) => (i ? 'L' : 'M') + p[0].toFixed(1) + ' ' + p[1].toFixed(1)).join('');
      const area = line + `L${X(13)} ${Y(0)}L${X(0)} ${Y(0)}Z`;
      let g = '';
      [0, 25, 50, 75, 100].forEach(v => g += `<line x1="${L}" x2="${W - Rm}" y1="${Y(v)}" y2="${Y(v)}" class="gl"/><text x="${L - 8}" y="${Y(v) + 4}" text-anchor="end" class="ax">${v}%</text>`);
      [1, 8, 15, 22, 31].forEach(d => g += `<text x="${X(d)}" y="${H - 8}" text-anchor="middle" class="ax">${d}${d === 1 ? ' Oct' : ''}</text>`);
      const col = fin >= 99 ? 'var(--green)' : fin >= 80 ? 'var(--amber)' : 'var(--red)';
      el.innerHTML = `<svg viewBox="0 0 ${W} ${H}" width="${W}" height="${H}" role="img" aria-label="Visit pace">
    <defs><linearGradient id="${idG}" x1="0" y1="0" x2="0" y2="1"><stop offset="0" style="stop-color:var(--green);stop-opacity:.4"/><stop offset="1" style="stop-color:var(--green);stop-opacity:0"/></linearGradient></defs>
    ${g}
    <line x1="${X(0)}" y1="${Y(0)}" x2="${X(31)}" y2="${Y(100)}" stroke="var(--muted)" stroke-width="1.8" stroke-dasharray="6 5"/>
    <line x1="${X(13)}" x2="${X(13)}" y1="${T}" y2="${T + ph}" stroke="var(--ink)" stroke-opacity=".3" stroke-dasharray="3 3"/>
    <text x="${X(13) - 6}" y="${T + 10}" text-anchor="end" class="ax" font-weight="700">Today</text>
    <path d="${area}" fill="url(#${idG})"/><path d="${line}" fill="none" stroke="var(--green)" stroke-width="2.8" stroke-linejoin="round" stroke-linecap="round"/>
    <line x1="${X(13)}" y1="${Y(a13)}" x2="${X(31)}" y2="${Y(fin)}" stroke="${col}" stroke-width="2.4" stroke-dasharray="2 5" stroke-linecap="round"/>
    <circle cx="${X(13)}" cy="${Y(a13)}" r="5" fill="var(--green)" stroke="var(--solid)" stroke-width="2" data-tip="<b>Today</b><br>${Math.round(a13)}% of sites visited<br>Plan says ${Math.round(ELAPSED * 100)}%"/>
    <circle cx="${X(31)}" cy="${Y(fin)}" r="5" fill="${col}" stroke="var(--solid)" stroke-width="2" data-tip="<b>At today's pace</b><br>${Math.round(fin)}% visited by 31 October"/>
    <text x="${Math.min(X(31), W - Rm)}" y="${Math.max(Y(fin) - 12, T + 10)}" text-anchor="end" font-size="12" font-weight="800" fill="${col}">${Math.round(fin)}% by month end</text></svg>
    <div class="leg" style="margin-top:6px">${dot('var(--green)', 'Sites visited so far')}${dot('var(--muted)', 'Plan: even pace to 100%')}${dot(col, "At today's pace")}</div>`;
    }

    function chHeat(el, ctx) {
      if (!CAP().inspections) {
        el.innerHTML = apiNeeded('Visit heatmap needs inspection data', 'all_dealers_inspection.php',
          'Shows which TM visited which site on which day of October.');
        return;
      }
      const W = bodyW(el), lw = W < 520 ? 96 : 150, tw = 56, all = tmsOf(ctx.list);
      const rowsAll = all.map(t => {
        const days = new Array(13).fill(0);
        t.sites.forEach(s => { if (s.visitDay) days[s.visitDay - 1]++ });
        const d = days.reduce((x, y) => x + y, 0);
        return { t, days, d, n: t.sites.length, p: t.sites.length ? d / t.sites.length : 0 };
      }).sort((x, y) => x.p - y.p);
      if (!rowsAll.length) { el.innerHTML = '<p class="empty">No TM data in this scope.</p>'; return; }
      const rows = rowsAll.slice(0, 12);
      const cell = Math.max(Math.floor((W - lw - tw) / 13), 10);
      const rh = Math.min(cell + 4, 28), H = 26 + rows.length * rh + 4;
      const mx = Math.max(...rows.flatMap(r => r.days), 1);
      let out = `<text x="0" y="14" class="ax" font-weight="700">October</text>`;
      for (let i = 0; i < 13; i++) out += `<text x="${lw + i * cell + cell / 2}" y="14" text-anchor="middle" class="ax">${W < 520 && i % 2 ? '' : i + 1}</text>`;
      rows.forEach((r, ri) => {
        const y = 24 + ri * rh;
        const nm = r.t.name.length > (W < 520 ? 12 : 18) ? r.t.name.slice(0, W < 520 ? 11 : 17) + '…' : r.t.name;
        out += `<text x="0" y="${y + rh / 2 + 3}" font-size="12" font-weight="600" fill="var(--ink)">${nm}</text>`;
        for (let i = 0; i < 13; i++) {
          const c = r.days[i], sun = isSun(i + 1);
          const fill = sun ? 'var(--line)' : c ? 'var(--green)' : 'var(--chip)';
          const op = sun ? .5 : c ? (.25 + .75 * c / mx) : 1;
          out += `<rect x="${lw + i * cell + 1}" y="${y + 1}" width="${cell - 2}" height="${rh - 3}" rx="5" fill="${fill}" opacity="${op}" data-tip="<b>${r.t.name}</b><br>${i + 1} October${sun ? ' (Sunday)' : ''}: ${c} ${c === 1 ? 'visit' : 'visits'}"/>`;
        }
        const col = r.p >= ELAPSED ? 'var(--green)' : r.p >= ELAPSED - .15 ? 'var(--amber)' : 'var(--red)';
        out += `<text x="${W}" y="${y + rh / 2 + 4}" text-anchor="end" font-size="12" font-weight="800" fill="${col}">${r.d}/${r.n}</text>`;
      });
      el.innerHTML = `<svg viewBox="0 0 ${W} ${H}" width="${W}" height="${H}" role="img" aria-label="Visits by TM and day">${out}</svg>
    <p class="note">Each square is one day. A darker square means more sites visited that day. The grey columns are Sundays. The number on the right is sites visited out of sites assigned.${rowsAll.length > 12 ? ` Showing the 12 furthest behind of ${rowsAll.length} TMs.` : ''}</p>`;
    }

    function chGauges(el, ctx) {
      if (!CAP().inventory) {
        el.innerHTML = apiNeeded('Equipment status needs an inventory API', '(tanks + nozzles API — to be built)',
          'This panel shows how many tanks, nozzles and sites are running right now. It needs an endpoint listing installed and running equipment per site.');
        return;
      }
      // (Future-ready implementation)
      const a = ctx.a, W = bodyW(el), cw = W / 3, r = Math.min(cw / 2 - 10, 62), H = r + 56;
      const G = [['Tanks running', pc(a.tanksOn, a.tanks), `${a.tanksOn} of ${a.tanks}`],
      ['Nozzles running', pc(a.nozOn, a.noz), `${a.nozOn} of ${a.noz}`],
      ['Sites selling', pc(a.st.ok + a.st.low, a.sites), `${a.st.ok + a.st.low} of ${a.sites}`]];
      const pt = (cx, cy, t) => { const th = Math.PI - t * Math.PI; return [cx + r * Math.cos(th), cy - r * Math.sin(th)] };
      const arc = (cx, cy, t) => { const A = pt(cx, cy, 0), B = pt(cx, cy, t); return `M${A[0].toFixed(1)} ${A[1].toFixed(1)}A${r} ${r} 0 0 1 ${B[0].toFixed(1)} ${B[1].toFixed(1)}` };
      const out = G.map((g, i) => {
        const cx = cw * i + cw / 2, cy = r + 14, t = Math.max(g[1], 0) / 100;
        const col = g[1] >= 95 ? 'var(--green)' : g[1] >= 85 ? 'var(--amber)' : 'var(--red)';
        return `<path d="${arc(cx, cy, 1)}" fill="none" stroke="var(--track)" stroke-width="13" stroke-linecap="round"/>
      ${t > 0 ? `<path d="${arc(cx, cy, Math.max(t, .02))}" fill="none" stroke="${col}" stroke-width="13" stroke-linecap="round" data-tip="<b>${g[0]}</b><br>${g[2]}"/>` : ''}
      <text x="${cx}" y="${cy - 4}" text-anchor="middle" font-size="${r > 50 ? 24 : 19}" font-weight="800" fill="var(--ink)">${g[1]}%</text>
      <text x="${cx}" y="${cy + 16}" text-anchor="middle" font-size="12" font-weight="700" fill="var(--ink)">${g[0]}</text>
      <text x="${cx}" y="${cy + 31}" text-anchor="middle" font-size="11.5" fill="var(--muted)">${g[2]}</text>`;
      }).join('');
      el.innerHTML = `<svg viewBox="0 0 ${W} ${H + 14}" width="${W}" height="${H + 14}" role="img" aria-label="Network running">${out}</svg>`;
    }

    function chSelling(el, ctx) {
      if (!CAP().fuelFlow || !CAP().targets) {
        el.innerHTML = apiNeeded('Selling status needs sales + target data', 'recon API + (target API — to be built)',
          'Compares each site\'s sales against its monthly target. A per-site target endpoint is required.');
        return;
      }
      const a = ctx.a, list = ctx.list, size = 170, c = size / 2;
      const parts = [
        { v: a.st.ok, c: 'var(--green)', tip: `<b>Selling normally</b><br>${a.st.ok} sites` },
        { v: a.st.low, c: 'var(--amber)', tip: `<b>Below half of target</b><br>${a.st.low} sites` },
        { v: a.st.none, c: 'var(--red)', tip: `<b>Sold nothing</b><br>${a.st.none} sites` }
      ];
      const weak = list.filter(s => status(s) !== 'ok').map(s => ({ s, r: s.sale / (s.target || 1) })).sort((x, y) => x.r - y.r).slice(0, 4);
      el.innerHTML = `<div class="mixwrap"><svg width="${size}" height="${size}" viewBox="0 0 ${size} ${size}" role="img" aria-label="Selling status">
    ${ringSegs(c, c, c * .64, c - 2, parts)}
    <text x="${c}" y="${c + 2}" text-anchor="middle" font-size="26" font-weight="800" fill="var(--ink)">${pc(a.st.ok, a.sites)}%</text>
    <text x="${c}" y="${c + 19}" text-anchor="middle" font-size="11" fill="var(--muted)">selling well</text></svg>
    <div class="mixleg">${dot('var(--green)', `<b>${a.st.ok}</b> selling normally`)}${dot('var(--amber)', `<b>${a.st.low}</b> below half of target`)}${dot('var(--red)', `<b>${a.st.none}</b> sold nothing`)}</div></div>
    ${weak.length ? `<div class="rl" style="margin-top:12px">${weak.map(({ s, r }) => `<div class="rr" data-site="${s.id}">${ring(Math.min(r * 100, 100), r === 0 ? 'var(--red)' : 'var(--amber)', 40, r === 0 ? '0%' : Math.round(r * 100) + '%')}
      <div class="nm"><b>${s.name}</b><small>${s.id} · ${s.city}</small></div><div class="v">${r === 0 ? 'No sales' : fmtL(s.sale)}<small>${r === 0 ? 'check the site' : 'of target ' + fmtL(s.target)}</small></div></div>`).join('')}</div>` : '<p class="empty" style="margin-top:12px">Every site here is selling normally.</p>'}`;
    }

    /* Rank lists */
    function items(list) {
      if (list.length === 1) {
        const s = list[0];
        return s.prods.filter(p => p.sale || p.buy || p.upl || p.dmp).map(p => ({
          label: PN[p.k], sub: s.name,
          sale: p.sale, upl: p.upl, dmp: p.dmp,
          target: s.target * (p.sale / (s.sale || 1)), k: p.k
        }));
      }
      return list.map(s => ({ id: s.id, label: s.name, sub: `${s.id} · TM ${s.tm.name}`, sale: s.sale, upl: s.upl, dmp: s.dmp, target: s.target }));
    }
    function rankHtml(list) {
      if (!CAP().fuelFlow) {
        return apiNeeded('Ranking needs fuel data', 'get_dealers_recons_product_wise_new2.php',
          'Lists the sites with the biggest litres outside the agreement, or the biggest sellers.');
      }
      const it = items(list);
      if (S.rank === 'sales') {
        const top = it.sort((a, b) => b.sale - a.sale).slice(0, 5);
        return `<div class="rl">${top.map(i => {
          const r = i.target ? i.sale / i.target * 100 : 0;
          return `<div class="rr" ${i.id ? `data-site="${i.id}"` : ''}>${ring(Math.min(r, 100), i.k ? pv(i.k) : 'var(--green)', 44, Math.round(r) + '%')}
        <div class="nm"><b>${i.label}</b><small>${i.sub}</small></div>
        <div class="v">${fmtL(i.sale)}<small>of target ${fmtL(i.target)}</small></div></div>`;
        }).join('')}</div>`;
      }
      const lk = it.filter(i => i.upl + i.dmp > .001).sort((a, b) => (b.upl + b.dmp) - (a.upl + a.dmp)).slice(0, 5);
      if (!lk.length) return `<p class="empty">${list.length === 1 ? 'This site has' : 'No site here has'} no upliftment or dumping this month.</p>`;
      return `<div class="rl">${lk.map(i => {
        const p = i.sale ? (i.upl + i.dmp) / i.sale * 100 : 0;
        return `<div class="rr" ${i.id ? `data-site="${i.id}"` : ''}>${ring(Math.min(p * 2, 100), i.upl >= i.dmp ? 'var(--red)' : 'var(--violet)', 44, p > 99 ? '99+' : Math.round(p) + '%')}
      <div class="nm"><b>${i.label}</b><small>${i.sub}</small></div>
      <div class="v">${fmtL(i.upl + i.dmp)}<small><span style="color:var(--red)">${fmtL(i.upl)}</span> · <span style="color:var(--violet)">${fmtL(i.dmp)}</span></small></div></div>`;
      }).join('')}</div>`;
    }
    function tmLeakHtml(list) {
      if (!CAP().fuelFlow) return apiNeeded('TM leakage ranking', 'get_dealers_recons_product_wise_new2.php', 'Needs fuel-flow data per site.');
      const rows = tmsOf(list).map(t => {
        const x = agg(t.sites);
        return { t, upl: x.upl, dmp: x.dmp, sale: x.sale, tot: x.upl + x.dmp, pct: x.sale ? (x.upl + x.dmp) / x.sale * 100 : 0 };
      }).sort((a, b) => b.pct - a.pct).slice(0, 5);
      if (!rows.length) return '<p class="empty">No TMs in this scope.</p>';
      return `<div class="rl">${rows.map(r => `<div class="rr" data-tm="${r.t.name}">${ring(Math.min(r.pct * 2, 100), r.pct > 8 ? 'var(--red)' : r.pct > 3 ? 'var(--amber)' : 'var(--green)', 44, r.pct > 99 ? '99+' : Math.round(r.pct * 10) / 10 + '%')}
    <div class="nm"><b>${r.t.name}</b><small>${r.t.city || ''} · ${r.t.sites.length} sites</small></div>
    <div class="v">${fmtL(r.tot)}<small><span style="color:var(--red)">${fmtL(r.upl)}</span> · <span style="color:var(--violet)">${fmtL(r.dmp)}</span></small></div></div>`).join('')}</div>`;
    }
    function tmBoardHtml(list) {
      if (!CAP().tour && !CAP().inspections) return apiNeeded('TM leaderboard', 'get_tm_tour_data_testing.php',
        'Sites visited as a share of sites assigned, this month.');
      const tms = tmsOf(list).map(t => {
        const d = t.sites.filter(s => s.insp[5]).length;
        const n = t.sites.length;
        const p = t.tourPercentage != null ? t.tourPercentage : (n ? d / n * 100 : 0);
        return { t, p, n, d };
      });
      tms.sort((a, b) => a.p - b.p);
      const plan = ELAPSED * 100;
      const rows = tms.slice(0, 10);
      if (!rows.length) return '<p class="empty">No TM data yet.</p>';
      return `<div class="rl">${rows.map(r => {
        const col = r.p >= plan ? 'var(--green)' : r.p >= plan * 0.7 ? 'var(--amber)' : 'var(--red)';
        return `<div class="rr" data-tm="${r.t.name}">${ring(Math.min(r.p, 100), col, 44, Math.round(r.p) + '%')}
      <div class="nm"><b>${r.t.name}</b><small>${r.t.city || r.t.region} · ${r.d}/${r.n} sites</small></div>
      <div class="v">${r.p.toFixed(0)}%<small style="color:${col}">${r.p >= plan ? 'on pace' : 'plan is ' + plan.toFixed(0) + '%'}</small></div></div>`;
      }).join('')}</div>`;
    }

    /* =====================================================================
       REPORT LAYOUT
       ===================================================================== */
    function panel(cls, title, why, id, extra = '') {
      return `<section class="panel ${cls}"><h3>${title}</h3><p class="why">${why}</p>${extra}<div class="cb" id="${id}"></div></section>`;
    }
    let CTX = null;
    function renderReport() {
      const list = scope(), a = agg(list), sr = series(list), h = health(list);
      CTX = { list, a, sr, h };
      $('#rtitle').textContent = 'Report: ' + scopeName();
      const IN = a.buy + a.upl, OUT = a.sale + a.dmp;
      const single = list.length === 1;
      const realSites = list.filter(s => s.hasFuel).length;
      const liveNote = (CAP().fuelFlow && realSites) ? ` Live fuel data for ${realSites} of ${list.length} sites.` : '';
      $('#report').innerHTML =
        `<div class="grp">Stock flow and the agreement</div>` +
        panel('s4', 'Where product came from and where it went',
          `Sites may buy only from us and sell only to customers.${CAP().fuelFlow ? ` Red and purple ribbons are the leaks: ${(IN ? a.upl / IN * 100 : 0).toFixed(1)}% of stock came from other companies and ${(OUT ? a.dmp / OUT * 100 : 0).toFixed(1)}% went to other pump owners.` : ''}${liveNote}`, 'c-sankey') +
        panel('s2', 'Overall health', 'Five checks on one shape. The further out, the better.', 'c-radar') +
        panel('s4', 'Day by day this month', 'Move over the chart to read any day. Columns are deliveries from us, the line is sales.', 'c-daily') +
        panel('s2', 'Product mix', 'How the three fuels split on the way in and on the way out.', 'c-mix') +
        panel('s3', 'Selling against leaking, site by site', 'Sites in the top left sell little and still leak. These are the ones to question first.', 'c-bubble') +
        `<section class="panel s3"><h3>${single ? 'This site, by product' : 'Sites to look at'}</h3><p class="why">${S.rank === 'leak' ? 'Biggest litres outside the agreement.' : 'Biggest sales to customers.'}</p>
      <div class="tabs" role="group" aria-label="Ranking"><button data-rank="leak" aria-pressed="${S.rank === 'leak'}">Leakage</button><button data-rank="sales" aria-pressed="${S.rank === 'sales'}">Sales</button></div>
      <div>${rankHtml(list)}</div></section>` +
        panel('s3', 'Six months of sales and leakage', 'Columns are average litres sold per day. The red line is the share that left the agreement.', 'c-monthly') +
        `<section class="panel s3"><h3>Which TM territory is leaking most</h3><p class="why">Upliftment plus dumping as a share of sales, across all sites under each TM. Tap one to open it.</p>${tmLeakHtml(list)}</section>` +
        `<div class="grp">Territory manager visits</div>` +
        panel('s2', 'Visit pace', `${a.insp[5]} of ${a.sites} sites visited. ${DAYS_LEFT} days remain.`, 'c-pace') +
        panel('s4', 'Which TM visited on which day', 'The rows are TMs, the columns are days of October.', 'c-heat') +
        `<section class="panel s3"><h3>TM visit leaderboard</h3><p class="why">Sites visited as a share of sites assigned, this month. Green means on pace, red means behind. Tap to open a TM.</p>${tmBoardHtml(list)}</section>` +
        `<div class="grp">Network and sales</div>` +
        panel('s3', 'Is the network running?', 'Tanks, nozzles and sites that are working right now.', 'c-gauge') +
        panel('s3', 'Is every site selling?', 'Compared with what each site normally sells by this date.', 'c-sell');
      fillCharts();
    }
    function fillCharts() {
      if (!CTX) return;
      const put = (id, fn) => {
        const el = document.getElementById(id);
        if (el) { try { fn(el, CTX); } catch (err) { console.error('[chart]', id, err); el.innerHTML = '<p class="empty">Chart error — see console.</p>'; } }
      };
      put('c-sankey', chSankey); put('c-radar', chRadar); put('c-daily', chDaily); put('c-mix', chMix);
      put('c-bubble', chBubble); put('c-monthly', chMonthly); put('c-pace', chPace); put('c-heat', chHeat);
      put('c-gauge', chGauges); put('c-sell', chSelling);
    }

    function renderAll() {
      try { renderStage(); } catch (e) { console.error('[renderStage]', e); }
      try { renderCrumb(); } catch (e) { console.error('[renderCrumb]', e); }
      try { renderCards(); } catch (e) { console.error('[renderCards]', e); }
      try { renderReport(); } catch (e) { console.error('[renderReport]', e); }
    }
    function refreshSel() {
      document.querySelectorAll('[data-key]').forEach(r => r.classList.toggle('sel', r.dataset.key === S.sel));
      renderCrumb(); renderCards(); renderReport();
    }
    function select(key) { S.sel = key; refreshSel(); }
    function drill(key) {
      const l = lvl();
      if (l === 0) { S.region = key; S.sel = null; renderAll(); }
      else if (l === 1) { S.group = key; S.sel = null; renderAll(); }
      else select(key);
    }
    function goTo(n) {
      if (n <= 0) { S.region = null; S.group = null; }
      else if (n === 1) { S.group = null; }
      S.sel = null; renderAll();
    }
    function navSite(id) {
      const s = SITES.find(x => x.id === id); if (!s) return;
      S.region = s.region; S.group = S.view === 'tm' ? s.tm.name : s.city; S.sel = s.id; renderAll();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    function navTm(name) {
      const t = TMS.find(x => x.name === name); if (!t) return;
      S.view = 'tm'; S.region = t.region; S.group = t.name; S.sel = null; renderAll();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    /* =====================================================================
       EVENT HANDLERS
       ===================================================================== */
    let last = { key: null, t: 0 };
    $('#stage').addEventListener('click', e => {
      const row = e.target.closest('[data-key]'); if (!row) return;
      const key = row.dataset.key;
      if (e.target.closest('[data-open]')) { last = { key: null, t: 0 }; drill(key); return; }
      const now = performance.now();
      if (last.key === key && now - last.t < 380) { last = { key: null, t: 0 }; drill(key); }
      else { last = { key, t: now }; select(key); }
    });
    $('#stage').addEventListener('keydown', e => {
      if (e.target.dataset && e.target.dataset.key && (e.key === 'Enter' || e.key === ' ')) {
        e.preventDefault(); select(e.target.dataset.key);
      }
    });
    $('#cards').addEventListener('click', e => {
      const c = e.target.closest('.card'); if (!c) return;
      if (c.classList.contains('missing')) return;   // not clickable
      S.metric = c.dataset.m;
      renderStage(); renderCards();
    });
    $('#crumb').addEventListener('click', e => {
      const b = e.target.closest('[data-go]'); if (!b) return;
      goTo(+b.dataset.go);
    });
    $('#scope').addEventListener('click', e => {
      if (e.target.id === 'clr') { S.sel = null; refreshSel(); }
    });
    $('#report').addEventListener('click', e => {
      const rk = e.target.closest('[data-rank]');
      if (rk) { S.rank = rk.dataset.rank; renderReport(); return; }
      const st = e.target.closest('[data-site]');
      if (st) { navSite(st.dataset.site); return; }
      const tm = e.target.closest('[data-tm]');
      if (tm) { navTm(tm.dataset.tm); }
    });
    document.querySelectorAll('[data-view]').forEach(b => b.addEventListener('click', () => {
      if (b.dataset.view === S.view) return;
      S.view = b.dataset.view; S.group = null; S.sel = null; renderAll();
    }));
    document.querySelectorAll('[data-chart]').forEach(b => b.addEventListener('click', () => {
      if (b.dataset.chart === S.chart) return;
      S.chart = b.dataset.chart; renderCrumb(); renderStage();
    }));
    $('#theme').addEventListener('click', () => {
      const root = document.documentElement;
      const cur = root.getAttribute('data-theme') || (matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
      root.setAttribute('data-theme', cur === 'dark' ? 'light' : 'dark');
    });

    /* =====================================================================
       SEARCH
       ===================================================================== */
    let INDEX = [];
    function rebuildIndex() {
      INDEX = [
        ...GEO.map(g => ({ type: 'Region', label: g.r, sub: 'RM ' + g.rm, go: () => { S.region = g.r; S.group = null; S.sel = null; } })),
        ...GEO.flatMap(g => g.c.map(([c]) => ({ type: 'City', label: c, sub: g.r, go: () => { S.view = 'geo'; S.region = g.r; S.group = c; S.sel = null; } }))),
        ...TMS.map(t => ({ type: 'TM', label: t.name, sub: (t.city || t.region || '') + ' · ' + t.sites.length + ' sites', go: () => { S.view = 'tm'; S.region = t.region; S.group = t.name; S.sel = null; } })),
        ...SITES.map(s => ({ type: 'Site', label: s.name + ' (' + s.id + ')', sub: s.city, key: s.id + ' ' + s.name + ' ' + s.city, go: () => { S.region = s.region; S.group = S.view === 'tm' ? s.tm.name : s.city; S.sel = s.id; } }))
      ];
    }
    const q = $('#q'), res = $('#res');
    function showRes() {
      const t = q.value.trim().toLowerCase();
      if (!t) { res.hidden = true; return; }
      const hits = INDEX.filter(x => (x.key || x.label).toLowerCase().includes(t)).slice(0, 8);
      res.innerHTML = hits.length
        ? hits.map(h => `<li><button data-i="${INDEX.indexOf(h)}"><span>${h.label}</span><small>${h.type} · ${h.sub}</small></button></li>`).join('')
        : '<li class="none">Nothing matches. Try a site code, TM name or city.</li>';
      res.hidden = false;
    }
    q.addEventListener('input', showRes);
    res.addEventListener('click', e => {
      const b = e.target.closest('[data-i]'); if (!b) return;
      INDEX[+b.dataset.i].go();
      q.value = ''; res.hidden = true; renderAll();
    });
    document.addEventListener('click', e => { if (!e.target.closest('.search')) res.hidden = true; });
    q.addEventListener('keydown', e => { if (e.key === 'Escape') res.hidden = true; });

    let rt = null, lastW = innerWidth;
    addEventListener('resize', () => {
      clearTimeout(rt);
      rt = setTimeout(() => { if (innerWidth !== lastW) { lastW = innerWidth; if (S.chart === 'tree') renderStage(); fillCharts(); } }, 150);
    });

    /* =====================================================================
       BOOT
       ===================================================================== */
    (async function boot() {
      // Show a loading state while hydrate is running
      $('#stage').innerHTML = '<p class="empty" style="color:var(--muted)">Loading…</p>';
      $('#cards').innerHTML = '';

      try {
        if (window.READY) await window.READY;
      } catch (e) {
        console.warn('[boot] hydrate failed', e);
      }

      const R = window.REAL_DATA;

      // Build from real data (no dummy fallback)
      if (R && R.meta.dealers) {
        const built = buildFromReal(R.dealers, R.filters);
        if (R.meta.recon) applyRecon(built.sites, R.recon);
        if (R.meta.tour) applyTour(built.tms, R.tour);
        if (R.meta.visitsRaw) applyInspections(built.sites, R.visitsRaw);
        SHORTAGE_MAP = buildShortageMap();

        GEO.length = 0; for (const g of built.geo) GEO.push(g);
        SITES.length = 0; for (const s of built.sites) SITES.push(s);
        TMS.length = 0; for (const t of built.tms) TMS.push(t);

        NETWORK_HEALTH = health(SITES);
        rebuildIndex();
        console.log(`[boot] built ${SITES.length} sites (${SITES.filter(s => s.hasFuel).length} with fuel), ${TMS.length} TMs, ${GEO.length} regions`);
      } else {
        console.warn('[boot] no dealers loaded — dashboard will show API-needed placeholders');
        SHORTAGE_MAP = new Map();
      }

      if (window.updateSourceBadge) window.updateSourceBadge();

      requestAnimationFrame(() => requestAnimationFrame(() => {
        try { renderAll(); console.log('[boot] renderAll OK'); }
        catch (err) { console.error('[boot] renderAll FAILED:', err); }
      }));
    })();
  </script>
</body>

</html>