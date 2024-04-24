import { fetchOpenAICompletion } from "@igelb/ig-aiforms/FetchAi.js";

function AiFormsText() {
  const clickButtons = document.querySelectorAll(".igjs-form-text-ai");

  clickButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      button.disabled = true;
      const { aiToRead, whatDoYouWant, aiToPaste } = button.dataset;
      const arrayAiToRead = aiToRead.split(",");
      let aiContent = "";

      arrayAiToRead.forEach((element) => {
        aiContent += ` ${document.querySelector(`[name='${element}']`).value}`;
      });

      const elementToPaste = document.querySelector(`[data-formengine-input-name='${aiToPaste}']`);
      const data = {
        model: "gpt-4-turbo",
        messages: [
          { role: "system", content: whatDoYouWant },
          { role: "user", content: aiContent },
        ],
        temperature: 0.5,
        top_p: 1,
      };

      fetchOpenAICompletion(data)
      .then((data) => {
        elementToPaste.value = data.choices[0].message.content;
        elementToPaste.dispatchEvent(new Event("change", { bubbles: true }));
        button.disabled = false;
      })
      .catch((error) => {
        console.error("Error:", error);
      });
    });
  });
}

AiFormsText();
