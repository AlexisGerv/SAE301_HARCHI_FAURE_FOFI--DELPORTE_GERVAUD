const items = Array.from(document.querySelectorAll(".item"));
const container = document.querySelector(".wheel-container");
const burger = document.querySelector(".burger");

const count = items.length;
const centerIndex = Math.floor(count / 2);

const step = Math.PI / 7;

let currentPage = null;
let isRotating = false;
let menuOpen = false;

function getRadius() {
  const vmin = Math.min(window.innerWidth, window.innerHeight);
  return vmin * 0.4;
}

function render() {
  const radius = getRadius();
  items.forEach((item, i) => {
    const offset = i - centerIndex;
    const angle = offset * step;

    const x = radius * Math.sin(angle);
    const y = -radius * Math.cos(angle);

    item.style.transform = `translate(${x}px, ${y}px) translate(-50%, -50%)`;
    item.classList.toggle("active", i === centerIndex);
  });
}

function loadPage(url) {
  if (!url || url === currentPage) return;
  currentPage = url;

  const content = document.getElementById("content");
  if (!content) return;

  content.style.opacity = 0;

  setTimeout(() => {
    fetch(url)
      .then((r) => r.text())
      .then((html) => {
        content.innerHTML = html;
        content.style.opacity = 1;
      });
  }, 200);
}

function rotateToItem(clicked) {
  if (isRotating || !menuOpen) return;

  const index = items.indexOf(clicked);
  let shift = index - centerIndex;

  if (shift === 0) {
    loadPage(clicked.dataset.page);
    return;
  }

  isRotating = true;

  const direction = shift > 0 ? 1 : -1;
  const steps = Math.abs(shift);
  const totalDuration = 500;
  const stepDuration = totalDuration / steps;

  let currentStep = 0;

  function stepRotate() {
    if (direction > 0) {
      items.push(items.shift());
    } else {
      items.unshift(items.pop());
    }

    render();
    currentStep++;

    if (currentStep < steps) {
      setTimeout(stepRotate, stepDuration);
    } else {
      isRotating = false;
      loadPage(clicked.dataset.page);
    }
  }

  stepRotate();
}

function openMenu() {
  container.classList.remove("menu-closed");
  burger.classList.add("open");
  burger.setAttribute("aria-expanded", "true");
  menuOpen = true;
  render();
}

function closeMenu() {
  burger.classList.remove("open");
  burger.setAttribute("aria-expanded", "false");
  menuOpen = false;

  items.forEach((item) => {
    item.style.transform = "";
  });

  container.classList.add("menu-closed");
}

burger.addEventListener("click", () => {
  menuOpen ? closeMenu() : openMenu();
});

items.forEach((item) => {
  item.addEventListener("click", () => rotateToItem(item));
});

window.addEventListener("resize", () => {
  if (menuOpen) render();
});
