const items = Array.from(document.querySelectorAll(".item"));

const count = items.length;
const centerIndex = Math.floor(count / 2);

// géométrie
const radius = 180;
const step = Math.PI / 6;

function render() {
  items.forEach((item, i) => {
    const offset = i - centerIndex;
    const angle = offset * step;

    const x = radius * Math.sin(angle);
    const y = -radius * Math.cos(angle);

    item.style.transform = `translate(${x}px, ${y}px) translate(-50%, -50%)`;

    item.classList.toggle("active", i === centerIndex);
  });
}

function rotateToItem(clicked) {
  const index = items.indexOf(clicked);
  let shift = index - centerIndex;

  if (shift === 0) return;

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
    }
  }

  stepRotate();
}

items.forEach((item) => {
  item.addEventListener("click", () => rotateToItem(item));
});

render();
