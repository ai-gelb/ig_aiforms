import { fetchOpenAICompletion } from "@igelb/ig-aiforms/FetchAi.js";
import Icons from "@typo3/backend/icons.js";

function AiFormsImage() {
  const clickButtons = document.querySelectorAll(".igjs-form-ai");
  const iconOn = "actions-infinity";
  const iconOff = "spinner-circle";

  clickButtons.forEach(button => {
    button.addEventListener("click", event => {
      button.disabled = true;

      // Replace button icon with loading icon
      Icons.getIcon(iconOff, Icons.sizes.small).then(icon => {
        const iconPlaceholder = button.querySelector(".t3js-icon");
        const iconFragment = document.createRange().createContextualFragment(icon);
        button.replaceChild(iconFragment, iconPlaceholder);
      });

      // Destructure data attributes from the button
      const { fileUrl, whatDoYouWant, aiToPaste, filePublic, language } = button.dataset;

      // Determine the URL to send based on public accessibility
      let fileUrlToSend = filePublic === "0" ? `data:image/jpeg;base64,${fileUrl}` : fileUrl;

      // Select the element to paste response into
      const elementToPaste = document.querySelector(`[data-formengine-input-name='${aiToPaste}']`);

      // Prepare data for OpenAI API
      const data = {
        model: "gpt-4-turbo",
        messages: [{
          role: "user",
          content: [{
            type: "text",
            text: `${whatDoYouWant}. Always respond in: ${language}`,
          }, {
            type: "image_url",
            image_url: { url: fileUrlToSend },
          }],
        }],
        max_tokens: 1500,
      };

      // Fetch completion from OpenAI
      fetchOpenAICompletion(data)
        .then(data => {
          elementToPaste.value = data.choices[0].message.content;
          elementToPaste.dispatchEvent(new Event("change", { bubbles: true }));
          button.disabled = false;

          // Replace loading icon with original icon
          Icons.getIcon(iconOn, Icons.sizes.small).then(icon => {
            const iconPlaceholder = button.querySelector(".t3js-icon");
            const iconFragment = document.createRange().createContextualFragment(icon);
            button.replaceChild(iconFragment, iconPlaceholder);
          });
        })
        .catch(error => {
          console.error("Error:", error);
        });
    });
  });
}

// Initialize the script when document is ready
if (document.readyState !== "loading") {
  AiFormsImage();
} else {
  document.addEventListener("DOMContentLoaded", AiFormsImage);
}
