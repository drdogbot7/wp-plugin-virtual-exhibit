import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";
import focus from "@alpinejs/focus";

import { tns } from "tiny-slider";
import "tiny-slider/dist/tiny-slider.css";

import tippy from "tippy.js";
import "tippy.js/dist/tippy.css";

import "./main.css";

/** Load Events */
jQuery(function () {
  window.tns = tns;
  Alpine.plugin(collapse);
  Alpine.plugin(focus);
  Alpine.start();
  window.Alpine = Alpine;
  tippy("[data-tippy-content]", { appendTo: "parent" });
});
