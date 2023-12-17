const saveFormBtn = document.querySelector("#saveForm");
const useSavedFormDataBtn = document.querySelector("#useSavedFormData");

saveFormBtn.addEventListener("click", () => {
  const form = document.querySelector("#form");
  const formData = new FormData(form);
  const data = Object.fromEntries(formData);

  localStorage.setItem("formData", JSON.stringify(data));
});

useSavedFormDataBtn.addEventListener("click", () => {
  const data = JSON.parse(localStorage.getItem("formData"));
  if (!data || data?.length == 0) return;

  Object.entries(data).forEach((input) => {
    const [key, value] = input;
    const inputElement = document.querySelector(`[name="${key}"]`);
    if (
      inputElement.getAttribute("type") === "checkbox" ||
      inputElement.getAttribute("type") === "radio"
    ) {
      inputElement.checked = value;
      return;
    }
    inputElement.value = value;
  });
});

const animateText = document.querySelector(".animate-text");
const randomNumber = (max = 255) => Math.floor(Math.random() * max);
const colors = new Array(10)
  .fill(0)
  .map((_) => `rgb(${randomNumber()}, ${randomNumber()}, ${randomNumber()})`);

setInterval(() => {
  animateText.style.color = colors[randomNumber(10)];
}, 2000);

const footer = document.querySelector(".footer");

const img = document.createElement("img");
img.src = "https://picsum.photos/300/500";
img.alt = "random image";
img.style = "position:absolute;top:30px;right:30px;";
footer.append(img);

$("#scroll_down").click(function () {
  const currentSection = $(".footer");

  $("html").animate(
    {
      scrollTop: currentSection.offset().top,
    },
    1000
  );
});

document.querySelector('.nojs').style.display = 'none';
document.querySelector('.form__button__container').style.display = 'flex';