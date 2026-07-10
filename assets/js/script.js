console.log("YouTube Clone JS Loaded 🚀");

/* =========================
   1. TOP LOADING BAR
========================= */

let bar = document.getElementById("progress-bar");

function startLoading() {
    if (!bar) return;

    let progress = 0;
    bar.style.width = "0%";

    let interval = setInterval(() => {
        if (progress >= 90) {
            clearInterval(interval);
        } else {
            progress += 10;
            bar.style.width = progress + "%";
        }
    }, 70);
}

function endLoading() {
    if (!bar) return;

    bar.style.width = "100%";

    setTimeout(() => {
        bar.style.width = "0%";
    }, 300);
}

/* =========================
   2. PAGE LOAD EVENTS
========================= */

window.addEventListener("load", function () {
    startLoading();
    endLoading();
});

/* =========================
   3. LINK CLICK LOADING (YouTube feel)
========================= */

document.addEventListener("DOMContentLoaded", function () {
    let links = document.querySelectorAll("a");

    links.forEach(link => {
        link.addEventListener("click", function () {
            if (this.href && !this.href.includes("#")) {
                startLoading();
            }
        });
    });
});

/* =========================
   4. SIMPLE FORM VALIDATION
========================= */

function validateForm() {
    let inputs = document.querySelectorAll("input, textarea, select");

    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].hasAttribute("required") && inputs[i].value.trim() === "") {
            alert("Please fill all required fields");
            return false;
        }
    }

    return true;
}