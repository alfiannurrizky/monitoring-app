// file: resources/js/app.js

import "./bootstrap";
import Alpine from "alpinejs";

window.Alpine = Alpine;

// DEFINISI FUNGSI THEME SWITCHER
window.themeSwitcher = function () {
    return {
        theme:
            localStorage.getItem("theme") ||
            (window.matchMedia("(prefers-color-scheme: dark)").matches
                ? "dark"
                : "light"),

        init() {
            // Terapkan tema saat inisialisasi
            this.applyTheme();

            // Perhatikan perubahan preferensi sistem
            window
                .matchMedia("(prefers-color-scheme: dark)")
                .addEventListener("change", (e) => {
                    if (!localStorage.getItem("theme")) {
                        this.theme = e.matches ? "dark" : "light";
                        this.applyTheme();
                    }
                });
        },

        applyTheme() {
            if (this.theme === "dark") {
                document.documentElement.classList.add("dark");
            } else {
                document.documentElement.classList.remove("dark");
            }
        },

        toggleTheme() {
            this.theme = this.theme === "light" ? "dark" : "light";
            localStorage.setItem("theme", this.theme);
            this.applyTheme();
        },
    };
};

Alpine.start();
