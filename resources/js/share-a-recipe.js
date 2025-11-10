document.addEventListener("DOMContentLoaded", () => {
  const imageInput = document.getElementById("imageInput");
  const imagePreview = document.getElementById("imagePreview");
  const addIngredientBtn = document.getElementById("addIngredientBtn");
  const addStepBtn = document.getElementById("addStepBtn");
  const ingredientsList = document.getElementById("ingredientsList");
  const stepsList = document.getElementById("stepsList");
  const ingredientInput = document.getElementById("ingredientInput");
  const stepInput = document.getElementById("stepInput");
  const form = document.getElementById("recipeForm");

  // Image preview
  imageInput.addEventListener("change", (e) => {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (ev) => {
        imagePreview.innerHTML = `<img src="${ev.target.result}" alt="Recipe Image"/>`;
      };
      reader.readAsDataURL(file);
    }
  });

  // Add ingredient
  addIngredientBtn.addEventListener("click", () => {
    const value = ingredientInput.value.trim();
    if (value) {
      const li = document.createElement("li");
      li.innerHTML = `${value} <button type="button">×</button>`;
      li.querySelector("button").addEventListener("click", () => li.remove());
      ingredientsList.appendChild(li);
      ingredientInput.value = "";
    }
  });

  // Add step
  addStepBtn.addEventListener("click", () => {
    const value = stepInput.value.trim();
    if (value) {
      const li = document.createElement("li");
      li.innerHTML = `${value} <button type="button">×</button>`;
      li.querySelector("button").addEventListener("click", () => li.remove());
      stepsList.appendChild(li);
      stepInput.value = "";
    }
  });

  // Submit form - log data
  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const data = {
      recipeName: document.getElementById("recipeName").value.trim(),
      category: document.getElementById("category").value.trim(),
      prepTime: document.getElementById("prepTime").value,
      cookTime: document.getElementById("cookTime").value,
      servings: document.getElementById("servings").value,
      ingredients: Array.from(ingredientsList.querySelectorAll("li")).map(li => li.textContent.trim()),
      steps: Array.from(stepsList.querySelectorAll("li")).map(li => li.textContent.trim())
    };

    console.log("Recipe data:", data);
    alert("Recipe logged to console!");
  });
});
