const nav = document.querySelector('nav');
const span = document.querySelector('span');

window.addEventListener("resize", () => {
    if (window.innerWidth < 984) {
        span.innerText = "expand_more"
    } else {
        span.innerText = "navigate_next"
    }
});

window.addEventListener("load", () => {
    if (window.innerWidth < 984) {
        span.innerText = "expand_more"
    } else {
        span.innerText = "navigate_next"
    }
});

span.addEventListener('click', () => {
    if (nav.classList.contains('menu')) {
        nav.classList.remove('menu');
        if (window.innerWidth < 984) {
            span.innerText = "expand_more"
        } else {
            span.innerText = "navigate_next"
        }
    } else {
        nav.classList.add('menu');
        if (window.innerWidth < 984) {
            span.innerText = "expand_less"
        } else {
            span.innerText = "navigate_before"
        }
    }
});